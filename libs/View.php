<?php
/*
  	@project    CSV Visual Mapping  
  	@author     Gianluca Di Battista
  	@copyright  Webmio.it
	@year 		2020
  	@version    1.0.0
  	@file  		View.php
  	@site		https://www.csvxlsvisualmapping.com/
*/

class View {

	function __construct() {
	}

	public function render($name, $noInclude = false, $data = false){
	    	if($name == 'error/404'){ ?>
			    <script type="text/javascript">
			        location.href = '/login';
			        </script>
			    <?php
			}
			require 'views/header.php';
// 			require 'views/' . $name . '.php';
			require 'views/footer.php';
			exit();
	}
	public function show($name, $noInclude = false, $data = false){
			require 'views/' . $name . '.php';
			exit();
	}
	public function dashboard($name, $noInclude = false, $data = false){
		    extract($data);
			require 'views/dashboard/includes/header.php';
			require 'views/' . $name . '.php';
			require 'views/dashboard/includes/footer.php';
			exit();
	}
	public function mydashboard($name, $noInclude = false, $data = false){
			extract($data);
			require 'views/dashboard/includes/header.php';
			require 'views/' . $name . '.php';
			require 'views/dashboard/includes/footer.php';
			exit();
			
	}

}
