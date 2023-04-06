<?php
class projectsgroup_model extends Model
{
    public function getProjectGroupById($id){
        $sth = $this->db->prepare("SELECT * FROM `projectgroup` where id=:id");
        $sth->bindparam(":id", $id);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
      public function getallProjectGroup(){
        $sth = $this->db->prepare("SELECT * FROM `projectgroup`");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    
	public function getUserDetailsById($userId){
        $sth = $this->db->prepare("SELECT * FROM `users` where id=:userId");
        $sth->bindparam(":userId", $userId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    	public function getprojectgroupBycreateId($userId){
        $sth = $this->db->prepare("SELECT * FROM `projectgroup` where createdby=:userId");
        $sth->bindparam(":userId", $userId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    	public function getClientsWhereIn($ids){
        $sth = $this->db->prepare("SELECT * FROM `clients` WHERE `id` IN ($ids)");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    	public function checkUniqueUrl($uniqueUrl,$clientId){
        $sth = $this->db->prepare('SELECT * FROM `projectgroup` WHERE `unique_url` =:uniqueUrl AND id!=:clientId');
        $sth->bindparam(":uniqueUrl", $uniqueUrl);
        $sth->bindparam(":clientId", $clientId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
       public function projectstatus($password_protected,$visibility,$user_id){
        $sth = $this->db->prepare("UPDATE `projectgroup` SET `visibility`='$visibility', `password_protected`='$password_protected' WHERE `id` = '$user_id'");
        $ret=$sth->execute();
        return $ret;
    }
       public function addpassword($password,$id){
        $sth = $this->db->prepare("UPDATE `projectgroup` SET `password`= '$password' WHERE `id` = $id");
        $ret=$sth->execute();
        return $ret;
    }
    
       public function updateGroup($newProjects,$removeGroupproject){
        $sth = $this->db->prepare("UPDATE `projectgroup` SET `projects`=:newProjects WHERE `id` =:removeGroupproject");
        $sth->bindparam(":newProjects", $newProjects);
        $sth->bindparam(":removeGroupproject", $removeGroupproject);
        $ret=$sth->execute();
        return $ret;
    }
    
     	public function hideprojects($proId){
        $sth = $this->db->prepare("UPDATE `projectgroup` SET `visibility`= '0', `password_protected`= '0' WHERE `id` = $proId");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    	public function showprojects($proId){
        $sth = $this->db->prepare("UPDATE `projectgroup` SET `visibility`= '1' WHERE `id` = $proId");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    	public function lockprojects($proId){
        $sth = $this->db->prepare("UPDATE `projectgroup` SET `visibility`= '1', `password_protected`= '1' WHERE `id` = $proId");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    	public function unlockprojects($proId){
        $sth = $this->db->prepare("UPDATE `projectgroup` SET `visibility`= '1', `password_protected`= '0' WHERE `id` = $proId");
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
        $sth = $this->db->prepare("SELECT * FROM `projectgroup` ORDER BY `sequence_no`");
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
	   $sth = $this->db->prepare('DELETE FROM `projectgroup` WHERE `id` = :projectId');
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
    public function addprojectGroup($gname,$cid,$description,$projects,$uid,$unique_url){
        $sth = $this->db->prepare("INSERT INTO `projectgroup`(`name`, `client`, `description`, `projects`, `createdby`, `unique_url`) VALUES (:gname,'$cid',:description,'$projects','$uid',:unique_url)");
        $sth->bindparam(":gname", $gname);
        $sth->bindparam(":description", $description);
        $sth->bindparam(":unique_url", $unique_url);
        $del=$sth->execute();
        return $del;
    }
     public function updateProjectGroup($gname,$description,$cid,$projects,$unique_url,$id){
        $sth = $this->db->prepare("UPDATE `projectgroup` SET `name`=:gname,`description`=:description,`client`='$cid',`projects`='$projects',`unique_url`='$unique_url' WHERE `id` = $id");
        $sth->bindparam(":gname", $gname);
        $sth->bindparam(":description", $description);
        $del=$sth->execute();
        return $del;
    }
    
    // ~~~~~~~~~~~
    
}