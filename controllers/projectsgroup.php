<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class Projectsgroup extends Controller{
	function __construct() {
		parent::__construct();
		$this->checkLoggedIn();
	}
	function index(){
		$userId=$_SESSION['uid'];
		$result=$this->model->getUserDetailsById($userId);
		$userDatass=$result[0];
		define("USERROLE", $userDatass['role']);
        $alldataclient=$this->model->getAllClients();	
        $groupDataAll=$this->model->getAllProjectGroups();
        
		if (USERROLE == 1){
			$userdetails=array('alldataclient'=>$alldataclient,'userDatass'=>$userDatass,'groupDataAll'=>$groupDataAll,'mthis'=>$this);	
			$this->view->mydashboard('dashboard/projectsgroup/view_admin',false,$userdetails);
		}else{
			$userdetails=array('userDatass'=>$userDatass,'allProjectGroups'=>$groupDataAll,'mthis'=>$this);	
			$this->view->mydashboard('dashboard/projectsgroup/view',false,$userdetails);
		}
	}
	
	function add(){
		$userId=$_SESSION['uid'];
		$result=$this->model->getUserDetailsById($userId);
		$userDatass=$result[0];
		define("USERROLE", $userDatass['role']);
		$clients=$this->model->getAllClients();
		$userdetails=array('userDatass'=>$userDatass,'clients'=>$clients,'mthis'=>$this);
			if (USERROLE == 1){
			$this->view->mydashboard('dashboard/projectsgroup/add_admin',false,$userdetails);
		}else{	
			$this->view->mydashboard('dashboard/projectsgroup/add',false,$userdetails);
		}
	
	}
	
	function edit($id){
			$userIds=$_SESSION['uid'];
			$result=$this->model->getUserDetailsById($userIds);
			$userDatass=$result[0];
			$users=$result;
			define("USERROLE", $userDatass['role']);
			$clients=$this->model->getAllClients();
        	$projects=$this->model->getAllProjects();
			$data_Projectgroup=$this->model->getProjectGroupById($id);
			$dataProjectgroup=!empty($data_Projectgroup) ? $data_Projectgroup : array();
			$userdetails=array('users'=>$users,'userDatass'=>$userDatass,'clients'=>$clients,'projects'=>$projects,'dataProjectgroup'=>$dataProjectgroup,'mthis'=>$this);
			if (USERROLE == 1){
		        	$this->view->mydashboard('dashboard/projectsgroup/edit_admin',false,$userdetails);
    		}else{	
    				$this->view->mydashboard('dashboard/projectsgroup/edit',false,$userdetails);
    		}
	}
		function checkunique(){
		if($_POST['unique_url']){
			$unique_url=$_POST['unique_url'];
			$client_id=$_POST['project_group_id'];
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
			$_SESSION["success_msg"]='Unknown method.';
			$ret=array('status'=>0,'msg'=>'Unknown method.');
			echo json_encode($ret);
			exit;	
		}
	}
		    function projectstatus(){
                if($_POST['user_ids']){
                $user_id = $_POST['user_ids'];  
                $action = $_POST['action_status']; 
                
                if($action == 'publish'){
                    $password_protected = 0;
                    $visibility = 1;
                }else if($action == 'draft'){
                    $password_protected = 0;
                    $visibility = 0;
                }else{
                    $password_protected = 1;
                    $visibility = 1;
                }
                    $allTemplate=$this->model->projectstatus($password_protected,$visibility,$user_id);
                if($allTemplate){
			$_SESSION["success_msg"]='status updated.';

                echo json_encode(array('success'=>1, 'msg'=>'status updated.'));
                }else{
                echo 'failed';
                }
                }else{
			$_SESSION["success_msg"]='something went wrong!';

                echo json_encode(array('success'=>0, 'msg'=>'something went wrong!'));
                }
	    }
	        function addpassword(){
	        $id = $_POST['id'];
            $key = 'Hl2018@1212';
            $encrypted_pass = openssl_encrypt($_POST['password'],'AES-128-ECB',$key, OPENSSL_RAW_DATA);
            $encrypted_pass = strtolower(bin2hex($encrypted_pass));
            $password = $encrypted_pass;
            
            $allTemplate=$this->model->addpassword($password,$id);

            if($allTemplate){
			$_SESSION["success_msg"]='Password added successfully.';
            $resultArray = array(
            'success' => 1,
            'msg' => 'Password added successfully.'
            );
            echo json_encode($resultArray);
            }
	    }
	   function hideprojects($proId){
            
                if($proId){
                $allTemplate=$this->model->hideprojects($proId);
                ?>
                <?php
                $_SESSION["success_msg"]='Projectgroup drafted successfully.';
                ?>
                <script>
                window.history.back();
                </script>
                <?php 
                }
            }
              function showprojects($proId){
            
                if($proId){
                $allTemplate=$this->model->showprojects($proId);
                ?>
                <?php
                $_SESSION["success_msg"]='Project publish successfully.';
                ?>
                <script>
                window.history.back();
                </script>
                <?php 
                }
            }
            function lock($proId){
                if($proId){
                $allTemplate=$this->model->lockprojects($proId);
                ?>
                <?php
                $_SESSION["success_msg"]='Project lock successfully.';
                ?>
                <script>
                window.history.back();
                </script>
                <?php 
                }
            }
              function unlock($proId){
                if($proId){
                $allTemplate=$this->model->unlockprojects($proId);
                ?>
                <?php
                $_SESSION["success_msg"]='Project unlock successfully.';
                ?>
                <script>
                window.history.back();
                </script>
                <?php 
                }
            }
            
		function update(){
		if($_POST['gid']){
		    $id = $_POST['gid'];
        $gname = $_POST['gname'];
        $unique_url = $_POST['unique_url'];
        $description = $_POST['description'];
        $cid = $_POST['cid'];
        $projects = $_POST['projects'];
        if($projects != null){
        $projects = serialize($_POST['projects']);
        }
		$allTemplate=$this->model->updateProjectGroup($gname,$description,$cid,$projects,$unique_url,$id);
			$_SESSION["success_msg"]='projectGroup updated successfully.';
		echo json_encode(array('success' => 1,'msg' => '','redirect_url' => BASE_URL.'projectsgroup'));    
		}else{
		    $_SESSION["success_msg"]='Unkonwn method';
		echo json_encode(array('success' => 0,'msg' => '','redirect_url' => BASE_URL.'projectsgroup'));  
		}
	}
	
	function delete(){
	    $projectId = $_GET['id'];
		$delete=$this->model->deleteProject($projectId);
		$_SESSION["success_msg"]='Project deleted successfully.';
		header('Location:'. BASE_URL.'projectsgroup/');
	}
	function addprojects(){
	    if($_POST['gname']){
        	$gname = $_POST['gname'];
            $description = $_POST['description'];
            $cid = $_POST['cid'];
            $projects = $_POST['projects'];
            $unique_url = strtolower(str_replace(' ', '', $gname));
        
            if($projects != null){
            $projects = serialize($_POST['projects']);
            }
            $uid = $_SESSION['uid'];
            
             $allTemplate=$this->model->addprojectGroup($gname,$cid,$description,$projects,$uid,$unique_url); 
             
            $_SESSION["success_msg"]='ProjectGroup created successfully.';
            if(isset($_POST['redirect_url'])){
            	echo json_encode(array('success' => 1,'msg' => '','redirect_url' => $_POST['redirect_url'])); 
            }else{
            	echo json_encode(array('success' => 1,'msg' => '','redirect_url' => BASE_URL.'projectsgroup'));    
            }
	    }else{
	          $_SESSION["success_msg"]='Unkonwn method';
	         echo json_encode(array('success' => 0,'msg' => 'Unkonwn method.','redirect_url' => BASE_URL.'projectsgroup')); 
	    }
	}
	function projectfilter(){
	    $ClientId = $_POST['clientId'];
		$userId=$_SESSION['uid'];
		$result=$this->model->getUserDetailsById($userId);
		$userDatass=$result[0];
		define("USERROLE", $userDatass['role']);
		$cproject=$this->model->getProjectByClientId($ClientId);
		$userdetails=array('cproject'=>$cproject,'mthis'=>$this);
	   $options = '';
	   foreach($cproject as $cp){
	        $options .= "<option value=".$cp['id_project'].">".$cp['name']."</option>";
	   }
	   echo $options;
	}
	function updateprojectingroup(){
            $pid = $_POST['pid'];
            $cid = $_POST['cid'];
            $redirect_url = $_POST['redirect_url'];
            $groups = $_POST['group'];
            
            
            if($groups != null){
            foreach($groups as $gid){
            $allproGroup=$this->model->getProjectGroupById($gid);
            $groupData = $this->model->getallProjectGroup();
            // print_r($allproGroup);
        
            foreach($groupData as $gdata){
            $grpProject = $gdata['projects'];
            if($grpProject != null){
            $grpProject = unserialize($gdata['projects']);
            if(in_array($pid,$grpProject)){  
            if($groups != null){
            if(!in_array($gdata['id'],$groups)){
            if (($key = array_search($pid, $grpProject)) !== false) {
            unset($grpProject[$key]);
            $removeGroupproject = $gdata['id'];
            
            if($grpProject != null){
            $newProjects = serialize($grpProject);
            }else{
            $newProjects = null;
            }
            $this->model->updateGroup($newProjects,$removeGroupproject);
            }
            
            }
            }else{
            
            
            if (($key = array_search($pid, $grpProject)) !== false) {
            unset($grpProject[$key]);
            $removeGroupproject = $gdata['id'];
            
            if($grpProject != null){
            $newProjects = serialize($grpProject);
            }else{
            $newProjects = null;
            }
                $this->model->updateGroup($newProjects,$removeGroupproject);
            }
            }
            }
            }
            }
            
            
            
            foreach($allproGroup as $algrp){
            $projectsingroup = $algrp['projects'];
            if($projectsingroup != null){
            $proall = unserialize($projectsingroup);
            if(!in_array($pid,$proall)){
            array_push($proall,$pid);
            }
            
            $proall = serialize($proall);
            }else{
            $proall = Array();
            if(!in_array($pid,$proall)){
            array_push($proall,$pid);
            }
            if($proall != null){
            $proall = serialize($proall);
            }
            
            }
            
            $this->model->updateGroup($proall,$gid);
                
            }
            }
            }else{
            
            
            $groupData = $this->model->getallProjectGroup();
            foreach($groupData as $gdata){
            $grpProject = $gdata['projects'];
            if($grpProject != null){
            $grpProject = unserialize($gdata['projects']);
            if(in_array($pid,$grpProject)){  
            
            
            if (($key = array_search($pid, $grpProject)) !== false) {
            unset($grpProject[$key]);
            $removeGroupproject = $gdata['id'];
            
            if($grpProject != null){
            $newProjects = serialize($grpProject);
            }else{
            $newProjects = null;
            }
            $this->model->updateGroup($newProjects,$removeGroupproject);
            }
            
            }
            }
            }
            }
	          $_SESSION["success_msg"]='ProjetGroup Updated successfully.';

            echo json_encode(array('success' => 1,'msg' => 'ProjetGroup Updated successfully.','redirect_url' => $redirect_url));    
	}
        // 	::::::::::::::::
}
?>