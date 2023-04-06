<?php
class packages_model extends Model
{
	public function getPackages(){
        $sth = $this->db->prepare('SELECT * FROM `packages` ORDER BY `sequence_no`');
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getClientBypackageId($packageId){
        $sth = $this->db->prepare('SELECT * FROM `clients` where package=:packageId');
        $sth->bindparam(":packageId", $packageId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getUserDetailsById($userId){
        $sth = $this->db->prepare('SELECT * FROM `users` where id=:userId');
        $sth->bindparam(":userId", $userId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function deletePackageById($packageId){
        $sth = $this->db->prepare('DELETE FROM `packages` WHERE `id` = :packageId');
        $sth->bindparam(":packageId", $packageId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function hidePackageById($packageId){
        $sth = $this->db->prepare("UPDATE `packages` SET `visibility`= '0' WHERE `id` = :packageId");
        $sth->bindparam(":packageId", $packageId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function showPackageById($packageId){
        $sth = $this->db->prepare("UPDATE `packages` SET `visibility`= '1' WHERE `id` = :packageId");
        $sth->bindparam(":packageId", $packageId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getPackagesById($packageId){
        $sth = $this->db->prepare('SELECT * FROM `packages` WHERE `id` = :packageId  ORDER BY `sequence_no`');
		$sth->bindparam(":packageId", $packageId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getMapTemplates(){
        $sth = $this->db->prepare('SELECT * FROM `map_templates` WHERE `hidden`=0');
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getMapTemplatesByCategory($category_id){
        $sth = $this->db->prepare('SELECT * FROM `map_templates` WHERE `category_id`= :catId AND `hidden`=0');
		$sth->bindparam(":catId", $category_id);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }	
	public function getMapTemplateCategory(){
        $sth = $this->db->prepare('SELECT * FROM `map_category` WHERE `status`=0');
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	
	public function dowithselected($packageId,$tablename,$status){
		if($status=='show'){
			$sth = $this->db->prepare("UPDATE ".$tablename." SET `visibility`= '1' WHERE `id` = :packageId");
		}else if($status=='hide'){
			$sth = $this->db->prepare("UPDATE ".$tablename." SET `visibility`= '0' WHERE `id` = :packageId");
		}else if($status=='delete'){
			if($tablename=='projects'){
				$sth = $this->db->prepare("DELETE `projects`, `project_fields`, `data_field_value` FROM `projects` LEFT join project_fields on projects.id_project = project_fields.id_project LEFT join data_field_value on projects.id_project = data_field_value.pro_id WHERE projects.id_project=:packageId");
			}else{
				$sth = $this->db->prepare("DELETE FROM ".$tablename." WHERE `id` = :packageId");
			}
			
		}else if($status=='suspend'){
			if($tablename=='users'){
				$sth = $this->db->prepare("UPDATE ".$tablename." SET `suspended`= '1' WHERE `id` = :packageId");
			}else{
				$sth = $this->db->prepare("UPDATE ".$tablename." SET `is_suspended`= '1' WHERE `id` = :packageId");
			}
		}else if($status=='active'){
			if($tablename=='users'){
				$sth = $this->db->prepare("UPDATE ".$tablename." SET `suspended`= '0' WHERE `id` = :packageId");
			}else{
				$sth = $this->db->prepare("UPDATE ".$tablename." SET `is_suspended`= '0' WHERE `id` = :packageId");
			}
		}else if($status=='draft'){
			$sth = $this->db->prepare("UPDATE ".$tablename." SET `visibility`= '0' WHERE `id_project` = :packageId");
		}else if($status=='publish'){
			$sth = $this->db->prepare("UPDATE ".$tablename." SET `visibility`= '1' WHERE `id_project` = :packageId");	
		}else{
			
		}
		$sth->bindparam(":packageId", $packageId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	
	public function insertPackage($pname,$no_allowed_user,$no_allowed_projects,$no_map_string,$is_logo,$is_charts,$is_fonts,$is_email_mp,$is_social_share,$is_email_share,$is_tweet_mp,$hide_branding){
        $sth = $this->db->prepare("INSERT INTO `packages`(`name`, `no_allowed_user`, `no_allowed_projects`, `no_allowed_maps`, `is_logo`, `is_charts`, `is_fonts`, `email_mp`,`is_email_share`,`is_social_share`,`is_tweet_mp`,`hide_branding`) VALUES (:pname,'$no_allowed_user','$no_allowed_projects','$no_map_string','$is_logo','$is_charts','$is_fonts','$is_email_mp','$is_email_share','$is_social_share','$is_tweet_mp','$hide_branding')");
        $sth->bindparam(":pname", $pname);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
	
	public function updatePackage($packageId,$pname,$no_allowed_user,$no_allowed_projects,$no_map_string,$is_logo,$is_charts,$is_fonts,$is_email_mp,$is_social_share,$is_email_share,$is_tweet_mp,$hide_branding){
        $sth = $this->db->prepare("UPDATE `packages` SET `name`=:pname,`no_allowed_user`='$no_allowed_user',`no_allowed_projects`='$no_allowed_projects',`no_allowed_maps`='$no_map_string',`is_logo`='$is_logo',`is_charts`='$is_charts',`is_fonts`='$is_fonts',`email_mp`='$is_email_mp',`is_social_share`='$is_social_share',`is_email_share`='$is_email_share',`is_tweet_mp`='$is_tweet_mp',`hide_branding`='$hide_branding' WHERE `id` = :packageId");
        $sth->bindparam(":packageId", $packageId);
        $sth->bindparam(":pname", $pname);
        $updt=$sth->execute();
        return $updt;
    }
	
	public function saveshorting($packageId,$tablename,$sequenceNo){
		if($tablename=='projects'){
			$sth = $this->db->prepare("UPDATE ".$tablename." SET `sequence_no`= '$sequenceNo' WHERE `id_project` = :packageId");
        }else if($tablename=='project_fields'){
            $sth = $this->db->prepare("UPDATE ".$tablename." SET `sequence_no`= '$sequenceNo' WHERE `id_project_field` = :packageId");
        }else{
			$sth = $this->db->prepare("UPDATE ".$tablename." SET `sequence_no`= '$sequenceNo' WHERE `id` = :packageId");
		}
		$sth->bindparam(":packageId", $packageId);
        $return=$sth->execute();
        return $return;
    }
	
}