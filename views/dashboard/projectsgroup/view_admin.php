<div class="page-header-wrap">
 <h3>Project Group</h3>
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
        <div class="client-filter">
              <div class="form-group">
                <label for="table-filter1">Filter by client</label>
				<select id="table-filter1" class="form-control">
					<option value="">All</option>
					<?php if(!empty($alldataclient)){ foreach($alldataclient as $row){ ?>
					<option><?php echo $row['name']; ?></option>
					<?php } } ?>
				</select>
              </div>
                    </div>
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
                          <?php if(!empty($groupDataAll)){
                         $count = 0;
                         foreach($groupDataAll as $row){
                                 $count++;
                                 $groupid = $row['id'];
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
                    <li> <a  class="btn btn-info tool" data-tip="Edit" href="<?php echo BASE_URL.'projectsgroup/edit/'.$groupid; ?>"><i class="fa green fa-edit"></i></a></li>
                      <li>
                      <?php if($row['visibility'] != 1){ ?>
                      <a class="btn btn-success tool" data-tip="Publish" href="<?php echo  BASE_URL.'projectsgroup/showprojects/'.$row['id']; ?>"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
						<?php } else{ ?>
							 <a  class="btn btn-success tool" data-tip="Draft" href="<?php echo BASE_URL.'projectsgroup/hideprojects/'.$row['id']; ?>"><i class="fa fa-eye"></i></a>
						<?php }  ?>
                     </li>
                    <!-- <li>-->
                    <!--   <?php //if($row['password_protected'] == 1){ ?>-->
                    <!--   <a  class="btn btn-success tool" data-tip="Unlock" href="<?php //echo BASE_URL.'projectsgroup/unlock/'.$row['id']; ?>"><i class="fa fa-lock" aria-hidden="true"></i></a>-->
                    <!-- <?php //} else{ ?>-->
                    <!--       <a  class="btn btn-info tool" data-tip="Lock" href="<?php //echo BASE_URL.'projectsgroup/lock/'.$row['id']; ?>"><i class="fa fa-unlock" aria-hidden="true"></i></a>-->
                    <!-- <?php //}  ?>-->
                    <!--</li>  -->
                    <li><a  class="btn btn-danger tool" data-tip="Delete" onclick="return letsconfirm('Are you sure you want to Delete?<p><?php echo str_replace("'","-", str_replace('"','-', $row['name']));?></p>','<?php echo BASE_URL.'projectsgroup/delete/?id='. $groupid; ?>')" href="javascript:void(0)"><i class="fa red fa-trash"></i></a> </li>
                  </ul>
                 </div>
                                    </td>
                                   
                                  <td style="min-width: 150px">
                                      <?php
									 
                                      $cid = $row['client'];
                                          $clientData = $mthis->model->getClientsById($cid);
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
                                     <?php } } ?>
                                  </ul>
                                  </td>
                                   <td style="min-width: 110px">
                                    <?php
                                      $usercreated = $row['createdby'];
                                      if($usercreated != null){
                                              $userData = $mthis->model->getUserDetailsById($usercreated);
											  if(!empty($userData)){
                                              $udata=$userData[0];
                                     ?>
                                     <span class="">
                                         <!--<?php //echo BASE_URL; ?>users/profile/<?php //echo $udata['id']; ?>-->
									 <a class="badge badge-primary" href="">
									 <?php echo $udata['name']; ?>
									 </a>
                                     </span>
                                   <?php  } }; 
									   ?>
									  </td>
									 
                                  	<td class="btn-rounded">
                                  	       <?php
									 $client_unique_url = '';
                                      $cid = $row['client'];
                                          $clientData = $mthis->model->getClientsById($cid);
                                          foreach($clientData as $client){
                                              $client_unique_url =  $client['unique_url'];
                                          }
                                      ?>

                                  	      <?php if(isset($first_project) && $first_project){ ?>
                                  	     <a target="_blank" href="<?php echo BASE_URL; ?>?dataSetKey=<?php echo $first_project.'&group='.$row['unique_url'];?>&client=<?php echo $client_unique_url; ?>" class="btn btn-success tool" data-tip="View"><span><i class="fa fa-location-arrow"></i></span></a>
                                    <?php 
                                  	    }else{ ?>
                                  	     <!-- <a target="_blank" disabled href="<?php //echo BASE_URL; ?>?dataSetKey=<?php //echo $first_project.'&group='.$row['unique_url'];?>" class="btn btn-danger tool" data-tip="Empty project"><span><i class="fa fa-location-arrow"></i></span></a> -->
                                   
                                  	  <?php    }?>
                                        
                                  	           	    </td>
                                  	           	    <?php $first_project = null; ?>
                                    <td style="min-width: 230px; display:none;">
                                        <div class="btn-rounded">
                                        <a  class="btn btn-danger tool" data-tip="Delete" onclick="return letsconfirm('Are you sure you want to Delete?<p><?php echo $row['name'];?></p>','<?php echo BASE_URL.'projectsgroup/delete/'. $groupid; ?>')" href="javascript:void(0)"><i class="fa red fa-trash"></i></a> 
                                         <a  class="btn btn-info tool" data-tip="Edit" href="<?php echo BASE_URL.'projectsgroup/editprojectsgroup/'.$groupid; ?>"><i class="fa green fa-edit"></i></a>
                                          
                      <?php if($row['visibility'] != 1){ ?>
                       <a class="btn btn-success tool" data-tip="Publish" href="<?php echo BASE_URL.'projectsgroup/showprojects/'.$row['id']; ?>"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                
                                    <?php } else{ ?>
                                        <a  class="btn btn-success tool" data-tip="Draft" href="<?php echo BASE_URL.'projectsgroup/hideprojects/'.$row['id']; ?>"><i class="fa fa-eye"></i></a>
                                   
                                    <?php }  ?>
                                  <?php if($row['password_protected'] == 1){ ?>
                                   <a  class="btn btn-success tool" data-tip="Unlock" href="<?php echo BASE_URL.'projectsgroup/unlock/'.$row['id']; ?>"><i class="fa fa-lock" aria-hidden="true"></i></a>
                                  <?php } else{ ?>
                                  <a  class="btn btn-info tool" data-tip="Lock" href="<?php echo BASE_URL.'projectsgroup/lock/'.$row['id']; ?>"><i class="fa fa-unlock" aria-hidden="true"></i></a>
                               <?php }  ?>
                                     </div>
                                    </td>
                                </tr>
								
                             <?php } } ?>
							</tbody>
                        </table>
                    </div>
                    </form>
                </div>
            </div>
           
</div><!-- Panel Content -->