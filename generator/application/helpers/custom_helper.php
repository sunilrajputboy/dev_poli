<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Custom Helper
* Author: PixlrIt
* version: 1.0
*/

/**
 * [To print array]
 * @param array $arr
*/
if ( ! function_exists('pr')) {
  function pr($arr)
  {
    echo '<pre>'; 
    print_r($arr);
    echo '</pre>';
    die;
  }
}
/**
* [To print last query]
*/
if ( ! function_exists('lq')) {
  function lq(){
    $CI = & get_instance();
    echo $CI->db->last_query();
    die;
  }
}
/**
 * [To print array]
 * @param array $arr
*/
if ( ! function_exists('sendSms')) {
  function sendSms($mob_number,$message){

$id = "ACc1e35cec346f1d618ea5b9b7c52646e9";
$token = "af25e3be9d6438c40d354848354e4234";
$url = "https://api.twilio.com/2010-04-01/Accounts/$id/SMS/Messages";
$from = "+16789321701";
$to = $mob_number; // twilio trial verified number
$body = $message;
$data = array (
    'From' => $from,
    'To' => $to,
    'Body' => $body,
);
$post = http_build_query($data);
$x = curl_init($url );
curl_setopt($x, CURLOPT_POST, true);
curl_setopt($x, CURLOPT_RETURNTRANSFER, true);
curl_setopt($x, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($x, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($x, CURLOPT_USERPWD, "$id:$token");
curl_setopt($x, CURLOPT_POSTFIELDS, $post);
$y = curl_exec($x);
curl_close($x);
//var_dump($post);
return $y;
    
  }
}

/**
 * [To encode string]
 * @param string $str
*/
if(!function_exists('encoding')){
  function encoding($str){
      $one = serialize($str);
      $two = @gzcompress($one,9);
      $three = addslashes($two);
      $four = base64_encode($three);
      $five = strtr($four, '+/=', '-_.');
      return $five;
  }
}

/**
 * [To decode string]
 * @param string $str
*/
if ( ! function_exists('decoding')) {
  function decoding($str){
    $one = strtr($str, '-_.', '+/=');
      $two = base64_decode($one);
      $three = stripslashes($two);
      $four = @gzuncompress($three);
      if ($four == '') {
          return "z1"; 
      } else {
          $five = unserialize($four);
          return $five;
      }
  }
}

/**
 * [To get previous dates]
 * @param int $no_of_days
*/
if ( ! function_exists('get_previous_dates')) 
{
  function get_previous_dates($no_of_days,$timestamp)
  {
    $dates_arr = array(); 
    for ($i = 0 ; $i < (int) $no_of_days ; $i++) {
        $dates_arr[] = date('Y-m-d', $timestamp);
        $timestamp -= 24 * 3600;
    }
    return $dates_arr;
  }
}

function get_free_period_status($registration_date)
{
  $regDateObj = new DateTime($registration_date);
  $CurrentDateObject = new DateTime(datetime());
  $interval = $regDateObj->diff($CurrentDateObject);
  return ($interval->d > 30) ? 0 : 1;
}

function tools(){
  return array('APP_PURCHASE');
}

function ValidateGooglePlaySignature($responseData, $signature) {
        $publicKey = "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEArm9P4RdLrY7ddzNjG57RljZd7bqP+lhsJFrjb0+P1ah9sZDkLmc7TJK8rxY2OCT+UBA4kqfNys87CgdqkTrHfTZoi7jlAJCRIGPQVH8/TS1kF+MgKFco6ug99PPLq5+LaqBz/GCLPaCKlgABYTQS4hiuagrZwRa8LxZ+0nv15mygSUaclNR7PlRmFSDA4s9L4lUEglr9nZqq3KDiBmil7v3XYP++ni9/7kTPZ/rbG4Zin4FKXY1Y7zhRvBkeEdjFSS7hB9OxDIJ3w8Db0PNs7qI6kBnBzpY+TfWrlzH/cjD0TIHudQ8WQcUqmfugrAa4LiweZu68DxWwp0/Ur0yV2QIDAQAB";
        
        $responseData = trim($responseData);
        $signature = trim($signature);
        $response = json_decode($responseData);
        //Create an RSA key compatible with openssl_verify from our Google Play sig
        $key = "-----BEGIN PUBLIC KEY-----\n" .
                chunk_split($publicKey, 64, "\n") .
                '-----END PUBLIC KEY-----';
        $key = openssl_get_publickey($key);

        // Pre-add signature to return array before we decode it
        $retArray = array('signature' => $signature);

        //Signature should be in binary format, but it comes as BASE64.
        $signature = base64_decode($signature);

        //Verify the signature
        return $result = openssl_verify($responseData, $signature, $key, OPENSSL_ALGO_SHA1);

        $status = (1 === $result) ? 0 : 1;
        $retArray["status"] = $status;
        return $retArray;
    }

    function verify_app_purchase_in_ios($data, $optional_headers = null) {
       $reciept_response = json_decode($data);
       if ($reciept_response->environment == 'Sandbox') {
            $url = 'https://sandbox.itunes.apple.com/verifyReceipt';
        } else {
            $url = 'https://buy.itunes.apple.com/verifyReceipt';
        }
        $params = array('http' => array(
                'method' => 'POST',
                'content' => $data
        ));
        if ($optional_headers !== null) {
            $params['http']['header'] = $optional_headers;
        }
        $ctx = stream_context_create($params);
        $fp = @fopen($url, 'rb', false, $ctx);
        if (!$fp) {
            throw new Exception("Problem with $url, $php_errormsg");
        }
        $response = @stream_get_contents($fp);
        if ($response === false) {
            throw new Exception("Problem reading data from $url, $php_errormsg");
        }
        $response_decode = json_decode($response);

        if ($response_decode->status == 0) {
            
            $single = end($response_decode->latest_receipt_info);
            //print_r($response_decode->latest_receipt_info);
            $timezone= explode(" ",$single->expires_date);
            $t = $timezone[2];
            date_default_timezone_set($t);
            $mil = $single->expires_date_ms;
            $seconds = $mil / 1000;
            $expire_date =  strtotime(date("d-m-Y H:i:s", $seconds));
            //echo date('Y-m-d H:i:s',$expire_date);
           //print_r($single);
            $current_date =  strtotime(date('d-m-Y H:i:s'));
            //echo date('Y-m-d H:i:s',$current_date);
            //exit;
            if($expire_date < $current_date){

                return 0;
            }else{
                return 1;
            }
        } else {
            return 0;
        }
    }
    
    
    function data_app_purchase_in_ios($data, $optional_headers = null) {
       $reciept_response = json_decode($data);
       if ($reciept_response->environment == 'Sandbox') {
            $url = 'https://sandbox.itunes.apple.com/verifyReceipt';
        } else {
            $url = 'https://buy.itunes.apple.com/verifyReceipt';
        }
        $params = array('http' => array(
                'method' => 'POST',
                'content' => $data
        ));
        if ($optional_headers !== null) {
            $params['http']['header'] = $optional_headers;
        }
        $ctx = stream_context_create($params);
        $fp = @fopen($url, 'rb', false, $ctx);
        if (!$fp) {
            throw new Exception("Problem with $url, $php_errormsg");
        }
        $response = @stream_get_contents($fp);
        if ($response === false) {
            throw new Exception("Problem reading data from $url, $php_errormsg");
        }
        $response_decode = json_decode($response);

        if ($response_decode->status == 0) {
            
            $single = end($response_decode->latest_receipt_info);
            //print_r($response_decode->latest_receipt_info);
            $timezone= explode(" ",$single->expires_date);
            $t = $timezone[2];
            date_default_timezone_set($t);
            $mil = $single->expires_date_ms;
            $seconds = $mil / 1000;
           return $expire_date =  date("Y-m-d H:i:s", $seconds);
        } else {
            return 0;
        }
    }

function verify_itune_app($responseData) {
        $password = "729799ff802740edbbe9099f5f5fea10";
        if ($responseData->environment == 'Sandbox') {
            $url = 'https://sandbox.itunes.apple.com/verifyReceipt';
        } else {
            $url = 'https://buy.itunes.apple.com/verifyReceipt';
        }
        $postData = json_encode(array('receipt-data' => $responseData,'password' => $password,));
        $params = array('http' => array('method' => 'POST','content' => $postData));
        $ctx = stream_context_create($params);
        $fp = @fopen($url, 'rb', false, $ctx);
        if(!$fp){
            throw new Exception("Problem with $url, $php_errormsg");
        }
        $response = @stream_get_contents($fp);
        if ($response === false){
            throw new Exception("Problem reading data from $url, $php_errormsg");
        }
        $response_decode = json_decode($response);
        pr($response_decode);
        return $response_decode;
        if ($response_decode->status == 0) {
            return true;
        } else {
            return false;
        }
    }

if (!function_exists('parseHTML')) {
  function parseHTML($str) {
    $str = str_replace('src="//', 'src="https://', $str);
    return $str;
  }
}

if (!function_exists('get_subscription_end_date')) {
  function get_subscription_end_date($datetime,$type) {
    switch ($type) {
      case 'MONTHLY':
        return date('Y-m-d H:i:s', strtotime('30 Days', strtotime($datetime)));
        break;
      case 'QUATERLY':
        return date('Y-m-d H:i:s', strtotime('90 Days', strtotime($datetime)));
        break;
      case 'YEARLY':
        return date('Y-m-d H:i:s', strtotime('365 Days', strtotime($datetime)));
        break;
      default:
        return '';
        break;
    }
  }
}


/**
 * [To get all timezones]
*/
if ( ! function_exists('timezones')) {
  function timezones() 
  {
    $zones_array = array();
    $timestamp = time();
    foreach(timezone_identifiers_list() as $key => $zone) {
      date_default_timezone_set($zone);
      $zones_array[$zone] = date('P', $timestamp);
    }
    return $zones_array;
  }
}

/**
 * [To get timezone identifire]
 * @param string $timezone
*/
if ( ! function_exists('getTimeZoneTime')) {
  function getTimeZoneTime($timezone="")
  {
    $CI = & get_instance();
    if(!empty($timezone)){
      $tz = $timezone;
    }else{
      $tz = $CI->session->userdata('timezone');
    }
    if(!empty($tz)){
      $timezone_list = timezones();
      if(isset($timezone_list[$tz]) && !empty($timezone_list[$tz])) {
        return $timezone_list[$tz];
      }else{
        return '-07:00'; //America/Los_Angeles
      }
    }else{
      return '-07:00'; //America/Los_Angeles
    }
  }
}

/**
 * extract_value
 * @return string
 */
if (!function_exists('extract_value')){
    function extract_value($array, $key, $default = ""){
        $CI = & get_instance();
        if(isset($array[$key])){
          $string = $CI->db->escape_str($array[$key]);
          return strip_tags($string);
        }else{
          return $default;
        }
    }

}

/**
 * [To get local time from user timezone]
 * @param datetime $utc
 * @param string $format
*/
if ( ! function_exists('getLocalTime')) {
  function getLocalTime($utc,$format){  
    $datetime = '';
    $CI = & get_instance();
    $timezone = $CI->session->userdata('timezone');
    $identifire = getTimeZoneTime($timezone);
    $identifireArr = explode(":", $identifire);
    $pos = strpos($identifireArr[0], '+');
    if($pos === false){
      $datetime = date($format,strtotime($identifireArr[0].' hour -'.$identifireArr[1].' minutes',strtotime($utc)));
    }else{
      $datetime = date($format,strtotime($identifireArr[0].' hour +'.$identifireArr[1].' minutes',strtotime($utc)));
    }
    return $datetime;
  }
}

/**
 * [To get current local time]
 * @param datetime $utc
 * @param string $format
*/
if ( ! function_exists('getCurrentLocalTime')) {
  function getCurrentLocalTime($utc,$format)
  {  
    $datetime = '';
    $utc = $utc." ".date('H:i:s');
    $CI = & get_instance();
    $timezone = $CI->session->userdata('timezone');
    $identifire = getTimeZoneTime($timezone);
    $identifireArr = explode(":", $identifire);
    $pos = strpos($identifireArr[0], '+');
    if($pos === false){
      $datetime = date($format,strtotime($identifireArr[0].' hour -'.$identifireArr[1].' minutes',strtotime($utc)));
    }else{
      $datetime = date($format,strtotime($identifireArr[0].' hour +'.$identifireArr[1].' minutes',strtotime($utc)));
    }
    return $datetime;
  }
}

/**
 * [To get data row count]
 * @param string $table
 * @param array $where
*/
if ( ! function_exists('getAllCount')) {
  function getAllCount($table,$where="")
  {
    $CI = & get_instance();
    if(!empty($where)){
      $CI->db->where($where);
    }
    $q = $CI->db->count_all_results($table);
    return addZero($q);
  }
}

/**
 * [To get user current location data]
*/
if ( ! function_exists('getCurrentLocationData')) {
  function getCurrentLocationData()
  {
    $data  = file_get_contents('https://api.ipify.org/?format=json');
    $query = json_decode($data,TRUE);
    if(!empty($query) && !empty($query['ip'])){
      $data1  = file_get_contents('http://freegeoip.net/json/'.$query['ip']);
      $query1 = json_decode($data1,TRUE);
      return $query1;
    }else{
      return array();
    }
  }
}

/**
 * [To print number in standard format with 0 prefix]
 * @param int $no
*/
if ( ! function_exists('addZero')) {
  function addZero($no)
  {
    if($no >= 10){
      return $no;
    }else{
      return "0".$no;
    }
  }
}

/**
 * [To get current datetime]
*/
if ( ! function_exists('datetime')) {
  function datetime()
  {
    $datetime = date('Y-m-d H:i:s');
    return $datetime;
  }
}

/**
 * [To sort multi-dimensional array]
 * @param array $response
 * @param string $column
 * @param string $type
*/
if ( ! function_exists('sortarr')) {
  function sortarr($response,$column,$type)
  {
    $arr =array();
    foreach ($response as $r) {
      $arr[] = $r->$column; // In Object
    }
    if($type == 'ASC'){
      array_multisort($arr,SORT_ASC,$response);
    }else{
      array_multisort($arr,SORT_DESC,$response);
    }
    return $response;
  }
}

/**
 * [To convert date time format]
 * @param datetime $datetime
 * @param string $format
*/
if ( ! function_exists('convertDateTime')) {
  function convertDateTime($datetime,$format='')
  {
    $new_fromat = '';
    if(empty($format)){
      $new_fromat = 'd F Y, h:i A';
    }else{
      $new_fromat = $format;
    }
    $convertedDateTime = getLocalTime($datetime,$new_fromat);
    return $convertedDateTime;
  }
}


/**
 * [To encode string]
 * @param string $str
*/
if ( ! function_exists('ci_enc')) {
  function ci_enc($str){
      $one = serialize($str);
      $two = @gzcompress($one,9);
      $three = addslashes($two);
      $four = base64_encode($three);
      $five = strtr($four, '+/=', '-_.');
      return $five;
  }
}

/**
 * [To decode string]
 * @param string $str
*/
if ( ! function_exists('ci_denc')) {
  function ci_denc($str){
    $one = strtr($str, '-_.', '+/=');
      $two = base64_decode($one);
      $three = stripslashes($two);
      $four = @gzuncompress($three);
      if ($four == '') {
          return "z1"; 
      } else {
          $five = unserialize($four);
          return $five;
      }
  }
}

/**
 * [To export csv file from array]
 * @param string $fileName
 * @param array $assocDataArray
 * @param array $headingArr
*/
if ( ! function_exists('exportCSV')) {
  function exportCSV($fileName,$assocDataArray,$headingArr)
  {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename='.$fileName);
    $output = fopen('php://output', 'w');
    fputcsv($output, $headingArr);
    foreach ($assocDataArray as $key => $value) {
        fputcsv($output, $value);
    }
     exit;
  }
}

/**
 * [To check number is digit or not]
 * @param int $element
*/
if ( ! function_exists('is_digits')) {
  function is_digits($element){ // for check numeric no without decimal
      return !preg_match ("/[^0-9]/", $element);
  }
}

/**
 * [To get all months list]
*/
if ( ! function_exists('getMonths')) {
  function getMonths(){
    $monthArr = array('January','February','March','April','May','June','July','August','September','October','November','December');
    return $monthArr ;
  }
}

/**
* [To upload all files]
* @param string $subfolder
* @param string $ext
* @param int $size
* @param int $width
* @param int $height
* @param string $filename
*/
if (!function_exists('fileUploading')){
  function fileUploading($filename,$subfolder,$ext,$size="",$width="",$height=""){
	 $filenames1=$_FILES["$filename"]['name'];
	 $filenames2=explode('.',$filenames1);
	 $fileext=end($filenames2);
	 $newfilename=time().'_'.rand(99999,9999999999).'_'.rand(10000,99999).'.'.$fileext;
     $CI = & get_instance();
     $directory_path = 'uploads/'.$subfolder; 
    // make_directory($directory_path);
     $config['upload_path']   = $directory_path.'/';
     $config['allowed_types'] = $ext; 
	 $config['file_name'] = $newfilename;
	 $config['overwrite'] = TRUE;
	 $config['maintain_ratio'] = FALSE;
	 $config['quality'] = 80;
	 $config['width']    = 350;
     $config['height']   = 350;
	 $config['remove_spaces'] = TRUE;
	 $CI->load->library('image_lib');
     if($size!=""){
      $config['max_size']   = $size; 
     }
     if($width!=""){
      $config['max_width']  =$width; 
     }
     if($height!=""){
      $config['max_height'] =$height;  
     }
	$CI->image_lib->clear();
    $CI->image_lib->initialize($config);
	$CI->load->library('upload', $config);
	
    if ($CI->upload->do_upload($filename)){
		            $uploades_pats=$CI->upload->upload_path.$CI->upload->file_name;
		            $data = array('upload_data' => $CI->upload->data());
					$config2['image_lib'] = 'gd2';
                    $config2['source_image'] = $uploades_pats;
                    $config2['new_image'] = $directory_path;
                    $config2['maintain_ratio'] = FALSE;
                    $config2['overwrite'] = TRUE;
                    $config2['width'] = 350;
                    $config2['height'] = 350;
                    $config2['master_dim'] = 'auto';
				    $CI->image_lib->initialize($config2);
	$Orientation=0;				
	$imgdata=@exif_read_data($uploades_pats,"FILE,COMPUTED,ANY_TAG,IFD0,THUMBNAIL,COMMENT,EXIF,Orientation", true);
    if(isset($imgdata['IFD0']['Orientation'])){
        $Orientation = $imgdata['IFD0']['Orientation'];
    }
                if (!$CI->image_lib->resize()){  
                    $error = array('error' => strip_tags($CI->resize->display_errors())); 
					return $error;
                }else{
                    $CI->image_lib->clear();
                    $config3=array();
                    $config3['image_library'] = 'gd2';
                    $config3['source_image'] = $uploades_pats;
                    if($Orientation!=0){
                        switch($Orientation) {
                            case 3:
                            $config3['rotation_angle']='180';
                            break;
                            case 6:
                            $config3['rotation_angle']='270';
                            break;
                            case 8:
                            $config3['rotation_angle']='90';
                            break;
                        }
                        $CI->image_lib->initialize($config3); 
                        $CI->image_lib->rotate();
                    }
                }				
					
					return $data;
    }else{
					$error = array('error' => strip_tags($CI->upload->display_errors())); 
					return $error;
      
    } 
  }
}
/**
 * [To check autorized user]
 * @param string $return_uri
*/
if ( ! function_exists('is_logged_in')) {
  function is_logged_in($return_uri = '') {
      $ci =&get_instance();
    $user_login = $ci->session->userdata('user_id');
    if(!isset($user_login) || $user_login != true) {
      if($return_uri) {
        $ci->session->set_flashdata('blog_token',time());
        redirect('?return_uri='.urlencode(base_url().$return_uri));  
      } else {
        $ci->session->set_flashdata('blog_token',time());
        redirect("/");  
      }   
    }   
  }
}

/**
 * [To excecute CURL]
 * @param string $Url
 * @param array $jsondata
 * @param array $post
 * @param array $headerData
*/
if (!function_exists('ExecuteCurl'))
{

    function ExecuteCurl($url, $jsondata = '', $post = '', $headerData = [])
    {
        $ch = curl_init();
        $headers = array('Accept: application/json', 'Content-Type: application/json');
        if (!empty($headerData) && is_array($headerData))
        {
            foreach ($headerData as $key => $value)
            {
                $headers[$key] = $value;
            }
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($jsondata != '')
        {
            curl_setopt($ch, CURLOPT_POST, count($jsondata));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsondata);
        }

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 50);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        if ($post != '')
        {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $post);
        }
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}

/**
 * [To filter POST/GET value]
 * @param string $value
*/
if ( ! function_exists('filtervalue')) {
  function filtervalue($value)
  {
    $filtered_val = '';
    $filtervalue  = strip_tags($value);
    return $filtervalue; 
  }
}

/**
 * [To check null value]
 * @param string $value
*/
if ( ! function_exists('null_checker')) {
  function null_checker($value,$custom="")
  {
    $return = "";
    if($value != "" && $value != NULL){
      $return = ($value == "" || $value == NULL) ? $custom : $value;
      return $return;
    }else{
      return $return;
    }
  }
}

/**
 * [To send mail]
 * @param string $from
 * @param string $to
 * @param string $subject
 * @param string $message
*/
if ( ! function_exists('send_mail')) {
  function send_mail($from,$to,$subject,$message)
  {
      $ci = &get_instance();
      $config['mailtype'] = 'html';
      $ci->email->initialize($config);
      $ci->email->from($from);
      $ci->email->to($to);
      $ci->email->subject($subject);
      $ci->email->message($message);
      if($ci->email->send()) {  
        return true;
      } else {
        return false;
      }
  }
}


if ( ! function_exists('crypto_rand_secure')) {
  function crypto_rand_secure($min, $max) 
  {
      $range = $max - $min;
      if ($range < 1) return $min;
      $log = ceil(log($range, 2));
      $bytes = (int) ($log / 8) + 1;
      $bits = (int) $log + 1;
      $filter = (int) (1 << $bits) - 1;
      do {
          $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
          $rnd = $rnd & $filter;
      } while ($rnd >= $range);
      return $min + $rnd;
  }
}

/**
 * [To generate random token]
 * @param string $length
*/
if ( ! function_exists('generateToken')) {
  function generateToken($length) 
  {
      $token = "";
      $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
      $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
      $codeAlphabet.= "0123456789";
      $max = strlen($codeAlphabet) - 1;
      for ($i=0; $i < $length; $i++) {
          $token .= $codeAlphabet[crypto_rand_secure(0, $max)];
      }
      return $token;
  }
}

/**
 * [To get live videos thumb Youtube,Vimeo]
 * @param string $videoString
*/
if ( ! function_exists('getVideoThumb')) {
  function getVideoThumb($videoString = null){
      // return data
      $videos = array();
      if (!empty($videoString)) {
          // split on line breaks
          $videoString = stripslashes(trim($videoString));
          $videoString = explode("\n", $videoString);
          $videoString = array_filter($videoString, 'trim');
          // check each video for proper formatting
          foreach ($videoString as $video) {
              // check for iframe to get the video url
              if (strpos($video, 'iframe') !== FALSE) {
                  // retrieve the video url
                  $anchorRegex = '/src="(.*)?"/isU';
                  $results = array();
                  if (preg_match($anchorRegex, $video, $results)) {
                      $link = trim($results[1]);
                  }
              } else {
                  // we already have a url
                  $link = $video;
              }
              // if we have a URL, parse it down
              if (!empty($link)) {
                  // initial values
                  $video_id = NULL;
                  $videoIdRegex = NULL;
                  $results = array();
                  // check for type of youtube link
                  if (strpos($link, 'youtu') !== FALSE) {
                      if (strpos($link, 'youtube.com') !== FALSE) {
                          // works on:
                          // http://www.youtube.com/embed/VIDEOID
                          // http://www.youtube.com/embed/VIDEOID?modestbranding=1&amp;rel=0
                          // http://www.youtube.com/v/VIDEO-ID?fs=1&amp;hl=en_US
                          $videoIdRegex = '/youtube.com\/(?:embed|v){1}\/([a-zA-Z0-9_]+)\??/i';
                      } else if (strpos($link, 'youtu.be') !== FALSE) {
                          // works on:
                          // http://youtu.be/daro6K6mym8
                          $videoIdRegex = '/youtu.be\/([a-zA-Z0-9_]+)\??/i';
                      }
                      if ($videoIdRegex !== NULL) {
                          if (preg_match($videoIdRegex, $link, $results)) {
                              $video_str = 'http://www.youtube.com/v/%s?fs=1&amp;autoplay=1';
                              $thumbnail_str = 'http://img.youtube.com/vi/%s/2.jpg';
                              $fullsize_str = 'http://img.youtube.com/vi/%s/0.jpg';
                              $video_id = $results[1];
                          }
                      }
                  }
                  // handle vimeo videos
                  else if (strpos($video, 'vimeo') !== FALSE) {
                      if (strpos($video, 'player.vimeo.com') !== FALSE) {
                          // works on:
                          // http://player.vimeo.com/video/37985580?title=0&amp;byline=0&amp;portrait=0
                          $videoIdRegex = '/player.vimeo.com\/video\/([0-9]+)\??/i';
                      } else {
                          // works on:
                          // http://vimeo.com/37985580
                          $videoIdRegex = '/vimeo.com\/([0-9]+)\??/i';
                      }
                      if ($videoIdRegex !== NULL) {
                          if (preg_match($videoIdRegex, $link, $results)) {
                              $video_id = $results[1];
                              // get the thumbnail
                              try {
                                  $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_id.php"));
                                  if (!empty($hash) && is_array($hash)) {
                                      $video_str = 'http://vimeo.com/moogaloop.swf?clip_id=%s';
                                      $thumbnail_str = $hash[0]['thumbnail_small'];
                                      $fullsize_str = $hash[0]['thumbnail_large'];
                                  } else {
                                      // don't use, couldn't find what we need
                                      unset($video_id);
                                  }
                              } catch (Exception $e) {
                                  unset($video_id);
                              }
                          }
                      }
                  }
                  // check if we have a video id, if so, add the video metadata
                  if (!empty($video_id)) {
                      // add to return
                      $videos[] = array(
                          'url' => sprintf($video_str, $video_id),
                          'thumbnail' => sprintf($thumbnail_str, $video_id),
                          'fullsize' => sprintf($fullsize_str, $video_id)
                      );
                  }
              }
          }
      }
      // return array of parsed videos
      return $videos;
  }
}

if ( ! function_exists('getVimeoVideoIdFromUrl')) {
  function getVimeoVideoIdFromUrl($url = '') {
      $regs = array();
      $id = '';
      if (preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $url, $regs)) {
          $id = $regs[3];
      }
      return $id;
  }
}

