<?php
header('location:login');
exit();
session_start();
if(!isset($_SESSION['uid'])){
    header("Location: login.php");
}else if($_SESSION['role'] == 'Admin'){
        header("Location: ./admin");
}
require_once("./admin/includes/user-header.php");
include "userdata.php";
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://"; 
$site_url  = $protocol.$_SERVER['HTTP_HOST'];

require_once($_SERVER["DOCUMENT_ROOT"]."/admin/includes/usernav.php");

?>


   
   

<div class="dashboard">

<div class="page-header-wrap">
    <h3>Dashboard</h3>
    
</div>
<h1><?php echo $userData['name'];
    ?></h1>
</div>

<?php
	require_once('./admin/includes/footer.php');
?>