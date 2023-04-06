<?php
$cid = $_SESSION['cid'];
if($projectData){
$countRows=count($projectData);
$no_allowed_maps = explode(",",$pdata['no_allowed_maps']);

   if($pdata['no_allowed_projects'] != 'Unlimited' && $pdata['no_allowed_projects'] != null){
if($countRows >= $pdata['no_allowed_projects']){
  ?>
  <script>
      location.href = "/dashboard/projects/";
  </script>
<?php
}
}
}
?>

<div class="page-header-wrap">
    <h3>Add project</h3>
    <a href="<?php echo BASE_URL ?>projects/" class="btn cus-btn"> <i class="fa fa-chevron-left"></i>  Back</a>
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
                       <form action="javascript:void(0)" id="addProjectForm" method="post">   
                       <div class="project-dtails form-group">
                        <div class="form-group row">
    <div class="col-md-12">
    <label for="">Select Map</label>
    <select class="form-control required" placeholder="Select Map" name="map" id="no_allowed_map" >
       <option value="">Select Map</option>
		  <?php if(!empty($map_templates)){ foreach($map_templates as $map_cat){
			  $mapTemplates=$map_cat['template_list'];
		   ?>
		   <optgroup label="<?php echo $map_cat['category_name']; ?>">
		   <?php
			  if($mapTemplates){
			   foreach($mapTemplates as $row){
				if(in_array($row['map_name'], $no_allowed_maps) || in_array($row['id_map_templates'], $no_allowed_maps)){
				  ?>
			<option value="<?php echo $row['id_map_templates']; ?>"><?php echo $row['map_name']; ?></option>
			<?php } } } ?>
			</optgroup>   
			<?php } }  ?> 
    </select>
    <span class="error">Map is required</span>
    </div>
  </div>
  <div class="form-group row">
  <div class="col-md-12">
  <label for="">Project Name</label>
    <input type="text" class="form-control required" name="pname" id="pname" placeholder="Project Name">
    <span class="error">Project name is required</span>
  </div>
  </div>
</div>
<div class="text-center">
    <button type="button" id="addProject" name="submit" value="submit" class="btn cus-btn">Submit</button>
</div>
</form>
             
                    </div>
                </div>
            </div>
           
</div>
<!-- Panel Content -->
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