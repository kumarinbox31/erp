<?php

class AttendanceModel
{
    public $table = 'user_attendance';
    function __construct($db)
    {
        $this->db = $db;
    }
    function find_by_id($id){
        return $this->db->query("SELECT ua.*,user.gender,user.login FROM user_attendance as ua LEFT JOIN llx_user as user ON user.rowid = ua.userid where ua.id = '$id'")->fetch_object();
    }
    function find_by_user_date($userid, $date){
        return $this->db->query("SELECT ua.*,user.gender,user.login FROM user_attendance as ua LEFT JOIN llx_user as user ON user.rowid = ua.userid where date = '$date' and userid = '$userid'")->fetch_object();
    }
    function find_by_date($date){
        $results = [];
        $query_result = $this->db->query("SELECT ua.*, user.gender, user.login FROM user_attendance AS ua LEFT JOIN llx_user AS user ON user.rowid = ua.userid WHERE date = '$date'");
        
        while ($row = $query_result->fetch_object()) {
            $results[] = $row;
        }

        return $results;
    }

    function find_by_user($user) {
        $results = [];
        $query_result = $this->db->query("SELECT ua.*, user.gender, user.login FROM user_attendance AS ua LEFT JOIN llx_user AS user ON user.rowid = ua.userid WHERE userid = '$user'");
        
        while ($row = $query_result->fetch_object()) {
            $results[] = $row;
        }
    
        return $results;
    }
    
    function fetch()
    {
        return $this->db->query("SELECT ua.*,user.gender,user.login FROM user_attendance as ua LEFT JOIN llx_user as user ON user.rowid = ua.userid")->fetch_all();
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

    function create($userid, $date, $time)
    {
        $chk = $this->isCheckedIn($userid,$date);
        if($chk){
            return 0;
        }else{
            $this->db->query("INSERT INTO `$this->table` (`userid`,`date`,`checkin`,`checkout`) 
			VALUES ('$userid','$date','$time',null)");
            return 1;
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

    function delete($id)
    {
        // SQL query to delete a record
    }
}
