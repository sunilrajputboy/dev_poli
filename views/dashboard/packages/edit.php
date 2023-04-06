<div class="page-header-wrap">
	<h3>Edit Packages</h3>
	<a href="<?php echo BASE_URL ?>packages/" class="btn cus-btn"> <i class="fa fa-chevron-left"></i> Back</a>
</div>
<div class="widget">
	<div class="table-area">
		<div class="widget-title">
			<?php if(isset($_SESSION["success_msg"]) && !empty($_SESSION["success_msg"])) { ?>
                        <div class="alert alert-success" id="sucessMessages">
                                <p id="suc_msg"><?php echo $_SESSION["success_msg"]; ?></p>
                        </div>
					<?php $_SESSION["success_msg"]=""; unset($_SESSION["success_msg"]); } ?>	
					<?php if(isset($_SESSION["error_msg"]) && !empty($_SESSION["error_msg"])) { ?>
                        	<div class="alert alert-danger" id="errorMessages">
								<p id="err_msg"><?php echo $_SESSION["error_msg"]; ?></p>
							</div>
					<?php $_SESSION["error_msg"]=""; unset($_SESSION["error_msg"]);  } ?>
		</div>
		<div class="addpackages">
			<form action="<?php echo BASE_URL.'packages/update';?>" id="addForm" method="post">
			    <div class="project-dtails form-group">
				<div class=" row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="">Package Name</label>
							<input type="text" class="form-control <?php if ($package['name'] != null) { echo 'value-filled'; } ?>" name="name" id="name" placeholder="Package Name" value="<?php echo $package['name']; ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="">No of allowed users</label>
							<input type="number" class="form-control <?php if ($package['no_allowed_user'] != null) { echo 'value-filled'; } ?>" name="no_allowed_user" id="no_allowed_user" placeholder="No of allowed user" value="<?php echo $package['no_allowed_user']; ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="">No of allowed projects</label>
							<input type="number" class="form-control <?php if ($package['no_allowed_projects'] != null) { echo 'value-filled'; } ?>" name="no_allowed_projects" id="no_allowed_projects" placeholder="No of allowed projects" value="<?php echo $package['no_allowed_projects']; ?>">
						</div>
					</div>
				</div>
					<div class="row">
						<div class="col-md-6 toggleWrapper m-l-0">
							<div class="form-group">
								<label for="">Unlimited users</label>
								<input type="checkbox" name="unlimited_user" id="unlimited_user" class="unlimited" value="Unlimited" <?php if ($package['no_allowed_user'] == 'Unlimited') { echo 'checked'; } ?> />
								<label for="unlimited_user" class="toggle"><span class="toggle__handler"></span></label>
							</div>
						</div>
						<div class="col-md-6 toggleWrapper m-l-0">
							<div class="form-group">
								<label for="">Unlimited projects</label>
								<input type="checkbox" name="unlimited_pro" id="unlimited_pro" class="unlimited" value="Unlimited" <?php if ($package['no_allowed_projects'] == 'Unlimited') { echo 'checked'; } ?> />
								<label for="unlimited_pro" class="toggle"><span class="toggle__handler"></span></label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
 <div class="form-group">
