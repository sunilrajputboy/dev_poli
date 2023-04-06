<?php

class import_model extends Model
{
    /**
     * table
     */
    public function getTable()
    {
        $sth = $this->db->prepare('SHOW TABLES;');
        $sth->execute();
        $table = $sth->fetchAll();
        
        $optionsTable = [];
        if($table)
        {
            $table_except =
            [
                'import', 'mapping', 'ordine_paypal'
            ];
            foreach ($table as $tb)
            {
                if(!in_array($tb[0], $table_except))
                    $optionsTable[] = $tb;
            }
        }
        return $optionsTable;
    }
    
    /**
     * get maps
     */
    public function getMaps($name_table, $project = false)
    {
		$project = 1;
        $sth = $this->db->prepare('SELECT filed_name,* FROM `project_fields` where id_project=:project ORDER BY `sequence_no`');
        $sth->bindparam(":project", $name_table);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    /**
     * get records
     */
    public function getRows($uniquid, $table, $columTable)
    {
        $sth = $this->db->prepare("SELECT * FROM $table where importUniquid=:importUniquid");
        $sth->bindparam(":importUniquid", $uniquid);
        $sth->execute();
        $rows = $sth->fetchAll();
	    
			  echo '<table id="row-list" class="table table-bordered display" style="width:100%"> <thead> <tr>';
			                foreach ($columTable as $cc => $c)
						    {
							    echo '<td>'.$c[0].'</td>'; 
						    }
	    				
		            echo '</tr> </thead> <tbody>';
			           $count = count($columTable);
			           foreach($rows as $rr)
			           { 
				        echo '<tr>';
							    for ($i = 0; $i < $count; $i++) {
								    echo "<td>".$rr["$i"]."</td>";
								}
						echo '</tr>';  
			            } 
		        echo "</tbody> </table> <script>$(document).ready(function() { $('#row-list').DataTable(); } ); </script>";
	    }
		
    public function importLists(){
		$params = $columns = $totalRecords = $data = array();
		$params = $_REQUEST;
	
		//define index of column
		$columns = array( 
			0 =>'id_import',
			1 =>'importUniquid',
			2 =>'filename',
			3 =>'rows',
			4 =>'data');
		
		$where = $sqlTot = $sqlRec = "";		
		if( !empty($params['search']['value']) ) {   
			$where .=" WHERE ";
			$where .=" ( id_import LIKE '%".$params['search']['value']."%' ";    
			$where .=" OR importUniquid LIKE '".$params['search']['value']."%' ";
			$where .=" OR filename LIKE '%".$params['search']['value']."%' )";
		}
		$sql = "SELECT *  FROM `import` ";

		$sqlTot .= $sql;
		$sqlRec .= $sql;

		if(isset($where) && $where != '') 
		{
	
			$sqlTot .= $where;
			$sqlRec .= $where;
		}
		
	 		$sqlRec .=  "ORDER BY ". $columns[$params['order'][0]['column']]." ".$params['order'][0]['dir']."  LIMIT ".$params['start']." ,".$params['length']." ";
			$sth = $this->db->prepare($sqlTot);
		    $sth->execute();
			$result = $sth->rowCount();		
			$totalRecords = $result;		
			$sth = $this->db->prepare($sqlRec);
		    $sth->execute();
			
			foreach($result = $sth->fetchAll() as $resultx) 
			{ 
				$table[0] = $resultx["id_import"];
				$table[1] = $resultx["filename"];
				$table[2] = $resultx["ext"];
				$table[3] = $resultx["importUniquid"];
				$table[4] = $resultx["rows"];
				$table[5] = $resultx["select_table"];
				$table[6] = $resultx["data"];
				$table[7] = "<a href='".BASE_URL."import/delate/".$resultx["importUniquid"]."' class='btn btn-xs btn-fill btn-danger btn-round btn-block'><i class='fa fa-trash'></i> Delate</a> ";
				$table[8] = "<a data-toggle='modal' data-target='#view-row' data-id='".$resultx["importUniquid"].",".$resultx["select_table"]."' id='getRow' class='btn btn-xs btn-fill btn-warning btn-round btn-block' href=''><i class='fa fa-eye'></i> Show</a> ";
				$data[] = $table;			
			
			}	
			
			$results = array(
				"draw"            => intval($params['draw'] ),   
				"recordsTotal"    => intval($totalRecords ),  
				"recordsFiltered" => intval($totalRecords),
				"data"            => $data
				);
		
		echo json_encode($results); 
			
		
	}
    /**
     * Delate Import
     */
    public function delate($uniquid)
    {
	    $sth = $this->db->prepare('DELETE FROM import WHERE importUniquid=:importUniquid');
		$sth->bindparam(":importUniquid", $uniquid);
		$sth->execute();
		
    }
 /**********OUR-CUSTOM-CODE************/ 
    /**
     * check Fields
     */
    public function check_field_name($project_id, $data_field_name )
    {
        $sth = $this->db->prepare('SELECT * FROM `project_fields` where id_project=:project AND field_name=:data_fl_name');
        $sth->bindparam(":project", $project_id);
        $sth->bindparam(":data_fl_name", $data_field_name);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    public function checkFieldName($project_id, $data_field_name,$id_project_field )
    {
        $sth = $this->db->prepare('SELECT * FROM `project_fields` where id_project=:project AND field_name=:data_fl_name AND id_project_field!=:id_project_field');
        $sth->bindparam(":project", $project_id);
        $sth->bindparam(":data_fl_name", $data_field_name);
        $sth->bindparam(":id_project_field", $id_project_field);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }	
	
    /**
     * INSERT DATA FIELD
     */
    public function insert_data_field($project_id, $field_name, $d_name,$field_type,$description,$field_data)
    {
		$sth = $this->db->prepare("INSERT INTO `project_fields` (`id_project`,`field_name`, `display_name`, `field_type`,`description`,`field_data`) VALUES (:project_id, :field_name, :display_name,:field_type,:description,:field_data)");
		$sth->bindparam(':project_id',$project_id);
		$sth->bindparam(':field_name',$field_name);
		$sth->bindparam(':display_name',$d_name);
		$sth->bindparam(':field_type',$field_type);
		$sth->bindparam(':description',$description);
		$sth->bindparam(':field_data',$field_data);
        $sth->execute();
		$insert_id=$this->db->lastInsertId('id_project_field');
		
		/**09-2-2023**/
		 $sth3 = $this->db->prepare('SELECT sequence_no FROM `project_fields` where id_project=:pr_id ORDER BY sequence_no DESC LIMIT 1');
		 $sth3->bindparam(':pr_id',$project_id);
		 $sth3->execute();
		 $sequence_no=0;
			foreach($result = $sth3->fetchAll() as $resultx) 
			{ 
				$sequence_nox = $resultx["sequence_no"];
				$sequence_no=$sequence_nox+1;
			}
		 
		$sth2 = $this->db->prepare("UPDATE project_fields SET sequence_no='$sequence_no'  WHERE  id_project_field=:fld_id");
        $sth2->bindparam(":fld_id", $insert_id);
        $sth2->execute();
		/**-END-**/
        return $insert_id;
    }
    
       public function insert_data_field2($project_id, $field_name,$field_type,$description,$field_data)
    {
		$sth = $this->db->prepare("INSERT INTO `project_fields` (`id_project`,`field_name`, `field_type`,`description`,`field_data`) VALUES (:project_id, :field_name,:field_type,:description,:field_data)");
		$sth->bindparam(':project_id',$project_id);
		$sth->bindparam(':field_name',$field_name);
		$sth->bindparam(':field_type',$field_type);
		$sth->bindparam(':description',$description);
		$sth->bindparam(':field_data',$field_data);
        $sth->execute();
		$insert_id=$this->db->lastInsertId('id_project_field');
		/**09-2-2023**/
		 $sth3 = $this->db->prepare('SELECT sequence_no FROM `project_fields` where id_project=:pr_id ORDER BY sequence_no DESC LIMIT 1');
		 $sth3->bindparam(':pr_id',$project_id);
		 $sth3->execute();
		 $sequence_no=0;
			foreach($result = $sth3->fetchAll() as $resultx) 
			{ 
				$sequence_nox = $resultx["sequence_no"];
				$sequence_no=$sequence_nox+1;
			}
		 
		$sth2 = $this->db->prepare("UPDATE project_fields SET sequence_no='$sequence_no'  WHERE  id_project_field=:fld_id");
        $sth2->bindparam(":fld_id", $insert_id);
        $sth2->execute();
		/**-END-**/
        return $insert_id;
    }
	
    public function getProjectDetails($project_id)
    {
		$sth = $this->db->prepare('SELECT * FROM `projects` WHERE `id_project`=:project_id');
        $sth->bindparam(":project_id", $project_id);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    	
    public function getcountryByMapid($mid)
    {
		$sth = $this->db->prepare('SELECT * FROM `map_template_regions` WHERE `id_map_template`=:mid');
        $sth->bindparam(":mid", $mid);
        $sth->execute();
        return $sth->fetchAll();
    }
	public function getSameMapTemplateRegions($proId){
        $sth = $this->db->prepare("SELECT DISTINCT(`city_id`) FROM `data_field_value` WHERE `pro_id`=:proId");
		$sth->bindparam(":proId", $proId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	
    public function getAllDataFields($mid)
    {
		$sth = $this->db->prepare('SELECT id_project_field,field_name,id_project FROM `project_fields` WHERE `id_project`=:mid ORDER BY `sequence_no`' );
        $sth->bindparam(":mid", $mid);
        $sth->execute();
        return $sth->fetchAll();
    }
	
    public function updateDataFields($id_project_field,$field_name)
    {
		$sth = $this->db->prepare("UPDATE project_fields SET field_name='$field_name'  WHERE  id_project_field=:fld_id");
        $sth->bindparam(":fld_id", $id_project_field);
        $sth->execute();
        return $sth->fetchAll();
    }
    public function renameDataFields($id_project_field,$field_name,$display_name)
    {
		$sth = $this->db->prepare("UPDATE project_fields SET field_name=:fieldName , display_name=:displayName  WHERE  id_project_field=:fld_id");
        $sth->bindparam(":fld_id", $id_project_field);
        $sth->bindparam(":fieldName", $field_name);
        $sth->bindparam(":displayName", $display_name);
        $updt=$sth->execute();
        return $updt;
    }
    public function checkNodeRegions($project_id,$city_id,$field_id )
    {
        $sth = $this->db->prepare('SELECT * FROM `data_field_value` where pro_id=:project AND city_id=:ct_id AND field_id=:fldid');
        $sth->bindparam(":project", $project_id);
        $sth->bindparam(":ct_id", $city_id);
        $sth->bindparam(":fldid", $field_id);
        $sth->execute();
        return $sth->fetchAll();
    }
	    /**
     * Delate Import
     */
    public function deleteNodeRegions($project_id,$city_id,$field_id)
    {
	    $sth = $this->db->prepare('DELETE FROM data_field_value WHERE pro_id=:project AND city_id=:ct_id AND field_id=:fldid');
        $sth->bindparam(":project", $project_id);
        $sth->bindparam(":ct_id", $city_id);
        $sth->bindparam(":fldid", $field_id);
		$sth->execute();
		return true;
    }
    public function insertDataFieldValue($project_id,$city_id,$field_id,$field_value)
    {
		$sth = $this->db->prepare("INSERT INTO `data_field_value` (`pro_id`,`city_id`,`field_id`,`field_value`) VALUES (:project_id, :ct_id,:fld_id,:fieldvalue)");
		$sth->bindparam('project_id',$project_id);
		$sth->bindparam('ct_id',$city_id);
		$sth->bindparam('fld_id',$field_id);
		$sth->bindparam('fieldvalue',$field_value);
        $sth->execute();
		$insert_id=$this->db->lastInsertId();
        return $insert_id;
    }
	/**********/
    public function insertDataFieldValue1($query)
    {
		$sth = $this->db->prepare($query);
        $sth->execute();
        return true;
    }
    public function deleteDataFieldsByProjectId($project_id)
    {
	    $sth = $this->db->prepare('DELETE FROM data_field_value WHERE pro_id=:project');
        $sth->bindparam(":project", $project_id);
		$sth->execute();
		return true;
    }
	    public function deleteIgnoredDataFieldsByProjectId($project_id,$ids)
    {
	    $sth = $this->db->prepare("DELETE FROM project_fields WHERE id_project=:project AND isGroup = 0  AND id_project_field NOT IN(".$ids.")");
        $sth->bindparam(":project", $project_id);
		$sth->execute();
		return true;
    }	
	/********/
	
    public function updateDataFieldsValue($project_id,$city_id,$field_id,$field_value)
    {
		$sth = $this->db->prepare("UPDATE data_field_value SET field_value='$field_value'  WHERE  pro_id=:project_id AND city_id=:ct_id AND field_id=:fld_id");
        $sth->bindparam(":project_id", $project_id);
        $sth->bindparam(":ct_id", $city_id);
        $sth->bindparam(":fld_id", $field_id);
        $sth->execute();
        return $sth->fetchAll();
    }
	
    public function getReagionExcept($project_id,$mids)
    {
		 $sth = $this->db->prepare('SELECT `id_map_template` FROM `projects` where id_project=:project');
		 $sth->bindparam(":project", $project_id);
		 $sth->execute();
		 $project_details=$sth->fetchAll(PDO::FETCH_ASSOC);
		 $id_map_template=$project_details[0]['id_map_template'];
		 $all_city_ids = "'".implode("','",$mids)."'";
		 $sth2 = $this->db->query("SELECT `id` FROM `map_template_regions` where `id` NOT IN($all_city_ids) AND id_map_template=$id_map_template");
        $sth2->execute();
        return $sth2->fetchAll(PDO::FETCH_ASSOC);
    }
	
    public function getDatafieldsByproject($project_id)
    {
		 $sth = $this->db->prepare('SELECT * FROM `project_fields` where id_project=:project ORDER BY `sequence_no`');
		 $sth->bindparam(":project", $project_id);
		 $sth->execute();
		 $project_dfls=$sth->fetchAll(PDO::FETCH_ASSOC);
        return $project_dfls;
    }
	
	public function getUserById($userId){
        $sth = $this->db->prepare('SELECT * FROM `users` WHERE `id` =:userId');
        $sth->bindparam(":userId", $userId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	/****END****/
}