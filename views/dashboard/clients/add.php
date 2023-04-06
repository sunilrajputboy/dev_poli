<div class="page-header-wrap">
    <h3>Add Clients</h3>
	<?php if($_SESSION['uid']==1){ ?>
    <a href="<?php echo BASE_URL; ?>clients" class="btn cus-btn"> <i class="fa fa-chevron-left"></i>  Back</a>
	<?php }else{ ?>
	 <a href="<?php echo BASE_URL; ?>clients" class="btn cus-btn"> <i class="fa fa-chevron-left"></i>  Back</a>
	<?php } ?>
</div>
            <div class="widget">
                <div class="table-area">
                    <div class="widget-title">
                       <div class="alert alert-success" id="sucessMessage" style="display:none">
                            <button class="close-btn">x</button>
                            <p id="suc_msg"></p>
                       </div>
                       <div class="alert alert-danger" id="errorMessage" style="display:none">
                            <button class="close-btn">x</button>
                            <p id="err_msg"></p>
                       </div>
                    </div>
                    <div class="addpackages">
                       <form action="<?php echo BASE_URL; ?>clients/insert" id="addForm" method="post">  
                       <div class="project-dtails form-group">
  <div class="row">
  <div class="col-md-6">
      <div class="form-group">
  <label for="">Name</label>
    <input type="text" class="form-control" name="name" id="name" placeholder="Name">
    </div>
  </div>
    <div class="col-md-6">
        <div class="form-group">
  <label for="">Phone</label>
    <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone">
    </div>
  </div>
  </div>
  <div class="row">
    <div class="col-md-6">
        <div class="form-group">
  <label for="">Email</label>
    <input type="email" class="form-control" name="email" id="email" placeholder="Email">
    </div>
  </div>
  <div class="col-md-6">
      <div class="form-group">
    <label for="">Select Package</label>
         <select class="form-control"  name="package">
             <option disabled selected>Choose Package</option>
            <?php if (!empty($allPackages)) { foreach($allPackages as $row){
           if($row['name'] != null){
          ?>
    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
    <?php } } } ?>      
    </select>
    </div>
    </div>
  </div>
  </div>
<div class="text-center">
     <button type="submit" name="submit" value="submit" class="btn cus-btn">Submit</button>
</div>
</form>
             
                    </div>
                </div>
            </div>
</div><!-- Panel Content -->
<script>
   var sucess_msg = localStorage.getItem("message_sucess");
   var error_msg = localStorage.getItem("message_error");
    if(sucess_msg != null){
        document.getElementById("addForm").reset();
         document.getElementById("sucessMessage").style.display = 'block';
 document.getElementById("suc_msg").innerHTML = sucess_msg;
     
    }else if(error_msg != null){
        document.getElementById("addForm").reset();
        document.getElementById("errorMessage").style.display = 'block';
 document.getElementById("err_msg").innerHTML = error_msg;
         
    }
    localStorage.removeItem("message_sucess");
    localStorage.removeItem("message_error");
</script>