<label for="">Select Maps</label>
	<select class="form-control js-select2 ad-package <?php if ($package['no_allowed_maps'] != null) {echo 'value-filled';} ?>" multiple="multiple" name="no_allowed_map[]" id="no_allowed_map">
	<?php
    $map_name = explode(",", $package['no_allowed_maps']);
	if(!empty($maptemplates)){ foreach($maptemplates as $map_cat){ $map_templates=$map_cat['template_list']; ?>
    <optgroup label="<?php echo $map_cat['category_name']; ?>">
	<?php if(!empty($map_templates)){ foreach($map_templates as $row){ ?>
	<option value="<?php echo $row['id_map_templates']; ?>" <?php foreach ($map_name as $map){
																								if ($row['map_name'] == $map || $row['id_map_templates'] == $map){ echo 'selected'; } } ?>>		<?php echo $row['map_name']; ?> </option>
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
								<input type="checkbox" name="is_logo" id="dndo" class="dn" value="yes" <?php if ($package['is_logo'] == 'yes') { echo 'checked'; } ?> />
								<label for="dndo" class="toggle"><span class="toggle__handler"></span></label>
							</div>
						</div>
						<div class="col-md-6 toggleWrapper m-l-0">
							<div class="form-group">
								<label for="">Enable Charts</label>
								<input type="checkbox" name="is_charts" id="charts" class="dn" value="yes" <?php if ($package['is_charts'] == 'yes') {
																												echo 'checked';
																											} ?> />
								<label for="charts" class="toggle"><span class="toggle__handler"></span></label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 toggleWrapper m-l-0">
							<div class="form-group">
								<label for="">Enable Fonts</label>
								<input type="checkbox" name="is_fonts" id="fonts" class="dn" value="yes" <?php if ($package['is_fonts'] == 'yes') {
																												echo 'checked';
																											} ?> />
								<label for="fonts" class="toggle"><span class="toggle__handler"></span></label>
							</div>
						</div>
						<div class="col-md-6 toggleWrapper m-l-0">
							<div class="form-group">
								<label for="">Enable email MP</label>
								<input type="checkbox" name="is_email_mp" id="email_mp" class="dn" value="yes" <?php if ($package['email_mp'] == 'yes') {
																													echo 'checked';
																												} ?> />
								<label for="email_mp" class="toggle"><span class="toggle__handler"></span></label>
							</div>
						</div>
						<div class="col-md-6 toggleWrapper m-l-0">
							<div class="form-group">
								<label for="">Enable social share</label>
								<input type="checkbox" name="is_social_share" id="social_share" class="dn" value="yes" <?php if ($package['is_social_share'] == 'yes') {
																													echo 'checked';
																												} ?> />
								<label for="social_share" class="toggle"><span class="toggle__handler"></span></label>
							</div>
						</div>
						<div class="col-md-6 toggleWrapper m-l-0">
							<div class="form-group">
								<label for="">Enable email share</label>
								<input type="checkbox" name="is_email_share" id="email_share" class="dn" value="yes" <?php if ($package['is_email_share'] == 'yes') {
																													echo 'checked';
																												} ?> />
								<label for="email_share" class="toggle"><span class="toggle__handler"></span></label>
							</div>
						</div>
							<div class="col-md-6 toggleWrapper m-l-0">
							<div class="form-group">
								<label for="">Enable tweet MP</label>
								<input type="checkbox" name="is_tweet_mp" id="tweet_mp" class="dn" value="yes" <?php if ($package['is_tweet_mp'] == 'yes') {
																													echo 'checked';
																												} ?> />
								<label for="tweet_mp" class="toggle"><span class="toggle__handler"></span></label>
							</div>
						</div>
							<div class="col-md-6 toggleWrapper m-l-0">
							<div class="form-group">
								<label for="">Hide Branding </label>
								<input type="checkbox" name="hide_branding" id="hide_branding" class="dn" value="yes" <?php if ($package['hide_branding'] == 'yes') {
																													echo 'checked';
																												} ?>/>
								<label for="hide_branding" class="toggle"><span class="toggle__handler"></span></label>
							</div>
						</div>
					</div>
					<div class="row m-t-30">
						<div class="col-md-12">
							<div class="form-group">
								<table class="table table-striped the-package" id="packages1">
									<thead>
										<tr>
											<th>Clients selected this package</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$id = $package['id'];
										if (!empty($allclients)) {
											foreach ($allclients as $packageClient ) {  ?>
												<tr>
													<td><a href="<?php echo BASE_URL.'clients/edit/' . $packageClient['id']; ?>"><?php echo $packageClient['name'];  ?></a></td>
												</tr>
										<?php }
										}  ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					</div>
					<input type="hidden" name="id" value="<?php echo $package['id']; ?>" />
					<input type="hidden" name="package_id" value="<?php echo $package['id']; ?>" />
				<div class="text-center">
				    	<button type="submit" name="update" value="update" class="btn cus-btn">Update</button>
				</div>
			</form>
		</div>
	</div>
</div><!-- Panel Content -->
<script>
	var sucess_msg = localStorage.getItem("message_sucess");
	var error_msg = localStorage.getItem("message_error");
	if (sucess_msg != null) {
		document.getElementById("addForm").reset();
		document.getElementById("suc_msg").style.display = 'block';
		document.getElementById("sucessMessage").innerHTML = sucess_msg;
	} else if (error_msg != null) {
		document.getElementById("addForm").reset();
		document.getElementById("err_msg").style.display = 'block';
		document.getElementById("errorMessage").innerHTML = error_msg;
	}
	localStorage.removeItem("message_sucess");
	localStorage.removeItem("message_error");
</script>