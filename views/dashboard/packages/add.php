<div class="page-header-wrap">
    <h3>Add packages</h3>
    <a href="<?php echo BASE_URL; ?>packages/" class="btn cus-btn"> <i class="fa fa-chevron-left"></i> Back</a>
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
   <form action="<?php echo BASE_URL; ?>packages/insertpackage" id="addForm" method="post"> 
                       <div class="project-dtails form-group">
  <div class="row">
	  <div class="col-md-12">
		  <div class="form-group">
		  <label for="">Package Name</label>
			<input type="text" class="form-control required" name="name" id="name" placeholder="Package Name" required>
		  </div>
	  </div>
  </div>
  <div class="row">
        <div class="col-md-6">
            <div class="form-group">
            <label for="">No of allowed user</label>
            <input type="number" min="0"  class="form-control" name="no_allowed_user" id="no_allowed_user" placeholder="No of allowed user">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
            <label for="">No of allowed project</label>
            <input type="number" min="0"  class="form-control" name="no_allowed_projects" id="no_allowed_projects" placeholder="No of allowed projects">
            </div>
        </div>
  </div>
        <div class="row">
            <div class="form-group">
          <div class="col-md-6 toggleWrapper m-l-0">
  <label for="">Unlimited user</label>  
  <input type="checkbox" name="unlimited_user" id="unlimited_user" class="unlimited" value="Unlimited"/>
  <label for="unlimited_user" class="toggle"><span class="toggle__handler"></span></label>
  </div>
 <div class="col-md-6 toggleWrapper m-l-0">
     <div class="form-group">
  <label for="">Unlimited project</label>  
  <input type="checkbox" name="unlimited_pro" id="unlimited_pro" class="unlimited" value="Unlimited"/>
  <label for="unlimited_pro" class="toggle"><span class="toggle__handler"></span></label>
  </div>
 </div>
</div>
</div>
    <div class="row">
    <div class="col-md-12">
    <div class="form-group">
    <label for="">Select Maps</label>
    <select class="form-control js-select2 ad-package" multiple="multiple" name="no_allowed_map[]" id="no_allowed_map" required>
   <?php if(!empty($maptemplates)){ foreach($maptemplates as $map_cat){ $map_templates=$map_cat['template_list']; ?>
    <optgroup label="<?php echo $map_cat['category_name']; ?>">
	<?php if(!empty($map_templates)){ foreach($map_templates as $row){ ?>
    <option value="<?php echo $row['id_map_templates']; ?>"><?php echo $row['map_name']; ?></option>
	<?php } } ?>
	 </optgroup>
   <?php } } ?>
    </select>
    </div>
    </div>
  </div>
    <div class="row">    
 <div class="col-md-6 toggleWrapper m-l-0">
     <div class="form-group">
  <label for="">Enable Logo</label>  
  <input type="checkbox" name="is_logo" id="dndo" class="dn" value="yes"/>
  <label for="dndo" class="toggle"><span class="toggle__handler"></span></label>
  </div>
 </div>
<div class="col-md-6 toggleWrapper m-l-0">
    <div class="form-group">
      <label for="">Enable Charts</label>  
  <input type="checkbox" name="is_charts" id="charts" class="dn" value="yes"/>
  <label for="charts" class="toggle"><span class="toggle__handler"></span></label>
  </div>
 </div>  
 </div>
 <div class="row"> 
 <div class="col-md-6 toggleWrapper m-l-0">
     <div class="form-group">
        <label for="">Enable Fonts</label>  
  <input type="checkbox" name="is_fonts" id="fonts" class="dn" value="yes"/>
  <label for="fonts" class="toggle"><span class="toggle__handler"></span></label>
  </div>
 </div>
 <div class="col-md-6 toggleWrapper m-l-0">
     <div class="form-group">
        <label for="">Enable Email MP</label> 
  <input type="checkbox" name="is_email_mp" id="email_mp" class="dn" value="yes"/>
  <label for="email_mp" class="toggle"><span class="toggle__handler"></span></label>
  </div>
 </div>   
 </div>
  <div class="row"> 
 <div class="col-md-6 toggleWrapper m-l-0">
     <div class="form-group">
        <label for="">Enable social share</label> 
  <input type="checkbox" name="is_social_share" id="social_share" class="dn" value="yes"/>
  <label for="social_share" class="toggle"><span class="toggle__handler"></span></label>
  </div>
 </div> 
  <div class="col-md-6 toggleWrapper m-l-0">
      <div class="form-group">
        <label for="">Enable email share</label> 
  <input type="checkbox" name="is_email_share" id="email_share" class="dn" value="yes"/>
  <label for="email_share" class="toggle"><span class="toggle__handler"></span></label>
  </div>
 </div> 
 </div>
   <div class="row"> 
 <div class="col-md-6 toggleWrapper m-l-0">
     <div class="form-group">
        <label for="">Enable tweet MP</label> 
  <input type="checkbox" name="is_tweet_mp" id="tweet_mp" class="dn" value="yes"/>
  <label for="tweet_mp" class="toggle"><span class="toggle__handler"></span></label>
  </div>
 </div> 
 <div class="col-md-6 toggleWrapper m-l-0">
							<div class="form-group">
								<label for="">Hide Branding </label>
								<input type="checkbox" name="hide_branding" id="hide_branding" class="dn" value="yes"/>
								<label for="hide_branding" class="toggle"><span class="toggle__handler"></span></label>
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