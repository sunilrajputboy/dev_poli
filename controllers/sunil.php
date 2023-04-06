<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class Sunil extends Controller{
	function __construct() {
		parent::__construct();
		
	}
	
function index($twitter_username='sunilrajputboy'){

	if($twitter_username != 'sunilrajputboy' ){
	$twitter_username = str_replace("@","",$twitter_username);
	}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://api.twitter.com/2/users/by/username/'.$twitter_username);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		$headers = array();
		$headers[] = 'Authorization: Bearer AAAAAAAAAAAAAAAAAAAAABxqYAEAAAAAhNPiS4AYb1kmwpw1XY4QnVIuHso%3DPkBOWtickVr7pZv6n0ZMWWxAz4h2NFCaqbqSQqoLezDu9RVKFA';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
		$mresponse=json_decode($result);
		
		$twitter_id=$mresponse->data->id;
		$name=$mresponse->data->id;
		$username=$mresponse->data->id;
	// echo $result;
	echo $twitter_id;
	//echo "<pre>";
//print_r($mresponse);	
//	echo "</pre>";	
		
/* $curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.twitter.com/2/users/'.$twitter_id,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer AAAAAAAAAAAAAAAAAAAAABxqYAEAAAAAhNPiS4AYb1kmwpw1XY4QnVIuHso%3DPkBOWtickVr7pZv6n0ZMWWxAz4h2NFCaqbqSQqoLezDu9RVKFA'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response; */


	}
	/**************/
}
?>