<?php
class Sunil_model extends Model
{
	public function getPackages(){
        $sth = $this->db->prepare("SELECT * FROM `packages` ORDER BY `sequence_no`");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getClientBypackageId($packageId){
        $sth = $this->db->prepare("SELECT * FROM `clients` where package=:packageId");
        $sth->bindparam(":packageId", $packageId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getUserDetailsById($userId){
        $sth = $this->db->prepare("SELECT * FROM `users` where id=:userId");
        $sth->bindparam(":userId", $userId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getClients(){
        $sth = $this->db->prepare("SELECT * FROM `clients` ORDER BY `sequence_no`");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getUsers(){
        $sth = $this->db->prepare("SELECT * FROM `users` WHERE `role` = 2 ORDER BY `sequence_no`");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getClientsWhereIn($uid){
        $sth = $this->db->prepare("SELECT * FROM `clients` WHERE `id` IN ($uid)");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	
	public function deleteUser($userId){
        $sth = $this->db->prepare('DELETE FROM `users` WHERE `id` = :userId');
        $sth->bindparam(":userId", $userId);
        $del=$sth->execute();
        return $del;
    }
	public function activeUser($userId){
        $sth = $this->db->prepare("UPDATE `users` SET `suspended`= '0' WHERE `id` = :userId");
        $sth->bindparam(":userId", $userId);
        $del=$sth->execute();
        return $del;
    }
	public function suspendUser($userId){
        $sth = $this->db->prepare("UPDATE `users` SET `suspended`= '1' WHERE `id` = :userId");
        $sth->bindparam(":userId", $userId);
        $del=$sth->execute();
        return $del;
    }
	public function allowClientPrivilage($userId){
        $sth = $this->db->prepare("UPDATE `users` SET `allowed_client_add`= '1' WHERE `id` = :userId");
        $sth->bindparam(":userId", $userId);
        $del=$sth->execute();
        return $del;
    }
	public function disallowClientPrivilage($userId){
        $sth = $this->db->prepare("UPDATE `users` SET `allowed_client_add`= '0' WHERE `id` = :userId");
        $sth->bindparam(":userId", $userId);
        $del=$sth->execute();
        return $del;
    }
	public function allowUserPrivilage($userId){
        $sth = $this->db->prepare("UPDATE `users` SET `allowed_user_add`= '1' WHERE `id` = :userId");
        $sth->bindparam(":userId", $userId);
        $del=$sth->execute();
        return $del;
    }
	public function disallowUserPrivilage($userId){
        $sth = $this->db->prepare("UPDATE `users` SET `allowed_user_add`= '0' WHERE `id` = :userId");
        $sth->bindparam(":userId", $userId);
        $del=$sth->execute();
        return $del;
    }
	public function getUserByEmail($emailId){
        $sth = $this->db->prepare("SELECT * FROM `users` where email=:emailId");
        $sth->bindparam(":emailId", $emailId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function insertUser($uname,$email,$password,$phone,$clients){
        $sth = $this->db->prepare("INSERT INTO `users`(`name`, `email`, `password`, `phone`, `clients`, `mail_sent`, `verify`) VALUES (:uname,'$email','$password','$phone','$clients',1,1)");
        $sth->bindparam(":uname", $uname);
        $del=$sth->execute();
        return $del;
    }
	public function updateUser($userId,$uname,$email,$password,$phone,$clients){
        $sth = $this->db->prepare("UPDATE `users` SET `name`=:uname,`email`='$email',`password`='$password',`phone`= '$phone',`clients`= '$clients' WHERE `id` = '$userId'");
         $sth->bindparam(":uname", $uname);
        $del=$sth->execute();
        return $del;
    }
	public function getUserByEmailId($emailId,$userId){
        $sth = $this->db->prepare("SELECT * FROM `users` where email=:emailId AND `id` != :userId ");
        $sth->bindparam(":emailId", $emailId);
        $sth->bindparam(":userId", $userId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}