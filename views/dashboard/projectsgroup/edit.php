<div class="page-header-wrap">
	<h3>Edit Project group</h3>
	<a href="<?php echo BASE_URL.'projectsgroup'; ?>" class="btn cus-btn"> <i class="fa fa-chevron-left"></i> Back</a>
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
		    <div class="row">
			<div class="col-md-6">
	 <form action="javascript:void(0)" id="updateProjectgroupForm" method="post"> 
	 <?php
	 foreach($dataProjectgroup as $data){
	 ?>
     <div class="project-dtails form-group">

									
  <div class="row">
  		<div class="col-md-12">
				<div class="form-group">
					<!--<div class="pro-heading">-->
					<!--<h4>Unique Url</h4>-->
				<!--</div>-->
				<!--<span class="input-group-text my-badge" id="unique_urlS"><?php //echo BASE_URL ?>projectgroup/<?php //echo $data['unique_url']; ?></span>-->
				</div>
				<div class="form-group">
  <label for="">Unique Url</label>
					<input type="hidden" name="project_group_id" value="<?php echo $data['id']; ?>">
				<input type="text" class="form-control required" onkeyup="checkinique(this.value,'<?php echo $data['id']; ?>')" name="unique_url" id="unique_url" placeholder="Unique URL" value="<?php echo $data['unique_url']; ?>">
				<span class="unique-error error-msg-span"></span>
				<span class="error">Unique url cant be empty</span>
			</div>
		</div>
  <div class="col-md-12">
      <div class="form-group">
  <label for="">Group name</label>
    <input type="text" class="form-control required" name="gname" id="gname" placeholder="Group name" value="<?php echo $data['name']; ?>">
    <span class="error">Group name is required</span>
  </div>
  </div>
  
   <div class="col-md-12">
      <div class="form-group">
  <label for="">Description</label>
    <textarea class="form-control" name="description" id="description" placeholder="Description"><?php echo $data['description']; ?></textarea>

  </div>
  </div>
  <div class="col-md-12">
       <div class="form-group">
    <label for="">Select client</label>
         <select class="form-control required" onchange="displayClientProject(this)"  name="cid" id="" >
     <?php
         foreach($users as $udata){
        $clientData =  $udata['clients'];
     }
      if($clients){
       foreach($clients as $row1){
        if($clientData != null){
          if(in_array($row1['id'],unserialize($clientData))){
              if($row1['is_suspended'] != 1){
       ?>
    <option value="<?php echo $row1['id']; ?>" <?php if($data['client'] == $row1['id']){ echo 'selected'; } ?>><?php echo $row1['name']; ?></option>
   <?php } }  } } } ?>      
    </select>
    </div>
    </div>
      <div class="col-md-12">
       <div class="form-group">
    <label for="">Select Projects</label>
         <select class="form-control js-select2clients required appendData" multiple  name="projects[]" id="" >
     <?php
    if($clientData != null){
         $clientDataUser = unserialize($clientData);
         $clientDataUser = implode(',',$clientDataUser);
     }else{
        $clientDataUser = '';
    }
    $clientid = $data['client'];
     if($projects){
      foreach($projects as $row1){ ?>
    <option value="<?php echo $row1['id_project']; ?>" <?php 
     $projectselect = $data['projects'];
    if($projectselect != null){
       $projectselect = unserialize($projectselect);
    if(in_array($row1['id_project'],$projectselect)){ echo 'selected'; }   } ?>><?php echo $row1['name']; ?></option>
   <?php } } ?>      
    </select>
        <span class="error">Projects is required</span>
    </div>
    </div>
  </div>
    </div>  

<div class="text-center">
    <input type="hidden" name="gid" id="gid" value="<?php echo $data['id']; ?>" />
  <button type="button" id="updateProjectgroupbtn" name="submit" value="submit" class="btn cus-btn">Submit</button>
</div>
<?php } ?>
</form>
</div>	<div class="col-md-6">
							<div class="form-group">
								<div class="project-dtails">
									<div class="pro-details-inner">
										<div class="pro-heading">
											<h4>Password</h4>
										</div>
										
													<div class="row">

					<div class="col-md-12 toggleWrapper m-l-0">
							<div class="form-group">
								<label for="">Publish</label>
								<input type="checkbox" name="is_publish" onclick="updateprojectStatus(this,'projectsgroup')" id="dndo" class="dn" value="publish" <?php if ($data['visibility'] == 1) {
																					echo 'checked';
																				} ?>/>
								<label for="dndo" class="toggle"><span class="toggle__handler"></span></label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12" id="passProtected" style="<?php if ($data['visibility'] != 1) {
																					echo 'display:none';
																				} ?>">
						    
							<div class="form-group">
							    <label for="">Protected</label>
							    <div class="custom-checkbox">
								<input type="checkbox" name="password_protected" onclick="updateprojectStatus(this,'projectsgroup')" id="password_protected" value="password_protected" <?php if ($data['password_protected'] == 1) {
																					echo 'checked';
																				} ?> />
																					<label for="password_protected">Password protected</label>
																				</div>
																				<?php
																					if ($data['password'] != null) {
		$pass = openssl_decrypt(hex2bin($data['password']), 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
	}
																				?>
							</div>
						</div>
											</div>
										</div>
										<div class="addPassword" style="<?php if ($data['password_protected'] != 1) {
																			echo 'display:none';
																		} ?>">
											<div class="row">
												<div class="col-md-12">
													<form id="passForm" action="javascript:void(0)" method="post" style="max-width:100%">
														<div class="form-group pass-field">
															<label>Project password</label>
															<input type="password" class="form-control required" value="<?php echo $pass; ?>" id="password" name="password" />
															<span class="error">Password is required</span>
															<span class="togglePass"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
														</div>
														<input type="hidden" id="project_id" name="id" value="<?php echo $data['id']; ?>" />
														<div class="form-group">
														<button class="generatePassword btn register-link" type="button" onclick="randomPassword(8)">Generate password</button>
														</div>
														<button class="btn cus-btn" id="savePass" page="projectsgroup" type="button">Submit</button>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div></div>

		</div>
	</div>

<script>
	function checkinique(mcval, project_group_id) {
		  if($.trim(mcval) != ''){
			$('.unique-error').html('loading...');
			if(/[^a-zA-Z0-9\-_/\/]/.test( mcval ) || mcval.toLowerCase().indexOf("/") >= 0 ) {
                	$('.unique-error').html('<span class="text-danger">special characters not allowed in UNIQUE-URL !</span>');
                	$('#updateProjectgroupbtn').attr('disabled', 'true');
            }else{
                	$('.unique-error').html('loading...');
                		 $('#updateProjectgroupbtn').prop("disabled", false);
			$.ajax({
				url: '<?php echo BASEURL . '/dashboard/projectsgroup/checkunique.php' ?>',
				type: 'POST',
				data: {
					'unique_url': mcval,
					'project_group_id': project_group_id
				},
				dataType: "json",
				success: function(data) {
						  $('.unique-error').html('<span class="text-success">'+data.msg+'</span>');
					if (data.status == 0) {
						$('.unique-error').focus();
					}
				}
			});
            }
	    }else{
	        	$('.unique-error').html('');
	    }
		}
</script>
						
</div><!-- Panel Content -->