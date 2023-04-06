<?php
if(!empty($projectData)){
	$packageData=null;
	$clientData = null;
	$data=$projectData[0];
	$mid = $data['id_map_template'];
	$pass = null;
	$cid = $data['id_client'];
	if ($cid != null){
		$clientResult = $mthis->model->getClientsById($cid);
		if (!empty($clientResult)){
			$clientData = $clientResult[0];
			$clientname = $clientData['name'];
			$client_unique_url = $clientData['unique_url'];
			$pid = $clientData['package'];
			if($clientData['is_suspended'] != 0 && USERROLE != 1){
				header('location:'.BASE_URL.'projects');
			}
			$packageQuery = $mthis->model->getPackageById($pid);
			if (!empty($packageResult)){
				$packageData = $packageQuery[0];
			}
		}
	} else {
		$clientData = null;
		$client_unique_url = '';
	}
	if ($data['password'] != null) {
		$pass = openssl_decrypt(hex2bin($data['password']), 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
	}
?>

<div class="page-header-wrap">
    <h3>View Project </h3>
    <!--<div class="export-menu">-->
    <!--    <a href="javascript:void(0)" onclick="editForm()" title="" class="btn cus-btn">-->
    <!--        <i class="fa green fa-edit"></i>-->
    <!--        <span>Edit </span>-->
    <!--    </a>-->
    <!--</div>-->
</div>
<ul class="nav nav-pills custom-tabs">
    <li id="li1" onclick="mytabFun('li1','#1a')">
        <a href="#1a" class="custom-tab-child" data-toggle="tab">General</a>
    </li>
    <li id="li2" onclick="mytabFun('li2','#2a')">
        <a href="#2a" class="custom-tab-child" data-toggle="tab">Settings</a>
    </li>
    <li id="li3" onclick="mytabFun('li3','#3a')">
        <a href="#3a" class="custom-tab-child" data-toggle="tab">Nodes</a>
    </li>
    <li id="li4" onclick="mytabFun('li4','#4a')">
        <a href="#4a" class="custom-tab-child" data-toggle="tab">Data fields</a>
    </li>
    <li id="li7" onclick="mytabFun('li7','#7a')">
        <a href="#7a" class="custom-tab-child" data-toggle="tab">Groups</a>
    </li>
    <li id="li6" onclick="mytabFun('li6','#6a')">
        <a href="#6a" class="custom-tab-child" data-toggle="tab">Import/Export</a>
    </li>
       <li id="li8" onclick="mytabFun('li8','#8a')">
        <a href="#8a" class="custom-tab-child" data-toggle="tab">Chart Wizard</a>
    </li>
    <li id="li5" onclick="mytabFun('li5','#')">
        <a href="#" class="custom-tab-child" data-toggle="tab">view all sections</a>
    </li>
</ul>
<div class="tab-content clearfix">
    <div class="widget">
        <div class="table-area addpackages edit-project">
            <div class="message"></div>
            <div class="alert alert-success" id="sucessMessage" style="display: none;">
                <p id="suc_msg"></p>
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
            <div class="row">
                <div class="tab-pane" id="1a">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="project-dtails">
                                        <form action="javascript:void(0)" id="update_datasetdetails" method="post">
                                            <div class="pro-heading">
                                                <h4>Data Set Details</h4>
                                                  <a href="javascript:void(0)" onclick="editprojectname()" title="" class="btn align-right cus-btn">
                                <i class="fa green fa-edit"></i>
                                <span> </span>
                            </a>
                                            </div>
                                            <div class="pro-details-inner">
                                                <div class="inner-details">
                                                    <label>
                                                        Name:
                                                    </label>
                                                    <p class="data-value"><?php echo $data['name']; ?>
                                                    </p>
                                                </div>
                                                <div class="inner-details">
                                                    <label>
                                                        Key:
                                                    </label>
                                                    <p class="data-value"><?php echo $pId; ?></p>
                                                </div>
                                            </div>
                                            <input type="hidden" name="step" value="1">
                                            <input type="hidden" name="project_id" value="<?php echo $projectId; ?>">
                                            
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="project-dtails inr-frm form-group">
                            <form action="javascript:void(0)" id="uniquesubmitbtnform" method="post">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="pro-heading">
                                                <h4>Unique Url</h4>
                                                  <?php 
                                                  if(!empty($data['unique_url'])){
                                                       
                                                        $url =$data['unique_url'];
                                                  }else{
                                                      $url =$data['proKey'];
                                                  }
                                                ?>
                                                <div>
                                                 <a id="download_svg" target="_blank" href="<?php  echo BASE_URL; ?>?dataSetKey=<?php echo $url;?>&client=<?php echo $client_unique_url; ?>&download=true" class="btn btn-success tool" data-tip="download Map svg"><span><i class="fa fa-download"></i></span></a>
                                                 <a id="fronturl" target="_blank" href="<?php echo BASE_URL; ?>?dataSetKey=<?php echo $url;?>&client=<?php echo $client_unique_url; ?>" class="btn btn-success tool" data-tip="View"><span><i class="fa fa-location-arrow"></i></span></a>
                                                  </div>
                                            </div>
                                            
                                                	  <span class="input-group-text my-badge"
                                                id="unique_urlS"><?php echo BASE_URL; ?>?dataSetKey=<?php echo $url;?>&client=<?php echo $client_unique_url; ?></span>
                                            <!--<span class="input-group-text my-badge"-->
                                                <!--id="unique_urlS">/<?php //if($clientData['unique_url'] != null){ echo $clientData['unique_url']; } else{ echo str_replace(' ', '', $clientname); } ?>/<?php// if($data['unique_url'] == null){ echo str_replace(' ', '', $data['name']); } else { echo $data['unique_url']; } ?></span>-->
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="project_id" value="<?php echo $projectId; ?>">
                                            <input type="text" class="form-control"
                                                onkeyup="checkinique(this.value,'<?php echo $projectId; ?>')" name="unique_url"
                                                id="unique_url" placeholder="Unique URL"
                                                <?php $url = str_replace('-', ' ',$data['name']); ?>
                                                value="<?php if($data['unique_url'] == null){echo strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9 ]/', '', $url)));
                                                } else { 
                                                echo $data['unique_url'];} 
                                                ?>">
                                            <span class="unique-error error-msg-span"></span>
                                        </div>
                                    </div>
                                </div>
                                <input type="submit" class="btn cus-btn" id="uniquesubmitbtn" name="unique_update" value="Submit">
                            </form>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="project-dtails">
                                        <form action="javascript:void(0)" id="update_datasetvisualsForm" method="post"
                                            enctype="multipart/form-data">
                                            <div class="pro-heading">
                                                <h4>Visuals</h4>
                                                 <a href="javascript:void(0)" onclick="editVisuals()" title="" class="btn align-right cus-btn">
                                <i class="fa green fa-edit"></i>
                                <span> </span>
                            </a>
                                            </div>
                                            <div class="pro-details-inner">
                                                <div class="inner-details">
                                                    <label>
                                                        Title:
                                                    </label>
                                                    <p class="data-value"><?php echo $data['title']; ?></p>
                                                </div>
                                                <?php
											if ($packageData['is_logo'] != 'no') {
											?>
                                                <div class="inner-details">
                                                    <label>
                                                        Logo:
                                                    </label>
                                                    <?php if ($data['logo'] != null) {
														$logofile = $data['logo'];
													?>
                                                    <img src="<?php echo '/uploads/' . $logofile;  ?>"
                                                        class="data-value" />
                                                    <?php
													} 
														else if ($data['logourl'] != null) {
                										?>
                                                    <img src="<?php echo $data['logourl']; ?>" class="data-value" />
                                                    <?php
                										} 
														else if ($clientData['logo'] != null) { ?>
                                                    <img src="<?php echo $clientData['logo'];  ?>" class="data-value" />
                                                    <?php
													} 
													else if ($clientData['logofile'] != null) {
														$logofile = $clientData['logofile'];
													?>
                                                    <img src="<?php echo BASE_URL.'uploads/' . $logofile;  ?>"
                                                        class="data-value" />
                                                    <?php
													}
													?>
                                                </div>
                                                <?php }   ?>
                                                <!--<div class="inner-details">-->
                                                <!--    <label>-->
                                                <!--        Description:-->
                                                <!--    </label>-->
                                                   
                                                <!--    <p class="data-value"><?php // echo $data['description'];  ?></p>-->
                                                <!--</div>-->
                                                
                                                <div class="inner-details">
                                                    <label>
                                                        Primary Color:
                                                    </label>
                                                    <span
                                                        class="colour-value ng-binding"><?php if($data['primary_color'] == null){ echo $clientData['primary_color']; }else{ echo $data['primary_color']; } ?></span>
                                                    <span class="colour-preview"
                                                        style="background-color:<?php if($data['primary_color'] == null){ echo $clientData['primary_color']; }else{ echo $data['primary_color']; } ?>"></span>
                                                </div>
                                                <div class="inner-details">
                                                    <label>
                                                        Secondary Color:
                                                    </label>
                                                    <span
                                                        class="colour-value ng-binding"><?php if($data['secondary_color'] == null){ echo $clientData['secondary_color']; }else{ echo $data['secondary_color']; } ?></span>
                                                    <span class="colour-preview"
                                                        style="background-color:<?php if($data['secondary_color'] == null){ echo $clientData['secondary_color']; }else{ echo $data['secondary_color']; } ?>"></span>
                                                </div>
                                                  <div class="inner-details">
                                                    <label>
                                                        Text Color 1:
                                                    </label>
                                                    <span
                                                        class="colour-value ng-binding"><?php if($data['text_color'] == null){ echo $clientData['text_color']; }else{ echo $data['text_color']; } ?></span>
                                                    <span class="colour-preview"
                                                        style="background-color:<?php if($data['text_color'] == null){ echo $clientData['text_color']; }else{ echo $data['text_color']; } ?>"></span>
                                                </div>
                                                 <div class="inner-details">
                                                    <label>
                                                        Text Color 2:
                                                    </label>
                                                    <span
                                                        class="colour-value ng-binding"><?php if($data['text_color2'] == null){ echo $clientData['text_color2']; }else{ echo $data['text_color2']; } ?></span>
                                                    <span class="colour-preview"
                                                        style="background-color:<?php if($data['text_color2'] == null){ echo $clientData['text_color2']; }else{ echo $data['text_color2']; } ?>"></span>
                                                </div>
                                                 <div class="inner-details">
                                                    <label>
                                                        Text Color 3:
                                                    </label>
                                                    <span
                                                        class="colour-value ng-binding"><?php if($data['text_color3'] == null){ echo $clientData['text_color3']; }else{ echo $data['text_color3']; } ?></span>
                                                    <span class="colour-preview"
                                                        style="background-color:<?php if($data['text_color3'] == null){ echo $clientData['text_color3']; }else{ echo $data['text_color3']; } ?>"></span>
                                                </div>


                                                <div class="inner-details">
                                                    <label>
                                                        Key colours:
                                                    </label>
                                                    
                                                    <div class="data-value-wrap">
                                                        <?php if ($data['key_colors'] != null) {
														$colorArray = unserialize($data['key_colors']);
													} else if ($clientData['colours'] != null) {
														$colorArray = unserialize($clientData['colours']);
													} else {
														$colorArray = null;
													}
													if ($colorArray != null) {
														foreach ($colorArray as $color) { ?>
                                                        <div class="data-value">
                                                            <div class="color-flex">
                                                                <span
                                                                    class="colour-value ng-binding"><?php echo $color; ?></span>
                                                                <span class="colour-preview"
                                                                    style="background-color:<?php echo $color; ?>"></span>
                                                            </div>
                                                        </div>
                                                        <?php }
													}  ?>
                                                    </div>

                                                </div>
                                                <!--<div class="inner-details">-->
                                                <!--    <label>-->
                                                <!--        Footer content:-->
                                                <!--    </label>-->
                                                    
                                                <!--    <div>-->
                                                <!--        <p class="data-value"><?php// echo $data['footer_content'];  ?>-->
                                                <!--        </p>-->
                                                <!--    </div>-->
                                                <!--</div>-->
                                            </div>
                                            <input type="hidden" name="project_id" value="<?php echo $projectId; ?>">
                                            <input type="hidden" name="step" value="2">
                                        </form>
                                    </div>
                                </div>
<div class="col-md-12 project-dtails">
<div class="form-group">
<label>Logo</label>
<input type="checkbox" value="1" name="iframe_logo" id="iframe_logo">
</div>
<div class="form-group">
<label>Location Dropdown</label>
<input type="checkbox" value="1" name="iframe_location" id="iframe_location">
</div>
<div class="form-group">
<label>Share Icon</label>
<input type="checkbox" value="1" name="iframe_share_icon" id="iframe_share_icon">
</div>
<div class="form-group">
<label>Intro Text</label>
<input type="checkbox" value="1" name="iframe_introtext" id="iframe_introtext">
</div>
<div class="form-group">
<label>Footer</label>
<input type="checkbox" value="1" name="iframe_footer" id="iframe_footer">
</div>
<div class="form-group">
<label></label>
<button type="button" class="btn btn-info btn-sm"  id="iframe_generate_btn" onclick="generate_iframe()">Generate Code</button>
</div>
<div class="form-group">
<textarea id="iframe_generated_code" class="form-control"></textarea>
</div>
<div class="form-group">
<button type="button" class="btn btn-warning btn-sm"  id="iframe_generate_btn" onclick="copy_iframe_code()">Copy Code</button>
</div>
</div>								
                            </div>
                        </div>
		<div class="form-group">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="project-dtails">
                                                      
                                      
                                            <div class="pro-heading">
                                                <h4>Content</h4>
                            <a href="javascript:void(0)" onclick="editContent()" title="" class="btn align-right cus-btn">
                                <i class="fa green fa-edit"></i>
                                <span> </span>
                            </a>
                                            </div>
                                            <div class="pro-details-inner foo-desc-inr">
                                                 <div class="inner-details">
                                                    <label>
                                                        Node Intro Text:
                                                    </label>
                                                    <div>
                                                        <p class="data-value"><?php echo $data['node_intro'];  ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="inner-details">
                                                    <label>
                                                        Node Description:
                                                    </label>
                                                    <div>
                                                        <p class="data-value"><?php echo $data['node_description'];  ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                  <div class="inner-details">
                                                    <label>
                                                        Print Description:
                                                    </label>
                                                    <div>
                                                        <p class="data-value"><?php echo $data['print_description'];  ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="inner-details">
                                                    <label>
                                                        Footer content:
                                                    </label>
                                                    <div>
                                                        <p class="data-value"><?php echo $data['footer_content'];  ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                  
                                                
                                            </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane group-tab" id="7a">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="project-dtails">
                                <div class="pro-details-inner">
                                    <div class="datafields">
                                        <div class="pro-heading">
                                            <h4>Groups</h4>
                                        </div>

                                        <?php 
										        $uid = $_SESSION['uid'];
										       $groupData = $mthis->model->getProjectGroupClientId($cid); 
										  ?>
                                        <form action="javascript:void(0)" id="updateProjectingroupform" method="post">
                                            <div class="form-group">
                                                <div class="row">
                                                    <input name="cid" type="hidden" value="<?php echo $cid; ?>" />
                                                    <input name="pid" type="hidden" value="<?php echo $projectId; ?>" />
                                                    <?php
                                                        $prokey = $data['proKey'];
                                                        $redirect_url =  BASE_URL."projects/viewprojects/".$prokey;  ?>
                                                    <input name="redirect_url" type="hidden"
                                                        value="<?php echo $redirect_url; ?>" />
                                                    <!--<input name="projects[]" type="hidden" value="<?php //echo $projectId; ?>"/>-->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">Add This Project To Group</label>
							<select class="form-control js-select2clients required" multiple name="group[]" id="">
										<?php 
										if(!empty($groupData)){
											foreach($groupData as $gdata){ $grpProject = $gdata['projects'];
												if($grpProject != null){
														$grpProject = unserialize($gdata['projects']);
												}else{
													$grpProject = array();
												} ?>
	<option value="<?php echo $gdata['id'];  ?>"<?php if(in_array($projectId,$grpProject)){ echo 'selected'; } ?>> <?php echo $gdata['name'];  ?></option>
										<?php } } ?>
							</select>
                                                            <span class="error">Projects is required</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="">
                                                <button type="button" id="updateProjectingroupbtn" name="submit"
                                                    value="submit" class="btn cus-btn">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="project-dtails">
                                <div class="pro-details-inner">
                                    <div class="datafields">
                                        <div class="pro-heading">
                                            <h4>Create a new group and add this project to it
                                            </h4>
                                        </div>

                                        <form action="javascript:void(0)" id="addProjectgroupForm" method="post">
                                            <div class="form-group">

                                                <div class="row">

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">Group name</label>
                                                            <input type="text" class="form-control required"
                                                                name="gname" id="gname" placeholder="Group name">
                                                            <span class="error">Group name is required</span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">Description</label>
                                                            <textarea class="form-control" name="description"
                                                                id="description" placeholder="Description"></textarea>

                                                        </div>
                                                    </div>
                                                    <input name="cid" type="hidden" value="<?php echo $cid; ?>" />
                                                    <?php
                                                        $prokey = $data['proKey'];
                                                        $redirect_url =  BASE_URL."projects/viewprojects/".$prokey;  ?>
                                                    <input name="redirect_url" type="hidden"
                                                        value="<?php echo $redirect_url; ?>" />
                                                 
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">Select Projects</label>
                                                            <select
                                                                class="form-control js-select2clients required appendData"
                                                                multiple name="projects[]" id="">
                                   <?php $allprojectsClients = $mthis->model->getProjectByClientId($cid);
								   if(!empty($allprojectsClients)){
                                       foreach($allprojectsClients as $apclientspro){ ?>
                                                                <option
                                                                    value="<?php echo $apclientspro['id_project'];  ?>"
                                                                    <?php if($apclientspro['id_project'] == $projectId){ echo 'selected'; } ?>>
                                                                    <?php echo $apclientspro['name'];  ?></option>
                                                                <?php
										} }
                                                                ?>
                                                            </select>
                                                            <span class="error">Projects is required</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="">
                                                <button type="button" id="addProjectgroupbtn" name="submit"
                                                    value="submit" class="btn cus-btn">Add</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="6a">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="project-dtails import-export">
                                <div class="pro-heading">
                                    <h4>Import/Export</h4>
                                </div>
                                <ul>
                                    <li>
                                        <a href="<?php echo BASE_URL.'export/datasetkey/'.$pId; ?>"
                                            target="_blank" class="">
                                            <i class="fa fa-upload" aria-hidden="true"></i>
                                            <span>Export Data</span>
                                        </a>
                                    </li>
                                    <li>

                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#ImportModal">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                            <span>Import Data</span>
                                        </a>

                                    </li>
									<li>
                                        <a href="javascript:void(0)" onclick="viewImportedNodes('<?php echo $projectId;  ?>','<?php echo BASE_URL.'export/view'; ?>')">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                            <span>View Data</span>
                                        </a>
                                        <img id="loaderedit" style="display:none" src="<?php echo BASE_URL.'public/web/'; ?>images/ajax-loader.gif">
                                    </li>
									
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                  <div class="tab-pane group-tab" id="8a">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="project-dtails">
                                <div class="pro-heading">
                                    <h4>Chart Wizard</h4>
                                </div>
                        <div class="chart_wizard">
                            <form action="javascript:void(0)" id="addChart" method="post">
                                            <div class="form-group">
                                                <div class="row">

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">Chart Name</label>
                                                            <input type="text" class="form-control required" name="chart_name" id="cname" placeholder="Chart name">
                                                            <span class="error" style="display: none;">Chart name is required</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">Display Name</label>
                                                            <input type="text" class="form-control" name="chart_display_name" id="c_displayname" placeholder="Chart display name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Horizontal Label</label>
                                                            <input type="text" class="form-control" name="x_axis" id="x_axis" placeholder="Horizontal label">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Vertical Label</label>
                                                            <input type="text" class="form-control" name="y_ayis" id="y_axis" placeholder="Vertical label">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="" class="lowercase">Is graph for node or national pages ?</label>
                                                            <div class="graphFor radio-g-m">
                                                            <div class="radio-g">
                                                           <input type="radio" class="form-control" name="graphfor" id="graphfornode" value="Node" checked>
                                                           <label for="graphfornode">Node</label>
                                                           </div>
                                                           <div class="radio-g">
                                                           <input type="radio" class="form-control" name="graphfor" id="graphfornationalpages" value="National">
                                                            <label for="graphfornationalpages">National</label>
                                                            </div>
                                                           </div>
                                                        </div>
                                                    </div>
                                                    
                                                     <div class="col-md-12">
                                                     <div class="toggleWrapper">
                                                    <label for="" class="lowercase">Show Average in Node View</label>
                                                    <input type="checkbox" name="hide_average" id="hide_average" class="dn" value="yes"/>
                                                    <label for="hide_average" class="toggle"><span
                                                            class="toggle__handler"></span></label>
                                                </div>
                                                 </div>
                                                 
                                                      <div class="col-md-12">
                                                         <div class="form-group">
                                                            <label for="">Average Color</label>
                                                              <div class="colorBoxm">
                                                                <input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="#000000">
                                                                <input type="color" class="colorInput" name="average_color" onchange="colorChange(this)" id="average_color" value="#000000">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
<div class="col-md-12">
<div class="form-group">
	<label for="" class="lowercase">What type of graph do you want to create ?</label>
	<div class="graph_type">
	 <select name="graph_type" id="graph_type_box" class="form-control">
	 <option value="Bar" >Bar</option>
	 <option value="Line">Line</option>
	 <option value="Column">Column</option>
	 <option value="Pie">Pie</option>
	 <option value="Donut">Donut</option>
	 <option value="Simpletable">Simple Table</option>
	 </select>
  
   </div>
</div>
</div>
										<div class="equal-height">
                                            <div class="col-md-6 equal-height-node">
                                                        <div class="form-group">
                                                            <label for="">Select field to display</label>
                                                            <div class="datafields_data">
                                                               
                                                       <div class="droptarget" id="allFacets" ondrop="drop(event)" ondragover="allowDrop(event)">
                                                           
                                                           <?php 
                                                            $prokeycolor = $data['key_colors'];
                                                        if ($prokeycolor != null) {
                                                            $prokeycolor = unserialize($prokeycolor);
                                                        } else {
                                                            $prokeycolor = [];
                                                        }
														   if(!empty($datafieldsWithoutChild)){
                                                           foreach($datafieldsWithoutChild as $key => $dparent){
                                                               
                                                               if($dparent['isGroup']){ ?>

                                                            <!-- <div class="group-fields-item-div"> -->

                                                                <div class="fields-item group-fields-item">
                                                                    <input type="text" disabled class="disabled" value="<?php echo $dparent['field_name']; ?>" readonly>
                                                                </div>

                                                            <?php
                                                                $parentId = $dparent['id_project_field'];
                                                                            
                                                            $datafieldsChild = $mthis->model->getProjectFieldsByParentId($parentId);
                                                            if(!empty($datafieldsChild)){ 
                                                                foreach($datafieldsChild as $dchild){ ?>
                                                                <div class="fields-item children">
                                                           <p ondragstart="dragStart(event)" ondrag="dragging(event)" draggable="true" id="<?php echo $dchild['id_project_field']; ?>" class="dfield_name"><?php echo $dchild['field_name']; ?></p>
                                                           <div class="colorBoxm">
                                                                <input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="<?php echo isset($prokeycolor[$key]) ? $prokeycolor[$key] : '#000000'; ?>">
                                                                <input type="color" class="colorInput" name="field_color[]" onchange="colorChange(this)" id="colors" value="<?php echo isset($prokeycolor[$key]) ? $prokeycolor[$key] : '#000000'; ?>">
                                                            </div>
                                                           </div>
                                                                    
                                                             <?php  }  ?>
                                                    
                                                    <?php  } ?>


                                                                <!-- </div> -->


                                                             

                                                              <?php }else{ ?>
                                                                   
                                                             

                                                            <div class="fields-item">
                                                           <p ondragstart="dragStart(event)" ondrag="dragging(event)" draggable="true" id="<?php echo $dparent['id_project_field']; ?>" class="dfield_name"><?php echo $dparent['field_name']; ?></p>
                                                           <div class="colorBoxm">
                                                                <input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="<?php echo isset($prokeycolor[$key]) ? $prokeycolor[$key] : '#000000'; ?>">
                                                                <input type="color" class="colorInput" name="field_color[]" onchange="colorChange(this)" id="colors" value="<?php echo isset($prokeycolor[$key]) ? $prokeycolor[$key] : '#000000'; ?>">
                                                            </div>
                                                           </div>
                                                              
                                                                 <?php
                                                               }
                                                               
                                                                 } } ?> 


</div>

                                                          
                                                           </div>
                                                        </div>
                                                    </div>
                                            <div class="col-md-6 equal-height-node">
                                                    <div class="form-group">
                                                    <label for="">Selected</label> 
<div class="droptarget" ondrop="drop(event)" ondragover="allowDrop(event)" id="selected_fields"></div>
                                                    </div>
                                                    </div>
                                                    </div>
                                                    
                                                      <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">Chart width</label>
                                                            <div class="graphFor radio-g-m">
                                                             <div class="radio-g">
                                                           <input type="radio" class="form-control" name="mapwidth" id="mapwidthhalf" value="half_width" checked>
                                                           <label for="mapwidthhalf">Half width</label>
                                                           </div>
                                                           <div class="radio-g">
                                                           <input type="radio" class="form-control" name="mapwidth" id="mapwidthfull" value="full_width">
                                                            <label for="mapwidthfull">Full width</label>
                                                            </div>
                                                           </div>
                                                        </div>
                                                    </div>
                                                     

                                                  
                                                </div>
                                            </div>
                                            <div class="">
 <input type="hidden" class="form-control" name="proid" id="proid" value="<?php echo $projectId; ?>">
                                                <button type="button" id="addChartBtn" name="submit" value="submit" class="btn cus-btn">Add</button>
                                            </div>
                                        </form>
                        </div>
                            </div>
                        </div>
                    </div>
													
                       <div class="col-md-6">
                        <div class="form-group">
                            <div class="project-dtails">
                                <div class="pro-heading">
                                    <h4>Chart Wizard List</h4>
                                </div>
                        <div class="chart_wizard">
                            <button class="btn btn-sort" onclick="saveshortingchart('chart_wizard')">
                       <i class="fa fa-sort"></i>
                       <span>Sort</span>
                   </button>
                            <ul class="dragDrop">
                  <?php 
				  if(!empty($chartWizard)){
                  $countchart = 0;
                  foreach($chartWizard as $chart){
                      $countchart++;
                      ?>
                      <li>
                             <div>
                                  <span class="count"><?php echo $countchart; ?></span>
                          <label><?php echo $chart['name']; ?></label>
                          <span class="badge"><?php echo $chart['graph_for']; ?></span>
                             </div>
                         <div>
                              <a class="btn btn-danger tool" onclick="return letsconfirm('Are you sure you want to Delete?<?php echo $chart['name']; ?>','<?php echo BASE_URL; ?>projects/deletechart/<?php echo $chart['id'];  ?>')" href="javascript:void(0)" data-tip="Delete"><i class="fa red fa-trash"></i></a>
                     <a class="btn btn-info tool" href="javascript:void(0)" data-tip="Edit" onclick="getChartWizard('<?php echo $chart['id']; ?>','<?php echo $projectId; ?>')"><i class="fa green fa-edit"></i></a>
                         </div>
                    <span class="indexc" style="display:none"><?php echo $chart['sequence_no']; ?></span>
                    <input type="hidden" value="<?php echo $chart['id']; ?>" name="shortposition[]" class="shortposition">
                      </li>
				  <?php } } ?>
				  </ul>
                        </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="4a">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="project-dtails">
                                <div class="pro-details-inner">
                                    <div class="datafields">
                                        <div class="pro-heading">
                                            <h4>Data Fields</h4>
                                        </div>
                                        <div class="datafields_main">
                                            <section id="demo">
                                                <ol
                                                    class="sortable ui-sortable mjs-nestedSortable-branch mjs-nestedSortable-expanded">

                                                    <!--- Initial Menu Items --->
                                                    <?php $count = 0;
													if(!empty($dataFieldsData)){
											               	foreach ($dataFieldsData as $dataf){ 
											               	   if($dataf['parentId'] == 0){
											               	$count++;
											               	?>


                                                    <li style="display: list-item;"
                                                        class="mjs-nestedSortable-branch mjs-nestedSortable-expanded <?php if($dataf['isGroup'] == 1){ echo 'group-true'; } ?>"
                                                        id="menuItem_<?php echo $dataf['id_project_field']; ?>">
                                                        <span class="index" style="display:none"><?php echo $count; ?></span>
                                                        <input type="hidden" style="display:none" name="shortposition[]"  value="<?php echo $dataf['id_project_field']; ?>" />
                                                        <div class="menuDiv">
                                                             <div class="custom-group-b">
                                                            <div>
                                                            <span title="Click to show/hide children"
                                                                class="disclose ui-icon ui-icon-minusthick">
                                                                <span></span>
                                                            </span>
                                                            <span title="Click to show/hide item editor"
                                                                data-id="<?php echo $dataf['id_project_field']; ?>"
                                                                class="expandEditor ui-icon ui-icon-triangle-1-n">
                                                                <span></span>
                                                            </span>
                                                            <span>
                                                                <span
                                                                    data-id="<?php echo $dataf['id_project_field']; ?>"
                                                                    class="itemTitle"><?php echo $dataf['field_name'];  ?></span>
                                                                <span title="Click to delete item."
                                                                    data-id="<?php echo $dataf['id_project_field']; ?>"
                                                                    class="deleteMenu ui-icon ui-icon-closethick">
                                                                    <span></span>
                                                                </span>
                                                            </span>
                                                            </div>
                                                            
                                                            
                				<div class="group-btn toggleWrapper">
                        				<div class="form-group">
                        					<label for="">Is group</label>
                        					<input type="checkbox" name="is_datagroup"
                        						onclick="isdatagroup(this,'<?php echo $dataf['id_project_field']; ?>')"
                        						id="is_datagroup<?php echo $dataf['id_project_field']; ?>"
                        						<?php if($dataf['isGroup'] == 1){ echo 'checked'; } ?>
                        						class="dn" value="1">
                        					<label
                        						for="is_datagroup<?php echo $dataf['id_project_field']; ?>"
                        						class="toggle"><span
                        							class="toggle__handler"></span></label>
                        				</div>
                        		</div>
                        		<!--Restrict Children restrict_children-->
                        		<div style="<?php if($dataf['isGroup'] == 1){ echo 'display:block'; }else { echo 'display:none'; } ?>" class="restrict_children-btn group-btn toggleWrapper rcb<?php echo $dataf['id_project_field']; ?>">
                        				<div class="form-group">
                        					<label for="">Restrict Children’s Options</label>
                        					<input type="checkbox" name="restrict_children"
                        						onclick="isdatagroupBYRestrictChildren('<?php echo $dataf['id_project_field']; ?>')"
                        						id="restrict_children<?php echo $dataf['id_project_field']; ?>"
                        						<?php if($dataf['restrict_children'] == 1){ echo 'checked'; } ?>
                        						class="dn" value="1">
                        					<label
                        						for="restrict_children<?php echo $dataf['id_project_field']; ?>"
                        						class="toggle"><span
                        							class="toggle__handler"></span></label>
                        				</div>
                        		</div>
                        		
                        		
                        		
                                                           </div>
                                                            <div id="menuEdit<?php echo $dataf['id_project_field']; ?>"
                                                                class="menuEdit hiddenDiv">
                                                                <div class=""
                                                                    id="id<?php echo $dataf['id_project_field']; ?>">
                                                                    <div class="datafieldsall">
                                                                        <label>Description: </label>
                                                                        <span><?php echo $dataf['description']; ?></span>
                                                                    </div>
                                                                    <div class="datafieldsall">
                                                                        <label>Data type: </label>
                                                                        <span><?php echo $dataf['field_type']; ?></span>
                                                                    </div>
                                                   <?php $field_data = json_decode($dataf['field_data']); ?>
                                                    <?php if (!$field_data->comparable != 'true') { ?>
                                                                    <div class="datafieldsall">
                                                                        <label> Display data on heatmap: </label>
                                                                        <span><?php if (!$field_data->comparable != 'true') {
																		echo 'Yes';
																	} else {
																		echo 'No';
																	} ?></span>
                                                                    </div>
                                                                    <?php  } 
                                                                    
                                                                    if ($dataf['hide_node'] == 'yes') { ?>
                                                                        <div class="datafieldsall">
                                                                            <label>Hide field on node view:
                                                                            </label>
                                                                            <span>Yes</span>
                                                                        </div>
                                                                        <?php  } 
                                                                    
                                                                    ?>
                                                                   <?php  
                                                                    
                                                                    if ($dataf['hide_empty_valu_on_node'] == 'yes') { ?>
                                                                        <div class="datafieldsall">
                                                                            <label>Hide empty values on node view:
                                                                            </label>
                                                                            <span>Yes</span>
                                                                        </div>
                                                                        <?php  } 
                                                                    
                                                                    ?>
                                                                    <?php 
                                                                    if($dataf['field_type'] == 'Text' || $dataf['field_type'] == 'Hyperlink'){}else{
                                                                        ?>
                                                                            <div class="datafieldsall" style="display: none;">
                                                                        <label> Grouping Method: </label>
                                                                        <span><?php echo $field_data->groupingMethod; ?></span>
                                                                    </div>
                                                                        <?php 
                                                                    }
                                                                    ?>
                                                                    <?php if ($field_data->graphType != '') { ?>
                                                                    <div class="datafieldsall">
                                                                        <label> Graph Type: </label>
                                                                        <span><?php echo $field_data->graphType; ?></span>
                                                                    </div>
                                                                    <?php  } ?>

                                                                    <?php
                                                                    // if ($field_data->groupingMethod != '') { ?>
                                                                    <!-- <div class="datafieldsall">
                                                                        <label> Grouping method: </label>
                                                                        <span>
                                                                            <?php
                                                                            // echo $field_data->groupingMethod; ?></span>
                                                                    </div> -->
                                                                    <?php // } ?>
                                                                    <?php if (!$field_data->includeAverageInNodeGraphs != 'true') { ?>
                                                                    <div class="datafieldsall">
                                                                        <label> Show average:
                                                                        </label>
                                                                        <span><?php if (!$field_data->includeAverageInNodeGraphs != 'true') {
																		echo 'Yes';
																	} else {
																		echo 'No';
																	} ?></span>
                                                                    </div>
                                                                    <?php  } ?>
                                                                    <?php if ($field_data->averageOverride != '') {  ?>
                                                                    <div class="datafieldsall">
                                                                        <label> Override calculated average:
                                                                        </label>
                                                                        <span><?php if (!$field_data->averageOverride != '') {
																		echo 'No';
																	} else {
																		echo $field_data->averageOverride;
																	} ?></span>
                                                                    </div>
                                                                    <?php  } ?>
                                                                    <?php if (!$field_data->showChartDatasetSummary != 'true') {  ?>
                                                                    <div class="datafieldsall">
                                                                        <label> Show chart in the data set summary:
                                                                        </label>
                                                                        <span><?php if (!$field_data->showChartDatasetSummary != true) {
																		echo 'Yes';
																	} else {
																		echo 'No';
																	} ?></span>
                                                                    </div>
                                                                    <?php  }  ?>
                                                                    <?php if (!$field_data->showChartDatasetSummary != 'true') {  ?>
                                                                    <div class="datafieldsall">
                                                                        <label> Exclude minimum from data set summary
                                                                            chart: </label>
                                                                        <span><?php if (!$field_data->excludeMinFromDataSetSummaryGraph != true) {
																		echo 'Yes';
																	} else {
																		echo 'No';
																	} ?></span>
                                                                    </div>
                                                                    <?php  }  ?>
                                                                    <?php if (!$field_data->showChartDatasetSummary != 'true') {  ?>
                                                                    <div class="datafieldsall">
                                                                        <label> Exclude maximum from data set summary
                                                                            chart: </label>
                                                                        <span><?php if (!$field_data->excludeMaxFromDataSetSummaryGraph != true) {
																		echo 'Yes';
																	} else {
																		echo 'No';
																	} ?></span>
                                                                    </div>
                                                                    <?php  }  ?>
                                                                    <?php if (!$field_data->showChartDatasetSummary != 'true') {  ?>
                                                                    <div class="datafieldsall">
                                                                        <label> Exclude average from data set summary
                                                                            chart: </label>
                                                                        <span><?php if (!$field_data->excludeAverageFromDataSetSummaryGraph != true) {
																		echo 'Yes';
																	} else {
																		echo 'No';
																	} ?></span>
                                                                    </div>
                                                                    <?php  }  ?>
                                                                    <?php if (!$field_data->showTotalInDataSetSummary != 'true') {  ?>
                                                                    <div class="datafieldsall">
                                                                        <label> Show total in the data set summary:
                                                                        </label>
                                                                        <span><?php if (!$field_data->showTotalInDataSetSummary != true) {
																		echo 'Yes';
																	} else {
																		echo 'No';
																	} ?></span>
                                                                    </div>
                                                                    <?php  }  ?>
                                                                    <?php if (!$field_data->isMultivalued != 'true') {  ?>
                                                                    <div class="datafieldsall">
                                                                        <label> Multivalued: </label>
                                                                        <span><?php if (!$field_data->isMultivalued != true) {
																		echo 'Yes';
																	} else {
																		echo 'No';
																	} ?></span>
                                                                    </div>
                                                                    <?php  } ?>
                                                                    <?php if (!$field_data->displayRankings != 'true') {  ?>
                                                                    <div class="datafieldsall">
                                                                        <label> Display rankings: </label>
                                                                        <span><?php if (!$field_data->displayRankings != true) {
																		echo 'Yes';
																	} else {
																		echo 'No';
																	} ?></span>
                                                                    </div>
                                                                    <?php  }  ?>
                                                                    <?php if (!$field_data->invertRankings != 'true') {  ?>
                                                                    <div class="datafieldsall">
                                                                        <label> Invert rankings: </label>
                                                                        <span><?php if (!$field_data->invertRankings != true) {
																		echo 'Yes';
																	} else {
																		echo 'No';
																	} ?></span>
                                                                    </div>
                                                                    <?php  }  ?>
                                                                    <div class="btn-rounded">
            <a class="btn btn-danger tool" data-tip="Delete" onclick="return letsconfirm('Are you sure you want to Delete?','<?php echo BASE_URL.'projects/deletedatafield/?id='. $dataf['id_project_field'] . '&&proid=' . $projectId; ?>')" href="javascript:void(0)"> <i class="fa red fa-trash"></i></a>
			
            <a 
            <?php //if($dataf['restrict_children'] == 1){ echo ''; }else{ echo 'disabled';} ?> 
            class="btn btn-info tool" data-tip="Edit" onclick="editProjectsForm(<?php echo $dataf['id_project_field']; ?>,<?php echo $projectId; ?>)" href="javascript:void(0)"><i class="fa green fa-edit"></i></a>
                                                                    </div>
			
			 <div style="<?php if($dataf['restrict_children'] == 1){ echo ''; }else{ echo 'display:none';} ?>" class="form-group">
				 <a class="btn cus-btn" data-tip="Edit" id="editkey<?php echo $dataf['id_project_field']; ?>"
					onclick="editProjectsKey(<?php echo $dataf['id_project_field']; ?>,<?php echo $projectId; ?>)"
					href="javascript:void(0)">Edit Map key</a>
			 </div>
			<!--<div class="toggleWrapper">-->
			<!--	<div class="form-group">-->
			<!--		<label for="">Is group</label>-->
			<!--		<input type="checkbox" name="is_datagroup"-->
			<!--			onclick="isdatagroup(this,'<?php //echo $dataf['id_project_field']; ?>')"-->
			<!--			id="is_datagroup<?php //echo $dataf['id_project_field']; ?>"-->
			<!--			<?php //if($dataf['isGroup'] == 1){ echo 'checked'; } ?>-->
			<!--			class="dn" value="1">-->
			<!--		<label-->
			<!--			for="is_datagroup<?php// echo $dataf['id_project_field']; ?>"-->
			<!--			class="toggle"><span-->
			<!--				class="toggle__handler"></span></label>-->
			<!--	</div>-->
			<!--</div>-->
                                                                </div>
                                                        </div>
                                                           </div>
                                                        <?php
		   $parentId = $dataf['id_project_field'];
                 
                  $datafieldsChild = $mthis->model->getProjectFieldsByParentId($parentId);
                 if(!empty($datafieldsChild)){
            $countn = $count;
                     ?>
                                                        <ol>
                    <?php   foreach($datafieldsChild as $dchild){ $countn++;
		       ?>
                                                            <li style="display: list-item;"
                                                                class="mjs-nestedSortable-branch mjs-nestedSortable-expanded"
                                                                id="menuItem_<?php echo $dchild['id_project_field']; ?>">
                                                                <span class="index" style="display:none"><?php  echo $countn; ?></span>
                                                                <input type="hidden" style="display:none" name="shortposition[]"  value="<?php echo $dchild['id_project_field']; ?>" />
                                                                <div class="menuDiv">
                                                                    <span title="Click to show/hide children"
                                                                        class="disclose ui-icon ui-icon-minusthick">
                                                                        <span></span>
                                                                    </span>
                                                                    <span title="Click to show/hide item editor"
                                                                        data-id="<?php echo $dchild['id_project_field']; ?>"
                                                                        class="expandEditor ui-icon ui-icon-triangle-1-n">
                                                                        <span></span>
                                                                    </span>
                                                                    <span>
                                                                        <span
                                                                            data-id="<?php echo $dchild['id_project_field']; ?>"
                                                                            class="itemTitle"><?php echo $dchild['field_name']; ?></span>
                                                                        <span title="Click to delete item."
                                                                            data-id="<?php echo $dchild['id_project_field']; ?>"
                                                                            class="deleteMenu ui-icon ui-icon-closethick">
                                                                            <span></span>
                                                                        </span>
                                                                    </span>
                                                                    <div id="menuEdit<?php echo $dchild['id_project_field']; ?>"
                                                                        class="menuEdit hiddenDiv">
                                                                        <div class=""
                                                                            id="id<?php echo $dchild['id_project_field']; ?>">
                                                                            <div class="datafieldsall">
                                                                                <label>Description: </label>
                                                                                <span><?php echo $dchild['description']; ?></span>
                                                                            </div>
                                                                            <div class="datafieldsall">
                                                                                <label>Data type: </label>
                                                                                <span><?php echo $dchild['field_type']; ?></span>
                                                                            </div>
                                                                            <?php $field_data = json_decode($dchild['field_data']);
													//   print_r($field_data);
													?>
                                                                            <?php if (!$field_data->comparable != 'true') { ?>
                                                                            <div class="datafieldsall">
                                                                                <label> Display data on heatmap: </label>
                                                                                <span><?php if (!$field_data->comparable != 'true') {
																		echo 'Yes';
																	} else {
																		echo 'No';
																	} ?></span>
                                                                            </div>
                                                                            <?php  } ?>
                                                                            
                                                                             <?php 
                                                                    if($dchild['field_type'] != 'Text' || $dchild['field_type'] != 'Hyperlink'){
                                                                        ?>
                                                                            <div class="datafieldsall" style="display: none;">
                                                                        <label> Grouping Method: </label>
                                                                        <span><?php echo $field_data->groupingMethod; ?></span>
                                                                    </div>
                                                                        <?php 
                                                                    }
                                                                    ?>
                                                                            
                                                                            <?php if ($field_data->graphType != '') { ?>
                                                                            <div class="datafieldsall">
                                                                                <label> Graph Type: </label>
                                                                                <span><?php echo $field_data->graphType; ?></span>
                                                                            </div>
                                                                            <?php  } ?>

                                                                            <?php
                                                                            // if ($field_data->groupingMethod != '') { ?>
                                                                            <!-- <div class="datafieldsall">
                                                                                <label> Grouping method: </label>
                                                                                <span><?php
                                                                                // echo $field_data->groupingMethod; ?></span>
                                                                            </div> -->
                                                                            <?php // } ?>
                                                                            <?php if (!$field_data->includeAverageInNodeGraphs != 'true') { ?>
                                                                            <div class="datafieldsall">
                                                                                <label> Show average: </label>
                                                                                <span><?php if (!$field_data->includeAverageInNodeGraphs != 'true') {
																		echo 'Yes';
																	} else {
																		echo 'No';
																	} ?></span>
                                                                            </div>
                                                                            <?php  } ?>
                                                                            <?php if ($field_data->averageOverride != '') {  ?>
                                                                            <div class="datafieldsall">
                                                                                <label> Override calculated average:
                                                                                </label>
                                                                                <span><?php if (!$field_data->averageOverride != '') {
																		echo 'No';
																	} else {
																		echo $field_data->averageOverride;
																	} ?></span>
                                                                            </div>
                                                                            <?php  } ?>
                                                                            <?php if (!$field_data->showChartDatasetSummary != 'true') {  ?>
                                                                            <div class="datafieldsall">
                                                                                <label> Show chart in the data set
                                                                                    summary: </label>
                                                                                <span><?php if (!$field_data->showChartDatasetSummary != true) {
																		echo 'Yes';
																	} else {
																		echo 'No';
																	} ?></span>
                                                                            </div>
                                                                            <?php  }  ?>
                                                                            <?php if (!$field_data->showChartDatasetSummary != 'true') {  ?>
                                                                            <div class="datafieldsall">
                                                                                <label> Exclude minimum from data set
                                                                                    summary chart: </label>
                                                                                <span><?php if (!$field_data->excludeMinFromDataSetSummaryGraph != true) {
																		echo 'Yes';
																	} else {
																		echo 'No';
																	} ?></span>
                                                                            </div>
                                                                            <?php  }  ?>
                                                                            <?php if (!$field_data->showChartDatasetSummary != 'true') {  ?>
                                                                            <div class="datafieldsall">
                                                                                <label> Exclude maximum from data set
                                                                                    summary chart: </label>
                                                                                <span><?php if (!$field_data->excludeMaxFromDataSetSummaryGraph != true) {
																		echo 'Yes';
																	} else {
																		echo 'No';
																	} ?></span>
                                                                            </div>
                                                                            <?php  }  ?>
                                                                            <?php if (!$field_data->showChartDatasetSummary != 'true') {  ?>
                                                                            <div class="datafieldsall">
                                                                                <label> Exclude average from data set
                                                                                    summary chart: </label>
                                                                                <span><?php if (!$field_data->excludeAverageFromDataSetSummaryGraph != true) {
																		echo 'Yes';
																	} else {
																		echo 'No';
																	} ?></span>
                                                                            </div>
                                                                            <?php  }  ?>
                                                                            <?php if (!$field_data->showTotalInDataSetSummary != 'true') {  ?>
                                                                            <div class="datafieldsall">
                                                                                <label> Show total in the data set
                                                                                    summary: </label>
                                                                                <span><?php if (!$field_data->showTotalInDataSetSummary != true) {
																		echo 'Yes';
																	} else {
																		echo 'No';
																	} ?></span>
                                                                            </div>
                                                                            <?php  }  ?>
                                                                            <?php if (!$field_data->isMultivalued != 'true') {  ?>
                                                                            <div class="datafieldsall">
                                                                                <label> Multivalued: </label>
                                                                                <span><?php if (!$field_data->isMultivalued != true) {
																		echo 'Yes';
																	} else {
																		echo 'No';
																	} ?></span>
                                                                            </div>
                                                                            <?php  } ?>
                                                                            <?php if (!$field_data->displayRankings != 'true') {  ?>
                                                                            <div class="datafieldsall">
                                                                                <label> Display rankings: </label>
                                                                                <span><?php if (!$field_data->displayRankings != true) {
																		echo 'Yes';
																	} else {
																		echo 'No';
																	} ?></span>
                                                                            </div>
                                                                            <?php  }  ?>
                                                                            <?php if (!$field_data->invertRankings != 'true') {  ?>
                                                                            <div class="datafieldsall">
                                                                                <label> Invert rankings: </label>
                                                                                <span><?php if (!$field_data->invertRankings != true) {
																		echo 'Yes';
																	} else {
																		echo 'No';
																	} ?></span>
                                                                            </div>
                                                                            <?php  }  ?>
                                                                            <div class="btn-rounded">
                                                                                <a class="btn btn-danger tool"
                                                                                    data-tip="Delete"
                                                                                    onclick="return letsconfirm('Are you sure you want to Delete?','<?php echo  $CurPageURL . '?id=' . $dchild['id_project_field'] . '&&proid=' . $projectId; ?>')"
                                                                                    href="javascript:void(0)"><i
                                                                                        class="fa red fa-trash"></i></a>
                                                                                         <a class="btn btn-info tool" data-tip="Edit" onclick="editProjectsForm(<?php echo $dchild['id_project_field']; ?>,<?php echo $projectId; ?>)" href="javascript:void(0)"><i class="fa green fa-edit"></i></a>
             
              </div>
             <?php if($dataf['restrict_children'] == 1){
             }else{ ?>
             
             <div class="form-group">
				 <a class="btn cus-btn" data-tip="Edit" id="editkey<?php echo $dchild['id_project_field']; ?>"
					onclick="editProjectsKey(<?php echo $dchild['id_project_field']; ?>,<?php echo $projectId; ?>)"
					href="javascript:void(0)">Edit Map key</a>
			 </div>
			 
             <?php  } ?>
             
			 

                                                                           
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </li>
                                                            <?php  $count++; } ?>
                                                        </ol>
                                                        <?php  } ?>





                                                    </li>


                                                    <?php } } } ?>

                                                </ol>

                                            </section>









                                        </div>
                                        <div class="grp-btns">
                                            <button class="btn cus-btn" name="toArray" id="toArray">
                                                <span>Update</span>
                                            </button>
                                            <button class="btn register-link"
                                                onclick="addFields('<?php echo $projectId; ?>','<?php echo $mid; ?>')">Add Data
                                                Field</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="tab-pane" id="2a">
                    <div class="col-md-6">
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
						<input type="checkbox" name="is_publish"
							onclick="updateprojectStatus(this,'project')" id="dndo" class="dn"
							value="publish" <?php if ($data['visibility'] == 1) { echo 'checked'; } ?> />
						<label for="dndo" class="toggle"><span
								class="toggle__handler"></span></label>
					</div>
				</div>
                                    </div>
                                    <div class="row">
	<div class="col-md-12" id="passProtected" style="<?php if ($data['visibility'] != 1) { echo 'display:none'; } ?>">
		<div class="form-group">
			<label for="">Protected</label>
			<div class="custom-checkbox">
	<input type="checkbox" name="password_protected" onclick="updateprojectStatus(this,'project')" id="password_protected" value="password_protected" <?php if($data['password_protected'] == 1){ echo 'checked'; } ?> />
	
				<label for="password_protected">Password protected</label>
			</div>
		</div>
	</div>
                                    </div>
                                </div>
                                <div class="addPassword" style="<?php if ($data['password_protected'] != 1) { echo 'display:none';} ?>">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form id="passForm" action="javascript:void(0)" method="post"
                                                style="max-width:100%">
                                                <div class="form-group pass-field">
                                                    <label>Project password</label>
                                                    <input type="password" class="form-control required"
                                                        value="<?php echo $pass; ?>" id="password" name="password" />
                                                    <span class="error">Password is required</span>
                                                    <span class="togglePass"><i class="fa fa-eye-slash"
                                                            aria-hidden="true"></i></span>
                                                </div>
                                                <input type="hidden" id="project_id" name="id"
                                                    value="<?php echo $projectId; ?>" />
                                                <div class="form-group">
                                                    <button class="generatePassword btn register-link" type="button"
                                                        onclick="randomPassword(8)">Generate password</button>
                                                </div>
                                                <button class="btn cus-btn" id="savePass" page="projects"
                                                    type="button">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <?php
					$templateData = !empty($allTemplate) ? $allTemplate[0] : array(); ?>
                    <!--project setting-->
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="project-dtails">
                                <form id="projectSettingsForm" action="<?php echo BASE_URL.'projects/update_settings' ?>" method="post"
                                    style="max-width:100%">
                                    <div class="pro-heading">
                                        <h4>Project setting</h4>
                                        <input type="hidden" name="id_project" value="<?php echo $projectId; ?>">
                                    </div>

                                    <?php if($packageData['is_fonts'] != 'no'){ ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Select Font</label>
                                                <select class="form-control" name="fonts" id="fonts">
                                                    <option value="" disabled selected>Select font</option>

        								<?php   foreach($allFonts as $font) { ?>
        										<option value="<?php echo $font['id']; ?>"
        										                    <?php	if ($data['font'] == $font['id']) {
        																			echo 'selected';
        																		}else if($data['font'] == null || $data['font'] == 0){
        																		    if($clientData['font'] == $font['font_family']){
        																		           echo 'selected';
        																		    }
        																		 
        																		}
        																?>><?php echo $font['font_family']; ?></option>
        								<?php } ?>
                                                </select>
												
												
												
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
<?php 
if($templateData['is_mp'] != 'no'){
if ($clientData['is_mp'] == 'yes') { ?>
  <div class="toggleWrapper">
	<div class="form-group">
		<label for="">Enable Email MP</label>
		<input type="checkbox" name="is_email_mp" onclick="emailMp(this)" id="email_mp" class="dn" value="yes" <?php if($data['is_mp'] == 'yes'){ echo 'checked'; } ?> />
		<label for="email_mp" class="toggle"><span class="toggle__handler"></span></label>
	</div>
  </div>
  
  
	<div id="emailMpsetting"
		style="<?php if($data['is_mp'] == 'no'){ echo 'display:none'; }?>">
		<div class="row">
<div class="col-md-12">
	<div class="form-group">
	<label for="">Model Header</label>
		<textarea class="form-control emailMPmodelEditer" name="emailmp_MH" id="emailmp_MH" placeholder="[Salutation] Write the text you want people to show in Email MP Model Header"><?php if($data['emailmp_MH'] == null || $data['emailmp_MH'] == ''){ if($clientData['emailmp_MH'] == '' || $clientData['emailmp_MH'] == null){ echo $templateData['emailmp_MH'];}else{ echo $clientData['emailmp_MH']; } } else{ echo $data['emailmp_MH']; } ?></textarea>
 </div>
</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="">Title</label>
					<input type="text" class="form-control "
						name="email_sub" id="email_sub"
						placeholder="Enter email subject"
						value="<?php if($data['email_sub'] == null || $data['email_sub'] == ''){
							   if($clientData['email_sub'] == ''){
		echo $templateData['email_sub'];
		}else{
			echo $clientData['email_sub']; 
		}
						} else{ echo $data['email_sub']; } ?>">
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="">Message to your MP</label>
					<textarea class="form-control " name="message" id="msg"
						placeholder="[Salutation] Write the text you want people to send their MPS"><?php if($data['message'] == null || $data['message'] == '' ){ 
					  
						 if($clientData['message'] == ''){
		echo $templateData['message'];
		}else{
			echo $clientData['message']; 
		}
						
						}else{ echo $data['message']; } ?></textarea>
				</div>
			</div>
		</div>
	</div>
<?php } } ?>
<input type="hidden" name="hide_node" id="hide_node" class="dn" value="yes" <?php if($data['hide_node'] == 'yes'){ echo 'checked'; } ?>  />

 <?php if ($clientData['is_charts']  == 'yes') { ?>
	<div class="toggleWrapper">
		   <div class="form-group">
		<label for="">Enable Charts</label>
		<input type="checkbox" name="is_charts" id="charts" class="dn"
			value="yes" <?php if($data['is_charts'] == 'yes'){ echo 'checked'; } ?> />
		<label for="charts" class="toggle"><span class="toggle__handler"></span></label>
	</div>
	  </div>
<?php } ?>

	<div class="toggleWrapper">
		   <div class="form-group">
		<label for="">Enable PDF Download</label>
		<input type="checkbox" name="is_pdf_download" id="pdf_download" class="dn"
			value="yes" <?php if($data['is_pdf_download'] == 'no'){ echo ''; }else{ echo 'checked';} ?> />
		<label for="pdf_download" class="toggle"><span class="toggle__handler"></span></label>
	</div>
	  </div>


	<div class="toggleWrapper">
		   <div class="form-group">
		<label for="">Enable Image Export</label>
		<input type="checkbox" name="is_image_export" id="image_export" class="dn"
			value="yes" <?php if($data['is_image_export'] == 'no'){ echo ''; }else{ echo 'checked';} ?> />
		<label for="image_export" class="toggle"><span class="toggle__handler"></span></label>
	</div>
	  </div>

<?php
if($templateData['is_social_share'] != 'no'){
if ($clientData['is_social_share']  == 'yes') { ?>
                                                <div class="toggleWrapper">
                                                    <div class="form-group">
                                                        <label for="">Enable social share</label>
                                                        <input type="checkbox" name="is_social_share"
                                                            onclick="enableSocialShare(this)" id="is_social" class="dn"
                                                            value="yes" <?php
																																	if ($data['is_social_share'] == 'yes') {
																																		echo 'checked';
																																	}
																															?> />
                                                        <label for="is_social" class="toggle"><span
                                                                class="toggle__handler"></span></label>
                                                    </div>
                                                </div>
                                                <!--social media-->
                                                <div id="socialshareSetting"
                                                    style="<?php if($data['is_social_share'] == 'no'){ echo 'display:none'; }?>">
                                                    <div class="row">
                                                        <?php 	if ($clientData['is_facebook'] != 'no') { ?>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="custom-checkbox">
                                                                    <input type="checkbox" name="is_facebook"
                                                                        onclick="enableFacebook(this)" id="is_facebook"
                                                                        class="" value="yes"
                                                                        <?php if ($data['is_facebook'] != 'no') {echo 'checked'; } ?>>
                                                                    <label for="is_facebook">Facebook</label>
                                                                </div>
                                                                <input type="text" class="form-control share-text"
                                                                    style="<?php if ($data['is_facebook'] == 'no'){ echo 'display:none';} ?>"
                                                                    name="is_facebook_text" id="is_fb_share"
                                                                    placeholder="Message"
                                                                    value="<?php if($data['is_facebook'] == 'no'){ echo $clientData['is_facebook']; } else { echo $data['is_facebook']; } ?>">
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                        <input type="hidden" name="is_insta" value="yes">
                                                           <input type="hidden" name="is_insta_text" value="<?php echo $data['is_insta']; ?>">
                                                        <?php
												if ($clientData['is_twitter'] != 'no') { ?>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="custom-checkbox">
                                                                    <input type="checkbox" name="is_twitter"
                                                                        onclick="enableTwitter(this)" id="is_twitter"
                                                                        class="" value="yes"
                                                                        <?php if ($data['is_twitter'] != 'no') {echo 'checked'; } ?>>
                                                                    <label for="is_twitter">Twitter</label>
                                                                </div>
                                                                <input type="text" class="form-control share-text"
                                                                    style="<?php if ($data['is_twitter'] == 'no'){ echo 'display:none';} ?>"
                                                                    name="is_twitter_text" id="is_twitter_share"
                                                                    placeholder="Message"
                                                                    value="<?php if($data['is_twitter'] == 'no'){ echo $clientData['is_twitter']; } else { echo $data['is_twitter']; } ?>">
                                                            </div>
                                                        </div>
                                                        <?php }
												if ($clientData['is_linkedin'] != 'no') { ?>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <div class="custom-checkbox">
                                                                    <input type="checkbox" name="is_linkedin"
                                                                        onclick="enableLinkedin(this)" id="is_linkedin"
                                                                        class="" value="yes"
                                                                        <?php if ($data['is_linkedin'] != 'no') {echo 'checked'; } ?>>
                                                                    <label for="is_linkedin">Linkedin</label>
                                                                </div>
                                                                <input type="text" class="form-control share-text "
                                                                    style="<?php if ($data['is_linkedin'] == 'no'){ echo 'display:none';} ?>"
                                                                    name="is_linkedin_text" id="is_linkedin_share"
                                                                    placeholder="Message"
                                                                    value="<?php if($data['is_linkedin'] == 'no'){ echo $clientData['is_linkedin']; } else { echo $data['is_linkedin']; } ?>">
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                    </div>

                                                </div>
                                                <?php } }
									if($templateData['is_email_friend'] != 'no'){
										if ($clientData['is_email_friend'] == 'yes') { ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="custom-checkbox">
                                                                <input type="checkbox" onclick="enableemailfriend(this)"
                                                                    name="is_email_friend" id="is_email_friend" class=""
                                                                    value="yes"
                                                                    <?php if ($data['is_email_friend'] == 'yes') {echo 'checked'; } ?>>
                                                                <label for="is_email_friend">Email a friend</label>
                                                            </div>

                                                            <div class="row" id="emailfriend"
                                                                style="<?php if ($data['is_email_friend'] !== 'yes'){ echo 'display:none';} ?>">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="">Title</label>
                                                                        <input type="text" name="email_friend_title"
                                                                            placeholder="Enter title here"
                                                                            id="email_friend_title"
                                                                            class="form-control share-text"
                                                                            value="<?php if($data['email_friend_title'] == null){
                                                                            
                                                                             if($clientData['email_friend_title'] == ''){
                                                                                echo $templateData['email_friend_title'];
                                                                                }else{
                                                                                    echo $clientData['email_friend_title']; 
                                                                                }
                                                                            
                                                                            }else{ echo $data['email_friend_title']; } ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="email_friend_text">Message</label>
                                                                        <textarea placeholder="Enter message here"
                                                                            id="email_friend_text"
                                                                            class="form-control tweet-mp-text"
                                                                            name="email_friend_text"><?php if($data['email_friend_text'] == null){
                                                                                
                                                                                 if($clientData['email_friend_text'] == ''){
                                                                                echo $templateData['email_friend_text'];
                                                                                }else{
                                                                                    echo $clientData['email_friend_text']; 
                                                                                }
                                                                            
                                                                            }else{ echo $data['email_friend_text']; } ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } }
			
									
									if ($clientData['is_email_share']  == 'yes') { ?>
                                                <div class="toggleWrapper" style="display:none;">
                                                    <div class="form-group">
                                                        <label for="">Enable email share</label>
                                                        <input type="checkbox" name="is_email_share" id="email_share"
                                                            class="dn" value="yes" <?php if ($data['is_email_share'] != null) {
																																		if ($data['is_email_share'] == 'yes') {
																																			echo 'checked';
																																		}
																																	} else if ($clientData['is_email_share'] == 'yes') {
																																		echo 'checked';
																																	} else if ($packageData['is_email_share'] == 'yes') {
																																		echo 'checked';
																																	}
																																	?> />
                                                        <label for="email_share" class="toggle"><span
                                                                class="toggle__handler"></span></label>
                                                    </div>
                                                </div>
                                                <?php }
									if($templateData['is_tweet_mp'] != 'no'){
									if ($clientData['is_tweet_mp'] == 'yes') { ?>
                                                <div class="toggleWrapper">
<div class="form-group">
	<label for="">Enable tweet MP</label>
	<input type="checkbox" name="is_tweet_mp" onclick="enabletweetMP(this)" id="tweet_mp" class="dn" value="yes" <?php if ($data['is_tweet_mp'] != null) { if ($data['is_tweet_mp'] == 'yes') { echo 'checked';} } ?> />
<label for="tweet_mp" class="toggle"><span class="toggle__handler"></span></label>
</div>
                                                </div>
                                                <div>
			<div class="form-group" id="tweetMptext"
				style="<?php if($data['is_tweet_mp'] !== 'yes'){ echo 'display:none'; }?>">
				<label for="tweetMptext">MP tweet text</label>
				<textarea name="tweet_mp_text" placeholder="Write MP tweet text"
					class="form-control tweet-mp-text"><?php if($data['tweet_mp_text'] ==null || $data['tweet_mp_text'] == ''){ 
                        if($clientData['tweet_mp_text'] == ''){ echo $templateData['tweet_mp_text']; }else{  echo $clientData['tweet_mp_text'];  } }else {  echo $data['tweet_mp_text'];  } ?></textarea> </div>
                                                </div>
                                                <?php } } ?>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label for="cta_text">CTA Text</label>
			<?php $cta_text = $data["cta_text"]; ?>
			<textarea name="cta_text" id="cta_text" placeholder="CTA text" class="form-control"><?php echo $cta_text; ?></textarea>
		</div>
	</div>
</div>
									<!--// new -->
										<div class="row">
									    	<div class="col-md-12">
		<div class="pro-heading">
               <h4>Subscribe Mail details</h4>
        </div>
		<div class="form-group">
			<label for="subscribe_mail_text">Text</label>
			<div class="toggleWrapper m-l-0">
				  <?php
				$text = (isset($data['subscribe_mail_text'])) ? $data['subscribe_mail_text'] : (isset($clientData['subscribe_mail_text']) ? $clientData['subscribe_mail_text'] : $templateData['subscribe_mail_text']);
				?>
				<textarea name="subscribe_mail_text" id="" placeholder="Write subscribing mail text" class="form-control"><?php echo $text; ?></textarea>
			</div>
		</div>
<div class="form-group">
	<label for="subscribe_mail_address">Address</label>
	<div class="m-l-0">
		 <?php
		$addresss = (isset($data['subscribe_mail_address'])) ? $data['subscribe_mail_address'] : (isset($clientData['subscribe_mail_address']) ? $clientData['subscribe_mail_address'] : $templateData['subscribe_mail_address']);
		?>
		<input type="text" placeholder="Subscribe mail address" value="<?php echo $addresss;?>" name="subscribe_mail_address" class="form-control"/>
		</div>
</div>
													<div class="form-group">
												    <label for="subscribe_mail_copyright_title">Copyright Website Name</label>
													<div class="m-l-0">
													     <?php
                                                        $ctitle = (isset($data['copyright_title'])) ? $data['copyright_title'] : (isset($clientData['copyright_title']) ? $clientData['copyright_title'] : $templateData['copyright_title']);
                                                        ?>
													   	<input type="text" name="copyright_title" value="<?php echo $ctitle;?>" placeholder="Write copyright title" class="form-control">
														</div>
												</div>
													<div class="form-group">
												    <label for="subscribe_mail_copyright_link">Copyright Website Link</label>
													<div class="m-l-0">
													      <?php
                                                        $clink = (isset($data['copyright_link'])) ? $data['copyright_link'] : (isset($clientData['copyright_link']) ? $clientData['copyright_link'] : $templateData['copyright_link']);
                                                        ?>
													   	<input type="text" name="copyright_link" value="<?php echo $clink;?>" placeholder="Write copyright link" class="form-control">
														</div>
												</div>
											</div>
									</div>
									<!--// new end -->
									
                                            </div>
                                        </div>
                                    </div>
                                    <input type="submit" name="update_setting" class="btn cus-btn"
                                        id="projectSettingsFormbtn" value="Submit">
                                </form>
                            </div>
                        </div>
                        
                          <!--// new -->
                        <div class="form-group">
                            <div class="project-dtails">
                                <div class="pro-details-inner">
                                    <div class="pro-heading">
                                        <h4>Privacy policy</h4>
                                    </div>
                                </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form id="ppform" action="<?php echo BASE_URL.'projects/updateprivacypolicy'; ?>" method="post"
                                                style="max-width:100%">
                                                <div class="form-group">
                                                      <?php
                                                      	$templateDatas = !empty($allTemplate) ? $allTemplate[0] : array();
                                                        $pptext = (isset($data['privacypolicy'])) ? $data['privacypolicy'] : (isset($clientData['privacypolicy']) ? $clientData['privacypolicy'] : $templateDatas['privacypolicy']);
                                                        ?>
														<textarea name="privacypolicy" id="" placeholder="Write privacy policy" class="form-control privacypolicyEditer"><?php echo $pptext; ?></textarea>
														
                                            <input type="hidden" name="project_id" value="<?php echo $projectId; ?>">
                                                </div>
                                                <button class="btn cus-btn" id="savepp"
                                                    type="submit">Update</button>
                                            </form>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    <!--// new end -->
                        
                    </div>
                    
                    
                    
                </div>

                <div class="tab-pane" id="3a">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="project-dtails nodes-table">
                                    <div class="custom-checkbox">
                                         <input type="checkbox" id="country_fields_in" name="country_fields_in" value="yes"/>
                                        <label for="country_fields_in">
                                    		<span></span>Show nodes with no data in list                                 	</label>
                                    </div>
                                    <!--   <label>-->
                                    <!--    Include nodes with no data-->
                                    <!--<input type="checkbox" id="country_fields_in" name="country_fields_in" value="yes"/>-->
                                    <!--</label>-->
                                    <div class="pro-heading">
                                        <h4>Nodes
                                        <!--(Constituencies)-->
                                        </h4>
                                    </div>
                                    <div class="pro-details-inner" id="connstitutedata">
                                        <img id="loadereditnodes" style="display:none" src="<?php echo BASE_URL.'public/web/'; ?>images/ajax-loader.gif">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade add-data-field cus-modal-f" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel2"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">Add data field</h5>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="dataFields" class="edit-project" method="post">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="">Name</label>
                            <input type="text" class="form-control required" name="name" id="name" placeholder="Name"
                                value="">
                            <span class="error">Name is required</span>
                        </div>
                    </div>
                     <div class="form-group row">
                        <div class="col-md-12">
                            <label for="">Display Name</label>
                            <input type="text" class="form-control required" name="display_name" id="name" placeholder="Name"
                                value="">
                            <span class="error">Display name is required</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="">Description</label>
                            <textarea type="text" class="form-control" name="description" id="description"
                                placeholder="Description"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="">Type</label>
                            <select class="form-control" id="dataType" onchange="getType(this)" name="type">
                                <option value="Text">Text</option>
                                <option value="Number">Number</option>
                                <option value="Percentage">Percentage</option>
                                <option value="Decimal">Decimal</option>
                                <option value="Hyperlink">Hyperlink</option>
                                <option value="Pound">Pound</option>
                                <option value="Euro">Euro</option>
                                <option value="Dollar">Dollar</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row comparable-data">
                        <div class="col-md-12">
                            <div class="toggleWrapper">
                                <label for="">Display data on heatmap</label>
                                <input type="checkbox" name="comparable" id="comparable" class="dn" value="true">
                                <label for="comparable" class="toggle"><span class="toggle__handler"></span></label>
                            </div>
                            <!-- <div class="grouping-method">
                                <label for="">Grouping method</label>
                                <select class="form-control" name="grouping">
                                    <option disabled selected>Select grouping</option>
                                    <option value="EqualRanges">Equal Ranges</option>
                                    <option value="Percentiles">Percentiles</option>
                                </select>
                            </div> -->
                        </div>
                    </div>
	<!------------------->
	<div class="form-group link_and_text" style="display:none;">
	<label for="">Link Text</label>
	<input type="text" class="form-control" name="link_text" id="link_text" placeholder="Link Text" value="">
	</div>
	<!------------------->
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="toggleWrapper">
                                <label for="">Show average</label>
                                <input type="checkbox" name="overall_range" id="overall_range" class="dn" value="true">
                                <label for="overall_range" class="toggle"><span class="toggle__handler"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="toggleWrapper">
                                <label for="">Override calculated average</label>
                                <input type="checkbox" name="override_average" id="override_average" class="dn"
                                    value="true">
                                <label for="override_average" class="toggle"><span
                                        class="toggle__handler"></span></label>
                            </div>
                            <div class="average-override">
                                <label for="">Average Override</label>
                                <input type="number" class="form-control" name="average_override_number"
                                    id="average_override_number" placeholder="" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="toggleWrapper">
                                <label for="">Show chart in the data set summary</label>
                                <input type="checkbox" name="chart_data_set_summary" id="chart_data_set_summary"
                                    class="dn" value="true">
                                <label for="chart_data_set_summary" class="toggle"><span
                                        class="toggle__handler"></span></label>
                            </div>
                            <div class="dataset_summary">
                                <div class="toggleWrapper">
                                    <label for="">Exclude minimum from data set summary chart</label>
                                    <input type="checkbox" name="exclude_minimum_data_set_summary"
                                        id="exclude_minimum_data_set_summary" class="dn" value="true">
                                    <label for="exclude_minimum_data_set_summary" class="toggle"><span
                                            class="toggle__handler"></span></label>
                                </div>

                                <div class="toggleWrapper">
                                    <label for="">Exclude maximum from data set summary chart</label>
                                    <input type="checkbox" name="exclude_maximum_data_set_summary"
                                        id="exclude_maximum_data_set_summary" class="dn" value="true">
                                    <label for="exclude_maximum_data_set_summary" class="toggle"><span
                                            class="toggle__handler"></span></label>
                                </div>

                                <div class="toggleWrapper">
                                    <label for="">Exclude average from data set summary chart</label>
                                    <input type="checkbox" name="exclude_average_data_set_summary"
                                        id="exclude_average_data_set_summary" class="dn" value="true">
                                    <label for="exclude_average_data_set_summary" class="toggle"><span
                                            class="toggle__handler"></span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="toggleWrapper">
                                <label for="">Show total in the data set summary</label>
                                <input type="checkbox" name="total_data_set_summary" id="total_data_set_summary"
                                    class="dn" value="true">
                                <label for="total_data_set_summary" class="toggle"><span
                                        class="toggle__handler"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row multivalued-data">
                        <div class="col-md-12">
                            <div class="toggleWrapper">
                                <label for="">Multivalued</label>
                                <input type="checkbox" name="multivalued" id="multivalued" class="dn" value="true">
                                <label for="multivalued" class="toggle"><span class="toggle__handler"></span></label>
                            </div>
                            <div class="graph-type">
                                <label for="">Graph Type</label>
                                <select class="form-control" name="graphtype">
                                    <option disabled selected>Select graph</option>
                                    <option value="BarGraph">Bar graph</option>
                                    <option value="LineGraph">Line graph</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row node-ranking-data">
                        <div class="col-md-12">
                            <div class="toggleWrapper">
                                <label for="">Display the node rankings</label>
                                <input type="checkbox" name="node_ranking" id="node_ranking" class="dn" value="true">
                                <label for="node_ranking" class="toggle"><span class="toggle__handler"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row invert-node">
                        <div class="col-md-12">
                            <div class="toggleWrapper">
                                <label for="">Invert the node rankings</label>
                                <input type="checkbox" name="invert_node_ranking" id="invert_node_ranking" class="dn"
                                    value="true">
                                <label for="invert_node_ranking" class="toggle"><span
                                        class="toggle__handler"></span></label>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" value="<?php echo $mid; ?>" name="mid" />
                    <input type="hidden" value="<?php echo $projectId; ?>" name="id" />
                    <div class="text-center">
                        <button type="button" id="datafield_btn" class="btn cus-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--//filed value model-->

<div class="modal fade editdatafieldvalue cus-modal-f" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel2"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">Data field name</h5>
            </div>
            <div class="modal-body">
               <!---->
            </div>
        </div>
    </div>
</div>

<!--end -->
<!--visuals model start-->
<div class="modal fade visuals-form cus-modal-f" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel2"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">Edit Visuals</h5>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="editProject" class="edit-project" method="post">
                    <div class="row">
                        <!--<div class="col-sm-6">-->
                        <!--    <div class="form-group">-->
                        <!--        <label for="">Name</label>-->
                        <textarea style="display:none;" class="" name="name"><?php echo $data['name'];?></textarea>
                        <!--        <span class="error">Name is required</span>-->
                        <!--    </div>-->
                        <!--</div>-->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">Display Title</label>
                                <textarea class="form-control required textarea-input" name="title" id="title"><?php echo $data['title'];?></textarea>
                                <!--<input type="text" class="form-control required" name="title" id="title" placeholder="Display name" value="<?php// echo $data['name'];?>">-->
                                     <span class="error">Display name is required</span>
                            </div>
                        </div>
                    </div>
                    <?php if ($packageData['is_logo'] != 'no') {  ?>
                    <div class="pro-logo row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Upload Logo Or Enter URL</label>

                                <div class="custom-checkbox">
                                    <input type="checkbox" onclick="enablelogourl(this)" name="url" id="logourl"
                                        class="" value="yes"
                                        <?php if ($data['logourl'] != null){ echo 'checked'; }else if($data['logo'] == null){ if($clientData['logo'] != null){ echo 'checked'; } }?>>
                                    <label for="logourl">Enter url</label>
                                </div>
                                <div class="custom-checkbox">
                                    <input type="checkbox" onclick="enablelogofile(this)" name="file" id="logofile"
                                        class="" value="yes" <?php if ($data['logo'] != null){ echo 'checked';} ?>>
                                    <label for="logofile">Logo</label>
                                </div>

                                <div id="url" style="<?php 
											if($data['logourl'] == null){
                                                if($data['logo'] == null){
                                                    if($clientData['logo'] == null){
                                                        echo 'display:none;';
                                                    }
                                                }else{
                                                     echo 'display:none;';
                                                }
                                            }
											?>">

                                    <input type="text" class="form-control value-filled" name="logourl" id="logo"
                                        placeholder="logo URL"
                                        value="<?php if($data['logourl'] == null){ echo $clientData['logo'];  } else{ echo $data['logourl']; } ?>">
                                </div>



                                <div class="form-group" id="chooselogo"
                                    style="<?php if ($data['logo'] == null){ echo 'display:none';} ?>">
                                    <div class="custom-file custom-file-1">
                                        <input type="file" class="custom-file-input form-control m-t-10 value-filled"
                                            name="logo" id="logo">
                                        <input type="hidden" value="<?php echo $data['logo']; ?>"
                                            name="old_logo_name" />
                                        <label class="custom-file-label" for="logo" data-js-label>Choose file</label>
                                    </div>
                                </div>

                                <!--<div class="custom-file">-->

                                <!--</div>-->
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <?php if ($data['logo'] != null) { ?>
                                <img src="<?php echo '/uploads/' . $data['logo'];  ?>" class="data-value" />
                                <?php } 
										else if ($data['logourl'] != null) {
										?>
                                <img src="<?php echo $data['logourl']; ?>" class="data-value" />
                                <?php
										} 
										else if ($clientData['logo'] != null) {
										?>
                                <img src="<?php echo $clientData['logo']; ?>" class="data-value" />
                                <?php
										} 
										else if ($clientData['logofile'] != null) {
										?>
                                <img src="<?php echo '/uploads/'. $clientData['logofile'];  ?>"
                                    class="data-value" />
                                <?php
										} 
										
										?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="description_data">
                                <label for="">Description</label>
                                <textarea class="form-control textEditor" name="description"
                                    placeholder="Description"><?php echo $data['description']; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Select primary color</label>
                                    <div class="colorBox">
                                        <input type="text" class="colorValueInput form-control"
                                            onchange="colorValueChange(this)"
                                            value="<?php if($data['primary_color'] == null){ echo $clientData['primary_color']; }else{ echo $data['primary_color']; } ?>" />
                                        <input type="color" class="colorInput" name="colorprime"
                                            onchange="colorChange(this)" id="colors"
                                            value="<?php if($data['primary_color'] == null){ echo $clientData['primary_color']; }else{ echo $data['primary_color']; } ?>" />

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Select secondary color</label>
                                    <div class="colorBox">
                                        <input type="text" class="colorValueInput form-control"
                                            onchange="colorValueChange(this)"
                                            value="<?php if($data['secondary_color'] == null){ echo $clientData['secondary_color']; }else{ echo $data['secondary_color']; } ?>" />
                                        <input type="color" class="colorInput" name="colorsecond"
                                            onchange="colorChange(this)" id="colors"
                                            value="<?php if($data['secondary_color'] == null){ echo $clientData['secondary_color']; }else{ echo $data['secondary_color']; } ?>" />

                                    </div>
                                </div>
                                    <div class="form-group">
                                    <label for="">Select text color 1</label>
                                    <div class="colorBox">
                                        <input type="text" class="colorValueInput form-control"
                                            onchange="colorValueChange(this)"
                                            value="<?php if($data['text_color'] == null){ echo $clientData['text_color']; }else{ echo $data['text_color']; } ?>" />
                                        <input type="color" class="colorInput" name="text_color"
                                            onchange="colorChange(this)" id="colors"
                                            value="<?php if($data['text_color'] == null){ echo $clientData['text_color']; }else{ echo $data['text_color']; } ?>" />

                                    </div>
                                </div>
                                                                    <div class="form-group">
                                    <label for="">Select text color 2</label>
                                    <div class="colorBox">
                                        <input type="text" class="colorValueInput form-control"
                                            onchange="colorValueChange(this)"
                                            value="<?php if($data['text_color2'] == null){ echo $clientData['text_color2']; }else{ echo $data['text_color2']; } ?>" />
                                        <input type="color" class="colorInput" name="text_color2"
                                            onchange="colorChange(this)" id="colors"
                                            value="<?php if($data['text_color2'] == null){ echo $clientData['text_color2']; }else{ echo $data['text_color2']; } ?>" />

                                    </div>
                                </div>
                                                  <div class="form-group">
                                    <label for="">Select text color 3</label>
                                    <div class="colorBox">
                                        <input type="text" class="colorValueInput form-control"
                                            onchange="colorValueChange(this)"
                                            value="<?php if($data['text_color3'] == null){ echo $clientData['text_color3']; }else{ echo $data['text_color3']; } ?>" />
                                        <input type="color" class="colorInput" name="text_color3"
                                            onchange="colorChange(this)" id="colors"
                                            value="<?php if($data['text_color3'] == null){ echo $clientData['text_color3']; }else{ echo $data['text_color3']; } ?>" />

                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
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
                                    <input class="inputmixer range-slider__range" type="range" id="numsteps" value="<?php if ($colorArray != null) {
																															echo count($colorArray) - 2;
																														} else {
																															echo 1;
																														} ?>" min="1" max="8" />
                                    <span class="range-slider__value"></span>
                                </div>
                                <br>
                                <ul class="ulmixer" id="list">
                                    <?php
										if ($colorArray != null) {
											$count = 0;
											foreach ($colorArray as $color) {
												$count++;

												if ($count == 1) {
										?>
                                    <li class="limixer" id="start"><input class="inputmobile" type="color"
                                            name="colorinput[]" value="<?php echo $color; ?>" size="7" /><span
                                            class="spanmixer"></span></li>
                                    <?php }
												if ($count != 1 && ($count != count($colorArray))) { ?>
                                    <li class="interim" style="background-color: <?php echo $color; ?>; "><span
                                            class="spanmixer"><?php echo $color; ?></span><input type="hidden"
                                            class="colorInput" name="colorinput[]" value="<?php echo $color; ?>" /></li>
                                    <?php }
												if ($count == count($colorArray)) { ?>
                                    <li class="limixer" id="end"><input class="inputmobile" type="color"
                                            name="colorinput[]" value="<?php echo $color; ?>" size="7" /><span
                                            class="spanmixer"></span></li>
                                    <?php
												}
											}
										} else { ?>
                                    <li class="limixer" id="start"><input class="inputmobile" type="color"
                                            name="colorinput[]" value="#5E4FA2" size="7" /><span
                                            class="spanmixer"></span></li>

                                    <li class="limixer" id="end"><input class="inputmobile" type="color"
                                            name="colorinput[]" value="#F79459" size="7" /><span
                                            class="spanmixer"></span></li>
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
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div id="color_type2">
                                <div class="color-append-box">
                                    <label for="">Key colors:</label>
                                    <?php
										if ($colorArray != null) {
											$count = 0;
											foreach ($colorArray as $color) {
												$count++;
										?>
                                    <div class="colorBox">
                                        <label for="">Key color <?php echo $count; ?></label>
                                        <input type="text" class="colorValueInput form-control"
                                            onchange="colorValueChange(this)" value="<?php echo $color; ?>" />
                                        <input type="color" class="colorInput" name="color[]"
                                            onchange="colorChange(this)" id="colors" value="<?php echo $color; ?>" />
                                        <?php if ($count == count($colorArray)) { ?>
                                        <button class="removeBox" onclick="removeColor(this)">
                                            <img src="/uploads/close.png" alt="">
                                        </button>
                                        <?php } ?>
                                    </div>
                                    <?php }
										}   ?>
                                </div>
                                <div class="m-5" id="addBtnBox" style="<?php if ($count < 10) { ?>display:block<?php } else { echo 'display:none'; } ?>">
                                    <button type="button" class="btn register-link" id="addColorBtn"
                                        onclick="addColor()">Add color</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $projectId;  ?>" />
                    <div class="modal-footer text-center">
                        <button type="button" id="updateProject" name="submit" value="submit"
                            class="btn cus-btn">Submit</button>
                        <!--<button type='button' class="btn btn-primary" data-dismiss="modal" aria-label="Close" value='Close' id='btnNo' ><i class="fa fa-times"> </i>      Close</button>-->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--visuals model end-->
<!--content form-->

<div class="modal fade content-form cus-modal-f" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel2"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">Edit Content</h5>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="editProjectcontent" class="edit-project" method="post">
                      <div class="form-group row">
                        <div class="col-md-12">
                            <div class="footer_content_data">
                                <label for="">Node Intro Text</label>
                                <textarea class="form-control nodeIntroEditor" 
                                    name="node_intro"
                                    placeholder="Node Intro Text"><?php echo $data['node_intro']; ?></textarea>
                           
                            </div>
                        </div>
                    </div>
                    
						
                         <div class="form-group row">
                        <div class="col-md-12">
                            <div class="footer_content_data">
                                <label for="">Node description</label>
                                <textarea class="form-control nodeEditor" 
                                    name="node_description"
                                    placeholder="Node description"><?php echo $data['node_description']; ?></textarea>
                           
                            </div>
                        </div>
                    </div>
                    
                      <div class="form-group row">
                        <div class="col-md-12">
                            <div class="footer_content_data">
                                <label for="">Print description</label>
                                <textarea class="form-control printEditor" 
                                    name="print_description"
                                    placeholder="Print description"><?php echo $data['print_description']; ?></textarea>
                           
                            </div>
                        </div>
                    </div>
                     <div class="form-group row">
                        <div class="col-md-12">
                            <div class="footer_content_data">
                                <label for="">Footer content</label>
                                <textarea class="form-control footerEditor" onkeyup="previewFooter()"
                                    name="footer_content"
                                    placeholder="Footer content"><?php echo $data['footer_content']; ?></textarea>
                                <div class="preview_footer_data">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                   
                    
                    <input type="hidden" name="id" value="<?php echo $projectId;  ?>" />
                    <div class="modal-footer text-center">
                        <button type="button" id="updateProjectContent" name="submit" value="submit"
                            class="btn cus-btn">Submit</button></div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--content form end-->
<!--project name model -->
<div class="modal fade project-name-form cus-modal-f" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel2"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">Edit Project Name</h5>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="editProjectname" class="edit-project" method="post">
						 <div class="form-group row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">Name</label>
                                <!--<input type="text" class="form-control required" name="name" id="name"-->
                                <!--    placeholder="Name" value="<?php// echo $data['name']; ?>">-->
                                    <textarea class="form-control required textarea-input" name="name" id="name"
                                    placeholder="Name"><?php echo $data['name'];?></textarea>
                                    
                                <span class="error">Name is required</span>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $projectId;  ?>" />
                    <div class="modal-footer text-center">
                        <button type="button" id="updateProjectname" name="submit" value="submit"
                            class="btn cus-btn">Submit</button></div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--project name model end -->
<!-------------IMPORT------>
<div class="modal cus-modal-f" id="ImportModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">Import</h5>
            </div>
            <div class="modal-body">
                <form action="<?php echo BASE_URL.'import/importdata/'; ?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="hidden" name="pr_id" value="<?php echo $projectId;  ?>">
                                <input type="hidden" name="pr_key" value="<?php echo $pId;  ?>">
                                <label></label>
                                <div class="custom-file">
                                    <input type="file" name="file_source"
                                        accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                        id="chooseFile" class="custom-file-input form-control">
                                    <label class="custom-file-label" for="chooseFile" data-js-label>Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <input type="submit" class="btn cus-btn" value="Import">
                    </div>
                </form>
            </div>
            <!--<div class="modal-footer">-->
            <!--  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
            <!--</div>-->
        </div>
    </div>
</div>
<!-------------IMPORT------>
<!-------------VIEW-NODES------>
<!-------------IMPORT------>
<div class="modal cus-modal-f" id="ViewNodesModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">View </h5>
            </div>
            <div class="modal-body">
               
                    <div class="row">
                        <div class="col-md-12" id="AllDataViewModel">
                            
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-------------VIEW-NODES------>
<?php
}
?>
<script type="text/javascript" src="<?php echo BASE_URL; ?>public/web/js/jquery-2.1.3.js"></script>
<script>
        var values = [];
		var sequences = [];
			$("input[name='shortposition[]']").each(function() {
				values.push($(this).val());
				sequences.push($(this).siblings('.index').text());
			});
			$.ajax({
            url: '<?php echo BASE_URL.'projects/saveshorting'; ?>',
            type: 'post',
            data: {shortposition: values,'sequence':sequences,'table_name':'project_fields'},
			dataType:'json',
            success: function(response){

             }
         });
   function nodesFunc(){
    $('#loadereditnodes').show();
            var mid = '<?php echo $mid; ?>';
         var pid = '<?php echo $projectId; ?>';
             if(document.getElementById('country_fields_in').checked){
             var is_include_empty_node = true;
         }else{
             var is_include_empty_node = false; 
         }
   
         		$.ajax({
            url: '<?php echo BASE_URL.'projects/displaynodes'; ?>',
            type: 'post',
            data: {'mid': mid,'pid':pid,'is_include_empty_node':is_include_empty_node},
            success: function(response){
				$('#loadereditnodes').hide();
				//console.log(response);
				$('#connstitutedata').html(response);
             }
         });     
        }
         
   $('#li3').click(function(){
       nodesFunc();
   });
   
   $('#country_fields_in').click(function(){
    nodesFunc();
});	
   
$(window).on('load', function(){
  nodesFunc();
})
</script>

<script>

$(window).on('load', function() {
	    var mcval = $('#unique_url').val();
	    if(/[^a-zA-Z0-9\-_/\/]/.test( mcval ) || mcval.toLowerCase().indexOf("/") >= 0 ) {
	            	$('.unique-error').html('<span class="text-danger">special characters not allowed in UNIQUE-URL !</span>');
                	$('#uniquesubmitbtn').attr('disabled', 'true');
                	 $('#fronturl').attr('disabled', 'true');
                	  $('#fronturl').css('pointer-events', 'none');
                	
            }
})

function checkinique(mcval, project_id) {
    $('.unique-error').html('loading...');
    	$('.unique-error').html('loading...');
        console.log(mcval);
			   if(/[^a-zA-Z0-9\-_/\/]/.test( mcval ) || mcval.toLowerCase().indexOf("/") >= 0 ) {
                	$('.unique-error').html('<span class="text-danger">special characters not allowed in UNIQUE-URL !</span>');
                	$('#uniquesubmitbtn').attr('disabled', 'true');
            }else{
                	$('.unique-error').html('loading...');
                		 $('#uniquesubmitbtn').prop("disabled", false);
    $.ajax({
        url: '<?php echo BASE_URL . 'projects/checkunique' ?>',
        type: 'POST',
        data: {
            'unique_url': mcval,
            'project_id': project_id,
            'cid': '<?php echo $cid; ?>'
        },
        dataType: "json",
        success: function(data) {
            $('.unique-error').html('<span class="text-success">'+data.msg+'</span>');
            if (data.status == 0) {
                $('.unique-error').focus();
                $('#uniquesubmitbtn').attr('disabled', true);
            }else{
                $('#uniquesubmitbtn').attr('disabled', false);

            }
        }
    });
            }
}
var msg = localStorage.getItem('message_viewprojects');

if (msg != undefined) {
    document.getElementById('sucessMessage').style.display = "block";
    document.getElementById('suc_msg').innerHTML = msg;
    localStorage.removeItem('message_viewprojects');
    removeMsg('sucessMessage');
}
function removeMsg(id){
	    setTimeout(function(){ 
	       	document.getElementById(id).style.display = "none";
	    }, 3000);
}
function clickFun(id) {
    localStorage.setItem('fieldtab', id);
}
</script>