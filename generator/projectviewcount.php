<?php
error_reporting(1);
$origin = $_SERVER['HTTP_ORIGIN'];
class Srclasss {
	
	private function dbConnect(){
		 $conn = new mysqli('localhost', 'visualisationpol_stage', 'visualisationpol_stage', 'visualisationpol_stage');

		 if(!$conn){
			die("Connection failed: " . mysqli_connect_error());
		   }
		   return $conn;
	 }
	 
	public function updateEventCount($pkey,$eventId){
		$connection=$this->dbConnect();  
		$query = "INSERT INTO `analytics`(`event_id`, `event_value`, `pro_key`) VALUES ('$eventId','1','$pkey')";
		$result = $connection->query($query);
		return $result;
	 }
	 
	 	public function getViews($pkey) {
		$connection=$this->dbConnect();  
		$query = "SELECT `views` FROM `projects` WHERE `proKey` = '$pkey'";
		$result = $connection->query($query);
		$data = mysqli_fetch_assoc($result);
		return $data['views'];
	 }
	 
}
$srObject= new Srclasss();
if(isset($_POST['key'])){
   
  $views = $_POST['viewcount'];
  $facebook_share = $_POST['facebook_share'];
   $linkedin_share = $_POST['linkedin_share'];
    $twitter_share = $_POST['twitter_share'];
    $mail_friend = $_POST['mail_friend'];
    $mail_mp = $_POST['mail_mp'];
     $mp_tweets = $_POST['mp_tweets'];
   
    
  $pkey = $_POST['key'];
  if(isset($views)){
     $re = $srObject->updateEventCount($pkey,'1');  
  }
    if(isset($facebook_share)){
     $re = $srObject->updateEventCount($pkey,'2');  
  }
    if(isset($twitter_share)){
     $re = $srObject->updateEventCount($pkey,'3');  
  }
   if(isset($linkedin_share)){
     $re = $srObject->updateEventCount($pkey,'4');  
  }
    if(isset($mail_friend)){
     $re = $srObject->updateEventCount($pkey,'7');  
  }
      if(isset($mp_tweets)){
     $re = $srObject->updateEventCount($pkey,'5');  
  }
   if(isset($mail_mp)){
     $re = $srObject->updateEventCount($pkey,'6');  
  }

 

 


 echo json_encode('success');
 
    
}

/*************/


?>