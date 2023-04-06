<?php 
    $errorText = "No company selected !!";
    $userData = $userDatass;
	$companyData = $userData['clients'];
	if ($companyData != null) {
		$ids = implode(",", unserialize($companyData));
	} else{
		$ids = null;
	}
	
    $alldataclient = $mthis->model->getClientsWhereIn($ids);
    
    if (!empty($alldataclient) && count($alldataclient) == 1) {
		foreach ($alldataclient as $clientData) {
			if ($clientData['is_suspended'] != 1) {
				$_SESSION['selectid'] = $clientData['id'];
			}else{
			  unset($_SESSION['selectid']);  
			}
        }
    }
                    if($_SESSION['selectid']){
                        $cid = $_SESSION['selectid'];
                        
                        $getsingleclient = $mthis->model->getClientsById($cid);
                       
                      foreach($getsingleclient as $sclient){
                        if($sclient['is_suspended'] != 0){
                            unset($_SESSION['selectid']);
                        }
                      }
                    }
                
$CurPageURL = BASE_URL.'projectsgroup/';  
$site_url = BASE_URL;
?>
<div class="page-header-wrap">
 <h3>Project Group</h3>
  <?php if ($_SESSION['selectid']) { ?>

	 <a class="btn cus-btn" href="<?php echo BASE_URL.'projectsgroup/add'; ?>" title=""><i class="fa fa-plus"></i><span>Add Project group</span></a>

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
                <button class="btn btn-light-red" onclick="return dowithselected('delete','projectgroup',event)"  value="delete" > <i class="fa red fa-trash"></i>  <span>Delete</span></button>
                <button class="btn btn-light-gray" onclick="return dowithselected('draft','projectgroup',event)"  value="hide" > <i class="fa fa-eye-slash"></i> <span>Draft</span> </button>
                <button class="btn btn-light-green" onclick="return dowithselected('publish','projectgroup',event)"  value="show" > <i class="fa fa-eye"></i> <span>Publish</span> </button>
            </div>
                  </div>
                  <div class="patient-f-group-btns">
                                     <div class="cl-filter">
        <!--<div class="client-filter">-->
        <!--                 <div class="form-group">-->
        <!--        <label for="table-filter">Filter by client</label>-->
        <!--                <select id="table-filter" class="form-control">-->
        <!--                <option value="">All</option>-->
                        <?php 
                      
                        // foreach($alldataclient as $row) {
                        //     if($row['is_suspended'] != 1){
                        //     ?>
                        <!--<option>-->
                            <?php //echo $row['name']; ?>
                            <!--</option>-->
                 
                         <?php
                        //     }
                        // }
                         ?>
                        
                    <!--    </select>-->
                    <!--   </div>-->
                    <!--</div>-->
    </div>
                
                   <button class="btn btn-sort" onclick="saveshorting('projectgroup')">
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
                                    <th style="min-width: 170px">Group name</th>
                                    <th style="min-width: 150px">Client</th>
                                    <th style="min-width: 110px">Projects</th>
                                    <th style="min-width: 110px">Created By</th>
                                    <th style="min-width: 110px">View</th>
                                    <th style="min-width: 230px;display:none;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                             <?php  
                             $uid = $_SESSION['uid'];
                             
                        $groupDataAll = $mthis->model->getprojectgroupBycreateId($uid);
                        
                         $count = 0;
                        
                         foreach($groupDataAll as $row){
                             $count++;
                                    
                                         
    $groupid = $row['id'];
   
                                
                               $cid = $row['client'];
                               
                                        $clientData = $mthis->model->getClientsById($cid);
                                        
                                          foreach($clientData as $cdata){
                                          if($cdata['is_suspended'] != 1){
                                ?>   
                                   
               <tr <?php if($row['visibility'] != 1){ ?>class="tr_suspended"<?php } ?> >
                                    <td class="index"><?php echo $count; ?></td>
                    
                                    <td style="min-width: 170px">
                                        <input type="hidden" value="<?php echo $row['id']; ?>" name="shortposition[]" class="shortposition">
                                          <div class="custom-checkbox">
                                        <input id="<?php echo $row['id']; ?>" type="checkbox" value="<?php echo $row['id']; ?>" class="chkbx" name="chkbx[]">
                                    	<label for="<?php echo $row['id']; ?>">
                                    		<span></span>
                                    		<a href="<?php echo  BASE_URL.'projectsgroup/edit/'.$row['id']; ?>"><?php echo $row['name']; ?></a>
                                    	</label>
                                   </div> 	
                                   <div class="btn-group btn-rounded ml-2">
                                              <button type="button" class="btn cus-btn-border dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v"></i>
                                              </button>
                                              <ul class="dropdown-menu btn-rounded">
                                                <li> <a  class="btn btn-info tool" data-tip="Edit" href="<?php echo  $CurPageURL.'edit/'.$groupid; ?>"><i class="fa green fa-edit"></i></a></li>
                                                <li>
                                                         
                      <?php if($row['visibility'] != 1){ ?>
                       <a class="btn btn-success tool" data-tip="Publish" href="<?php echo  $CurPageURL.'showprojects/'.$row['id']; ?>"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                
                                    <?php } else{
                                    ?>
                                           <a  class="btn btn-success tool" data-tip="Draft" href="<?php echo  $CurPageURL.'hideprojects/'.$row['id']; ?>"><i class="fa fa-eye"></i></a>
                                     
                                    <?php
                                    }  ?>
                                                </li>
                       <!--                             <li>-->
                                                         
                       <!--<?php //if($row['password_protected'] == 1){ ?>-->
                       <!--            <a  class="btn btn-user tool" data-tip="Unlock" href="<?php //echo  $CurPageURL.'unlock/'.$row['id']; ?>"><i class="fa fa-lock" aria-hidden="true"></i></a>-->
                       <!--           <?php //} else{ ?>-->
                       <!--           <a  class="btn btn-user-1 tool" data-tip="Lock" href="<?php //echo  $CurPageURL.'lock/'.$row['id']; ?>"><i class="fa fa-unlock" aria-hidden="true"></i></a>-->

                       <!--        <?php //}  ?>-->
                       <!--                         </li>-->
                               <li>  <a  class="btn btn-danger tool" data-tip="Delete" onclick="return letsconfirm('Are you sure you want to Delete?<p><?php echo str_replace("'","-", str_replace('"','-', $row['name']));?></p>','<?php echo  $CurPageURL.'delete/?id='. $groupid; ?>')" href="javascript:void(0)"><i class="fa red fa-trash"></i></a> </li>
                                              </ul>
                                            </div>
                                    </td>
                                   
                                  <td style="min-width: 150px">
                                      <?php
                                    
                                        foreach($clientData as $client){
                                            echo $client['name'];
                                        }
                                      
                                      ?>
                                  </td>
                                  
                                   <td>
                                           <ul class="allclient">  
                                      <?php
                                      $projects = $row['projects'];
                                      if($projects != null){
                                         $projects = unserialize($row['projects']); 
                                         $projectsids = implode(',',$projects);
                              
                              
                                        $projectData = $mthis->model->getProjectWhereIn($projectsids);
                                    
                                           
                                              foreach($projectData as $pro){
                                                    $first_project = $pro['proKey'];
                                                      $first_unique_url = $pro['unique_url'];
                                          if($first_unique_url){
                                              $first_project = $first_unique_url;
                                          }
                                                  ?>
                                                                          
                                           
                                                                            
                                    <li><span><?php echo $pro['name'];  ?></span></li>
                                                                             
                                
                                                  <?php
                                              }
                                              
                                              
                                      }
                           
                                
                            
                                      ?>
                                          </ul>
                                  </td>
                                   <td style="min-width: 110px">
                                    <?php
                                      $usercreated = $row['createdby'];
                                      if($usercreated != null){
                                         
                                        $userData = $mthis->model->getUserDetailsById($usercreated);
                                              
                                              foreach($userData as $udata){
                                                  ?>
                                                  <span class="">
                                                      <!--<?php //echo BASE_URL; ?>/dashboard/users/profile?id=<?php //echo $udata['id']; ?>-->
                                                      <a class="badge badge-primary" href="">
                                                          <?php echo $udata['name']; ?>
                                                          </a>
                                     
                                     </span>
                                                  
                                                  <?php
                                              }
                                              
                                              
                                      }
                           
                                
                            
                                      ?>
                                  </td>
                                  	<td class="btn-rounded">

                                        <?php if(isset($first_project) && $first_project){ ?>
                                  	     <a target="_blank" href="<?php echo BASE_URL; ?>?dataSetKey=<?php echo $first_project.'&group='.$row['unique_url'];?>" class="btn btn-success tool" data-tip="View"><span><i class="fa fa-location-arrow"></i></span></a>
                                    <?php 
                                  	    }else{ ?>
                                  	     <!-- <a target="_blank" disabled href="<?php //echo BASE_URL; ?>?dataSetKey=<?php //echo $first_project.'&group='.$row['unique_url'];?>" class="btn btn-danger tool" data-tip="Empty project"><span><i class="fa fa-location-arrow"></i></span></a> -->
                                   
                                  	  <?php    }?>


                                  	   </td>
                                  	    <?php $first_project = null; ?>
                                    <td style="min-width: 230px; display:none;">
                         
                                        <div class="btn-rounded">
                                        <a  class="btn btn-danger tool" data-tip="Delete" onclick="return letsconfirm('Are you sure you want to Delete?<p><?php echo $row['name'];?></p>','<?php echo  $CurPageURL.'/delete?id='. $groupid; ?>')" href="javascript:void(0)"><i class="fa red fa-trash"></i></a> 
                                         <a  class="btn btn-info tool" data-tip="Edit" href="<?php echo  $CurPageURL.'editprojectsgroup?id='.$groupid; ?>"><i class="fa green fa-edit"></i></a>
                                          
                      <?php if($row['visibility'] != 1){ ?>
                       <a class="btn btn-success tool" data-tip="Publish" href="<?php echo  $CurPageURL.'showprojects?id='.$row['id']; ?>"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                
                                    <?php } else{
                                    ?>
                                        <a  class="btn btn-success tool" data-tip="Draft" href="<?php echo  $CurPageURL.'hideprojects?id='.$row['id']; ?>"><i class="fa fa-eye"></i></a>
                                   
                                     
                                    <?php
                                    }  ?>
                                   
                                  <?php if($row['password_protected'] == 1){ ?>
                                   <a  class="btn btn-user tool" data-tip="Unlock" href="<?php echo  $CurPageURL.'unlock?id='.$row['id']; ?>"><i class="fa fa-lock" aria-hidden="true"></i></a>
</a>
                                  <?php } else{ ?>
                                  <a  class="btn btn-user-1 tool" data-tip="Lock" href="<?php echo  $CurPageURL.'lock?id='.$row['id']; ?>"><i class="fa fa-unlock" aria-hidden="true"></i></a>

                               <?php }  ?>
                                
                                     </div>
                                
                                    </td>
									
                                </tr>
                             <?php } 
                             } }
                             ?>
                            
							
							
							</tbody>
                        </table>
                    </div>
                    </form>
                </div>
            </div>
           
<!-- Panel Content -->

<!-- Panel Content -->
<?php } else{ ?>  
</div>
    <div class="widget"> 
        <div class="table-area" style="<?php if ($clientData['is_suspended'] == 1) { echo 'display:none'; } ?>">
            <div class="message"></div>
            <div class="clientdata">
                <ul class="company">
                    <li class="active">Company</li>
                    <?php
                    
                    $userData = $userDatass;
                    
                    $companyData = $userData['clients'];
                    if ($companyData != null) {
                        $ids = implode(",", unserialize($companyData));
                    } else {
                        $ids = null;
                    }
                    
                    
                     $alldataclient = $mthis->model->getClientsWhereIn($ids);
                    

                    if (!empty($alldataclient) && count($alldataclient) == 1) {

                        foreach ($alldataclient as $clientData) {
                            if ($clientData['is_suspended'] != 1) {
                                $_SESSION['selectid'] = $clientData['id'];
                            }else{
                                $errorText = "Company is suspended !!";
                              unset($_SESSION['selectid']);  
                            }
                    ?>
                            <li style="" class="<?php if ($_SESSION['selectid'] == $clientData['id']) {
                                                    echo 'active';
                                                } ?>"><?php echo $clientData['name'];
                                                if ($clientData['is_suspended'] == 1){
                                                    echo '-suspended';
                                                }
                                                ?></li>
                    <?php }
                    } ?>

                    <?php ?>
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
                                <option value="<?php echo $clientData['id']; ?>" <?php if ($clientData['id'] == $_SESSION['selectid']) {
                                                                                        echo 'selected';
                                                                                    } ?>><?php echo $clientData['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            <?php } ?>
        </div>
        
<?php
            echo '<div class="no-select-box"><div class="no-select-box-inr"><img src="/uploads/no-selected.svg" alt=""><h1>'.$errorText.'</h1></div></div></div></div>';
        }  ?>

