<?php
//header("Location:/login.php");
/*
  	@project    CSV Visual Mapping  
  	@author     Gianluca Di Battista
  	@copyright  Webmio.it
	@year 		2020
  	@version    1.0.0
  	@file  		Index.php
  	@site		https://www.csvxlsvisualmapping.com/
*/

define('ROOT', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);

/* load composer autoloader */
if (file_exists(ROOT.'vendor/autoload.php'))
{
    require ROOT.'vendor/autoload.php';
}
else
{
    echo '<h1>Install composer.json</h1>';
    echo "<p>Follow instruction on Composer: <a href='https://getcomposer.org/doc/00-intro.md#globally'>https://getcomposer.org/doc/00-intro.md#globally</a></p>";
    echo "<p>After install composer, enter directory  / prompt command and type \"composer install\"</p>";
    exit;
}


require 'libs/Bootstrap.php';
require 'libs/Controller.php';
require 'libs/Model.php';
require 'libs/View.php';
require 'libs/Database.php';
require 'libs/Functions.php';
//require 'libs/mailer/class.phpmailer.php';
require 'config/database.php';
require 'libs/Mapp.php';
require 'libs/Detect.php';


$app = new Bootstrap();
