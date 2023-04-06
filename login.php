<?php 
header('location:login');
exit();
 include "session.php";
include "./dashboard/includes/dbconnection.php";
include "header.php";
if(isset($_COOKIE['email'])){
   $email = $_COOKIE['email'];
   $password = $_COOKIE['password'];
}else{
      $email = '';
   $password = '';
}
?>

  <title>Polimapper - Login page</title>
    <div class="auth-form">
        <div class="row">

            <div class="col-md-12">
                <div class="login-head">
                    <a href="/" title="">
                   <img src="../public/assets/img/polimapper-logo.png" alt="Polimapper" />
                   </a>
                </div>
                <div class="contact-sec">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="account-forms">
                                <form action="javascript:void(0)" method="POST" id="loginForm" novalidate>


                                    <div class="form-wrapper">
                                        <div class="login-title" style="padding-top:0;">
                    <h3>Login</h3>
                    <p>Welcome to Polimapper</p>

                </div><!-- Widget title -->
                                        <div class="message"></div>
                                        <div class="form-group row">


                                            <div class="col-md-12">
                                                <label for="">Email</label>
                                                <input class="form-control required is_email" value="<?php echo $email; ?>" type="email" placeholder="Enter Email Address" name="email">
                                               
                                                     <span class="error">Email is required</span>
                                            </div>

                                        </div>
                                        <div class="form-group row">

                                            <div class="col-md-12">
                                                <label for="">Password</label>

                                                <input type="password" 
                                                    placeholder="Enter Password" class="form-control required" name="password" value="<?php echo $password; ?>"
                                                     />
                                           <span class="error">Password is required</span>

                                            </div>

                                        </div>
                                        <div class="form-group rem-ber-fgot">


                                            <div class="custom-checkbox">
                                                <input id="remember-me" name="remember_me" type="checkbox" value="yes"
                                                    class="chkbx" <?php if($email != '' && $password != ''){ echo 'checked';
                                                    } ?>>
                                                <label for="remember-me">
                                                    <span></span> Remember me </label>
                                            </div>

                                            <a class="fgot-link" title="" href="forgot-password.php">Forgot
                                                Your Password</a>

                                        </div>
                                        <div class="form-group row">

                                            <div class="col-md-12">
<input type="hidden" placeholder="" class="" id="timeZone" name="timezone" value=""
                                                     />
                                                <button class="btn cus-btn btn-full" type="button" id="loginBtn" name="submit"
                                                    >Login</button>

                                            </div>

                                        </div>
                                        <div class="form-group btn-grps ">



                                            <a href="register.php" class="btn cus-btn btn-full register-link"
                                                title="">Register</a>
                                        </div>

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
        </div><!-- Main Content -->
        <!-- Vendor: Javascripts -->
        </div>
        <?php include "footer.php"; ?>
     