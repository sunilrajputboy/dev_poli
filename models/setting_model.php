<?php
class setting_model extends Model
{
	public function getUserDetailsById($userId){
        $sth = $this->db->prepare("SELECT * FROM `users` where id=:userId");
        $sth->bindparam(":userId", $userId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getProjectById($projectId){
        $sth = $this->db->prepare("SELECT * FROM `projects` where id_project=:projectId");
        $sth->bindparam(":projectId", $projectId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getClientById($clientId){
        $sth = $this->db->prepare('SELECT * FROM `clients` WHERE `id` =:clientId');
        $sth->bindparam(":clientId", $clientId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    	public function getAllpackages(){
        $sth = $this->db->prepare("SELECT * FROM `packages` where visibility='1'");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    	public function checkUniqueUrl($uniqueUrl,$clientId){
        $sth = $this->db->prepare('SELECT * FROM `clients` WHERE `unique_url` =:uniqueUrl AND id!=:clientId');
        $sth->bindparam(":uniqueUrl", $uniqueUrl);
        $sth->bindparam(":clientId", $clientId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getPackageById($packageId){
        $sth = $this->db->prepare('SELECT * FROM `packages` WHERE `id` =:packageId');
        $sth->bindparam(":packageId", $packageId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    	public function getFonts(){
        $sth = $this->db->prepare('SELECT * FROM `fonts` ORDER BY  `font_family` ASC');
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    
	public function getAllProjects(){
        $sth = $this->db->prepare("SELECT * FROM `projects` ORDER BY `sequence_no`");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getProjectWhereIn($projectIds){
        $sth = $this->db->prepare("SELECT * FROM `projects` WHERE `id_project` IN ($projectIds) ORDER BY `sequence_no`");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    	public function getClientWhereIn($ids){
        $sth = $this->db->prepare("SELECT * FROM `clients` WHERE `id` IN ($ids)");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    
	public function getProjectByClientId($ClientId){
        $sth = $this->db->prepare("SELECT * FROM `projects` WHERE `id_client` =:ClientId ORDER BY `sequence_no`");
        $sth->bindparam(":ClientId", $ClientId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	
	public function getAllClients(){
        $sth = $this->db->prepare("SELECT * FROM `clients`");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	
	public function getAllProjectGroups(){
        $sth = $this->db->prepare("SELECT * FROM `projectgroup`");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getClientsById($clientId){
        $sth = $this->db->prepare('SELECT * FROM `clients` where id=:clientId');
        $sth->bindparam(":clientId", $clientId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    	public function updateUserwithpass($name,$password,$phone,$id){
        $sth = $this->db->prepare("UPDATE `users` SET `name`= :name, `password`=:password, `phone`= '$phone' WHERE `id` = $id");
         $sth->bindparam(":password", $password);
        $sth->bindparam(":name", $name);
        $sth->execute();
        return $sth;
    }

	public function updateCompany($cname,$cphone,$cemail,$cid){
        $sth = $this->db->prepare("UPDATE `clients` SET `name`= :name, `email`=:email, `phone`= :phone WHERE `id` =:cid");
         $sth->bindparam(":email", $cemail);
        $sth->bindparam(":name", $cname);
        $sth->bindparam(":phone", $cphone);
        $sth->bindparam(":cid", $cid);
        $sth->execute();
        return $sth;
    }
    	public function updateUser($name,$phone,$id){
        $sth = $this->db->prepare("UPDATE `users` SET `name`= :name, `phone`= '$phone' WHERE `id` = $id");
        $sth->bindparam(":name", $name);
        $sth->execute();
        return $sth;
    }
    	public function UpdateClientData($logourl,$logofiledb,$fonts,$colours,$is_mp,$is_social_share,$is_email_share, $is_tweet_mp,$tweet_mp_text,$email_sub,$email_msg,$is_charts,$unique_url,$is_facebook,$is_insta,$is_twitter,$is_linkedin,$is_email_friend,$email_friend_text,$email_friend_title,$primary_color,$secondary_color,$text_color,$text_color2,$text_color3,$id){
        $sth = $this->db->prepare("UPDATE `clients` SET `logo`='$logourl',`logofile`='$logofiledb', `font`='$fonts',`colours`='$colours',`is_mp`='$is_mp', `is_social_share`='$is_social_share',`is_email_share`='$is_email_share',`is_tweet_mp`=:is_tweet_mp,`tweet_mp_text`=:tweet_mp_text,`email_sub` = :email_sub,`message` =:email_msg,`is_charts`='$is_charts',`unique_url`=:unique_url,`is_facebook`=:is_facebook,`is_insta`=:is_insta,`is_twitter`=:is_twitter,`is_linkedin`=:is_linkedin,`is_email_friend`=:is_email_friend, `email_friend_text`=:email_friend_text,`email_friend_title`='$email_friend_title', `primary_color` = '$primary_color',`secondary_color` =  '$secondary_color',`text_color`='$text_color',`text_color2`='$text_color2',`text_color3`='$text_color3' WHERE `id` = $id");
      
        $sth->bindparam(":tweet_mp_text", $tweet_mp_text);
        $sth->bindparam(":email_msg", $email_msg);
        $sth->bindparam(":email_friend_text", $email_friend_text);
        $sth->bindparam(":email_sub", $email_sub);
          $sth->bindparam(":is_tweet_mp", $is_tweet_mp);
        $sth->bindparam(":is_facebook", $is_facebook);
        $sth->bindparam(":is_insta", $is_insta);
            $sth->bindparam(":is_twitter", $is_twitter);
                $sth->bindparam(":is_linkedin", $is_linkedin);
           $sth->bindparam(":unique_url", $unique_url);
             $sth->bindparam(":is_email_friend", $is_email_friend);
        $ret=$sth->execute();
        return  $ret;
    }
    
	/********************/
}