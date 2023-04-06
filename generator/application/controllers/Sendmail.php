<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sendmail extends MY_Controller{
	public function __construct(){
        parent::__construct();
		    }
			
public function index(){
	$this->load->model('sr_model');
	$config = array(
    'protocol' => 'smtp',
    'smtp_host' => 'smtp.gmail.com',
    'smtp_port' => 587,
    'smtp_user' => 'polimappertest@gmail.com',
    'smtp_pass' => 'syvbmrhmebajkmiy',
    'mailtype' => 'html',
    'charset' => 'utf-8',
    'newline' => "\r\n",
    'wordwrap' => TRUE
);
    $to = 'sunil.srajput90@gmail.com';
    $subject ='testfrom Px';
    $message ='<h3>HELLO</h3> this is a test mail. SUNIL';
    $from ='polimappertest@gmail.com';
	
     $this->email->initialize($config);
      $this->email->from($from);
      $this->email->to($to);
      $this->email->subject($subject);
      $this->email->message($message);
	 
      try {
			$hello = $this->email->send();
			echo $hello;
			 echo "HELLO";
			//return true;
		} catch (Exception $e) {
			log_message('error', $e->getMessage());
			print_r($e->getMessage());
			 echo "ERROR";
			//return false;
		}
}

}