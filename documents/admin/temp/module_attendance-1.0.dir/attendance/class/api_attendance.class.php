<?php
/* Copyright (C) 2016   Jean-François Ferry     <hello@librethic.io>
 * Copyright (C) 2024       Frédéric France             <frederic.france@free.fr>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

 use Luracast\Restler\RestException;

require_once DOL_DOCUMENT_ROOT.'/custom/attendance/class/attendance.class.php';


/**
 * API class for attendance object
 *
 * @access protected
 * @class  DolibarrApiAccess {@requires user,external}
 */
class Attendance extends DolibarrApi
{
    public $db,$user; 

	/**
	 * @var array   $FIELDS     Mandatory fields, checked when create and update object
	 */
	public static $FIELDS = array(
		'subject',
		'message'
	);

	/**
	 * @var array   $FIELDS_MESSAGES     Mandatory fields, checked when create and update object
	 */
	public static $FIELDS_MESSAGES = array(
		'track_id',
		'message'
	);

	/**
	 * @var Attendance $attendance {@type Attendance}
	*/
	public $attendance;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		global $db;
		global $user;
		$this->user = $user;
		$this->db = $db;
		$this->attendance = new AttendanceModel($db);
	}

	/**
	 * Get Report by date.
	 *
	 * Return an array with attendance information
	 *
	 * @param	date	$date	    Date (Eg. 2024-05-28)
     * @param	int		$user_id	User Id 
	 * @return  Object						Object with cleaned properties
	 *
	 * @throws RestException 401
	 * @throws RestException 403
	 * @throws RestException 404
	 */


	public function get($date=null,$user_id=null)
	{
		if (! $this->user->hasRight('attendance', 'read','')) {
			// $this->db->lasterror()
			throw new RestException(403, 'Access denied');
		}
        $data = $this->attendance->findByDateUserid($date,$user_id);
        return $this->showMessage('success','Fetched successfully',$data);
	}

    /**
	 * Checkin.
	 *
	 * Return an array with attendance information
	 *
	 * @param	int	$user_id	    User Id 
	 * @return  Object				Object with cleaned properties
	 *
	 * @throws RestException 401
	 * @throws RestException 403
	 * @throws RestException 404
	 */


	public function post($userid=null)
	{
        $date = date('Y-m-d');
        $time = date('h:i A');
        $ins = $this->attendance->create($userid,$date, $time);
        if($ins == 1){
            $data  = $this->attendance->findByDateUserid($date,$userid);
            return $this->showMessage('success','Checked in Successfully.',$data);
        }elseif($ins == 2){
            $data  = $this->attendance->findByDateUserid($date,$userid);
            return $this->showMessage('error','Already Checked in',$data);
        }else{
			// $this->db->lasterror()
			throw new RestException(500, 'Something went wrong.|'.$this->db->lasterror());
            // return $this->showMessage('error','Something went wrong',[]);
        }
	}

    /**
	 * Checkout.
	 *
	 * Return an array with attendance information
	 *
	 * @param	int	$user_id	    User Id 
	 * @return  Object				Object with cleaned properties
	 *
	 * @throws RestException 401
	 * @throws RestException 403
	 * @throws RestException 404
	 */


	public function put($user_id=null)
	{
        $date = date('Y-m-d');
        $time = date('h:i A');
        $ins = $this->attendance->update($user_id,$date, $time);
        if($ins){
            $data  = $this->attendance->findByDateUserid($date,$user_id);
            return $this->showMessage('success','Checkout in Successfully.',$data);
        }else{
			throw new RestException(500, 'Something went wrong.|'.$this->db->lasterror());
            // return $this->showMessage('error','Something went wrong or Already Checked out',[]);
        }
	}

    /**
	 * Check in or not.
	 *
	 * Return an array with attendance information
	 *
     * @param	date	$date	    Date (Eg. 2024-05-28) 
	 * @param	int	$user_id	    User Id 
	 * @return  Object				Object with cleaned properties
	 *
	 * @throws RestException 401
	 * @throws RestException 403
	 * @throws RestException 404
	 */

    public function check($date,$user_id){
        $get = $this->attendance->isCheckedIn($user_id,$date);
        if($get == 1){
            return $this->showMessage('success','Checked in',[]);
        }elseif($get == 2){
            return $this->showMessage('error','Already checked out',[]);
        }else{
            return $this->showMessage('error','Not Exists',[]);
        }
    }


    private function showMessage($status,$msg,$data){
        return [
            'status' => $status,
            'msg' => $msg,
            'data' => $data,
        ];
    }
	
}
