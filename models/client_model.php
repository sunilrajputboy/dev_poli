<?php
class client_model extends Model{

	public function getClientById($clientId){
        $sth = $this->db->prepare('SELECT * FROM `clients` WHERE `id` =:clientId');
        $sth->bindparam(":clientId", $clientId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getUserById($userId){
        $sth = $this->db->prepare('SELECT * FROM `users` WHERE `id` =:userId');
        $sth->bindparam(":userId", $userId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	
	public function getClientByUniqueUrl($UniqueUrl){
        $sth = $this->db->prepare('SELECT * FROM `clients` WHERE `unique_url` =:UniqueUrl');
        $sth->bindparam(":UniqueUrl", $UniqueUrl);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}