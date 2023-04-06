<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sr_model extends CI_Model {
	
/*************************CheckUser*******************************/
public function get_row($table_name,$condition)
{
   $q = $this->db->get_where($table_name,$condition);
   return $q->num_rows();  
}

public function checkUser($data = array()){
        $this->db->select('id');
        $this->db->from('tb_users');
        $this->db->where(array('email'=>$data['email']));
        $query = $this->db->get();
        $check = $query->num_rows();
        if($check > 0){
            $result = $query->row_array();
            $data['last_login'] = date("Y-m-d H:i:s");
            $update = $this->db->update(USERS,$data,array('id'=>$result['id']));
            $userID = $result['id'];
        }else{
            $userID = false ;
        }
        return $userID;
    }
	
/*************************CheckUser*******************************/	
    /* <!--INSERT RECORD FROM SINGLE TABLE--> */
    function insertData($table, $dataInsert){
        $this->db->insert($table, $dataInsert);
        return $this->db->insert_id();
    }
    /* <!--INSERT Batch RECORD FROM SINGLE TABLE--> */
	function insertBatch($table,$data)
	{
		$this->db->insert_batch($table, $data);
		return true;
	}
    /* <!--UPDATE RECORD FROM SINGLE TABLE--> */
    function updateFields($table, $data, $where){
        $this->db->update($table, $data, $where);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    /* <!--DELETE RECORD FROM SINGLE TABLE--> */
    function deleteData($table,$where){
        $this->db->where($where);
        $this->db->delete($table); 
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }   
    }
    /* ---GET SINGLE RECORD--- */
    function getsingle($table, $where = '', $fld = NULL, $order_by = '', $order = ''){
        if ($fld != NULL) {
            $this->db->select($fld);
        }
        $this->db->limit(1);
        if ($order_by != '') {
            $this->db->order_by($order_by, $order);
        }
        if ($where != '') {
            $this->db->where($where);
        }
        $q = $this->db->get($table);
        $num = $q->num_rows();
        if ($num > 0) {
            return $q->row();
        }
    }
    /* ---GET MULTIPLE RECORD--- */
    function getAllwhere($table, $where = '', $order_fld = '', $order_type = '', $select = 'all', $limit = '', $offset = '',$group_by='',$and_where = ''){
        $data = array();
        if ($order_fld != '' && $order_type != '') {
            $this->db->order_by($order_fld, $order_type);
        }
        if ($select == 'all') {
            $this->db->select('*');
        }else{
            $this->db->select($select);
        }
        $this->db->from($table);
        if ($where != ''){
            $this->db->where($where);
        }
        if ($and_where != ''){
            $this->db->where($and_where);
        }
        if(!empty($group_by)){
            $this->db->group_by($group_by); 
        }
        $clone_db = clone $this->db;
        $total_count = (int) $clone_db->get()->num_rows();
        if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
        } else if ($limit != '') {
            $this->db->limit($limit);
        }
        $q = $this->db->get();
        $num_rows = $q->num_rows();
        if ($num_rows > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
        }
        return array('total_count' => $total_count,'result' => $data);
    }
/***
/*@name=getFieldIdSequence
/*@param = projectId, city_id
***/
	public function getFieldIdSequence($projectId,$city_id){
		$this->db->select('field_id');
		$this->db->from('data_field_value');
		$this->db->where(array('pro_id'=>$projectId,'city_id'=>$city_id));
		$q = $this->db->get();
		$num_rows = $q->num_rows();
		$field_id_array=array();
		$field_id_sequence='';
		if ($num_rows > 0) {
			foreach($q->result() as $rows) 
			{  
				$field_id_array[] = $rows->field_id;
			}	
		}
		if(!empty($field_id_array)){	
		$field_id_sequence=implode(',',$field_id_array);
		}		
		return $field_id_sequence;
	}
