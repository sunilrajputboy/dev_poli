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
	
//echo "<pre>"; print_r($node_regions); echo "</pre>"; die();
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
				$m=0;
				$iteration=0;
				
		/*************-SMITH-*22-02-2023*-SMITH-**************/
		if(!empty($node_regions)){
			foreach($node_regions as $city_id){ $iteration++;
			$my_query="INSERT INTO `data_field_value_new` ( `pro_id`, `city_id`, `field_value_data` ) VALUES ";
			$values=array();
				if(!empty($city_id)){
					if(!empty($Only_Needed)){
						$pos=0;
						foreach($Only_Needed as $field_id=>$field_name){
							if($field_name!='Ignore'){
								$allColumnVal=${"mfiv".$pos};
							  $v1=str_replace(",","",$allColumnVal[$m]);
							  $v1 = mb_convert_encoding($v1,'UTF-8','UTF-8');
							  $v1=str_replace("'","",$v1);
							  $mcoum++;
							  $values[]=array($field_id=>$v1);
							  $values2[]=array('id'=>$field_id,'name'=>$field_name,'value'=>$v1,'city_id'=>$city_id,'project_id'=>$project_id);
							}
							$pos++;
						}
					}	
				}
				$fieldValueNew=serialize($values);
				$m++;
				$my_query .="('".$project_id."','".$city_id."','".$fieldValueNew."')" ;
				$this->model->insertDataFieldValue1($my_query);
		        $my_query="";
			}
		}
	//*******************/			
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