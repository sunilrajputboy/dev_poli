
<div class="page-header-wrap">
    <h3>Add Users</h3>
    <a href="<?php echo BASE_URL ?>users/" class="btn cus-btn"> <i class="fa fa-chevron-left"></i>  Back</a>
</div>
            <div class="widget">
                <div class="table-area">
                    <div class="widget-title">
                      <div class="message">
                       
                      </div>
                    </div>
                    <div class="addpackages">
                       <form action="javascript:void(0)" id="addUserForm" method="post">    
                       <div class="project-dtails form-group">
  <div class="row">
  <div class="col-md-12">
      <div class="form-group">
  <label for="">Name</label>
    <input type="text" class="form-control" name="name" id="name" placeholder="Name">
  </div>
  </div>
  </div>
    <div class="row">
         <div class="col-md-6">
             <div class="form-group">
            <label for="">Email</label>
            <input type="email" class="form-control required is_email" name="email" id="email" placeholder="Email">
            <span class="error">Email is required*</span>
            </div>
        </div>
        <div class="col-md-6">
              <div class="form-group">
            <label for="">Phone</label>
            <input type="number" class="form-control" name="phone" id="phone" placeholder="Phone" min="0">
            </div>
        </div>
  </div>
  <div class="row">
         <div class="col-md-12">
               <div class="form-group">
            <label for="">Password</label>
            <input type="password" class="form-control is_password required" name="password" id="password" placeholder="Password">
            <span class="error">Password is required*</span>
            </div>
        </div>
          <div class="col-md-12">
                <div class="form-group">
               <!--<label for="">Generate Password</label>-->
             <button class="generatePassword btn register-link" onclick="randomPassword(8)">
                Generate password
            </button>
            </div>
        </div>
      </div>
  <div class="row">
    <div class="col-md-12">
          <div class="form-group">
    <label for="">Select clients</label>
         <select class="form-control js-select2clients" multiple="multiple" placeholder="Select clients"  name="client[]">
          <?php
        if(!empty($clients)){
       foreach($clients as $row ) {
          ?>
    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
   <?php } } ?>      
    </select>
    </div>
    </div>
  </div>
  </div>
  <div class="text-center">
      <button type="submit" name="submit" value="submit" class="btn cus-btn" id="addUserBtn">Submit</button>
  </div>
</form>
             
                    </div>
                </div>
            </div>
</div><!-- Panel Content -->