<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
/*
  	@project    CSV Visual Mapping  
  	@author     Gianluca Di Battista
  	@copyright  Webmio.it
	@year 		2020
  	@version    1.0.0
  	@class  	Import
*/
class import extends Controller
{
    //**
    //  * import constructor.
    //  */
    public function __construct()
    {
    	        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);

        parent::__construct();
    }
    /**
     * Import view
     */

    public function index()
    {
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
       // error_reporting(E_ALL);
        $getTable = $this->model->getTable();
        $data = [
	            'table' => $getTable
				];
        $this->view->render('import/index', false, $data);
        exit();
    }
    
    
    public function importlist()
    {
		$this->view->js = array('import/js/importLists.js');
		$this->view->render('import/importlist');
		exit();    
		
	}
    
    /**
     * Import view table;
     */
    public function importLists()
    {
	    $this->model->importLists();
	    exit();
    } 
    
    /**
	    * GET ROWS
	   */
	public function getRows()
	{
		$uniquid = Functions::sanitizeTxt($_POST["uniquid"]);
		$table = Functions::sanitizeTxt($_POST["selected_table"]);

		$mapps = new Mapp();
        $mapps->setSelectOptionsTable($table);
		$headTable = $mapps->getSelectOptionFields();
		
		$this->model->getRows($uniquid, $table, $headTable);
		exit();
	}   
    
    
    
    /**
     * View ImportUpload
     */ 
     
    public function doImportUpload()
    {
        if($_POST)
        {
            $uploaddir = 'uploads/';
            $uploadfile = $uploaddir . basename($_FILES['file_source']['name']);
            $ext = ucfirst(pathinfo($_FILES['file_source']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, ['Csv', 'Xls', 'Xlsx', 'Xlsm', 'Xlt'])) {
                die(sprintf("Formato %s non supportato", $ext));
            }
            $ext = ($ext == 'Xlt') ? 'Xls' : $ext;
            if (move_uploaded_file($_FILES['file_source']['tmp_name'], $uploadfile))
            {
                $file_name = $_FILES['file_source']['name'];
                $use_csv_header = isset($_POST["use_csv_header"]) ? 1 : 0;
                $select_table = $_POST["select_table"];
                $filter_limit = isset($_POST["filter_limit"]) ? $_POST["filter_limit"] : 100;

                $list_mapp = $_POST["list_mapp"];
                $mapp = new Mapp();
                $mapp->setIncludeHeader($use_csv_header);
                if($list_mapp != '') {
                    $mapp->setMapId($list_mapp);
                }
				
                $mapp->setCsvFileName($file_name);
                $mapp->setFileExtension($ext);
                $mapp->setLimitRow($filter_limit);
                $mapp->setCSVdata($uploadfile);
				$mapp->setSelectOptionsTable($select_table);
				$rows_import = $mapp->count();
				
                $data = [
                    'Mapp' => $mapp,
                    'use_csv_header' => $use_csv_header,
                    'select_tables' => $select_table,
                    'filter_limit' => $filter_limit,
                    'ext' => $ext,
                    'countRow'=> $rows_import
                ];
                $this->view->render('import/import_view', false, $data);
                exit(); 
            }
            else
            {
                echo "Error on upload File";
                exit();
            }
        }
        else
        {
            // echo 'Is not Post';
            
	    header('Location:'. BASE_URL.'projects');
            exit();
        }
    }
    /**
     * doImport
     */
    public function doImport()
    {
        
        if($_POST) {
            
            $uniqJobId = uniqid(true).date('dmY');
            $importData = Functions::now(); 
             $json_response = [];
            $mapping = $_POST["mapping"];
            $Only_Needed = [];
            foreach ($mapping as $mkey => $mval) {
                if ($mval != '' && !empty($mval))
                    $Only_Needed[$mkey] = $mval;
            }
            $tmp_csv = $_POST["tmp_csv"];
            $file_name = $_POST["file_name"];
			
            if($tmp_csv){
                try {
                    $db = new Database();
					$use_csv_header = Functions::sanitizeTxt($_POST["use_csv_header"]);
					$select_table = Functions::sanitizeTxt($_POST["select_table"]);
					$filter_limit = Functions::sanitizeTxt($_POST["filter_limit"]);
                    $tmp_ext = 		Functions::sanitizeTxt($_POST["tmp_ext"]);
                    $tmp_ext = 		($tmp_ext == 'Xlt') ? 'Xls' : $tmp_ext;
					$mapp = new Mapp();
					$mapp->setIncludeHeader($use_csv_header);
                    $mapp->setFileExtension($tmp_ext);
					$mapp->setLimitRow($filter_limit);
					$mapp->setCSVdata($tmp_csv);
					$mapp->setSelectOptionsTable($select_table);
					
					$csv_items = $mapp->getCsvData();
                    $array_upload = [];
                    $rows_import = $mapp->count();
                    
                    /**
                     * ADD EXTRA PARAM TO IMPORT
                    **/

                    $setAdditionalParams = [
                        'importUniquid' => $uniqJobId,
                        'importData' => $importData
                    ];
					
                    $rows_count = 0;
                    $current_position = -1;
                    foreach ($csv_items as $csv_item)
                    {
                        $x = [];
                        foreach ($Only_Needed as $k => $v) {
                            $x[$v] = $csv_item[$k];
                        }
                       
                        $array_upload[] = array_merge($x, $setAdditionalParams);
                        $rows_count++;
                    }
                    
                    

                    $return = $db->insert_bulk($select_table, $array_upload);
                    if ($return)
                    {
                        $db->insert("import", ["importUniquid" => $uniqJobId, "filename" => $file_name, "select_table" => $select_table, "data" => $importData , "rows" => $rows_count, "ext" => $tmp_ext]);
                        $json_response = [
                            'type'=> 'success' , 'msg'=> sprintf('%s row imported correctly',  number_format($rows_count,0,'','.'))
                        ];
                        @unlink($tmp_csv);
                    }
                    else
                    {
                        $json_response = [
                            'type'=> 'error' , 'msg'=> 'Try Again'
                        ];
                    }

                } catch (Exception $ex) {
                    $json_response = [
                        'type'=> 'error' , 'msg'=> $ex->getMessage()
                    ];
                }
            }
            echo json_encode($json_response, JSON_PRETTY_PRINT);
        }
    }
    /**
     * Save Map
     */
    public function SaveMapp()
    {
        if($_POST)
        {
            $json_response = [];

            $mapping = $_POST["mapp_form"];
            $mapp_name = Functions::sanitizeTxt($_POST["mapp_name"]);
            $name_table = Functions::sanitizeTxt($_POST["select_table"]);
			$use_csv_header = Functions::sanitizeTxt($_POST["use_csv_header"]);
			
            if ($mapping)
            {
                parse_str($mapping, $mapping);
                $map_query_build = [];

                foreach ($mapping["mapping"] as $mkey => $mval)
                {
                    if ($mval != '' && !empty($mval))
                        $map_query_build[] = $mkey . '|' . $mval;
                }

                if ($map_query_build)
                {
                    $map_query_string = implode('~', $map_query_build);
                    $db = new database();
                    $sth = $db->prepare('INSERT INTO `mapping` (`name_table`,`map_name`, `map_query`, `use_header`) values (:name_table, :map_name, :map_query, :use_header)');
                    $sth->bindparam(":name_table", $name_table);
                    $sth->bindparam(":map_name", $mapp_name);
                    $sth->bindparam(":map_query", $map_query_string);
                    $sth->bindparam(":use_header", $use_csv_header);
                    $sth->execute();
                    $json_response =
                    [
                        'type'=> 'success' , 'msg'=> sprintf("Mapping `%s` saved correctly", $mapp_name)
                    ];
                }
                else
                {
                    $json_response = [
                        'type'=> 'warning' , 'msg'=> 'You have not mapped any columns'
                    ];
                }
            }
            echo json_encode($json_response, JSON_PRETTY_PRINT);
        }
    }
    /**
     * GetMaps
     */
    public function Maps()
    {
        if($_POST && !empty($_POST["name_table"]))
        {
            $name_table = Functions::sanitizeTxt($_POST["name_table"]);
            $maps = $this->model->getMaps($name_table);
            $json_response = [
                'type'=> 'success' , 'msg'=> '', 'maps'=> $maps
            ];
        }
        else{
            $json_response = [
                'type'=> 'warning' , 'msg'=> 'Try Again'
            ];
        }
        echo json_encode($json_response, JSON_PRETTY_PRINT);
    }
    
    /**
     * DelMap
     */
    public function delate($uniquid)
    {
	    if(!empty($uniquid))
	    {
		    $this->model->delate($uniquid);
		    
	    }
	    
	    header('Location:'. BASE_URL.'import/importlist');
		exit();
	    
    }
