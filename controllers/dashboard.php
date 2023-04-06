<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class Dashboard extends Controller{
	function __construct() {
		parent::__construct();
		$this->checkLoggedIn();
	}
// 	function index(){
// 	    header('Location:'. BASE_URL.'login');
// 	//$this->view->show('dashboard/login');
// 	//exit();
// 	}
	
	function index(){
		$userId=$_SESSION['uid'];
		$result=$this->model->getUserDetailsById($userId);
        $userDatass=$result[0];
		define("USERROLE", $userDatass['role']);
		$alldataclient=array();
		$clientData=array();
		if(isset($_SESSION['cid']) && $_SESSION['cid'] != null){
			$cid = $_SESSION['cid'];
			$getsingleclient = $this->model->selectClienById($cid);
			if(!empty($getsingleclient)){
				$clientData=$getsingleclient[0];
				if($clientData['is_suspended']!= 0){ unset($_SESSION['cid']); }
			}
		}
		$companyData = $userDatass['clients'];

		if($companyData != null){
			$ids = implode(",",unserialize($companyData));
			$alldataclient=$this->model->selectAllData('clients',"`id` IN (".$ids.")"); 
			if(!empty($alldataclient)){
                foreach($alldataclient as $clientDatas){
                if($clientDatas['is_suspended'] != 1){
                     $_SESSION['cid'] = $clientDatas['id'];
                }
            } } 
		}
						 
		$visitorCount=0;
		$ClientCount=0;
		$UserCount=0;
		$ProjectCount=0;
		$visitors=$this->model->selectVisitorCounter(); 
		$clientC=$this->model->totalClientCount(); 
		$UserC=$this->model->totalUserCount(); 
		$ProjectC=$this->model->totalProjectCount(); 
		if(!empty($clientC)){ $ClientCount=$clientC[0]['clientCount']; }
		if(!empty($UserC)){ $UserCount=$UserC[0]['userCount']-1; }
		if(!empty($ProjectC)){ $ProjectCount=$ProjectC[0]['projectCount']; }
		if(!empty($visitors)){ $visitorCount=$visitors[0]['visitor']-1;}
		
		$userdetails=array('userDatass'=>$userDatass,'companyData'=>$companyData,'alldataclient'=>$alldataclient,'visitorCount'=>$visitorCount,'ClientCount'=>$ClientCount,'UserCount'=>$UserCount,'ProjectCount'=>$ProjectCount);
		$this->view->mydashboard('dashboard/dashboard',false,$userdetails);
	}
	
	function check(){
		if($_POST)
        {
		$email = $_POST['email'];
		$core_password = $_POST['password'];
		$password = md5($_POST['password']);
		$remember = $_POST['remember_me'];
		$timezone = $_POST['timezone'];
		//$result=$this->model->getAllWhere('users',array('email'=>$email,'password'=>$password));
		//print_r($result);
		
		}else
        {
			$result=array('success'=>0,'msg'=>'Unknown method.');
			echo json_encode($result);
            exit();
        }
	}
	function sendmailadmin(){

        $userName = $_POST['uname'];
        $userEmail = $_POST['email'];
        $userPhone = $_POST['phone'];
        $title = $_POST['title'];
        $message = $_POST['message'];
        
        $subject='Request for '.$title;
        $year = date("Y");
        	$txt = '<!doctype html>
<html lang="en-US">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>Login details Template</title>
    <meta name="description" content="'.$title.'">
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
                            <a href="https://visualisation.polimapper.co.uk/login" title="logo" target="_blank">
                                <img width="200"
                                    src="https://visualisation.polimapper.co.uk/public/assets/img/polimapper-logo.png"
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
                                        ">Hello Admin,Please check this new request for <strong>'.$title.'</strong></h2>
						                <p> User Name-' . $userName.'</p>
                                          <p>  User Email-' . $userEmail.'</p>
                                           <p> User Phone-' . $userPhone.'</p>
                                           <p>'.$message.'</p>
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

$nathanemail = "nathan.coyne@polimapper.co.uk";
        $header =  'MIME-Version: 1.0' . "\r\n"; 
        $header .= 'From: Polimapper <info@polimapper.co.uk>' . "\r\n";
        $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $retval = $this->sendEmail($nathanemail,$subject,$txt,$header);
        
        echo json_encode(array('success' => 1,'msg' => 'Mail sent successfully.'));
	}
}
?>