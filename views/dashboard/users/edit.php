<div class="page-header-wrap">
    <h3>Edit Users</h3>
    <a href="<?php echo BASE_URL ?>users/" class="btn cus-btn"> <i class="fa fa-chevron-left"></i>Back</a>
</div>
         <div class="widget">
                <div class="table-area">
                    <div class="widget-title">
                      <div class="message">
                          
                      </div>
                    </div>
                    <div class="addpackages">
                       <form action="javascript:void(0)" id="updateUserForm" method="post" autocomplete="off">   
                       <div class="project-dtails form-group">
  <div class="row">
  <div class="col-md-12">
      <div class="form-group">
  <label for="">Name</label>
    <input type="text" class="form-control <?php if($data['name'] != ''){echo 'value-filled'; } ?>" name="name" id="name" placeholder="Name" value="<?php echo $data['name']; ?>">
    </div>
  </div>
  </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
            <label for="">Email</label>
            <input type="email" class="form-control required is_email <?php if($data['email'] != ''){echo 'value-filled'; } ?>" name="email" id="email" placeholder="Email" value="<?php echo $data['email']; ?>">
            <span class="error">Email is required*</span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
            <label for="">Phone</label>
            <input type="number" class="form-control <?php if($data['phone'] != ''){echo 'value-filled'; } ?>" name="phone" id="phone" placeholder="Phone" value="<?php echo $data['phone']; ?>">
        </div>
      </div>
  </div>
  <div class="row">
         <div class="col-md-12">
             <div class="form-group">
            <label for="">Password</label>
             <input type="hidden" name="old_password" value="<?php echo $data['password']; ?>">
            <input type="password" class="form-control place-holder is_password" name="password" id="password" placeholder="*****" value="" autocomplete="false">
            <span class="passworderror error">Password is required*</span>
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
         <select class="form-control required ad-client <?php if($data['clients'] != ''){echo 'value-filled'; } ?> js-select2"  multiple="multiple"  name="client[]" >
           
              <?php 
            if(!empty($clients)){
       foreach($clients as $row) {
          ?>
    <option value="<?php echo $row['id']; ?>" <?php 
 
    if($data['clients'] != null){
        
        foreach(unserialize($data['clients']) as $c){
    if($c == $row['id']){  echo 'selected'; } } }
    ?>><?php echo $row['name']; ?></option>
   <?php } } ?>      
    </select>
    </div>
    </div>
            </div>
            </div>
   <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
<div class="text-center">
      <button type="submit" name="submit" value="submit" class="btn cus-btn" id="updateUserBtn">Update</button>
</div>
</form>
             
                    </div>
                </div>
            </div>