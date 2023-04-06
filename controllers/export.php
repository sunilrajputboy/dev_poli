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
			$results=$this->model->selectTwoTableData($datasetkey);
			$row=$results[0];
			$project_id=$row['id_project'];
			$mquery="SELECT data_field_value_new.*,map_template_regions.name FROM `data_field_value_new` LEFT JOIN map_template_regions ON data_field_value_new.city_id=map_template_regions.id WHERE data_field_value_new.pro_id=$project_id";
			$result=$this->model->customQuery($mquery,'FETCH');
			$nodesarray = array();
			$maindata1=array();
			$maindata2=array();
			$maindata=array();
			$maindata1[]='Node';
			if(!empty($result)){
				foreach($result as $node_data){
					$maindata2=array();
					$dataFieldSequence=array();
					$maindata2[]=$node_data['name'];
					$field_value_data=($node_data['field_value_data']) ? unserialize($node_data['field_value_data']): array();
					if(!empty($field_value_data)){
						foreach($field_value_data as $val){
							$value = current($val);
							$key = key($val);
							$maindata2[]=$value;
							$dataFieldSequence[]=$key;
						}
					}	
				$maindata[]=$maindata2;
				}
			}
			
			if(empty($maindata)){
				$maptemplates=$this->model->selectMapTemplates($row['id_map_template']);
				if(!empty($maptemplates)){
					foreach($maptemplates as $mtr){
						$maindata_x=array();
						$maindata_x[]=$mtr['name'];
						$maindata[]=$maindata_x;
					}
				}
			}
			
			
			if(!empty($dataFieldSequence)){
			$sequenced_id=implode(',',$dataFieldSequence);	
			$datafieldData=$this->model->selectProjecFieldsBySequence($row['id_project'],$sequenced_id);
			}else{
			$datafieldData=$this->model->selectsingleTableDatabyid($row['id_project']);	
			}
			foreach($datafieldData as $d){ $count++;
				$maindata1[]=$d['field_name'];
			}
			//print_r($row['id_map_template']);die();
			$nodesarray[]=$maindata1;
			$nodesarray1=array_merge($nodesarray,$maindata);
			
			//echo "<pre>"; print_r($nodesarray1); echo "</pre>"; die();
			
			$project_title=$row['title'];
			$fp = fopen('php://output', 'w');
			$filename='polimapper_export_'.$project_title.'_'.date('Y-m-d-H-i').'.csv';
			header('Content-type: application/csv');
			header('Content-Disposition: attachment; filename='.$filename);
				if(!empty($nodesarray1)){
					foreach ($nodesarray1 as $fields) {
						fputcsv($fp, $fields);
					}
				}
			fclose($fp);  

		}else{
	     echo json_encode(array("status"=>400,'dataSetKey is empty or missing'));
        }
	}
	/**************/	
	function view(){
		if(isset($_POST['project_id']) && !empty($_POST['project_id'])){
			$project_id=$_POST['project_id'];
			$mquery="SELECT data_field_value_new.*,map_template_regions.name FROM `data_field_value_new` LEFT JOIN map_template_regions ON data_field_value_new.city_id=map_template_regions.id WHERE data_field_value_new.pro_id=$project_id";
			$result=$this->model->customQuery($mquery,'FETCH');
			$table_body="<tbody>";
			if(!empty($result)){
				foreach($result as $node_data){
					$dataFieldSequence=array();
					$table_body.="<tr><td>".$node_data['name']."</td>";
					$field_value_data=($node_data['field_value_data']) ? unserialize($node_data['field_value_data']): array();
					if(!empty($field_value_data)){
						foreach($field_value_data as $val){
							$value = current($val);
							$key = key($val);
							$table_body.="<td>".$value."</td>";
							$dataFieldSequence[]=$key;
						}
					}
					$table_body.="</tr>";
				}
			}
			$table_body.="</tbody>";
			
			
			if(!empty($dataFieldSequence)){
			$sequence=implode(',',$dataFieldSequence);
			$datafieldData=$this->model->selectProjecFieldsBySequence($project_id,$sequence);
			}else{
			$datafieldData=$this->model->selectsingleTableDatabyid($project_id);	
			}
			
		$html='<div class="table-container">
		<table class="table" id="packages">
		<thead><tr><th>Node</th>';

		if(!empty($datafieldData)){
			foreach($datafieldData as $d){
				$html.='<th>'.$d['field_name'].'</th>';
			}
		}
		//------------//
		if(empty($datafieldData)){
			$mqry="SELECT * FROM projects WHERE id_project='$project_id'";
			$projects=$this->model->customQuery($mqry,'FETCH');
			$row=$projects[0];
				$maptemplates=$this->model->selectMapTemplates($row['id_map_template']);
				//echo "<pre>"; print_r($row['id_map_template']); echo "</pre>"; die();
				if(!empty($maptemplates)){
					foreach($maptemplates as $mtr){
						$table_body.='<tr><td>'.$mtr['name'].'</td></tr>';
					}
				}
			}
		
		$html.='</tr></thead><tbody>';
		$html.=$table_body;
		$html.='</div>';
		
		echo json_encode(array("success"=>200,'msg'=>'Data View','html_data'=>$html));
		exit;
		}else{
		   echo json_encode(array("success"=>400,'msg'=>'<h3>Project Id is empty or missing</h3>','html_data'=>'<h3>Project Id is empty or missing</h3>'));
		   exit;
		}

	}
	/**************/
	public function exportnodelink($datasetkey=""){
		if($datasetkey!=""){
			$results=$this->model->selectProjectClientData($datasetkey);
			$row=$results[0];
			$project_id=$row['id_project'];
			$clientunique_url1=$row['client_unique_url'];
			$mquery="SELECT data_field_value_new.*,map_template_regions.name FROM `data_field_value_new` LEFT JOIN map_template_regions ON data_field_value_new.city_id=map_template_regions.id WHERE data_field_value_new.pro_id=$project_id";
			$result=$this->model->customQuery($mquery,'FETCH');
			$nodesarray = array();
			$maindata1=array();
			$maindata2=array();
			$maindata=array();
			$maindata1[]='Node';
			$maindata1[]='Node direct link';
			if(!empty($result)){
				foreach($result as $node_data){
					$maindata2=array();
					$dataFieldSequence=array();
					$maindata2[]=$node_data['name'];
					$city_name=rawurlencode($node_data['name']);
					$clientunique_url=rawurlencode($clientunique_url1);
					$nd_url=BASE_URL.'?dataSetKey='.$datasetkey.'&client='.$clientunique_url.'#con_over='.$city_name;
					$maindata2[]=$nd_url;
				$maindata[]=$maindata2;
				}
			}
			$nodesarray[]=$maindata1;
			$nodesarray1=array_merge($nodesarray,$maindata);
			$project_title=$row['title'];
			$fp = fopen('php://output', 'w');
			$filename='polimapper_export_'.$project_title.'_'.date('Y-m-d-H-i').'.csv';
			header('Content-type: application/csv');
			header('Content-Disposition: attachment; filename='.$filename);
				if(!empty($nodesarray1)){
					foreach ($nodesarray1 as $fields) {
						fputcsv($fp, $fields);
					}
				}
			fclose($fp);  

		}else{
	     echo json_encode(array("status"=>400,'dataSetKey is empty or missing'));
        }
	}
	/**************/
}
?>