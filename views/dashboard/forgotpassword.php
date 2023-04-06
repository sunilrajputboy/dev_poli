  <!DOCTYPE html>
<html>
<head>
    <!-- Meta-Information -->
    <title><?php echo BASE_TITLE; ?> | Forgot Password page</title>
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
                     <div class="login-title">
                                                <h3>Forget your password?</h3>
                                                
                                            </div>
                            
                        <div class="contact-sec">
                            
                          
                            
                            <div class="row">
                                <div class="col-md-12">  
                                  
                                    <div class="account-forms">
                                        <form action="javascript:void(0)" method="post" id="forgotForm" novalidate>

                                            
                                            <div class="form-wrapper">
                                                
                                                   <div class="message"></div>
                                                 <div class="form-group row">
    
                                <div class="col-md-12">
                                     <label for="">Email</label>
 
                                 <input class="form-control required is_email" name="email" type="text" placeholder="Enter Your Email" />
                         
                                                            <span class="error">Email is required</span>
                                                        
                                </div> 
    
                            </div>
                            
                             <div class="form-group row">
    
                                <div class="col-md-12">
                                
                                  <input class="btn cus-btn btn-full" name="submit" id="forgotBtn" type="submit" value="Recover Password" />
                        
                                </div> 
    
                            </div>
                            
                           <div class="form-group btn-grps ">
                                                     
                                                      
                                                       
                                                        <a href="<?php echo BASE_URL; ?>login" class="btn cus-btn btn-full register-link" title=""><i class="fa fa-chevron-left"></i> <span>Back to login</span></a>
                                                     </div>
                            
                                            </div>
                                        </form>
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

    function forgotDatafun(formId, action_url, responseDiv = '') {
formId = '#' + formId;
var formData = new FormData($(formId)[0]);


$.ajax({
url: action_url,
data: formData,
type: 'POST',
processData: false,
contentType: false,
success: function(res) {
var res = jQuery.parseJSON(res);
// console.log(res)
if (res.success == 1) { $('.' + responseDiv).html('<div class="alert alert-success">' + res.msg + '</div>'); } else {
$('.' + responseDiv).html('<div class="alert alert-danger">' + res.msg + '</div>');
setTimeout(function() { $('.' + responseDiv).html(''); }, 4000);
}
if(res.redirect_url != ''){
    if(res.email != undefined && res.password != undefined){
    setCookie('email',res.email,10);
     setCookie('password',res.password,10);
    }
location.href = res.redirect_url;
}
},
error: function() {
$(".loader").css("transform", 'scale(0)');
alert('An error has occurred');
}
});
}




    $('#forgotBtn').click(function(){

var submit_form = true;
    $('.required').each(function(){
   
        if($(this).val() == ''){
            $(this).siblings('.error').show();
          submit_form = false;  
        }else if($(this).hasClass('is_email') && !ValidateEmail($(this).val())){
           
                 $(this).siblings('.error').html('Email is Invalid');
                $(this).siblings('.error').show();
             submit_form = false; 
        }else{
            
             $(this).siblings('.error').hide();
        }
            
    });
    if(submit_form){
     forgotDatafun('forgotForm','<?php echo BASE_URL; ?>forgotpassword/forgotfunctions','message');
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


</script>
