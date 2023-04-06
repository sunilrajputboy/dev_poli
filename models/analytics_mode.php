<?php
class analytics_model extends Model
{
	public function getUserDetailsById($userId){
        $sth = $this->db->prepare("SELECT * FROM `users` where id=:userId");
        $sth->bindparam(":userId", $userId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getProjectById($projectId){
        $sth = $this->db->prepare("SELECT * FROM `projects` where id_project=:projectId");
        $sth->bindparam(":projectId", $projectId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getAllProjects(){
        $sth = $this->db->prepare("SELECT * FROM `projects` ORDER BY `sequence_no`");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getProjectWhereIn($projectIds){
        $sth = $this->db->prepare("SELECT * FROM `projects` WHERE `id_project` IN ($projectIds) ORDER BY `sequence_no`");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getProjectByClientId($ClientId){
        $sth = $this->db->prepare("SELECT * FROM `projects` WHERE `id_client` =:ClientId ORDER BY `sequence_no`");
        $sth->bindparam(":ClientId", $ClientId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getAllClients(){
        $sth = $this->db->prepare("SELECT * FROM `clients`");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getAllProjectGroups(){
        $sth = $this->db->prepare("SELECT * FROM `projectgroup`");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getClientsById($clientId){
        $sth = $this->db->prepare('SELECT * FROM `clients` where id=:clientId');
        $sth->bindparam(":clientId", $clientId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
 	public function getMapTemplatesById($id){
        $sth = $this->db->prepare('SELECT * FROM `map_templates` WHERE `id_map_templates` =:tid');
        $sth->bindparam(":tid", $id);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function deleteProject($projectId){
        $sth = $this->db->prepare("DELETE `projects`, `project_fields`, `data_field_value` FROM `projects` LEFT join project_fields on projects.id_project = project_fields.id_project LEFT join data_field_value on projects.id_project = data_field_value.pro_id WHERE projects.id_project = :projectId");
        $sth->bindparam(":projectId", $projectId);
        $ret=$sth->execute();
        return $ret;
    }
	public function getDataFieldsById($projectId){
        $sth = $this->db->prepare('SELECT * FROM `project_fields` WHERE id_project= :projectId ORDER BY `sequence_no`');
        $sth->bindparam(":projectId", $projectId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getDataFieldsByIdWithoutGroup($projectId){
        $sth = $this->db->prepare("SELECT * FROM `project_fields` WHERE `id_project`=:projectId AND isGroup=0 ORDER BY `sequence_no` ");
        $sth->bindparam(":projectId", $projectId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getPackageById($packagetId){
        $sth = $this->db->prepare("SELECT * FROM `packages` WHERE `id` = :packagetId");
        $sth->bindparam(":packagetId", $packagetId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getProjectGroupClientId($client){
        $sth = $this->db->prepare("SELECT * FROM `projectgroup` WHERE `client` = :Client AND isGroup=0 ORDER BY `sequence_no` ASC");
        $sth->bindparam(":Client", $client);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

	public function datafieldsWithoutChild($projectId){
        $sth = $this->db->prepare("SELECT * FROM `project_fields` WHERE parentId = 0 AND id_project = :projectId");
        $sth->bindparam(":projectId", $projectId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getchartWizard($projectId){
        $sth = $this->db->prepare("SELECT * FROM `chart_wizard` WHERE pro_id =:projectId  ORDER BY `sequence_no` ASC");
        $sth->bindparam(":projectId", $projectId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getProjectFieldsByParentId($parentId){
        $sth = $this->db->prepare("SELECT * FROM `project_fields` WHERE parentId =:parentId  ORDER BY `sequence_no` ASC");
        $sth->bindparam(":parentId", $parentId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getAllTemplate(){
        $sth = $this->db->prepare("SELECT * FROM `template`");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	
	public function getAllFonts(){
        $sth = $this->db->prepare("SELECT * FROM `fonts` ORDER BY  `font_family` ASC");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    } 
}