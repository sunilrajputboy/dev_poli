<?php
error_reporting(1);
header('Content-Type: application/json;charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Headers: Cache-Control, Pragma, Origin, Authorization, Content-Type, X-Requested-With");
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
$json_string = json_encode($maindata, JSON_INVALID_UTF8_IGNORE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
		echo $json_string;
?>