<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/mailer/vendor/autoload.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class Forgotpassword extends Controller{
	function __construct() {
		parent::__construct();
	}
	
	function index(){
		$this->view->show('dashboard/forgotpassword');
	}
	function forgotfunctions(){
	    if(isset($_POST["email"])){
	        
            $email = $_POST["email"];
            $row=$this->model->getuserByemail($email);
			if(empty($row)){
				echo json_encode(array('success' => 0,'msg' => 'email address does not match.','redirect_url' => ''));
				die();
			}
            $data = $row[0];
            $row1 = count($row);
            if($row1 == 1){
            $id = $data['id'];
            $to = $email;
            $subject = "Reset password on polimapper";
            // $txt = "<h2>Hello ".$data['name']." , </h2><p> Click on this to reset your password. </p>";
            // $txt .= "<p><a href=".BASE_URL."forgotpassword/resetpassword?id=$id>Click to reset password</a></p>";
            $year = date("Y");

            $txt ='<!doctype html>
<html lang="en-US">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>Reset Password Email Template</title>
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
                            <a href="'.BASE_URL.'" title="logo" target="_blank">
                                <img src="https://visualisation.polimapper.co.uk/public/assets/img/polimapper-logo.png" width="200" title="logo" alt="logo">
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
                                        ">Hi,
                                            <span>'.$data['name'].'</span>
                                        </h2>
                                        <p style="margin:0;font-size: 15px; color: #000;">
                                            We have received a request to reset the password on your account. If the request came from you, please click on the link below. Otherwise please disregard this email.
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:30px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <table style="width: 150px;" align="center">
                                            <tr>
                                                <td style="width: 150px;
                                    padding: 15px;
                                    display: block;
                                    background: #f31828; text-align: center;">
                                                    <a href='.BASE_URL.'forgotpassword/resetpassword?id='.$id.' style="
                                                text-decoration: none !important;
                                                text-decoration-color: #f31828;
                                                font-weight: 500;
                                                color: #fff;
                                                padding: 12px 15px;
                                                font-size: 14px;">Reset Password</a>
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
                                                href="https://visualisation.polimapper.co.uk/login">Polimapper</a> All
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
            $header .= 'From: Your name <info@polimapper.co.uk>' . "\r\n";
            $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            //$retval = $this->sendEmail($to,$subject,$txt,$header);
            $retval = $this->sendSMTPemail($to,$subject,$txt,$data['name']);
			
				 echo json_encode(array('success' => 1,'msg' => 'Link sent successfully.','redirect_url' => '','d'=>$retval)); 
            }else{
                 echo json_encode(array('success' => 0,'msg' => 'email address does not match.','redirect_url' => ''));
            }
	    }
            else{
            echo json_encode(array('success' => 0,'msg' => 'Something went wrong!','redirect_url' => ''));
            }
	}
	function resetpassword(){
		    $id = $_GET['id'];
		   $userdetails=array('id'=>$id);	
			$this->view->show('dashboard/resetpassword',false,$userdetails);
	}
	
	
	function newpass(){
	    
        $pass = md5($_POST['password']);
        $id = $_POST['id'];
        
        $update=$this->model->addnewpassword($pass,$id);
      
        if($update){
        
        echo json_encode(array(
        'success' => 1,
        'msg' => 'Reset password successfully.',
        'redirect_url' => BASE_URL.'login'
        )); 
        }else{
        echo json_encode(array(
        'success' => 0,
        'msg' => 'Something went wrong!',
        'redirect_url' => ''
        ));
        }
        }
	/****************************/	
	/****************************/	
	/****************************/	
	public function sendSMTPemail($email,$subject,$body,$toname="",$attachment=""){
		$mail = new PHPMailer();	 
		$mail->isSMTP();                                      // Set mailer to use SMTP
		//$mail->SMTPDebug = 2;
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers  //polimapper.codealearning.co.uk
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'polimappertest@gmail.com';  // SMTP username //info@polimapper.codealearning.co.uk
		$mail->Password = 'dqwfpzhwvovsvver';                           // SMTP password //PTm%1m0Ye3zi
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port =587;                                    // TCP port to connect to
		$mail->From = 'polimappertest@gmail.com';
		$mail->FromName = 'Polimapper';
		$mail->addAddress($email, $toname);
		$mail->addReplyTo('info@polimapper.co.uk', 'Polimapper');
		$mail->WordWrap = 50;
		if(!empty($attachment)){
		$mail->addAttachment($attachment);
		}
		$mail->isHTML(true);
		$mail->CharSet = "text/html; charset=UTF-8;";
		$mail->Subject = $subject;
		$mail->Body    = $body;
	    $ems_resp=$mail->send();
		if(!$ems_resp) {
			return array('status'=>0,'msg'=> 'Mailer Error: ' . $mail->ErrorInfo);
		} else {
			return array('status'=>1,'msg'=> 'Email has been sent','m'=>$ems_resp);
		}
}	
		
	
}
?>