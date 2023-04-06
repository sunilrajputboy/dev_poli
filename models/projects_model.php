<?php
class projects_model extends Model
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
    
    public function getProKey_colors($projectId){
        $sth = $this->db->prepare("SELECT * FROM `projects` where id_project=:projectId");
        $sth->bindparam(":projectId", $projectId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    
     public function updateProname($pname,$id){ 
        $sth = $this->db->prepare("UPDATE `projects` SET `name`=:pname WHERE `id_project` = $id");
        $sth->bindparam(":pname", $pname);
        $ret=$sth->execute();
        return $ret;
    }
       public function updatePrivacypolicyContent($pp,$id){ 
        $sth = $this->db->prepare("UPDATE `projects` SET `privacypolicy`=:pp WHERE `id_project` = $id");
        $sth->bindparam(":pp", $pp);
        $ret=$sth->execute();
        return $ret;
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
	

	public function checkProjectFieldValue($pro_id,$city_id){
        $sth = $this->db->prepare("SELECT * FROM `data_field_value_new` WHERE `pro_id` =:proId AND `city_id` =:cityId");
        $sth->bindparam(":proId", $pro_id);
        $sth->bindparam(":cityId", $city_id);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	/**********/
    public function insertDataFieldValue1($query)
    {
		$sth = $this->db->prepare($query);
        $sth->execute();
        return true;
    }
	/**********/
   public function datafieldvalueByProid($prodecryptid){
        $sth = $this->db->prepare("SELECT * FROM `data_field_value_new` WHERE `pro_id` =:proId");
		$sth->bindparam(":proId", $prodecryptid);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	/**********/
   public function insertNewFieldvalue($latestId,$city_id,$field_value_data,$node_text,$node_image){
        $sth = $this->db->prepare("INSERT INTO `data_field_value_new`(`pro_id`, `city_id`,`field_value_data`, `node_text`,`node_image`,`status`) VALUES ('$latestId','$city_id','$field_value_data','$node_text','$node_image','0')");
        $ins=$sth->execute();
        return $ins;
    }
	/**********/
	public function getAllClients(){
        $sth = $this->db->prepare("SELECT * FROM `clients` ORDER BY `name` ASC");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	
	public function getAllProjectGroups(){
        $sth = $this->db->prepare("SELECT * FROM `projectgroup`");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getProjectGroupByID($gid){
        $sth = $this->db->prepare("SELECT * FROM `projectgroup` where id=$gid");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	
	public function getClientsById($clientId){
        $sth = $this->db->prepare('SELECT * FROM `clients` where id=:clientId');
        $sth->bindparam(":clientId", $clientId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
   public function getFieldvalueByCityId($cid,$pid){
        $sth = $this->db->prepare("SELECT * FROM `data_field_value_new` WHERE `city_id` = $cid AND `pro_id` = $pid");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	/*********ANSWER-BY-CHATGPT********/
public function getfieldValues($id, $pro_id){
    $sth = $this->db->prepare("SELECT field_value_data FROM `data_field_value_new` WHERE `pro_id` = :ProId");
    $sth->bindParam(":ProId", $pro_id);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_COLUMN);

    $maindata2 = array();
    $maindata3 = array();
    foreach ($result as $fv_data) {
        $field_value_data = unserialize($fv_data);
        if (!empty($field_value_data)) {
            foreach ($field_value_data as $val) {
                $value = current($val);
                $key = key($val);
                if ($key == $id) {
					if($val!=""){
						$maindata3[] = $value;
					}
						$maindata2[] = $value;
                }
            }
        }
    }

    $maindata = array('min_value' => 0, 'max_value' => 0, 'total_count' => 0, 'total_sum' => 0,'all_df_value'=>array());
    if (!empty($maindata2)) {
		$maindata_num = array_filter($maindata2, 'is_numeric');
        $maindata = array(
            'min_value' => !empty($maindata_num) ? min($maindata_num) : 0.00,
            'max_value' => !empty($maindata_num) ? max($maindata_num) : 0.00,
            'total_count' => !empty($maindata_num) ? count($maindata_num) : 0.00,
            'total_sum' => !empty($maindata_num) ? array_sum($maindata_num) : 0.00,
            'all_df_value' => $maindata2,
            'not_empty_df_count' => count($maindata3),
            'not_empty_df_sum' => array_sum($maindata3),
            'not_empty_df_value' => $maindata3
        );
    }

    return $maindata;
}
	/******************/
   public function getfieldValues2($id,$pro_id){
        $sth = $this->db->prepare("SELECT field_value_data FROM `data_field_value_new` WHERE `pro_id` =:ProId");
		$sth->bindparam(":ProId", $pro_id);
        $sth->execute();
		$result=$sth->fetchAll(PDO::FETCH_ASSOC);
		$maindata2=array();
		if(!empty($result)){
		 foreach($result as $res){
			$fv_data=$res['field_value_data'];
			$field_value_data=($fv_data) ? unserialize($fv_data): array();
			if(!empty($field_value_data)){
						foreach($field_value_data as $val){
							$value = current($val);
							$key = key($val);
							if($key==$id){
							$maindata2[]=$value;
							}
						}
					}
		 }	
		}
		$maindata=array('min_value'=>0,'max_value'=>0,'total_count'=>0,'total_sum'=>0);
		if(!empty($maindata2)){
			$min_value = min($maindata2);
			$max_value = max($maindata2);
			$total_sum = array_sum($maindata2);
			$total_count = count($maindata2);
			$maindata=array('min_value'=>$min_value,'max_value'=>$max_value,'total_count'=>$total_count,'total_sum'=>$total_sum);
		}
        return $maindata;
    }
	
    public function maxfieldValue($id){
		 $query='SELECT MAX(CONVERT(SUBSTRING_INDEX(SUBSTRING_INDEX(field_value_data,\':"\', -1),\'"\', 1), DECIMAL(10,3))) AS max_value FROM data_field_value_new WHERE field_value_data LIKE CONCAT("%", :id, ";%") AND pro_id=:proId';
		$sth = $this->db->prepare($query);
		$sth->bindparam(":id", $id);
		$sth->bindparam(":proId", $proid);
        $sth->execute();
		$results=$sth->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
/****-UN-USED-FUNCTIONS-***

	public function getProjectFieldValueSingle($pro_id,$city_id,$field_id){
        $sth = $this->db->prepare("SELECT * FROM `data_field_value` WHERE `pro_id` =:proId AND `city_id` =:cityId AND field_id=:fieldId ");
        $sth->bindparam(":proId", $pro_id);
        $sth->bindparam(":cityId", $city_id);
        $sth->bindparam(":fieldId", $field_id);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	
	public function insertFieldvalue($latestId,$city_id,$field_id,$field_value){
        $sth = $this->db->prepare("INSERT INTO `data_field_value`(`pro_id`, `city_id`, `field_id`, `field_value`) VALUES ('$latestId','$city_id','$field_id','$field_value')");
        $ins=$sth->execute();
        return $ins;
    }
    public function countfieldValue($id){
        $sth = $this->db->prepare("SELECT count(cast(`field_value` as unsigned)) AS 'total' FROM `data_field_value` WHERE `field_id` =$id");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	
  public function getEqualCountvalues($id,$proid,$from, $to){
        $sth = $this->db->prepare("SELECT cast(`field_value` as decimal(12,2)) as 'value' FROM `data_field_value` WHERE `field_id` =$id LIMIT $from, $to");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_COLUMN);
    }
   public function getEqualCountvaluesV2($id, $from, $to){
        $sth = $this->db->prepare("SELECT cast(`field_value` as decimal(12,2)) as 'value' FROM `data_field_value` WHERE `field_value` != '' AND `field_id` =$id ORDER BY cast(`field_value` as decimal(12,2)) DESC LIMIT $from,$to");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_COLUMN);
    }
    public function getEqualCountvalueswithIgnore($id){
        $sth = $this->db->prepare("SELECT cast(`field_value` as decimal(12,2)) as 'value' FROM `data_field_value` WHERE `field_value` != '' AND  `field_id` =$id");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_COLUMN);
    }
    public function minfieldValue($id){
        $sth = $this->db->prepare("SELECT MIN(cast(`field_value` as decimal(12,2))) AS 'min' FROM `data_field_value` WHERE `field_id` = $id");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function select_data_field_value_by_fid($field_id){
        $sth = $this->db->prepare("SELECT * FROM `data_field_value` WHERE field_id=:fieldId ");
        $sth->bindparam(":fieldId", $field_id);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function insertDataFieldValue($proId, $city_id, $fieldId){
        $sth = $this->db->prepare("INSERT INTO `data_field_value` (`pro_id`, `city_id`, `field_id`) VALUES ('$proId','$city_id','$fieldId')");
        $ins=$sth->execute();
        $insert_id = $this->db->lastInsertId();
        $key = 'Hl2018@1212';
        $encrypted_id = openssl_encrypt($insert_id,'AES-128-ECB',$key, OPENSSL_RAW_DATA);
        $encrypted_id = strtolower(bin2hex($encrypted_id));
        $sth1 = $this->db->prepare("UPDATE `projects` SET `proKey`= '$encrypted_id' WHERE `id_project` = $insert_id");
        $ins=$sth1->execute();
        return $ins;
    }
    public function deletefieldval($proId,$id){
        $sth = $this->db->prepare("DELETE FROM `data_field_value` WHERE `pro_id` = $proId AND `field_id` = $id");
		$sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }	
****/	

 	public function getMapTemplatesById($id){
        $sth = $this->db->prepare('SELECT * FROM `map_templates` WHERE `id_map_templates` =:tid');
        $sth->bindparam(":tid", $id);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
 	public function getAllMapTemplates(){
        $sth = $this->db->prepare('SELECT * FROM `map_templates` ORDER BY `map_name` ASC');
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getMapTemplatesByCategory($category_id){
        $sth = $this->db->prepare('SELECT * FROM `map_templates` WHERE `category_id`= :catId AND `hidden`=0 ORDER BY map_name ASC');
		$sth->bindparam(":catId", $category_id);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }	
	public function getMapTemplateCategory(){
        $sth = $this->db->prepare('SELECT * FROM `map_category` WHERE `status`=0 ORDER BY category_name ASC');
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function deleteProject($projectId){
        $sth = $this->db->prepare("DELETE `projects`, `project_fields`, `data_field_value_new` FROM `projects` LEFT join project_fields on projects.id_project = project_fields.id_project LEFT join data_field_value_new on projects.id_project = data_field_value_new.pro_id WHERE projects.id_project = :projectId");
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
	public function dataFieldsByName($name,$proId){
        $sth = $this->db->prepare('SELECT * FROM `project_fields` WHERE field_name= :fieldName AND `id_project`=:proId ORDER BY `sequence_no`');
        $sth->bindparam(":fieldName", $name);
        $sth->bindparam(":proId", $proId);
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
        $sth = $this->db->prepare("SELECT * FROM `projectgroup` WHERE `client` = :Client ORDER BY `sequence_no` ASC");
        $sth->bindparam(":Client", $client);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getProjectGroupCreatedBy($createdBy){
        $sth = $this->db->prepare("SELECT * FROM `projectgroup` WHERE `createdby` = :createdBy ORDER BY `sequence_no` ASC");
        $sth->bindparam(":Client", $client);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function datafieldsWithoutChild($projectId){
        $sth = $this->db->prepare("SELECT * FROM `project_fields` WHERE parentId = 0 AND id_project = :projectId ORDER BY `sequence_no` ASC");
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
	public function sortingchartWizard($sequence,$id){
        $sth = $this->db->prepare("UPDATE `chart_wizard` SET `sequence_no`= '$sequence' WHERE `id` = $id");
        $sth->execute();
        return $sth;
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
	public function getClientWhereIn($clientIds){
        $sth = $this->db->prepare("SELECT * FROM `clients` WHERE `id` IN ($clientIds)");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getPackageByClientId($clientIds){
        $sth = $this->db->prepare("SELECT * FROM `packages` WHERE `id`=:clientIds");
		$sth->bindparam(":clientIds", $clientIds);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	
	public function updateGeneral($unique_url,$project_id){
        $sth = $this->db->prepare("UPDATE `projects` SET `unique_url`= :uniqueUrl WHERE `id_project` = :projectId");
        $sth->bindparam(":uniqueUrl", $unique_url);
        $sth->bindparam(":projectId", $project_id);
        $ret=$sth->execute();
        return $ret;
    }
	
    public function update($pname,$title,$logo,$logourl,$description,$colorprime,$colorsecond,$text_color,$text_color2,$text_color3,$color,$fonts,$email_mp,$charts,$is_social_share,$is_email_share,$is_tweet_mp,$id){ 
        $sth = $this->db->prepare("UPDATE `projects` SET `title`=:title,`logo`='$logo',`logourl`='$logourl',`description`=:description,`primary_color`='$colorprime',`secondary_color`='$colorsecond',`text_color`='$text_color',`text_color2`='$text_color2',`text_color3`='$text_color3',`key_colors` = '$color' WHERE `id_project` = $id");
           $sth->bindparam(":title", $title);
          $sth->bindparam(":description", $description);
        $ret=$sth->execute();
        //$ret=$sth->queryString;
        return $ret;
    }
    
    public function updateContent($footer_content,$node_description,$print_description,$node_intro,$id){
        $sth = $this->db->prepare("UPDATE `projects` SET `footer_content`=:footer_content, `node_description` =:node_description,`print_description`=:print_description,`node_intro`=:node_intro WHERE `id_project` = $id");
            $sth->bindparam(":footer_content", $footer_content);
         $sth->bindparam(":node_description", $node_description);
         $sth->bindparam(":print_description", $print_description);
           $sth->bindparam(":node_intro", $node_intro);
        $ret=$sth->execute();
        return $ret;
    }
    public function checkUniqueUrl($unique_url,$project_id,$cid){
        $sth = $this->db->prepare('SELECT * FROM `projects` WHERE `id_client`= :cid AND `unique_url` =:unique_url AND id_project!=:project_id');
        $sth->bindparam(":unique_url", $unique_url);
        $sth->bindparam(":project_id", $project_id);
          $sth->bindparam(":cid", $cid);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    public function checkUniqueUrlfromall($unique_url){
        $sth = $this->db->prepare('SELECT * FROM `projects` WHERE `unique_url` =:unique_url');
        $sth->bindparam(":unique_url", $unique_url);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    public function checkUniqueUrllike($unique_url,$cid){
        $sth = $this->db->prepare('SELECT * FROM `projects` WHERE `id_client`= :cid AND `unique_url` like "%'.$unique_url.'%"');
           $sth->bindparam(":cid", $cid);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    
      public function updateUniqueUrl($unique_url,$project_id){
        $sth = $this->db->prepare("UPDATE `projects` SET `unique_url`='$unique_url' WHERE `id_project` = $project_id");
        $ret=$sth->execute();
        return $ret;
    }
    
       public function projectstatus($password_protected,$visibility,$user_id){
        $sth = $this->db->prepare("UPDATE `projects` SET `visibility`='$visibility', `password_protected`='$password_protected' WHERE `id_project` = '$user_id'");
        $ret=$sth->execute();
        return $ret;
    }
        public function addpassword($password,$id){
        $sth = $this->db->prepare("UPDATE `projects` SET `password`= '$password' WHERE `id_project` = $id");
        $ret=$sth->execute();
        return $ret;
    }
    
	public function updateSettings($fonts,$email_mp,$email_sub,$message,$emailmp_MH,$hide_node,$charts,$is_social_share,$is_email_share,$is_tweet_mp,$tweet_mp_text,$is_facebook,$is_insta,$is_twitter,$is_linkedin,$email_friend_text,$email_friend_title,$is_email_friend,$cta_text,$subscribe_mail_text,$subscribe_mail_address,$copyright_title,$copyright_link,$is_pdf_download,$is_image_export,$id){
        $sth = $this->db->prepare("UPDATE `projects` SET `font` = '$fonts', `is_mp` = '$email_mp',`email_sub`=:email_sub,`emailmp_MH`=:emailmp_MH,`message`=:message,`hide_node`='$hide_node',`is_charts` =  '$charts', `is_social_share` = '$is_social_share',`is_email_share` = '$is_email_share', `is_tweet_mp` = '$is_tweet_mp' ,`tweet_mp_text`=:tweet_mp_text,`is_facebook` = :is_facebook, `is_insta` = :is_insta,  `is_twitter` = :is_twitter,`is_linkedin` = :is_linkedin,`email_friend_text`=:email_friend_text,`email_friend_title`=:email_friend_title,`is_email_friend` = :is_email_friend,`cta_text`=:ctaText,`subscribe_mail_text`=:subscribe_mail_text,`subscribe_mail_address`='$subscribe_mail_address',`copyright_title`='$copyright_title',`copyright_link`='$copyright_link',`is_pdf_download` = :isPdfDownload,  `is_image_export` = :isImageExport WHERE `id_project` = $id");
        $sth->bindparam(":subscribe_mail_text", $subscribe_mail_text);
        $sth->bindparam(":email_sub", $email_sub);
		$sth->bindparam(":message", $message);
		$sth->bindparam(":emailmp_MH", $emailmp_MH);
		$sth->bindparam(":tweet_mp_text", $tweet_mp_text);
		$sth->bindparam(":is_facebook", $is_facebook);
		$sth->bindparam(":is_insta", $is_insta);
		$sth->bindparam(":is_twitter", $is_twitter);
		$sth->bindparam(":is_linkedin", $is_linkedin);
		$sth->bindparam(":email_friend_text", $email_friend_text);
		$sth->bindparam(":email_friend_title", $email_friend_title);
		$sth->bindparam(":is_email_friend", $is_email_friend);
		$sth->bindparam(":isPdfDownload", $is_pdf_download);
		$sth->bindparam(":isImageExport", $is_image_export);
		$sth->bindparam(":ctaText", $cta_text);
        $upd=$sth->execute();
		//var_dump($sth->errorInfo());exit;
        return $upd;
    }
		
	public function getNodeDetails($project_id){
     $sth = $this->db->prepare("SELECT data_field_value_new.*,map_template_regions.name FROM `data_field_value_new` LEFT JOIN map_template_regions ON data_field_value_new.city_id=map_template_regions.id WHERE data_field_value_new.pro_id=$project_id ORDER BY map_template_regions.name");
     $sth->execute();
     return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    
     public function addprojects($pname, $map, $title, $idclient,$is_email_mp,$is_charts,$is_socialshare,$added_by,$unique_url){
        $sth = $this->db->prepare("INSERT INTO `projects`(`name`, `id_map_template`, `title`, `id_client`,`is_mp`, `is_charts`, `is_social_share`, `added_by`, `is_facebook`, `is_insta`, `is_twitter`, `is_linkedin`,`unique_url`) VALUES (:pname, '$map', :title, '$idclient','$is_email_mp','$is_charts','$is_socialshare','$added_by','no','no','no','no',:unique_url)");
        $sth->bindparam(":pname", $pname);
         $sth->bindparam(":title", $title);
          $sth->bindparam(":unique_url", $unique_url);
        $ins=$sth->execute();
        $insert_id = $this->db->lastInsertId();
        $key = 'Hl2018@1212';
        $encrypted_id = openssl_encrypt($insert_id,'AES-128-ECB',$key, OPENSSL_RAW_DATA);
        $encrypted_id = strtolower(bin2hex($encrypted_id));
        $sth1 = $this->db->prepare("UPDATE `projects` SET `proKey`= '$encrypted_id' WHERE `id_project` = $insert_id");
        $ins=$sth1->execute();
        return $encrypted_id;
    }
/*****
// update data_field_value_new
***/
public function updateDataFieldValueNew($proId, $city_id, $field_value_data,$node_text,$node_image){
		$sth=$this->db->prepare("UPDATE `data_field_value_new`(`pro_id`, `city_id`,`field_value_data`,`node_text`,`node_image`) VALUES ('$proId','$city_id','$field_value_data','$node_text','$node_image')");
        $ins=$sth->execute();
        $insert_id = $this->db->lastInsertId();
        return $ins;
    }
/******/	
	public function addDataFields($proId, $name, $displayName,$type,$hide_node,$hide_empty_valu_on_node,$description1,$myJSON,$isGroup){
        $sth = $this->db->prepare("INSERT INTO `project_fields` (`id_project`, `field_name`, `display_name`, `field_type`,`hide_node`,`hide_empty_valu_on_node`, `description`, `field_data`,`isGroup`) VALUES ('$proId',:name,:displayName,'$type','$hide_node','$hide_empty_valu_on_node',:description1,:myJSON,'$isGroup')");
        $sth->bindparam(":name", $name);
        $sth->bindparam(":displayName", $displayName);
        $sth->bindparam(":description1", $description1);
        $sth->bindparam(":myJSON", $myJSON);
        $ins=$sth->execute();
        $insert_id = $this->db->lastInsertId();
        return $insert_id;
    }
	
	public function mapTemplateRegions($idMapTemplate){
        $sth = $this->db->prepare("SELECT * FROM `map_template_regions` WHERE `id_map_template`=:idMapTemplate");
		$sth->bindparam(":idMapTemplate", $idMapTemplate);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	
	public function getSameMapTemplateRegions($proId){
        $sth = $this->db->prepare("SELECT `id`,`city_id`,field_value_data,node_text,node_image,status FROM `data_field_value_new` WHERE `pro_id`=:proId");
		$sth->bindparam(":proId", $proId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	
	
    public function addChart($cname,$c_displayname,$x_axis,$y_axis,$graphfor,$hide_average,$graph_type,$fieldData,$field_color,$average_color,$mapWidth,$pro_id){
        $sth = $this->db->prepare("INSERT INTO `chart_wizard`(`name`,`display_name`,`x_axis`,`y_axis`, `graph_for`,`hide_average`, `graph_type`, `datafields`,`field_color`,`average_color`, `map_width`, `pro_id`) VALUES (:cname,:c_displayname,:x_axis,:y_axis,'$graphfor','$hide_average','$graph_type',:fieldData,:field_color,:average_color,'$mapWidth','$pro_id')");
		$sth->bindparam(":cname", $cname);
		$sth->bindparam(":c_displayname", $c_displayname);
		$sth->bindparam(":x_axis", $x_axis);
		$sth->bindparam(":y_axis", $y_axis);
		$sth->bindparam(":fieldData", $fieldData);
		$sth->bindparam(":field_color", $field_color);
		$sth->bindparam(":average_color", $average_color);
		$sth->execute();
        return $sth;
    }
     public function copyChartData($cname,$graphfor,$graph_type,$fieldData,$mapWidth,$sequence_no,$latestId){
        $sth = $this->db->prepare("INSERT INTO `chart_wizard`(`name`, `graph_for`, `graph_type`, `datafields`, `map_width`,`sequence_no`, `pro_id`) VALUES (:cname,'$graphfor','$graph_type',:fieldData,'$mapWidth','$sequence_no','$latestId')");
		$sth->bindparam(":cname", $cname);
		$sth->bindparam(":fieldData", $fieldData);
		$sth->execute();
        return $sth;
    }
    public function updateChart($cname,$chart_displayname,$c_x_axis,$c_y_axis,$graphfor,$hide_average,$graph_type,$fieldData,$field_color,$average_color,$mapWidth,$id){
        $sth = $this->db->prepare("UPDATE `chart_wizard` SET `name`=:cname,`display_name`=:chart_displayname,`x_axis`=:c_x_axis,`y_axis`=:c_y_axis,`graph_for`='$graphfor',`hide_average`='$hide_average',`graph_type`='$graph_type',`datafields`=:fieldData,`field_color`=:field_color,`average_color`=:average_color,`map_width`='$mapWidth' WHERE `id` = $id");
			$sth->bindparam(":fieldData", $fieldData);
			$sth->bindparam(":field_color", $field_color);
			$sth->bindparam(":average_color", $average_color);
			$sth->bindparam(":chart_displayname", $chart_displayname);
			$sth->bindparam(":c_x_axis", $c_x_axis);
			$sth->bindparam(":c_y_axis", $c_y_axis);
			$sth->bindparam(":cname", $cname);
		$sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    public function deleteChart($id){
        $sth = $this->db->prepare("DELETE FROM `chart_wizard` WHERE `id` = '$id'");
		$sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
      public function deleteprofield($id){
        $sth = $this->db->prepare("DELETE FROM `project_fields` WHERE `id_project_field` = $id");
		$sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    public function leftdatafiledfromGroup($id){
        $sth = $this->db->prepare("UPDATE `project_fields` SET `parentId`=0 WHERE `parentId` = $id");
		$sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    

    
    public function getChartData($id){
        $sth = $this->db->prepare("SELECT * FROM `chart_wizard` WHERE `id`=:id");
        $sth->bindparam(":id", $id);
		$sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getDataFieldsByFieldId($did){
        $sth = $this->db->prepare('SELECT * FROM `project_fields` WHERE id_project_field =:did');
        $sth->bindparam(":did", $did);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getDataFieldsByMultiple($Id,$fieldName,$proId){
        $sth = $this->db->prepare('SELECT * FROM `project_fields` WHERE `id_project_field` != :Id AND `field_name` = :fieldName AND `id_project` = :proId');
        $sth->bindparam(":Id", $Id);
        $sth->bindparam(":fieldName", $fieldName);
        $sth->bindparam(":proId", $proId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    public function updateProjectFieldsById($name,$dname,$type,$hide_node,$hide_empty_valu_on_node,$description,$myJSON,$id){
        $sth = $this->db->prepare("UPDATE `project_fields` SET `field_name`=:Name, `display_name` =:Dname, `field_type`=:Type,`hide_node`=:hide_node,`hide_empty_valu_on_node`=:hide_empty_valu_on_node,`description`=:Description,`field_data`=:FieldData WHERE `id_project_field` = :PrId");
		$sth->bindparam(":Name", $name);
		$sth->bindparam(":Dname", $dname);
		$sth->bindparam(":Type", $type);
		$sth->bindparam(":hide_node", $hide_node);
		$sth->bindparam(":hide_empty_valu_on_node", $hide_empty_valu_on_node);
		$sth->bindparam(":Description", $description);
		$sth->bindparam(":FieldData", $myJSON);
		$sth->bindparam(":PrId", $id);
		$sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
       public function updateProjectFieldsortingData($pftype,$pfdata,$parentid,$fieldid){
        $sth = $this->db->prepare("UPDATE `project_fields` SET `field_type`=:pftype,`field_data`=:pfdata, `parentId`='$parentid', `isGroup` = '0' WHERE `id_project_field` = $fieldid");
		$sth->bindparam(":pftype", $pftype);
		$sth->bindparam(":pfdata", $pfdata);
		$sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    
      public function updateProjectFieldsortingDataWithRestrict($parentid,$fieldid){
        $sth = $this->db->prepare("UPDATE `project_fields` SET `parentId`='$parentid', `isGroup` = '0' WHERE `id_project_field` = $fieldid");
		$sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function updateProjectFieldsByParentId($type,$hide_node,$hide_empty_valu_on_node,$description,$myJSON,$parentId){
        $sth = $this->db->prepare("UPDATE `project_fields` SET `field_type`=:Type,`hide_node`=:hide_node,`hide_empty_valu_on_node`=:hide_empty_valu_on_node,`description`=:Description,`field_data`=:FieldData WHERE `parentId` =:PrId");
		$sth->bindparam(":Type", $type);
			$sth->bindparam(":hide_node", $hide_node);
			$sth->bindparam(":hide_empty_valu_on_node", $hide_empty_valu_on_node);
		$sth->bindparam(":Description", $description);
		$sth->bindparam(":FieldData", $myJSON);
		$sth->bindparam(":PrId", $parentId);
		$sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    	public function hideprojects($proId){
        $sth = $this->db->prepare("UPDATE `projects` SET `visibility`= '0', `password_protected`= '0' WHERE `id_project` = $proId");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    	public function showprojects($proId){
        $sth = $this->db->prepare("UPDATE `projects` SET `visibility`= '1' WHERE `id_project` = $proId");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    	public function lockprojects($proId){
        $sth = $this->db->prepare("UPDATE `projects` SET `visibility`= '1', `password_protected`= '1' WHERE `id_project` = $proId");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    	public function unlockprojects($proId){
        $sth = $this->db->prepare("UPDATE `projects` SET `visibility`= '1', `password_protected`= '0' WHERE `id_project` = $proId");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    public function checklast_copy($projectname){
        $sth = $this->db->prepare("SELECT * FROM projects WHERE `name` LIKE '".$projectname."-copy-%' ORDER BY id_project DESC LIMIT 1");
        $sth->execute();
        $ret = $sth->fetchAll(PDO::FETCH_ASSOC);
	if(!empty($ret)){
		$project_name=$ret['name'];
		$copytext = explode("-",$project_name);
		$lastElement = end($copytext);
		$count=(int)$lastElement;
		$cpycnt=$count+1;
		$newname=$projectname;
		$name = $newname.''.$cpycnt;
		return $name;
	}else{
	return $projectname.'1';	
	}
}

public function copyProject($idClient,$id_map_template,$name,$title,$logo,$description1,$datafield_label_style,$colorprime,$colorsecond,$text_color,$text_color2,$text_color3,$key_colors,$footer_content,$node_description1,$sequence_no,$visibility,$password_protected,$password,$font,$is_mp,$is_charts,$is_social_share,$is_email_share,$is_tweet_mp, $copycountnum,$uid,$email_sub,$message,$is_facebook,$is_insta,$is_twitter,$is_linkedin,$is_email_friend,$email_friend_text,$email_friend_title,$tweet_mp_text){
$sth = $this->db->prepare("INSERT INTO `projects`(`id_client`, `id_map_template`, `name`, `title`, `logo`, `description`, `datafield_label_style`,`primary_color`,`secondary_color`,`text_color`,`text_color2`,`text_color3`, `key_colors`, `footer_content`,`node_description`, `sequence_no`, `visibility`, `password_protected`, `password`, `font`, `is_mp`, `is_charts`, `is_social_share`, `is_email_share`, `is_tweet_mp`, `copy_count`,`added_by`,`email_sub`,`message`,`is_facebook`,`is_insta`,`is_twitter`,`is_linkedin`,`is_email_friend`,`email_friend_text`,`email_friend_title`,`tweet_mp_text`) VALUES ('$idClient','$id_map_template',:name,:title,'$logo',:description1,'$datafield_label_style','$colorprime','$colorsecond','$text_color','$text_color2','$text_color3','$key_colors',:footer_content,:node_description1,'$sequence_no','$visibility','$password_protected','$password','$font','$is_mp','$is_charts','$is_social_share','$is_email_share','$is_tweet_mp', '$copycountnum','$uid','$email_sub','$message','$is_facebook','$is_insta','$is_twitter','$is_linkedin','$is_email_friend','$email_friend_text','$email_friend_title','$tweet_mp_text')");
$sth->bindparam(":name", $name);
$sth->bindparam(":title", $title);
$sth->bindparam(":description1", $description1);
$sth->bindparam(":footer_content", $footer_content);
$sth->bindparam(":node_description1", $node_description1);
$sth->execute();
$insert_id = $this->db->lastInsertId();
$key = 'Hl2018@1212';
$encrypted_id = openssl_encrypt($insert_id,'AES-128-ECB',$key, OPENSSL_RAW_DATA);
$encrypted_id = strtolower(bin2hex($encrypted_id));
$sth1 = $this->db->prepare("UPDATE `projects` SET `proKey`= '$encrypted_id' WHERE `id_project` = $insert_id");
$ins=$sth1->execute();
return $insert_id;
	}
	
public function insertProjectFileds($latestId,$fieldName,$fieldType,$description,$field_data,$sequence_no,$first_interval,$last_interval){
      $sth = $this->db->prepare("INSERT INTO `project_fields`( `id_project`, `field_name`, `field_type`, `description`, `field_data`,`sequence_no`,`first_interval`, `last_interval`) VALUES ('$latestId',:fieldName,'$fieldType',:description,:field_data,'$sequence_no','$first_interval','$last_interval')");
		$sth->bindparam(":fieldName", $fieldName);
		$sth->bindparam(":field_data", $field_data);
		$sth->bindparam(":description", $description);
		$sth->execute();
        $insert_id = $this->db->lastInsertId();
        return $insert_id;
}
public function setFieldSequence($sequence,$id){
     $sth = $this->db->prepare("UPDATE `project_fields` SET `sequence_no`= '$sequence' WHERE `id_project_field` = $id");
        $sth->execute();
        return $sth;
}
public function setIsgroup($fieldid){
     $sth = $this->db->prepare("UPDATE `project_fields` SET `isGroup` = '0'  WHERE `id_project_field` = $fieldid");
    $sth->execute();
    return $sth;
}

public function setIsgroupOrnot($pdval,$id,$restrict_children){
     $sth = $this->db->prepare("UPDATE `project_fields` SET `isGroup`= '$pdval',`restrict_children`='$restrict_children' WHERE `id_project_field` = $id");
    $sth->execute();
    return $sth;
}

public function setparentId($fieldid){
     $sth = $this->db->prepare("UPDATE `project_fields` SET `parentId`='0' WHERE `id_project_field` = $fieldid");
    $sth->execute();
    return $sth;
}

public function setInterval($first_interval,$last_interval,$colors,$max_key_values,$min_key_values,$key_value_option,$link_values,$show_last_key,$minDisplay_values,$maxDisplay_values,$id){
     $sth = $this->db->prepare("UPDATE `project_fields` SET `first_interval`= '$first_interval',`last_interval`= '$last_interval',`key_value_option`='$key_value_option',`link_values`='$link_values',`show_last_key`='$show_last_key',`key_colors`=:colors, `max_key_values`=:max_key_values,`min_key_values`=:min_key_values,`min_display_values`=:min_display_values,`max_display_values`=:max_display_values WHERE `id_project_field` = $id");
		$sth->bindparam(":colors", $colors);
		$sth->bindparam(":max_key_values", $max_key_values);
		$sth->bindparam(":min_key_values", $min_key_values);
		$sth->bindparam(":min_display_values", $minDisplay_values);
		$sth->bindparam(":max_display_values", $maxDisplay_values);      
    $sth->execute();
    return $sth;
}
public function setchildrenInterval($first_interval,$last_interval,$colors,$max_key_values,$min_key_values,$key_value_option,$link_values,$show_last_key,$minDisplay_values,$maxDisplay_values,$id){
     $sth = $this->db->prepare("UPDATE `project_fields` SET `first_interval`= '$first_interval',`last_interval`= '$last_interval',`key_value_option`='$key_value_option',`link_values`='$link_values',`show_last_key`='$show_last_key',`key_colors`=:colors, `max_key_values`=:max_key_values,`min_key_values`=:min_key_values,`min_display_values`=:min_display_values,`max_display_values`=:max_display_values WHERE `parentId` = $id");
		$sth->bindparam(":colors", $colors);
        $sth->bindparam(":max_key_values", $max_key_values);
		$sth->bindparam(":min_key_values", $min_key_values);
        $sth->bindparam(":min_display_values", $minDisplay_values);
		$sth->bindparam(":max_display_values", $maxDisplay_values);  
    $sth->execute();
    return $sth;
}

public function updateDisVal($id)
{
    $sth = $this->db->prepare("UPDATE `project_fields` SET `min_display_values`=null,`max_display_values`=null WHERE `id_project_field` = $id");
    $sth->execute();
    return $sth;
}

public function updateFieldalue($value,$pid,$cid,$node_text,$node_image){
     $sth = $this->db->prepare("UPDATE `data_field_value_new` SET `field_value_data`=:value,`node_text`=:nodeText,`node_image`=:nodeImage WHERE `pro_id` = $pid AND `city_id` = $cid");
	$sth->bindparam(":value", $value);
	$sth->bindparam(":nodeText", $node_text);
	$sth->bindparam(":nodeImage", $node_image);
    $sth->execute();
    return $sth;
}
	public function insertDataGroup($name,$datafields,$added_by,$clients,$datatype,$node_ranking,$invert_node_ranking,$display_map,$proid){
        $sth = $this->db->prepare("INSERT INTO `datagroup`(`name`, `datafields`, `added_by`, `clients`, `datatype`, `node_ranking`, `invert_node_ranking`, `display_map`, `proid`) VALUES ('$name','$datafields','$added_by','$clients','$datatype','$node_ranking','$invert_node_ranking','$display_map','$proid')");
        $ins=$sth->execute();
        return $ins;
    }
	/********************/
}