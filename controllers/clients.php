<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class Clients extends Controller{
	function __construct() {
		parent::__construct();
		$this->checkLoggedIn();
	}
	function index(){
		$userId=$_SESSION['uid'];
		$result=$this->model->getUserById($userId);
        $userDatass=$result[0];
		define("USERROLE", $userDatass['role']);
		$client_list=$this->model->getClients();
		$users_list=$this->model->getAllUsers();
		$dataClientall=!empty($client_list) ? $client_list : array();
		$allUsers=!empty($users_list) ? $users_list : array();
		$userdetails=array('dataClientall'=>$dataClientall,'allUsers'=>$allUsers,'userDatass'=>$userDatass,'mthis'=>$this);
		if(USERROLE == 1){
		$this->view->mydashboard('dashboard/clients/view',false,$userdetails);
		}else{
		     if($userDatass['allowed_client_add']==1){
		    $this->view->mydashboard('dashboard/clients/client_view',false,$userdetails);
		    }else{
		         header('Location:'. BASE_URL.'dashboard');
		    }
		 
		}
	}
	
	function view(){
	$userId=$_SESSION['uid'];
		$result=$this->model->getUserById($userId);
        $userDatass=$result[0];
		define("USERROLE", $userDatass['role']);
		$client_list=$this->model->getClients();
		$users_list=$this->model->getAllUsers();
		$dataClientall=!empty($client_list) ? $client_list : array();
		$allUsers=!empty($users_list) ? $users_list : array();
		$userdetails=array('dataClientall'=>$dataClientall,'allUsers'=>$allUsers,'mthis'=>$this);
	
	}

	function add(){
		$userId=$_SESSION['uid'];
		$result=$this->model->getUserById($userId);
		$userDatass=$result[0];
		define("USERROLE", $userDatass['role']);
		$users_list=$this->model->getAllUsers();
		$allUsers=!empty($users_list) ? $users_list : array();
		$packages_list=$this->model->getAllPackages();
		$allPackages=!empty($packages_list) ? $packages_list : array();
		$userdetails=array('allPackages'=>$allPackages,'allUsers'=>$allUsers,'userDatass'=>$userDatass,'mthis'=>$this);
		if(USERROLE == 1){
		$this->view->mydashboard('dashboard/clients/add',false,$userdetails);
		} else{
		       if($userDatass['allowed_client_add']==1){
		    $this->view->mydashboard('dashboard/clients/add',false,$userdetails);
		    }else{
		         header('Location:'. BASE_URL.'dashboard');
		    }
		    }
	}
	function insert(){
		if($_POST['name']){
			$cname = $_POST['name'];
			$email = $_POST['email'];
			$phone = $_POST['phone'];
			$package = $_POST['package'];
			$uid = $_SESSION['uid'];
			$register_by = $uid;
			$newDate = date("d-m-Y", strtotime($renew_date));
			$unique_url=$this->model->slugify($cname);
			$ckeckUnique=$this->model->getClientByUniqueUrl($unique_url);
			if(!empty($ckeckunique)){
				$unique_url=$unique_url.'-1';
				}
			$templateData1=$this->model->getAllTemplate();
		    $dataTemplate=!empty($templateData1) ? $templateData1[0] : array();
			
			$colours = array('#000000','#230305','#46050a','#69080f','#8b0a15','#ae0d1a','#d10f1f','#f41224');
			$colours = serialize($colours);
			
			$is_mp = !empty($dataTemplate) ? $dataTemplate['is_mp'] : '';
			$email_sub = !empty($dataTemplate) ? $dataTemplate['email_sub'] : '' ;
			$message = !empty($dataTemplate) ? $dataTemplate['message'] : '';
			$is_social_share = !empty($dataTemplate) ? $dataTemplate['is_social_share'] : '';
			$is_facebook = !empty($dataTemplate) ? $dataTemplate['is_facebook'] : '';
			$is_insta = !empty($dataTemplate) ? $dataTemplate['is_insta'] : '';
			$is_twitter = !empty($dataTemplate) ? $dataTemplate['is_twitter'] : '';
			$is_linkedin = !empty($dataTemplate) ? $dataTemplate['is_linkedin'] : '';
			$is_email_friend = !empty($dataTemplate) ? $dataTemplate['is_email_friend'] : '';
			$is_tweet_mp = !empty($dataTemplate) ? $dataTemplate['is_tweet_mp'] : '';
			$tweet_mp_text = !empty($dataTemplate) ? $dataTemplate['tweet_mp_text'] : '';
			$clnt=$this->model->insertClient($cname,$email,$phone,$package,$register_by,$unique_url,$is_mp, $email_sub,$message,$is_social_share,$is_tweet_mp,$is_facebook,$is_insta,$is_twitter,$is_linkedin,$is_email_friend,$tweet_mp_text,$colours);
			
			$userId=$_SESSION['uid'];
		    $getuserData=$this->model->getUserById($userId);
			foreach($getuserData as $udata){
				$clients = $udata['clients'];
				if($clients != null){
				$clients = unserialize($udata['clients']);
				array_push($clients,$last_id);
				$clients = serialize($clients);
				$queryUser = $this->model->updateUsers($clients,$userId);
				}
			}
	   if($getuserData[0]['role'] == 2){
	   	 $_SESSION['success_message']='Client added successfully.';
	     header('Location:'. BASE_URL.'clients/view');
		 exit;
         }else{
		 $_SESSION['success_message']='Client added successfully.';
	     header('Location:'. BASE_URL.'clients');
		 }
		}else{
			$_SESSION["error_msg"]='Unknown method!';
			header('Location:'. BASE_URL.'clients/');
		}
	}

	function edit($clientId){
		if($clientId){
		$userId=$_SESSION['uid'];
		$result=$this->model->getUserById($userId);
		$userDatass=$result[0];
		define("USERROLE", $userDatass['role']);
		$users_list=$this->model->getAllUsers();
		$client_data=$this->model->getClientById($clientId);
		$clientData=!empty($client_data) ? $client_data[0] : array();
		$allUsers=!empty($users_list) ? $users_list : array();
		$packages_list=$this->model->getAllPackages();
		$packages_data=$this->model->getPackageById($clientData['package']);
		$templateData1=$this->model->getAllTemplate();
		$templateData=!empty($templateData1) ? $templateData1[0] : array();
	$ProjectList=$this->model->getProjectById($clientId);
	    //$ProjectList=$this->model->getallProject($clientId);
		$fonts=$this->model->getFonts();
		$packageData=!empty($packages_data) ? $packages_data[0] : array();
		$allPackages=!empty($packages_list) ? $packages_list : array();
		$userdetails=array('allPackages'=>$allPackages,'templateData'=>$templateData,'packageData'=>$packageData,'clientData'=>$clientData,'allUsers'=>$allUsers,'ProjectList'=>$ProjectList,'mthis'=>$this,'fonts'=>$fonts);
		$this->view->mydashboard('dashboard/clients/edit',false,$userdetails);
		}else{
			$_SESSION["error_msg"]='Unknown method!';
			header('Location:'. BASE_URL.'clients/');	
		}
	}

	function update(){
		if($_POST['id']){
			$id = $_POST['id'];
			$cname = $_POST['name'];
			$email = isset($_POST['email']) ? $_POST['email'] : null;
			$phone = isset($_POST['phone']) ? $_POST['phone'] : null;
			$package = $_POST['package'];
			$userId = $_SESSION['uid'];
			$updateClient = $this->model->updateClientdetails($cname,$email,$phone,$package,$id);
			
			if($updateClient){
			 $_SESSION['success_message']='Client updated successfully.';
			 header('Location:'. BASE_URL.'clients/edit/'.$id);
			  exit();
		}else{
			$_SESSION["error_msg"]='Unknown method!';
			header('Location:'. BASE_URL.'clients/');
			 exit();
		}
	}
	}
	
	 function updateclient(){
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
			if($unique_url == '' || $unique_url == null){
			 $_SESSION['error_msg']='Unique url can not be empty';
			 header('Location:'. BASE_URL.'clients/edit/?id='.$id);
			 exit;
			}
// 			$ckeckunique=$this->model->checkUniqueUrl($unique_url,$id);
// 			if(!empty($ckeckunique)){
// 			 $_SESSION['error_msg']='you are using duplicate Unique Url. Try new one.';
// 			 header('Location:'. BASE_URL.'clients/edit/?id='.$id);
// 			 exit;			 
// 			}

	$subscribe_mail_text = isset($_POST['subscribe_mail_text']) ? $_POST['subscribe_mail_text'] : null;
	if($subscribe_mail_text == '' || $subscribe_mail_text == ' '){
		$subscribe_mail_text = null;
	}
	
		$subscribe_mail_address = isset($_POST['subscribe_mail_address']) ? $_POST['subscribe_mail_address'] : null;
		$copyright_title = isset($_POST['copyright_title']) ? $_POST['copyright_title'] : null;
		$copyright_link = isset($_POST['copyright_link']) ? $_POST['copyright_link'] : null;
	
	$privacypolicy = isset($_POST['privacypolicy']) ? $_POST['privacypolicy'] : null;
	
   $inserts=$this->model->UpdateClientData($logourl,$logofiledb,$fonts,$colours,$is_mp,$is_social_share,$is_email_share, $is_tweet_mp,$tweet_mp_text,$email_sub,$email_msg,$is_charts,$unique_url,$is_facebook,$is_insta,$is_twitter,$is_linkedin,$is_email_friend,$email_friend_text,$email_friend_title,$primary_color,$secondary_color,$text_color,$text_color2,$text_color3,$subscribe_mail_text,$subscribe_mail_address,$copyright_title,$copyright_link,$privacypolicy,$id);
			$userId=$_SESSION['uid'];
		    $getuserData=$this->model->getUserById($userId);
		   if($getuserData[0]['role'] == 2){
			 $_SESSION['success_msg']='Clients setting updated successfully.';
			 header('Location:'. BASE_URL.'clients/edit/'.$id);
			 exit;
			 }else{
			 $_SESSION['success_msg']='Clients setting updated successfully.';
			 header('Location:'. BASE_URL.'clients/edit/'.$id);
			 exit;
			 }
			}else{
				$_SESSION["error_msg"]='Unknown method!';
				header('Location:'. BASE_URL.'clients/');
			}
	}
	/***/
	function delete(){
		if($_GET['id']){
			$id = $_GET['id'];
			$delete=$this->model->deleteClientsById($id);
			$_SESSION["success_msg"]='Client deleted successfully.';
			header('Location:'. BASE_URL.'clients/');
		}
	}
	/***/
	function activeclients(){
		if($_GET['id']){
			$id = $_GET['id'];
			$adminData1 = $this->model->getUserById(1);
			$adminData=!empty($adminData1) ? $adminData1[0] : array();
			$clientData1=$this->model->getClientById($id);
			$clientData=!empty($clientData1) ? $clientData1[0] : array();
			$active=$this->model->activeClient($id);
			$allusers=$this->model->getAllUsers();
			$userArr = array();
			if(!empty($userDataAll)){
				foreach($userDataAll as $udata){
					$clientInuser = $udata['clients'];
					if($clientInuser != null){
						if(in_array($id, unserialize($clientInuser))){
							array_push($userArr,$udata['email']);
						}  
					}
				}
			}
			if($userArr != null){
			 $emaillistUser = implode(',',$userArr);
			 $emailuserclient = $emaillistUser.', '.$clientData['email'];
			 }else{
			  $emailuserclient = $clientData['email'];   
			 }
			$adminEmail =  $adminData['email'];
			$cname = $clientData['name'];
 			$subjectUser = "Company approved";
// 			$txt = "Hi company $cname is approved successfully!!";
$year = date("Y");
			$txt = '<!doctype html>
			<html lang="en-US">
			
			<head>
				<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
				<title>Company approved Template</title>
				<meta name="description" content="Reset Password Email Template.">
			</head>
			
			<body marginheight="0" topmargin="0" marginwidth="0"
				style="margin: 0px; background-color: #f2f3f8;font-family: Arial, Helvetica, sans-serif;" leftmargin="0">
				<table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8">
					<tr>
						<td>
							<table style="background-color: #f2f3f8; max-width:670px; margin:0 auto;" width="100%" border="0"
								align="center" cellpadding="0" cellspacing="0">
								<tr>
									<td style="height:80px;">&nbsp;</td>
								</tr>
								<tr>
									<td style="text-align:center;">
										<a href="'.BASE_URL.'/login" title="logo" target="_blank">
											<img width="200"
												src="'.BASE_URL.'/public/assets/img/polimapper-logo.png"
												title="logo" alt="logo">
										</a>
									</td>
								</tr>
								<tr>
									<td style="height:20px;">&nbsp;</td>
								</tr>
								<tr>
									<td>
										<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
											style="max-width:670px;background:#fff; border-radius:3px; text-align:center">
											<tr>
												<td style="height:35px;">&nbsp;</td>
											</tr>
											<tr>
												<td style="padding:0 35px;">
													<h2 style="
														font-size: 25px;
														color: #000;
														margin-bottom: 20px;
														margin-top: 20px;
														font-weight: 600
													">Hi company,
														<span>'.$cname.'</span> is approved successfully.
													</h2>
												</td>
											</tr>
											<tr>
												<td style="height:30px;">&nbsp;</td>
											</tr>
											<tr>
												<td>
													<div style="margin:0 100px ;">
														<p style="margin:0; border-top: 1px solid #f2f3f8;">&nbsp;</p>
													</div>
												</td>
											</tr>
											<tr>
												<td>
													<table style="width: 180px;" align="center">
														<tr>
															<td style="width: 180px;
												padding: 15px;
												display: block;
												background: #f31828; text-align: center;">
																<a href="'.BASE_URL.'/login" style="
															text-decoration: none !important;
															text-decoration-color: #f31828;
															font-weight: 500;
															color: #fff;
															padding: 12px 15px;
															font-size: 14px;">Login</a>
															</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td style="height:25px;">&nbsp;</td>
											</tr>
											<tr>
												<td class="footer" style="padding: 0 35px;">
													<table width="100%;" style="text-align: center;">
														<tr>
															<td>
																<p
																	style="margin: 0; font-size: 12px;text-align: center; color: #000;">
																	4 Croxted Mews, Croxted Road, London, SE24 9DA</p>
															</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td style="height:30px;">&nbsp;</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td>
										<table width="95%" style="text-align: center;" border="0" align="center" cellpadding="0" cellspacing="0">
											<tr>
												<td style="height:20px;">&nbsp;</td>
											</tr>
											<tr>
												<td>
													<p
														style="font-size:12px; color:#000; line-height:18px; margin:0 0 0; text-align: center;">
														© '.$year.' Copyright <a style="color: #f31828;"
															href="https://www.polimapper.co.uk">Polimapper</a> All
														rights
														reserved.
													</p>
												</td>
											</tr>
											<tr>
												<td style="height:25px;">&nbsp;</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</body>
			
			</html>';
			$header =  'MIME-Version: 1.0' . "\r\n"; 
			$header .= 'From: Polimapper <info@polimapper.co.uk>' . "\r\n";
			$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$userMail = $this->sendEmail($emailuserclient,$subjectUser,$txt,$header); 
			$adminMail = $this->sendEmail($adminEmail,$subjectUser,$txt,$header);

			$_SESSION["success_msg"]='Client approved successfully.';
			header('Location:'. BASE_URL.'clients/');
		}
	}
	function suspendclients(){
		if($_GET['id']){
			$id=$_GET['id'];
			$active=$this->model->suspendClient($id);
			$_SESSION["success_msg"]='Client suspended successfully.';
			header('Location:'. BASE_URL.'clients/');
		}
	}
	/**************/
	function checkunique(){
		if($_POST['unique_url']){
			$unique_url=$_POST['unique_url'];
			$client_id=$_POST['client_id'];
			if($_POST['unique_url'] == ''){
			$ret=array('status'=>0,'msg'=>'Unique URL can not be empty!');
			echo json_encode($ret);
			exit;
			}else{
				$ckeckunique=$this->model->checkUniqueUrl($unique_url,$client_id);
			
				if(!empty($ckeckunique)){
					$unique_url=$unique_url.'1';
					$ret=array('status'=>0,'msg'=>'Sorry, this Unique url already taken. You can use <strong>'.$unique_url.'</strong> instead. ');
					echo json_encode($ret);
					exit;
				}else{
					$ret=array('status'=>1,'msg'=>'Unique url available, You can use it.');
					echo json_encode($ret);
					exit;
				}
		   }
		}else{
			$ret=array('status'=>0,'msg'=>'Unknown method!');
			echo json_encode($ret);
			exit;	
		}
	}
	/**************/
}
?>