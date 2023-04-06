<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class Packages extends Controller{
	function __construct() {
		parent::__construct();
		$this->checkLoggedIn();
	}
	function index(){
		$userId=$_SESSION['uid'];
		$result=$this->model->getUserDetailsById($userId);
		$userDatass=$result[0];
		define("USERROLE", $userDatass['role']);
		$package_list=$this->model->getPackages();
		$packageList=!empty($package_list) ? $package_list : array();
		 $allMaptemplates=$this->model->getMapTemplates();
	   $maptemplates=!empty($allMaptemplates) ? $allMaptemplates : array();
		$userdetails=array('packageList'=>$packageList,'maptemplates'=>$maptemplates,'userDatass'=>$userDatass,'mthis'=>$this);
		$this->view->mydashboard('dashboard/packages/view',false,$userdetails);
	}
	
	
	function delete(){
		$userId=$_SESSION['uid'];
		$id=$_GET['id'];
		$result=$this->model->deletePackageById($id);
		$_SESSION["success_msg"]='Package deleted successfully.';
        header('Location:'. BASE_URL.'packages/');
	}
	
	function hidepackage(){
		$id=$_GET['id'];
		$result=$this->model->hidePackageById($id);
        header('Location:'. BASE_URL.'packages/');
	}
	
	function packagesclient(){
            $pid = $_POST['pid'];
            $packageData=$this->model->getClientBypackageId($pid);
            foreach($packageData as $pdata){
            ?>
            <li>
            <i class="fa fa-user-plus"></i> <?php echo $pdata['name']; ?>
            <!--$count.'. ' .-->
            </li>
            <?php 
            }
            }
	
	function showpackage(){
		$userId=$_SESSION['uid'];
		$id=$_GET['id'];
		$result=$this->model->showPackageById($id);
		$_SESSION["success_msg"]='Package status changed successfully.';
        header('Location:'. BASE_URL.'packages/');
	}
	function add(){
	   $userId=$_SESSION['uid'];
	   $result=$this->model->getUserDetailsById($userId);
	   $userDatass=$result[0];
	   define("USERROLE", $userDatass['role']);
	   $allMaptemplateCategory=$this->model->getMapTemplateCategory();
	   $maptemplates=array();
	   $cat_array=array();
	   if(!empty($allMaptemplateCategory)){
		   foreach($allMaptemplateCategory as $cat){
			   $cat_array['category_name']=$cat['category_name'];
			   $allMaptemplates=$this->model->getMapTemplatesByCategory($cat['id']);
			   $cat_array['template_list']=!empty($allMaptemplates) ? $allMaptemplates : array();
			   $maptemplates[]=$cat_array;
		   }
	   }
	   $userdetails=array('maptemplates'=>$maptemplates,'userDatass'=>$userDatass,'mthis'=>$this);
       $this->view->mydashboard('dashboard/packages/add',false,$userdetails);
	}
function insertpackage(){
		if(isset($_POST['submit'])){
		$pname = $_POST['name'];
		$no_allowed_user = $_POST['no_allowed_user'];
		$no_allowed_projects = $_POST['no_allowed_projects'];
		$no_allowed_map = $_POST['no_allowed_map'];
		$is_logo= $_POST['is_logo'];
		$is_charts = $_POST['is_charts'];
		$is_fonts = $_POST['is_fonts'];
		$is_email_mp = $_POST['is_email_mp'];
		$is_social_share = $_POST['is_social_share'];
		$is_email_share = $_POST['is_email_share'];
		$is_tweet_mp = $_POST['is_tweet_mp'];
			$hide_branding = $_POST['hide_branding'];

		   if($_POST['unlimited_user'] != null){
			  $no_allowed_user = $_POST['unlimited_user'];
		   }
			if($_POST['unlimited_pro'] != null){
			  $no_allowed_projects = $_POST['unlimited_pro'];
		   }
		   
		 if($no_allowed_map != null){
			$no_map_string = implode(",",$no_allowed_map);  
		 }else{
			 $no_map_string = null;
		 }
		 
		 if($is_logo == null){
		   $is_logo = 'no';
		}
		if($is_charts == null){
		   $is_charts = 'no';
		}if($is_fonts == null){
		   $is_fonts = 'no';
		}if($is_email_mp == null){
		   $is_email_mp = 'no';
		}
		if($is_social_share == null){
		   $is_social_share = 'no';
		}
		if($is_email_share == null){
		   $is_email_share = 'no';
		}
		if($is_tweet_mp == null){
		   $is_tweet_mp = 'no';
		}
				if($hide_branding == null){
		   $hide_branding = 'no';
		}
		
		
		$result=$this->model->insertPackage($pname,$no_allowed_user,$no_allowed_projects,$no_map_string,$is_logo,$is_charts,$is_fonts,$is_email_mp,$is_social_share,$is_email_share,$is_tweet_mp,$hide_branding);
		$msg="Package inserted successfully.";
		$_SESSION["success_msg"]='Package inserted successfully.';
		 header('Location:'. BASE_URL.'packages/');
			
		}else{
			$_SESSION["error_msg"]='Unknown method';
			 header('Location:'. BASE_URL.'packages/');
		}
	}
	
	function edit($packageId){
		$userId=$_SESSION['uid'];
		$result=$this->model->getUserDetailsById($userId);
		$userDatass=$result[0];
		define("USERROLE", $userDatass['role']);
		$result=$this->model->getPackagesById($packageId);
		/************/
		$allMaptemplateCategory=$this->model->getMapTemplateCategory();
	   $maptemplates=array();
	   $cat_array=array();
	   if(!empty($allMaptemplateCategory)){
		   foreach($allMaptemplateCategory as $cat){
			   $cat_array['category_name']=$cat['category_name'];
			   $allMaptemplates=$this->model->getMapTemplatesByCategory($cat['id']);
			   $cat_array['template_list']=!empty($allMaptemplates) ? $allMaptemplates : array();
			   $maptemplates[]=$cat_array;
		   }
	   }
		/*************/
		$all_Clients=$this->model->getClientBypackageId($packageId);
		$package=!empty($result) ? $result[0] : array();
		$allclients=!empty($all_Clients) ? $all_Clients : array();
		$userdetails=array('package'=>$package,'maptemplates'=>$maptemplates,'allclients'=>$allclients,'userDatass'=>$userDatass,'mthis'=>$this);
		
      $this->view->mydashboard('dashboard/packages/edit',false,$userdetails);
	}
	
	function update(){
		
		if(isset($_POST['update'])){
			
		$id = $_POST['id'];
		$pname = $_POST['name'];
		$no_allowed_user = $_POST['no_allowed_user'];
		$no_allowed_projects = $_POST['no_allowed_projects'];
		$no_allowed_map = $_POST['no_allowed_map'];
		$is_logo= $_POST['is_logo'];
		$is_charts = $_POST['is_charts'];
		$is_fonts = $_POST['is_fonts'];
		$is_email_mp = $_POST['is_email_mp'];
		$is_social_share = $_POST['is_social_share'];
		$is_email_share = $_POST['is_email_share'];
		$is_tweet_mp = $_POST['is_tweet_mp'];
			$hide_branding = $_POST['hide_branding'];

		   if($_POST['unlimited_user'] != null){
			  $no_allowed_user = $_POST['unlimited_user'];
		   }
			if($_POST['unlimited_pro'] != null){
			  $no_allowed_projects = $_POST['unlimited_pro'];
		   }
		   
		 if($no_allowed_map != null){
			$no_map_string = implode(",",$no_allowed_map);  
		 }else{
			 $no_map_string = null;
		 }
		 
		 if($is_logo == null){
		   $is_logo = 'no';
		}
		if($is_charts == null){
		   $is_charts = 'no';
		}if($is_fonts == null){
		   $is_fonts = 'no';
		}if($is_email_mp == null){
		   $is_email_mp = 'no';
		}
		if($is_social_share == null){
		   $is_social_share = 'no';
		}
		if($is_email_share == null){
		   $is_email_share = 'no';
		}
		if($is_tweet_mp == null){
		   $is_tweet_mp = 'no';
		}
			if($hide_branding == null){
		   $hide_branding = 'no';
		}
		
		
		$result=$this->model->updatePackage($id,$pname,$no_allowed_user,$no_allowed_projects,$no_map_string,$is_logo,$is_charts,$is_fonts,$is_email_mp,$is_social_share,$is_email_share,$is_tweet_mp,$hide_branding);
		$msg="Package updated successfully.";
		//print_r($result);
		//die();
		$_SESSION["success_msg"]='Package updated successfully.';
		 header('Location:'. BASE_URL.'packages/edit/'.$id);
			
		}else{
			$_SESSION["error_msg"]='Unknown method.';
			 header('Location:'. BASE_URL.'packages/');
		}
	}
	function dowithselected(){
		if(isset($_POST['user_ids'])){
		$user_ids=$_POST['user_ids'];
		$action_status=$_POST['action_status'];
		$tablename=$_POST['tablename'];
		foreach($user_ids as $id){
			$result=$this->model->dowithselected($id,$tablename,$action_status);
		}
			echo json_encode(array('status'=>200,'msg'=>'status changed'));
		}else{
			echo json_encode(array('status'=>400,'msg'=>'Bad Request'));
		}
	}
	function saveshorting(){
		if(isset($_POST['shortposition'])){
		$shortposition=$_POST['shortposition'];
		$sequence=$_POST['sequence'];
		$tablename=$_POST['table_name'];
		$count = 0;
		foreach($shortposition as $id){ 
			$result=$this->model->saveshorting($id,$tablename,$sequence[$count]);
			 $count++;
		}
		print_r($result);
			//echo json_encode(array('status'=>200,'msg'=>'status changed'));
		}else{
			//echo json_encode(array('status'=>400,'msg'=>'Bad Request'));
		}
	}
}
?>