/***
/* @name  selectProjecFieldsBySequence
/* @param projectId, sequence
***/	
	public function selectProjecFieldsBySequence($projectId,$sequence){
        $myquery = "SELECT * FROM `project_fields` WHERE `id_project` =$projectId ORDER BY FIELD(`id_project_field`,$sequence)";
		$query = $this->db->query($myquery);
		$result=$query->result();
        return $result;
    }
	public function selectProjecFields($projectId){
        $myquery = "SELECT * FROM `project_fields` WHERE `id_project` =$projectId ORDER BY `sequence_no`";
		$query = $this->db->query($myquery);
		$result=$query->result();
        return $result;
    }
	
    /* ---GET MULTIPLE RECORD--- */
    function getAll($table, $order_fld = '', $order_type = '', $select = 'all', $limit = '', $offset = '',$group_by='') {
        $data = array();
        if ($select == 'all') {
            $this->db->select('*');
        } else {
            $this->db->select($select);
        }
        if($group_by !=''){
            $this->db->group_by($group_by);
        }
        $this->db->from($table);

        $clone_db = clone $this->db;
        $total_count = (int) $clone_db->get()->num_rows();

        if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
        } else if ($limit != '') {
            $this->db->limit($limit);
        }
        if ($order_fld != '' && $order_type != '') {
            $this->db->order_by($order_fld, $order_type);
        }
        $q = $this->db->get();
        $num_rows = $q->num_rows();
        if ($num_rows > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
        }
        return array('total_count' => $total_count,'result' => $data);
    }


    /* <!--GET ALL COUNT FROM SINGLE TABLE--> */
    function getcount($table, $where="") {
        if(!empty($where)){
           $this->db->where($where);
        }
        $q = $this->db->count_all_results($table);
        return $q;
    }

    function getTotalsum($table, $where, $data) {
        $this->db->where($where);
        $this->db->select_sum($data);
        $q = $this->db->get($table);
        return $q->row();
    }

     /* <!--Join tables get single record with using where condition--> */
    
    function GetJoinRecord($table, $field_first, $tablejointo, $field_second,$field_val='',$where="",$group_by='',$order_fld='',$order_type='') {
        if(!empty($field_val)){
            $this->db->select("$field_val");
        }else{
            $this->db->select("*");
        }
        $this->db->from("$table");
        $this->db->join("$tablejointo", "$tablejointo.$field_second = $table.$field_first","inner");
        if(!empty($where)){
            $this->db->where($where);
        }
        if(!empty($group_by)){
            $this->db->group_by($group_by);
        }
        $clone_db = clone $this->db;
        $total_count = (int) $clone_db->get()->num_rows();
        if(!empty($order_fld) && !empty($order_type)){
            $this->db->order_by($order_fld, $order_type);
        }
        $q = $this->db->get();
        // echo $this->db->last_query();die;
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
        return array('total_count' => $total_count,'result' => $data);;
        }
    }

    
    function GetJoinRecordNew($table, $field_first, $tablejointo, $field_second, $field, $value, $field_val,$group_by='',$order_fld='',$order_type='', $limit = '', $offset = '') {
        $data = array();
        $this->db->select("$field_val");
        $this->db->from("$table");
        $this->db->join("$tablejointo", "$tablejointo.$field_second = $table.$field_first");
        $this->db->where("$table.$field", "$value");
        if(!empty($group_by)){
            $this->db->group_by($group_by);
        }

        $clone_db = clone $this->db;
        $total_count = (int) $clone_db->get()->num_rows();

        if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
        } else if ($limit != '') {
            $this->db->limit($limit);
        }
        if(!empty($order_fld) && !empty($order_type)){
            $this->db->order_by($order_fld, $order_type);
        }
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
        }
        return array('total_count' => $total_count,'result' => $data);
    }/******************************/
    function GetJoinRecordThree($table, $field_first, $tablejointo, $field_second,$tablejointhree,$field_three,$table_four,$field_four,$field_val='',$where="" ,$group_by="",$order_fld='',$order_type='', $limit = '', $offset = '') {
        $data = array();
        if(!empty($field_val)){
            $this->db->select("$field_val");
        }else{
            $this->db->select("*");
        }
        $this->db->from("$table");
        $this->db->join("$tablejointo", "$tablejointo.$field_second = $table.$field_first",'inner');
        $this->db->join("$tablejointhree", "$tablejointhree.$field_three = $table_four.$field_four",'inner');
        if(!empty($where)){
            $this->db->where($where);
        }

        if(!empty($group_by)){
            $this->db->group_by($group_by);
        }
        $clone_db = clone $this->db;
        $total_count = (int) $clone_db->get()->num_rows();

        if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
        } else if ($limit != '') {
            $this->db->limit($limit);
        }
        
        if(!empty($order_fld) && !empty($order_type)){
            $this->db->order_by($order_fld, $order_type);
        }
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
        }
        return array('total_count' => $total_count,'result' => $data);
    }/******************************/
    function getAllwhereIn($table,$where = '',$column ='',$wherein = '', $order_fld = '', $order_type = '', $select = 'all', $limit = '', $offset = '',$group_by='') {
        $data = array();
        if ($order_fld != '' && $order_type != '') {
            $this->db->order_by($order_fld, $order_type);
        }
        if ($select == 'all') {
            $this->db->select('*');
        } else {
            $this->db->select($select);
        }
        $this->db->from($table);
        if ($where != '') {
            $this->db->where($where);
        }
        if ($wherein != '') {
            $this->db->where_in($column,$wherein);
        }
        if($group_by !=''){
            $this->db->group_by($group_by);
        }

        $clone_db = clone $this->db;
        $total_count = (int) $clone_db->get()->num_rows();

        if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
        } else if ($limit != '') {
            $this->db->limit($limit);
        }

        $q = $this->db->get();
        $num_rows = $q->num_rows();
        if ($num_rows > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
        }
        return array('total_count' => $total_count,'result' => $data);
    }
