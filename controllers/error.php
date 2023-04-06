<?php
/*
  	@project    CSV Visual Mapping  
  	@author     Gianluca Di Battista
  	@copyright  Webmio.it
	@year 		2020
  	@version    1.0.0
  	@class  	Errors
*/

class Errors extends Controller {
	/**
     * Erros constructor
     */
	function __construct() {
		parent::__construct();
	}
	/**
     * Erros View
     */
	function index(){
		$this->view->msg = 'Error 404 - Page not Found';
		$this->view->render('error/404');
		exit();
		
	}
	

	

}