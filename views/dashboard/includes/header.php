<!DOCTYPE html>
<html>

<head>
	<!-- Meta-Information -->
	<title><?php echo BASE_TITLE; ?></title>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Vendor: Bootstrap Stylesheets http://getbootstrap.com -->
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/web/css/bootstrap.min.css">
	<!-- Our Website CSS Styles -->
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/web/css/icons.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>public/web/css/select2.min.css" />
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>public/web/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/web/css/richtext.min.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/web/css/rte_theme_default.css" />
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/web/css/drag.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/web/css/main.css">
	<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/web/css/responsive.css">
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo BASE_URL; ?>/public/web/images/favicon.jpg" />

</head>

<body>

	<div class="overlay-close"></div>
	<div class="sideToggle">
		<div id="nav-icon" class=""> <span></span> <span></span> <span></span> </div>
	</div>

	<header class="side-header light-skin opened-menu">
		<div class="menu-options" style="display:none"><span class="menu-action"><i></i></span></div>
		<div class="site-logo">
			<a href="<?php echo BASE_URL ?>/dashboard" title="">
				<img src="https://images.squarespace-cdn.com/content/5a1bf4aaf6576eb8bfaa94ae/1511781776755-5VYNU72VY6PJ9T1EWLBL/polimapper+header+small-01.jpg?format=1500w&content-type=image%2Fjpeg" alt="Polimapper" />
			</a>
		</div>
		<!--// for active class //-->
		<?php
		$URI = '';
		$path = '';
		$URI = explode('/', $_SERVER['REQUEST_URI']);
		$path = $URI[1];
		?>
		<div class="menu-scroll">
			<nav>
				<ul>
					<li class="<?php if ($path == 'dashboard') {
									echo 'active';
								} ?>">
						<a href="<?php echo BASE_URL; ?>dashboard" title=""><i class="fa fa-dashboard"></i><span>Dashboard</span></a>
					</li>
					<?php if (USERROLE == 1) { ?>
						<li class="<?php if ($path == 'packages') {
										echo 'active';
									} ?>">
							<a href="<?php echo BASE_URL; ?>packages/" title=""><i class="fa fa-map"></i><span>Packages</span></a>
						</li>

						<li class="<?php if ($path == 'clients') {
										echo 'active';
									} ?>">
							<a href="<?php echo BASE_URL; ?>clients" title=""><i class="fa fa-user-plus"></i><span>Clients</span></a>
						</li>

						<li class="<?php if ($path == 'users') {
										echo 'active';
									} ?>">
							<a href="<?php echo BASE_URL; ?>users/" title=""><i class="fa fa-users"></i><span>Users</span></a>
						</li>
						<li class="<?php if ($path == 'projects') {
										echo 'active';
									} ?>">
							<a title="" href="<?php echo BASE_URL; ?>projects/"><i class="fa fa-window-maximize" aria-hidden="true"></i><span>Projects</span></a>
						</li>
						<li class="<?php if ($path == 'projectsgroup') {
										echo 'active';
									} ?>">
							<a title="" href="<?php echo BASE_URL; ?>projectsgroup/"><i class="fa fa-window-restore" aria-hidden="true"></i><span>Projects group</span></a>
						</li>
						<li class="<?php if ($path == 'analytics') {
										echo 'active';
									} ?>"> <a href="<?php echo BASE_URL; ?>analytics/" title=""><i class="fa fa-pie-chart"></i><span>Analytics</span></a>
						</li>

						<!--<li class="<? php // if($path == 'notifications'){ echo 'active';}
										?>"><a href="Javascript:void(0)" title=""><i class="fa fa-bell"></i><span>Notifications</span></a></li>-->
						<li class="<?php if ($path == 'templates') {
										echo 'active';
									} ?>"><a href="<?php echo BASE_URL; ?>templates/" title=""><i class="fa fa-file"></i><span>Templates</span></a></li>
					<?php } else { ?>

						<li class="<?php if ($path == 'projects') {
										echo 'active';
									} ?>">
							<a title="" href="<?php echo BASE_URL; ?>projects/"><i class="fa fa-window-maximize" aria-hidden="true"></i><span>Projects</span></a>
						</li>
						<li class="<?php if ($path == 'projectsgroup') {
										echo 'active';
									} ?>">
							<a title="" href="<?php echo BASE_URL; ?>projectsgroup"><i class="fa fa-window-restore" aria-hidden="true"></i><span>Projects group</span></a>
						</li>
						<?php if (isset($userDatass) && $userDatass['allowed_user_add'] == 1) { ?>
							<li class="<?php if ($path == 'users') {
											echo 'active';
										} ?>">
								<a href="<?php echo BASE_URL; ?>users" title=""><i class="fa fa-users"></i><span>Users</span></a>
							</li>
						<?php } ?>
						<?php if (isset($userDatass) && $userDatass['allowed_client_add'] == 1) { ?>
							<li class="<?php if ($path == 'clients') {
											echo 'active';
										} ?>">
								<a href="<?php echo BASE_URL; ?>clients" title=""><i class="fa fa-user-plus"></i><span>Clients</span></a>
							</li>
						<?php } ?>

						<li class="<?php if ($path == 'setting') {
										echo 'active';
									} ?>">
							<a title="" href="<?php echo BASE_URL; ?>setting/"><i class="fa fa-gear"></i><span>Settings</span></a>
						</li>
					<?php } ?>
				</ul>
			</nav>
		</div><!-- Menu Scroll -->
		<div class="log-out-btn">
			<a class="btn cus-btn" href="<?php echo BASE_URL; ?>logout/index" title=""><i class="fa fa-share"></i> <span>Log out</span></a>
		</div>
	</header>
	<div class="main-content">
		<!-- <div class="sub-header">
<div></div>
			<div class="sub-header-right">
				<ul>
					<li>
						<a href="<?php echo BASE_URL; ?>setting/"><i class="fa fa-cog"></i></a>
					</li>
					<li>
						<a href="<?php echo BASE_URL; ?>logout/index"><i class="fa fa-sign-out"></i></a>
					</li>
				</ul>
			</div>
		</div> -->