/**
 * [To get embedded live video url]
 * @param string $url
 * @param string $type
*/
if ( ! function_exists('parseLiveVideo')) {
  function parseLiveVideo($url,$type = 'youtube') {
    $parsedURL = '';
    switch ($type) {
      case 'youtube':
        $parsedURL = str_replace('watch?v=', 'embed/', $url);
        break;
      case 'vimeo':
        $vid  = getVimeoVideoIdFromUrl($url);
        $parsedURL = 'https://player.vimeo.com/video/'.$vid;
        break;
      default:
        $parsedURL = '';
        break;
    }
    return $parsedURL;
  }
}

/**
 * [To export DOC file]
 * @param string $html
 * @param string $filename
*/
if ( ! function_exists('exportDOCFile')) {
  function exportDOCFile($html,$filename = ''){
    $$filename = (!empty($filename)) ? $filename : 'document';
    header("Content-type: application/vnd.ms-word");
    header("Content-Disposition: attachment;Filename=".$filename.".doc");
    echo $html;
  }
}

/**
 * [To get user ip address]
*/
if (!function_exists('getRealIpAddr'))
{
    function getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
        {   //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip = $_SERVER['REMOTE_ADDR']; //'103.15.66.178';//
        }
        return $ip;
    }
}

/**
 * [Create GUID]
 * @return string
 */
