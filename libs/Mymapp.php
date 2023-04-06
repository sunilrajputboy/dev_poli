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


class Mymapp extends Model
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
    private $select_option_colfield = '<b>FIELD</b>';
    /** @var string $select_option_colfield_empty */
    private $select_option_colfield_empty = 'empty';
    /** @var string $select_option_field */
    private $select_option_field = 'Please select the right Data FIeld';
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
        $table = '<table class="table table-hover table-striped table-import">';
        $table.= '<thead><tr>';
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
                        $table.='<th scope="row" >'.$tr[$thk].'</th>';
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
        $selector_html = '<select class="select-css form-control" name="mapping['.$key.']">';
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
}