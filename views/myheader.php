<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <!-- Meta-Information -->
    <title>Polimapper Admin</title>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Vendor: Bootstrap Stylesheets http://getbootstrap.com -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/dashboard/css/bootstrap.min.css">
    <!-- Our Website CSS Styles -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/dashboard/css/icons.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>public/web/css/select2.min.css"/>
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>public/web/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/dashboard/css/richtext.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/dashboard/css/main.css">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/dashboard/css/responsive.css">
    <link rel="shortcut icon" type="image/x-icon" href="https://images.squarespace-cdn.com/content/v1/5a1bf4aaf6576eb8bfaa94ae/1521729157183-R5WP740S36BRCRNHGAO5/ke17ZwdGBToddI8pDm48kH54PB8yiwm2_rSCIjyNENlZw-zPPgdn4jUwVcJE1ZvWQUxwkmyExglNqGp0IvTJZUJFbgE-7XRK3dMEBRBhUpyDF37q3iMIriaFfyrDbDP6KmmMTXGlPlnjqY75t8ZjqZlghf0G-FRcalVDMsa2s9U/favicon.ico?format=100w"/>
</head>
<body>
  
 <!-- <div class="loader">-->
	<!--	<div>-->
	<!--	     <div class="triforce"></div>-->
	<!--	 </div>-->
	<!--</div>-->
	<div class="overlay-close"></div>
	<div class="sideToggle">
	    <div id="nav-icon" class=""> <span></span> <span></span> <span></span> </div>
	</div>