if (!function_exists('get_guid'))
{
    function get_guid()
    {
        if (function_exists('com_create_guid'))
        {
            return strtolower(com_create_guid());
        }
        else
        {
            mt_srand((double) microtime() * 10000); //optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45); // "-"
            $uuid = substr($charid, 0, 8) . $hyphen
                    . substr($charid, 8, 4) . $hyphen
                    . substr($charid, 12, 4) . $hyphen
                    . substr($charid, 16, 4) . $hyphen
                    . substr($charid, 20, 12);
            return strtolower($uuid);
        }
    }
}

/**
 * [get_domain Get domin based on given url]
 * @param  string $url
 */
if ( ! function_exists('get_domain')) 
{ 
    function get_domain($url)
    {
      $pieces = parse_url($url);
      $domain = isset($pieces['host']) ? $pieces['host'] : '';
      if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
        return $regs['domain'];
      }
      return false;
    }
}

/**
 * [to check url is 404 or not]
 * @param  string $url
 */
if ( ! function_exists('get_domain')) 
{ 
  function is_404($url) {
      $handle = curl_init($url);
      curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

      /* Get the HTML or whatever is linked in $url. */
      $response = curl_exec($handle);

      /* Check for 404 (file not found). */
      $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
      curl_close($handle);

      /* If the document has loaded successfully without any redirection or error */
      if ($httpCode >= 200 && $httpCode < 300) {
          return false;
      } else {
          return true;
      }
  }
}

