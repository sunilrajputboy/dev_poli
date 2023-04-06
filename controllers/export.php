<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class Export extends Controller{
	function __construct() {
		parent::__construct();
		$this->checkLoggedIn();
	}
	function index(){
		echo "silence is good.";
	}
	function datasetkey($datasetkey=""){
		if($datasetkey!=""){
			$result=$this->model->selectTwoTableData($datasetkey);
			$row=$result[0];
			$get_a_datafield=$this->model->getSingleDataFieldValue($row['id_project']);
			$city_id=$get_a_datafield[0]['city_id'];
			$sequenced_id=$this->model->getFieldIdSequence($row['id_project'],$city_id);
			if(!empty($sequenced_id)){
			$datafieldData=$this->model->selectProjecFieldsBySequence($row['id_project'],$sequenced_id);
			}else{
			$datafieldData=$this->model->selectsingleTableDatabyid($row['id_project']);	
			}
			$nodeDetails=$this->model->getNodeDetails($row['id_project']);
			$maindata1=array();
			$maindata=array();
			$mdata=array();
			$nodesarray = array();
			$maindata1[]='Node';
			$count = 0;
			foreach($datafieldData as $d){ $count++;
				$maindata1[]=$d['field_name'];
			}
			$nodesarray[]=$maindata1;
			$fieldDataarr = array();
			$nds=0;
			if(!empty($nodeDetails)){
				$i=0;
				foreach($nodeDetails as $nd){
					$nds++;
					if($i==0){
					$fieldDataarr[]=$nd['name'];
					}
					$fieldDataarr[]=$nd['field_value'];
					$i++;
					if($count==$i){
					$nodesarray[]=$fieldDataarr;
					$fieldDataarr=array();		
					$i=0;	
					}
				}
			}
			 if($nds==0){
				$id_map_template=$row['id_map_template'];
				$allnodes=$this->model->findcountrydata($id_map_template);
 				if(!empty($allnodes)){
					foreach($allnodes as $nd1){
						 $fieldDataarr=array();
						$fieldDataarr[]=$nd1['name'];
						$nodesarray[]=$fieldDataarr;
					}
				}   
			}
			$project_title=$row['title'];
			$fp = fopen('php://output', 'w');
			$filename='polimapper_export_'.$project_title.'_'.date('Y-m-d-H-i').'.csv';
			header('Content-type: application/csv');
			header('Content-Disposition: attachment; filename='.$filename);
				if(!empty($nodesarray)){
					foreach ($nodesarray as $fields) {
						fputcsv($fp, $fields);
					}
				}
			fclose($fp);  

		}else{
	     echo json_encode(array("status"=>400,'dataSetKey is empty or missing'));
        }
	}
	
	function view(){
		if(isset($_POST['project_id']) && !empty($_POST['project_id'])){
			$project_id=$_POST['project_id'];
			$result=$this->model->selectTwoTableDataView($project_id);
			$id_map_templates=$result[0]['id_map_templates'];
			$allMapTemplate=$this->model->selectMapTemplates($id_map_templates);
			
			$maindata1=array();
			$maindata=array();
			$mdata=array();
			$nodesarray = array();
			$row=$result[0];
			
			$get_a_datafield=$this->model->getSingleDataFieldValue($row['id_project']);
			$city_id=$get_a_datafield[0]['city_id'];
			$sequenced_id=$this->model->getFieldIdSequence($row['id_project'],$city_id);
			if(!empty($sequenced_id)){
			$datafieldData=$this->model->selectProjecFieldsBySequence($row['id_project'],$sequenced_id);
			}else{
			$datafieldData=$this->model->selectsingleTableDatabyid($row['id_project']);	
			}
			$nodeDetails=$this->model->getNodeDetails($row['id_project']);
			if(!empty($datafieldData)){
			$count = count($datafieldData);
			}else{
			$count=0;	
			}
			
			$fieldDataarr = array();
			if(!empty($nodeDetails)){
				$i=0;
				foreach($nodeDetails as $nd){
					if($i==0){
					$fieldDataarr[]=$nd['name'];
					}
					$fieldDataarr[]=$nd['field_value'];
					$i++;
					if($count==$i){
					$nodesarray[]=$fieldDataarr;
					$fieldDataarr=array();
					$i=0;
					}
				
				}

			}else{
			    //echo print_r($nodeDetails);
			}
			
		
		$html='<div class="table-container"><table class="table" id="packages"><thead><tr><th>Node</th>';
		if(!empty($datafieldData)){
			foreach($datafieldData as $d){
				$html.='<th>'.$d['field_name'].'</th>';
			}
		}
		$html.='</tr></thead><tbody>';
			
		if(!empty($nodesarray)){
		foreach($nodesarray as $fields){
		$html.='<tr>';   
			for($x = 0; $x<=$count; $x++){
				$html.= '<td>'.$fields[$x].'</td>'; 
			}
		$html.='</tr>';	
		}
		}else{
			if(!empty($allMapTemplate)){
				foreach($allMapTemplate as $mpt){
				  $html.= '<tr><td>'.$mpt['name'].'</td></tr>'; 
				}
			}
		}
		$html.='</div>';
		
		echo json_encode(array("success"=>200,'msg'=>'Data View','html_data'=>$html));
		exit;
		}else{
		   echo json_encode(array("success"=>400,'msg'=>'<h3>Project Id is empty or missing</h3>','html_data'=>'<h3>Project Id is empty or missing</h3>'));
		   exit;
		}

	}
	/**************/
}
?>