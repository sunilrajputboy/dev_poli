<?php
/*
  	@project    CSV Visual Mapping  
  	@author     Gianluca Di Battista
  	@copyright  Webmio.it
	@year 		2020
  	@version    1.0.0
  	@file  		Mapp.php
  	@site		https://www.csvxlsvisualmapping.com/
*/

use PhpOffice\PhpSpreadsheet\IOFactory;


class Mapp extends Model
{
    /** @var $header | bool */
    private $header;
    /** @var string $csv_tmp */
    private $csv_tmp = "";
    /** @var string $csv_file_name */
    private $csv_file_name = "";
    /** @var string $file_extension */
    private $file_extension = "";
	/** @var $csv_data | array */
    private $csv_data;
    /** @var array $select_options */
    private $select_options = [];
    /** @var string $select_option_colfield */
    private $select_option_colfield = 'Field';
    /** @var string $select_option_colfield_empty */
    private $select_option_colfield_empty = 'empty';
    /** @var string $select_option_field */
    private $select_option_field = 'select...';
    private $select_option_field2 = 'Select data field';
    private $mapping_id = null;
     /**
     * setIncludeHeader
     * @param $bool
     */
    public function setIncludeHeader($bool)
    {
        $this->header = $bool;
    }
    /**
     * SET
     * @param $options
     */
    public function setSelectOptions($options)
    {
        $this->select_options = $options;
    }
    /**
     * SET
     * @param $ext
     */
    public function setFileExtension($ext)
    {
        $this->file_extension = $ext;
    }
    /**
     * SET
     * @param $table
     */
    public function setSelectOptionsTable($table)
    {
        $this->select_option_table = $table;
    }
    /**
     * SET
     * @param $limit
     */
    public function setLimitRow($limit)
    {
        $this->setLimit = $limit;
    }
    /**
     * SET
     * @param $id
     */
    public function setMapId($id)
    {
        $this->mapping_id = $id;
    }
    /**
     * SET
     * @param $name
     */
    public function setCsvFileName($name)
    {
        $this->csv_file_name = $name;
    }
    /**
     * @param $csv_file
     * @throws Exception
     */
    public function setCSVdata($csv_file)
    {
        if($csv_file == '' && empty($csv_file))
        {
            throw new Exception("Missing File");
        }
        $this->csv_tmp = $csv_file;
        try {
            $reader = IOFactory::createReader($this->file_extension);
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($csv_file);
            $this->csv_data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        }
        catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e)
        {
            throw new Exception($e->getMessage());
        }
        catch (\PhpOffice\PhpSpreadsheet\Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
    /**
     * buildTable
     * @return string
     */
    public function buildTable()
    {

        $csv = $this->csv_data;

        $headers = [];
        if(isset($csv[1]))
        {
            foreach ($csv[1] as $k => $v)
            {
                $headers[$k] = ($this->header) ? $v : '';
            }
        }

        if($this->header)
        {
            unset($csv[1]);
        }

        $y = self::userSettingsDecode();
        $table = '<table class="table table-striped table-import">';
        $table.= '<thead><tr>';
		$table.= '<th>Row Labels</th>';
		$number_of_column=count($headers)-1;
		if($number_of_column>0){
        $table.= '<th colspan="'.$number_of_column.'">Column Labels</th>';
		}
		$table.='</tr><tr>';
            foreach ($headers as $hk => $hv)
            {
                $table.= '<th scope="col" data-coll="'.$hv.'" >';
                $clm2 = ($hv && $hv!='') ? $hv : $this->select_option_colfield_empty;
                $clm = ($this->header) ? $this->select_option_colfield. ':<br> '.$clm2: '';
                $table.= '<span class="colfield">'.$clm.'</span>';
                $table.= $this->selector($hk, $y);
                $table.= '</th>';
             }
        $table.= '</tr></thead>';
        $table.='<tbody>';
            foreach ($csv as $tr)
            {
                $table.='<tr>';
                    foreach ($headers as $thk => $thv)
                    {
                        $table.='<td scope="row" style="min-width:150px;">'.$tr[$thk].'</td>';
                    }
                $table.='</tr>';
            }
        $table.='</tbody>';
        $table.= '</table>';
        return $table;
    }
    /**
     * Build selector
     * @param $key
     * @param $userSettings
     * @return string
     */
    private function selector($key, $userSettings)
    {
        $options_avbs = $this->getSelectOptionFields();
        $options = [];
        if($options_avbs)
        {
            $options_except =
            [
                'id', 'importUniquid', 'importData'
            ];
            foreach ($options_avbs as $options_avb)
            {
                $Field = $options_avb["Field"];
                if(!in_array($Field, $options_except))
                    $options[] = $Field;
            }
        }
        $selector_html = '<select class="select-css" name="mapping['.$key.']">';
        $selector_html .= '<option value="">'.$this->select_option_field.'</option>';
        if(isset($options))
        {
            foreach ($options as $option)
            {
                $selected = (isset($userSettings[$key]) && $userSettings[$key] == $option) ? 'selected':'';
                $selector_html.='<option value="'.$option.'" '.$selected.'>'.$option.'</option>';
            }
        }
        $selector_html.= '</select>';
        return $selector_html;
    }
    /**
     * @return array
     */
    private function userSettingsDecode()
    {
        if($this->mapping_id != '')
        {
            $sth = $this->db->prepare('SELECT * FROM `mapping` where id_mapping=:id_mapping');
            $sth->bindparam(":id_mapping", $this->mapping_id);
            $sth->execute();
            $map = $sth->fetch();
            $map_query = ($map["map_query"] != '') ? $map["map_query"] : '';
        }else{
            $map_query = "";
        }
        $headers = [];
        $map_query_rows = explode('~', $map_query);
        if(isset($map_query_rows))
        {
            foreach ($map_query_rows as $map_query_row)
            {
                $map_query_line = explode('|', $map_query_row);
                $headers[$map_query_line[0]] = @$map_query_line[1];
            }
        }
        return $headers;
    }
    /**
     * Total CSV
     * @param $y
     * @return int
     */
    public function count()
    {
        $i = 0;
        $csv = $this->csv_data;
        if($this->header == 1)
        {
            unset($csv[1]);
        }
        foreach ($csv as $x)
        {
            $i++;
        }
        return $i;
    }

    /**
     * GET
     * @return string
     */
    public function getCsvFileName()
    {
        return $this->csv_file_name;
    }
    /**
     * @return mixed
     */
    public function getCsvData()
    {
        $csv = $this->csv_data;
        if($this->header == 1)
        {
            unset($csv[1]);
        }
        return $csv;
    }
    /**
     * GET
     * @return string
     */
    public function getCsvTmpFile()
    {
        return $this->csv_tmp;
    }
    /**
     * @return array
     */
    public function getSelectOptionFields()
    {
        if($this->select_option_table) {
            $sth = $this->db->prepare("SHOW COLUMNS FROM `{$this->select_option_table}`;");
            $sth->execute();
            return $sth->fetchAll();
        }
        return [];
    }
	
/******************************/
/* OUR CUSTOM CODE ***/
/******************************/
	private function selector2($key, $userSettings,$project_id)
    {
		$options_avbs = $this->getSelectOptionFields2($project_id);
		$nodesarray[]=$maindata1;
		$nodesarray2 = array();
		$nodeData = array();
		$fieldDataarr = array();
		$fieldDatnamevalue = array();
			foreach($options_avbs as $c){
			 $datafieldValueData=$this->datafieldvaluedata($project_id);
				  $fieldDataarr[]= $c['name'];
			}
        $selector_html = '<select class="select-css" name="mapping['.$key.']">';
        $selector_html .= '<option value="">'.$this->select_option_field2.'</option>';
        if(isset($nodesarray))
        {
            foreach ($fieldDataarr as $option)
            {
                $selected = (isset($userSettings[$key]) && $userSettings[$key] == $option) ? 'selected':'';
				
                $selector_html.='<option '.$userSettings[$key].' value="'.$option.'" '.$selected.'>'.$option.'</option>';
            }
        }
        $selector_html.= '</select>';
        return $selector_html;
    }
/*************************************************/
/** SHOW IMPORTED CSV IN PROPER FORMATE
/** FUNCTION NAME- buildTable2
/** @PARAMETER- project_id (Numeric)
/*************************************************/
	public function buildTable2($project_id=""){
		error_reporting(1);
        $csv = $this->csv_data;
        $headers = [];
		$codelist=array_column($csv,'A');
		$codelist_without=array_splice($codelist,0,1);
		$codelist_without_header=$codelist;
		$codelist_without_header=array_filter($codelist_without_header,'strlen');
		$unavailable_namelist=$this->getRegionByNameArray($codelist_without_header,$project_id);
		
        if(isset($csv[1]))
        {
            foreach ($csv[1] as $k => $v)
            {
                $headers[$k] = ($this->header) ? $v : '';
            }
        }
        if($this->header)
        {
            unset($csv[1]);
        }

        $y = self::userSettingsDecode();
		
		$number_of_column=count($headers)-1;
		if($number_of_column==0){
        $number_of_column=1;
		}
		$table='<div class="tbl-header">';
		$table.='<table class="table table-striped"><thead><tr><th>Row Labels</th><th colspan="'.$number_of_column.'">Column Labels</th></tr></thead></table>';
        $table.= '<table class="table table-striped table-import">';
        $table.= '<thead><tr>';
		    $i=0;
			$total_nodes=0;
			$getproject_fields=$this->getfieldNamebyid($project_id);
			$similar_df=array();
            foreach ($headers as $hk => $hv)
            {
				$hv=str_replace(array("\r\n", "\n\r", "\n", "\r"), ',', $hv);
				$selected_node="";
                $table.= '<th scope="col" data-coll="'.$hv.'" >';
                $clm2 = ($hv && $hv!='') ? $hv : $this->select_option_colfield_empty;
                $clm = ($this->header) ? $this->select_option_colfield. ':<br> '.$clm2: '';
                $table.= '<span class="colfield">'.$clm2.'</span>';
				if($i!=0){
					$total_nodes++;
				if(in_array($hv,$similar_df)){
				$selector_html = '
				<select class="select-css" data-pos="'.$i.'" onchange="putdatavalue(\''.$hv.'\','.$i.')" id="df_title_'.$i.'" name="mapping[\''.$hv.$i.'\']">';	
				}else{
				$similar_df[]=$hv;	
				$selector_html = '
				<select class="select-css" data-pos="'.$i.'" onchange="putdatavalue(\''.$hv.'\','.$i.')" id="df_title_'.$i.'" name="mapping[\''.$hv.'\']">';
				}
                $selector_html .= '<option value="">'.$this->select_option_field2.'</option>';
				$p=0;
				
				$sessval=isset($_SESSION['data-key-session']) ? $_SESSION['data-key-session'][$hv] : null;
				$sessval2=isset($_SESSION['ignored_DF']) ? $_SESSION['ignored_DF'] : array();
				$s_n="";
				if(in_array($i,$sessval2)){ $s_n="selected"; }
				
		if(!empty($getproject_fields)){
			foreach($getproject_fields as $flds){
			if($hv==$flds['field_name']){
				$selected_node="selected";
			}else if($flds['field_name']== $sessval){
				$selected_node="selected";
				}
			else{
				$selected_node="";
			}
			if($flds['isGroup']==0){
			$selector_html.='<option dv="'.$sessval.'" sq="'.$i.'" value="'.$flds['field_name'].'" '.$selected_node.' >'.$flds['field_name'].'</option>';
			}
			}
		   }
		   
			$selector_html.='<optgroup label="-">';
			$selector_html.='<option value="add_new">Add New Data field</option>';
			$selector_html.='<option value="edit_datafield">Edit Data field</option>';
			$selector_html.='<option '.$s_n.' value="Ignore">Ignore</option>';
			$selector_html.='</optgroup>';
				$selector_html.= '</select>';	
                $table.= $selector_html;
				}
                $table.= '</th>';
				$i++;
             }
			 
        $table.= '</tr></thead></table></div>';
        $table.='<div class="tbl-content"><table class="table table-striped table-import"><tbody>';
		$all_regions=$this->getSelectOptionFields2($project_id);
		
		$all_regions_names = array_column($all_regions, 'name');
		$all_regions_id = array_column($all_regions, 'id');
        $total_number_of_regions=count($all_regions);    
			$mncnt=0;
			$rgn_avail=array();
			$selected_region_list=array();
			$right_region_id=array();
			$selected_region_htm="";
			$options="";
				$options.='<optgroup label="-">';
				$options.='<option value="0">Ignore</option>';
				$options.='</optgroup>';
			if(!empty($unavailable_namelist)){
					foreach($unavailable_namelist as $n_list){
						$n_list=array_filter($n_list,'strlen');
						if(!empty($n_list['name'])){
						$options.='<option value="'.$n_list['id'].'">'.$n_list['name'].'</option>';
						}
					}
					
				}

			$mncnt=0;
			$tnor=$total_number_of_regions;
			$j=1;
			$array_duplicate=array();
			$lp_cntr=0;
			foreach ($csv as $tr)
            {
                
			//	if(!empty($tr['A']) && $j<=count($all_regions)){
				if(!empty($tr['A']) ){
				$j++;
                $table.='<tr>';
				$cntry=0;
				$cntry1=0;
				$pos=0;
				   $ndIgnSESS=isset($_SESSION['ignored_ND']) ? $_SESSION['ignored_ND'] : null;
				    
                    foreach ($headers as $thk => $thv){
						$excel_column_value=str_replace("'","",$tr[$thk]);
					if($cntry==0 && in_array(strtolower(trim($excel_column_value)), array_map('strtolower', $all_regions_names))){
						$lp_cntr++;
						$key = array_search (strtolower(trim($excel_column_value)), array_map('strtolower', $all_regions_names));
						$notval=$excel_column_value;
						$table.='<td scope="row" >
						<div class="hide">
						<select class="select-css1" id="ndsCounter-'.$lp_cntr.'" name="node_regions[\''.$all_regions_id[$key].'\']">
						<option value="'.$all_regions_id[$key].'" selected>'.$notval.'</option>
						</select>
						</div>'.$notval.' </td>';
					}else if($cntry==0 && !in_array(strtolower(trim($excel_column_value)), array_map('strtolower', $all_regions_names))) {
						$lp_cntr++;
						$tnor++;
						$notval="";
						$notval = '<select class="select-css1" id="ndsCounter-'.$lp_cntr.'" name="node_regions[\''.$tnor.'\']">';
						$notval .= '<option value="">'.$excel_column_value.' can\'t be found please select from the list</option>'.$options;
						$notval .='</select>';
						$table.='<td scope="row" class="errorfield" style="background:#e6133d66;">'.$notval.' </th>';
						
						if(in_array($tnor,array('1774','1730','2191','2190','2188','2189','2187'))){
						$array_duplicate[]=$excel_column_value;
						}
					}else{
						$table.='<td scope="row" >
							<div class="hide">
							<input type="hidden" name="field_value[]" value="'.$excel_column_value.'">
							</div>'.$excel_column_value.' </td>';	
							if($pos==($total_nodes-1)){$pos=0; }
							$pos++;
					};
						$cntry++;
						$cntry1++;
					}
                $table.='</tr>'; $mncnt++;
			}
            }
        $table.='</tbody>';
        $table.= '</table></div>';
        return $table;
    }
	
    public function getSelectOptionFields2($project_id)
    {
		$sth = $this->db->prepare('SELECT * FROM `projects` where id_project=:project');
        $sth->bindparam(":project", $project_id);
        $sth->execute();
        $project_details=$sth->fetchAll();
		$id_map_template=$project_details[0]['id_map_template'];
		$sth2 = $this->db->prepare("SELECT * FROM `map_template_regions` where id_map_template=:idmaptemplate AND name!=''");
		$sth2->bindparam(":idmaptemplate", $id_map_template);
		$sth2->execute();
		$return=$sth2->fetchAll(PDO::FETCH_ASSOC);
		return $return;
    }
	
   public function datafieldvaluedata($proid) {
		$sth = $this->db->prepare("SELECT* FROM `data_field_value` INNER JOIN `map_template_regions` ON data_field_value.city_id = map_template_regions.id WHERE data_field_value.pro_id = :proid");
		$sth->bindparam(":proid", $proid);
		$sth->execute();
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}
	
	
   function getfieldNamebyid($id) {
		$sth = $this->db->prepare('SELECT * FROM `project_fields` where id_project=:project ORDER BY `field_name` ASC');
		$sth->bindparam(":project", $id);
		$sth->execute();
		$project_details=$sth->fetchAll(PDO::FETCH_ASSOC);
		return $project_details;
   }	
   function getRegionByName($project_id) {
	    $sth = $this->db->prepare('SELECT * FROM `projects` where id_project=:project');
        $sth->bindparam(":project", $project_id);
        $sth->execute();
        $project_details=$sth->fetchAll();
		$id_map_template=$project_details[0]['id_map_template']; 
		$sth2 = $this->db->prepare("SELECT * FROM `map_template_regions` where id_map_template=:mtid AND name!=''");
		$sth2->bindparam(":mtid", $id_map_template);
		$sth2->execute(); 
		$region_details=$sth2->fetchAll(PDO::FETCH_ASSOC);
		return $region_details;
   }
   
   function getRegionByIds($region_id,$project_id) {
		$sth = $this->db->prepare('SELECT * FROM `projects` where id_project=:project');
        $sth->bindparam(":project", $project_id);
        $sth->execute();
        $project_details=$sth->fetchAll();
		$id_map_template=$project_details[0]['id_map_template']; 
	    $allids=implode(',',$region_id);
		$sth2 = $this->db->prepare('SELECT * FROM `map_template_regions` where id NOT IN(:region_ids) AND id_map_template=:mtid');
		$sth2->bindparam(":region_ids", $allids);
		$sth2->bindparam(":mtid", $id_map_template);
		$sth2->execute();
		$region_details=$sth2->fetchAll(PDO::FETCH_ASSOC);
		return $region_details;
   }
   
   function getRegionByNameArray($region_names,$project_id) {
	    $sth = $this->db->prepare('SELECT * FROM `projects` where id_project=:project');
        $sth->bindparam(":project", $project_id);
        $sth->execute();
        $project_details=$sth->fetchAll();
		$id_map_template=$project_details[0]['id_map_template'];
		$region_names=str_replace(',',"",$region_names);
		$region_names=str_replace("'","",$region_names);
		$allnames = "'".implode("','",$region_names)."'";
		$sth2 = $this->db->prepare("SELECT * FROM `map_template_regions` where `name` NOT IN($allnames) AND id_map_template=$id_map_template ORDER BY name ASC");
		$sth2->execute();
		//$region_details=$sth2->debugDumpParams();
		$region_details=$sth2->fetchAll(PDO::FETCH_ASSOC);

		return $region_details;
   }
   
   public function pr($passed_array){
	   echo '<pre>'; print_r($passed_array); echo '</pre>'; die();
   }
  

}