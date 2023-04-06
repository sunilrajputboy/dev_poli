<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * This Class used as common database query functions
 * @package   CodeIgniter
 * @category  COMMON MODEL
 * @author    PixlrIt Team
 */

class Common_model extends CI_Model {
function __construct()
{
parent::__construct();
}

    /*************************CheckUser*******************************/
public function checkUser($data = array()){
        $this->db->select('UserID');
        $this->db->from('users');
        $this->db->where(array('LoginType'=>$data['type'],'SocialID'=>$data['oauth_uid']));
        $query = $this->db->get();
        $check = $query->num_rows();
        if($check > 0){
            $result = $query->row_array();
            $data['ModifiedDate'] = datetime();
            $update = $this->db->update('users',$data,array('UserID'=>$result['id']));
            $userID = $result['id'];
        }else{
            $data['CreatedDate'] = datetime();
            $data['ModifiedDate']= datetime();
            $insert = $this->db->insert('users',$data);
            $userID = $this->db->insert_id();
        }

        return $userID?$userID:false;
    }

    /* <!--INSERT RECORD FROM SINGLE TABLE--> */

    function insertData($table, $dataInsert) {
        $this->db->insert($table, $dataInsert);
        return $this->db->insert_id();
    }

    /* <!--UPDATE RECORD FROM SINGLE TABLE--> */

    function updateFields($table, $data, $where) {
        $this->db->update($table, $data, $where);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    /* UPDATE CONCATE COLUMN WITH AMOUNT */
    function updateConcate($table,$field1,$value,$where){
        $this->db->set($field1,'CONCAT('.$field1.',\',\',\''.$value.'\')',FALSE);
        $this->db->where($where);
        $this->db->update($table);	
		if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    /* UPDATE SINGLE ROW WITH AMOUNT */
    function updateAmount($table,$field1,$amt,$where)
    {
        $this->db->set($field1, "$field1+$amt",FALSE);
        $this->db->where($where);
        $this->db->update($table);
    }
    /* UPDATE SINGLE ROW WITH MINUS AMOUNT */
    function updateAmountMinus($table,$field1,$amt,$where)
    {
        $this->db->set($field1, "$field1-$amt",FALSE);
        $this->db->where($where);
        $this->db->update($table);
    }
    
    // update by operator fee in failled transaction (user)
    function updateTrans($table,$field,$where)
    {
        $this->db->set($field, "$field+1",FALSE);
        $this->db->where($where);        
        $this->db->update($table);
    }
    //update wallet amount
    function updateWalletamount($table,$amt,$field,$where){
        $this->db->set($field,"$field+$amt",FALSE);
        $this->db->where($where);        
        $this->db->update($table);
    }
    
    function updateWalletamountmul($table,$amt,$field,$amt2,$field2,$where){
        $this->db->set($field,"$field+$amt",FALSE);
        $this->db->set($field,"$field2+$amt2",FALSE);
        $this->db->where($where);        
        $this->db->update($table);
    }

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
    function getsingle($table, $where = '', $fld = NULL, $order_by = '', $order = '') {
        
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

    function getsingle_or($table, $where = '',$where_or = '', $fld = NULL, $order_by = '', $order = '') {

        if ($fld != NULL) {
            $this->db->select($fld);
        }
        $this->db->limit(1);

        if ($order_by != '') {
            $this->db->order_by($order_by, $order);
        }
        if ($where_or != '') {
            $this->db->or_where($where_or);
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
		if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
        } else if ($limit != '') {
            $this->db->limit($limit);
        }
        if(!empty($group_by)){
            $this->db->group_by($group_by);
        }
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
            return $data;
        }
    }

    function GetJoinRecordGame($table, $field_first, $tablejointo, $field_second,$field_val='',$where="",$order_fld='',$order_type='',$limit="",$offset=""){
        if(!empty($field_val)){
            $this->db->select("$field_val");
        }else{
            $this->db->select("*");
        }
        $this->db->from("$table");
        $this->db->join("$tablejointo", "$tablejointo.$field_second = $table.$field_first","left outer");
        if(!empty($where)){
            $this->db->where($where);
        }
        // if(!empty($group_by)){
        //     $this->db->group_by($group_by);
        // }
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
            return $data;
        }
    }
     
    /* ---GET MULTIPLE RECORD--- */
    function getAllwhere($table, $where = '', $order_fld = '', $order_type = '', $select = 'all', $limit = '', $offset = '',$group_by='',$like = '') {
        if ($order_fld != '' && $order_type != '') {
            $this->db->order_by($order_fld, $order_type);
        }
        if ($select == 'all') {
            $this->db->select('*');
        } else {
            $this->db->select($select);
        }
        if ($where != '') {
            $this->db->where($where);
        }
        if($like != ''){
             $this->db->like($like);
        }

        if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
        } else if ($limit != '') {
            $this->db->limit($limit);
        }

        if(!empty($group_by)){
            $this->db->group_by($group_by); 
        }

        $q = $this->db->get($table);
        $num_rows = $q->num_rows();
        if ($num_rows > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
            return $data;
        }
    }


/* ---GET MULTIPLE RECORD--- */
    function getAll($table, $order_fld = '', $order_type = '', $select = 'all', $limit = '', $offset = '',$group_by='') {
        if ($order_fld != '' && $order_type != '') {
            $this->db->order_by($order_fld, $order_type);
        }
        if ($select == 'all') {
            $this->db->select('*');
        } else {
            $this->db->select($select);
        }
        if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
        } else if ($limit != '') {
            $this->db->limit($limit);
        }
        if($group_by !=''){
            $this->db->group_by($group_by);
        }