/******************************/
/* OUR CUSTOM CODE ***/
/******************************/
 public function importdata(){
        if($_POST)
        {
			$userId=$_SESSION['uid'];
			$result=$this->model->getUserById($userId);
			$userDatass=$result[0];
		    define("USERROLE", $userDatass['role']);
			
            $uploaddir = 'uploads/';
            $uploadfile = $uploaddir . basename($_FILES['file_source']['name']);
            $ext = ucfirst(pathinfo($_FILES['file_source']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, ['Csv', 'Xls', 'Xlsx', 'Xlsm', 'Xlt'])) {
                die(sprintf("Formato %s non supportato", $ext));
            }
            $ext = ($ext == 'Xlt') ? 'Xls' : $ext;
            if (move_uploaded_file($_FILES['file_source']['tmp_name'], $uploadfile))
            {
                $file_name = $_FILES['file_source']['name'];
                $project_id = $_POST['pr_id'];
                $project_key = $_POST['pr_key'];
				
                $use_csv_header = 1;
                $select_table = '';
                $filter_limit = 100;
                $list_mapp = '';
                $mapp = new Mapp();
                $mapp->setIncludeHeader($use_csv_header);
                $mapp->setCsvFileName($file_name);
                $mapp->setFileExtension($ext);
                $mapp->setLimitRow($filter_limit);
                $mapp->setCSVdata($uploadfile);
				$mapp->setSelectOptionsTable($select_table);
				$rows_import = $mapp->count();
				$getAllProjectFields=$this->model->getAllDataFields($project_id);
				
                $data = [
                    'Mapp' => $mapp,
                    'use_csv_header' => $use_csv_header,
                    'select_tables' => $select_table,
                    'filter_limit' => $filter_limit,
                    'ext' => $ext,
                    'countRow'=> $rows_import,
					'project_id'=>$project_id,
					'project_key' => $project_key,
					'allProjectFields' => !empty($getAllProjectFields) ? $getAllProjectFields : array()
                ];
					
                $this->view->dashboard('mypages/import_view', false, $data);
                exit();
            }
            else
            {
                echo "Error on upload File";
                exit();
            }
        }
        else
        {
            
	    header('Location:'. BASE_URL.'projects');
            exit();
        }
    }