/**
 * [get_ip_location_details Get location details based on given IP Address]
 * @param  [string] $ip_address [IP Adress]
 * @return [array]           [location details]
 */
if ( ! function_exists('get_ip_location_details')) 
{    
    function get_ip_location_details($ip_address) 
    {
        $url = "http://api.ipinfodb.com/v3/ip-city/?key=" . IPINFODBKEY . "&ip=" . $ip_address . "&timezone=true&format=json";
        $location_data = json_decode(ExecuteCurl($url), true);
        return $location_data;
    }
}

/**
* [geocoding_location_details Get location details based on given geo coordinate]
* @param  [string] $latitude  [latitude]
* @param  [string] $longitude [longitude]
* @return [array]            [location details]
*/
if(!function_exists('geocoding_location_details'))
{    
    function geocoding_location_details($latitude, $longitude)
    {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$latitude.",".$longitude;
        $details = json_decode(file_get_contents($url));
        return $details;
    }
}

/**
* [To Format Bytes]
* @param  [integer] $bytes
*/
if (!function_exists('formatSizeUnits'))
{
    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = NumberFormat($bytes / 1073741824) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = NumberFormat($bytes / 1048576) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = NumberFormat($bytes / 1024) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = NumberFormat($bytes) . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = NumberFormat($bytes) . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}

