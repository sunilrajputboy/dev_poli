<?php
/*
  	@project    CSV Visual Mapping  
  	@author     Gianluca Di Battista
  	@copyright  Webmio.it
	@year 		2020
  	@version    1.0.0
  	@file  		Controller.php
  	@site		https://www.csvxlsvisualmapping.com/
*/
if (session_status() === PHP_SESSION_NONE){
    ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session'));
    session_start();
}
require_once($_SERVER["DOCUMENT_ROOT"]."/mailer/vendor/autoload.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class Controller {

	function __construct() {
		$this->view = new View();
	}
	
	public function loadModel($name){
		$path = 'models/'.$name.'_model.php';
		if (file_exists($path))
		{
			require_once 'models/'.$name.'_model.php';
			$modelName = $name. '_Model';
			$this->model = new $modelName();
		}
	}
/************************************/	
	public function checkLoggedIn(){
      if(isset($_SESSION['uid']) && !empty($_SESSION['loggedIn'])){
		  return true;
	  }else{
	    if (isset($_COOKIE['uid_c']) && !empty($_COOKIE['uid_c']) && $_COOKIE['uid_c']>0) {
	       
	        $_SESSION['uid']=$_COOKIE['uid_c'];
	        $_SESSION['loggedIn']=1;
	        $_SESSION['role']=$_COOKIE['role_c'];
	        $_SESSION['email']=$_COOKIE['email_c'];
        } else{
            $url = BASE_URL.'login';
			?>
			<script>
				window.location.href = "<?php echo $url; ?>";
				</script>
			<?php 
// 		header('Location:'. BASE_URL.'login');
		exit();  
        }
	  }
	}
/************************************/	
	public function sendEmail($email,$subject,$body,$toname="",$attachment=""){
		$mail = new PHPMailer();	 
		$mail->isSMTP();                                      // Set mailer to use SMTP
		//$mail->SMTPDebug = 2;
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers  //polimapper.codealearning.co.uk
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'polimappertest@gmail.com';  // SMTP username //info@polimapper.codealearning.co.uk
		$mail->Password = 'dqwfpzhwvovsvver';                           // SMTP password //PTm%1m0Ye3zi
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port =587;                                    // TCP port to connect to
		$mail->From = 'polimappertest@gmail.com';    //smtp@polimapper.co.uk
		$mail->FromName = 'Polimapper';              // pOlimapper2022
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
			return array('status'=>1,'msg'=> 'Message has been sent');
		}
	}
/************************************/
}