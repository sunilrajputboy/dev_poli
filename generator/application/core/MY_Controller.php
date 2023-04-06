<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    function __construct(){
        parent::__construct();
    }

/********************************/
	 public function pageview($page,$headerdata=array(),$maindata=array(),$footerdata=array()){
		 $this->load->view('website/template/header',$headerdata);
		 $this->load->view('website/'.$page,$maindata);
		 $this->load->view('website/template/footer',$footerdata);
	 }
	 public function pageViewLogin($page,$headerdata=array(),$maindata=array(),$footerdata=array()){
		 $this->load->view('template/header',$headerdata);
		 $this->load->view($page,$maindata);
		 $this->load->view('template/footer',$footerdata);
	 }
/***************Admin*****************/
	 public function pageviewadmin($page,$headerdata=array(),$maindata=array(),$footerdata=array()){
		 $this->load->view('admin/template/header',$headerdata);
		 $this->load->view('admin/template/sidebar');
		 $this->load->view('admin/'.$page,$maindata);
		 $this->load->view('admin/template/footer',$footerdata);
	 }	
/********************************/	
    public function check_userrole(){
			      if($this->session->userdata('loggedIn')){
					$email=$this->session->userdata['userData']['email'];
					$userDetails = $this->sr_model->getsingle(USERS,array('email'=>$email));
					if(!empty($userDetails)){
						return $userDetails->user_role;
					}else{
						return false;
						};
			      }else{
			         return false;
			      }
    }
/********************************/
    public function checkUserLogin(){
			      if($this->session->userdata('loggedIn')){
			         return true;
			      }else{
					 $this->session->set_flashdata('error_msg','Please login.'); 
			         redirect(BASEURL);
			      }
    }
/********************************/
/********************************/
    public function checkAdminlogin(){
			      if($this->session->userdata('loggedIn') && $this->session->userdata['userData']['user_role']==1){
						return true;
			      }else{
					 $this->session->set_flashdata('error_msg','Please login.'); 
			         redirect(BASEURL);
			      }
    }
/********************************/
/********************************/
    public function checkVendorlogin(){
			      if($this->session->userdata('loggedIn') && $this->session->userdata['userData']['user_role']==2){
						return true;
			      }else{
					 $this->session->set_flashdata('error_msg','Please login.'); 
			         redirect(BASEURL);
			      }
    }
/********************************/
/********************************/
    public function checkCustomerlogin(){
			      if($this->session->userdata('loggedIn') && $this->session->userdata['userData']['user_role']==3){
						return true;
			      }else{
					 $this->session->set_flashdata('error_msg','Please login.'); 
			         redirect(BASEURL);
			      }
    }
/********************************/
    public function deleteData(){
    	$tableName = $this->input->post('table_name');
    	$record = $this->input->post('record');
    	if($this->sr_model->deleteData($tableName,array('id'=>$record))){
    		echo json_encode(array('status'=>1));
    	}
    }/*************************************//*************************************/
	public function sendEmail($from,$fromname,$to,$subject,$message){
        $this->load->library('email');
		$config = array ('mailtype' => 'html','charset'  => 'utf-8','priority' => '1');
        $this->email->initialize($config);
        $this->email->from($from,$fromname);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
         return$this->email->send();
		 
    	}
		/*************************************/


	/*
	*Function: getAllwhere
	*Descripion: Get All Data with Condition
	*/
	public function getAllwhere($table, $where = '', $order_fld = '', $order_type = '', $select = 'all', $limit = '', $offset = '',$group_by='',$like = ''){
		return $this->sr_model->getAllwhere($table, $where, $order_fld , $order_type , $select , $limit , $offset ,$group_by,$like);
	}

	/*
	*Function: getAllwherein
	*Descripion: Get All Data with Condition
	*/
	public function getAllwherein($table,$where = '',$column ='',$wherein = '', $order_fld = '', $order_type = '', $select = 'all', $limit = '', $offset = '',$group_by='') {
		return $this->sr_model->getAllwherein($table,$where,$column,$wherein, $order_fld, $order_type, $select, $limit, $offset,$group_by);
	}

	/*
	*Function: getsingle
	*Descripion: Get Single row
	*/
	public function getsingle($table, $where = '', $fld = NULL, $order_by = '', $order = ''){
		return $this->sr_model->getsingle($table, $where, $fld, $order_by, $order);

	}

		/*************************************/
}