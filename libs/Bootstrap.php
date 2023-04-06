<?php
/*
  	@project    CSV Visual Mapping  
  	@author     Gianluca Di Battista
  	@copyright  Webmio.it
	@year 		2020
  	@version    1.0.0
  	@file  		Bootstrap.php
  	@site		https://www.csvxlsvisualmapping.com/
*/

class Bootstrap {

	function __construct() {

		$url = isset($_GET['url']) ? $_GET['url'] : null;
		$url = rtrim($url, '/');
		$url = explode('/', $url);

		if (empty($url[0])) {
			require_once 'controllers/index.php';
			$controller = new Index();
			$controller->index();
			return false;
		}

		$file = 'controllers/' . $url[0] . '.php';
		if (file_exists($file)) {
			require_once $file;
		} else {
			$this->error();
			die;
		}
		
		$controller = new $url[0];
		$controller->loadModel($url[0]);

		if (isset($url[2])) {
			if (method_exists($controller, $url[1])) {
				$controller->{$url[1]}($url[2]);
			} else {
				$this->error();
			}
		} else {
			if (isset($url[1])) {
				if (method_exists($controller, $url[1])) {
					$controller->{$url[1]}();
				} else {
					$this->error();
				}
			} else {
				$controller->index();
			}
		}
		
		
	}
	
	function error() {
		require_once 'controllers/error.php';
		$controller = new Errors();
		$controller->index();
		return false;
	}

}