/**
* [To Get offset using page no, limit]
* @param  [integer] $PageNo
* @param  [integer] $Limit
*/
if (!function_exists('getOffset'))
{
    function getOffset($PageNo, $Limit)
    {
        if (empty($PageNo))
        {
            $PageNo = 1;
        }
        $offset = ($PageNo - 1) * $Limit;
        return $offset;
    }
}

/**
 *
 * @param   date_format
 * @return  Current UTC Date       
 */
if (!function_exists('get_current_date'))
{

    function get_current_date($date_format, $timediff = 0, $plus = 0, $time = 0)
    {
        $CI = & get_instance();
        $CI->load->helper('date');
        $now = now();
        if ($time)
        {
            $now = $time;
        }
        if ($timediff)
        {
            if ($plus)
            {
                $now = $now + (24 * 60 * 60 * $timediff);
            }
            else
            {
                $now = $now - (24 * 60 * 60 * $timediff);
            }
        }
        //echo mdate($date_format,$now);
        return mdate($date_format, $now);
    }

}

/**
* [To Save Image File From Live Server]
* @param  [string] $file
* @param  [string] $subfolder
*/
if (!function_exists('save_file_from_server'))
{
  function save_file_from_server($file,$subfolder){
    $explode_file = explode(".", $file);
    if(!empty($explode_file) && !is_404($file)){
      $ext      = end($explode_file);
      $pic      = file_get_contents($file);
        $filename = time().uniqid().'.'.$ext;
        $path     = 'uploads/'.$subfolder."/".$filename;
        file_put_contents($path, $pic);
        chmod($path, 0777);
        return $filename;
    }else{
      return "";
    }
  }
}

