<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class Login extends Controller{
	function __construct() {
		parent::__construct();
	}
/************LOGIN*********/
	function index(){
	    if(isset($_SESSION['uid'])){
				header('Location:'. BASE_URL.'dashboard');
	    }else{
		$this->view->show('dashboard/login');
	    }
		exit();	
	}
/************SIGNIN*********/
	function signin(){
		if($_POST)
        {
		$email = $_POST['email'];
		$core_password = $_POST['password'];
		$password = md5($_POST['password']);
		$remember = isset($_POST['remember_me']) ?  1 : 0;
		$timezone = $_POST['timezone'];
		if(isset($_COOKIE["member_username"])){
		$results=$this->model->checkAuth($email,$password);
		}else{
		$results=$this->model->checkAuth($email,$password);	
		}
		if(!empty($results)){
			$result=$results[0];
			if(!empty($remember)){
		    $current_time = time();
			$current_date = date("Y-m-d H:i:s", $current_time);
			$cookie_expiration_time = $current_time + (30 * 24 * 60 * 60);  // for 1 month
            setcookie("member_username", $email, $cookie_expiration_time,"/");
            setcookie("member_password", $core_password, $cookie_expiration_time,"/");
            
			}
			if($result['verify'] == 1){
				 if($result['suspended'] != 1){
				$_SESSION['uid'] = $result['id'];
			    $_SESSION['email'] = $result['email'];
			    $_SESSION['role'] = $result['role'];
			    $_SESSION['loggedIn'] = 1;
			    $_SESSION['cid'] =null;
			    
$cookie_name = "uid_c";
$cookie_value = $result['id'];
$cookieExpirationTime = time()+3600;  // for 1 hour
setcookie($cookie_name, $cookie_value, $cookieExpirationTime, "/");

$cookie_name = "email_c";
$cookie_value = $result['email'];
setcookie($cookie_name, $cookie_value, $cookieExpirationTime, "/");

$cookie_name = "role_c";
$cookie_value = $result['role'];
setcookie($cookie_name, $cookie_value, $cookieExpirationTime, "/");

			    $lid = $result['id'];
			    $timezone_name = timezone_name_from_abbr("", $timezone*60, false);
			    date_default_timezone_set($timezone_name);
				$now = new DateTime();
				$date = $now->format('d-m-Y H:i:s');
				$this->model->updateLastLogin($date,$lid);
				$resultss=array('success'=>1,'msg'=>'You are successfully logged in.','redirect_url'=>BASE_URL.'dashboard');
				$_SESSION['unblock_time']="";
				$_SESSION['failed_login']=0;
				unset($_SESSION["unblock_time"]);
				unset($_SESSION["failed_login"]);
				echo json_encode($resultss);
				exit();	
				 }else{
					$resultss=array('success'=>0,'msg'=>'Your account has been suspended.','redirect_url'=>'');
					echo json_encode($resultss);
					exit();	 
				 }
			}else{
			$resultss=array('success'=>0,'msg'=>'Please verify your email.','redirect_url'=>'');
			echo json_encode($resultss);
            exit();
			}
		}else{
			if (empty($_SESSION['failed_login'])){$_SESSION['failed_login'] = 1;} 
			elseif (isset($_POST['email'])){ $_SESSION['failed_login']++;}
			if ($_SESSION['failed_login'] > 5) {
				$_SESSION['unblock_time']=date("Y-m-d H:i:s", strtotime("+10 minutes"));
				
				$resultss=array('success'=>0,'msg'=>'You are blocked for 10 minutes in this device. ','redirect_url'=>'https://stage.visualisation.polimapper.co.uk/login');
				echo json_encode($resultss);
				exit();
				}
			$resultss=array('success'=>0,'msg'=>'Wrong username or password.','redirect_url'=>'');
			echo json_encode($resultss);
            exit();
		}
		}else
        {
			$result=array('success'=>0,'msg'=>'Unknown Method.','redirect_url'=>'');
			echo json_encode($result);
            exit();
        }
	}
	function restartLogin(){
		if(isset($_SESSION['unblock_time']) && strtotime($_SESSION['unblock_time']) < strtotime(date('Y-m-d H:i:s'))){
			$_SESSION['unblock_time']="";
			$_SESSION['failed_login']=0;
			unset($_SESSION["unblock_time"]);
			unset($_SESSION["failed_login"]);
			header('Location:'. BASE_URL.'login');
		}else{
			echo "HELLO";
		}
	}	
/************VERIFY*********/
	function verify_email($token){
            if($token){
            $key = 'Hl2018@1212';
            $id = openssl_decrypt(hex2bin($token), 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
            
			$sqlGetuser = $this->model->getUsers($id);
            $userData=!empty($sqlGetuser) ? $sqlGetuser[0] : array();
           
           	$adminData1 = $this->model->getUsers(1);
			$adminData=!empty($adminData1) ? $adminData1[0] : array();
			
            if($userData){
            if($userData['verify'] == 1){
            echo '<h2>Link expired</h2>';
            
            }else{
           	$result = $this->model->verifyEmail($id);
            if($result){
                $username = $userData['name'];
            $email = $userData['email'];
            $adminEmail = $adminData['email'];
            $userEmail = $email;
            $subjectAdmin = "User registered.";
            $subjectUser = "You are registered successfully.";
            $year = date("Y");
            
              $txtUser = '<!doctype html>
<html lang="en-US">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>Verify Template</title>
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
                                        ">Hi '.$username.',<br>
                                        </h2>
                                        <p style="color: #000; font-size: 15px; line-height: 21px; ">
Your email address has been successfully verified and you may now access your PoliMapper account. Please click on the link below to start creating maps!.
                                        </p>
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
                                        <table style="width: 150px;" align="center">
                                            <tr>
                                                <td style="width: 160px;
                                    padding: 15px;
                                    display: block;
                                    background: #f31828; text-align: center;">
                                                    <a href="'.BASE_URL.'login" style="
                                                text-decoration: none !important;
                                                text-decoration-color: #f31828;
                                                font-weight: 500;
                                                color: #fff;
                                                padding: 12px 15px;
                                                font-size: 14px;">Login to PoliMapper</a>
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
                                                    <p style="font-size: 14px;
                                                    color: #000;
                                                    margin-bottom: 15px;
                                                    margin-top: 10px;">Kind Regards,<br>
            
            The PoliMapper team</p>
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
            $txtAdmin = '<!doctype html>
<html lang="en-US">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>Signup Template</title>
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
                                        ">Hi new user,
                                            <span>'.$email.'</span> is signup successfully.
                                        </h2>
                                    </td>
                                </tr>
                                <tr>
                                <td style="height:30px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="'.BASE_URL.'/login" style="
                                    font-size: 16px;
                                    text-decoration: none;
                                    background: #f31828;
                                    min-width: 130px;
                                    display: inline-block;
                                    color: #fff;
                                    border-radius: 5px;
                                    font-weight: 600;
                                    height: 45px;
                                    line-height: 45px;
                                    ">Login</a>
                                </td>
                            </tr>
                            <tr>
                                <td style="height:25px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="margin:0 100px ;">
                                        <p style="margin:0; border-top: 1px solid #f2f3f8;">&nbsp;</p>
                                    </div>
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
			$userMail = $this->sendEmail($userEmail,$subjectUser,$txtUser,$header); 
			$adminMail = $this->sendEmail($adminEmail,$subjectAdmin,$txtAdmin,$header);

            }
            	header('Location:'. BASE_URL.'login');
           
            }
            }
            
            }else{
                echo "something went wrong.";
            }
		
	}
}
?>