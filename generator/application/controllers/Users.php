<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users extends MY_Controller{
	public function __construct(){
        parent::__construct();
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->load->model('sr_model');
		$this->lang->load('message','english');
		header('Content-Type: application/json;charset=utf-8');
		header('Access-Control-Allow-Origin: *');
        Header('Access-Control-Allow-Headers: *');
        header('Access-Control-Allow-Methods: GET, POST');
		header("Access-Control-Allow-Headers: X-Requested-With");
		header("Access-Control-Allow-Headers: Cache-Control, Pragma, Origin, Authorization, Content-Type, X-Requested-With");
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
    }
/**
/*@generate
/*@for- API call from frontend
***/	
	public function index_old(){
		 $parameter_url =$_GET['dataSetKey'];
		 $data  = array('parameter_url' => $parameter_url);
		 $dataSetKey = $_GET['dataSetKey'];
		 $client_unique_url = $_GET['client'];
		//GET CLIENT DETAILS
		$clientCheck = $this->sr_model->getsingle('clients',array('unique_url'=>$client_unique_url));
		if(empty($clientCheck)){
			$return=array("status" =>400,'msg'=>'Unavailable or invalid client url!');
			echo json_encode($return);
			exit();
		}
		$clientId=$clientCheck->id;
		//GET PROJECT DETAILS
		$projectDetails = $this->sr_model->GetJoinRecordThree('projects','id_map_template','map_templates','id_map_templates','data_field_value','pro_id','projects','id_project','',"(`projects`.`proKey`='$dataSetKey' OR `projects`.`unique_url`='$dataSetKey') AND `projects`.`id_client`='$clientId'",'','','',1);
		if(empty($projectDetails['result'])){
			$return=array("status" =>400,'msg'=>'Unavailable or invalid key !');
			echo json_encode($return);
			exit();
		}
		
		$projectDetail=$projectDetails['result'];
		$row=(array) $projectDetail[0];
		$clientData=(array) $clientCheck;
		$projectId=$projectDetail[0]->id_project;
		$city_id=$projectDetail[0]->city_id;
		
		//GET DATAFIELDS
	$sequenced_id=$this->sr_model->getFieldIdSequence($projectId,$city_id);
	$datafieldData=$this->sr_model->selectProjecFieldsBySequence($projectId,$sequenced_id);
	$cityIds=$this->sr_model->custom_query("SELECT DISTINCT(`city_id`) as city_id FROM data_field_value WHERE pro_id = ".$projectId."");
	$allCityId = implode(',', array_map(function($obj) { return $obj->city_id; }, $cityIds));

	$all_cityId=($allCityId) ? rtrim($allCityId,',') : $allCityId;
		
		$custom_query="SELECT map_template_regions.name, map_template_regions.fname, map_template_regions.lname, map_template_regions.party, map_template_regions.twitter_handle, map_template_regions.prefix, map_template_regions.email, map_template_regions.profile_url, project_fields.field_name, project_fields.display_name,project_fields.field_type, data_field_value.field_value FROM `data_field_value`,project_fields,map_template_regions WHERE  data_field_value.`pro_id`='".$projectId."' AND map_template_regions.id=data_field_value.city_id AND data_field_value.field_id=project_fields.id_project_field AND data_field_value.city_id IN(".$all_cityId.") ORDER BY `map_template_regions`.`name` ASC";
		
		$nodeDetails=$this->sr_model->custom_query($custom_query);
		$clientlogo  = $clientCheck->logo;
		$clientlogofile = $clientCheck->logofile;
		$kklr = !empty($projectDetail[0]->key_colors) ? count(unserialize($projectDetail[0]->key_colors)) : 0;
		
		// Maindata is main array
		$maindata = array();
		$maindata['key'] = $projectDetail[0]->proKey;
		$key = 'Hl2018@1212';
		$encrypted_id = openssl_encrypt($projectDetail[0]->id_map_templates, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
		$encrypted_id = strtolower(bin2hex($encrypted_id));
		$maindata['topology'] = array(
			"mapTemplatePath" => $projectDetail[0]->mapTemplatePath,
			"id" => $encrypted_id,
			"mapID" => $projectDetail[0]->id_map_templates,
			"name" => $row['map_name'],
			"labelForSingularNode" => $projectDetail[0]->labelForSingularNode,
			"labelForPluralNode" => $projectDetail[0]->labelForPluralNode,
			"labelForNodeSearch" => $projectDetail[0]->labelForNodeSearch
		);
		if ($projectDetail[0]->password == null) {
			$pass = null;
		} else {
			$pass = openssl_decrypt(hex2bin($projectDetail[0]->password), 'AES-128-ECB', 'Hl2018@1212', OPENSSL_RAW_DATA);
			$pass = md5($pass);
		}
		// project status
		$maindata['project_status'] = array(
			"visibility" => ($projectDetail[0]->visibility == 1) ? 'publish' : 'draft',
			"password_protected" => ($projectDetail[0]->password_protected == 1) ? true : false,"password" => ($projectDetail[0]->password_protected == 1) ?  $pass : null,
		);
		$logo = $projectDetail[0]->logo;
		$logoURLprojects = $projectDetail[0]->logourl;
		$maindata['title'] = $projectDetail[0]->title;
		 $baseURL = "https://" . $_SERVER['SERVER_NAME'] ."/uploads/";
		 $baseURL2 = "https://" . $_SERVER['SERVER_NAME'] ."/uploads/";
		if ($logo != null) {
			$maindata['logo'] = $baseURL2 . $logo;
		} else if ($logoURLprojects != null) {
			$maindata['logo'] = $logoURLprojects;
		} else if ($clientlogofile != null) {
			$maindata['logo'] = $baseURL . $clientlogofile;
		} else if ($clientlogo != null) {
			$maindata['logo'] = $clientlogo;
		} else {
			$maindata['logo'] = "";
		}
		$maindata['clientName'] = $clientCheck->name;
		$packageData =$this->sr_model->getsingle('packages', array('id'=> $clientCheck->package));
		$maindata['hideBranding'] = (!empty($packageData) && $packageData->hide_branding == 'yes') ? true : false;
		$maindata['hideNode'] = !empty($projectDetail[0]->hide_node) && ($projectDetail[0]->hide_node == 'yes') ? true  : false;
		$maindata['hideEmptyValOnNode'] = !empty($projectDetail[0]->hide_empty_valu_on_node) && ($projectDetail[0]->hide_empty_valu_on_node == 'yes') ? true  : false;
		$maindata['description'] = $projectDetail[0]->description;
		$maindata['footerContent'] = $projectDetail[0]->footer_content;
		$maindata['nodeDescription'] = $projectDetail[0]->node_description;
		$maindata['printDescription'] = $projectDetail[0]->print_description;
		$maindata['node_intro'] = $projectDetail[0]->node_intro;
		$maindata['dataFieldLabelStyle'] = !empty($projectDetail[0]->datafield_label_style) ? $projectDetail[0]->datafield_label_style : 'Icons';
		$maindata['numberOfKeyColours'] = $kklr;
		if (!empty($projectDetail[0]->key_colors)) {
			$keycolorlist = unserialize($projectDetail[0]->key_colors);
			$x = 0;
			for ($i = 0; $i < 10; $i++) {
				$x++;
				$maindata['keyColour' . $x] = !empty($keycolorlist[$i]) ? $keycolorlist[$i] : '';
			}
		}
		$maindata['embeddedCode'] = NULL;
		$maindata['disabled'] = TRUE;
		$maindata['primaryColour'] = !empty($row['primary_color']) ? $row['primary_color'] : (!empty($clientCheck->primary_color) ? $clientCheck->primary_color : '#000000');
		$maindata['secondaryColour'] = !empty($row['secondary_color']) ? $row['secondary_color'] : (!empty($clientCheck->secondary_color) ? $clientCheck->secondary_color : '#fff');
		$maindata['textColour'] = !empty($row['text_color']) ? $row['text_color'] : (!empty($clientCheck->text_color) ? $clientCheck->text_color : '#fff');
		$maindata['textColour1'] = !empty($row['text_color']) ? $row['text_color'] : (!empty($clientCheck->text_color) ? $clientCheck->text_color : '#fff');
		$maindata['textColour2'] = !empty($row['text_color2']) ? $row['text_color2'] : (!empty($clientCheck->text_color2) ? $clientCheck->text_color2 : '#000000');
		$maindata['textColour3'] = !empty($row['text_color3']) ? $row['text_color3'] : (!empty($clientCheck->text_color3) ? $clientCheck->text_color3 : '#000000');
		$getfontName =$this->sr_model->getsingle('fonts', array('id'=> $projectDetail[0]->font),array('font_family','font_type','importLink'));
		$maindata['fontFamily'] =empty($row['font']) ? array("font_family" => "Roboto") : $getfontName;
		$maindata['projectLink'] = "https://visualisation.polimapper.co.uk/".$projectDetail[0]->unique_url;
		if(!empty($_GET['group'])) {
			$group_url = $_GET['group'];
			$groupData = $this->sr_model->getsingle('projectgroup',array('unique_url'=>$group_url));

			if (!empty($groupData)){
				$maindata['isGroup'] = true;
				$projects = $groupData->projects;
				if (!empty($projects)) {
					$projects = unserialize($projects);
					$k = 0;
					foreach ($projects as $proid) {
						$k++;
						$proKeys = $this->sr_model->getsingle('projects',array('id_project'=>$proid));
						$proKey=!empty($proKeys) ? $proKeys->proKey : '';
						$unique_url=!empty($proKeys) ? $proKeys->unique_url : '';
						$name = !empty($proKeys) ? $proKeys->name : '';
						
						if (!empty($proKey)) {
							if ($unique_url) {
								$arraynew = array('name' => $name, 'url' => 'dataSetKey=' . $unique_url . '&group=' . $group_url.'&client='.$client_unique_url);
							} else {
								$arraynew = array('name' => $name, 'url' => 'dataSetKey=' . $proKey . '&group=' .$group_url.'&client='.$client_unique_url);
							}

							$groupprolinksarray[] = $arraynew;
						}
					}
					$maindata['grouplinks'] = $groupprolinksarray;
				}
			} else {
				$maindata['isGroup'] = false;
			}
		} else {
			$maindata['isGroup'] = false;
		}
		$maindata['emailMP'] = ($row['is_mp'] == 'yes') ? (($clientData['is_mp'] == 'yes') ? true : false)  : false;
		$maindata['emailMPTitle'] = !empty($row['email_sub']) ? $row['email_sub']  : (!empty($clientData['email_sub']) ? $clientData['email_sub'] : '');
		$maindata['emailMPMessage'] = !empty($row['message']) ? $row['message']  : (!empty($clientData['message']) ? $clientData['message'] : '');
		$maindata['socialShare'] = ($row['is_social_share'] == 'yes') ? (($clientData['is_social_share'] == 'yes') ? true : false)  : false;
		$sociallinksarray = array(
			array(
				"name" => "facebook",
				"enable" => ($row['is_facebook'] == 'no') ? false : true,
				"text" => ($row['is_facebook'] == 'no') ? '' : $row['is_facebook']
			),
			array(
				"name" => "Instagram",
				"enable" => false,
				"text" => false,
			),
			array(
				"name" => "Twitter",
				"enable" => ($row['is_twitter'] == 'no') ? false : true,
				"text" => ($row['is_twitter'] == 'no') ? '' : $row['is_twitter']
			),
			array(
				"name" => "LinkedIn",
				"enable" => ($row['is_linkedin'] == 'no') ? false : true,
				"text" => ($row['is_linkedin'] == 'no') ? '' : $row['is_linkedin']
			)
		);
		$maindata['sociallinksarray'] = $sociallinksarray;
		$maindata['emailFriend'] = ($row['is_email_friend'] == 'yes') ? (($clientData['is_email_friend'] == 'yes') ? true : false)  : false;
		$maindata['emailFriendTitle'] = !empty($row['email_friend_title']) ? $row['email_friend_title']  : "";
		$maindata['emailFriendCody'] = !empty($row['email_friend_text']) ? $row['email_friend_text']  : "";
		$maindata['tweetMP'] = ($row['is_tweet_mp'] == 'yes') ? (($clientData['is_tweet_mp'] == 'yes') ? true : false)  : false;
		$maindata['tweetMPText'] = !empty($row['tweet_mp_text']) ? $row['tweet_mp_text']  : "";
		$maindata['pdfDownload'] = !empty($row['is_pdf_download']) ? $row['is_pdf_download']  : "";
		$maindata['imageExport'] = !empty($row['is_image_export']) ? $row['is_image_export']  : "";
		//Template-data
		$template_data = $this->sr_model->getsingle('template',array('id'=>1));
		$templateDATA=(array)$template_data;
		$maindata['cta_text']=$row['cta_text'];
		$maindata['subscribe_mail_text'] = !empty($row['subscribe_mail_text']) ? $row['subscribe_mail_text'] : (!empty($clientData['subscribe_mail_text']) ? $clientData['subscribe_mail_text'] : $templateDATA['subscribe_mail_text']);
		
		$maindata['subscribe_mail_address'] = !empty($row['subscribe_mail_address']) ? $row['subscribe_mail_address'] : (!empty($clientData['subscribe_mail_address']) ? $clientData['subscribe_mail_address'] : $templateDATA['subscribe_mail_address']);
		$maindata['copyright_title'] = !empty($row['copyright_title']) ? $row['copyright_title'] : (!empty($clientData['copyright_title']) ? $clientData['copyright_title'] : $templateDATA['copyright_title']);
		$maindata['copyright_link'] = !empty($row['copyright_link']) ? $row['copyright_link'] : (!empty($clientData['copyright_link']) ? $clientData['copyright_link'] : $templateDATA['copyright_link']);
		$maindata['privacypolicy'] = !empty($row['privacypolicy']) ? $row['privacypolicy'] : (!empty($clientData['privacypolicy']) ? $clientData['privacypolicy'] : $templateDATA['privacypolicy']);
		
		$key_field_color = $row['key_colors'];
		if($key_field_color != null){
            $key_field_color = unserialize($key_field_color);
		}else{
			$key_field_color = [];
		}
		
		// chart
		$chartDataArray = array();
		$chartData = $this->sr_model->getAllwhere('chart_wizard',array('pro_id'=>$row['id_project']),'sequence_no','ASC');
		$key_field_color = $row['key_colors'];
		if($key_field_color != null){
            $key_field_color = unserialize($key_field_color);
		}else{
			$key_field_color = [];
		}
		
		if(!empty($chartData['result'])){
			foreach ($chartData['result'] as $c_dt){
				$pxarray = array();
				$d=(array) $c_dt;
				$fields = unserialize($d['datafields']);
				$field_color = !empty($d['field_color']) ? unserialize($d['field_color']) : array();
				$i = 1;
				foreach ($fields as $key => $f){
					//NOTES- CAN BE MODIFIED 
					$getfieldName = $this->sr_model->getsingle('project_fields',array('id_project_field'=>$f));
					 $fmin = $getfieldName->first_interval;
					 $fmax = $getfieldName->last_interval;
					 $key_colors = $getfieldName->key_colors;
					 $colorArray = !empty($getfieldName->key_colors) ? unserialize($key_colors) : (!empty($clientData['colours']) ? unserialize($clientData['colours']) : array());
					
					 $minMaxSumField = $this->sr_model->getsingle('data_field_value',array('field_id'=>$getfieldName->id_project_field,'pro_id'=>$projectId),"MAX(cast(`field_value` as decimal(12,2))) AS max,MIN(cast(`field_value` as decimal(12,2))) AS min,SUM(cast(`field_value` as unsigned)) AS sum");
					$max=0; $min=0; $sum=0;
					if(!empty($minMaxSumField)){
						$max=$minMaxSumField->max;
						$min=$minMaxSumField->min;
						$sum=$minMaxSumField->sum;
					}
					$px_get_valuess = $this->sr_model->getAllwhere('data_field_value',array('field_id'=>$getfieldName->id_project_field,'pro_id'=>$projectId));
					$px_get_values=$px_get_valuess['result'];
					$pxtotal = 0;
					$total_number_of_nodes = 0;
					$fieldData_s = json_decode($d['field_data']);
					if(isset($fieldData_s->average_without_empty_nodes) && $fieldData_s->average_without_empty_nodes==true){
						foreach($px_get_values as $value){
								if($value->field_value!=''){
									$total_number_of_nodes++;
									$pxtotal +=  (float)$value->field_value;
								}
						}
						}else{
							foreach($px_get_values as $value){
								$total_number_of_nodes++;
								$pxtotal +=  (float)$value->field_value;
							}	
						}
					$nationalaverage = $total_number_of_nodes;
					$totalValueSum=!empty($sum) ? $sum : 0;
					$min=($fmin == null) ? $min : $fmin;
					$max=($fmax == null) ? $max : $fmax;
					$maxConstant=$max;
					$minConstant=$min;
					$total_colors = count($colorArray);
					if (!empty($fmax) && !empty($fmin)) {
						if ($total_colors != 0) {
							$newCount = $total_colors - 2;
							$keyInterval = ($max - $min) / $newCount;
							$keyInterval = round($keyInterval, 2);
							$fmaxNew = $max;
						} else {
							$keyInterval = NULL;
						}
					} else{

						if ($total_colors != 0) {
							$keyInterval = ($max - $min) / $total_colors;
							$keyInterval = round($keyInterval, 2);
						} else {
							$keyInterval = NULL;
						}
					}
				$newinterval = is_nan($pxtotal / $nationalaverage) ? 0 : $pxtotal / $nationalaverage;
				if(empty($getfieldName->display_name) || $getfieldName->display_name == "") {
						$getfieldName->display_name = $getfieldName->field_name;
					}
				$key_colors = $getfieldName->key_colors;
				if (!empty($key_colors)) {
						$colorArray = unserialize($key_colors);
					} else {
						if (!empty($row['key_colors'])) {
							$colorArray = unserialize($row['key_colors']);
						} else {
							if (!empty($clientData['colours'])) {
								$colorArray = unserialize($clientData['colours']);
							} else {
								$colorArray = array();
							}
						}
					}
			$new = array(
						"name" => $getfieldName->display_name,
						"label" => $getfieldName->display_name,
						"field_color" => isset($field_color[$key]) ? $field_color[$key] : (isset($key_field_color[$key]) ? $key_field_color[$key] : '#000000'),
						"columnIndex" =>	$i++,
						"maxValue" => $maxConstant,
						"minValue" => $minConstant,
						"average" => round($newinterval, 2),
						"totalValue" => round($pxtotal, 2),
						"maxColor" => $colorArray[0],
						"minColor" => $colorArray[2],
						"avgColor" => $colorArray[1]
					);
					if($new){ $pxarray[] = $new;}
				}
				
				
				$chartarray = array(
				"chart_name" => $d['name'],
				"display_name" => ucwords(!empty($d['display_name']) ? $d['display_name']  :$d['name']),
				"x_axis_title" => $d['x_axis'],
				"y_axis_title" => $d['y_axis'],
				"graph_type" => !empty($d['graph_type']) ? $d['graph_type']  : null,
				"graph_for" => !empty($d['graph_for']) ? $d['graph_for']  : null,
				"hide_average" => !empty($d['hide_average']) && ($d['hide_average'] == 'yes') ? true  : false,
				"average_color" => isset($d['average_color']) ? $d['average_color'] : '#000000', 
				"map_width" => !empty($d['map_width']) ? $d['map_width']  : null,
				"columns" => !empty($pxarray) ? $pxarray : null
			);
			if ($chartarray['columns']) {
				array_push($chartDataArray, $chartarray);
			}
			}
		}			
		$maindata['chartWizard'] = $chartDataArray;
		$datafieldarray = array();
		$arrayOfDF = array();
		$count = 0;
		$min = 0;
		$max = 0;
		$keyInterval = 0;
		/******************/
		foreach ($datafieldData as $p_data_fields) {
			$d=(array)$p_data_fields;
			$id_project_field = $d['id_project_field'];
			$keyColors = array();
			/*************KEY-COLOR**********/
            $constant_fmin = $d['first_interval'];
            $fmin = $d['first_interval'];
			$fmax = $d['last_interval'];
            if(!empty($fmax) && empty($fmin)){
                $fmin = '0';
                $constant_fmin = '0';
            }
			$id_field = $d['id_project_field'];
			$key_colors = $d['key_colors'];
			if (!empty($key_colors)) {
				$colorArray = unserialize($key_colors);
			} else {
				if (!empty($row['key_colors'])) {
					$colorArray = unserialize($row['key_colors']);
				} else {
					if (!empty($clientData['colours'])) {
						$colorArray = unserialize($clientData['colours']);
					} else {
						$colorArray = array();
					}
				}
			}
			
			$minMaxSumField = $this->sr_model->getsingle('data_field_value',array('field_id'=>$id_field,'pro_id'=>$projectId),"MAX(cast(`field_value` as decimal(12,2))) AS max,MIN(cast(`field_value` as decimal(12,2))) AS min,SUM(cast(`field_value` as unsigned)) AS sum");
					$max=0; $min=0; $sum=0;
					if(!empty($minMaxSumField)){
						$max=$minMaxSumField->max;
						$min=$minMaxSumField->min;
						$sum=$minMaxSumField->sum;
					}
					$px_get_valuess = $this->sr_model->getAllwhere('data_field_value',array('field_id'=>$id_field,'pro_id'=>$projectId));
					$px_get_values=$px_get_valuess['result'];
            
			$pxtotal = 0;
			$total_number_of_nodes = 0;
			$fieldData_s = json_decode($d['field_data']);
			if(isset($fieldData_s->average_without_empty_nodes) && $fieldData_s->average_without_empty_nodes==true){
				foreach($px_get_values as $value){
						if($value->field_value!=''){
							$total_number_of_nodes++;
							$pxtotal +=  (float)$value->field_value;
						}
				}
			}else{
				foreach($px_get_values as $value){
					$total_number_of_nodes++;
					$pxtotal +=  (float)$value->field_value;
				}	
			}
             
			$nationalaverage = $total_number_of_nodes;
			$totalValueSum=!empty($sum) ? $sum : 0;
			$min=($fmin == null) ? $min : $fmin;
			$max=($fmax == null) ? $max : $fmax;
			$maxConstant=$max;
			$minConstant=$min;
			$total_colors = count($colorArray);
			
			if($fmax != null && $fmin != null){
				if ($total_colors != 0) {
					$newCount = $total_colors - 1;
					$keyInterval = ($max - $min) / $newCount;
					$keyInterval = round($keyInterval, 2);
					$fmaxNew = $max;
				} else {
					$keyInterval = NULL;
				}
			}else if($fmax != null && $fmin == null){
			if ($total_colors != 0) {
				$newCount = $total_colors - 1;
				$keyInterval = ($max - $min) / $newCount;
				$keyInterval = round($keyInterval, 2);
				$fmaxNew = $max;
			} else {
				$keyInterval = NULL;
			}

		  }else {
				if ($total_colors != 0) {
					$keyInterval = ($max - $min) / $total_colors;
					$keyInterval = round($keyInterval, 2);
				} else {
					$keyInterval = NULL;
				}
			}
			$keyClr = array();

	if (!empty($colorArray)) {
				$i = 0;
				$p = 0;
				$min_key_values = $d['min_key_values'] ? unserialize($d['min_key_values']) : null;
				$max_key_values = $d['max_key_values'] ? unserialize($d['max_key_values']) : null;
				$max_display_values = $d['max_display_values'] ? unserialize($d['max_display_values']) : null;
				$min_display_values = $d['min_display_values'] ? unserialize($d['min_display_values']) : null;

                $UniqueArray = array();
                if($d['field_type'] == 'Text'){
                    foreach($px_get_values as $dfv){
                        if ($dfv->field_value && $dfv->field_value != null) {
                            $trimval = trim($dfv->field_value);
                            if(!in_array($trimval, $UniqueArray)){
                             array_push($UniqueArray, $trimval);
                             }
                            }
                         }
                         $UniqueArray = array_unique($UniqueArray);
                         if($max_key_values && count($max_key_values)>0){
                             $UniqueArray = $max_key_values;
                         }
                         $counting = 1;
                         foreach($UniqueArray as $key => $value){
                             if($counting <=10){
                            $keyClr['keyColor'] = isset($colorArray[$key])? $colorArray[$key] : '#000000';
				    	    $keyClr['minKeyValue'] = null;
                            $keyClr['MaxKeyValue'] = $UniqueArray[$key];
                            $keyClr['MinDisplayKey'] =null;
                            $keyClr['MaxDisplayKey'] = isset($max_display_values[$key]) ? $max_display_values[$key] : $UniqueArray[$key];
					    	$keyColors[] = $keyClr;
                            $counting++;
                        }
                         }
                }else{
					
					if($d['key_value_option'] == 'Equal Count'){ 
						$count = 0;
						$from = 0;
						$to = round($total_number_of_nodes/count($colorArray));
						$devide = round($total_number_of_nodes/count($colorArray));
						$px = $this->sr_model->getEqualCountvalueswithIgnore($id_field);
						$newCOUNT =  count($px);
						$color_count = count($colorArray);
						$NEW_devide = round($newCOUNT / $color_count);
						$fff = 0;
						$fff_1 = 0;
						$NEW_devide_1 = round($newCOUNT / $color_count);
						
						foreach ($colorArray as $key => $color) {
							$E_Arr = $this->sr_model->getEqualCountvaluesV2($id_field,$fff_1, $NEW_devide_1);
							$E_Arr = array_map(function($obj) {
								return $obj->value;
								}, $E_Arr);
								if ($key == ($color_count - 2)) {
									$fff_1 = $fff_1 + $NEW_devide_1;
									$NEW_devide_1 = $NEW_devide_1 + ($newCOUNT - ($NEW_devide_1 * $color_count));
								} else {
									$fff_1 = $fff_1 + $NEW_devide_1;
								}
								
						if(!empty($E_Arr)){
							$keyClr['keyColor'] = $color;
							$keyClr['minKeyValue'] = min($E_Arr);
							$keyClr['MaxKeyValue'] = max($E_Arr);
                            $keyClr['MinDisplayKey'] = isset($min_display_values[$key]) ? $min_display_values[$key] : min($E_Arr);
                            $keyClr['MaxDisplayKey'] = isset($max_display_values[$key]) ? $max_display_values[$key] : max($E_Arr);
						}

							$keyColors[] = $keyClr;
							$from = $from + $devide;
							$to = $to + $devide;
							
						}
                      
					}else{
						if($d['key_value_option'] == 'Equal Ranges'){
							$min_key_values = null;
							$max_key_values = null;
						}
			
				foreach ($colorArray as $keyNo => $clr) {
					$p++;
					$keyClr['keyColor'] = $clr;
					$maxNew  = $max - $keyInterval;
					
						if($min_key_values != null && $max_key_values != null && count($max_key_values) > 0 && count($min_key_values) > 0){
						       if($keyNo === 0){
								$keyClr['MinDisplayKey'] = (isset($min_display_values[$keyNo]) ? $min_display_values[$keyNo] :(($min_key_values[$keyNo] == null || $min_key_values[$keyNo] == 'null') ? $maxNew : $min_key_values[$keyNo])) . ($d['show_last_key'] == 'Yes' ? '': '+');
								$keyClr['minKeyValue'] = (($min_key_values[$keyNo] == null || $min_key_values[$keyNo] == 'null') ? $maxNew : $min_key_values[$keyNo]) . ($d['show_last_key'] == 'Yes' ? '': '+');
								if($d['show_last_key'] == 'Yes'){
				    	        	$keyClr['MaxKeyValue'] = $max_key_values[$keyNo];
									$keyClr['MaxDisplayKey'] = isset($max_display_values[$keyNo]) ? $max_display_values[$keyNo] : $max_key_values[$keyNo];
								}
				    	    }else{
				    	         $keyClr['minKeyValue'] = $min_key_values[$keyNo];
						         $keyClr['MaxKeyValue'] = $max_key_values[$keyNo];
								 $keyClr['MinDisplayKey'] = isset($min_display_values[$keyNo]) ? $min_display_values[$keyNo] : $min_key_values[$keyNo];
								 $keyClr['MaxDisplayKey'] = isset($max_display_values[$keyNo]) ? $max_display_values[$keyNo] : $max_key_values[$keyNo];

				    	    }
				    	    	$keyColors[] = $keyClr;
						}else{
						    
					if ($p == $total_colors) {

					if($fmin != null){
                            $fm = $fmin + $keyInterval;
                            $keyClr['minKeyValue'] = $constant_fmin;
							$keyClr['MaxKeyValue'] = number_format(($fm), 2);
							$keyClr['MinDisplayKey'] = isset($min_display_values[$keyNo]) ? $min_display_values[$keyNo] :number_format(($constant_fmin), 2);
							$keyClr['MaxDisplayKey'] = isset($max_display_values[$keyNo]) ? $max_display_values[$keyNo] : number_format(($fm), 2);
                    }else{
            		$keyClr['minKeyValue'] = number_format(($min), 2);
					$keyClr['MaxKeyValue'] = number_format(($max), 2);
					$keyClr['MinDisplayKey'] = isset($min_display_values[$keyNo]) ? $min_display_values[$keyNo] :number_format(($min), 2);
					$keyClr['min_dis_key2'] = number_format(($min), 2);
					$keyClr['MaxDisplayKey'] = isset($max_display_values[$keyNo]) ? $max_display_values[$keyNo] :number_format(($max), 2);
                    }
					} else if ($p == 1) {
							if($fmax != null){
							$fmax = $fmax ? $fmax : $max - $avg;
							$keyClr['minKeyValue'] = number_format(($fmax), 2) . ($d['show_last_key'] == 'Yes' ? '': '+');
							$keyClr['MinDisplayKey'] = (isset($min_display_values[$keyNo]) ? $min_display_values[$keyNo] : number_format(($fmax), 2)) . ($d['show_last_key'] == 'Yes' ? '': '+');
						} else {
							$maxNew = $maxNew ? $maxNew : $max - $avg;
							$keyClr['minKeyValue'] = number_format(($maxNew), 2) . ($d['show_last_key'] == 'Yes' ? '': '+');
							$keyClr['MinDisplayKey'] = (isset($min_display_values[$keyNo]) ? $min_display_values[$keyNo] : number_format(($maxNew), 2)) . ($d['show_last_key'] == 'Yes' ? '': '+');
						}

						if($d['show_last_key'] == 'Yes'){
							$keyClr['MaxKeyValue'] = number_format(($max), 2);
							$keyClr['MaxDisplayKey'] = isset($max_display_values[$keyNo]) ? $max_display_values[$keyNo] : number_format(($max), 2);
						}

					} else {
                            if($fmax != null && $fmin != null){
							$fminNew = $fmaxNew - $keyInterval;
							$keyClr['minKeyValue'] = number_format(($fminNew), 2);
							$keyClr['MaxKeyValue'] = number_format(($fmaxNew), 2);
							$keyClr['MinDisplayKey'] = isset($min_display_values[$keyNo]) ? $min_display_values[$keyNo] : number_format(($fminNew), 2);
							$keyClr['MaxDisplayKey'] = isset($max_display_values[$keyNo]) ? $max_display_values[$keyNo] : number_format(($fmaxNew), 2);
							$fmaxNew = $fmaxNew - $keyInterval;
						} else {
							$keyClr['minKeyValue'] = number_format(($maxNew), 2);
							$keyClr['MaxKeyValue'] = number_format(($max), 2);
							$keyClr['MinDisplayKey'] = isset($min_display_values[$keyNo]) ? $min_display_values[$keyNo] : number_format(($maxNew), 2);
							$keyClr['MaxDisplayKey'] = isset($max_display_values[$keyNo]) ? $max_display_values[$keyNo] : number_format(($max), 2);
						}
					}
					$max = $max - $keyInterval;
					
					if($keyClr['minKeyValue'] != null){
					    	$keyColors[] = $keyClr;
					}
						}
				}
            }
		}
			}
			
			/************************/
			$fieldData = json_decode($d['field_data']);
		
			$new_arr3 = array();
			if (empty($d['display_name']) || $d['display_name'] == ""){
				$d['display_name'] = $d['field_name'];
			}

			$mydfarr =  $d['field_name'];

			$new_arr2 = array(
				"name" => $d['display_name'],
				"unique_name" => $d['field_name'],
				"icon" => "icon-sort-time-asc",
				"label" => $d['display_name'],
				"columnIndex" => 0,
				"averageOverride" => $fieldData->averageOverride ? $fieldData->averageOverride : false,
				"displayRankings" => $fieldData->displayRankings ? true : false,
				"invertRankings" => $fieldData->invertRankings ? true : false,
				"maxValue" => $maxConstant,
				"minValue" => $minConstant,
				"average" =>  is_nan($pxtotal / $nationalaverage) ? 0 : $pxtotal / $nationalaverage,
				"totalValue" => $pxtotal
			);
		
			$new_arr = array(
				"name" => $d['display_name'],
				"unique_name" => $d['field_name'],
				"type" => $d['field_type'],
				"hide_node" => isset($d['hide_node']) && $d['hide_node'] == 'yes' ? true : false,
				"hide_empty_valu_on_node" => isset($d['hide_empty_valu_on_node']) && $d['hide_empty_valu_on_node'] == 'yes' ? true : false,
				"description" => $d['description'],
				"groupingMethod" => $fieldData->groupingMethod,
				"comparable" => $fieldData->comparable,
				"defaultComparable" => false,
				"isMultivalued" => false,
				"fieldIndex" =>  $count,
				"link_text"=>$fieldData->link_text,
				"map_areas_border_colour"=>$fieldData->map_areas_border_colour,
				"includeAverageInNodeGraphs" => $fieldData->includeAverageInNodeGraphs,
				"averageOverride" => $fieldData->averageOverride,
				"isGroup" => !empty($d['isGroup']) ? true  : false,
				"sequence_no" => $d['sequence_no'],
				"parentId" => $d['parentId'],
				"columns" => [$new_arr2],
				"maxValue" => $maxConstant,
				"minValue" => $minConstant,
				"average" => is_nan($pxtotal / $nationalaverage) ? 0 : $pxtotal / $nationalaverage,
				"totalValue" => $pxtotal,
				'rangeType' => $d['key_value_option'],
				'show_last_key' => ($d['show_last_key']== 'Yes' ? true: false),
				"keyColors" => $keyColors,
			);

			array_push($new_arr2, $new_arr3);
			array_push($datafieldarray, $new_arr);
			array_push($arrayOfDF, $mydfarr);
			$count++;
		}
		/******************/
		$row['id_map_template'];
		$maindata['dataFieldsArray'] = $arrayOfDF;
		$maindata['dataFields'] = $datafieldarray;
		$datafieldcount = $this->sr_model->getAllwhere('data_field_value',array('pro_id'=>$projectId),'','',"DISTINCT(data_field_value.field_id)");
		$fieldDataarr = array();
		$nodesarray = array();
		$node_double = array();
		$itr = 0;
		$dfieldcount=$datafieldcount['total_count'];
		
		
		if(!empty($nodeDetails)){
			$i = 0;
			foreach ($nodeDetails as $nds) { $itr++;
				$nd=(array) $nds;
				$i++;
				if (strlen($nd['field_value']) > 0 && strlen(trim($nd['field_value'])) == 0){
					$nd['field_value'] = null;
				}
				if ($nd['field_value'] == '' || $nd['field_value'] == " ") {
					$nd['field_value'] = null;
				}
				
				if($nd['field_type'] != 'Text' && $nd['field_value'] != null){
					$nd['field_value'] = str_replace(",","",$nd['field_value']);
				}
				if (empty($nd['display_name']) || $nd['display_name'] == "") {
					$nd['display_name'] = $nd['field_name'];
				}
				$fieldDataarr[$nd['display_name']] = array($nd['display_name'] => $nd['field_value']);

				if ($i == $dfieldcount){
					if ($row['id_map_template'] == 8) {
						$mparray = array("fname" => $nd['fname'], "lname" => $nd['lname'], "party" => $nd['party'], "twitter_handle" => $nd['twitter_handle'], 'prefix' => $nd['prefix'], 'email' => $nd['email'], 'profile_url' => $nd['profile_url']);
					} else {
						$mparray = null;
					}
					$node_arr = array(
						"name" => $nd['name'],
						"mpdetails" => !empty($mparray) ? $mparray  : null,
						"data" => $fieldDataarr
					);
					
					if (!in_array($node_arr, $nodesarray)){
						$nodesarray[] = $node_arr;
					}else{
						$node_double[]=$node_arr;
					}
					$i = 0;
					$mparray = array();
				}
			}
		}
		$maindata['nodes'] = $nodesarray;
		$json_string = json_encode($maindata, JSON_INVALID_UTF8_IGNORE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
		echo $json_string;
	}
/****************************************/
/************OLD-ONE***************/
/***************************************/
	public function index(){
	     $parameter_url =$this->uri->segment(1);
	 	 $data  = array('parameter_url' => $parameter_url);
		$this->load->view('index',$data);
	}
/****************************************/
/************INDEX-LIVE***************/
/***************************************/
	public function index_live(){
		$dataSetKey=$_GET['dataSetKey'];
	     $projectDetails = $this->sr_model->getsingle('projects',"proKey='$dataSetKey' OR unique_url='$dataSetKey'");
	 	 $data  = array('parameter_url' => $projectDetails->proKey);
		$this->load->view('index_live',$data);
	}	
/****************************************/
}