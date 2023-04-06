<?php
error_reporting(1);
header('Content-Type: application/json;charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Headers: Cache-Control, Pragma, Origin, Authorization, Content-Type, X-Requested-With");
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
if ((isset($_GET['dataSetKey']) && !empty($_GET['dataSetKey'])) && (isset($_GET['client']) && !empty($_GET['client']) && $_GET['client'] != 'false') || !empty($parameter_url) || isset($_GET['group'])) {
	class Srclasss
	{
		private function dbConnect()
		{
 			$conn = new mysqli('localhost', 'visualisationpol_stage', 'visualisationpol_stage', 'visualisationpol_stage');
			//$conn = new mysqli('localhost', 'visualisationpol_root', 'P0lliM@pper', 'visualisationpol_polimapper');
			
			if (!$conn) {
				die("Connection failed: " . mysqli_connect_error());
			}
			return $conn;
		}

		public  function selectTwoTableData($data = "*", $table1, $table2, $on, $condition = "", $urlcondition = "",$clientidCondition = "", $order_cloumn = "", $asc_decs = "", $ofset = "", $limit = "")
		{
			$connection = $this->dbConnect();
			$query = "SELECT " . $data . " FROM " . $table1 . " LEFT JOIN " . $table2 . " ON " . $on;
			if ($condition != "") {
				$query .= " WHERE " . $condition . " OR " . $urlcondition .' AND '. $clientidCondition;
			}
			if ($order_cloumn != "" && $asc_decs != "") {
				$query .= " ORDER BY " . $order_cloumn . " " . $asc_decs;
			}
			if ($ofset != "" && $limit != "") {
				$query .= " LIMIT " . $ofset . "," . $limit;
			}
			$result = $connection->query($query);
			$rowss = $result->fetch_assoc();
			return $rowss;
		}

		public function selectThreeTableData($data = "*", $table1, $table2, $table3, $on, $on3, $condition = "", $order_cloumn = "", $asc_decs = "", $ofset = "", $limit = "")
		{

			$connection = $this->dbConnect();
			$query = "SELECT " . $data . " FROM " . $table1 . " LEFT JOIN " . $table2 . " ON " . $on . " LEFT JOIN " . $table3 . " ON " . $on3;
			if ($condition != "") {
				$query .= " WHERE " . $condition;
			}
			if ($order_cloumn != "" && $asc_decs != "") {
				$query .= " ORDER BY " . $order_cloumn . " " . $asc_decs;
			}
			if ($ofset != "" && $limit != "") {
				$query .= " LIMIT " . $ofset . "," . $limit;
			}
			$result = $connection->query($query);
			return $result;
		}

		public  function selectsingleTableDatabyid($id)
		{
			$connection = $this->dbConnect();
			$query = "SELECT * FROM `project_fields` WHERE `id_project` = $id ORDER BY `sequence_no`";
			$result = $connection->query($query);
			return $result;
		}
		public function selectTemplateDATA()
		{
			$connection = $this->dbConnect();
			$query = "SELECT * FROM `template` WHERE `id` = 1";
			$result = $connection->query($query);
			$rowss = $result->fetch_assoc();
			return $rowss;
		}
		public  function selectsingleTableDatabyuniqueurl($unique_url)
		{

			$connection = $this->dbConnect();
			$query = "SELECT * FROM `projectgroup` WHERE `unique_url` = '$unique_url'";
			$result = $connection->query($query);
			return $result;
		}


		public   function findcountrydata($id)
		{
			$connection = $this->dbConnect();
			$query = "SELECT * FROM `map_template_regions` WHERE `id_map_template` = $id";
			$result = $connection->query($query);
			return $result;
		}

		public   function getfieldNamebyid($id)
		{
			$connection = $this->dbConnect();
			$query = "SELECT * FROM `project_fields` WHERE `id_project_field` = $id";
			$result = $connection->query($query);
			return $result;
		}

		public   function getdatafieldwithoutgroup($proid)
		{
			$connection = $this->dbConnect();
			$query = "SELECT * FROM `project_fields` WHERE `id_project` = $proid AND `isGroup` = '0'";
			$result = $connection->query($query);
			return $result;
		}

		public   function datafieldvaluedata($proid)
		{
			$connection = $this->dbConnect();
			$queryNodes = "SELECT* FROM `data_field_value` INNER JOIN `map_template_regions` ON data_field_value.city_id = map_template_regions.id WHERE data_field_value.pro_id = $proid";
			$result = $connection->query($queryNodes);
			return $result;
		}

		public  function selectsingleClientbyid($id)
		{
			$connection = $this->dbConnect();
			$query = "SELECT * FROM `clients` WHERE `id` = $id";
			$result = $connection->query($query);
			$rowss = $result->fetch_assoc();
			return $rowss;
		}
		
			public  function selectClientbyURL($url)
		{
			$connection = $this->dbConnect();
			$query = "SELECT * FROM `clients` WHERE `unique_url` = '$url'";
			$result = $connection->query($query);
			$rowss = $result->fetch_assoc();
			return $rowss;
		}
		
		public  function getBrandingInfoBypackage($packageId)
		{
			$connection = $this->dbConnect();
			$query = "SELECT * FROM `packages` WHERE `id` = $packageId";
			$result = $connection->query($query);
			$rowss = $result->fetch_assoc();
			return $rowss;
		}
		
		public  function getProkeybyid($id)
		{
			$connection = $this->dbConnect();
			$query = "SELECT `proKey`, `name`,`unique_url` FROM `projects` WHERE `id_project` = $id";
			$result = $connection->query($query);
			$rowss = $result->fetch_assoc();
			return $rowss;
		}
		public  function getfontName($id)
		{
			$connection = $this->dbConnect();
			$query = "SELECT `font_family`,`font_type`,`importLink` FROM `fonts` WHERE `id` = $id";
			$result = $connection->query($query);
			$rowss = $result->fetch_assoc();
			return $rowss;
		}

		public  function getNodeDetails($project_id)
		{
			$connection = $this->dbConnect();
			$query = "SELECT map_template_regions.name, map_template_regions.fname, map_template_regions.lname, map_template_regions.party, map_template_regions.twitter_handle, map_template_regions.prefix, map_template_regions.email, map_template_regions.profile_url, project_fields.field_name, project_fields.display_name,project_fields.field_type, data_field_value.field_value FROM `data_field_value`,project_fields,map_template_regions WHERE  data_field_value.`pro_id`='" . $project_id . "' AND map_template_regions.id=data_field_value.city_id AND data_field_value.field_id=project_fields.id_project_field AND project_fields.isGroup=0 AND data_field_value.city_id IN(SELECT DISTINCT(`city_id`) FROM `data_field_value` WHERE `pro_id`='$project_id') ORDER BY `map_template_regions`.`name` ASC";
			$result = $connection->query($query);
			return $result;
		}

		public  function getmaxFieldValue($id_field, $pro_id)
		{
			$connection = $this->dbConnect();
			$query = "SELECT MAX(cast(`field_value` as decimal(12,2))) AS 'max' FROM `data_field_value` WHERE `field_id` = $id_field AND pro_id='$pro_id'";
			$result = $connection->query($query);
			$rowss = $result->fetch_assoc();
			return $rowss;
		}
		public  function getMinFieldValue($id_field, $pro_id)
		{
			$connection = $this->dbConnect();
			$query = "SELECT MIN(cast(`field_value` as decimal(12,2))) AS 'min' FROM `data_field_value` WHERE `field_id` = $id_field AND pro_id='$pro_id'";
			$result = $connection->query($query);
			$rowss = $result->fetch_assoc();
			return $rowss;
		}
		public function getSumFieldValue($id_field, $pro_id)
		{
			$connection = $this->dbConnect();
			$query = "SELECT SUM(cast(`field_value` as unsigned)) AS 'sum' FROM `data_field_value` WHERE `field_id` = $id_field AND pro_id='$pro_id'";
			$result = $connection->query($query);
			$rowss = $result->fetch_assoc();
			return $rowss;
		}
		public function getFieldValue($id_field, $pro_id)
		{
			$connection = $this->dbConnect();
			$query = "SELECT `field_value` FROM `data_field_value` WHERE `field_id` = '$id_field' AND pro_id='$pro_id'";
			$result = $connection->query($query);
			$rowss = $result->fetch_all();
			return $rowss;
		}

		public function getCountFieldValue($id_field, $pro_id)
		{
			$connection = $this->dbConnect();
			$query = "SELECT COUNT(`field_value`) as 'count' FROM `data_field_value` WHERE `field_id` = $id_field AND pro_id='$pro_id'";
			$result = $connection->query($query);
			$rowss = $result->fetch_assoc();
			return $rowss;
		}

		public function getEqualCountvalues($id, $from, $to){
			$connection = $this->dbConnect();
			$query = "SELECT cast(`field_value` as decimal(12,2)) as 'value' FROM `data_field_value` WHERE `field_id` =$id LIMIT $from, $to";
			$result = $connection->query($query);
			$rowss = $result->fetch_all();
			return $rowss;
		}

		
		public function getEqualCountvalueswithIgnore($id){
			$connection = $this->dbConnect();
			$query = "SELECT cast(`field_value` as decimal(12,2)) as 'value' FROM `data_field_value` WHERE `field_value` != '' AND  `field_id` =$id";
			$result = $connection->query($query);
			$rowss = $result->fetch_all();
			return $rowss;
		}

		public function getEqualCountvaluesV2($id, $from, $to){
			$connection = $this->dbConnect();
			$query = "SELECT cast(`field_value` as decimal(12,2)) as 'value' FROM `data_field_value` WHERE `field_value` != '' AND `field_id` =$id ORDER BY cast(`field_value` as decimal(12,2)) DESC LIMIT $from,$to";
			$result = $connection->query($query);
			$rowss = $result->fetch_all();
			return $rowss;
		}
		
		public  function getchartWizard($pro_id)
		{
			$connection = $this->dbConnect();
			$query = "SELECT * FROM `chart_wizard` WHERE `pro_id` = $pro_id ORDER BY `sequence_no`";
			$result = $connection->query($query);
			return $result;
		}
		public function convert_from_latin1_to_utf8_recursively($dat)
	   {
		  if (is_string($dat)) {
			 return utf8_encode($dat);
		  } elseif (is_array($dat)) {
			 $ret = [];
			 foreach ($dat as $i => $d) $ret[ $i ] = self::convert_from_latin1_to_utf8_recursively($d);

			 return $ret;
		  } elseif (is_object($dat)) {
			 foreach ($dat as $i => $d) $dat->$i = self::convert_from_latin1_to_utf8_recursively($d);

			 return $dat;
		  } else {
			 return $dat;
		  }
	   }
		
	}
	/*************/
	$srObject = new Srclasss();
	$dataSetKey = $_GET['dataSetKey'];
	if (!empty($parameter_url)) {
		$dataSetKey = $parameter_url;
	}
	$client_unique_url = $_GET['client'];
	$uniqueClient = $srObject->selectClientbyURL($client_unique_url);
	if(!empty($uniqueClient)){
	$cid = $uniqueClient['id'];
	$prdtk = $srObject->selectTwoTableData('projects.*,map_templates.*', 'projects', 'map_templates', 'projects.id_map_template=map_templates.id_map_templates', "projects.proKey='" . $dataSetKey . "'", "projects.unique_url='" . $dataSetKey . "'","projects.id_client=" . $cid . "");
	
	$client_unique_url = $_GET['client'];
	$clientCheck = $srObject->selectClientbyURL($client_unique_url);
	$row = $prdtk;
	// if (!empty($row)) {
	   	if (!empty($row) && !empty($clientCheck)) {
		$maindata = array();
		$datafieldData = $srObject->selectsingleTableDatabyid($row['id_project']);
		//pr($datafieldData->fetch_all(MYSQLI_ASSOC));
		$countryData = $srObject->findcountrydata($row['id_map_template']);
		$clientData = $srObject->selectsingleClientbyid($row['id_client']);
		$nodeDetails = $srObject->getNodeDetails($row['id_project']);
		
		$clientlogo = null;
		$clientlogofile = null;
		if (!empty($clientData)) {
			$clientlogo  = $clientData['logo'];
			$clientlogofile = $clientData['logofile'];
		}
		$kklr = !empty($row['key_colors']) ? count(unserialize($row['key_colors'])) : 0;
		$maindata['key'] = $row['proKey'];
			
		$key = 'Hl2018@1212';
		$encrypted_id = openssl_encrypt($row['id_map_templates'], 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
		$encrypted_id = strtolower(bin2hex($encrypted_id));
		$maindata['topology'] = array(
			"mapTemplatePath" => $row['mapTemplatePath'],
			"id" => $encrypted_id,
			"name" => $row['map_name'],
			"labelForSingularNode" => $row['labelForSingularNode'],
			"labelForPluralNode" => $row['labelForPluralNode'],
			"labelForNodeSearch" => $row['labelForNodeSearch']
		);

		if ($row['password'] == null) {
			$pass = null;
		} else {
			$pass = openssl_decrypt(hex2bin($row['password']), 'AES-128-ECB', 'Hl2018@1212', OPENSSL_RAW_DATA);
			$pass = md5($pass);
		}
		// 	project status
		$maindata['project_status'] = array(
			"visibility" => ($row['visibility'] == 1) ? 'publish' : 'draft',
			"password_protected" => ($row['password_protected'] == 1) ? true : false,
			"password" => ($row['password_protected'] == 1) ?  $pass : null,
		);

		$logo = $row['logo'];
		$logoURLprojects = $row['logourl'];
		$maindata['title'] = $row['title'];
		 $baseURL = "https://visualisation.polimapper.co.uk/uploads/";
		 $baseURL2 = "https://visualisation.polimapper.co.uk/uploads/";
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
		
		$packageData = $srObject->getBrandingInfoBypackage($clientData['package']);
		$maindata['clientName'] = $clientData['name'];
		$maindata['hideBranding'] = ($packageData && $packageData['hide_branding'] == 'yes') ? true : false;
		$maindata['hideNode'] = !empty($row['hide_node']) && ($row['hide_node'] == 'yes') ? true  : false;
		$maindata['description'] = $row['description'];
		$maindata['footerContent'] = $row['footer_content'];
		$maindata['nodeDescription'] = $row['node_description'];
		$maindata['printDescription'] = $row['print_description'];
			$maindata['node_intro'] = $row['node_intro'];
		$maindata['dataFieldLabelStyle'] = !empty($row['datafield_label_style']) ? $row['datafield_label_style'] : 'Icons';
		$maindata['numberOfKeyColours'] = $kklr;
		if (!empty($row['key_colors'])) {
			$keycolorlist = unserialize($row['key_colors']);
			$x = 0;
			for ($i = 0; $i < 10; $i++) {
				$x++;
				$maindata['keyColour' . $x] = !empty($keycolorlist[$i]) ? $keycolorlist[$i] : '';
			}
		}
		$maindata['embeddedCode'] = NULL;
		$maindata['disabled'] = TRUE;
		$maindata['primaryColour'] = !empty($row['primary_color']) ? $row['primary_color'] : (!empty($clientData['primary_color']) ? $clientData['primary_color'] : '#000000');
		$maindata['secondaryColour'] = !empty($row['secondary_color']) ? $row['secondary_color'] : (!empty($clientData['secondary_color']) ? $clientData['secondary_color'] : '#fff');
		$maindata['textColour'] = !empty($row['text_color']) ? $row['text_color'] : (!empty($clientData['text_color']) ? $clientData['text_color'] : '#fff');
		$maindata['textColour1'] = !empty($row['text_color']) ? $row['text_color'] : (!empty($clientData['text_color']) ? $clientData['text_color'] : '#fff');
		$maindata['textColour2'] = !empty($row['text_color2']) ? $row['text_color2'] : (!empty($clientData['text_color2']) ? $clientData['text_color2'] : '#000000');
		$maindata['textColour3'] = !empty($row['text_color3']) ? $row['text_color3'] : (!empty($clientData['text_color3']) ? $clientData['text_color3'] : '#000000');

		$maindata['fontFamily'] = empty($row['font']) ? array("font_family" => "Roboto") : $srObject->getfontName($row['font']);
		 $maindata['projectLink'] = "https://visualisation.polimapper.co.uk/" . $row['unique_url'];

		if (!empty($_GET['group'])) {
			$group_url = $_GET['group'];
			$groupData = $srObject->selectsingleTableDatabyuniqueurl($group_url);

			if ($groupData->num_rows != 0) {
				$maindata['isGroup'] = true;

				foreach ($groupData as $groupdatapro) {
					$projects = $groupdatapro['projects'];
				}
				if (!empty($projects)) {
					$projects = unserialize($projects);
					$k = 0;
					foreach ($projects as $proid) {
						$k++;
						$proKey = $srObject->getProkeybyid($proid)['proKey'];
						$unique_url = $srObject->getProkeybyid($proid)['unique_url'];
						$name = $srObject->getProkeybyid($proid)['name'];
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

		$count = 0;
		$noOfItems = 4;
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


		$templateDATA = $srObject->selectTemplateDATA();
		$maindata['subscribe_mail_text'] = !empty($row['subscribe_mail_text']) ? $row['subscribe_mail_text'] : (!empty($clientData['subscribe_mail_text']) ? $clientData['subscribe_mail_text'] : $templateDATA['subscribe_mail_text']);
		
		$maindata['subscribe_mail_address'] = !empty($row['subscribe_mail_address']) ? $row['subscribe_mail_address'] : (!empty($clientData['subscribe_mail_address']) ? $clientData['subscribe_mail_address'] : $templateDATA['subscribe_mail_address']);
		$maindata['copyright_title'] = !empty($row['copyright_title']) ? $row['copyright_title'] : (!empty($clientData['copyright_title']) ? $clientData['copyright_title'] : $templateDATA['copyright_title']);
		$maindata['copyright_link'] = !empty($row['copyright_link']) ? $row['copyright_link'] : (!empty($clientData['copyright_link']) ? $clientData['copyright_link'] : $templateDATA['copyright_link']);
		$maindata['privacypolicy'] = !empty($row['privacypolicy']) ? $row['privacypolicy'] : (!empty($clientData['privacypolicy']) ? $clientData['privacypolicy'] : $templateDATA['privacypolicy']);

		// chart 
		$chartDataArray = array();
		$chartData = $srObject->getchartWizard($row['id_project']);

		$key_field_color = $row['key_colors'];
		if($key_field_color != null){
            $key_field_color = unserialize($key_field_color);
		}else{
			$key_field_color = [];
		}

		foreach ($chartData as $d) {

			$pxarray = array();
			$fields = unserialize($d['datafields']);

			$field_color = $d['field_color'];
			if($field_color != null){
				$field_color = unserialize($field_color);
			}else{
				$field_color = [];
			}

			$i = 1;
			foreach ($fields as $key => $f) {

				$getfieldNamebyid = $srObject->getfieldNamebyid($f);
				foreach ($getfieldNamebyid as $p) {

					$fmin = $p['first_interval'];
					$fmax = $p['last_interval'];
					// 
					$keyColors = array();
					// /*************KEY-COLOR**********
					$key_colors = $p['key_colors'];
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

					$dataMax = $srObject->getmaxFieldValue($p['id_project_field'], $row['id_project']);
					$dataMin = $srObject->getMinFieldValue($p['id_project_field'], $row['id_project']);
					$datasum = $srObject->getSumFieldValue($p['id_project_field'], $row['id_project']);
					$px_get_values = $srObject->getFieldValue($p['id_project_field'], $row['id_project']);

					$pxtotal = 0;
					foreach($px_get_values as $value){
						$pxtotal +=  (float)$value[0];
					}
					$datacount = $srObject->getCountFieldValue($p['id_project_field'], $row['id_project']);
					$nationalaverage = $datacount['count'];
					$max = $dataMax['max'];
					if (!empty($datasum['sum'])) {
						$totalValueSum = $datasum['sum'];
					} else {
						$totalValueSum = 0;
					}
					if (empty($fmin)) {
						$min = $dataMin['min'];
					} else {
						$min = $fmin;
					}
					if (empty($fmax)) {
						$max = $dataMax['max'];
					} else {
						$max = $fmax;
					}
					$maxConstant = $max;
					$minConstant = $min;
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
					} else {

						if ($total_colors != 0) {
							$keyInterval = ($max - $min) / $total_colors;
							$keyInterval = round($keyInterval, 2);
						} else {
							$keyInterval = NULL;
						}
					}

					$newinterval = is_nan($pxtotal / $nationalaverage) ? 0 : $pxtotal / $nationalaverage;
					if (empty($p['display_name']) || $p['display_name'] == "") {
						$p['display_name'] = $p['field_name'];
					}
					$key_colors = $p['key_colors'];
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
						"name" => $p['display_name'],
						"label" => $p['display_name'],
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
				}
				if ($new) {
					$pxarray[] = $new;
				}
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
		$maindata['chartWizard'] = $chartDataArray;
		// chart 

		$datafieldarray = array();
		$arrayOfDF = array();
		$count = 0;
		$min = 0;
		$max = 0;
		$keyInterval = 0;
		foreach ($datafieldData as $d) {
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
			$dataMax = $srObject->getmaxFieldValue($id_field, $row['id_project']);
			$dataMin = $srObject->getMinFieldValue($id_field, $row['id_project']);
			$datasum = $srObject->getSumFieldValue($id_field, $row['id_project']);
			$px_get_values = $srObject->getFieldValue($id_field, $row['id_project']);
          
			$pxtotal = 0;
			foreach($px_get_values as $value){
				$pxtotal +=  (float)$value[0];
			}

			$datacount = $srObject->getCountFieldValue($id_field, $row['id_project']);
			$nationalaverage = $datacount['count'];
			$max = $dataMax['max'];
			if (!empty($datasum['sum'])) {
				$totalValueSum = $datasum['sum'];
			} else {
				$totalValueSum = 0;
			}
			if ($fmin == null) {
				$min = $dataMin['min'];
			} else {
				$min = $fmin;
			}
			if ($fmax == null) {
				$max = $dataMax['max'];
			} else {
				$max = $fmax;
			}
			$maxConstant = $max;
			$minConstant = $min;
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
			} 
		 else if($fmax != null && $fmin == null){
			if ($total_colors != 0) {
				$newCount = $total_colors - 1;
				$keyInterval = ($max - $min) / $newCount;
				$keyInterval = round($keyInterval, 2);
				$fmaxNew = $max;
			} else {
				$keyInterval = NULL;
			}

		 }
			else {
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
                        if ($dfv[0] && $dfv[0] != null) {
                            $trimval = trim($dfv[0]);
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
						$to = round($datacount['count']/count($colorArray));
						$devide = round($datacount['count']/count($colorArray));
						$px = $srObject->getEqualCountvalueswithIgnore($id_field);
						$newCOUNT =  count($px);
						$color_count = count($colorArray);
						$NEW_devide = round($newCOUNT / $color_count);
						$fff = 0;
						$fff_1 = 0;
						$NEW_devide_1 = round($newCOUNT / $color_count);
						foreach ($colorArray as $key => $color) {
							$E_Arr = $srObject->getEqualCountvaluesV2($id_field,$fff_1, $NEW_devide_1);
							$E_Arr = array_column($E_Arr, '0');
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
				// 		if (!empty($fmax)) {
				// 		    if($fmin > 0){
				// 		        $keyClr['minKeyValue'] = '0';
				// 			$keyClr['MaxKeyValue'] =  number_format(($fmin), 2);
				// 		    }else{
				// 		          $keyClr['minKeyValue'] = null;
				// 			$keyClr['MaxKeyValue'] = null;
				// 		    }
							
				// 		} else {
				// 			$keyClr['minKeyValue'] = number_format(($min), 2);
				// 			$keyClr['MaxKeyValue'] = number_format(($max), 2);
				// 		}
					if($fmin != null){

            				// $keyClr['minKeyValue'] = '0';
							// $keyClr['MaxKeyValue'] = number_format(($fmin), 2);
							// $keyClr['MinDisplayKey'] = '0';
							// $keyClr['MaxDisplayKey'] = isset($max_display_values[$keyNo]) ? $max_display_values[$keyNo] : number_format(($fmin), 2);
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
						// if (!empty($fmax) && !empty($fmin)) {
                            if($fmax != null && $fmin != null){
							$fminNew = $fmaxNew - $keyInterval;
							// if ($p == $total_colors - 1) {
							// 	$fminNew = $fmin;
							// }
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
			if (empty($d['display_name']) || $d['display_name'] == "") {
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
				"description" => $d['description'],
				"groupingMethod" => $fieldData->groupingMethod,
				"comparable" => $fieldData->comparable,
				"defaultComparable" => false,
				"isMultivalued" => false,
				"fieldIndex" =>  $count,
				//   "graphType" => $fieldData->graphType,
				"includeAverageInNodeGraphs" => $fieldData->includeAverageInNodeGraphs,
				//   "showAverageInDataSetSummary" => $fieldData->showAverageInDataSetSummary,
				//   "showTotalInDataSetSummary" => $fieldData->showTotalInDataSetSummary,
				//   "excludeMinFromDataSetSummaryGraph" => $fieldData->excludeMinFromDataSetSummaryGraph,
				//   "excludeMaxFromDataSetSummaryGraph" => $fieldData->excludeMaxFromDataSetSummaryGraph,
				//   "excludeAverageFromDataSetSummaryGraph" => $fieldData->excludeAverageFromDataSetSummaryGraph,
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
				"keyColors" => $keyColors
			);

			array_push($new_arr2, $new_arr3);
			array_push($datafieldarray, $new_arr);
			array_push($arrayOfDF, $mydfarr);
			$count++;
		}
		
		$row['id_map_template'];
		$maindata['dataFieldsArray'] = $arrayOfDF;
		$maindata['dataFields'] = $datafieldarray;
		$datafieldValueData = $srObject->datafieldvaluedata($row['id_project']);
		$dfieldcount = $srObject->getdatafieldwithoutgroup($row['id_project'])->num_rows;
		$fieldDataarr = array();
		$nodesarray = array();
		if (!empty($nodeDetails)) {
			$i = 0;
			foreach ($nodeDetails as $nd) {
				
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

				if ($i == $dfieldcount) {
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
					
					if (!in_array($node_arr, $nodesarray)) {
						$nodesarray[] = $node_arr;
					}
					$i = 0;
					$mparray = array();
				}
			}
		}
		$maindata['nodes'] = $nodesarray;
		$json_string = json_encode($maindata, JSON_INVALID_UTF8_IGNORE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
		echo $json_string;
	} else {
	    if(empty($row)){
	        	echo json_encode(array("status" => 400, 'msg'=> 'Unavailable or invalid key !'));
	    }else{
	        	echo json_encode(array("status" => 400, 'msg'=> 'Unavailable or invalid client url !'));
	    }
	}
}else{
	echo json_encode(array("status" => 400, 'msg'=> 'Unavailable or invalid client url !'));
}
} else {
    if(isset($_GET['dataSetKey'])){
        	echo json_encode(array("status" => 400, 'msg'=> 'Unavailable or invalid client url !'));
    }else{
       	echo json_encode(array("status" => 400,'msg'=> 'Unavailable or invalid key !')); 
    }
}
