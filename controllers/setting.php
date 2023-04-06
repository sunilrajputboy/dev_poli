<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class Setting extends Controller{
	function __construct() {
		parent::__construct();
		$this->checkLoggedIn();
	}
	function index(){
		$userId=$_SESSION['uid'];
		$result=$this->model->getUserDetailsById($userId);
		$userDatass=$result[0];
		define("USERROLE", $userDatass['role']);
		$cid=$_SESSION['cid'];
		$fonts=$this->model->getFonts();
		
		$cdata =$this->model->getClientById($cid);
		$cdata = $cdata[0];
		$packageData=$this->model->getPackageById($cdata['package']);

		$userdetails=array('userDatass'=>$userDatass,'fonts'=>$fonts,'packageData'=>$packageData[0],'mthis'=>$this);
		$this->view->mydashboard('dashboard/setting/view',false,$userdetails);
	}
	
	function edit($userId){
			$userIds=$_SESSION['uid'];
			$result=$this->model->getUserDetailsById($userIds);
			$userDatass=$result[0];
			define("USERROLE", $userDatass['role']);	
			$clients=$this->model->getClients();
			$userdata=$this->model->getUserDetailsById($userId);
			$data=!empty($userdata) ? $userdata[0] : array();
			$userdetails=array('userDatass'=>$userDatass,'data'=>$data,'clients'=>$clients,'mthis'=>$this);
			$this->view->mydashboard('dashboard/projects/edit',false,$userdetails);
	}
	function updateUserProfile(){
            
            $name  = $_POST['uname'];
            $phone = $_POST['uphone'];
            $id = $_POST['uid'];
			
            $password = $_POST['password'];
            if($password != null){
            $password = md5($_POST['password']);
            }
            if($password != null){
			$query=$this->model->updateUserwithpass($name,$password,$phone,$id);
            }else{
			$query=$this->model->updateUser($name,$phone,$id);
            }
            if($query){
            echo json_encode(array(
            'success' => 1,
            'msg' => 'User updated successfully.'
            )
            );
            }

	}
	
	function updateCompany(){
            $cname  = $_POST['cname'];
            $cphone = $_POST['cphone'];
            $cemail = $_POST['cemail'];
            $cid = $_POST['cid'];
			$query=$this->model->updateCompany($cname,$cphone,$cemail,$cid);
            if($query){
				echo json_encode(array('success' => 1,'msg' => 'Company updated succesffully.','redirect_url'=>BASE_URL.'setting'));
            }
	}
	
		 function updateglobalsetting(){
		if(isset($_POST['update'])){
			$id = $_POST['id'];
			$fonts= $_POST['fonts'];
			if($fonts != null){
				$fonts = $fonts;
			}
			$tweet_mp_text = $_POST['tweet_mp_text'];
			$email_sub = $_POST['email_sub'];
			$email_msg = $_POST['message'];
			$primary_color = $_POST['colorprime'];
			$secondary_color = $_POST['colorsecond'];
			$text_color = $_POST['text_color'];
			$text_color2 = $_POST['text_color2'];
			$text_color3 = $_POST['text_color3'];
			
			$unique_url = $_POST['unique_url'];
			$is_charts = $_POST['is_charts'];
			$logofile = $_FILES['logofile']['name'];
			if($_POST['is_email_mp'] != 'yes'){
				$is_mp = 'no';
			}else{
				$is_mp = $_POST['is_email_mp'];
			}
			if($_POST['is_social_share'] != 'yes'){
				$is_social_share = 'no';
			}else{
				$is_social_share = $_POST['is_social_share'];
			}
			if($_POST['is_email_share'] != 'yes'){
				$is_email_share = 'no';
			}else{
				$is_email_share = $_POST['is_email_share'];
			}
			if($_POST['is_tweet_mp'] != 'yes'){
				$is_tweet_mp = 'no';
			}else{
				$is_tweet_mp = $_POST['is_tweet_mp'];
			}
			if($_POST['is_charts'] != 'yes'){
				$is_charts = 'no';
			}
			if($_POST['facebook'] != 'yes'){
				$is_facebook = 'no';
			}else{
				$is_facebook = $_POST['is_facebook'];
			}
			if($_POST['insta'] != 'yes'){
				$is_insta = 'no';
			}else{
				$is_insta = $_POST['is_insta'];
			}
			if($_POST['twitter'] != 'yes'){
				$is_twitter = 'no';
			}else{
				$is_twitter = $_POST['is_twitter'];
			}

			if($_POST['linkedin'] != 'yes'){
				$is_linkedin = 'no';
			}else{
				$is_linkedin = $_POST['is_linkedin'];
			}

			if($_POST['is_email_friend'] != 'yes'){
				$is_email_friend = 'no';
			}else{
				$is_email_friend = $_POST['is_email_friend'];
			}
			$email_friend_text = $_POST['email_friend_text'];
			$email_friend_title = $_POST['email_friend_title'];
			if($_POST['url'] == 'yes'){
				$logourl = $_POST['logourl'];
				$logofiledb= null;
			}
			if($_POST['file'] == 'yes'){
			      if($_FILES["logofile"]["name"] == NULL){
                 $logofiledb = $_POST['old_logo_file'];
                 }else{
             	$ext = pathinfo($_FILES["logofile"]["name"], PATHINFO_EXTENSION);
				$logofiledb = rand().'.'.$ext;  
				move_uploaded_file($_FILES["logofile"]["tmp_name"], "uploads/".$logofiledb);
                 }
				$logourl = null;
                
			
			}
			
			$color_type = $_POST['color_type'];
			if($color_type == 1){
				if($_POST['colorinput'] != null){
				   $colours = serialize($_POST['colorinput']); 
				}else{
					$colours = null;
				}
			}else{
				if($_POST['color'] != null){
					$colours = serialize($_POST['color']); 
				}else{
					$colours = null;
				}
			}
			if($unique_url == ''){
			 $_SESSION['error_msg']='Unique url can not be empty';
			 header('Location:'. BASE_URL.'setting');
			 exit;
			}
			$ckeckunique=$this->model->checkUniqueUrl($unique_url,$id);
			if(!empty($ckeckunique)){
			 $_SESSION['error_msg']='you are using duplicate Unique Url. Try new one.';
			 header('Location:'. BASE_URL.'setting');
			 exit;			 
			}
			
   $inserts=$this->model->UpdateClientData($logourl,$logofiledb,$fonts,$colours,$is_mp,$is_social_share,$is_email_share, $is_tweet_mp,$tweet_mp_text,$email_sub,$email_msg,$is_charts,$unique_url,$is_facebook,$is_insta,$is_twitter,$is_linkedin,$is_email_friend,$email_friend_text,$email_friend_title,$primary_color,$secondary_color,$text_color,$text_color2,$text_color3,$id);
			$userId=$_SESSION['uid'];
			 $_SESSION['success_msg']='Clients setting updated successfully !';
			 header('Location:'. BASE_URL.'setting');
			 exit();
			}else{
				$_SESSION["error_msg"]='Unknown method';
				header('Location:'. BASE_URL.'setting');
			}
	}
/***************/	
	
}
?>