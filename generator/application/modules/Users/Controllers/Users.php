<?php

class Users extends MX_Controller {
 
	// public function index()
	// {
	// 	echo "index";
	// }


	public function test_hmvc(){
		$data['test'] = 123;
		$this->layout->load('default','testing_hmvc',$data);
		// echo "success";
	}
}