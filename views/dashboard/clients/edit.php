	<div class="page-header-wrap">
		<h3>Edit Clients</h3>
		<a href="<?php echo BASE_URL; ?>clients/" class="btn cus-btn"> <i class="fa fa-chevron-left"></i> Back</a>
	</div>
	<?php
	$id = $clientData['id'];

	?>

	<ul class="nav nav-pills custom-tabs">
		<li id="general1" onclick="mytabFun('general1','#1a')">
			<a href="#1a" class="custom-tab-child" data-toggle="tab">General</a>
		</li>
		<li id="settings1" onclick="mytabFun('settings1','#2a')">
			<a href="#2a" class="custom-tab-child" data-toggle="tab">Settings</a>
		</li>
	</ul>
	<div class="tab-content clearfix">
		<div class="tab-pane" id="1a">
			<!--		        <div class="page-header-wrap">-->
			<!--	<h3>Edit Clients</h3>-->
			<!--</div>-->
			<div class="clear">
				<div class="widget">
					<div class="table-area">
						<div class="widget-title">
							<div class="alert alert-success" id="sucessMessage" style="display:none">

								<p id="suc_msg"></p>
							</div>
							<div class="alert alert-danger" id="errorMessage" style="display:none">

								<p id="err_msg"></p>
							</div>
							<?php if (isset($_SESSION["success_msg"]) && !empty($_SESSION["success_msg"])) { ?>
								<div class="alert alert-success" id="sucessMessages">
									<p id="suc_msg"><?php echo $_SESSION["success_msg"]; ?></p>
								</div>
							<?php $_SESSION["success_msg"] = "";
								unset($_SESSION["success_msg"]);
							} ?>

							<?php if (isset($_SESSION["error_msg"]) && !empty($_SESSION["error_msg"])) { ?>
								<div class="alert alert-danger" id="errorMessages">
									<p id="err_msg"><?php echo $_SESSION["error_msg"]; ?></p>
								</div>
							<?php $_SESSION["error_msg"] = "";
								unset($_SESSION["error_msg"]);
							} ?>
						</div>
						<div class="addpackages">
							<form action="<?php echo BASE_URL; ?>clients/update" id="updateForm" method="post">
								<div class="project-dtails form-group">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="">Name</label>
												<input type="text" class="form-control <?php if ($clientData['name'] != null) {
																							echo 'value-filled';
																						} ?>" name="name" id="name" placeholder="Name" value="<?php echo $clientData['name']; ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="">Phone</label>
												<input type="text" class="form-control <?php if ($clientData['phone'] != null) {
																							echo 'value-filled';
																						} ?>" name="phone" id="phone" placeholder="Phone" value="<?php echo $clientData['phone']; ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="">Email</label>
												<input type="email" class="form-control <?php if ($clientData['email'] != null) {
																							echo 'value-filled';
																						} ?>" name="email" id="email" placeholder="Email" value="<?php echo $clientData['email']; ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="">Select Package</label>
												<select class="form-control <?php if ($clientData['package'] != null) {
																				echo 'value-filled';
																			} ?>" name="package">
													<?php if (!empty($allPackages)) {
														foreach ($allPackages as $row) { ?>
															<option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $clientData['package']) {
																											echo 'selected';
																										} ?>> <?php echo $row['name']; ?> </option>
													<?php }
													} ?>
												</select>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label for="">Projects of this clients</label>
												<select disabled class="form-control js-select2" multiple="multiple" name="project[]" id="project">
													<?php if (!empty($ProjectList)) {
														foreach ($ProjectList as $row1) {
															if ($row1['id_client'] == $id) { ?>
																<option value="<?php echo $row1['id_project']; ?>" selected><?php echo $row1['name']; ?></option>
													<?php }
														}
													} ?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<input type="hidden" name="id" value="<?php echo $clientData['id']; ?>" />
								<div class="text-center">
									<button type="submit" name="update" value="update" class="btn cus-btn">Update</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane" id="2a">
			<!--    <div class="page-header-wrap">-->
			<!--	<h3>Client setting</h3>-->
			<!--</div>-->
			<div class="clear">
				<div class="widget" id="clientSetting">
					<div class="table-area">
						<div class="widget-title">
							<div class="alert alert-success" id="sucessclientMessage2" style="display:none">
								<p id="suc_clientmsg2"></p>
							</div>
							<div class="alert alert-danger" id="errorMessage2" style="<?php if (isset($_SESSION['error'])) {
																							echo 'display:block';
																						} else {
																							echo 'display:none';
																						} ?>">

								<p id="err_msg2"><?php if (isset($_SESSION['error'])) {
														echo $_SESSION['error'];
													} ?></p>
							</div>
						</div>
						<div class="addpackages">
							<form action="<?php echo BASE_URL; ?>clients/updateclient" id="clientSettingUpdateForm" method="post" enctype='multipart/form-data'>
								<div class="project-dtails form-group">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label for="">Unique Url</label>
												</div>
												<div class="form-group">
								<input type="text" class="form-control" onkeyup="checkinique(this.value,'<?php echo $clientData['id']; ?>')" name="unique_url" id="unique_url" placeholder="Unique URL" value="<?php echo $clientData['unique_url']; 
																																																						?>">
								<span class="unique-error error-msg-span"></span>
											</div>
										</div>
									</div>
								</div>

								<?php if ($packageData['is_logo'] != 'no') { ?>
									<div class="project-dtails form-group">

										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label for="">Upload Logo or enter URL</label>

													<div class="custom-checkbox">
														<input type="checkbox" onclick="enablelogourl(this)" name="url" id="logourl" class="" value="yes" <?php if ($clientData['logo'] != null) {
																																								echo 'checked';
																																							} ?>>
														<label for="logourl">Enter url</label>
													</div>
													<div class="custom-checkbox">
														<input type="checkbox" onclick="enablelogofile(this)" name="file" id="logofile" class="" value="yes" <?php if ($clientData['logofile'] != null) {
																																									echo 'checked';
																																								} ?>>
														<label for="logofile">Logo</label>
													</div>
													<div id="url" style="<?php if ($clientData['logo'] == null) {
																				echo 'display:none';
																			} ?>">
														<input type="text" class="form-control <?php if ($clientData['logo'] != null) {
																									echo 'value-filled';
																								} ?>" name="logourl" id="logo" placeholder="logo URL" value="<?php echo $clientData['logo']; ?>">
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group" id="chooselogo" style="<?php if ($clientData['logofile'] == null) {
																									echo 'display:none';
																								} ?>">
													<div class="custom-file custom-file-1">
														<input type="file" class="custom-file-input form-control m-t-10 <?php if ($clientData['logofile'] != null) {
																															echo 'value-filled';
																														} ?>" name="logofile" id="logo" placeholder="logo" value="<?php echo $clientData['logofile']; ?>">
														<label class="custom-file-label" for="logo" data-js-label>Choose file</label>
													</div>
												</div>
												<div class="form-group selected-logo">
													<?php
													if ($clientData['logo'] != '') { ?>
														<img src="<?php echo $clientData['logo'];  ?>" class="data-value" />

													<?php } else if ($clientData['logofile'] != null) {
													?>
														<img src="<?php echo '/uploads/' . $clientData['logofile'];  ?>" class="data-value" />
													<?php
													} ?>
												</div>
											</div>
										</div>
									</div>
								<?php }  ?>
								<!--option foreach-->

								<?php if ($packageData['is_fonts'] != 'no') { ?>
									<div class="project-dtails form-group">
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label for="">Select fonts</label>
													<select class="form-control" name="fonts" id="fonts">
														<option value="" disabled <?php if ($clientData['font'] == null) {
																						echo 'selected';
																					} ?>>Select fonts</option>
														<?php foreach ($fonts as $font) { ?>
															<option value="<?php echo $font['font_family']; ?>" <?php if ($clientData['font'] != null) {
																													if ($clientData['font'] == $font['font_family']) {
																														echo 'selected';
																													}
																												} ?>><?php echo $font['font_family']; ?>
															</option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>
									</div>
								<?php } ?>

								<div class="project-dtails form-group">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label for="">Select primary color</label>
												<div class="colorBox">
													<input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="<?php echo $clientData['primary_color']; ?>" />
													<input type="color" class="colorInput" name="colorprime" onchange="colorChange(this)" id="colors" value="<?php echo $clientData['primary_color']; ?>" />

												</div>
											</div>
											<div class="form-group">
												<label for="">Select secondary color</label>
												<div class="colorBox">
													<input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="<?php echo $clientData['secondary_color']; ?>" />
													<input type="color" class="colorInput" name="colorsecond" onchange="colorChange(this)" id="colors" value="<?php echo $clientData['secondary_color']; ?>" />

												</div>
											</div>
											<div class="form-group">
												<label for="">Select text color 1</label>
												<div class="colorBox">
													<input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="<?php echo $clientData['text_color']; ?>" />
													<input type="color" class="colorInput" name="text_color" onchange="colorChange(this)" id="colors" value="<?php echo $clientData['text_color']; ?>" />

												</div>
											</div>
											<div class="form-group">
												<label for="">Select text color 2</label>
												<div class="colorBox">
													<input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="<?php echo $clientData['text_color2']; ?>" />
													<input type="color" class="colorInput" name="text_color2" onchange="colorChange(this)" id="colors" value="<?php echo $clientData['text_color2']; ?>" />
												</div>
											</div>
											<div class="form-group">
												<label for="">Select text color 3</label>
												<div class="colorBox">
													<input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="<?php echo $clientData['text_color3']; ?>" />
													<input type="color" class="colorInput" name="text_color3" onchange="colorChange(this)" id="colors" value="<?php echo $clientData['text_color3']; ?>" />
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="project-dtails form-group">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group radio-g-m">
												<div class="radio-g">
													<input type="radio" id="color_type_2" name="color_type" value="2" checked />
													<label for="color_type_2">Normal colour</label>
												</div>
												<div class="radio-g">
													<input type="radio" id="color_type_1" name="color_type" value="1" />
													<label for="color_type_1">Colour mixer</label>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-12">
											<div id="color_type1">
												<div class="range-sliders">
													<input class="inputmixer range-slider__range" type="range" id="numsteps" value="<?php if ($clientData['colours'] != '') {
																																		echo count(unserialize($clientData['colours'])) - 2;
																																	} else {
																																		echo 1;
																																	} ?>" min="1" max="8" />
													<span class="range-slider__value"></span>
												</div>
												<br>
												<ul class="ulmixer" id="list">
													<?php
													if ($clientData['colours'] != null) {
														$count = 0;
														foreach (unserialize($clientData['colours']) as $color) {
															$count++;

															if ($count == 1) {
													?>
																<li class="limixer" id="start"><input class="inputmobile" type="color" name="colorinput[]" value="<?php echo $color; ?>" size="7" /><span class="spanmixer"></span></li>
															<?php }
															if ($count != 1 && ($count != count(unserialize($clientData['colours'])))) { ?>
																<li class="interim"><span class="spanmixer"><?php echo $color; ?></span><input type="hidden" class="colorInput" name="colorinput[]" value="<?php echo $color; ?>" /></li>
															<?php }
															if ($count == count(unserialize($clientData['colours']))) { ?>
																<li class="limixer" id="end"><input class="inputmobile" type="color" name="colorinput[]" value="<?php echo $color; ?>" size="7" /><span class="spanmixer"></span></li>
														<?php
															}
														}
													} else { ?>
														<li class="limixer" id="start"><input class="inputmobile" type="color" name="colorinput[]" value="#5E4FA2" size="7" /><span class="spanmixer"></span></li>
														<li class="limixer" id="end"><input class="inputmobile" type="color" name="colorinput[]" value="#F79459" size="7" /><span class="spanmixer"></span></li>
													<?php
													}
													?>
												</ul>
												<br>
												<div class="form-group radio-g-m r-none">
													<div class="radio-g">
														<input type="radio" name="intype" value="interpolateColor" id="rgb" checked />
														<label for="rgb">RGB</label>
													</div>
													<div class="radio-g">
														<input type="radio" name="intype" value="interpolateHSL" id="hsl" />
														<label for="hsl">HSL</label>
													</div>
												</div>
											</div>
											<div id="color_type2">
												<div class="color-append-box">
													<label for="">Key colors:</label>
													<?php
													if ($clientData['colours'] != null) {
														$count = 0;
														foreach (unserialize($clientData['colours']) as $color) {
															$count++;
													?>
															<div class="colorBox">
																<label for="">Key color <?php echo $count; ?></label>
																<input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="<?php echo $color; ?>" />
																<input type="color" class="colorInput" name="color[]" onchange="colorChange(this)" id="colors" value="<?php echo $color; ?>" />
																<?php if ($count == count(unserialize($clientData['colours']))) { ?>
																	<button class="removeBox" onclick="removeColor(this)">
																		x
																		<!-- <img src="../images/close.png" alt=""> -->
																	</button>
																<?php } ?>
															</div>
													<?php }
													} ?>
												</div>
												<div class="m-5" id="addBtnBox" style="<?php if ($count < 10) { ?>display:block<?php } else {
																																echo 'display:none';
																															} ?>">
													<button type="button" class="btn register-link" id="addColorBtn" onclick="addColor()">Add color</button>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="project-dtails form-group">
								<?php if ($packageData['email_mp'] != 'no' || $packageData['is_charts'] != 'no' || $packageData['is_social_share'] != 'no' || $packageData['is_tweet_mp'] != 'no' || $packageData['is_email_share'] != 'no') { ?>
										<div class="row">
											<?php if ($templateData['is_mp'] != 'no') { ?>
												<?php if ($packageData['email_mp'] != 'no') { ?>
													<div class="col-sm-12 col-xs-12">
														<div class="form-group">
															<div class="toggleWrapper m-l-0">
																<label for="">Enable Email MP</label>
																<input type="checkbox" name="is_email_mp" onclick="emailMp(this)" id="email_mp" class="dn" value="yes" <?php
																																										if ($clientData['is_mp'] != null) {
																																											if ($clientData['is_mp'] == 'yes') {
																																												echo 'checked';
																																											}
																																										} else if ($packageData['email_mp'] == 'yes') {
																																											echo 'checked';
																																										} ?> />
																<label for="email_mp" class="toggle"><span class="toggle__handler"></span></label>
															</div>
														</div>
														<div id="emailMpsetting" style="<?php if ($clientData['is_mp'] != null) {
																							if ($clientData['is_mp'] != 'yes') {
																								echo 'display:none';
																							}
																						} else if ($packageData['email_mp'] != 'yes') {
																							echo 'display:none';
																						} ?>">
															<?php if ($clientData['email_setting'] != null) {
																$emailSettingArr = unserialize($clientData['email_setting']);
																$sub = $emailSettingArr['esubject'];
																$msg =   $emailSettingArr['emsg'];
															} else {
																$sub = '';
																$msg = '';
															} ?>
															<div class="row">
																<div class="col-md-12">
																	<div class="form-group">
																		<label for="">Enter email subject</label>
																		<input type="text" class="form-control <?php if ($templateData['email_sub'] != null) {
																													echo 'value-filled';
																												} ?>" name="email_sub" id="email_sub" placeholder="Enter email subject" value="<?php if ($clientData['email_sub'] == null) {
																									echo $templateData['email_sub'];
																								} else {
																									echo $clientData['email_sub'];
																								} ?>">
																	</div>
																</div>
																<div class="col-md-12">
																	<div class="form-group">
																		<label for="">Message</label>
																		<textarea class="form-control <?php if ($templateData['message'] != null) {
																											echo 'value-filled';
																										} ?>" name="message" id="msg"><?php if ($clientData['message'] == null) {
																																																				echo $templateData['message'];
																																																			} else {
																																																				echo $clientData['message'];
																																																			} ?></textarea>

																	</div>
																</div>
															</div>
														</div>
													</div>
												<?php }
											}
											if ($packageData['is_charts'] != 'no') { ?>
												<div class="col-md-12">
													<div class="form-group">
														<div class="toggleWrapper m-l-0">
															<label for="">Enable Charts</label>
															<input type="checkbox" name="is_charts" id="charts" class="dn" value="yes" <?php if ($clientData['is_charts'] != null) {
																																			if ($clientData['is_charts'] == 'yes') {
																																				echo 'checked';
																																			}
																																		} else if ($packageData['is_charts'] == 'yes') {
																																			echo 'checked';
																																		} ?> />
															<label for="charts" class="toggle"><span class="toggle__handler"></span></label>
														</div>
													</div>
												</div>
												<?php }
											if ($templateData['is_social_share'] != 'no') {
												if ($packageData['is_social_share'] != 'no') {
												?>
													<div class="col-md-12">
														<div class="form-group">
															<div class="toggleWrapper m-l-0">
																<label for="">Enable social share</label>
																<input type="checkbox" name="is_social_share" onclick="enableSocialShare(this)" id="is_social" class="dn" value="yes" <?php
																																														if ($clientData['is_social_share'] != null) {
																																															if ($clientData['is_social_share'] == 'yes') {
																																																echo 'checked';
																																															}
																																														} else if ($packageData['is_social_share'] == 'yes') {
																																															echo 'checked';
																																														}																																													?> />
																<label for="is_social" class="toggle"><span class="toggle__handler"></span></label>
															</div>
														</div>
														<div id="socialshareSetting" style="<?php if ($clientData['is_social_share'] != null) {
																								if ($clientData['is_social_share'] != 'yes') {
																									echo 'display:none';
																								}
																							} else if ($packageData['is_social_share'] != 'yes') {
																								echo 'display:none';
																							} ?>">
															<?php
															// if ($clientData['social_setting'] != null) {
															//$emailSettingArr = unserialize($clientData['social_setting']);
															//} 
															?>
															<div class="row">
																<?php if ($templateData['is_facebook'] != 'no') { ?>
																	<div class="col-md-12">
																		<div class="form-group">
																			<div class="custom-checkbox">
																				<input type="checkbox" onclick="enableFacebook(this)" name="facebook" id="is_facebook" class="" value="yes" <?php if ($clientData['is_facebook'] != 'no') {
																																																echo 'checked';
																																															} ?>>
																				<label for="is_facebook">Facebook</label>
																			</div>
																			<input type="text" name="is_facebook" class="form-control share-text <?php if ($clientData['is_facebook'] != null) {
																																						echo 'value-filled';
																																					} ?>" style="<?php if ($clientData['is_facebook'] == 'no') {
																																																										echo 'display:none';
																																																									} ?>" id="is_fb_share" placeholder="Enter share text" value="<?php if ($clientData['is_facebook'] == null) {
																																																																																										echo $templateData['is_facebook'];
																																																																																									} else {
																																																																																										if ($clientData['is_facebook'] == 'no') {
																																																																																											echo  $templateData['is_facebook'];
																																																																																										} else {
																																																																																											echo $clientData['is_facebook'];
																																																																																										}
																																																																																									} ?>">
																		</div>
																	</div>
																<?php }  ?>
																<input type="hidden" name="insta" value="yes">
																<input type="hidden" name="is_insta" value="<?php echo $clientData['is_insta']; ?>">
																<?php
																if ($templateData['is_twitter'] != 'no') { ?>
																	<div class="col-md-12">
																		<div class="form-group">
																			<div class="custom-checkbox">
																				<input type="checkbox" onclick="enableTwitter(this)" name="twitter" id="is_twitter" class="" value="yes" <?php if ($clientData['is_twitter'] != 'no') {
																																																echo 'checked';
																																															} ?>>
																				<label for="is_twitter">Twitter</label>
																			</div>
																			<input type="text" name="is_twitter" class="form-control share-text <?php if ($clientData['is_twitter'] != null) {
																																					echo 'value-filled';
																																				} ?>" style="<?php if ($clientData['is_twitter'] == 'no') {
																																																										echo 'display:none';
																																																									} ?>" id="is_twitter_share" placeholder="Enter share text" value="<?php if ($clientData['is_twitter'] == null) {
																																																																																											echo $templateData['is_twitter'];
																																																																																										} else {
																																																																																											if ($clientData['is_twitter'] == 'no') {
																																																																																												echo  $templateData['is_twitter'];
																																																																																											} else {
																																																																																												echo $clientData['is_twitter'];
																																																																																											}
																																																																																										} ?>">
																		</div>
																	</div>
																<?php }
																if ($templateData['is_linkedin'] != 'no') { ?>
																	<div class="col-md-12">
																		<div class="form-group">
																			<div class="custom-checkbox">
																				<input type="checkbox" onclick="enableLinkedin(this)" name="linkedin" id="is_linkedin" class="" value="yes" <?php if ($clientData['is_linkedin'] != 'no') {
																																																echo 'checked';
																																															} ?>>
																				<label for="is_linkedin">Linkedin</label>
																			</div>
																			<input type="text" name="is_linkedin" class="form-control share-text <?php if ($clientData['is_linkedin'] != null) {
																																						echo 'value-filled';
																																					} ?>" style="<?php if ($clientData['is_linkedin'] == 'no') {
																																																										echo 'display:none';
																																																									} ?>" id="is_linkedin_share" placeholder="Enter share text" value="<?php if ($clientData['is_linkedin'] == null) {
																																																																																												echo $templateData['is_linkedin'];
																																																																																											} else {
																																																																																												if ($clientData['is_linkedin'] == 'no') {
																																																																																													echo  $templateData['is_linkedin'];
																																																																																												} else {
																																																																																													echo $clientData['is_linkedin'];
																																																																																												}
																																																																																											} ?>">
																		</div>
																	</div>

															</div>
														</div>

													<?php }
																if ($templateData['is_email_friend'] != 'no') {
													?>
														<div class="row">
															<div class="col-md-12">
																<div class="form-group">
																	<div class="custom-checkbox">
																		<input type="checkbox" onclick="enableemailfriend(this)" name="is_email_friend" id="is_email_friend" class="" value="yes" <?php if ($clientData['is_email_friend'] != 'no') {
																																																		echo 'checked';
																																																	} ?>>
																		<label for="is_email_friend">Email a friend</label>
																	</div>

																	<div class="row" id="emailfriend" style="<?php if ($clientData['is_email_friend'] == 'no') {
																													echo 'display:none';
																												} ?>">
																		<div class="col-md-12">
																			<div class="form-group">
																				<label for="">Title</label>
																				<input type="text" name="email_friend_title" placeholder="Enter title here" id="email_friend_title" class="form-control share-text" value="<?php if ($clientData['email_friend_title'] == null) {
																																																								echo $templateData['email_friend_title'];
																																																							} else {
																																																								echo $clientData['email_friend_title'];
																																																							} ?>">
																			</div>
																		</div>
																		<div class="col-md-12">
																			<div class="form-group">
																				<label for="email_friend_text">Message</label>
																				<textarea placeholder="Enter message here" id="email_friend_text" class="form-control tweet-mp-text" name="email_friend_text"><?php if ($clientData['email_friend_text'] == null) {
																																																					echo $templateData['email_friend_text'];
																																																				} else {
																																																					echo $clientData['email_friend_text'];
																																																				} ?></textarea>
																			</div>
																		</div>
																	</div>

																</div>
															</div>

														</div>
													<?php }
															}
														}
														if ($templateData['is_tweet_mp'] != 'no') {
															if ($packageData['is_tweet_mp'] != 'no') { ?>
													<div class="row">
														<div class="col-md-12">
															<div class="form-group">
																<div class="toggleWrapper m-l-0">
																	<label for="">Enable tweet MP</label>
																	<input type="checkbox" name="is_tweet_mp" onclick="enabletweetMP(this)" id="tweet_mp" class="dn" value="yes" <?php if ($clientData['is_tweet_mp'] != null) {
																																														if ($clientData['is_tweet_mp'] == 'yes') {
																																															echo 'checked';
																																														}
																																													} else if ($packageData['is_tweet_mp'] == 'yes') {
																																														echo 'checked';
																																													} ?> />
																	<label for="tweet_mp" class="toggle"><span class="toggle__handler"></span></label>
																</div>
															</div>

															<div id="tweetMptext" style="<?php if ($clientData['is_tweet_mp'] == 'no') {
																								echo 'display:none';
																							} ?>">
																<div class="row">
																	<div class="col-md-12">
																		<div class="form-group">
																			<label for="tweetMptext">Mp tweet text</label>
																			<textarea name="tweet_mp_text" id="" placeholder="Write MP tweet text" class="form-control tweet-mp-text <?php if ($clientData['tweet_mp_text'] != null) {
																																															echo 'value-filled';
																																														} ?>"><?php if ($clientData['tweet_mp_text'] == null) {
																	echo $templateData['tweet_mp_text'];
																} else {
																	if ($clientData['tweet_mp_text'] == 'no') {
																		echo  $templateData['tweet_mp_text'];
																	} else {
																		echo $clientData['tweet_mp_text'];
																	}
																} ?></textarea>
																		</div>
																	</div>
																</div>
															</div>

														</div>
													</div>
											<?php }
														} ?>

													</div>
													<?php
													if ($packageData['is_email_share'] != 'no') {
													?>
														<div class="col-md-12" style="display:none;">
															<div class="form-group">
																<div class="toggleWrapper m-l-0">
																	<label for="">Enable email share</label>
																	<input type="checkbox" name="is_email_share" id="email_share" class="dn" value="yes" <?php if ($clientData['is_email_share'] != null) {
																																								if ($clientData['is_email_share'] == 'yes') {
																																									echo 'checked';
																																								}
																																							} else if ($packageData['is_email_share'] == 'yes') {
																																								echo 'checked';
																																							} ?> />
																	<label for="email_share" class="toggle"><span class="toggle__handler"></span></label>
																</div>
															</div>
														</div>
													<?php } ?>
										</div>
										<?php } ?>
									
									</div>
										<!--// new111 -->
											<div class="project-dtails form-group">
										<div class="row">
									    	<div class="col-md-12">
									    	    	<div class="pro-heading">
                        								<h4>Subscribe Mail details</h4>
                        							</div>
												<div class="form-group">
												    <label for="subscribe_mail_text">Text</label>
													<div class="toggleWrapper m-l-0">
														<textarea name="subscribe_mail_text" id="" placeholder="Write subscribing mail text" class="form-control"><?php echo isset($clientData['subscribe_mail_text']) ? $clientData['subscribe_mail_text']: $templateData['subscribe_mail_text'] ;?></textarea>
													</div>
												</div>
												<div class="form-group">
												    <label for="subscribe_mail_address">Address</label>
													<div class="m-l-0">
													    <input type="text" placeholder="Subscribe mail address" value="<?php echo isset($clientData['subscribe_mail_address']) ? $clientData['subscribe_mail_address']: $templateData['subscribe_mail_address'] ;?>" name="subscribe_mail_address" class="form-control"/>
														</div>
												</div>
													<div class="form-group">
												    <label for="subscribe_mail_copyright_title">Copyright Website Name</label>
													<div class="m-l-0">
													   	<input type="text" name="copyright_title" value="<?php echo isset($clientData['copyright_title']) ? $clientData['copyright_title']: $templateData['copyright_title'] ;?>" placeholder="Write copyright title" class="form-control">
														</div>
												</div>
													<div class="form-group">
												    <label for="subscribe_mail_copyright_link">Copyright Website Link</label>
													<div class="m-l-0">
													   	<input type="text" name="copyright_link" value="<?php echo isset($clientData['copyright_link']) ? $clientData['copyright_link']: $templateData['copyright_link'] ;?>" placeholder="Write copyright link" class="form-control">
														</div>
												</div>
											</div>
									</div>
										</div>
													
													<!--// new111 old -->
													
									<!--new -->
			<div class="project-dtails form-group">
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<h4>Privacy Policy</h4>
													<div class="row">
													    	<textarea name="privacypolicy" id="" placeholder="Write privacy policy" class="form-control privacypolicyEditer"><?php echo isset($clientData['privacypolicy']) ? $clientData['privacypolicy']: $templateData['privacypolicy'] ;?></textarea>
												
													</div>
												</div>
											</div>
										</div>
									</div>
							

								<input type="hidden" name="old_logo_file" value="<?php echo $clientData['logofile']; ?>" />
								<input type="hidden" name="id" value="<?php echo $clientData['id']; ?>" />
								<div class="text-center">
									<button type="submit" id="uniquesubmitClientbtn" name="update" value="update" class="btn cus-btn">Update</button>
								</div>
							</form>
						</div>
					</div>
				</div><!-- Panel Content -->
			</div>
		</div>
	</div>
	<script>
		var sucess_msg = localStorage.getItem("message_sucess");
		var error_msg = localStorage.getItem("message_error");
		var error_msg2 = localStorage.getItem("message_error");
		if (sucess_msg != null) {
			document.getElementById("sucessMessage").style.display = 'block';
			document.getElementById("suc_msg").innerHTML = sucess_msg;
			removeMsg('sucessMessage');
		}
		if (error_msg != null) {

			document.getElementById("errorMessage").style.display = 'block';
			document.getElementById("err_msg").innerHTML = error_msg;
		}
		if (error_msg2 != null) {

			document.getElementById("errorMessage2").style.display = 'block';
			document.getElementById("err_msg2").innerHTML = error_msg2;
		}
		var client_setting = localStorage.getItem("message_clientSetting2");
		if (client_setting != null) {

			document.getElementById("sucessclientMessage2").style.display = 'block';
			document.getElementById("suc_clientmsg2").innerHTML = client_setting;
			//removeMsg('sucessclientMessage2');
		}


		localStorage.removeItem("message_clientSetting");
		localStorage.removeItem("message_clientSetting2");
		localStorage.removeItem("message_sucess");
		localStorage.removeItem("message_error");
		localStorage.removeItem("message_error2");
		//removeMsg('sucessclientMessage');
		//removeMsg('errorMessage2');
		//	removeMsg('errorMessage');
		//	removeMsg('sucessMessage');
	</script>
	<script type="text/javascript">
		function checkinique(mcval, client_id) {
			$('.unique-error').html('loading...');
			    if(/[^a-zA-Z0-9\-_/\/]/.test( mcval ) || mcval.toLowerCase().indexOf("/") >= 0 ) {
				$('.unique-error').html('<span class="text-danger">special characters not allowed in UNIQUE-URL !</span>');
				$('#uniquesubmitClientbtn').attr('disabled', 'true');
			} else {
				$('.unique-error').html('loading...');
				$('#uniquesubmitClientbtn').prop("disabled", false);
				$.ajax({
					url: '<?php echo BASE_URL . 'clients/checkunique' ?>',
					type: 'POST',
					data: {
						'unique_url': mcval,
						'client_id': client_id
					},
					dataType: "json",
					success: function(data) {
						console.log(data)
					
						if (data.status == 0) {
						    	$('.unique-error').html('<span class="text-danger">' + data.msg + '</span>');
						    		$('#uniquesubmitClientbtn').attr('disabled', 'true');
							$('.unique-error').focus();
						}
						if (data.status == 1) {
						    	$('#uniquesubmitClientbtn').attr('disabled', false);
						    	$('.unique-error').html('<span class="text-success">' + data.msg + '</span>');
						}
					}
				});
			}
		}
	</script>