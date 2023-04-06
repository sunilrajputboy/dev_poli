<div class="page-header-wrap">
    <h3>Add project group</h3>
    <a href="<?php echo BASE_URL.'projectsgroup'; ?>" class="btn cus-btn"> <i class="fa fa-chevron-left"></i>  Back</a>
    
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
                       <form action="javascript:void(0)" id="addProjectgroupForm" method="post"> 
                       <div class="project-dtails form-group">
   
  <div class="row">
  <div class="col-md-12">
      <div class="form-group">
  <label for="">Group name</label>
    <input type="text" class="form-control required" name="gname" id="gname" placeholder="Group name">
    <span class="error">Group name is required</span>
  </div>
  </div>
   <div class="col-md-12">
      <div class="form-group">
  <label for="">Description</label>
    <textarea class="form-control" name="description" id="description" placeholder="Description"></textarea>

  </div>
  </div>
  <div class="col-md-12">
       <div class="form-group">
    <label for="">Select client</label>
         <select class="form-control required" onchange="displayClientProject(this)"  name="cid" id="" >
                <option value="0">Select client</option>
     <?php  
      if($clients){
          foreach($clients as $row1){ ?>
        <option value="<?php echo $row1['id']; ?>" <?php //if($cid == $row1['id']){ echo 'selected'; } ?>><?php echo $row1['name']; ?></option>
      <?php } } ?>      
    </select>
     <span class="error">Client is required</span>
    </div>
    </div>
      <div class="col-md-12">
       <div class="form-group">
    <label for="">Select Projects</label>
         <select class="form-control js-select2clients required appendData" multiple  name="projects[]" id="" >
           <?php
           if($cproject){
              foreach($cproject as $cpro){
                  ?>
              <option value="<?php echo $cpro['id_project']; ?>"><?php echo $cpro['name']; ?></option>
                  <?php
              }
           }
           ?>
    </select>
        <span class="error">Projects is required</span>
    </div>
    </div>
  </div>
    </div>        
<div class="text-center">
    
  <button type="button" id="addProjectgroupbtn" name="submit" value="submit" class="btn cus-btn">Submit</button>
</div>
</form>
             
                    </div>
                </div>
            </div>
           
</div><!-- Panel Content -->