/*******************************/
/* Insert Imported data after all field managed
/* @paraeter- project_id, project_key, mapping, node_regions, field_value
/*****************************/	
	/*************/
	public function importEditedFile(){
		if($_POST) {
			$project_id=$_POST["project_id"];
			$project_key=$_POST["project_key"];
			$mapping=$_POST["mapping"];
			$node_regions=$_POST["node_regions"];
			$field_value=$_POST["field_value"];
			$uniqJobId = uniqid(true).date('dmY');
			$project_details=$this->model->getProjectDetails($project_id);
			$project_name=$project_details[0]['name'];		

			$myObj = new stdClass;	
			$myObj->comparable =  false;
			$myObj->isMultivalued =  false;
			$myObj->displayRankings = false;
			$myObj->invertRankings = false;
			$myObj->groupingMethod = '';
			$myObj->includeAverageInNodeGraphs = false;
			$myObj->showAverageInDataSetSummary = false;
			$myObj->averageOverride = null;
			$myObj->showChartDatasetSummary = false;
			$myObj->showTotalInDataSetSummary = false;
			$myObj->excludeMinFromDataSetSummaryGraph =false;
			$myObj->excludeMaxFromDataSetSummaryGraph = false;
			$myObj->excludeAverageFromDataSetSummaryGraph = false;
			$myObj->graphType = '';
             
			$myObj->columns=array(
			'name'=>$project_name,
			'icon'=>null,
			'label'=>null,
			'columnIndex'=>null,
			'averageOverride'=>null,
			'displayRankings'=>false,
			'invertRankings'=>false,
			'maxValue'=>null,
			'minValue'=>null,
			'average'=>null,
			'totalValue'=>null
			);
			$myObj->maxValue = null;
			$myObj->minValue = null;
			$myObj->average = null;
			$myObj->totalValue = null;
			$field_data = json_encode($myObj);

			$Only_Needed = [];
			$i=0;
			$ignored=0;
			$checkEmptyArr=array();
			$ignored_position=array();
			$accepted_position=array();
				
			foreach ($mapping as $mkey => $mval) {
				if ($mval != '' && !empty($mval)){
					$data_field_name=trim($mval);
					if(!in_array($data_field_name,$checkEmptyArr)){
						if($mval!='Ignore'){
						$check_empty=$this->model->check_field_name($project_id,$data_field_name);
						$type = 'Text';
						if(!empty($check_empty)){
							$fld_id=$check_empty[0]['id_project_field'];
							$this->model->updateDataFields($fld_id,$data_field_name);
							$Only_Needed[$fld_id] = $data_field_name;
							$accepted_position[]=$i;
						}else{
							$id=$this->model->insert_data_field2($project_id, $data_field_name,$type,'',$field_data);
							$Only_Needed[$id] = $data_field_name;
							$accepted_position[]=$i;
						}
						
						}else{
						  $ignored++;
						  $ignored_position[]=$i;
						}
					}else{
					$check_empty=$this->model->check_field_name($project_id,$data_field_name);
					$checkEmptyArr[]=$check_empty;
					if(!empty($check_empty)){
						$fld_id=$check_empty[0]['id_project_field'];
						$this->model->updateDataFields($fld_id,$data_field_name);
						$Only_Needed[$fld_id] = $data_field_name;
						$accepted_position[]=$i;
					}else{
						if($mval!='Ignore'){
						$id=$this->model->insert_data_field2($project_id, $data_field_name,'Text','',$field_data);
						$Only_Needed[$id] = $data_field_name;
						$accepted_position[]=$i;
						}else{
						  $ignored++;
						  $ignored_position[]=$i;
						}
					}
					}
				  $i++;
				}
			}

	/****/
	$available_fields=array();
	foreach($Only_Needed as $key=>$val){
	$available_fields[]=trim($key);
	}

	if(!empty($available_fields)){
	$av_ids=implode(',',$available_fields);	
	/*** removed ignore datafields from database ***/
	$DeleteDataFields=$this->model->deleteIgnoredDataFieldsByProjectId($project_id,$av_ids);
	}
	$total_fv=count($field_value);	
	$total_col=count($Only_Needed);	
	$all_column=$total_col+$ignored;
	$i=0;

	foreach($field_value as $flv){
		$m1=0;
		foreach($Only_Needed as $key=>$val){
			if(in_array($i,$accepted_position) && $accepted_position[$m1]==$i && !in_array($i,$ignored_position)){
			${"mfiv".$m1}[]=trim($flv);
			
			}
			$m1++;
		}
		$i++;
		if($i==$all_column){
			$i=0;
		}
	}
     /*** Delete datafields before insert new one **/
	$DeleteNodeRegions=$this->model->deleteDataFieldsByProjectId($project_id);
	
				$mcoum=0;
				$emarr=array();
				$my_query="";
				$my_query2=array();
				$ignored_fields=array();
				if(!empty($Only_Needed)){
					$pos=0;
					foreach($Only_Needed as $field_id=>$field_name){
						if($field_name!='Ignore'){
							if(!empty($node_regions)){
								$allColumnVal=${"mfiv".$pos};
								$m=0;
								$my_query="INSERT INTO `data_field_value` (`pro_id`,`city_id`,`field_id`,`field_value`) VALUES ";
								$values=array();
								foreach($node_regions as $city_id){
									if(!empty($city_id)){
								/*****-Remove-Comma-From-Values-*******/
										$val_without_comma=str_replace(",","",$allColumnVal[$m]);
										$val_without_comma = mb_convert_encoding($val_without_comma, 'UTF-8', 'UTF-8');
										$val_without_comma = str_replace("'", "", $val_without_comma);
										/******************/
										$mcoum++;
										$values[] = "('".$project_id."','".$city_id."','".$field_id."','".$val_without_comma."')";
									}
									$m++;
								}
								
								$my_query .= implode(',', $values);
								$my_query2[]=$my_query;
								//if($field_id==2755){
								//echo "<pre>"; print_r($my_query); die();
								//}
							$this->model->insertDataFieldValue1($my_query);
							$my_query="";
							}
					  }
						$pos++;
					}
				}
				//echo ""; print_r($my_query2); echo "</pre>"; die();
				$_SESSION['data-key-session']='';
				$_SESSION['ignored_DF']='';
				unset($_SESSION['data-key-session']);
				unset($_SESSION['ignored_DF']);
				$json_response =['type'=> 'success' , 'msg'=> sprintf("Nodes saved correctly", ''), 'pro_key'=>$project_key ];
				echo json_encode($json_response, JSON_PRETTY_PRINT);
			}
		}
		
	 public function newview(){
		$this->view->dashboard('mypages/import_view', false, $data); 
	 }
