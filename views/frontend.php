<html>
<head>
  <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no,height=device-height,target-densitydpi=device-dpi">
  <title>PoliMapper - Mapping policy data interactively 1</title>
  <html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
  <style type="text/css">
    body {
      padding: 0;
      margin: 0;
    }

    .topbar {
      position: fixed !important;
    }
  </style>
	<link rel="stylesheet" href="front-end/styles/main.8196df1e.css">
	<link rel="icon" type="image/png" href="favicon.ico">
	<link rel="manifest" href="front-end/img/icons/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<script>
		document.write('<meta property="og:url" content= "'+location.href+'" />');
	</script>
      <meta charset="UTF-8">
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="article" />
	<meta property="og:image" content="<?php echo BASE_URL; ?>front-end/img/polimapper-logo.jpg">
	<meta property="og:title" content="PoliMapper - Mapping policy data interactively"/>
	<meta property="og:image:width" content="1200" />
	<meta property="og:image:height" content="627" />
	<script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
  </head>

<body id="main-body">
  <!-- Insert page layout here -->
  <!-- <div class="polimapper-mobile"></div> -->
  <div class="polimapper-desktop"></div>
  <script  src="<?php echo BASE_URL; ?>front-end/scripts/vendor.f1d39f02.js"></script>
  <script src="<?php echo BASE_URL; ?>front-end/scripts/templates.6fa8f712.js"></script>
  <script src="<?php echo BASE_URL; ?>front-end/scripts/scripts.7afe9034.js"></script>
  <script src="https://connect.facebook.net/en_US/sdk.js"></script>
  <script src="https://smtpjs.com/v3/smtp.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
  <div id="fb-root"></div>
  <script>(function (d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=156615191071220";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
  <script>!function (d, s, id) { var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https'; if (!d.getElementById(id)) { js = d.createElement(s); js.id = id; js.src = p + '://platform.twitter.com/widgets.js'; fjs.parentNode.insertBefore(js, fjs); } }(document, 'script', 'twitter-wjs');</script>
  <script>(function (i, s, o, g, r, a, m) {
      i['GoogleAnalyticsObject'] = r; i[r] = i[r] || function () {
        (i[r].q = i[r].q || []).push(arguments)
      }, i[r].l = 1 * new Date(); a = s.createElement(o),
        m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g; m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-48230403-2', 'auto', { 'name': 'polimapper' });
    ga('polimapper.send', 'pageview');
    
    var newheight = $('body').height();
$('body').ready(function(){
     setTimeout(() => {
      
 newheight = $('body').height();
  window.parent.postMessage({ message: "getAppData",Height: $('body').height(), value: 'test val' }, "*");
}, 2000)
})

$('body').on('change', '#sel_con', function() {
  window.parent.postMessage({ message: "getAppData",Height: $('body').height(), value: 'test val2' }, "*");
});

window.addEventListener('resize', function(event) {
  window.parent.postMessage({ message: "getAppData",Height: $('body').height(), value: 'test val2' }, "*");
}, true);



$('body').on('click', '.closes', function() {
  window.parent.postMessage({ message: "getAppData",Height: newheight , value: 'test val2' }, "*");
});

    </script>