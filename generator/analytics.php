<?php
error_reporting(1);
$origin = $_SERVER['HTTP_ORIGIN'];
require_once($_SERVER["DOCUMENT_ROOT"]."/mailer/vendor/autoload.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class Srclasss {
	
	private function dbConnect(){
	   //  $conn = new mysqli('localhost', 'visualis_polimapper', '[TIv%(WBCDrA', 'visualis_polimapper');
		$conn = new mysqli('localhost', 'visualisationpol_stage', 'visualisationpol_stage', 'visualisationpol_stage');
		 if(!$conn){
			die("Connection failed: " . mysqli_connect_error());
		   }
		   return $conn;
	 }
     public function ADDemailMpAnalyticsEntry($email,$name,$mobile,$mp,$mp_email,$signuptime,$pro_key)
     {
        $connection=$this->dbConnect();  
		$query = "INSERT INTO `improve_analytics`(`event_id`,`pro_key`, `user_email`, `user_name`,`mobile`, `mp_name`, `mp_email`, `signuptime`, `confirm`, `confirmtime`) VALUES ('6','$pro_key','$email','$name','$mobile','$mp','$mp_email','$signuptime','false',null)";
		$result = $connection->query($query);
		return $connection->insert_id;
     }
     public function ADDtweetAnalyticsEntry($mp,$mp_email,$signuptime,$pro_key)
     {
        $connection=$this->dbConnect();  
		$query = "INSERT INTO `improve_analytics`(`event_id`,`pro_key`, `user_email`, `user_name`, `mp_name`, `mp_email`, `signuptime`, `confirm`, `confirmtime`) VALUES ('5','$pro_key',null,null,'$mp','$mp_email','$signuptime',null,null)";
		$result = $connection->query($query);
		return $connection->insert_id;
     }

     public function sendEmail($email,$subject,$body,$toname="",$clientName,$attachment=""){
		$mail = new PHPMailer();	 
		$mail->isSMTP();                                      // Set mailer to use SMTP
// 		$mail->SMTPDebug = 2;
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers  //polimapper.codealearning.co.uk
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'polimappertest@gmail.com';  // SMTP username //info@polimapper.codealearning.co.uk
		$mail->Password = 'dqwfpzhwvovsvver';                           // SMTP password //PTm%1m0Ye3zi
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port =587;                                    // TCP port to connect to
        $mail->From = 'polimappertest@gmail.com';    //smtp@polimapper.co.uk
		$mail->FromName = $clientName;              // pOlimapper2022
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
            return json_encode(array('status'=>1,'msg'=>'Message has been sent', 'data'=>$mail));
			// return array('status'=>1,'msg'=> 'Message has been sent'.$mail);
		}
	}
     public function confirmSubscribe($id,$confirmtime)
     {
        $connection=$this->dbConnect();  
		$query = "UPDATE `improve_analytics` SET `confirm`= 'true',`confirmtime`='$confirmtime' WHERE `id`='$id'";
		$result = $connection->query($query);
		return $result;
     }
	 
}
$srObject= new Srclasss();
if(isset($_POST['mp_email'])){
     $email = $_POST['email'];
       $mobile = $_POST['mobile'];
     $name = $_POST['name'];
     $mp = $_POST['mp'];
     $mp_email = $_POST['mp_email'];
     $signuptime = date('Y-m-d H:i:s');
     $pro_key = $_POST['pro_key'];
     $insert_id=$srObject->ADDemailMpAnalyticsEntry($email,$name,$mobile,$mp,$mp_email,$signuptime,$pro_key);
     $id = $insert_id;
     $subscribe_mailing = $_POST['subscribe_mailing'];
     $to = $email;
     $subject = "Confirm your subscription";
     $year = date("Y");
     $subscribe_mail_text = $_POST['subscribe_mail_text'];
     $clientName = $_POST['clientName'] ? $_POST['clientName'] : 'Polimapper';
        define('BASE_URL', 'https://stage.visualisation.polimapper.co.uk/');
        $base_url = BASE_URL;
        if(isset($_POST['logo']) && $_POST['logo']){
            $logourl = $_POST['logo'];
        }else{
            $logourl = $base_url.'public/assets/img/polimapper-logo.png';
        }
        
        if(isset($_POST['subscribe_mail_address']) && $_POST['subscribe_mail_address']){
            $subscribe_mail_address = $_POST['subscribe_mail_address'];
        }else{
            $subscribe_mail_address = '4 Croxted Mews, Croxted Road, London, SE24 9DA';
        }
        
        if(isset($_POST['copyright_title']) && $_POST['copyright_title']){
            $copyright_title = $_POST['copyright_title'];
        }else{
            $copyright_title = 'Polimapper';
        }
        if(isset($_POST['copyright_link']) && $_POST['copyright_link']){
            $copyright_link = $_POST['copyright_link'];
        }else{
            $copyright_link = 'https://www.polimapper.co.uk';
        }

     if($subscribe_mailing == true){
             $text = '<!doctype html>
             <html lang="en-US">
             <head>
                 <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
                 <title>Confirm your subscription</title>
                 <meta name="description" content="Confirm your subscription Template.">
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
                                         <a href="'.$base_url.'login" title="logo" target="_blank">
                                             <img width="200" src="'.($logourl).'"
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
                                                     <p style="
                                                         font-size: 25px;
                                                         color: #000;
                                                         margin-bottom: 20px;
                                                         margin-top: 20px;
                                                     ">'.$subscribe_mail_text.'
                                                     </p>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td style="height:30px;">&nbsp;</td>
                                             </tr>
                                             <tr>
                                                 <td>
                                                     <a href="'.$base_url.'generator/analytics.php?id='.$id.'&logo='.$logourl.'&cl='.$copyright_link.'&ct='.$copyright_title.'&clientName='.$clientName.'&address='.$subscribe_mail_address.'" style="
                                                     font-size: 16px;
                                                     text-decoration: none;
                                                     background: #f31828;
                                                     min-width: 130px;
                                                     width: 130px;
                                                     display: inline-block;
                                                     color: #fff;
                                                     border-radius: 5px;
                                                     font-weight: 600;
                                                     height: 45px;
                                                     padding: 10px 15px;
                                                     line-height: 25px;
                                                    box-sizing: border-box;
                                                     ">Confirm</a>
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
                                                                 <p
                                                                     style="margin: 0; font-size: 12px;text-align: center; color: #000;">
                                                                     '.$subscribe_mail_address.'</p>
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
                                                         © '. $year.' Copyright <a style="color: #f31828;"
                                                             href="'.$copyright_link.'">'.$copyright_title.'</a> All
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
             $header .= 'From: '.$clientName.' <info@polimapper.co.uk>' . "\r\n";
             $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
             $retval = $srObject->sendEmail($to,$subject,$text,$header,$clientName);
             if($retval){
                echo json_encode(array('status'=>1,'message'=>'Mail has been sent.'));
            }else{
                echo json_encode(array('status'=>0,'message'=>$retval));
            }
     }
     if($insert_id){
             echo json_encode(array('status'=>1,'message'=>'success'));
         }else{
             echo json_encode(array('status'=>0,'message'=>'something went wrong'));
         }
}

