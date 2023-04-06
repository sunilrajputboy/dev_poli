<div class="page-header-wrap">
 <h3>Project</h3>
	 <a class="btn cus-btn" href="<?php echo BASE_URL.'projects/add' ?>" title=""><i class="fa fa-plus"></i><span>Add Project </span></a>
</div>

            <div class="widget">
                <div class="table-area">
                    <div class="widget-title">
                        <div class="alert alert-success" id="sucessMessage" style="display:none">
                             <button class="close-btn">
                                 <i class="fa fa-times"></i>
                             </button>
                                <p id="suc_msg">Data deleted Successfully !!</p>
                                
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
                <button class="btn btn-light-red" onclick="return dowithselected('delete','projects',event)"  value="delete" > <i class="fa red fa-trash"></i>  <span>Delete</span></button>
                <button class="btn btn-light-gray" onclick="return dowithselected('draft','projects',event)"  value="hide" > <i class="fa fa-eye-slash"></i> <span>Draft</span> </button>
                <button class="btn btn-light-green" onclick="return dowithselected('publish','projects',event)"  value="show" > <i class="fa fa-eye"></i> <span>Publish</span> </button>
            </div>
                  </div>
                  <div class="patient-f-group-btns">
                        <div class="cl-filter">
        <div class="client-filter">
                         <div class="form-group">
                <label for="table-filter">Filter by client</label>
                        <select id="table-filter" class="form-control" onchange="filterbyclientreflectgroup(this)">
                        <option value="">All</option>
                        <?php if(!empty($allClients)){ foreach($allClients as $row) { ?>
                        <option cid="<?php echo $row['id']; ?>" <?php if(isset($_SESSION['clientSelected'])){ if($_SESSION['clientSelected'] == $row['id']){ echo 'selected'; }   } ?>><?php echo $row['name']; ?></option>
                        <?php
                        } }
                        ?>
                        </select>
                       </div>
                    </div>
    </div>
                       
                <div class="cl-filter">
        <div class="client-filter">
                         <div class="form-group">
                <label for="table-filter">Filter by Group</label>
                        <select id="groupData" class="form-control" onchange="filterBygroup(this)">
                  <option disabled <?php if($gid == null){ echo 'selected';  } ?>>Filter by group</option>
                        <?php if(!empty($allProjectGroups)){
                        foreach($allProjectGroups as $row) { ?>
                        <option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $gid){ echo 'selected'; } ?>><?php echo $row['name']; ?></option>
                        <?php } } ?>
                        </select>
                       </div>
                    </div>
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
                                    <th style="min-width: 110px">Created by</th>
                                    <th style="min-width: 110px">View</th>
                                    <th style="min-width: 230px; display:none;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                   <?php
                               
       
            if(!empty($projects)){
        $count = 0;
       foreach($projects as $row) {
           $count++;
           $idclient = $row['id_client'];
         $resultClient = $mthis->model->getClientsById($idclient);
           if(!empty($resultClient)){
				$data = $resultClient[0];
				$nameClient = $data['name'];
				$is_suspended = $data['is_suspended'];
				$client_unique_url = $data['unique_url'];
            }else{
				$nameClient = '';
				$is_suspended = '';
				$client_unique_url = '';
            }
                                        
                                        
     $key = 'Hl2018@1212';
    $encrypted_id = openssl_encrypt($row['id_project'],'AES-128-ECB',$key, OPENSSL_RAW_DATA);
    $encrypted_id = strtolower(bin2hex($encrypted_id));
          ?>
                                <tr <?php if($row['visibility'] != 1){ ?>class="tr_suspended"<?php } ?>>
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
                                                   <li><a  class="btn btn-info tool" data-tip="Edit" href="<?php echo  BASE_URL.'projects/viewprojects/'.$encrypted_id; ?>"><i class="fa green fa-edit"></i></a></li>
                                                <li><a  class="btn btn-warning tool" data-tip="Copy" href="<?php echo  BASE_URL.'projects/copyprojects/'.$encrypted_id; ?>"><i class="fa green fa-copy"></i></a>
                                                </li>
                                                 <li>
                                     <?php if ($row['visibility'] != 1) { ?>
                                                          <a class="btn btn-success tool" data-tip="Publish" href="<?php echo BASE_URL.'projects/showprojects/'.$row['id_project']; ?>"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>

                                                        <?php } else {
                                                        ?>
                                                            <a  class="btn btn-success tool" data-tip="Draft" href="<?php echo BASE_URL.'projects/hideprojects/'.$row['id_project']; ?>"><i class="fa fa-eye"></i></a>

                                                        <?php
                                                        }  ?>
                                                </li>
                                       <!--          <li>-->
                                       <!--<?php //if ($row['password_protected'] == 1) { ?>-->
                                       <!--                    <a  class="btn btn-user-1 tool" data-tip="Unlock" href="<?php //echo BASE_URL.'projects/unlock/'.$row['id_project']; ?>"><i class="fa fa-lock" aria-hidden="true"></i></a>-->
                                       <!--                     </a>-->
                                       <!--                 <?php //} else { ?>-->
                                       <!--                     <a  class="btn btn-user tool" data-tip="Lock" href="<?php //echo BASE_URL.'projects/lock/'.$row['id_project']; ?>"><i class="fa fa-unlock" aria-hidden="true"></i></a>-->
                                       <!--             <?php //} ?>-->
                                       <!--         </li>-->
                                                 <li><a  class="btn btn-danger tool" data-tip="Delete" onclick="return letsconfirm('Are you sure you want to Delete?<p><?php echo str_replace("'","-", str_replace('"','-', $row['name']));?></p>','<?php echo BASE_URL.'projects/delete/'. $row['id_project']; ?>')" href="javascript:void(0)"><i class="fa red fa-trash"></i></a></li>
                                              </ul>
                                            </div>
                                    </td>
                                   
                                  <td style="min-width: 150px">
                                      <?php
                                      $id = $row['id_map_template'];
                                        $resultMap = $mthis->model->getMapTemplatesById($id);
                                        if(!empty($resultMap)){
                                            $data1 = $resultMap[0];
                                           echo $data1['map_name'];
                                        }
                                        
                                      ?>
                                  </td>
                                  
                                   <td>
                                      <?php
                                 echo $nameClient;
                                      ?>
                                  </td>
                                   <td style="min-width: 110px">
                                       <ul class="allclient">
                                      <?php
                              if($row['password_protected'] == 1){
                                  echo '<li><span><i class="fa fa-eye"></i></span></li> <li><span><i class="fa fa-key"></i></span></li>';    
                              }else if($row['visibility'] == 1){
                                  echo '<li><span><i class="fa fa-eye"></i></span></li>';
                              }else{
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
                                               echo $date; ?>
                                                </td>
                                                
                                                     <td>
                                               <?php 
                                               $uid = $row['added_by'];
                                           
                                               $udata = $mthis->model->getUserDetailsById($uid);
                                                if(!empty($udata)){
                                               foreach($udata as $d){
                                                   ?>
                                                   <span class=""><p class="badge badge-primary" href="<?php echo BASE_URL; ?>users/edit/<?php echo $row['id_client']; ?>"><?php echo $d['name']; ?></p></span>
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
                                    <td style="min-width: 230px; display:none;">
                                
                                        <div class="btn-rounded">
                                        <a  class="btn btn-danger tool" data-tip="Delete" onclick="return letsconfirm('Are you sure you want to Delete?<p><?php echo str_replace("'"," ", $row['name']);?></p>','<?php echo  BASE_URL.'projects/delete/'. $row['id_project']; ?>')" href="javascript:void(0)"><i class="fa red fa-trash"></i></a> 
                                         <a  class="btn btn-info tool" data-tip="Edit" href="<?php echo BASE_URL.'projects/viewprojects/'.$encrypted_id; ?>"><i class="fa green fa-edit"></i></a>
                                          <a  class="btn btn-warning tool" data-tip="Copy" href="<?php echo BASE_URL.'projects/copyprojects/'.$encrypted_id; ?>"><i class="fa green fa-copy"></i></a>
                                         
                      <?php if($row['visibility'] != 1){ ?>
                       <a class="btn btn-success tool" data-tip="Publish" href="<?php echo BASE_URL.'projects/showprojects/'.$row['id_project']; ?>"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                
                                    <?php } else{
                                    ?>
                                        <a  class="btn btn-success tool" data-tip="Draft" href="<?php echo BASE_URL.'projects/hideprojects/'.$row['id_project']; ?>"><i class="fa fa-eye"></i></a>
                                   
                                     
                                    <?php
                                    }  ?>
                                   
                                  <?php if($row['password_protected'] == 1){ ?>
                                   <a  class="btn btn-user-1 tool" data-tip="Unlock" href="<?php echo BASE_URL.'projects/unlock/'.$row['id_project']; ?>"><i class="fa fa-lock" aria-hidden="true"></i></a>
</a>
                                  <?php } else{ ?>
                                  <a  class="btn btn-user tool" data-tip="Lock" href="<?php echo BASE_URL.'projects/lock/'.$row['id_project']; ?>"><i class="fa fa-unlock" aria-hidden="true"></i></a>

                               <?php } } ?>
                                
                                     </div>
                                
                                    </td>
                                </tr>
                                <?php }  ?>
							</tbody>
                        </table>
                    </div>
                    </form>
                </div>
            </div>
           
</div><!-- Panel Content -->
<script>
       localStorage.setItem('activetab', 'li1');
     localStorage.setItem('tabid', '#1a');
</script>