/**
* [To Check Live URL File Is Exist Or Not]
* @param  [string] $url
*/
if (!function_exists('is_404'))
{
  function is_404($url) {
      $handle = curl_init($url);
      curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

      /* Get the HTML or whatever is linked in $url. */
      $response = curl_exec($handle);

      /* Check for 404 (file not found). */
      $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
      curl_close($handle);

      /* If the document has loaded successfully without any redirection or error */
      if ($httpCode >= 200 && $httpCode < 300) {
          return false;
      } else {
          return true;
      }
  }
}
/*************************************************************/
/*************************************************************/
/*************************************************************/
if(!function_exists('send_android_notification')) {
function send_android_notification($data, $target,$badges = 0,$update_badges_condition = array()){
$CI = & get_instance();

$fields = array
       (
       	'data' => $data
   	);

   if(is_array($target)){
$fields['registration_ids'] = $target;
} else {
$fields['to'] = $target;
}
   $server_key = 'AIzaSyDEiGNYzs9FYa9M7L7u6dOTM9vtdukLTJg';

   $headers = array
       (
       'Authorization: key=' . $server_key,
       'Content-Type: application/json'
   );

   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
   curl_setopt($ch, CURLOPT_POST, true);
   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
   $result = curl_exec($ch);
   $resp   = json_decode($result);
   if($resp->success == 1){
   	log_message('ERROR',"GCM - Message send successfully, message - ".$data['body']);
   }else{
   	log_message('ERROR',"GCM - Message failed, message - ".$data['body']);
   }
   curl_close($ch);

/* To update user badges */
/*if(!empty($update_badges_condition) && isset($update_badges_condition['user_id'])){
$device_badges = $badges + 1;
$CI->Common_model->updateFields(USERS, array('badges' => $device_badges), array('id' => $update_badges_condition['user_id']));
}*/
}
}
/*************************************************************/
/*************************************************************/
/*************************************************************/