<script type="text/javascript">
 localStorage.removeItem('li1');
 localStorage.removeItem('li2');
 localStorage.removeItem('li3');
 localStorage.removeItem('li4');
 localStorage.removeItem('li5');
 localStorage.removeItem('li6');
 localStorage.setItem('li1','active');
 
 
                            var d = localStorage.getItem('pro_delete_msg');
                            if(d){
                               document.getElementById("sucessMessage").style.display = 'block';
                                 document.getElementById("suc_msg").innerHTML = 'Project delete succesfully.';
                               localStorage.removeItem('pro_delete_msg');
                               removeMsg('sucessMessage');
                               
                            }
                            var packageshow = localStorage.getItem('pro_packageshow');
                              if(packageshow){
                               document.getElementById("sucessMessage").style.display = 'block';
                               document.getElementById("suc_msg").innerHTML = 'Project publish succesfully.';
                               
                               localStorage.removeItem('pro_packageshow');
                                removeMsg('sucessMessage');

                            }
                            var packagehide = localStorage.getItem('pro_packagehide');
                              if(packagehide){
                               document.getElementById("sucessMessage").style.display = 'block';
                               document.getElementById("suc_msg").innerHTML = 'Project draft succesfully.';
                                removeMsg('sucessMessage');
                               localStorage.removeItem('pro_packagehide');

                            }
                            
                         
                        </script>