        $q = $this->db->get($table);
        $num_rows = $q->num_rows();
        if ($num_rows > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
            return $data;
        }
    }

    function getAllwherenew($table, $where, $select = 'all') {
        if ($select == 'all') {
            $this->db->select('*');
        } else {
            $this->db->select($select);
        }
        $this->db->where($where, NULL, FALSE);
        $q = $this->db->get($table);
        $num_rows = $q->num_rows();
        if ($num_rows > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
            return $data;
        } else {
            return 'no';
        }
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

    
    function GetJoinRecordNew($table, $field_first, $tablejointo, $field_second, $field, $value, $field_val) {
        $this->db->select("$field_val");
        $this->db->from("$table");
        $this->db->join("$tablejointo", "$tablejointo.$field_second = $table.$field_first");
        $this->db->where("$table.$field", "$value");
        $this->db->group_by("$table.$field");
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
            return $data;
        }
    }

    function GetJoinRecordThree($table, $field_first, $tablejointo, $field_second,$tablejointhree,$field_three,$table_four,$field_four,$field_val='',$where="" ,$group_by="") {
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
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
            return $data;
        }
    }

/* <!--GET SUM FROM SINGLE TABLE--> */

    function getSum($table, $where, $data) {
        $this->db->where($where);
        $this->db->select_sum($data);
        $q = $this->db->get($table);
        return $q->result();
    }

    function getSumfield($table, $data) {
        //$this->db->where($where);
        $this->db->select_sum($data);
        $q = $this->db->get($table);
        return $q->row();
    }

    function getAllwhereIn($table,$where = '',$column ='',$wherein = '', $order_fld = '', $order_type = '', $select = 'all', $limit = '', $offset = '',$group_by='') {
        if ($order_fld != '' && $order_type != '') {
            $this->db->order_by($order_fld, $order_type);
        }
        if ($select == 'all') {
            $this->db->select('*');
        } else {
            $this->db->select($select);
        }
        if ($where != '') {
            $this->db->where($where);
        }
        if ($wherein != '') {
            $this->db->where_in($column,$wherein);
        }
        if($group_by !=''){
            $this->db->group_by($group_by);
        }
        if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
        } else if ($limit != '') {
            $this->db->limit($limit);
        }

        $q = $this->db->get($table);
        $num_rows = $q->num_rows();
        if ($num_rows > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
            return $data;
        }
    } 
/*****************************************/
	public function findInSet($table,$select="*",$value,$column,$order_fld = '', $order_type = '',$andwhere=array()){
		$this->db->select($select);
		$this->db->from($table);
		$this->db->where("FIND_IN_SET($value,$column)!=", 0);
		if(!empty($andwhere)){
		$this->db->where($andwhere);
		}
		if($order_fld!="" && $order_type != ''){
		$this->db->order_by($order_fld,$order_type);
		}
		$result=$this->db->get();	
		$num_rows =$result->num_rows();
		if($num_rows > 0) {
		foreach ($result->result() as $rows) {
		$data[] = $rows;
		}
		$result->free_result();
		return $data;
    }
}
/*************-Select-Data_by-Condition-************/
	public function get_data_by_condition($data,$table,$condition,$limit="",$offset=""){
		$this->db->select($data);
		$this->db->from($table);
		$this->db->where($condition);
		if ($limit != '' && $offset != '') {
        $this->db->limit($limit, $offset);
        }
		$query=$this->db->get();
		return $query->result();
	}
/****************************Join*By*Details**************/
	public function get_two_table_data($data,$table1,$table2,$relation,$condition,$groupby="",$order_fld="",$order_type="",$limit="",$offset=""){
		$this->db->select($data);
		$query=$this->db->from($table1);
		$this->db->join($table2, $relation , 'left');
		$query=$this->db->where($condition);
		if($groupby!=""){
		 $this->db->group_by($groupby);
        }
		if($order_fld!="" && $order_type != ''){
		$this->db->order_by($order_fld,$order_type);
		}
		if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
        }
		$query=$this->db->get();
		return $query=$query->result();	
	}
/****************************Custom-Query**************/
	public function custom_query($sql){
		$query = $this->db->query($sql);
		return $query=$query->result();	
	}
	
/* End of file Common_model.php */
/* Location: ./application/models/Common_model.php */
}
?>