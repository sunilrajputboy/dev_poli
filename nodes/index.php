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

 function dbConnect(){
		  $conn = new mysqli('localhost', 'visualisationpol_stage', 'visualisationpol_stage', 'visualisationpol_stage');
			if (!$conn) {
				die("Connection failed: " . mysqli_connect_error());
			}
			mysqli_set_charset($conn, "utf8");
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
}

$srObject= new Srclasss();
$dataSetKey = $_GET['dataSetKey'];
$client_unique_url = $_GET['client'];
$uniqueClient = $srObject->selectClientbyURL($client_unique_url);
$cid = $uniqueClient['id'];
$prdtk = $srObject->selectTwoTableData('projects.*,map_templates.*', 'projects', 'map_templates', 'projects.id_map_template=map_templates.id_map_templates', "projects.proKey='" . $dataSetKey . "'", "projects.unique_url='" . $dataSetKey . "'","projects.id_client=" . $cid . "");

$row=$prdtk;
$maindata=array();
$nodeDetails=$srObject-> getNodeDetails($row['id_project']);

$kklr=!empty($row['key_colors']) ? count(unserialize($row['key_colors'])) :0;

$dfieldcount = $srObject->getdatafieldwithoutgroup($row['id_project'])->num_rows;
$fieldDataarr = array();
$nodesarray = array();
if(!empty($nodeDetails)){
	$i=0;
	foreach($nodeDetails as $nd){ $i++;
		if (empty($nd['display_name']) || $nd['display_name'] == "") {
			$nd['display_name'] = $nd['field_name'];
		}
	
		$fieldDataarr[] = 
			array(
				'name' => $nd['field_name'] ? $nd['field_name'] : $nd['display_name'],
				'display_name' => $nd['display_name'] ? $nd['display_name'] : $nd['field_name'],
				'value'=> $nd['field_value']
			);

		if($i==$dfieldcount){
if($row['id_map_template'] == 8 || $row['id_map_template'] == 19){
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
	   $fieldDataarr = array();
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