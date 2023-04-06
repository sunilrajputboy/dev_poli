<?php
class forgotpassword_model extends Model
{
	public function getuserByemail($email){
        $sth = $this->db->prepare("SELECT * FROM `users` WHERE `email`=:email");
        $sth->bindparam(":email", $email);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function addnewpassword($pass,$id){
	    $sth = $this->db->prepare("UPDATE `users` SET `password` =:pass WHERE `id` = $id");
        $sth->bindparam(":pass", $pass);
        $sth->execute();
        return $sth;
	}
	
}