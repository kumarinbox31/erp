<?php
class AttendanceModel{

    public $db;
    public $table = 'user_attendance';

    function __construct($db){
        $this->db = $db;
    }

    public function findByDateUserid($date,$user_id){
        if($date == null and $user_id == null){
            return $this->getAll();
        }
        elseif($date==null){
            return $this->findByUserId($user_id);
        }
        elseif($user_id == null){
            return $this->findByDate($date);
        }else{
            return $this->getByDateUser($date,$user_id);
        }
    }
    public function findByDate($date){
        return $this->db->query("SELECT ua.*, user.gender, user.login FROM user_attendance AS ua LEFT JOIN llx_user AS user ON user.rowid = ua.userid WHERE date = '$date'");
    }
    public function getAll(){
        return $this->db->query("SELECT ua.*, user.gender, user.login FROM user_attendance AS ua LEFT JOIN llx_user AS user ON user.rowid = ua.userid");
    }
    public function findByUserId($user_id){
        return $this->db->query("SELECT ua.*, user.gender, user.login FROM user_attendance AS ua LEFT JOIN llx_user AS user ON user.rowid = ua.userid WHERE ua.userid = '$user_id'");
    }
    public function getByDateUser($date,$userid){
        return $this->db->query("SELECT ua.*, user.gender, user.login FROM user_attendance AS ua LEFT JOIN llx_user AS user ON user.rowid = ua.userid WHERE ua.userid = '$userid' and date = '$date'");
    }

    function create($userid, $date, $time)
    {
        try{
            $chk = $this->isCheckedIn($userid, $date);
            if ($chk) {
                return 2; // Indicates user is already checked in
            } else {
                $sql = "INSERT INTO `$this->table` (`userid`, `date`, `checkin`, `checkout`) VALUES ('$userid', '$date', '$time', null)";
                $ins = $this->db->query($sql);
                if ($ins) {
                    return 1; // Indicates successful insertion
                } else {
                    return 0; // Returns error message in an array
                }
            }
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    

    function update($userid,$date,$checkout)
    {
        $chk = $this->isCheckedIn($userid,$date);
        if($chk == 1){
            $this->db->query("UPDATE $this->table  SET checkout = '$checkout' where userid = '$userid' and date = '$date'");
            return 1;
        }else{
            return 0;
        }
    }
    function isCheckedIn($userid,$date){
        $get = $this->db->query("SELECT * FROM user_attendance WHERE userid = '$userid' and date = '$date'");
        $count = $get->num_rows;
        if($count){
            $row = $get->fetch_object();
            if($row->checkout != ''){
                return 2;
            }else{
                return 1;
            }
        }else{
            return 0;
        }
    }
}