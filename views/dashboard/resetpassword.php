  <!DOCTYPE html>
<html>
<head>
    <!-- Meta-Information -->
    <title><?php echo BASE_TITLE; ?> | Reset Password page</title>
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
                         
                                                <h3>Reset your password?</h3>
                                                
                                            </div>
                            
                        <div class="contact-sec">
                            
                          
                            
                            <div class="row">
                                <div class="col-md-12">  
                                  
                                    <div class="account-forms">
                                         <form action="javascript:void(0)" method="POST" id="resetForm" novalidate>
                                            
                                            <div class="form-wrapper">
                                                
                                           <div class="message"></div>
                                         
                                           <div class="form-group row">
    
                                <div class="col-md-12">
                                  <label for="">New password</label>
 
                                 <input class="form-control required" name="password" id="pass"
                                  type="password" placeholder="Enter new password" />
                                  <span class="error">Enter new password</span>
                                                        
                                                       
                                </div> 
    
                            </div>
                           
                            <div class="password"></div>
                             <div class="form-group row">
    
                                <div class="col-md-12">
                                <input type="hidden" name="id" id="userid" value="<?php echo $_GET['id']; ?>" />
                                  <input class="btn cus-btn btn-full" name="reset" type="submit" id="resetBtn" value="Reset Password" />
                        
                                </div> 
    
                            </div>
                            
                           <div class="form-group btn-grps ">
                                                     
                                                      
                                                       
                                                        <a href="<?php echo BASE_URL;?>login" class="btn cus-btn btn-full register-link" title=""><i class="fa fa-chevron-left"></i> <span>Back to login</span></a>
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
  $('#resetBtn').click(function(){

var submit_form = true;
    $('.required').each(function(){
   
        if($(this).val() == ''){
            $(this).siblings('.error').show();
           submit_form = false;  
        }
        else if(!CheckPassword($(this).val())){
             $(this).siblings('.error').show();
             $(this).siblings('.error').html("Password Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters");
             submit_form = false;
        }else{
             $(this).siblings('.error').hide(); 
             submit_form = true;
        }
            
    });
    if(submit_form){
        
     		var urls = "<?php echo BASE_URL; ?>forgotpassword/newpass";
			var password = $("#pass").val();
			var id = $("#userid").val();
		$.ajax({
            url: urls,
            type: 'POST',
            data: {'password':password,'id': id},
       
            success: function(response){
                var res = JSON.parse(response);
        if(res.success == 1){
			location.href = res.redirect_url;
        }
       
             }

         });
     
}
    
});
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