/**************************** Custom - Query **************/
    public function custom_query($myquery,$trunket=""){
        $query = $this->db->query($myquery);
		if($trunket==""){
        return $query->result();
		}else{
		return 0;	
		}
    }
/****************************Join*By*Details**************/
public function get_two_table_data($data,$table1,$table2,$relation,$condition,$groupby="",$order="",$by=""){
		$this->db->select($data);
		$query=$this->db->from($table1);
		$this->db->join($table2, $relation , 'left');
		$query=$this->db->where($condition);
		
		if($order!="" && $by!=""){
		$this->db->order_by($order,$by);
		}
		if($groupby!=""){
		 $this->db->group_by($groupby);
        }
		$query=$this->db->get();
		return $query=$query->result();	
	}
/*******************************************/
public function getThreeTableData($data,$table1,$table2,$table3,$on,$on2,$condition,$groupby="",$order="",$by="",$limit="",$offset=""){
        $this->db->select($data);
		$this->db->from($table1);
		$this->db->join($table2,$on,'left');
		$this->db->join($table3,$on2,'left');
		$this->db->where($condition);
		if($groupby!=""){
		 	$this->db->group_by($groupby);
        }
		if($order!="" && $by!=""){
		$this->db->order_by($order,$by);
		}
		if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
        }
		
		$query=$this->db->get();
		return $query->result();
    }
/*******************************************/
/********-Select-Data_by-Condition-*********/
public function getDataByCondition($data,$table,$condition,$groupby="",$order="",$by=""){
	$this->db->select($data);
	$this->db->from($table);
	$this->db->where($condition);
	if($groupby!=""){
		$this->db->group_by($groupby);
        }
		if($order!="" && $by!=""){
			$this->db->order_by($order,$by);
		}
	$query=$this->db->get();
	return $query->result_array();
	}
 /********-Select-Data_by-Condition-*********/
 public function get_categories(){
    $query = $this->db->get('tb_category');
    $data = array();

    foreach ($query->result() as $category)
    {
        $data[$category->id] = $category;
        $data[$category->id]->subs = $this->get_sub_categories($category->id); 
    }

    return $data;
}

public function get_sub_categories($category_id)
{
    $this->db->where('category_id', $category_id);
    $query = $this->db->get('tb_subjects');
    return $query->result();
}
/*****************DATAFIELD-VALUE***************/
	 public function datafieldvaluedata($proid){
		$queryNodes = "SELECT * FROM `data_field_value` INNER JOIN `map_template_regions` ON data_field_value.city_id = map_template_regions.id WHERE data_field_value.pro_id = $proid";
		$query = $this->db->query($queryNodes);
		$result=$query->result();
		return $result;
	}
	public function getEqualCountvalueswithIgnore($id){
		$queryNodes = "SELECT cast(`field_value` as decimal(12,2)) as 'value' FROM `data_field_value` WHERE `field_value` != '' AND  `field_id` =$id";
		$query = $this->db->query($queryNodes);
		$result=$query->result();
		return $result;
	}
	public function getEqualCountvaluesV2($id, $from, $to){
		$queryNodes = "SELECT cast(`field_value` as decimal(12,2)) as 'value' FROM `data_field_value` WHERE `field_value` != '' AND `field_id` =$id ORDER BY cast(`field_value` as decimal(12,2)) DESC LIMIT $from,$to";
		$query = $this->db->query($queryNodes);
		$result=$query->result();
		return $result;
	} 
/*****************End Class***************/  
}