<?php
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$CurPageURL = $protocol . $_SERVER['HTTP_HOST']; 
define("BASEURL", $CurPageURL);
define("USERROLE", $_SESSION['role']);
define("CURRENTURL", $_SERVER['REQUEST_URI']);
$id = $_SESSION['uid'];
require_once($_SERVER["DOCUMENT_ROOT"]."/dashboard/includes/functions.php");
$obj = new Mainfunctions();
$userDatass=$obj->selectSingleRow('users',"`id`='$id'");
?>
<header class="side-header light-skin opened-menu">
    <div class="menu-options" style="display:none"><span class="menu-action"><i></i></span></div>
    <div class="site-logo">
        <a href="<?php echo BASEURL ?>/dashboard" title="">
            <img src="https://images.squarespace-cdn.com/content/5a1bf4aaf6576eb8bfaa94ae/1511781776755-5VYNU72VY6PJ9T1EWLBL/polimapper+header+small-01.jpg?format=1500w&content-type=image%2Fjpeg" alt="Polimapper" />
        </a>
    </div>
    <div class="menu-scroll">
            <nav>
       <ul>
	 <li class="<?php if(CURRENTURL == '/dashboard/'){ echo 'active';}?>">
          <a href="<?php echo BASE_URL; ?>/dashboard/"      title=""><i class="fa fa-dashboard"></i><span>Dashboard</span></a>
	  </li>
	   <?php if(USERROLE==1){ ?>		
	  <li class="<?php if(CURRENTURL == '/dashboard/packages/' || explode("?", CURRENTURL)[0] == '/dashboard/packages/edit.php' || CURRENTURL == '/dashboard/packages/add.php'){ echo 'active';}?>"> 
		  <a href="<?php echo BASE_URL; ?>/dashboard/packages/"  title=""><i class="fa fa-map"></i><span>Packages</span></a> 
	  </li>
					
      <li class="<?php if(CURRENTURL == '/dashboard/clients/' || explode("?", CURRENTURL)[0] == '/dashboard/clients/edit.php' || CURRENTURL == '/dashboard/clients/add.php'){ echo 'active'; }?>"> 
	  <a href="<?php echo BASE_URL; ?>/dashboard/clients/" title=""><i class="fa fa-user-plus"></i><span>Clients</span></a>
      </li>
	  
    <li  class="<?php if(CURRENTURL == '/dashboard/users/' || explode("?", CURRENTURL)[0] == '/dashboard/users/edit.php' || CURRENTURL == '/dashboard/users/add.php'){ echo 'active'; } ?>">
	<a href="/dashboard/users/" title=""><i class="fa fa-users"></i><span>Users</span></a>
	</li>
	<li  class="<?php  if(CURRENTURL == '/dashboard/projects/' || explode("?", CURRENTURL)[0] == '/dashboard/projects/viewprojects.php' || CURRENTURL == '/dashboard/projects/add.php'){ echo 'active'; } ?>"> 
	<a title="" href="<?php echo BASE_URL; ?>/dashboard/projects/"><i class="fa fa-window-maximize" aria-hidden="true"></i><span>Projects</span></a> 
	</li>
		<li  class="<?php  if(CURRENTURL == '/dashboard/projectsgroup/' || explode("?", CURRENTURL)[0] == '/dashboard/projectsgroup/editprojectsgroup.php' || CURRENTURL == '/dashboard/projectsgroup/add.php'){ echo 'active'; } ?>"> 
	<a title="" href="<?php echo BASE_URL; ?>/dashboard/projectsgroup/"><i class="fa fa-window-restore" aria-hidden="true"></i><span>Projects group</span></a> 
	</li>
	   <li  class="<?php if(CURRENTURL == '/dashboard/analytics/'){ echo 'active'; } ?>"> <a href="javascript:void(0)" title=""><i class="fa fa-pie-chart"></i><span>Analytics</span></a>
	   </li>
	   
	   <li class="<?php if(CURRENTURL == '/dashboard/notifications/'){ echo 'active'; } ?>"><a href="javascript:void(0)" title=""><i class="fa fa-bell"></i><span>Notifications</span></a></li>
	   <li class="<?php if(CURRENTURL == '/dashboard/templates/'){ echo 'active'; } ?>"><a href="<?php echo BASE_URL; ?>/dashboard/templates/" title=""><i class="fa fa-file"></i><span>Templates</span></a></li>
	   <?php }else{ ?>
	   
	<li  class="<?php  if(CURRENTURL == '/dashboard/projects/' || explode("?", CURRENTURL)[0] == '/dashboard/projects/viewprojects.php' || CURRENTURL == '/dashboard/projects/add.php'){ echo 'active'; } ?>"> 
	<a title="" href="<?php echo BASE_URL; ?>/dashboard/projects/"><i class="fa fa-window-maximize" aria-hidden="true"></i><span>Projects</span></a> 
	</li>
	<li  class="<?php  if(CURRENTURL == '/dashboard/projectsgroup/' || explode("?", CURRENTURL)[0] == '/dashboard/projectsgroup/editprojectsgroup.php' || CURRENTURL == '/dashboard/projectsgroup/add.php'){ echo 'active'; } ?>"> 
	<a title="" href="<?php echo BASE_URL; ?>/dashboard/projectsgroup"><i class="fa fa-window-restore" aria-hidden="true"></i><span>Projects group</span></a> 
	</li>
	<?php if($userDatass['allowed_user_add']==1){ ?>
	<li  class="<?php if(CURRENTURL == '/dashboard/users/view_users.php' || explode("?", CURRENTURL)[0] == '/dashboard/users/edit_user.php' || CURRENTURL == '/dashboard/users/add_user.php'){ echo 'active'; } ?>">
	<a href="<?php echo BASE_URL; ?>/dashboard/users/view_users.php" title=""><i class="fa fa-users"></i><span>Users</span></a>
	</li>
	<?php } ?>
		<?php if($userDatass['allowed_client_add']==1){ ?>
 <li class="<?php if(CURRENTURL == '/dashboard/clients/view_clients.php' || explode("?", CURRENTURL)[0] == '/dashboard/clients/edit_clients.php' || CURRENTURL == '/dashboard/clients/add.php'){ echo 'active'; }?>"> 
	  <a href="<?php echo BASE_URL; ?>/dashboard/clients/view_clients.php" title=""><i class="fa fa-user-plus"></i><span>Clients</span></a>
      </li>
	<?php } ?>
	
	<li  class="<?php  if(CURRENTURL == '/dashboard/setting/'){ echo 'active'; } ?>"> 
	<a title="" href="<?php echo BASE_URL; ?>/dashboard/setting/"><i class="fa fa-gear"></i><span>Settings</span></a> 
	</li>
	 <!--<li  class="<?php //if(CURRENTURL == '/dashboard/analytics/'){ echo 'active'; } ?>"> <a title=""><i class="fa fa-pie-chart"></i> <span>Analytics</a>-->
	 <!--  </li>-->
	   <?php } ?>
                   </ul>
            </nav>

    </div><!-- Menu Scroll -->
    <div class="log-out-btn"> 
	<a class="btn cus-btn" href="<?php echo BASEURL; ?>/logout.php" title=""><i class="fa fa-share"></i> <span>Log out</span></a>
    </div>
</header>
<div class="main-content">

