<?php
class login_model extends Model
{
	
	public function checkAuth($email,$password){
        $sth = $this->db->prepare('SELECT * FROM `users` where email=:email_id AND password=:passwords LIMIT 1');
        $sth->bindparam(":email_id", $email);
        $sth->bindparam(":passwords", $password);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);	
    }
	
	public function updateLastLogin($lastLogin,$user_id){
		$sth = $this->db->prepare('UPDATE `users` SET last_login=:lastLogin  where id=:uId ');
        $sth->bindparam(":lastLogin", $lastLogin);
        $sth->bindparam(":uId", $user_id);
        return $sth->execute();	
    }
    	public function getUsers($id){
		$sth = $this->db->prepare("SELECT * FROM `users` WHERE `id` = '$id'");
        $sth->execute();	
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    
    	public function verifyEmail($id){
		$sth = $this->db->prepare("UPDATE `users` SET `verify`= '1',`mail_sent`= '1' WHERE `id` = $id");
        $sth->execute();	
        return $sth;
    }
    
    
    
}