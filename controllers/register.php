<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class Register extends Controller{
	function __construct() {
		parent::__construct();
// 		$this->checkLoggedIn();
	}
	
	function index(){
		$this->view->show('dashboard/register');
	}
	function getPackages(){
	   	$package_list=$this->model->getPackages();
		$packageList=!empty($package_list) ? $package_list : array();
	   $options = '<option disabled selected>Select package</option>';
	   foreach($packageList as $cp){
	        $options .= "<option value=".$cp['id'].">".$cp['name']."</option>";
	   }
	   echo $options;
	}
	
	function UserRegister(){
            //user input value
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $md5_password = md5($_POST['password']);
            $phone = $_POST['phone'];
            $package = $_POST['package'];
            
            $role = "2";
            // company input value
            $cname = $_POST['cname'];
            $cemail = $_POST['cemail'];
            $cphone = $_POST['cphone'];
            
            
            $result=$this->model->getUserByEmail($email);
            $rows = count($result);
            
            if($rows > 0){
            echo json_encode(array(
            'success' => 0,
            'msg' => 'Personal email already exists!',
            'redirect_url' => ''
            )
            );
            }else{
            
            $results=$this->model->insertUser($name,$email,$md5_password,$phone,$role);
 
            if($results){
            
            $last_id = $results;
            $key = 'Hl2018@1212';
            $encrypted_id = openssl_encrypt($last_id,'AES-128-ECB',$key, OPENSSL_RAW_DATA);
            $id = strtolower(bin2hex($encrypted_id));
            
            //     // the message
            $to = $email;
            $subject = "Verify your email";
            // $txt = "Click on this to verify your email. </br>";
            // $txt .= "<p><a href=".BASE_URL."/login/verify_email/".$id.">Click to verify email</a></p>";
            $year = date("Y");
            $txt = '<!doctype html>
<html lang="en-US">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>Reset Password Email Template</title>
    <meta name="description" content="verify Email Template.">
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
                                        ">Dear '.$name.',<br>
                                        </h2>
                                     <p>
You have been registered for a PoliMapper account. To complete the registration process and access your account, simply click on the link below.
                                     </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:30px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <table style="width: 180px;" align="center">
                                            <tr>
                                                <td style="width: 180px;
                                    padding: 15px;
                                    display: block;
                                    background: #f31828; text-align: center;">
                                                    <a href='.BASE_URL.'/login/verify_email/'.$id.' style="
                                                text-decoration: none !important;
                                                text-decoration-color: #f31828;
                                                font-weight: 500;
                                                color: #fff;
                                                padding: 12px 15px;
                                                font-size: 14px;">Click to verify email</a>
                                                </td>
                                            </tr>
                                        </table>
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
                                <!-- <tr>
                                    <td>
                                        <h4 style="font-size: 20px;
                                        color: #000;
                                        margin-bottom: 20px;
                                        margin-top: 10px;font-weight: 600;">Kind Regards,<br>
                                        The PoliMapper team</h4>
                                    </td>
                                </tr> -->
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

$nathantxt = '<!doctype html>
<html lang="en-US">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>Reset Password Email Template</title>
    <meta name="description" content="New user Template.">
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
                                        ">
New User have been registered for a PoliMapper account.
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
            
            
            $header =  'MIME-Version: 1.0' . "\r\n"; 
            $header .= 'From: Polimapper <info@polimapper.co.uk>' . "\r\n";
            $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $retval = $this->sendEmail($email,$subject,$txt,$header);
         
            $adminemail = 'nathan.coyne@polimapper.co.uk';
            $nathansubject = "New User Registered";
              $retval = $this->sendEmail($adminemail,$nathansubject,$nathantxt,$header);
            //template details
            $unique_url = $cname.$last_id;
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
            $register_by = 1;
			$clnt=$this->model->insertClient($cname,$email,$phone,$package,$register_by,$unique_url,$is_mp, $email_sub,$message,$is_social_share,$is_tweet_mp,$is_facebook,$is_insta,$is_twitter,$is_linkedin,$is_email_friend,$tweet_mp_text,$colours);
			
		    $clients = 'a:1:{i:0;s:3:"clientids";}';
		  $clients = str_replace('clientids',$clnt,$clients); 
            $results=$this->model->updateUser($last_id,$clients);
            echo json_encode(array(
            'success' => 1,
            'msg' => 'registred successfully, Check your email for account verifications.',
            'redirect_url' => BASE_URL.'login'
            )); 
            
            
            }else{
            echo json_encode(array(
            'success' => '0',
            'msg' => 'an error occured',
            'redirect_url' => ''
            
            ));
            }
            }
            }
	
}
?>