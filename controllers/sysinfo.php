<?php
	
	
	class Sysinfo extends Controller {

	function __construct() {
		parent::__construct();
		
	}
	
		
	function index()
	{
		
		$this->view->title = "Sysinfo";
		$this->view->subtitle = "The settings of recommended system for run Visual Mapping";
		$this->view->phpversion = phpversion();
		$this->view->memory_limit = ini_get("memory_limit");
		$this->view->upload_max_filesize =  ini_get("upload_max_filesize");
		$this->view->max_file_uploads =  ini_get("max_file_uploads");
		$this->view->post_max_size =  ini_get("post_max_size");
		$this->view->max_execution_time =  ini_get("max_execution_time");
		$this->view->max_input_time =  ini_get("max_input_time");
		$this->view->allow_url_fopen = ini_get("allow_url_fopen");
		$this->view->short_open_tag = ini_get("short_open_tag");
		$this->view->System = PHP_OS;
		$this->view->render('sysinfo/index');
		exit();
		
	}
	

}