if(!function_exists('send_ios_notification')) {
function send_ios_notification($deviceToken, $message,$params = array(),$badges = 0,$update_badges_condition = array()) {
$CI = & get_instance();
// Put your private key's passphrase here:
$passphrase = '123';
$user_certificate_path = APPPATH . "/third_party/swpush.certi.pem";

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', $user_certificate_path);
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
$fp = stream_socket_client(APNS_GATEWAY_URL, $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp) {
log_message('ERROR',"APN: Maybe some errors: $err: $errstr, message - ".$message);
} else {
log_message('ERROR',"Connected to APNS, message - ".$message);
}


// Create the payload body
$body['aps'] = array(
'alert' => $message,
'params'=> $params,
'badge'=> (int)$badges,
'sound' => 'default'
);

// Encode the payload as JSON
$payload = json_encode($body);

// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));

if (!$result) {
log_message('ERROR',"APN: Message not delivered, message - ".$message);
} else {
/* To update user badges */
/*if(!empty($update_badges_condition) && isset($update_badges_condition['user_id'])){
$device_badges = $badges + 1;
$CI->Common_model->updateFields(USERS, array('badges' => $device_badges), array('id' => $update_badges_condition['user_id']));
}*/
log_message('ERROR',"APN: Message successfully delivered, message - ".$message);
}

// Close the connection to the server
fclose($fp);
}
}
/*************************************************************/
if ( ! function_exists('array_multi_subsort')){
   function array_multi_subsort($array, $subkey){ 
       $b = array(); $c = array();
       foreach ($array as $k => $v)
       {
           $b[$k] = strtolower($v->$subkey);
       }
       asort($b);
       foreach ($b as $key => $val)
       {
           $c[] = $array[$key];

       }

       return array_reverse($c);

   }

}
/*************************************************************/
/*************************************************************/
/*************************************************************/


/*************************************************************/
/********************************/
/********************************/ 
if ( ! function_exists('alert')) {  
  function alert($msg='', $type='success_msg') {
    $CI =& get_instance();?>

 <?php if (empty($msg)): ?>
        <?php if ($CI->session->flashdata('success_msg')): ?>
        <?php echo success_alert($CI->session->flashdata('success_msg')); ?>
        <?php endif ?>
        <?php if ($CI->session->flashdata('error_msg')): ?>
        <?php echo error_alert($CI->session->flashdata('error_msg')); ?>
        <?php endif ?>
        <?php if ($CI->session->flashdata('info_msg')): ?>
        <?php echo info_alert($CI->session->flashdata('info_msg')); ?>
        <?php endif ?>
        <?php else: ?>
        <?php if ($type == 'success_msg'): ?>
        <?php echo success_alert($msg); ?>
        <?php endif ?>
        <?php if ($type == 'error_msg'): ?>
        <?php echo error_alert($msg); ?>
        <?php endif ?>
        <?php if ($type == 'info_msg'): ?>
        <?php echo info_alert($msg); ?>
        <?php endif ?>
<?php endif; ?>
<?php } }
/**
* Success alert
*/
if ( ! function_exists('success_alert')) {  
  function success_alert($msg = '') {?>
		<div class="alert alert-success">
		  <button data-dismiss="alert" class="close" type="button">X</button>
		  <strong>Success!</strong> <?php echo $msg ?>
		</div>
<?php  } }
/**
* Error alert
*/
if ( ! function_exists('error_alert')) {  
	  function error_alert($msg = '') { ?>
		<div class="alert alert-danger">
		  <button data-dismiss="alert" class="close" type="button">X</button>
		  <strong>Warning!</strong> <?php echo $msg ?>
		</div>
  <?php   } }
/**
* info alert
*/
if ( ! function_exists('info_alert')) { 
		function info_alert($msg = '') {?>
		<div class="alert alert-info">
		 <button data-dismiss="alert" class="close" type="button">X</button>
		<strong>Info: </strong> <?php echo $msg ?>
		</div>
  <?php } }
