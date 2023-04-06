<div class="container">
 <div class="row">
  <div class="col-md-3"></div>
 <div class="col-md-6">
 <div class="login-box" style=" padding: 10px; margin-top: 150px; background: #3f44448a; border-radius: 5px; color: #FFF; ">
  <div class="login-logo" style=" font-size: 40px;  margin: 5px; text-align: center; ">
    <a href="<?php echo BASEURL; ?>" style="color:#c7416c">
	<strong>Alice's Garden</strong>
	</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"></p>
<?php alert(); ?>
    <form action="<?php echo site_url('users/login'); ?>" method="post">
      <div class="form-group has-feedback">
        <input name="email" type="email" class="form-control" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input name="pwd" type="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div><!-- /.login-box -->
</div>
 <div class="col-md-3"></div>
</div>
<!-- /.login-box -->

</div>