<!DOCTYPE html>
<html lang="IT">
   <head>
      <title><?php echo BASE_TITLE; ?></title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
	  <meta name="theme-color" content="#4b6584">
      <meta name="description" itemprop="description" content="_______________________">
      <meta name="keywords" itemprop="description" content="_______________________" />
      <meta name="url" itemprop="identifier" content="<?php echo BASE_URL;?>">
      <meta name="copyright" content="2020 ©  www.webmio.it">
      <meta name="twitter:card" content="summary" />
      <meta name="twitter:image" content="<?php echo BASE_URL;?>public/assets/img/logo.png" />
      <meta name="twitter:title" content="_______________________">
      <meta name="twitter:description" content="_______________________">
      <meta name="twitter:site" content="<?php echo BASE_URL;?>">
      <meta property="og:site_name" itemprop="name" content="_______________________">
      <meta property="og:image" content="<?php echo BASE_URL;?>public/assets/img/logo.png" />
      <meta property="og:url" itemprop="identifier" content="<?php echo BASE_URL;?>">
      <meta name="author" content="www.webmio.it">
      <meta property="og:title" itemprop="description" content="_______________________">
      <meta property="og:description" itemprop="disambiguatingDescription" content="_______________________">
      <meta property="og:keywords" itemprop="disambiguatingDescription" content="_______________________" />
      <link rel="alternate" hreflang="it" href="<?php echo BASE_URL;?>"/>
      <link href="<?php echo BASE_URL; ?>public/assets/css/bootstrap.min.css" rel="stylesheet" />
      <link href="<?php echo BASE_URL; ?>public/assets/css/style.css?ver=1.0.0" rel="stylesheet" />
      <link href="<?php echo BASE_URL; ?>public/assets/css/font-awesome.min.css" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
      <link href="<?php echo BASE_URL; ?>public/assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
      <link href="<?php echo BASE_URL; ?>public/assets/css/jquery.dataTables.min.css" rel="stylesheet" />
      <link rel="icon" href="<?php echo BASE_URL; ?>public/assets/img/favicon.ico" type="image/ico">
   </head>
   <body>
      <div class="wrapper">
      <div class="sidebar">
         <div class="sidebar-wrapper">
            <div class="logo">
               <a href="<?php echo(BASE_URL); ?>" class="simple-text">
               <img width="70%" src="<?php echo BASE_URL;?>public/assets/img/static1.squarespace.jpg">
               </a>
            </div>
            <ul class="nav">
               <li>
                  <a data-toggle="collapse" data-target="#importMenu" style="cursor: pointer;">
                     <i class="pe-7s-server"></i>
                     <p>Import</p>
                  </a>
                  <div id="importMenu" class="collapse in">
                     <ul class="nav">
                        <li><a style="color: white;" href="<?php echo BASE_URL;?>import"><small><i class="pe-7s-angle-right"></i> NEW</small></a> </li>
                        <li><a style="color: white;" href="<?php echo BASE_URL;?>import/importlist"><small><i class="pe-7s-angle-right"></i> LIST</small></a> </li>
                     </ul>
                  </div>
               </li>
               <hr>
               <li>
                  <a href="<?php echo(BASE_URL); ?>sysinfo">
                     <i class="pe-7s-tools"></i>
                     <p>Sysinfo</p>
                  </a>
               </li>
            </ul>
         </div>
      </div>
      <div class="main-panel">
      <nav class="navbar navbar-default navbar-fixed">
         <div class="container-fluid">
            <div class="navbar-header">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               </button>
               <a class="navbar-brand" href="<?php echo(BASE_URL); ?>">Home</a>
            </div>
            <div class="collapse navbar-collapse">
               <ul class="nav navbar-nav navbar-right">
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                     Welcome
                     <b class="caret"></b>
                     </a>
                     <ul class="dropdown-menu">
                        <li><a href="<?php echo BASE_URL.'import';?>">Import</a>
                        </li>
                        <li><a href="<?php echo BASE_URL.'import/importlist';?>">List</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?php echo BASE_URL;?>sysinfo">Sysinfo</a>
                        </li>
                     </ul>
                  </li>
               </ul>
            </div>
         </div>
      </nav>