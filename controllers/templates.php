<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class Templates extends Controller{
	function __construct() {
		parent::__construct();
		$this->checkLoggedIn();
	}
	function index(){
		$userId=$_SESSION['uid'];
		$result=$this->model->getUserById($userId);
        $userDatass=$result[0];
		define("USERROLE", $userDatass['role']);
		$tempData=$this->model->getTemplate();
		$dataClientall=!empty($tempData) ? $tempData : array();
		$userdetails=array('dataClientall'=>$dataClientall[0],'mthis'=>$this);
			if(USERROLE == 1){
		    
		$this->view->mydashboard('dashboard/templates/view',false,$userdetails);
		}else{
		         header('Location:'. BASE_URL.'dashboard');
		  
		}
		
	}

	function update(){
		if($_POST['email_mp_update']){
		    	$email_sub = $_POST['email_sub'];
				$message = $_POST['message'];
			if($_POST['is_mp'] != 'yes'){
				$is_mp = 'no';
			}else{
				$is_mp = $_POST['is_mp'];
				$email_sub = $_POST['email_sub'];
				$message = $_POST['message'];
			}
			
			$emailmp_MH = $_POST['emailmp_MH'];
				$update=$this->model->updatTemplate($is_mp,$email_sub,$message,$emailmp_MH);
				$_SESSION['success_message']='Template updated sucessfully !';
				header('Location:'. BASE_URL.'templates');
		}else{
			$_SESSION["error_msg"]='Unknown method';
			header('Location:'. BASE_URL.'templates/');
			exit;
		}
}

        function updateprivacypolicy(){
            	if($_POST['privacypolicy']){
				$update=$this->model->updatPrivacyTemplate($_POST['privacypolicy']);
				$_SESSION['success_message']='Template updated successfully !';
				header('Location:'. BASE_URL.'templates');
		}else{
			$_SESSION["error_msg"]='Unknown method';
			header('Location:'. BASE_URL.'templates/');
			exit;
		}
        }

	function newupdate(){
		if(isset($_POST['update'])){
		if($_POST['is_social_share'] != 'yes'){
		$is_social_share = 'no';
		$is_tweet_mp = 'no';
		}else{
			$is_social_share = $_POST['is_social_share'];
			if($_POST['is_facebook'] != 'yes'){
				$is_facebook = 'no';
			}else{
				$is_facebook = $_POST['is_facebook_text'];
			}

			if($_POST['is_insta'] != 'yes'){
				$is_insta = 'no';
			}else{
				$is_insta = $_POST['is_insta_text'];
			}

			if($_POST['is_twitter'] != 'yes'){
				$is_twitter = 'no';
			}else{
				$is_twitter = $_POST['is_twitter_text'];
			}
			if($_POST['is_linkedin'] != 'yes'){
				$is_linkedin = 'no';
			}else{
				$is_linkedin = $_POST['is_linkedin_text'];
			}
		}

		if($_POST['is_tweet_mp'] != 'yes'){
			$is_tweet_mp = 'no';
			$tweet_mp_text = null;
		}else{
			$is_tweet_mp = $_POST['is_tweet_mp'];
			$tweet_mp_text = $_POST['tweet_mp_text'];
		}

		if($_POST['is_email_friend'] != 'yes'){
			$is_email_friend = 'no';
		}else{
			$is_email_friend = $_POST['is_email_friend'];
		}
			$email_friend_text  = $_POST['email_friend_text'];
			$email_friend_title = $_POST['email_friend_title'];

			$subscribe_mail_text = isset($_POST['subscribe_mail_text']) ? $_POST['subscribe_mail_text'] : null;
			$subscribe_mail_address = isset($_POST['subscribe_mail_address']) ? $_POST['subscribe_mail_address'] : null;
			$copyright_title = isset($_POST['copyright_title']) ? $_POST['copyright_title'] : null;
			$copyright_link = isset($_POST['copyright_link']) ? $_POST['copyright_link'] : null;

		$update=$this->model->updatSocialShare($is_social_share,$is_tweet_mp,$tweet_mp_text,$is_facebook,$is_insta,$is_twitter,$is_linkedin,$email_friend_text,$email_friend_title,$is_email_friend,$subscribe_mail_text,$subscribe_mail_address,$copyright_title,$copyright_link);
		$_SESSION['success_message']='Social Share Updated Successfully.';
		header('Location:'. BASE_URL.'templates');		
			
			}else{
				$_SESSION["error_msg"]='Unknown method';
				header('Location:'. BASE_URL.'templates/');
			}
	}

	/**************/
}
?>