/*************/
/*************/
public function saveDataFields(){
        if($_POST){
$name =trim($_POST['name']);
$description = $_POST['description'];
$display_name = $_POST['dname'];
$proId = $_POST['id'];
$type = $_POST['type'];
$datakeyVal=$_POST['datakeyVal'];
$sequenceVal=$_POST['sequenceVal'];
$myObj = new stdClass;

$myObj->comparable = isset($_POST['comparable']) ? $_POST['comparable'] : false;
$myObj->isMultivalued = isset($_POST['multivalued']) ? $_POST['multivalued'] : false;
$myObj->displayRankings = isset($_POST['node_ranking']) ? $_POST['node_ranking'] : false;
$myObj->invertRankings = isset($_POST['invert_node_ranking']) ? $_POST['invert_node_ranking'] : false;
$myObj->groupingMethod = isset($_POST['grouping']) ? $_POST['grouping'] : 'Percentiles';
$myObj->includeAverageInNodeGraphs = isset($_POST['overall_range']) ? $_POST['overall_range'] : false;
$myObj->showAverageInDataSetSummary = isset($_POST['override_average']) ? $_POST['override_average'] : false;
$myObj->averageOverride = isset($_POST['average_override_number']) ? $_POST['average_override_number'] : null;
$myObj->showChartDatasetSummary = isset($_POST['chart_data_set_summary']) ? $_POST['chart_data_set_summary'] : false;
$myObj->showTotalInDataSetSummary = isset($_POST['total_data_set_summary']) ? $_POST['total_data_set_summary'] : false;
$myObj->excludeMinFromDataSetSummaryGraph = isset($_POST['exclude_minimum_data_set_summary']) ? $_POST['exclude_minimum_data_set_summary'] : false;
$myObj->excludeMaxFromDataSetSummaryGraph = isset($_POST['exclude_maximum_data_set_summary']) ? $_POST['exclude_maximum_data_set_summary'] : false;
$myObj->excludeAverageFromDataSetSummaryGraph = isset($_POST['exclude_average_data_set_summary']) ? $_POST['exclude_average_data_set_summary'] : false;
$myObj->graphType = isset($_POST['graphtype']) ? $_POST['graphtype'] : '';


$myObj->columns=array(
'name'=>$name,
'icon'=>null,
'label'=>null,
'columnIndex'=>null,
'averageOverride'=>isset($_POST['average_override_number']) ? $_POST['average_override_number'] : null,
'displayRankings'=>isset($_POST['node_ranking']) ? $_POST['node_ranking'] : false,
'invertRankings'=>isset($_POST['invert_node_ranking']) ? $_POST['invert_node_ranking'] : false,
'maxValue'=>null,
'minValue'=>null,
'average'=>null,
'totalValue'=>null
);
$myObj->maxValue = null;
$myObj->minValue = null;
$myObj->average = null;
$myObj->totalValue = null;

$myJSON = json_encode($myObj);	
$checkfieldname=$this->model->check_field_name($proId, $name);
if(!(count($checkfieldname) > 0)){
$id=$this->model->insert_data_field($proId,$name,$display_name,$type,$description,$myJSON);
//$proDetails=$this->model->getProjectDetails($proId);
//$mid = $proDetails[0]['id_map_template'];
//$mapDetails=$this->model->getcountryByMapid($mid);
$mapDetails=$this->model->getSameMapTemplateRegions($proId);   
foreach($mapDetails as $map){
$city_id = $map['city_id'];
$this->model->insertDataFieldValue($proId,$city_id,$id,'');
}

			$_SESSION['data-key-session'][$datakeyVal]=$name;
			$json_response =['type'=> 'success' , 'msg'=> sprintf("New Datafield created", '')];
            echo json_encode($json_response, JSON_PRETTY_PRINT);
}else{
   	$json_response =['type'=> 'error' , 'msg'=> 'Field name already exists'];
            echo json_encode($json_response, JSON_PRETTY_PRINT); 
}

        }
    }	
	/*****END CUSTOM-CODE*******/
	 public function setSessionIgnore(){
		 if($_POST['id']){
			 $id=$_POST['id'];
			 $pi=explode('_',$id);
			 $position=end($pi);
			 $_SESSION['ignored_DF'][] = $position;
			 echo json_encode($_SESSION['ignored_DF']);
		 }
	 }
	 /*****END CUSTOM-CODE*******/
	 public function setSessionNodeIgnore(){
		 if($_POST['id']){
			 $id=$_POST['id'];
			 $val=$_POST['val'];
			 $pi=explode('_',$id);
			 $position=end($pi);
			 $_SESSION[$id] = $val;
			 echo json_encode($_SESSION['ignored_ND']);
		 }
	 }
/*******RENAME-DATAFIELD*******/	
/*************/
/*************/
public function renameDataFields(){
if($_POST){
	$name = trim($_POST['name']);
	$display_name = $_POST['dname'];
	$proId = $_POST['id'];
	$datafieldid = $_POST['datafieldid'];
	$datakeyVal=$_POST['datakeyVal'];
	$sequenceVal=$_POST['sequenceVal'];
	$checkfieldname=$this->model->checkFieldName($proId, $name,$datafieldid);
	if(!(count($checkfieldname) > 0)){
	$id=$this->model->renameDataFields($datafieldid,$name,$display_name);
	//$proDetails=$this->model->getProjectDetails($proId);
	$_SESSION['data-key-session'][$datakeyVal]=$name;
	$json_response =['type'=> 'success' , 'msg'=> sprintf("Datafield updated", '')];
	echo json_encode($json_response, JSON_PRETTY_PRINT);
	}else{
		$json_response =['type'=> 'error' , 'msg'=> 'Field name already exists'];
				echo json_encode($json_response, JSON_PRETTY_PRINT); 
	}
}
    }	 
/***************************/
}