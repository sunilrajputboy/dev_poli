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
    	public function getAnalytics($eventId){
        $sth = $this->db->prepare("SELECT * FROM `analytics` WHERE event_id =:eventId");
        $sth->bindparam(":eventId", $eventId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    } 
    	public function getAnalyticsByproKey($eventId,$proKeyArr){
        $sth = $this->db->prepare("SELECT * FROM `analytics` WHERE `pro_key` IN ('$proKeyArr') AND event_id =$eventId");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    } 
    	public function getAnalyticsByproject($eventId,$pkey){
        $sth = $this->db->prepare("SELECT * FROM `analytics` WHERE `pro_key`=:pkey AND event_id =:eventId");
        $sth->bindparam(":eventId", $eventId);
        $sth->bindparam(":pkey", $pkey);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    } 
      //30 days
    	public function getDaysIntervalByprokey($eventId,$pro_key){
        $sth = $this->db->prepare("SELECT * FROM `analytics` WHERE DATE(time) >= DATE(NOW()) - INTERVAL 30 DAY AND `pro_key`=:pro_key AND event_id =:eventId");
        $sth->bindparam(":eventId", $eventId);
        $sth->bindparam(":pro_key", $pro_key);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    } 
  
    	public function getDaysIntervalByIn($eventId,$proKeyArr){
        $sth = $this->db->prepare("SELECT * FROM `analytics` WHERE DATE(time) >= DATE(NOW()) - INTERVAL 30 DAY AND `pro_key` IN ('$proKeyArr') AND event_id =:eventId");
        $sth->bindparam(":eventId", $eventId);
        // $sth->bindparam(":proKeyArr", $proKeyArr);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    } 
    	public function getDaysIntervalByEventId($eventId){
        $sth = $this->db->prepare("SELECT * FROM `analytics` WHERE DATE(time) >= DATE(NOW()) - INTERVAL 30 DAY AND `event_id` =:eventId");
        $sth->bindparam(":eventId", $eventId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    } 
      //6 month
     	public function getSixmonthInterval($eventId,$pro_key){
        $sth = $this->db->prepare("SELECT * FROM `analytics` WHERE DATE(time) >= DATE(NOW()) - INTERVAL 6 month AND `pro_key`=:pro_key AND event_id =:eventId");
        $sth->bindparam(":eventId", $eventId);
        $sth->bindparam(":pro_key", $pro_key);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    } 
    	public function getSixmonthIntervalByIn($eventId,$proKeyArr){
        $sth = $this->db->prepare("SELECT * FROM `analytics` WHERE DATE(time) >= DATE(NOW()) - INTERVAL 6 month AND `pro_key` IN ('$proKeyArr') AND event_id =:eventId");
        $sth->bindparam(":eventId", $eventId);
        // $sth->bindparam(":proKeyArr", $proKeyArr);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    } 
      	public function getSixmonthIntervalByEventId($eventId){
        $sth = $this->db->prepare("SELECT * FROM `analytics` WHERE DATE(time) >= DATE(NOW()) - INTERVAL 6 month AND `event_id` =:eventId");
        $sth->bindparam(":eventId", $eventId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    } 
    //12 month
      	public function getYearInterval($eventId,$pro_key){
        $sth = $this->db->prepare("SELECT * FROM `analytics` WHERE DATE(time) >= DATE(NOW()) - INTERVAL 12 month AND `pro_key`=:pro_key AND event_id =:eventId");
        $sth->bindparam(":eventId", $eventId);
        $sth->bindparam(":pro_key", $pro_key);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    } 
    	public function getYearIntervalByIn($eventId,$proKeyArr){
        $sth = $this->db->prepare("SELECT * FROM `analytics` WHERE DATE(time) >= DATE(NOW()) - INTERVAL 12 month AND `pro_key` IN ('$proKeyArr') AND event_id =:eventId");
        $sth->bindparam(":eventId", $eventId);
        // $sth->bindparam(":proKeyArr", $proKeyArr);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    } 
      	public function getYearIntervalByEventId($eventId){
        $sth = $this->db->prepare("SELECT * FROM `analytics` WHERE DATE(time) >= DATE(NOW()) - INTERVAL 12 month AND `event_id` =:eventId");
        $sth->bindparam(":eventId", $eventId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    } 

    // 1 week 
    public function getweekInterval($eventId,$pro_key){
        $sth = $this->db->prepare("SELECT * FROM `analytics` WHERE DATE(time) >= DATE(NOW()) - INTERVAL 1 week AND `pro_key`=:pro_key AND event_id =:eventId");
        $sth->bindparam(":eventId", $eventId);
        $sth->bindparam(":pro_key", $pro_key);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    } 
    public function getCustomInterval($eventId,$pro_key, $from ,$to){
        $sth = $this->db->prepare("SELECT * FROM `analytics` WHERE (DATE(time) BETWEEN '$from' AND '$to') AND `pro_key`=:pro_key AND event_id =:eventId");
        $sth->bindparam(":eventId", $eventId);
        $sth->bindparam(":pro_key", $pro_key);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    } 
    public function getCustomIntervalByIn($eventId,$proKeyArr, $from, $to){
        $sth = $this->db->prepare("SELECT * FROM `analytics` WHERE (DATE(time) BETWEEN '$from' AND '$to') AND `pro_key` IN ('$proKeyArr') AND event_id =:eventId");
        $sth->bindparam(":eventId", $eventId);
        // $sth->bindparam(":proKeyArr", $proKeyArr);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    } 
    public function getCustomIntervalByEventId($eventId,$from,$to){
        $sth = $this->db->prepare("SELECT * FROM `analytics` WHERE (DATE(time) BETWEEN '$from' AND '$to') AND `event_id` =:eventId");
        $sth->bindparam(":eventId", $eventId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    } 

    public function getweekIntervalByIn($eventId,$proKeyArr){
        $sth = $this->db->prepare("SELECT * FROM `analytics` WHERE DATE(time) >= DATE(NOW()) - INTERVAL 1 week AND `pro_key` IN ('$proKeyArr') AND event_id =:eventId");
        $sth->bindparam(":eventId", $eventId);
        // $sth->bindparam(":proKeyArr", $proKeyArr);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    } 
    public function getweekIntervalByEventId($eventId){
        $sth = $this->db->prepare("SELECT * FROM `analytics` WHERE DATE(time) >= DATE(NOW()) - INTERVAL 1 week AND `event_id` =:eventId");
        $sth->bindparam(":eventId", $eventId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    } 
    public function getMPtweetDATA(){
        $sth = $this->db->prepare("SELECT `mp_name`, `pro_key`, `id`, `mp_email`, `signuptime` FROM `improve_analytics` WHERE `event_id` =5");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_GROUP);
    } 
    public function getemailMpDATA(){
        $sth = $this->db->prepare("SELECT `mp_name`, `event_id`, `pro_key`, `user_email`, `user_name`, `id`, `mp_email`, `signuptime`, `confirm`, `confirmtime`  FROM `improve_analytics` WHERE `event_id` =6");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_GROUP);
    } 
    public function getexportDATA(){
        $sth = $this->db->prepare("SELECT * FROM `improve_analytics` WHERE `confirm` = 'true' AND `event_id` =6");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    } 

    public function deleteAnalyticsById($id){
        $sth = $this->db->prepare("DELETE FROM `improve_analytics` WHERE `id` = '$id'");
        $del=$sth->execute();
        return $del;
    }
    public function getAnalyticsById($id)
    {
        $sth = $this->db->prepare("SELECT * FROM `improve_analytics` where id='$id'");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function confirmUnconfirmSubs($value,$time,$id)
    {
        $sth = $this->db->prepare("UPDATE `improve_analytics` SET `confirm`= '$value',`confirmtime`='$time' WHERE `id`='$id'");
        $ret=$sth->execute();
        return  $ret;
    }
}