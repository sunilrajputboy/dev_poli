<?php
class clients_model extends Model
{
	public function getClients(){
        $sth = $this->db->prepare('SELECT * FROM `clients` ORDER BY `sequence_no`');
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function activeClient($clientId){
        $sth = $this->db->prepare("UPDATE `clients` SET `is_suspended`= '0' WHERE `id` =:clientId");
        $sth->bindparam(":clientId", $clientId);
        $ret=$sth->execute();
        return $ret;
    }
	public function suspendClient($clientId){
        $sth = $this->db->prepare("UPDATE `clients` SET `is_suspended`= '1' WHERE `id`=:clientId");
        $sth->bindparam(":clientId", $clientId);
         $ret=$sth->execute();
        return  $ret;
    }
	public function getAllUsers(){
        $sth = $this->db->prepare('SELECT * FROM `users`');
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
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
	public function getPackageById($packageId){
        $sth = $this->db->prepare('SELECT * FROM `packages` WHERE `id` =:packageId');
        $sth->bindparam(":packageId", $packageId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getAllPackages(){
        $sth = $this->db->prepare('SELECT * FROM `packages` WHERE `visibility` =1');
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getProjectById($projectId){
        $sth = $this->db->prepare('SELECT * FROM `projects` WHERE `id_client` =:projectId');
        $sth->bindparam(":projectId", $projectId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    	public function getallProject(){
        $sth = $this->db->prepare('SELECT * FROM `projects`');
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getAllTemplate(){
        $sth = $this->db->prepare('SELECT * FROM `template`');
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function selectTwoTableData(){
        $sth = $this->db->prepare("SELECT projects.id_project,projects.id_client,projects.name,clients.name as company_name FROM projects LEFT JOIN clients ON projects.id_client=clients.id WHERE projects.id!=''");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	
	public function deleteClientsById($clientId){
        $sth = $this->db->prepare('DELETE FROM `clients` WHERE `id` = :clientId');
        $sth->bindparam(":clientId", $clientId);
        $del=$sth->execute();
        return $del;
    }
	
	public function slugify($text, string $divider = '-'){
	  $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
	  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	  $text = preg_replace('~[^-\w]+~', '', $text);
	  $text = trim($text, $divider);
	  $text = preg_replace('~-+~', $divider, $text);
	  $text = strtolower($text);
	  $text = str_replace('-',"", $text);
	  if(empty($text)) {
		return 'n-a';
	  }
	  return $text;
	}
	
	public function getClientByUniqueUrl($uniqueUrl){
        $sth = $this->db->prepare('SELECT * FROM `clients` WHERE `unique_url` =:uniqueUrl');
        $sth->bindparam(":uniqueUrl", $uniqueUrl);
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
        return  $ret;
    }
	
	public function updateUsers($clients,$uid){
        $sth = $this->db->prepare("UPDATE `users` SET `clients`= :Clients WHERE `id` = :Uid");
        $sth->bindparam(":Clients", $clients);
        $sth->bindparam(":Uid", $uid);
         $ret=$sth->execute();
        return  $ret;
    }
	public function checkUniqueUrl($uniqueUrl,$clientId){
        $sth = $this->db->prepare('SELECT * FROM `clients` WHERE `unique_url` =:uniqueUrl AND id!=:clientId');
        $sth->bindparam(":uniqueUrl", $uniqueUrl);
        $sth->bindparam(":clientId", $clientId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getFonts(){
        $sth = $this->db->prepare('SELECT * FROM `fonts` ORDER BY  `font_family` ASC');
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
// 	public function updateClient($cname,$email,$phone,$package,$project,$id){
//         $sth = $this->db->prepare("UPDATE `clients` SET `name`=:cname,`email`=:email,`phone`=:phone,`package`=:package,`projects`=:project WHERE `id`=:id");
//         $sth->bindparam(":cname",$cname);
//         $sth->bindparam(":phone",$phone);
//         $sth->bindparam(":package",$package);
//         $sth->bindparam(":project",$project);
//         $sth->bindparam(":email",$email);
//          $sth->bindparam(":id",$id);
//         $sth->execute();
//         return $sth;
//     }
    	public function updateClientdetails($cname,$email,$phone,$package,$id){
        $sth = $this->db->prepare("UPDATE `clients` SET `name`=:cname,`email`='$email',`phone`='$phone',`package`=:package WHERE `id`='$id'");
        $sth->bindparam(":cname",$cname);
        $sth->bindparam(":package",$package);
        $sth->execute();
        return $sth;
    }
	
	public function insertClientData($cname,$email,$phone,$package,$register_by,$unique_url,$is_mp, $email_sub,$message,$is_social_share,$is_tweet_mp,$is_facebook,$is_insta,$is_twitter,$is_linkedin,$is_email_friend,$tweet_mp_text,$colours){
        $sth = $this->db->prepare("INSERT INTO `clients`(`name`, `email`, `phone`, `package`, `register_by`,`unique_url`,`is_mp`, `email_sub`, `message`, `is_social_share`, `is_tweet_mp`, `is_facebook`, `is_insta`, `is_twitter`, `is_linkedin`, `is_email_friend`, `tweet_mp_text`, `colours`,`primary_color`,`secondary_color`,`logofile`,`font`) VALUES (:cname,'$email','$phone','$package','$register_by',:unique_url,'$is_mp', :email_sub, :message, '$is_social_share', :is_tweet_mp, :is_facebook, :is_insta, :is_twitter, :is_linkedin, :is_email_friend, :tweet_mp_text,'$colours','#000000','#f41224','polimapper-logo.jpg','Roboto')");
        $sth->bindparam(":cname", $cname);
          $sth->bindparam(":tweet_mp_text", $tweet_mp_text);
        $sth->bindparam(":message", $message);
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
	public function UpdateClientData($logourl,$logofiledb,$fonts,$colours,$is_mp,$is_social_share,$is_email_share, $is_tweet_mp,$tweet_mp_text,$email_sub,$email_msg,$emailmp_MH,$is_charts,$unique_url,$is_facebook,$is_insta,$is_twitter,$is_linkedin,$is_email_friend,$email_friend_text,$email_friend_title,$primary_color,$secondary_color,$text_color,$text_color2,$text_color3,$subscribe_mail_text,$subscribe_mail_address,$copyright_title,$copyright_link,$privacypolicy,$id){
        $sth = $this->db->prepare("UPDATE `clients` SET `logo`='$logourl',`logofile`='$logofiledb', `font`='$fonts',`colours`='$colours',`is_mp`='$is_mp', `is_social_share`='$is_social_share',`is_email_share`='$is_email_share',`is_tweet_mp`=:is_tweet_mp,`tweet_mp_text`=:tweet_mp_text,`email_sub` = :email_sub,`message` =:email_msg,`emailmp_MH`=:emailmp_MH,`is_charts`='$is_charts',`unique_url`=:unique_url,`is_facebook`=:is_facebook,`is_insta`=:is_insta,`is_twitter`=:is_twitter,`is_linkedin`=:is_linkedin,`is_email_friend`=:is_email_friend, `email_friend_text`=:email_friend_text,`email_friend_title`='$email_friend_title', `primary_color` = '$primary_color',`secondary_color` =  '$secondary_color',`text_color`='$text_color',`text_color2`='$text_color2',`text_color3`='$text_color3',`subscribe_mail_text`=:subscribe_mail_text,`subscribe_mail_address`='$subscribe_mail_address',`copyright_title`='$copyright_title',`copyright_link`='$copyright_link',`privacypolicy`=:privacypolicy WHERE `id` = $id");
        $sth->bindparam(":privacypolicy", $privacypolicy);
        $sth->bindparam(":subscribe_mail_text", $subscribe_mail_text);
        $sth->bindparam(":tweet_mp_text", $tweet_mp_text);
        $sth->bindparam(":email_msg", $email_msg);
          $sth->bindparam(":emailmp_MH", $emailmp_MH);
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
}