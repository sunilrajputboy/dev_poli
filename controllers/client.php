<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class Client extends Controller{
	function __construct() {
		parent::__construct();
		//$this->checkLoggedIn();
	}
	function index(){

	}
	
	function view($unique_url=""){
		if(!empty($unique_url)){
		$result=$this->model->getClientByUniqueUrl($unique_url);
		$userDatass=$result[0];
		$users_list=$this->model->getAllUsers();
		$allUsers=!empty($users_list) ? $users_list : array();
		$packages_list=$this->model->getAllPackages();
		$allPackages=!empty($packages_list) ? $packages_list : array();
		$userdetails=array('clientDatass'=>$userDatass,'allPackages'=>$allPackages,'allUsers'=>$allUsers,'mthis'=>$this);
		$this->view->show('dashboard/client/view',false,$userdetails);
		}else{
			echo json_encode(array('status'=>400,'message'=>'Missing unique URL'));
		}
	}
	/**************/
}
?>