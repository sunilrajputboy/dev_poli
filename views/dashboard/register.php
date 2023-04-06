<!DOCTYPE html>
<html>
<head>
    <!-- Meta-Information -->
    <title><?php echo BASE_TITLE; ?> | Register page</title>
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
        <div class="login-head">
            <a href="/" title="">
                   <img src="../public/assets/img/polimapper-logo.png" alt="Polimapper" />
                   </a>
                </div>
        <div class="contact-sec contact-sec-register">
            <div class="row">
                <div class="col-md-12">

                    <div class="account-forms">
                        <form action="javascript:void(0)" method="post" id="adminRegisterForm" novalidate>
                            <div class="form-wrapper">
                                 <div class="login-title" style="padding-top:0;">
                    <h3>Register</h3>
                    <p>Welcome to Polimapper</p>
                </div><!-- Widget title -->
                                 <div class="message"></div>
                                <div class="step1">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <label for="">Full Name</label>
                                        <input class="form-control required" type="text" placeholder="Enter Name"
                                            value="" name="name" />
                                        <span class="error">Name is required</span>
                                    </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <label for="">Email </label>
                                        <input class="form-control required is_email" value="" type="email"
                                            placeholder="Enter Email Address" name="email" />

                                        <span class="error">Email is required</span>
                                    </div>
</div>
                                </div>


                               

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <label for="">Password</label>
                                        <input class="form-control required is_password" id="password"  type="password"
                                            placeholder="Enter Password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" />
                                        <span class="error">Password is required</span>
                                        </div> 
                             <div id="message">

        <h3>Password must contain the following:</h3>

        <span id="letter" class="invalid">A <b>lowercase</b> letter</span>

        <span id="capital" class="invalid">A <b>capital (uppercase)</b> letter</span>

        <span id="number" class="invalid">A <b>number</b></span>

        <span id="length" class="invalid">Minimum <b>8 characters</b></span>

      </div>
                                    </div>
                                      <div class="col-md-6">
                                          <div class="form-group">
                                        <label for="">Confirm password</label>
                                        <input class="form-control required is_cpassword" value="" type="password"
                                            placeholder="Enter Password" name="cpassword" />
                                        <span class="error">Confirm password is required</span>
</div>
                                    </div>
                                    </div>
                                    <div class="row">
                                     <div class="col-md-6">
                                         <div class"form-group">
                                        <label for="">Phone No.</label>

                                        <input class="form-control required" value="" type="number"
                                            placeholder="Enter Phone No." name="phone" />
                                        <span class="error">Phone no. is required</span>
</div>
                                    </div>

                                </div>
        </div>
<div class="step2" style="display:none">
<div class="row">
    
    
     <div class="col-md-6">
         <div class="form-group">
         <h4>Company Detail</h4>
         </div>
     </div>
</div>
<div class="row">
                                     <div class="col-md-6">
                                         <div class="form-group">
                                        <label for="">Company name</label>
                                        <input class="form-control required" type="text" placeholder="Enter Compay Name"
                                            value="" name="cname" />
                                        <span class="error">Company name is required</span>
                                        </div>
                                    </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Company email </label>
                                        <input class="form-control required is_email" value="" type="email"
                                            placeholder="Enter Email Address" name="cemail" />

                                        <span class="error">Company Email is required</span>
                                        </div>
                                    </div>
                                </div>
<div class="row">
                                     <div class="col-md-6">
                                         <div class="form-group">
                                        <label for="">Company contact no.</label>

                                        <input class="form-control required" value="" type="number"
                                            placeholder="Enter Company Phone No." name="cphone" />
                                            <span class="error">Company Phone no. is required</span>
                                    </div>
</div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                        <label for="">Select package</label>
                                        <select class="form-control" id="package" name="package" style="text-transform:capitalize;">
                                        
                                        </select>
                                        </div>
                                    </div>
                                </div>

</div>
<div class="text-center m-t-20">
    <button type="button" id="prevBtn" class="btn register-link" onclick="nextPrev(-1)">Previous</button>
<button type="button" class="btn register-link" id="nextBtn" onclick="nextPrev(1)">Next</button>
<button type="submit" id="RegisterBtn" class="btn cus-btn" style="display:none">Register</button>

</div>
<div class="text-center m-t-20">
    <p>Do you have an account? <a href="<?php echo BASE_URL; ?>login">Login Here</a></p>
</div>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
</div><!-- Account Sec -->
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
    
function nextPrev(val){
    if(val == 1){
     var submit_form = true;
    $('.step1 .required').each(function(){
   
        if($(this).val() == ''){
            $(this).siblings('.error').show();
          submit_form = false;  
        }else if($(this).hasClass('is_email') && !ValidateEmail($(this).val())){
           
                 $(this).siblings('.error').html('Email is Invalid');
                $(this).siblings('.error').show();
             submit_form = false; 
        }else if($(this).hasClass('is_password') && !CheckPassword($(this).val())){
            
             $(this).siblings('.error').show();
              $(this).siblings('.error').html('Password Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters');
                submit_form = false; 
        }else if($(this).hasClass('is_cpassword') && !ValidatePassword($(this).val())){
             $(this).siblings('.error').show();
              $(this).siblings('.error').html('Password and confirm password does not match');
                submit_form = false; 
        }
    });
        if(submit_form){
        $('.step1').css('display','none');
     $('.step2').css('display','block');
     $('#nextBtn').hide();
      $('#prevBtn').show();
      $('#RegisterBtn').show();
        }
    }else{
         $('.step1').css('display','block');
     $('.step2').css('display','none');
    $('#nextBtn').show();
    $('#RegisterBtn').hide();
    }
    }
    
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
    $('#RegisterBtn').click(function(){

var submit_form = true;
    $('.required').each(function(){
   
        if($(this).val() == ''){
            $(this).siblings('.error').show();
          submit_form = false;
          
        }else if($(this).hasClass('is_email') && !ValidateEmail($(this).val())){
                 $(this).siblings('.error').html('Email is Invalid');
                $(this).siblings('.error').show();
             submit_form = false; 
        }
        else{
            
             $(this).siblings('.error').hide();
        }
            
    });
    if(submit_form){
      
      formId = '#adminRegisterForm';
var formData = new FormData($(formId)[0]);

var redirect = "<?php echo BASE_URL; ?>login";
  $.ajax({
     url: '<?php echo BASE_URL; ?>register/UserRegister',
    	data: formData,
		type: 'POST',
		processData: false,
		contentType: false,
success: function(response) {
     var res = JSON.parse(response);
if(res.success == 0){
    $('.message').html('<div class="alert alert-danger">' + res.msg + '</div>');
}else{
      $('.message').html('<div class="alert alert-success">' + res.msg + '</div>');
       setTimeout(function () {
                    location.href = res.redirect_url;
                 }, 3000);
}
}
});
}
});

$(document).ready(function() {
    $.ajax({
     url: '<?php echo BASE_URL; ?>register/getPackages',
    type: 'post',
success: function(res) {
// console.log(res);
$('#package').html(res);
}
});
});

</script>
</body>
</html>