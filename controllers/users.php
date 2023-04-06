<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class Users extends Controller{
	function __construct() {
		parent::__construct();
		$this->checkLoggedIn();
	}
	function index(){
		$userId=$_SESSION['uid'];
		$result=$this->model->getUserDetailsById($userId);
        $userDatass=$result[0];
		define("USERROLE", $userDatass['role']);
		$clients=$this->model->getClients();
		$users=$this->model->getUsers();
		$userdetails=array('clients'=>$clients,'userDatass'=>$userDatass,'users'=>$users,'mthis'=>$this);
		if(USERROLE == 1){
		    
		$this->view->mydashboard('dashboard/users/view',false,$userdetails);
		}else{
		    if($userDatass['allowed_user_add']==1){
		    	$this->view->mydashboard('dashboard/users/user_view',false,$userdetails);
		    }else{
		         header('Location:'. BASE_URL.'dashboard');
		    }
		}
	}
	
	function view(){
			$userId=$_SESSION['uid'];
		$result=$this->model->getUserDetailsById($userId);
        $userDatass=$result[0];
		define("USERROLE", $userDatass['role']);
		$clients=$this->model->getClients();
		$users=$this->model->getUsers();
		$userdetails=array('clients'=>$clients,'userDatass'=>$userDatass,'users'=>$users,'mthis'=>$this);
	
	}
	
	function add(){
		$userId=$_SESSION['uid'];
		$result=$this->model->getUserDetailsById($userId);
		$userDatass=$result[0];
		define("USERROLE", $userDatass['role']);
		$clients=$this->model->getClients();
		$userdetails=array('userDatass'=>$userDatass,'clients'=>$clients,'userDatass'=>$userDatass,'mthis'=>$this);
	
			if(USERROLE == 1){
		$this->view->mydashboard('dashboard/users/add',false,$userdetails);
		} else{
		     if($userDatass['allowed_user_add']==1){
		    	$this->view->mydashboard('dashboard/users/add',false,$userdetails);
		    }else{
		         header('Location:'. BASE_URL.'dashboard');
		    }
		    }
	}
	function addusers(){
		if($_POST['name']){
			$uname = $_POST['name'];
			$email = $_POST['email'];
			$password = md5($_POST['password']);
			$clients = $_POST['client'];
			if($clients != null){
				$clients = serialize($_POST['client']);
				}
			$phone = $_POST['phone']; 
			$checkEmail=$this->model->getUserByEmail($email);
			 if(!empty($checkEmail)){
				 echo json_encode(array( 'success' => 0, 'msg' => 'Email already exists'));
				 }else{
					 $insert=$this->model->insertUser($uname,$email,$password,$phone,$clients);
					
						$to = $email;
						$pass = $_POST['password'];
						$subject = "Login details for polimappper";
				// 		$txt = "Your login details";
				// 		$txt .= "<h2>User: $email</h2>";
				// 		$txt .= "<h2>Password: $pass</h2>";
                $year = date("Y");
				$txt = '<!doctype html>
                <html lang="en-US">
                
                <head>
                    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
                    <title>Login details Template</title>
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
                                                        ">Your login details.
                                                        </h2>
                                                        <p>User: '.$email.'</p>
                                                        <p>Password: '.$pass.'</p>
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
                                                            © '. $year.' Copyright <a style="color: #f31828;"
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
A new user has been registered for a PoliMapper account. 
                                        </h2>
                                    </td>
                                </tr>
                                 <tr>
                                    <td style="padding:0 35px;">
                                        <h2 style="
                                            font-size: 25px;
                                            color: #000;
                                            margin-bottom: 20px;
                                            margin-top: 20px;
                                            font-weight: 600
                                        ">New User login details.
                                        </h2>
                                        <p>User: '.$email.'</p>
						                <p>Password: '.$pass.'</p>
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
                                            © '. $year.' Copyright <a style="color: #f31828;"
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
                        $retval = $this->sendEmail($to,$subject,$txt,$header);
                          
            $adminemail = 'nathan.coyne@polimapper.co.uk';
            $nathansubject = "New User Registered";
              $retval = $this->sendEmail($adminemail,$nathansubject,$nathantxt,$header);
						   
					if($insert){
						    $_SESSION["success_msg"]='User added successfully.';
							echo json_encode(array('success' => 1,'msg' => 'User added successfully.','redirect_url'=>  BASE_URL.'users'));
                        }else{
							$_SESSION["error_msg"]='Unknown error occured';
							echo json_encode(array('success' => 0,'msg' => 'Unknown error occured'));  
                        } 
				 }
		}else{
			echo json_encode(array('success' => 0,'msg' => 'Unknown method')); 
		}
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
		$this->view->mydashboard('dashboard/users/edit',false,$userdetails);
	}
	function update(){
		if($_POST['name']){
			$userId = $_POST['id'];
			$uname = $_POST['name'];
			$email = $_POST['email'];
			if($_POST['password'] != null){
			$password = md5($_POST['password']);
			}else{
			$password = $_POST['old_password'];
			}
			$clients = $_POST['client'];
			if($clients != null){
				$clients = serialize($_POST['client']);
				}
			$phone = $_POST['phone']; 
			$checkEmail=$this->model->getUserByEmailId($email,$userId);
			 if(!empty($checkEmail)){
				 echo json_encode(array( 'success' => 0, 'msg' => 'Email already exists'));
				 }else{
					 $insert=$this->model->updateUser($userId,$uname,$email,$password,$phone,$clients);

	if($_POST['password'] != null){
			//here
				$to = $email;
						$pass = $_POST['password'];
						$subject = "Login details for polimappper";
                        $year = date("Y");
						$txt = '<!doctype html>
<html lang="en-US">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>Login details Template</title>
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
                                        ">Your login details.
                                        </h2>
                                        <p>User: '.$email.'</p>
						                <p>Password: '.$pass.'</p>
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
                        $retval = $this->sendEmail($to,$subject,$txt,$header);
                    //   print_r($retval);
                    //     exit;
			}else{
			//
			}
					
					if($insert){
						    $_SESSION["success_msg"]='User updated successfully.';
							echo json_encode(array('success' => 1,'msg' => 'User updated successfully.','redirect_url'=>  ''));
                        }else{
							$_SESSION["error_msg"]='Unknown error occured.';
							echo json_encode(array('success' => 0,'msg' => 'Unknown error occured'));  
                        } 
				 }
		}else{
			echo json_encode(array('success' => 0,'msg' => 'Unknown method')); 
		}
	}
	
	function delete($userId){
		$delete=$this->model->deleteUser($userId);
		$_SESSION["success_msg"]='User deleted successfully.';
		header('Location:'. BASE_URL.'users/');
	}
	function activeusers($userId){
		$delete=$this->model->activeUser($userId);
		$_SESSION["success_msg"]='User activated successfully.';
		header('Location:'. BASE_URL.'users/');
	}
	function suspendusers($userId){
		$delete=$this->model->suspendUser($userId);
		$_SESSION["success_msg"]='User suspended successfully.';
		header('Location:'. BASE_URL.'users/');
	}
	function allowclientprivilage($userId){
		$delete=$this->model->allowClientPrivilage($userId);
		$_SESSION["success_msg"]='Client privilage added successfully.';
		header('Location:'. BASE_URL.'users/');
	}
	function disallowclientprivilage($userId){
		$delete=$this->model->disallowClientPrivilage($userId);
		$_SESSION["success_msg"]='Client privilage changed successfully.';
		header('Location:'. BASE_URL.'users/');
	}
	function allowuserprivilage($userId){
		$delete=$this->model->allowUserPrivilage($userId);
		$_SESSION["success_msg"]='User privilage changed successfully.';
		header('Location:'. BASE_URL.'users/');
	}
	function disallowuserprivilage($userId){
		$delete=$this->model->disallowUserPrivilage($userId);
		$_SESSION["success_msg"]='User privilage changed successfully.';
		header('Location:'. BASE_URL.'users/');
	}
	function clientfilter(){
		if(isset($_POST['clientId'])){
		$cid = $_POST['clientId'];
			if($cid != 'all' && $cid != 'orphan'){
				$_SESSION['cid'] = $cid;
			}else if($cid == 'all'){
			   unset($_SESSION['cid']);
			}else if($cid == 'orphan'){
			   $_SESSION['cid'] = 'orphan'; 
			}
		echo json_encode(array('success' => 1));
		}else{
		echo json_encode(array('success' => 0,'msg'=>'Unknown method'));	
		}

	}
}
?>