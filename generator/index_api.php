<?php
error_reporting(1);
$origin = $_SERVER['HTTP_ORIGIN'];
header('Content-Type: application/json;charset=utf-8');
header('Content-Type: text/html; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Origin: ' . $origin);
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
if(isset($_GET['dataSetKey']) && !empty($_GET['dataSetKey'])){
class Srclasss {
	
	private function dbConnect(){
		 $conn = new mysqli('localhost', 'codealea_polimapper', '=#x@BIKn_^1m', 'codealea_polimapper');
		 if(!$conn){
			die("Connection failed: " . mysqli_connect_error());
		   }
		   return $conn;
	 }
 
	public  function selectTwoTableData($data="*",$table1,$table2,$on,$condition="",$urlcondition="",$order_cloumn="",$asc_decs="",$ofset="", $limit="") {
		$connection=$this->dbConnect();  
		$query = "SELECT ".$data." FROM ".$table1." LEFT JOIN ".$table2." ON ".$on;
		if($condition!=""){
		$query.=" WHERE ".$condition." OR ".$urlcondition;
		}
		if($order_cloumn!="" && $asc_decs!=""){
		 $query.=" ORDER BY ".$order_cloumn." ".$asc_decs;  
		}
		if($ofset!="" && $limit!=""){
		 $query.=" LIMIT ".$ofset.",".$limit;	
		}
		$result = $connection->query($query);
		$rowss = $result->fetch_assoc();
		return $rowss;
	 }
 
	public function selectThreeTableData($data="*",$table1,$table2,$table3,$on,$on3,$condition="",$order_cloumn="",$asc_decs="",$ofset="", $limit="") {

		$connection=$this->dbConnect();  
		$query = "SELECT ".$data." FROM ".$table1." LEFT JOIN ".$table2." ON ".$on." LEFT JOIN ".$table3." ON ".$on3;
		if($condition!=""){
		$query.=" WHERE ".$condition;
		}
		if($order_cloumn!="" && $asc_decs!=""){
		 $query.=" ORDER BY ".$order_cloumn." ".$asc_decs;  
		}
		if($ofset!="" && $limit!=""){
		 $query.=" LIMIT ".$ofset.",".$limit;	
		}
		$result = $connection->query($query);
		return $result;
	 }
	 
	public  function selectsingleTableDatabyid($id) {

		$connection=$this->dbConnect();  
		$query = "SELECT * FROM `project_fields` WHERE `id_project` = $id";
		$result = $connection->query($query);
		return $result;
	 }
 
	public   function findcountrydata($id) {
		$connection=$this->dbConnect();  
		$query = "SELECT * FROM `map_template_regions` WHERE `id_map_template` = $id";
		$result = $connection->query($query);
		return $result;
	 }
 
	public   function getfieldNamebyid($id) {
		$connection=$this->dbConnect();  
		$query = "SELECT * FROM `project_fields` WHERE `id_project_field` = $id";
		$result = $connection->query($query);
		return $result;
	 }
	 
	 	public   function getdatafieldwithoutgroup($proid) {
		$connection=$this->dbConnect();  
		$query = "SELECT * FROM `project_fields` WHERE `id_project` = $proid AND `isGroup` = '0'";
		$result = $connection->query($query);
		return $result;
	 }
	 
	public   function datafieldvaluedata($proid) {
		$connection=$this->dbConnect();  
		$queryNodes = "SELECT* FROM `data_field_value` INNER JOIN `map_template_regions` ON data_field_value.city_id = map_template_regions.id WHERE data_field_value.pro_id = $proid";
		$result = $connection->query($queryNodes);
		return $result;
	 }
 
	public  function selectsingleClientbyid($id) {
		$connection=$this->dbConnect();  
		$query = "SELECT * FROM `clients` WHERE `id` = $id";
		$result = $connection->query($query);
		$rowss = $result->fetch_assoc();
		return $rowss;
	 }
	public  function getfontName($id) {
		$connection=$this->dbConnect();  
		$query = "SELECT font_family FROM `fonts` WHERE `id` = $id";
		$result = $connection->query($query);
		$rowss = $result->fetch_assoc();
		return $rowss;
	 }
	 
	public  function getNodeDetails($project_id) {
		$connection=$this->dbConnect(); 
		$query = "SELECT map_template_regions.name, map_template_regions.fname, map_template_regions.lname, map_template_regions.party, map_template_regions.twitter_handle, map_template_regions.prefix, map_template_regions.email, map_template_regions.profile_url, project_fields.field_name, data_field_value.field_value FROM `data_field_value`,project_fields,map_template_regions WHERE  data_field_value.`pro_id`='".$project_id."' AND map_template_regions.id=data_field_value.city_id AND data_field_value.field_id=project_fields.id_project_field AND project_fields.isGroup=0 AND data_field_value.city_id IN(SELECT DISTINCT(`city_id`) FROM `data_field_value` WHERE `pro_id`='$project_id') ORDER BY `data_field_value`.`city_id` ASC";
		$result = $connection->query($query);
		return $result;
	 }
	 
	public  function getmaxFieldValue($id_field,$pro_id) {
		$connection=$this->dbConnect();  
		$query = "SELECT MAX(cast(`field_value` as unsigned)) AS 'max' FROM `data_field_value` WHERE `field_id` = $id_field AND pro_id='$pro_id'";
		$result = $connection->query($query);
		$rowss = $result->fetch_assoc();
		return $rowss;
	 }
	 public  function getMinFieldValue($id_field,$pro_id){
		$connection=$this->dbConnect();  
		$query = "SELECT MIN(cast(`field_value` as unsigned)) AS 'min' FROM `data_field_value` WHERE `field_id` = $id_field AND pro_id='$pro_id'";
		$result = $connection->query($query);
		$rowss = $result->fetch_assoc();
		return $rowss;
	 }
	 public  function getSumFieldValue($id_field,$pro_id) {
		$connection=$this->dbConnect();  
		$query = "SELECT SUM(cast(`field_value` as unsigned)) AS 'sum' FROM `data_field_value` WHERE `field_id` = $id_field AND pro_id='$pro_id'";
		$result = $connection->query($query);
		$rowss = $result->fetch_assoc();
		return $rowss;
	 }
}
/*************/
$srObject= new Srclasss();
$dataSetKey = $_GET['dataSetKey'];

$prdtk=$srObject->selectTwoTableData('projects.*,map_templates.*','projects','map_templates','projects.id_map_template=map_templates.id_map_templates',"projects.proKey='".$dataSetKey."'","projects.unique_url='".$dataSetKey."'");

// $prdtk=$srObject->selectTwoTableData('projects.*,map_templates.*','projects','map_templates','projects.id_map_template=map_templates.id_map_templates',"projects.unique_url='".$dataSetKey."'");
// New_current_9_sep

$row=$prdtk;

$maindata=array();

$datafieldData=$srObject->selectsingleTableDatabyid($row['id_project']);
$countryData=$srObject->findcountrydata($row['id_map_template']);
$clientData=$srObject->selectsingleClientbyid($row['id_client']);
$nodeDetails=$srObject-> getNodeDetails($row['id_project']);

$clientlogo=null;
$clientlogofile=null;
if(!empty($clientData)){
  $clientlogo  = $clientData['logo'];
  $clientlogofile=$clientData['logofile'];
}

$kklr=!empty($row['key_colors']) ? count(unserialize($row['key_colors'])) :0;

$maindata['key']=$row['proKey'];
	
	$key = 'Hl2018@1212';
    $encrypted_id = openssl_encrypt($row['id_map_templates'],'AES-128-ECB',$key, OPENSSL_RAW_DATA);
    $encrypted_id = strtolower(bin2hex($encrypted_id));
     $maindata['topology']=array(
		"mapTemplatePath"=> $row['mapTemplatePath'],
		"id"=> $encrypted_id,
		"name"=> $row['map_name'],
		"labelForSingularNode"=> $row['labelForSingularNode'],
		"labelForPluralNode"=> $row['labelForPluralNode'],
		"labelForNodeSearch"=>$row['labelForNodeSearch']
		);
		
		if($row['password'] == null){
		    $pass = null;
		}else{
		    $pass = openssl_decrypt(hex2bin($row['password']), 'AES-128-ECB', 'Hl2018@1212', OPENSSL_RAW_DATA);
		    $pass = md5($pass);
		}
			
    // 	project status
	  $maindata['project_status']=array(
		"visibility" => ($row['visibility']==1) ? 'publish' : 'draft',
		"password_protected" => ($row['password_protected'] == 1) ? true : false,
		"password" => ($row['password_protected'] == 1) ?  $pass : null,
		);
		

$logo = $row['logo'];
$logoURLprojects = $row['logourl'];
	$maindata['title']=$row['title'];
	$baseURL = "https://polimapper.codealearning.co.uk/dashboard/clients/uploads/";
	$baseURL2 = "https://polimapper.codealearning.co.uk/dashboard/projects/uploads/";
	if($logo!=null){
	$maindata['logo']= $baseURL2.$logo;
	}else if($logoURLprojects!=null){
	  $maindata['logo']=$logoURLprojects;  
	}else if($clientlogofile!=null){
	  $maindata['logo']=$baseURL.$clientlogofile;  
	}else if($clientlogo!=null){
	  $maindata['logo']=$clientlogo;    
	}else{
	  $maindata['logo']="";  
	}
	

	$maindata['description']= $row['description'];
	$maindata['footerContent']= $row['footer_content'];
	$maindata['nodeDescription']= $row['node_description'];
	$maindata['dataFieldLabelStyle']= !empty($row['datafield_label_style']) ? $row['datafield_label_style'] : 'Icons';
	$maindata['numberOfKeyColours']=$kklr;
	if(!empty($row['key_colors'])){
	$keycolorlist=unserialize($row['key_colors']);
	$x = 0;
	for($i=0; $i<10;$i++){
		$x++;
	 $maindata['keyColour'.$x]=$keycolorlist[$i];   
	}
	}

	$maindata['embeddedCode']=NULL;	
	$maindata['disabled']=TRUE;	
	$maindata['primaryColour']=!empty($row['primary_color']) ? $row['primary_color'] :'#00000';
	$maindata['secondaryColour']=!empty($row['secondary_color']) ? $row['secondary_color'] :'#00000';
	$maindata['fontFamily']=empty($row['font']) ? array("font_family" => "Roboto") : $srObject->getfontName($row['font']);
	$maindata['projectLink']= "https://polimapper.codealearning.co.uk/project/".$row['unique_url'];
	$maindata['isGroup']= !empty($row['group_ids']) ? true  : false;
	$maindata['grouplinks'] = array(
		  "link1" => "https://www.polimapper.co.uk/linktoproject",
		  "link2" => "https://www.polimapper.co.uk/linktoproject",
		  "link3" => "https://www.polimapper.co.uk/linktoproject",
		  "link4" => "https://www.polimapper.co.uk/linktoproject"
	  );
	$maindata['emailMP']= ($row['is_mp'] == 'yes') ? true  : false;
	$maindata['emailMPTitle']= !empty($row['email_sub']) ? $row['email_sub']  : "";
	$maindata['emailMPMessage']= !empty($row['message']) ? $row['message']  : "";
	$maindata['socialShare'] =($row['is_social_share']=='yes') ? true  : false;
	
	
	$count = 0;
	$noOfItems = 4;
	$sociallinksarray = array(
	array(
		"name" => "facebook",
		"enable" => ($row['is_facebook']=='no') ? false : true,
		"text" => ($row['is_facebook']=='no') ? '' : $row['is_facebook']
	),
	array(
		"name" => "Instagram",
		"enable" => ($row['is_insta']=='no') ? false : true,
		"text" => ($row['is_insta']=='no') ? '' : $row['is_insta']
	),
	array(
		"name" => "Twitter",
		"enable" => ($row['is_twitter']=='no') ? false : true,
		"text" => ($row['is_twitter']=='no') ? '' : $row['is_twitter']
	),
	array(
		"name" => "LinkedIn",
		"enable" => ($row['is_linkedin']=='no') ? false : true,
		"text" => ($row['is_linkedin']=='no') ? '' : $row['is_linkedin']
	)
	);
	

	$maindata['sociallinksarray'] = $sociallinksarray;
    $maindata['emailFriend']= ($row['is_email_friend']=='yes') ? true  : false;
    $maindata['emailFriendTitle']= !empty($row['email_friend_title']) ? $row['email_friend_title']  : "";
    $maindata['emailFriendCody']= !empty($row['email_friend_text']) ? $row['email_friend_text']  : "";
    $maindata['tweetMP']= ($row['is_tweet_mp']=='yes') ? true  : false;
    $maindata['tweetMPText']= !empty($row['tweet_mp_text']) ? $row['tweet_mp_text']  : "";;

$datafieldarray = array();
$count = 0;
$min = 0;
$max = 0;
$keyInterval = 0;

foreach($datafieldData as $d){
	$keyColors=array();
/*************KEY-COLOR**********/
$fmin = $d['first_interval'];
$fmax = $d['last_interval'];
$id_field = $d['id_project_field'];
$key_colors = $d['key_colors'];
if(!empty($key_colors)){
$colorArray=unserialize($key_colors);
}else{
	if(!empty($row['key_colors'])){
$colorArray=unserialize($row['key_colors']);
	}else{
	    if(!empty($clientData['colours'])){
	    $colorArray=unserialize($clientData['colours']);
	    }else{
$colorArray=array();
}
	}
	
}
$dataMax=$srObject->getmaxFieldValue($id_field,$row['id_project']);
$dataMin=$srObject->getMinFieldValue($id_field,$row['id_project']);
$datasum=$srObject->getSumFieldValue($id_field,$row['id_project']);
$max = $dataMax['max'];
if(!empty($datasum['sum'])){
$totalValueSum = $datasum['sum'];
}else{
	$totalValueSum=0;
}


if(empty($fmin)){
$min = $dataMin['min'];
}else{
$min = $fmin;
}
if(empty($fmax)){
$max = $dataMax['max'];
}else{
$max = $fmax;
}

$maxConstant = $max;
$minConstant = $min;



$total_colors=count($colorArray);


if(!empty($fmax) && !empty($fmin)){

  if($total_colors!=0){
          $newCount = $total_colors - 2;
$keyInterval=($max - $min) / $newCount;
$keyInterval=number_format($keyInterval,2);
 $fmaxNew = $max;
}else{
$keyInterval=NULL;	
}
}else{
    
   if($total_colors!=0){
$keyInterval=($max - $min) / $total_colors;
$keyInterval=number_format($keyInterval,2);
}else{
$keyInterval=NULL;	
}
}


$keyClr=array();
if(!empty($colorArray)){
	$i=0;
	$p=0;
	foreach($colorArray as $clr){ $p++;
		$keyClr['keyColor']=$clr;
	 $maxNew  = $max - $keyInterval;
	  if($p == $total_colors) {
                                    if(!empty($fmax)){
                                     	$keyClr['minKeyValue']= '0';
                                     		$keyClr['MaxKeyValue']=number_format(($fmin),2);
                                     		  
                                    }else{
                                        	$keyClr['minKeyValue']=number_format(($min),2);
                                        		$keyClr['MaxKeyValue']=number_format(($max),2);
                                        	
                                     
                                    }
	  }else if($p == 1){
	        if(!empty($fmax)){
	            	$keyClr['minKeyValue']=number_format(($fmax),2).'+';
                                        // 		$keyClr['MaxKeyValue']=number_format(($max),2);
                                     
                                    }else{
                                        	$keyClr['minKeyValue']=number_format(($maxNew),2).'+';
                                    
                                    }
	      
	  }else{
	      
	      
	        if(!empty($fmax) && !empty($fmin)){
                                      $fminNew = $fmaxNew - $keyInterval;
                                      if($p == $total_colors - 1){
                                          $fminNew = $fmin;
                                      }
                                      	$keyClr['minKeyValue']=number_format(($fminNew),2);
                                      		$keyClr['MaxKeyValue']=number_format(($fmaxNew),2);
                                 
                                    $fmaxNew = $fmaxNew - $keyInterval;
                             
                                    
                                }else{
                                    $keyClr['minKeyValue']=number_format(($maxNew),2);
                                      		$keyClr['MaxKeyValue']=number_format(($max),2);
                                  
                                }
	      
	  }
	    $max = $max - $keyInterval;

		$keyColors[]=$keyClr;
		
		
	
		
		
// 	$i+=$keyInterval;	
	}
	
}

/************************/
    $fieldData = json_decode($d['field_data']);
	$new_arr3 = array();
     $new_arr2 = array(
	  "name" => $d['field_name'],
	  "icon" => "icon-sort-time-asc",
	  "label"=> $d['field_name'],
	  "columnIndex"=> 0,
	  "averageOverride"=> $fieldData->averageOverride,
	  "displayRankings"=> true,
	  "invertRankings"=> false,
	  "maxValue"=>$maxConstant,
	  "minValue"=> $minConstant,
	  "average"=>  $keyInterval,
	  "totalValue"=> $totalValueSum
   );

	
   $new_arr = array(
      "name" => $d['field_name'],
      "type" => $d['field_type'],
      "description" =>$d['description'],
      "groupingMethod" => $fieldData->groupingMethod,
      //"comparable" => $fieldData->comparable,
      "comparable" => true,
      "defaultComparable" => false,
      "isMultivalued" => $fieldData->isMultivalued,
      "fieldIndex" =>  $count,
      "graphType" => $fieldData->graphType,
      "includeAverageInNodeGraphs" => $fieldData->includeAverageInNodeGraphs,
      "showAverageInDataSetSummary" => $fieldData->showAverageInDataSetSummary,
      "showTotalInDataSetSummary" => $fieldData->showTotalInDataSetSummary,
      "excludeMinFromDataSetSummaryGraph" => $fieldData->excludeMinFromDataSetSummaryGraph,
      "excludeMaxFromDataSetSummaryGraph" => $fieldData->excludeMaxFromDataSetSummaryGraph,
      "excludeAverageFromDataSetSummaryGraph" => $fieldData->excludeAverageFromDataSetSummaryGraph,
      "averageOverride" => $fieldData->averageOverride,
	  "isGroup"=> !empty($d['isGroup']) ? true  : false,
	  "sequence_no"=> $d['sequence_no'],
	  "parentId"=> $d['parentId'],
	  "columns"=> [$new_arr2],
      "maxValue" =>$maxConstant,
      "minValue" =>$minConstant,
      "average" =>$keyInterval,
      "totalValue" => $totalValueSum,
	  "keyColors"=>$keyColors
       );
      array_push($new_arr2,$new_arr3); 
      array_push($datafieldarray,$new_arr); 
        $count++;
}


$row['id_map_template'];
$maindata['dataFields'] = $datafieldarray;
$datafieldValueData=$srObject->datafieldvaluedata($row['id_project']);

$dfieldcount = $srObject->getdatafieldwithoutgroup($row['id_project'])->num_rows;
$fieldDataarr = array();
if(!empty($nodeDetails)){
	$i=0;
	foreach($nodeDetails as $nd){ $i++;
		$fieldDataarr[$nd['field_name']]=array($nd['field_name']=>$nd['field_value']);
		
		if($i==$dfieldcount){
if($row['id_map_template'] == 8){
    $mparray=array("fname" => $nd['fname'], "lname" => $nd['lname'], "party" => $nd['party'], "twitter_handle" => $nd['twitter_handle'], 'prefix' => $nd['prefix'], 'email' => $nd['email'], 'profile_url' => $nd['profile_url']);  
}else{
   $mparray = null; 
}
		$node_arr = array(
           "name" => $nd['name'],
           "mpdetails" => !empty($mparray) ? $mparray  : null,
           "data" => $fieldDataarr
        );
		if(!in_array($node_arr, $nodesarray)){
					 $nodesarray[]=$node_arr;
		}
	   $i=0;
	   $mparray = array();
		  }
	}
}

$maindata['nodes'] = $nodesarray;
$json_string = json_encode($maindata, JSON_INVALID_UTF8_IGNORE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
echo $json_string;
}else{
	echo json_encode(array("status"=>400,'dataSetKey is empty or unavailable'));
}     
?>