/**
* In cart
*/
/************************************/
if(!function_exists('in_cart')){
		function in_cart($product_id = null){
		$CI = & get_instance();
		if ($CI->cart->total_items() > 0)
			{
				$in_cart = array();
				// Fetch data for all products in cart
				foreach ($CI->cart->contents() AS $item)
				{
					$in_cart[$item['id']] = $item['qty'];
				}
				if ($product_id)
				{
					if (array_key_exists($product_id, $in_cart))
					{
						return $in_cart[$product_id];
					}
					return null;
				}
				else
				{
					return $in_cart;
				}
			}
			return null;
		  }
}
/**
 * [To get data row count]
 * @param string $table
 * @param array $where
*/
if (!function_exists('getSingleRecord')){
  function getSingleRecord($table, $where = '', $fld = NULL, $order_by = '', $order = ''){
    $CI = & get_instance();
    if(!empty($table) && !empty($where)){
      $singleRecord = $CI->sr_model->getsingle($table, $where, $fld, $order_by, $order);
    }
    return $singleRecord;
  }
}
/**
* [To get data row count]
* @param string $table
* @param array $where
*/
if ( ! function_exists('getAllCount')) {
  function getAllCount($table,$where="")
  {
    $CI = & get_instance();
    if(!empty($where)){
      $CI->db->where($where);
    }
    $q = $CI->db->count_all_results($table);
    return addZero($q);
  }
}

   function send_email($options)
    {
        $CI =& get_instance();
        $CI->load->library('email');
        $fromemail = 'no-reply@webandappdevelopers.com';
        $fromname = 'No Reply';

        $config=array(
        'charset'=>'utf-8',
        'wordwrap'=> TRUE,
        'mailtype' => 'html'
        );
       
        $mesg = $CI->load->view('email/email_body',['message'=>$options['message']],true);  



        $CI->email->initialize($config);

        $CI->email->to($options['to_email'],($options['name'] ? $options['name'] : ''));
        $CI->email->from($fromemail, $fromname);
        $CI->email->subject($options['subject']);
        $CI->email->message($mesg);
        return $CI->email->send();
    }








/**
* countAllBrands
* @param int $no
*/
if ( ! function_exists('countAllBrands')) {
  function countAllBrands()
  {
    $CI = & get_instance();
   $products=$CI->sr_model->getAllwhere('products',array('status'=>0),'UNIQUE_KEY','DESC','all','','','BRAND_NAME');
   $total_count=$products['total_count'];
    return addZero($total_count);
  }
}
if ( ! function_exists('countAllproducts')) {
  function countAllproducts()
  {
    $CI = & get_instance();
   $products=$CI->sr_model->getAllwhere('products',array('status'=>0),'UNIQUE_KEY','DESC','all','','','PRODUCT_TITLE');
   $total_count=$products['total_count'];
    return addZero($total_count);
  }
}
/**
* [To print number in standard format with 0 prefix]
* @param int $no
*/
if ( ! function_exists('getAllBrands')) {
  function getAllBrands()
  {
    $CI = & get_instance();
   $products=$CI->sr_model->getAllwhere('products',array('status'=>0),'UNIQUE_KEY','DESC','all',$limit,$offset,'BRAND_NAME');
   $total_count=$products['total_count'];
    return addZero($total_count);
  }
}
/**
* [To print number in standard format with 0 prefix]
* @param int $no
*/
if ( ! function_exists('addZero')) {
  function addZero($no)
  {
    if($no >= 10){
      return $no;
    }else{
      return "0".$no;
    }
  }
}

/* End of file custom_helper.php */
/* Location: ./application/helpers/custom_helper.php */


//get product detail
function get_warehouse($partid='',$pid='',$color='')
{
    
$xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns="http://www.promostandards.org/WSDL/Inventory/2.0.0/" xmlns:shar="http://www.promostandards.org/WSDL/Inventory/2.0.0/SharedObjects/">
  <soapenv:Header/>
  <soapenv:Body>
     <ns:GetInventoryLevelsRequest>
        <shar:wsVersion>2.0.0</shar:wsVersion>
        <shar:id>jonsolnar</shar:id>
        <!--Optional:-->
        <shar:password>12341234</shar:password>
        <shar:productId>'.$pid.'</shar:productId>
        <!--Optional:-->
		<shar:Filter>
           <!--Optional:-->
           <shar:partId>'.$partid.'</shar:partId>
           <shar:PartColorArray>
             <shar:partColor>'.$color.'</shar:partColor>
          </shar:PartColorArray>
        </shar:Filter>
     </ns:GetInventoryLevelsRequest>
  </soapenv:Body>
</soapenv:Envelope>';
$url = "https://uat-ws.sanmar.com:8080/promostandards/InventoryServiceBindingV2?wsdl";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
$headers = array();
array_push($headers, "Content-Type: text/xml; charset=utf-8");
array_push($headers, "Accept: text/xml");
array_push($headers, "Cache-Control: no-cache");
array_push($headers, "Pragma: no-cache");
array_push($headers, "SOAPAction: http://api.soap.website.com/WSDL_SERVICE/GetShirtInfo");
if($xml != null) {
    curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml");
    array_push($headers, "Content-Length: " . strlen($xml));
}
curl_setopt($ch, CURLOPT_USERPWD, "jonsolnar:12341234"); /* If required */
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
$xml = new SimpleXMLElement($response);
$body = $xml->xpath('//SBody')[0];
return $array = json_decode(json_encode((array)$body), TRUE); 
}
?>