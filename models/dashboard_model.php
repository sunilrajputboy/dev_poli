<?php
class dashboard_model extends Model
{
	public function getUserDetailsById($userId){
        $sth = $this->db->prepare('SELECT * FROM `users` where id=:userId');
        $sth->bindparam(":userId", $userId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function selectClienById($clientId){
        $sth = $this->db->prepare('SELECT * FROM `clients` where id=:clientId');
        $sth->bindparam(":clientId", $clientId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function selectAllData($table,$condition){
        $sth = $this->db->prepare('SELECT * FROM '.$table.' where '.$condition);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function selectVisitorCounter(){
        $sth = $this->db->prepare('SELECT COUNT(`last_login`) as visitor FROM `users`');
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function totalUserCount(){
        $sth = $this->db->prepare('SELECT COUNT(`id`) as userCount FROM users');
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function totalClientCount(){
        $sth = $this->db->prepare('SELECT COUNT(`id`) as clientCount FROM clients');
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function totalProjectCount(){
        $sth = $this->db->prepare('SELECT COUNT(`id_project`) as projectCount FROM projects');
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}