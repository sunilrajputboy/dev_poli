<!DOCTYPE html>
<html>
<head>
    <!-- Meta-Information -->
    <title><?php echo BASE_TITLE; ?> | Login page</title>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo BASE_URL; ?>/public/web/images/favicon.jpg"/>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/web/css/bootstrap.min.css">
    <!-- Our Website CSS Styles -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/web/css/icons.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
	 <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/web/css/richtext.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/web/css/main.css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/web/css/responsive.css">
</head>
    <div class="auth-form">
        <div class="row">
            <div class="col-md-12">
                <div class="login-head">
                    <a href="<?php echo BASE_URL; ?>" title="">
                   <img src="<?php echo BASE_URL; ?>/public/assets/img/polimapper-logo.png" alt="Polimapper" />
                   </a>
                </div>
                <div class="contact-sec">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="account-forms">
                       <form action="javascript:void(0)" method="POST" id="loginForm" >
                          <div class="form-wrapper">
                           <div class="login-title" style="padding-top:0;">
                    <h3 class="vs">Login</h3>
                    <p>Welcome to Polimapper</p>

                </div><!-- Widget title -->
                                        <div class="message"></div>
<div class="form-group row">
	<div class="col-md-12">
		<label for="">Email</label>
		<input class="form-control required is_email" value="<?php if(isset($_COOKIE["member_username"])){ echo $_COOKIE["member_username"]; } ?>" type="email" placeholder="Enter Email Address" name="email">
			 <span class="error">Email is required</span>
	</div>
</div>
<div class="form-group row">
	<div class="col-md-12">
		<label for="">Password</label>
		<input type="password"  placeholder="Enter Password" class="form-control required" name="password" value="<?php if(isset($_COOKIE["member_password"])){ echo $_COOKIE["member_password"]; } ?>" />
   <span class="error">Password is required</span>
	</div>
</div>
<div class="form-group rem-ber-fgot">
	<div class="custom-checkbox">
		<input id="remember-me" name="remember_me" type="checkbox" value="yes" class="chkbx" <?php if(isset($_COOKIE["member_username"]) && isset($_COOKIE["member_username"])){ echo 'checked'; } ?>>
		<label for="remember-me">
			<span></span> Remember me </label>
	</div>
	<a class="fgot-link" title="" href="<?php echo BASE_URL; ?>forgotpassword">Forgot Your Password</a>
</div>

<?php if(isset($_SESSION['unblock_time']) && !empty($_SESSION['unblock_time'])){ $remaining_time=date('i',strtotime($_SESSION['unblock_time']));  ?>
			<div class="form-group row">
				<div class="col-md-12">
				  <p id="demo"></p>
				</div>
			</div>
<?php }else{ ?>
			<div class="form-group row">
				<div class="col-md-12">
				   <input type="hidden" placeholder="" class="" id="timeZone" name="timezone" value=""/>
				   <button class="btn cus-btn btn-full" type="submit" id="loginBtn" name="submit">Login</button>
				</div>
			</div>
<?php } ?>
			
                                        <!--<div class="form-group btn-grps " style="display:none;">-->
                                        <!--    <a href="<?php // echo BASE_URL; ?>register" class="btn cus-btn btn-full register-link"-->
                                        <!--        title="">Register</a>-->
                                        <!--</div>-->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<script>
var timezone_offset_minutes = new Date().getTimezoneOffset();
timezone_offset_minutes = timezone_offset_minutes == 0 ? 0 : -timezone_offset_minutes;
document.getElementById('timeZone').value = timezone_offset_minutes;
</script>
<?php if(isset($_SESSION['unblock_time']) && !empty($_SESSION['unblock_time'])){ $remaining_time=date('i',strtotime($_SESSION['unblock_time']));  ?>
<script>
<?php $date=date('Y-m-d H:i:s',strtotime($_SESSION['unblock_time'])) ?>
// Set the date we're counting down to
var countDownDate = <?php echo strtotime($_SESSION['unblock_time']); ?>* 1000;
var now = <?php echo time(); ?>* 1000;
// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  now = now + 1000;

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  document.getElementById("demo").innerHTML = minutes + "m " + seconds + "s ";

  // If the count down is finished, write some text
  if (distance <= 0) {
    clearInterval(x);
    //document.getElementById("demo").innerHTML = "EXPIRED";
	location.href = '<?php echo BASE_URL; ?>/login/restartLogin';
  }
}, 1000);
</script>
<?php } ?>
        </div><!-- Main Content -->
        <!-- Vendor: Javascripts -->
        </div>
<!-- Vendor: Javascripts -->
<script type="text/javascript" src="<?php echo BASE_URL; ?>/public/web/js/jquery-2.1.3.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>/public/web/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
<!-- Our Website Javascripts -->
<script type="text/javascript" src="<?php echo BASE_URL; ?>/public/web/js/app.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>/public/web/js/main.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>/public/web/js/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>/public/web/js/dataTables.rowReorder.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>/public/web/js/dataTables.editor.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>/public/web/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>/public/web/js/jquery.richtext.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>/public/web/js/common.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>/public/web/js/sr.js"></script>
<script src="<?php echo BASE_URL; ?>/public/assets/js/sweetalert2.all.min.js"></script>
<script> 
$(document).ready(function(){ $('[data-toggle="tooltip"]').tooltip(); });

$('#loginBtn').click(function() {
    var submit_form = true;
    $('.required').each(function() {
        if ($(this).val() == '') {
            $(this).siblings('.error').show();
            submit_form = false;
        } else if ($(this).hasClass('is_email') && !ValidateEmail($(this).val())) {
            $(this).siblings('.error').html('Email is Invalid');
            $(this).siblings('.error').show();
            submit_form = false;
        } else {

            $(this).siblings('.error').hide();
        }

    });
    if (submit_form) {
        saveData('loginForm', '/login/signin/','message');
    }

});
function ValidateEmail(email) 
{
 if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(email))
  {
    return true;
  }
    
    return false;
}

function ValidatePassword(cpass) 
{
    var pass = $('#password').val();
  
 if (pass == cpass)
  {
    return true;
  }
    
    return false;
}

function CheckPassword(pass) 
{ 
var passw = '(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}';
var l = /[a-z]/g;
var u = /[A-Z]/g;
var n = /[0-9]/g;
 if(pass.match(l) && pass.match(u) && pass.match(n) && pass.length >= 8 ){
    return true;
 }
else{ 
return false;
}
}
</script>
</body>
</html>