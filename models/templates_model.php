<?php
class templates_model extends Model
{
	public function getTemplate(){
        $sth = $this->db->prepare('SELECT * FROM `template`');
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	
	public function updatTemplate($is_mp,$email_sub,$message){
        $sth = $this->db->prepare("UPDATE `template` SET `is_mp`= :IsMp,`email_sub` = :EmailSub, `message`= :Message");
        $sth->bindparam(":IsMp", $is_mp);
        $sth->bindparam(":EmailSub", $email_sub);
        $sth->bindparam(":Message", $message);
        $ret=$sth->execute();
        return $ret;
    }
	public function updatSocialShare($is_social_share,$is_tweet_mp,$tweet_mp_text,$is_facebook,$is_insta,$is_twitter,$is_linkedin,$email_friend_text,$email_friend_title,$is_email_friend,$subscribe_mail_text,$subscribe_mail_address,$copyright_title,$copyright_link){
        $sth = $this->db->prepare("UPDATE `template` SET `is_social_share`='$is_social_share',`is_tweet_mp`='$is_tweet_mp',`tweet_mp_text`='$tweet_mp_text', `is_facebook` = '$is_facebook', `is_insta` = '$is_insta',  `is_twitter` = '$is_twitter',`is_linkedin` = '$is_linkedin',`email_friend_text`='$email_friend_text',`email_friend_title`='$email_friend_title',`is_email_friend` = '$is_email_friend',`subscribe_mail_text`='$subscribe_mail_text',`subscribe_mail_address`='$subscribe_mail_address',`copyright_title`='$copyright_title',`copyright_link`='$copyright_link'");
        $ret=$sth->execute();
        return $ret;
    }

	public function getUserById($userId){
        $sth = $this->db->prepare('SELECT * FROM `users` WHERE `id` =:userId');
        $sth->bindparam(":userId", $userId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    	public function updatPrivacyTemplate($pp){
        $sth = $this->db->prepare('UPDATE `template` SET `privacypolicy`=:pp');
        $sth->bindparam(":pp", $pp);
        $ret=$sth->execute();
        return $ret;
    }
	
}