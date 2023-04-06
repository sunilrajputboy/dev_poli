<?php
class register_model extends Model
{
	public function getPackages(){
        $sth = $this->db->prepare('SELECT * FROM `packages` ORDER BY `sequence_no`');
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getUserByEmail($email){
         $sth = $this->db->prepare("SELECT * FROM `users` WHERE `email` =:email");
        $sth->bindparam(":email", $email);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    	public function insertUser($uname,$email,$password,$phone,$role){
        $sth = $this->db->prepare("INSERT INTO `users`(`name`, `email`, `password`, `phone`, `role`, `mail_sent`) VALUES (:uname,'$email','$password','$phone','$role',1)");
        $sth->bindparam(":uname", $uname);
        $sth=$sth->execute();
        $insert_id = $this->db->lastInsertId();
        return $insert_id;
    }
    	public function getAllTemplate(){
        $sth = $this->db->prepare('SELECT * FROM `template`');
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    
    	public function insertClient($cname,$email,$phone,$package,$register_by,$unique_url,$is_mp, $email_sub,$message,$is_social_share,$is_tweet_mp,$is_facebook,$is_insta,$is_twitter,$is_linkedin,$is_email_friend,$tweet_mp_text,$colours){
       $sth = $this->db->prepare("INSERT INTO `clients`(`name`, `email`, `phone`, `package`, `register_by`,`unique_url`,`is_mp`, `email_sub`, `message`, `is_social_share`, `is_tweet_mp`, `is_facebook`, `is_insta`, `is_twitter`, `is_linkedin`, `is_email_friend`, `tweet_mp_text`, `colours`,`primary_color`,`secondary_color`,`text_color`,`text_color2`,`text_color3`,`logofile`,`font`) VALUES (:cname,'$email','$phone','$package','$register_by',:unique_url,'$is_mp', :email_sub, :message, '$is_social_share', :is_tweet_mp, :is_facebook, :is_insta, :is_twitter, :is_linkedin, :is_email_friend, :tweet_mp_text,'$colours','#000000','#f41224','#f41224','#000000','#000000','polimapper-logo.jpg','Roboto')");
         $sth->bindparam(":cname", $cname);
         $sth->bindparam(":email_sub", $email_sub);
          $sth->bindparam(":message", $message);
          $sth->bindparam(":is_tweet_mp", $is_tweet_mp);
        $sth->bindparam(":is_facebook", $is_facebook);
        $sth->bindparam(":is_insta", $is_insta);
            $sth->bindparam(":is_twitter", $is_twitter);
           $sth->bindparam(":unique_url", $unique_url);
             $sth->bindparam(":is_email_friend", $is_email_friend);
               $sth->bindparam(":tweet_mp_text", $tweet_mp_text);
                $sth->bindparam(":is_linkedin", $is_linkedin);
        $ret=$sth->execute();
         $insert_id = $this->db->lastInsertId();
        return $insert_id;
    }
    	public function updateUser($last_id,$clients){
       $sth = $this->db->prepare("UPDATE `users` SET `clients`=:clients WHERE `id` = $last_id");
        $sth->bindparam(":clients", $clients);
        $del=$sth->execute();
        return $del;
    }
	
}