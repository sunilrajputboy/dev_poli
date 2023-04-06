<div class="page-header-wrap">
	<h3>Templates</h3>
</div>
<div class="widget">
	<div class="table-area">
		<div class="widget-title">
			<div class="alert alert-success" id="sucessMessage" style="display:none">
				<p id="suc_msg">Update successfully.</p>
			</div>
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
		<div class="addtemplates">
			<div class="row form-group">
				<div class="col-md-6">
					<form method="post" action="<?php echo BASE_URL.'templates/update' ?>" id="template1">
						<div class="project-dtails form-group">
							<div class="pro-heading">
								<h4>Sharing Settings Email</h4>
							</div>
							<div class="pro-details-inner">
							    	<label class="social-head">Email MP</label>
									<div class="toggleWrapper m-l-0 form-group">
									
										<input type="hidden" name="is_mp" id="email_mp" class="dn" value="yes">
										<!--<label for="email_mp" class="toggle"><span class="toggle__handler"></span></label>-->
									</div>
									<div id="emailMpsetting">
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label for="">Title</label>
													<input type="text" class="form-control " name="email_sub" id="email_sub" placeholder="Enter email subject" value="<?php  echo $dataClientall['email_sub']; ?>">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label for="">Message to your MP</label>
													<textarea class="form-control " name="message" id="msg" placeholder="[Salutation] Write the text you want people to send their MPS"><?php echo $dataClientall['message'];?></textarea>
												</div>
											</div>
										</div>
								</div>
							</div>
								<div class="text-center">
							<button type="submit" name="email_mp_update" value="update" class="btn cus-btn">Save</button>
						</div>
						</div>
					
					</form>
					<!--// 2-->
						<form method="post" action="<?php echo BASE_URL.'templates/updateprivacypolicy' ?>" id="template-pp">
						<div class="project-dtails form-group">
							<div class="pro-heading">
								<h4>Privacy Policy</h4>
							</div>
							<div class="pro-details-inner">
										<div class="row">
										<textarea class="form-control privacypolicyEditer" name="privacypolicy" id="privacypolicy_msg" placeholder="[Salutation] Write the text you want people to show in privacy policy"><?php echo $dataClientall['privacypolicy'];?></textarea>
										</div>
							</div>
								<div class="text-center">
							<button type="submit" name="privacypolicy_update" value="update" class="btn cus-btn">Save</button>
						</div>
						</div>
					
					</form>
				</div>
				<div class="col-md-6">
					<form method="post" action="<?php echo BASE_URL.'templates/newupdate' ?>" id="template2">
						<div class="project-dtails form-group">
							<div class="pro-heading">
								<h4>Social Sharing</h4>
							</div>
							<div class="pro-details-inner">
								<div class="form-group">
								    	<label class="social-head">social share</label>
									<div class="toggleWrapper m-l-0">
										<input type="hidden" name="is_social_share" id="is_social" class="dn" value="yes">
										<!--<label for="is_social" class="toggle"><span class="toggle__handler"></span></label>-->
									</div>
								</div>
								<div class="form-group">
									<div id="socialshareSetting">
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<div class="custom-checkbox">
														<input type="hidden" name="is_facebook" onclick="enableFacebook(this)" id="is_facebook" class="" value="yes">
														<label for="is_facebook">Facebook</label>
													</div>
													<input type="text" class="form-control share-text"
													name="is_facebook_text" id="is_fb_share" placeholder="Default message" value="<?php echo $dataClientall['is_facebook']; ?>">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<div class="custom-checkbox"> 
														<input type="hidden" name="is_twitter" onclick="enableTwitter(this)" id="is_twitter" class="" value="yes">
														<label for="is_twitter">Twitter</label>
													</div>
													<input type="text" class="form-control share-text"
													name="is_twitter_text" id="is_twitter_share" placeholder="Default message" value="<?php echo $dataClientall['is_twitter'];?>">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<div class="custom-checkbox">
														<input type="hidden" name="is_linkedin" onclick="enableLinkedin(this)" id="is_linkedin" class="" value="yes">
														<label for="is_linkedin">Linkedin</label>
													</div>
													<input type="text" class="form-control share-text "
													name="is_linkedin_text" id="is_linkedin_share" placeholder="Default message" value="<?php echo $dataClientall['is_linkedin'];?>">
												</div>
											</div>
										</div>
										
									</div>
									<div class="row">
										<div class="col-md-12">
												<div class="form-group">
												    <label class="social-head">Email a friend</label>
													<div class="toggleWrapper m-l-0">
														<input type="hidden" name="is_email_friend" id="is_email_friend" class="" value="yes">
													
													</div>
													</div>
													<div class="form-group">
													<div class="row form-group" id="emailfriend">
													<div class="col-md-12">
        												<div class="form-group">
        													<label for="">Title</label>
        												<input type="text"
        													name="email_friend_title" placeholder="Enter title here" id="email_friend_title" class="form-control share-text" value="<?php echo $dataClientall['email_friend_title']; ?>">
        												</div>
        											</div>
        											<div class="col-md-12">
        												<div class="form-group">
    														<label for="email_friend_text">Message</label>
        											
        													<textarea placeholder="Enter message here" id="email_friend_text" class="form-control tweet-mp-text" name="email_friend_text" ><?php echo $dataClientall['email_friend_text']; ?></textarea>
        												</div>
        											</div>
        											</div>
												</div>
											</div>
											</div>
									
									<div class="row">
									    	<div class="col-md-12">
												<div class="form-group">
												    <label class="social-head">Tweet MP</label>
													<div class="toggleWrapper m-l-0">
														<input type="hidden" name="is_tweet_mp" onclick="enabletweetMP(this)" id="tweet_mp" class="dn" value="yes">
														<!--<label for="tweet_mp" class="toggle"><span class="toggle__handler"></span></label>-->
													</div>
												</div>
												<div>
													<div class="form-group" id="tweetMptext">
														<label for="tweetMptext">MP tweet text</label>
														<textarea name="tweet_mp_text" id="" placeholder="Write MP tweet text" class="form-control tweet-mp-text"><?php echo $dataClientall['tweet_mp_text'];?></textarea>
													</div>
												</div>
											</div>
									</div>
									<div class="row">
									    	<div class="col-md-12">
									    	    	<div class="pro-heading">
                        								<h4>Subscribe Mail details</h4>
                        							</div>
												<div class="form-group">
												    <label for="subscribe_mail_text">Text</label>
													<div class="toggleWrapper m-l-0">
														<textarea name="subscribe_mail_text" id="" placeholder="Write subscribing mail text" class="form-control"><?php echo isset($dataClientall['subscribe_mail_text']) ? $dataClientall['subscribe_mail_text']: '';?></textarea>
													</div>
												</div>
												<div class="form-group">
												    <label for="subscribe_mail_address">Address</label>
													<div class="m-l-0">
													    <input type="text" placeholder="Subscribe mail address" value="<?php echo isset($dataClientall['subscribe_mail_address']) ? $dataClientall['subscribe_mail_address']: '';?>" name="subscribe_mail_address" class="form-control"/>
														</div>
												</div>
													<div class="form-group">
												    <label for="subscribe_mail_copyright_title">Copyright Website Name</label>
													<div class="m-l-0">
													   	<input type="text" name="copyright_title" value="<?php echo isset($dataClientall['copyright_title']) ? $dataClientall['copyright_title']: '';?>" placeholder="Write copyright title" class="form-control">
														</div>
												</div>
													<div class="form-group">
												    <label for="subscribe_mail_copyright_link">Copyright Website Link</label>
													<div class="m-l-0">
													   	<input type="text" name="copyright_link" value="<?php echo isset($dataClientall['copyright_link']) ? $dataClientall['copyright_link']: '';?>" placeholder="Write copyright link" class="form-control">
														</div>
												</div>
											</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
						    	<input type="hidden" name="is_insta" value="yes">
											<input type="hidden" name="is_insta_text" value="<?php echo $dataClientall['is_insta']; ?>">
							<div class="text-center">
								<button type="submit" name="update" value="update" class="btn cus-btn">Save</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
 
	var sucess_msg = localStorage.getItem("message_success");
	var error_msg = localStorage.getItem("message_error");
	if (sucess_msg != null) {
		document.getElementById("sucessMessage").style.display = 'block';
		document.getElementById("suc_msg").innerHTML = sucess_msg;
			//removeMsg('sucessMessage');
	} else if (error_msg != null) {
		document.getElementById("err_msg").style.display = 'block';
		document.getElementById("errorMessage").innerHTML = error_msg;
			//removeMsg('err_msg');
	}
	localStorage.removeItem("message_success");
	localStorage.removeItem("message_error");
	localStorage.removeItem("settings1");
	localStorage.setItem("general1", 'active');
</script>
</div><!-- Panel Content -->
