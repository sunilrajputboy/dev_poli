<?php
class export_model extends Model{

	public function selectTwoTableData($dataSetKey){
        $sth = $this->db->prepare('SELECT projects.*,map_templates.* FROM projects LEFT JOIN map_templates ON projects.id_map_template=map_templates.id_map_templates WHERE projects.proKey =:dataSetKey');
        $sth->bindparam(":dataSetKey", $dataSetKey);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function selectsingleTableDatabyid($projectId){
        $sth = $this->db->prepare('SELECT * FROM `project_fields` WHERE `id_project` =:projectId AND isGroup=0 ORDER BY `sequence_no`');
        $sth->bindparam(":projectId", $projectId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

	public function selectMapTemplates($idMapTemplates){
        $sth = $this->db->prepare('SELECT * FROM `map_template_regions` WHERE `id_map_template` =:idMapTemplates');
        $sth->bindparam(":idMapTemplates", $idMapTemplates);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	
	public function getNodeDetails($projectId){
        $sth = $this->db->prepare('SELECT map_template_regions.name, project_fields.field_name, data_field_value.field_value FROM `data_field_value`,project_fields,map_template_regions WHERE data_field_value.`pro_id`=:projectId AND map_template_regions.id=data_field_value.city_id AND data_field_value.field_id=project_fields.id_project_field AND project_fields.isGroup=0 ORDER BY city_id ASC,`data_field_value`.`id` ASC');
        $sth->bindparam(":projectId", $projectId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
		public function findcountrydata($idMapTemplate){
        $sth = $this->db->prepare('SELECT * FROM `map_template_regions` WHERE `id_map_template` = :idMapTemplate');
        $sth->bindparam(":idMapTemplate", $idMapTemplate);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function selectTwoTableDataView($projectId){
        $sth = $this->db->prepare('SELECT projects.*,map_templates.* FROM projects LEFT JOIN map_templates ON projects.id_map_template=map_templates.id_map_templates WHERE projects.id_project =:projectId');
        $sth->bindparam(":projectId", $projectId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	/***09-02-2023***/
	public function getSingleDataFieldValue($projectId){
		$sth = $this->db->prepare('SELECT * FROM data_field_value WHERE pro_id =:projectId ORDER BY id ASC LIMIT 1');
        $sth->bindparam(":projectId", $projectId);
		$sth->execute();
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	public function getFieldIdSequence($projectId,$city_id){
		$sth = $this->db->prepare('SELECT field_id FROM data_field_value WHERE pro_id =:projectId AND city_id=:cityID');
        $sth->bindparam(":projectId", $projectId);
        $sth->bindparam(":cityID", $city_id);
		$sth->execute();
		$field_id_array=array();
		$field_id_sequence='';
			foreach($result = $sth->fetchAll(PDO::FETCH_ASSOC) as $resultx) 
			{ 
				$field_id_array[] = $resultx["field_id"];
			}
		if(!empty($field_id_array)){	
		$field_id_sequence=implode(',',$field_id_array);
		}		
		
		return $field_id_sequence;
	}
	
	public function selectProjecFieldsBySequence($projectId,$sequence){
        $sth = $this->db->prepare('SELECT * FROM `project_fields` WHERE `id_project` =:projectId AND isGroup=0 ORDER BY FIELD(`id_project_field`,'.$sequence.')');
        $sth->bindparam(":projectId", $projectId);
        $sth->execute();
		//return ($sth->queryString);
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	/******/
	
}