if(isset($_GET['id'])){
        // confirm 
        $id = $_GET['id'];
    $confirmtime = date('Y-m-d H:i:s');
    $confirm=$srObject->confirmSubscribe($id,$confirmtime);
    define('BASE_URL', 'https://stage.visualisation.polimapper.co.uk/');
$base_url = BASE_URL;
$logourl = $_GET['logo'];
$copyright_link = $_GET['cl'];
$copyright_title = $_GET['ct'];
$clientName = $_GET['clientName'];
$address = $_GET['address'];

if($confirm){
    // echo json_encode(array('status'=>1,'message'=>'confirmed success'));
    
    ?>
       <!doctype html>
                <html lang="en-US">
                
                <head>
                    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
                    <title>Thank You</title>
                    <meta name="description" content="thank you Email Template.">
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
                                            <a href="<?php echo $base_url; ?>/login" title="logo" target="_blank">
                                                <img width="200"
                                                    src="<?php echo $logourl; ?>"
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
                                                        <p style="
                                                            font-size: 25px;
                                                            color: #000;
                                                            margin-bottom: 20px;
                                                            margin-top: 20px;
                                                        ">Thank you for confirming your subscriptions.
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="height:30px;">&nbsp;</td>
                                                </tr>
                                                <!--<tr>-->
                                                <!--    <td>-->
                                                <!--        <a href="<?php // echo $base_url; ?>/login" style="-->
                                                <!--        font-size: 16px;-->
                                                <!--        text-decoration: none;-->
                                                <!--        background: #f31828;-->
                                                <!--        min-width: 130px;-->
                                                <!--        display: inline-block;-->
                                                <!--        color: #fff;-->
                                                <!--        border-radius: 5px;-->
                                                <!--        font-weight: 600;-->
                                                <!--        height: 45px;-->
                                                <!--        line-height: 45px;-->
                                                <!--        ">Go To Login</a>-->
                                                <!--    </td>-->
                                                <!--</tr>-->
                                                <!--<tr>-->
                                                <!--    <td style="height:25px;">&nbsp;</td>-->
                                                <!--</tr>-->
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
                                                                    <p
                                                                        style="margin: 0; font-size: 12px;text-align: center; color: #000;">
                                                                        <?php echo $address; ?></p>
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
                                                            © <?php echo $year; ?> Copyright <a style="color: #f31828;"
                                                                href="<?php echo $copyright_link; ?>"><?php echo $copyright_title ?></a> All
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
                
                </html>
     <script>
    // location.href = '<?php //echo $base_url; ?>login';
    // </script>
    <?php
}else{
    echo json_encode(array('status'=>0,'message'=>'something went wrong'));
}
}


if(isset($_POST['tweet_mp_name'])){

    $mp = $_POST['tweet_mp_name'];
    $signuptime = date('Y-m-d H:i:s');
    $pro_key = $_POST['pro_key'];
    $mp_email = $_POST['tweet_mp_email'];
    $entry=$srObject->ADDtweetAnalyticsEntry($mp,$mp_email,$signuptime,$pro_key);
    if($entry){
        echo json_encode(array('status'=>1,'message'=>'success'));
    }else{
        echo json_encode(array('status'=>0,'message'=>'something went wrong'));
    }
}

/*************/


?>