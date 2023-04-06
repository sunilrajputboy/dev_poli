<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class Analytics extends Controller{
	function __construct() {
		parent::__construct();
		$this->checkLoggedIn();
	}
	function index(){
		$userId=$_SESSION['uid'];
		$result=$this->model->getUserDetailsById($userId);
		$userDatass=$result[0];
		define("USERROLE", $userDatass['role']);
		$gid = isset($_SESSION['groupid']) ? $_SESSION['groupid'] : null;
		if(isset($_GET['id'])){
		  $cidGet = $_GET['id'];
		}else{
		   $cidGet = null; 
		}
		if(isset($_SESSION['projectArray'])){
			if($_SESSION['projectArray'] != 'NO'){
		  $projectids = implode(',',$_SESSION['projectArray']);
		  $projectArray = $projectids;
			}else{
			  $projectArray = '0';  
			}
		}
		if(isset($_SESSION['projectArray'])){
			$result=$this->model->getProjectWhereIn($projectArray);
		}else if($cidGet != null){
			$result=$this->model->getProjectByClientId($cidGet);	
		}else{
			$result=$this->model->getAllProjects();	
		}
        $allClients=$this->model->getAllClients();	
        $allProjectGroups=$this->model->getAllProjectGroups();
        $views =$this->model->getAnalytics("1");
        $facebook_share = $this->model->getAnalytics("2");
        $twitter_share = $this->model->getAnalytics("3");
        $linkedin_share = $this->model->getAnalytics("4");
        $mp_tweets =$this->model->getAnalytics("5");
        $mp_emails = $this->model->getAnalytics("6");
        $mail_friend =$this->model->getAnalytics("7");
        
		$userdetails=array('projects'=>$result,'allClients'=>$allClients,'views'=>$views,'facebook_share'=>$facebook_share,'twitter_share'=>$twitter_share,'linkedin_share'=>$linkedin_share,'mp_tweets'=>$mp_tweets,'mp_emails'=>$mp_emails,'mail_friend'=>$mail_friend,'userDatass'=>$userDatass,'gid'=>$gid,'allProjectGroups'=>$allProjectGroups,'mthis'=>$this);	
		
		if (USERROLE == 1){
		$this->view->mydashboard('dashboard/analytics/view',false,$userdetails);
		}else{
		    header('Location:'. BASE_URL.'dashboard');
// 		$this->view->mydashboard('dashboard/analytics/view',false,$userdetails);
		}
	}
	
	function add(){
		$userId=$_SESSION['uid'];
		$result=$this->model->getUserDetailsById($userId);
		$userDatass=$result[0];
		define("USERROLE", $userDatass['role']);
		$clients=$this->model->getClients();
		$userdetails=array('userDatass'=>$userDatass,'clients'=>$clients,'mthis'=>$this);
		$this->view->mydashboard('dashboard/analytics/add',false,$userdetails);
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
			$this->view->mydashboard('dashboard/analytics/edit',false,$userdetails);
	}
	
	function delete($projectId){
		$delete=$this->model->deleteProject($projectId);
		$_SESSION["success_msg"]='Project deleted successfully.';
		header('Location:'. BASE_URL.'analytics/');
	}
	function filterprojectbyclient(){
        
        $cid = $_POST['cid'];
        $_SESSION['client_id'] = $cid;
        if($cid != '0'){
        $dataProject=$this->model->getProjectByClientId($cid);
        $option =  '<option value="0">All Projects</option>';
        foreach($dataProject as $pdata){
        $proOptkey = $pdata['proKey'];
        $proOptname = $pdata['name'];
        $option .= '<option value="'.$proOptkey.'">'.$proOptname.'</option>';
        
        }
        foreach($dataProject as $proClient){
        $proKeyArr[] = $proClient['proKey'];
        }
        if($proKeyArr){
        $proKeyArr = implode("','",$proKeyArr);
        $views=$this->model->getAnalyticsByproKey('1',$proKeyArr);
        // print_r($views);
        // exit();
        $views = count($views);
        $facebook_share=$this->model->getAnalyticsByproKey('2',$proKeyArr);
        $facebook_share = count($facebook_share);
        $twitter_share=$this->model->getAnalyticsByproKey('3',$proKeyArr);
        $twitter_share = count($twitter_share);
        $linkedin_share=$this->model->getAnalyticsByproKey('4',$proKeyArr);
        $linkedin_share = count($linkedin_share);
        $mp_tweets=$this->model->getAnalyticsByproKey('5',$proKeyArr);
        $mp_tweets = count($mp_tweets);
        
        $mp_emails=$this->model->getAnalyticsByproKey('6',$proKeyArr);
        $mp_emails = count($mp_emails);
        $mail_friend=$this->model->getAnalyticsByproKey('7',$proKeyArr);
        $mail_friend = count($mail_friend);
        }else{
        $views = 0; 
        $facebook_share = 0;
        $twitter_share = 0;
        $linkedin_share = 0;
        $mp_tweets = 0;
        $mp_emails = 0;
        $mail_friend = 0;
        }
        
        }else{
        $dataProjectAll=$this->model->getAllProjects();
        
        $option =  '<option value="0">All Projects</option>';
        
        foreach($dataProjectAll as $pdata){
        $proOptkey = $pdata['proKey'];
        $proOptname = $pdata['name'];
        $option .= '<option value="'.$proOptkey.'">'.$proOptname.'</option>';
        }
        $views1 =$this->model->getAnalytics("1");
        $views = count($views1);
        $facebook_share1 = $this->model->getAnalytics("2");
        $facebook_share = count($facebook_share1);
        $twitter_share1 = $this->model->getAnalytics("3");
        $twitter_share = count($twitter_share1);
        $linkedin_share1 = $this->model->getAnalytics("4");
        $linkedin_share = count($linkedin_share1);
        $mp_tweets1 =$this->model->getAnalytics("5");
        $mp_emails1 = $this->model->getAnalytics("6");
        $mail_friend1 =$this->model->getAnalytics("7");
        $mp_tweets = count($mp_tweets1);
        $mp_emails = count($mp_emails1);
        $mail_friend = count($mail_friend1);
        
        }
        echo json_encode(array('$proKeyArr'=>$proKeyArr,'options'=>$option,'proKeyArr'=>$proKeyArr,'views'=>$views,'facebook_share'=>$facebook_share,'twitter_share'=>$twitter_share,'linkedin_share'=>$linkedin_share,'mp_tweets'=>$mp_tweets,'mp_emails'=>$mp_emails,'mail_friend'=>$mail_friend));

	}
	
	function filterAnalyticsbyproject(){
        $pkey = $_POST['pkey'];
          $_SESSION['proKey'] = $pkey;
        if($pkey != '0'){
        $views=$this->model->getAnalyticsByproject('1',$pkey);
        $views = count($views);
        $facebook_share=$this->model->getAnalyticsByproject('2',$pkey);
        $facebook_share = count($facebook_share);
        $twitter_share=$this->model->getAnalyticsByproject('3',$pkey);
        $twitter_share = count($twitter_share);
        $linkedin_share=$this->model->getAnalyticsByproject('4',$pkey);
        $linkedin_share = count($linkedin_share);
        $mp_tweets=$this->model->getAnalyticsByproject('5',$pkey);
        $mp_tweets = count($mp_tweets);
        $mp_emails=$this->model->getAnalyticsByproject('6',$pkey);
        $mp_emails = count($mp_emails);
        $mail_friend=$this->model->getAnalyticsByproject('7',$pkey);
        $mail_friend = count($mail_friend);
        
        echo json_encode(array('views'=>$views,'facebook_share'=>$facebook_share,'twitter_share'=>$twitter_share,'linkedin_share'=>$linkedin_share,'mp_tweets'=>$mp_tweets,'mp_emails'=>$mp_emails,'mail_friend'=>$mail_friend));
        
        }else{
        $proKeyArr = array();
        
        if(isset($_SESSION['client_id']) && $_SESSION['client_id'] != '0'){
        $cids = $_SESSION['client_id'];
        $projectByclients=$this->model->getProjectByClientId($cids);
        
        foreach($projectByclients as $proClient){
        
        $proKeyArr[] = $proClient['proKey'];
        }
        
        if($proKeyArr){
        $proKeyArr = implode("','",$proKeyArr);
        
        $views=$this->model->getAnalyticsByproKey('1',$proKeyArr);
        $views = count($views);
        $facebook_share=$this->model->getAnalyticsByproKey('2',$proKeyArr);
        $facebook_share = count($facebook_share);
        $twitter_share=$this->model->getAnalyticsByproKey('3',$proKeyArr);
        $twitter_share = count($twitter_share);
        $linkedin_share=$this->model->getAnalyticsByproKey('4',$proKeyArr);
        $linkedin_share = count($linkedin_share);
        $mp_tweets=$this->model->getAnalyticsByproKey('5',$proKeyArr);
        $mp_tweets = count($mp_tweets);
        
        $mp_emails=$this->model->getAnalyticsByproKey('6',$proKeyArr);
        $mp_emails = count($mp_emails);
        $mail_friend=$this->model->getAnalyticsByproKey('7',$proKeyArr);
        $mail_friend = count($mail_friend);
        
        
        }else{
        $views = 0; 
        $facebook_share = 0;
        $twitter_share = 0;
        $linkedin_share = 0;
        $mp_tweets = 0;
        $mp_emails = 0;
        $mail_friend = 0;
        }
        echo json_encode(array('views'=>$views,'facebook_share'=>$facebook_share,'twitter_share'=>$twitter_share,'linkedin_share'=>$linkedin_share,'mp_tweets'=>$mp_tweets,'mp_emails'=>$mp_emails,'mail_friend'=>$mail_friend));
        
        
        }else{
        
        $views1 =$this->model->getAnalytics("1");
        $views = count($views1);
        $facebook_share1 = $this->model->getAnalytics("2");
        $facebook_share = count($facebook_share1);
        $twitter_share1 = $this->model->getAnalytics("3");
        $twitter_share = count($twitter_share1);
        $linkedin_share1 = $this->model->getAnalytics("4");
        $linkedin_share = count($linkedin_share1);
        $mp_tweets1 =$this->model->getAnalytics("5");
        $mp_emails1 = $this->model->getAnalytics("6");
        $mail_friend1 =$this->model->getAnalytics("7");
        $mp_tweets = count($mp_tweets1);
        $mp_emails = count($mp_emails1);
        $mail_friend = count($mail_friend1);
        
        echo json_encode(array('views'=>$views,'facebook_share'=>$facebook_share,'twitter_share'=>$twitter_share,'linkedin_share'=>$linkedin_share,'mp_tweets'=>$mp_tweets,'mp_emails'=>$mp_emails,'mail_friend'=>$mail_friend));
        
        }
        }
	}
	function NumberOfvisits(){
            // $pro_key = $_SESSION['proKey'];
            $pro_key = $_POST['allproject'];
            $cids = $_POST['allclient'];
            // $cids = $_SESSION['client_id'];
            $visits = $_POST['visits'];
            
            if($visits == 'all'){
                    if($pro_key != '0'){
                          $dataAnalytics =$this->model->getAnalyticsByproject('1',$pro_key);
                    }else{
                    if($cids != '0'){
                        
                    $projectByclients=$this->model->getProjectByClientId($cids);
                    
                    foreach($projectByclients as $proClient){
                    
                    $proKeyArr[] = $proClient['proKey'];
                    }
                    $proKeyArr = implode("','",$proKeyArr);
                    $dataAnalytics=$this->model->getAnalyticsByproKey('1',$proKeyArr);
                    
                    }else{
                     $dataAnalytics=$this->model->getAnalytics('1'); 
                    }
                    
                    }
                    $dataCount = count($dataAnalytics);
                    echo json_encode(array('key'=>'Total visits','value'=>$dataCount));
            
            }
            else if($visits == '30d'){
                
                    if($pro_key != '0'){
                        
                    $dataAnalytics=$this->model->getDaysIntervalByprokey('1',$pro_key);
                    
                    }else{
                    if($cids != '0'){
                        
                    $projectByclients=$this->model->getProjectByClientId($cids);
                    
                    foreach($projectByclients as $proClient){
                    
                    $proKeyArr[] = $proClient['proKey'];
                    }
                        
                    $proKeyArr = implode("','",$proKeyArr);
                    $dataAnalytics=$this->model->getDaysIntervalByIn('1',$proKeyArr);
                  
                    }else{
                         $dataAnalytics=$this->model->getDaysIntervalByEventId('1');
                    }
                    
                    }
                    $dataCount = count($dataAnalytics);
                    echo json_encode(array('key'=>'Last 30 days visit','value'=>$dataCount));
            
            }
            else if($visits == '6m'){
                
                    if($pro_key != '0'){
                         $dataAnalytics=$this->model->getSixmonthInterval('1',$pro_key);
                         
                    }else{
                    if($cids != '0'){
                        
                    $projectByclients=$this->model->getProjectByClientId($cids);
                    
                    foreach($projectByclients as $proClient){
                    
                    $proKeyArr[] = $proClient['proKey'];
                    }
                      
                    $proKeyArr = implode("','",$proKeyArr);
                    $dataAnalytics=$this->model->getSixmonthIntervalByIn('1',$proKeyArr);
                    }else{
                        $dataAnalytics=$this->model->getSixmonthIntervalByEventId('1');
                    }
                    
                    }
                    
                    $dataCount = count($dataAnalytics);
                    echo json_encode(array('key'=>'Last 6 month visit','value'=>$dataCount));
            
            }
            else if($visits == '12m'){
                if($pro_key != '0'){
                
                $dataAnalytics=$this->model->getYearInterval('1',$pro_key);
                
                }else{
                if($cids != '0'){
                $projectByclients=$this->model->getProjectByClientId($cids);
                
                foreach($projectByclients as $proClient){
                
                $proKeyArr[] = $proClient['proKey'];
                }
                
                $proKeyArr = implode("','",$proKeyArr);
                $dataAnalytics=$this->model->getYearIntervalByIn('1',$proKeyArr);
                
                
                }else{
                
                $dataAnalytics=$this->model->getYearIntervalByEventId('1');
                }
                
                }
                
                $dataCount = count($dataAnalytics);
                echo json_encode(array('key'=>'Last 12 month visit','value'=>$dataCount));
            }
            elseif ($visits == 'week'){
                if($pro_key != '0'){
                        $dataAnalytics=$this->model->getweekInterval('1',$pro_key);
                        }else{
                        if($cids != '0'){
                        $projectByclients=$this->model->getProjectByClientId($cids);
                        foreach($projectByclients as $proClient){
                        $proKeyArr[] = $proClient['proKey'];
                        }
                        $proKeyArr = implode("','",$proKeyArr);
                        $dataAnalytics=$this->model->getweekIntervalByIn('1',$proKeyArr);
                        }else{
                        $dataAnalytics=$this->model->getweekIntervalByEventId('1');
                        }
                        }
                        $dataCount = count($dataAnalytics);
                        echo json_encode(array('key'=>'Last week visit','value'=>$dataCount));
            }
              elseif($visits == 'custom'){
            $from = $_POST['from'];
            $from = $from.' 00:00:00';
            $to = $_POST['to'];
            $to = $to.' 00:00:00';
                if($pro_key != '0'){
                        $dataAnalytics=$this->model->getCustomInterval('1',$pro_key,$from, $to);
                }else{
                        if($cids != '0'){
                        $projectByclients=$this->model->getProjectByClientId($cids);
                        foreach($projectByclients as $proClient){
                        $proKeyArr[] = $proClient['proKey'];
                        }
                        $proKeyArr = implode("','",$proKeyArr);
                        $dataAnalytics=$this->model->getCustomIntervalByIn('1',$proKeyArr,$from,$to);
                        }else{
                        $dataAnalytics=$this->model->getCustomIntervalByEventId('1',$from,$to);
                        }
                }
                        $dataCount = count($dataAnalytics);
                        echo json_encode(array('key'=>'Custom range visit','value'=>$dataCount));
            }
	}
	   // ******

           function gettweetmpdata(){
			$tweetdata=$this->model->getMPtweetDATA();
		$html='<div class="table-container"><table class="table" id="packages"><thead><tr>';
		$html.='<th>Name of the MP</th>';
		$html.='<th>Number of tweets</th>';
		$html.='</tr></thead><tbody>';
                foreach ($tweetdata as $key => $data) {
                        $html.= '<tr>';
                        $html.='<td>'.$key.'</td>';
                        $html.='<td>'.(count($data)).'</td>';
                        $html.= '</tr>';
                }
		$html.='</tbody></div>';
		echo json_encode(array("success"=>200,'msg'=>'Tweet MP data View','html_data'=>$html));
		exit;
           }
           function getEmailMpdata(){
                $emailMPdata=$this->model->getemailMpDATA();
        $html='<div class="table-container"><table class="table" id="packages"><thead><tr>';
        $html.='<th>MP Name</th>';
        $html.='<th>Number of emails</th>';
        $html.='<th>List of users</th>';
        $html.='</tr></thead><tbody>';
        foreach ($emailMPdata as $key => $data) {
                $html.= '<tr>';
                $html.='<td>'.$key.'</td>';
                $html.='<td>'.(count($data)).'</td>';
                $html.='<td>';
                $html.='<table class="table export-list"><thead><tr>';
                $html.='<th>name</th>';
                $html.='<th>email</th>';
                $html.='<th>signuptime</th>';
                $html.='<th>Confirmed time</th>';
                $html.='<th>actions</th>';
                $html.='</tr></thead><tbody>';
                foreach ($data as $k => $d) {
                        $html.= '<tr>';
                        $html.='<td>'.$d['user_name'].'</td>';
                        $html.='<td>'.$d['user_email'].'</td>';
                        $html.='<td>'.$d['signuptime'].'</td>';
                        $html.='<td id="timeid'.$d['id'].'">'.$d['confirmtime'].'</td>';
                        if($d['confirm'] == 'false'){
                                $html.='<td>
                                <button style="color:red" class="btn btn-light-gray cnfrm-btn" data-id="'.$d['id'].'">Confirm</button>
                                <button class="btn btn-light-red" onclick="return letsconfirm(`Are you sure you want to Delete? <p>'.$d['user_name'].'</p>`,`'.BASE_URL.'analytics/deleteanalytics/?id='.$d['id'].'`)">Delete</button>
                                </td>';
                        }else{
                                $html.='<td>
                                <button style="color:green" class="btn btn-light-green cnfrm-btn" data-id="'.$d['id'].'"">Unconfirm</button>
                                <button class="btn btn-light-red" onclick="return letsconfirm(`Are you sure you want to Delete? <p>'.$d['user_name'].'</p>`,`'.BASE_URL.'analytics/deleteanalytics/?id='.$d['id'].'`)">Delete</button>
                                </td>';
                        }
                        $html.= '</tr>';
                }
                $html.='</tbody></table>';
                $html.='</td>';
                $html.= '</tr>';
        }
        $html.='</tbody></table></div>';
        echo json_encode(array("success"=>200,'msg'=>'Email MP data View','html_data'=>$html));
        exit;
   }

   function exportDATA()
   {
        $exportDATA=$this->model->getexportDATA();
        $Arr = array();
        $new= array('name','email','signuptime','Confirmed time','Mp name');
        array_push($Arr, $new);
        foreach ($exportDATA as $key => $data) {
        $new1= array($data['user_name'],$data['user_email'],$data['signuptime'],$data['confirmtime'],$data['mp_name']);
        array_push($Arr, $new1);
        }
        echo json_encode(array("success"=>200,'msg'=>'export data','html_data'=>$Arr));
        exit;
   }
   function deleteanalytics()
   {
        if(isset($_GET['id'])){
        $dd=$this->model->deleteAnalyticsById($_GET['id']);
        if($dd){
		header('Location:'. BASE_URL.'analytics/');
        }
        }
   }

   function confirmUnconfirmAnalytics()
   {
       $id = $_POST['id'];
       $result=$this->model->getAnalyticsById($id);
       $Data=$result[0];
       if($Data['confirm'] == 'false'){
        $val = 'true';
        $time = date('Y-m-d H:i:s');
        $msg = 'Record Confirmed Successfully.';
       }else{
        $val = 'false';
        $time = null;
        $msg = 'Record Unconfirmed Successfully.';
       }
       $rr=$this->model->confirmUnconfirmSubs($val,$time,$id);
       if($rr){
        echo json_encode(array("success"=>200,'msg'=>$msg));
       }else{
        echo json_encode(array("success"=>401,'msg'=>'something went wrong.'));
       }
   }

}
?>