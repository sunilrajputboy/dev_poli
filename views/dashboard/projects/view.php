<script>
       localStorage.setItem('activetab', 'project1');
     localStorage.setItem('tabid', '#project');
      localStorage.setItem('mainTab', '#menutab1');
</script>
<div class="page-header-wrap">
        <h3>Project</h3>
        <?php 
          $errorText = "No company selected !!";
        if (isset($_SESSION['selectid'])) {
            $cid = $_SESSION['selectid'];
            $cdatas = $mthis->model->getClientsById($cid);
			$cdata=$cdatas[0];
            $cprojects = $cdata['projects'];
            if ($cprojects != null) {
                $cprojects = unserialize($cdata['projects']);
                $cprojects = implode(",", $cprojects);
            }
            
            $pdatas = $mthis->model->getPackageById($cdata['package']);
            if($pdatas){
                $pdata=$pdatas[0];
            }
			
            if ($projectArray != null) {
                
				$query = $mthis->model->getProjectWhereIn($projectArray);
            } else {
				$query = $mthis->model->getProjectByClientId($cid);
            }
            
            $result=array();
			if(!empty($query)){
            $result = $query;
			}
            $r = count($result);
            
            if($pdata['no_allowed_projects'] > $r || $pdata['no_allowed_projects'] == 'Unlimited'){ ?>
                <a class="btn cus-btn" href="<?php echo BASE_URL.'projects/add' ?>" title=""><i class="fa fa-plus"></i><span>Add Project </span></a>

          <?php  }else{ ?>
 <a href="<?php echo BASE_URL.'dashboard'; ?>" title="" class="btn cus-btn">
                    <i class="fa fa-chevron-left"></i>
                    <span>Back</span>
                </a>
         <?php }
?>

    </div>
            <div class="widget">
                <div class="table-area">
                    <div class="widget-title">
                        <div class="alert alert-success" id="sucessMessage" style="display:none">
                            <p id="suc_msg">Data deleted successfully.</p>
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
        <div class="patient-f-group-wrapper">
			<div class="patient-f-group">
				<div class="table-data-suspend">
					<button class="btn btn-light-red" onclick="return dowithselected('delete','projects',event)" value="delete"> <i class="fa red fa-trash"></i> <span>Delete</span></button>
					<button class="btn btn-light-gray" onclick="return dowithselected('draft','projects',event)" value="hide"> <i class="fa fa-eye-slash"></i> <span>Draft</span> </button>
					<button class="btn btn-light-green" onclick="return dowithselected('publish','projects',event)" value="show"> <i class="fa fa-eye"></i> <span>Publish</span> </button>
				</div>
			</div>
      <div class="patient-f-group-btns">
   <!--    <div class="cl-filter">-->
   <!--     <div class="client-filter">-->
			<!--<div class="form-group">-->
			<!--	<label for="table-filter">Filter by client</label>-->
			<!--	<select id="table-filter" class="form-control" onchange="filterbyclientreflectgroup(this)">-->
			<!--		<option value="">All</option>-->
		<?php //foreach($alldataclient as $row) { if($row['is_suspended'] != 1){ ?>
		<!--<option cid="<?php //echo $row['id']; ?>" <?php //if(isset($_SESSION['clientSelected'])){ if($_SESSION['clientSelected'] == $row['id']){ echo 'selected'; }   } ?>><?php// echo $row['name']; ?></option>-->
			<?php //} } ?>
			<!--	</select>-->
			<!--</div>-->
   <!--     </div>-->
   <!--   </div>-->
      <div class="cl-filter">
		<!--<div class="client-filter">-->
		<!--	<div class="form-group">-->
		<!--		<label for="table-filter">Filter by Group</label>-->
		<!--		<select id="groupData" class="form-control" onchange="filterBygroup(this)">-->
		<!--			<option disabled <?php// if ($gid == null) { echo 'selected'; } ?>>Filter by group</option>-->
				<?php 
				// $uid = $_SESSION['uid'];
		//	if(isset($_SESSION['clientSelected'])){-->
			  // $clientSelectedId = $_SESSION['clientSelected'];
					   
			  // $groupData=$mthis->model->getProjectGroupClientId($clientSelectedId );
			//	}else{
				//	$groupData=$mthis->model->getProjectGroupCreatedBy($uid );
			//	}
			//	if(!empty($groupData)){
				//foreach ($groupData as $row){
				?>
		<!--		<option value="<?php //echo $row['id']; ?>" <?php// if ($row['id'] == $gid) { echo 'selected'; } ?>><?php// echo $row['name']; ?></option>-->
		<!--        <?php //} } ?>-->
		<!--		</select>-->
		<!--	</div>-->
		<!--</div>-->
                            </div>
                            
                       
                            <button class="btn btn-sort" onclick="saveshorting('projects')">
                                <i class="fa fa-sort"></i>
                                <span>Sort</span>
                            </button>
                        </div>
                    </div>
                    <form method="post" action="" id="rearrange">
                        <div class="table-responsive">
                            <table class="table table-striped" id="packages">
                                <thead>
                                    <tr>
                                        <th style="max-width: 50px">Order</th>
                                        <th style="min-width: 230px">Name</th>
                                        <th style="min-width: 150px">Map name</th>
                                        <th style="min-width: 110px">Client</th>
                                        <th style="min-width: 110px">Status</th>
                                        <th style="min-width: 110px">Created at</th>
                                        <th style="min-width: 110px">Created By</th>
                                        <th style="min-width: 110px">View</th>
                                        <th style="min-width: 230px; display:none">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    if (!empty($result)){
                                        $count = 0;
                                        foreach ($result as $row) {
                                             $key = 'Hl2018@1212';
                                                    $encrypted_id = openssl_encrypt($row['id_project'], 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
                                                    $encrypted_id = strtolower(bin2hex($encrypted_id));
                                            $count++;
                                            $idclient = $row['id_client'];
                                            $resultClient = $mthis->model->getClientsById($idclient);
                                            if (!empty($resultClient)) {
                                                $data = $resultClient[0];
                                                $nameClient = $data['name'];
                                                $is_suspended = $data['is_suspended'];
                                                	$client_unique_url = $data['unique_url'];
                                            } else {
                                                $nameClient = '';
                                                	$client_unique_url = '';
                                            }
                                            if($is_suspended != 1){

                                    ?>
                                            <tr <?php if ($row['visibility'] != 1) { ?>class="tr_suspended" <?php } ?> <?php if ($is_suspended != 0) { ?>class="tr_clientsuspended" <?php } ?>>
                                                <td class="index"><?php echo $count; ?></td>

                                                <td style="min-width: 230px">
                                                    <input type="hidden" value="<?php echo $row['id_project']; ?>" name="shortposition[]" class="shortposition">
                                                    <div class="custom-checkbox">
                                                        <input id="<?php echo $row['id_project']; ?>" type="checkbox" value="<?php echo $row['id_project']; ?>" class="chkbx" name="chkbx[]">
                                                        <label for="<?php echo $row['id_project']; ?>">
                                                            <span></span>
                                    		<a href="<?php echo  BASE_URL.'projects/viewprojects/'.$encrypted_id; ?>"><?php echo $row['name']; ?></a>
                                                        </label>
                                                    </div>
 <div class="btn-group btn-rounded ml-2">
                                              <button type="button" class="btn cus-btn-border dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v"></i>
                                              </button>
                                              <ul class="dropdown-menu btn-rounded">
                                                   <li><a class="btn btn-info tool" data-tip="Edit" href="<?php echo  BASE_URL . 'projects/viewprojects/' .$encrypted_id; ?>"><i class="fa green fa-edit"></i></a></li>
                                                <li><a class="btn btn-warning tool" data-tip="Copy" href="<?php echo BASE_URL . 'projects/copyprojects/'.$encrypted_id; ?>"><i class="fa green fa-copy"></i></a></li>
                                                 <li>
                                     <?php if ($row['visibility'] != 1) { ?>
                                                            <a class="btn btn-success tool" data-tip="Publish" href="<?php echo BASE_URL. 'projects/showprojects/'.$row['id_project']; ?>"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>

                                                        <?php } else {
                                                        ?>
                                                           <a class="btn btn-success tool" data-tip="Draft" href="<?php echo BASE_URL. 'projects/hideprojects/'.$row['id_project']; ?>"><i class="fa fa-eye"></i></a>

                                                        <?php
                                                        }  ?>
                                                </li>
                                       <!--          <li>-->
                                       <!--<?php //if ($row['password_protected'] == 1) { ?>-->
                                       <!--                    <a class="btn btn-user tool" data-tip="Unlock" href="<?php //echo BASE_URL. 'projects/unlock/' . $row['id_project']; ?>"><i class="fa fa-lock" aria-hidden="true"></i></a>-->
                                       <!--                     </a>-->
                                       <!--                 <?php //} else { ?>-->
                                       <!--                   <a class="btn btn-user-1 tool" data-tip="Lock" href="<?php //echo BASE_URL. 'projects/lock/' . $row['id_project']; ?>"><i class="fa fa-unlock" aria-hidden="true"></i></a>-->
                                       <!--             <?php //} ?>-->
                                       <!--         </li>-->
                                                 <li> <a class="btn btn-danger tool" data-tip="Delete" onclick="return letsconfirm('Are you sure you want to Delete?<p><?php echo str_replace("'","-", str_replace('"','-', $row['name']));?></p>','<?php echo BASE_URL. 'projects/delete/' . $row['id_project']; ?>')" href="javascript:void(0)"><i class="fa red fa-trash"></i></a></li>
                                              </ul>
                                            </div>

                                                </td>

                                                <td style="min-width: 150px">
                                                    <?php
                                                    $id = $row['id_map_template'];
                                                    $resultMap = $mthis->model->getMapTemplatesById($id);
                                                    if(!empty($resultMap)){
                                                        $data = $resultMap[0];
                                                        echo $data['map_name'];
                                                    }
                                                    ?>
                                                </td>
                                                <td> <?php echo $nameClient; ?> </td>
                                                <td>
                                                    <ul class="allclient">
                                                        <?php
                                                        if ($row['password_protected'] == 1) {
                                                            echo '<li><span><i class="fa fa-eye"></i></span></li> <li><span><i class="fa fa-key"></i></span></li>';
                                                        } else if ($row['visibility'] == 1) {
                                                            echo '<li><span><i class="fa fa-eye"></i></span></li>';
                                                        } else {
                                                            echo '<li><span><i class="fa fa-eye-slash" aria-hidden="true"></i></span></li>';
                                                        }
                                                        ?>
                                                    </ul>
                                                </td>
                                                <td>
                                                 <?php 
                                               $dt = new DateTime($row['created_at']);
											   $date = $dt->format('d/m/Y');
											   $time = $dt->format('H:i:s');
											   echo $date;
											   ?>
                                                </td>
                                               <td>
                                               <?php 
                                               $uid = $row['added_by'];
											   $udata = $mthis->model->getUserDetailsById($uid);
                                               if(!empty($udata)){
                                               foreach($udata as $d){
                                               ?>
                                              <span class="">
											  <p class="badge badge-primary" href="<?php echo BASE_URL; ?>users/edit/<?php echo $row['id_client']; ?>">
											  <?php echo $d['name']; ?></p>
											  </span>
                                               <?php } } ?>
                                                </td>
                                                 <?php 
                                                  if(!empty($row['unique_url'])){
                                                        $url =$row['unique_url'];
                                                  }else{
                                                      $url =$row['proKey'];
                                                  }
                                               
                                                ?>
                                                <td class="btn-rounded"> <a target="_blank" href="<?php echo BASE_URL; ?>?dataSetKey=<?php echo $url;?>&client=<?php echo $client_unique_url; ?>" class="btn btn-success tool" data-tip="View"><span><i class="fa fa-location-arrow"></i></span></a>
                                                	    </td>
                                                <td style="min-width: 230px; display:none">
                                                    <div class="btn-rounded">
                                                    <?php if($is_suspended == 0){ ?> 
                                                        <a class="btn btn-danger tool" data-tip="Delete" onclick="return letsconfirm('Are you sure you want to Delete?<p><?php echo str_replace("'"," ", $row['name']);?></p>','<?php echo BASE_URL.'projects/delete/' . $row['id_project']; ?>')" href="javascript:void(0)"><i class="fa red fa-trash"></i></a>
                                                        <a class="btn btn-info tool" data-tip="Edit" href="<?php echo  BASE_URL . 'projects/viewprojects/'.$encrypted_id; ?>"><i class="fa green fa-edit"></i></a>
                                                        <a class="btn btn-warning tool" data-tip="Copy" href="<?php echo BASE_URL . 'projects/copyprojects/' . $encrypted_id; ?>"><i class="fa green fa-copy"></i></a>
                                                        <?php if ($row['visibility'] != 1) { ?>
                                                            <a class="btn btn-success tool" data-tip="Publish" href="<?php echo BASE_URL. 'projects/showprojects/'.$row['id_project']; ?>"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>

                                                        <?php } else {
                                                        ?>
                                                            <a class="btn btn-success tool" data-tip="Draft" href="<?php echo BASE_URL. 'projects/hideprojects/'.$row['id_project']; ?>"><i class="fa fa-eye"></i></a>


                                                        <?php
                                                        }  ?>

                                                        <?php if ($row['password_protected'] == 1) { ?>
                                                            <a class="btn btn-user tool" data-tip="Unlock" href="<?php echo BASE_URL. 'projects/unlock/'.$row['id_project']; ?>"><i class="fa fa-lock" aria-hidden="true"></i></a>
                                                            </a>
                                                        <?php } else { ?>
                                                            <a class="btn btn-user-1 tool" data-tip="Lock" href="<?php echo BASE_URL. 'projects/lock/' .$row['id_project']; ?>"><i class="fa fa-unlock" aria-hidden="true"></i></a>
                                                    <?php }
                                                    } else{ echo 'Client suspended';  }  } ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php }  } ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
<?php } else { ?>
</div>
    <div class="widget"> 
        <div class="table-area" style="<?php if ($clientData['is_suspended'] == 1) { echo 'display:none'; } ?>">
            <div class="message"></div>
            <div class="clientdata">
                <ul class="company">
                    <li class="active">Company</li>
                    <?php
                    if(!empty($alldataclient)) {
                        foreach ($alldataclient as $clientData) {
                            if ($clientData['is_suspended'] != 1) {
                                $_SESSION['selectid'] = $clientData['id'];
                            }else{
                                $errorText = "Company is suspended !!";
                              unset($_SESSION['selectid']);  
                            }
                    ?>
                            <li style="" class="<?php if ($_SESSION['selectid'] == $clientData['id']) { echo 'active'; } ?>">
							<?php echo $clientData['name']; if ($clientData['is_suspended'] == 1){ echo '-suspended';} ?></li>
                    <?php } } ?>
                </ul>
            </div>
            <?php
            if (!empty($alldataclient) && count($alldataclient) > 1) { ?>
                <div class="select-c-box">
                    <div class="form-group">
                        <label> Select your company </label>
                        <select class="form-control" onchange="selectCompany(this)">
                            <option value="0" >Select your company</option>
                            <?php foreach ($alldataclient as $clientData) {
                            ?>
                                <option value="<?php echo $clientData['id']; ?>" <?php if ($clientData['id'] == $_SESSION['selectid']) { echo 'selected'; } ?>><?php echo $clientData['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            <?php } ?>
        </div>
        
<?php
            echo '<div class="no-select-box"><div class="no-select-box-inr"><img src="/uploads/no-selected.svg" alt=""><h1>'.$errorText.'</h1></div></div></div></div>';
        } ?>
<!-- Panel Content -->
<?php
unset($_SESSION['projectArray']);
unset($_SESSION['groupid']);
unset($_SESSION['clientSelected']);
?>
<script type="text/javascript">
     
     
    var d = localStorage.getItem('pro_delete_msg');
    if (d){
        document.getElementById("sucessMessage").style.display = 'block';
        localStorage.removeItem('pro_delete_msg');
        //removeMsg('sucessMessage');
    }
    var packageshow = localStorage.getItem('pro_packageshow');
    if (packageshow){
        document.getElementById("sucessMessage").style.display = 'block';
        document.getElementById("suc_msg").innerHTML = 'Project publish succesfully.';
		//removeMsg('sucessMessage');
        localStorage.removeItem('pro_packageshow');
    }
    var packagehide = localStorage.getItem('pro_packagehide');
    if (packagehide){
        document.getElementById("sucessMessage").style.display = 'block';
        document.getElementById("suc_msg").innerHTML = 'Project draft succesfully.';
		//removeMsg('sucessMessage');
        localStorage.removeItem('pro_packagehide');
    }
  
	    var values = [];
		var sequences = [];
		$("input[name='shortposition[]']").each(function() {
			values.push($(this).val());
			sequences.push($(this).closest('tr').find('.index').text());
		});

		$.ajax({
            url: '<?php echo BASE_URL; ?>projects/saveshorting',
            type: 'post',
            data: {shortposition: values,'sequence':sequences,'table_name':'projects'},
			dataType:'json',
            success: function(response){
      
             }

         });
   
</script>
