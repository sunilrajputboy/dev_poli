<?php
error_reporting(1);
if(isset($_GET['dataSetKey']) && !empty($_GET['dataSetKey'])){
class Srclasss {

 function dbConnect(){
	      $conn = new mysqli('localhost','visualisationpol_stage','visualisationpol_stage','visualisationpol_dev');
			if (!$conn) {
				die("Connection failed: " . mysqli_connect_error());
			}
			mysqli_set_charset($conn, "latin1");
			return $conn;
 }
 public  function selectTwoTableData($data = "*", $table1, $table2, $on, $condition = "", $urlcondition = "",$clientidCondition = "", $order_cloumn = "", $asc_decs = "", $ofset = "", $limit = "")
 {
	 $connection = $this->dbConnect();
	 $query = "SELECT " . $data . " FROM " . $table1 . " LEFT JOIN " . $table2 . " ON " . $on;
	 if ($condition != "") {
		 $query .= " WHERE " . $condition . " OR " . $urlcondition .' AND '. $clientidCondition;
	 }
	 if ($order_cloumn != "" && $asc_decs != "") {
		 $query .= " ORDER BY " . $order_cloumn . " " . $asc_decs;
	 }
	 if ($ofset != "" && $limit != "") {
		 $query .= " LIMIT " . $ofset . "," . $limit;
	 }
	 $result = $connection->query($query);
	 $rowss = $result->fetch_assoc();
	 return $rowss;
 }

	public  function getNodeDetails($project_id) {
		$connection=$this->dbConnect();
		$query = "SELECT map_template_regions.name, map_template_regions.fname, map_template_regions.lname, map_template_regions.party, map_template_regions.twitter_handle, map_template_regions.prefix, map_template_regions.email, map_template_regions.profile_url, project_fields.field_name,project_fields.display_name, data_field_value.field_value, data_field_value.field_id FROM `data_field_value`,project_fields,map_template_regions WHERE  data_field_value.`pro_id`='".$project_id."' AND map_template_regions.id=data_field_value.city_id AND data_field_value.field_id=project_fields.id_project_field AND project_fields.isGroup=0 AND data_field_value.city_id IN(SELECT DISTINCT(`city_id`) FROM `data_field_value` WHERE `pro_id`='$project_id') ORDER BY `map_template_regions`.`name` ASC";
		$result = $connection->query($query);
		return $result;
	 }
 function selectThreeTableData($data="*",$table1,$table2,$table3,$on,$on3,$condition="",$order_cloumn="",$asc_decs="",$ofset="", $limit="") {

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
 
  function selectsingleTableDatabyid($id) {

	$connection=$this->dbConnect();  
	$query = "SELECT * FROM `project_fields` WHERE `id_project` = $id";
	$result = $connection->query($query);
    return $result;
 }
 
   function findcountrydata($id) {
	$connection=$this->dbConnect();  
	$query = "SELECT * FROM `map_template_regions` WHERE `id_map_template` = $id";
	$result = $connection->query($query);
    return $result;
 }
 public  function selectClientbyURL($url)
 {
	 $connection = $this->dbConnect();
	 $query = "SELECT * FROM `clients` WHERE `unique_url` = '$url'";
	 $result = $connection->query($query);
	 $rowss = $result->fetch_assoc();
	 return $rowss;
 }
 
   function getfieldNamebyid($id) {
	$connection=$this->dbConnect();  
	$query = "SELECT * FROM `project_fields` WHERE `id_project_field` = $id";
	$result = $connection->query($query);
    return $result;
 }
   function datafieldvaluedata($proid) {
	$connection=$this->dbConnect();  
	$queryNodes = "SELECT* FROM `data_field_value` INNER JOIN `map_template_regions` ON data_field_value.city_id = map_template_regions.id WHERE data_field_value.pro_id = $proid";
	$result = $connection->query($queryNodes);
    return $result;
 }
 
  function selectsingleClientbyid($id) {
	$connection=$this->dbConnect();  
	$query = "SELECT * FROM `clients` WHERE `id` = $id";
	$result = $connection->query($query);
		$rowss = $result->fetch_assoc();
		return $rowss;
 }
 	public   function getdatafieldwithoutgroup($proid) {
		$connection=$this->dbConnect();  
		$query = "SELECT * FROM `project_fields` WHERE `id_project` = $proid AND `isGroup` = '0'";
		$result = $connection->query($query);
		return $result;
	 }
 	public   function getProjectDetails($dataSetKey,$cid) {
		$connection=$this->dbConnect();  
		$query = "SELECT * FROM `projects` INNER JOIN `map_templates` ON `map_templates`.`id_map_templates` = `projects`.`id_map_template` INNER JOIN `data_field_value_new` ON `data_field_value_new`.`pro_id` = `projects`.`id_project` WHERE (`projects`.`proKey` = '$dataSetKey' OR `projects`.`unique_url`='$dataSetKey') AND `projects`.`id_client` = '$cid' LIMIT 1";
		$result = $connection->query($query);
		$rowss = $result->fetch_assoc();
		return $rowss;
	 } 
	public  function getNodeDetailsNew($projectId){
		$connection=$this->dbConnect();
		$query = "SELECT data_field_value_new.id,data_field_value_new.city_id,data_field_value_new.pro_id,CONVERT(data_field_value_new.field_value_data USING utf8) as field_value_data,map_template_regions.name, map_template_regions.fname, map_template_regions.lname, map_template_regions.party, map_template_regions.twitter_handle, map_template_regions.prefix, map_template_regions.email, map_template_regions.profile_url FROM `data_field_value_new` LEFT JOIN map_template_regions ON data_field_value_new.city_id=map_template_regions.id WHERE data_field_value_new.pro_id='$projectId'";
		$result = $connection->query($query);
		return $result;
		 }
	public  function selectProjecFieldsBySequence($projectId,$sequenced_id){
		$connection=$this->dbConnect();
		$query = "SELECT * FROM `project_fields` WHERE `id_project` =$projectId AND isGroup=0 ORDER BY FIELD(`id_project_field`,$sequenced_id)";
		$result = $connection->query($query);
		return $result;
		 }
		 
   public  function selectProjecFields($projectId){
		$connection=$this->dbConnect();
		$query = "SELECT * FROM `project_fields` WHERE `id_project` =$projectId AND isGroup=0";
		$result = $connection->query($query);
		return $result;
		 }
public function mb_unserialize($string) {
    $string2 = preg_replace_callback(
        '!s:(\d+):"(.*?)";!s',
        function($m){
            $len = strlen($m[2]);
            $result = "s:$len:\"{$m[2]}\";";
            return $result;

        },
        $string);
    return unserialize($string2);
} 		 
}
 
$srObject= new Srclasss();
$dataSetKey = $_GET['dataSetKey'];
$client_unique_url = $_GET['client'];
$uniqueClient = $srObject->selectClientbyURL($client_unique_url);
$cid = $uniqueClient['id'];
$prdtk = $srObject->getProjectDetails($dataSetKey,$cid);
$row=$prdtk;
$maindata=array();
$nodeDetails=$srObject->getNodeDetailsNew($row['id_project']);
$datafieldId=array();
$nodesarray = array();
$dataValuePerField = array();
define("BASE_URL","https://dev.visualisation.polimapper.co.uk/");

if(!empty($nodeDetails)){
	$nodeValues = mysqli_fetch_assoc($nodeDetails);
	
	$firstRow=($nodeValues['field_value_data']) ? unserialize($nodeValues['field_value_data']): array();
	if(!empty($firstRow)){
		$datafieldId = array_reduce($firstRow, function($carry, $item) {
		return array_merge($carry, array_keys($item));
		}, array());
		}
}
	//echo "<pre>"; print_r($datafieldId);  echo "</pre>"; 
		//GET DATAFIELDS
		if(!empty($datafieldId)){
		 $sequenced_id=implode(',',$datafieldId);
		 $datafieldData1=$srObject->selectProjecFieldsBySequence($row['id_project'],$sequenced_id);
		}else{
		 $datafieldData1=$srObject->selectProjecFields($row['id_project']);	
		}
	
	$dfieldcount=0;
   while ($rows = mysqli_fetch_assoc($datafieldData1)){
	  $dfieldcount++;
    $datafieldData[] = $rows;
   }
	
//echo "<pre>"; print_r($nodeDetails->fetch_all(MYSQLI_ASSOC)); echo "</pre>"; die();
$cnt=0;
if(!empty($nodeDetails)){
	foreach($nodeDetails as $node_data){ 
					$field_value_data=($node_data['field_value_data']) ? $srObject->mb_unserialize($node_data['field_value_data']): array();
					$dfieldcount=count($field_value_data);
					if(!empty($field_value_data)){
						$dfc=0;
						$fieldDataarr=array();
						foreach($field_value_data as $val){
							$value = current($val);
							$key = key($val);
							$dataValuePerField[$key][]=$value;
							$index = array_search($key, array_column($datafieldData, 'id_project_field'));
							$fv=$value;
							$field_value=null;
							if(strlen(trim($value))>0 && strlen(trim($value)) == 0){
								$fv=null;
							}
							if($fv=="" || $fv==" "){
								$fv=null;
							}
							if($datafieldData[$index]['field_type'] != 'Text' && $fv != null){
								 $fv=str_replace(",","",$value);
							}
							$field_value=$fv;
							if (empty($datafieldData[$index]['display_name']) || $datafieldData[$index]['display_name'] == ""){
								$display_name = $datafieldData[$index]['field_name'];
								}else{
								$display_name=$datafieldData[$index]['display_name'];
								}
								
							//$fieldDataarr[$display_name] = array($display_name=> $field_value);
							$fieldDataarr[] = array(
							'name' => $datafieldData[$index]['field_name'],
							'display_name' => $datafieldData[$index]['display_name'],
							'value'=> $field_value
							);
							
							if($dfieldcount==$dfc+1){ 
						
							if ($row['id_map_template'] == 8 || $row['id_map_template'] == 19) {
								
								$mparray = array("fname" =>$node_data['fname'], "lname" =>$node_data['lname'], "party" => $node_data['party'], "twitter_handle" =>$node_data['twitter_handle'], 'prefix' => $node_data['prefix'], 'email' =>$node_data['email'], 'profile_url' =>$node_data['profile_url']);
							} else {
								$mparray = null;
							}
							$node_arr = array(
								"name" => $node_data['name'],
								"mpdetails" => !empty($mparray) ? $mparray  : null,
								"node_text"=>$node_data['node_text'],
								"node_image"=>$node_data['node_image'],
								"data" => $fieldDataarr
							);
	
							if (!in_array($node_arr, $nodesarray)) {
								$nodesarray[] = $node_arr;
							}
								//if($cnt==28){ echo "<pre>";  print_r($nodesarray); echo "</pre>"; die(); }
						}
						$dfc++;
						}
					}
				}
}

header('Content-Type: application/json;charset=utf-8');
$maindata['nodes'] = $nodesarray;
$json_string = json_encode($maindata, JSON_INVALID_UTF8_IGNORE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
echo $json_string;

}else{
	echo json_encode(array("status"=>400,'dataSetKey is empty or unavailable'));
}

                                      
?>