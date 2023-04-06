<?php
/*
  	@project    CSV Visual Mapping  
  	@author     Gianluca Di Battista
  	@copyright  Webmio.it
	@year 		2020
  	@version    1.0.0
  	@file  		Functions.php
  	@site		https://www.csvxlsvisualmapping.com/
*/
 	
class Functions
{

    public function __construct()
    {

    }

    public static function now()
    {
        date_default_timezone_set('Europe/Rome');
        $script_tz = date_default_timezone_get();
        $today = date("d/m/Y - H:i:s");
        return $today;
    }

    public static function commaReplace($string)
    {
        $string = str_replace(',', ' ', $string);
        return $string;

    }

    public static function sanitizeEmail($data)
    {
        return filter_var($data, FILTER_SANITIZE_EMAIL);
    }

    public static function sanitizeTxt($data)
    {
        return filter_var($data, FILTER_SANITIZE_STRING);
    }

    public static function getExt($str)
    {
        $pathInfo = pathinfo($str);
        return $pathInfo["extension"];
    }
    public static function returnTxt($val)
    {
	    switch($val)
	    {
		    case 0: $result = "No"; break;
		    case 1: $result = "Yes"; break;
	    }
	    return $result;
	    
    }

}
