<?php
$cid=null;
 if(isset($_SESSION['cid'])){
	$cid = $_SESSION['cid'];
	} ?>
<div class="page-header-wrap">
    <h3>Users</h3>
     <a href="<?php echo BASE_URL.'users/add/'; ?>" title="" class="btn cus-btn">
                      <i class="fa fa-plus"></i>
                       <span>Add Users </span>
                      </a>
</div>

            <div class="widget">
                <div class="table-area">
                    <div class="widget-title">
    
                          <div class="message">
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
                        
                       
                    </div>
                 <div class="patient-f-group-wrapper">
                   <div class="patient-f-group">
                  <div class="table-data-suspend">
                <button class="btn btn-light-red" onclick="return dowithselected('delete','users')"  value="delete" > <i class="fa red fa-trash"></i>  <span>Delete</span></button>
                <button class="btn btn-light-gray" onclick="return dowithselected('suspend','users')"  value="hide" > <i class="fa fa-eye-slash"></i> <span>Suspend</span> </button>
                <button class="btn btn-light-green" onclick="return dowithselected('active','users')"  value="show" > <i class="fa fa-eye"></i> <span>Activate</span> </button>
            </div>
                  </div>
                  <div class="patient-f-group-btns">
                
                <div class="cl-filter">
        <div class="client-filter">
                         <div class="form-group">
                <label for="table-filter">Filter by client</label>
                        <select id="" class="form-control" onchange="filterByclientUser(this)">
                        <option value="all">All</option>
                         <?php  foreach($clients as $row) { ?>
                        <option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $cid){ echo 'selected'; } ?>><?php echo $row['name']; ?></option>
                        <?php } ?>
                           <option value="orphan" <?php if($cid == 'orphan'){ echo 'selected'; } ?>>Orphan user</option>
                        </select>
                       </div>
                    </div>
    </div>
                   <button class="btn btn-sort" onclick="saveshorting('users')">
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
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Clients</th>
                                    <th>Suspended</th>
                                    <th style="min-width:120px">Last login</th>
                                    <th style="min-width: 200px; display:none;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
            <?php
            if(!empty($users)){
        $count = 0;
        $userData = array();
       foreach($users as $row){
       $clientData = $row['clients'];
		if($clientData != null && $cid !=null){
			if(in_array($cid,unserialize($clientData))){
				array_push($userData,$row['id']);
			}
		} 
         if($cid == null){
             array_push($userData,$row['id']);
         }
         if($cid == 'orphan' && $clientData==null){
             array_push($userData,$row['id']);
         }
		if(in_array($row['id'],$userData)){
           $count++;
          ?>
                                <tr <?php if($row['suspended'] == 1){ ?>class="tr_suspended"<?php } ?>>
                                    <td class="index"><?php echo $count; ?></td>
                    
                                    <td style="width: 250px">
                                        <input type="hidden" value="<?php echo $row['id']; ?>" name="shortposition[]" class="shortposition">
                                        
                                   <div class="custom-checkbox">
                                        <input id="<?php echo $row['id']; ?>" type="checkbox" value="<?php echo $row['id']; ?>" class="chkbx" name="chkbx[]">
                                    	<label for="<?php echo $row['id']; ?>">
                                    		<span></span>
                                    		
                                    		<a href="<?php echo  BASE_URL.'users/edit/'.$row['id']; ?>"><?php echo $row['name']; ?></a>
                                    	</label>
                                   </div>    
                                        	<div class="btn-group btn-rounded ml-2">
                                              <button type="button" class="btn cus-btn-border dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v"></i>
                                              </button>
                                              <ul class="dropdown-menu btn-rounded">
                                               <li><a  class="btn btn-info tool" data-tip="Edit"  href="<?php echo BASE_URL.'users/edit/'.$row['id'];?>"><i class="fa green fa-edit"></i></a></li>
                                                <li>
                                        <?php if($row['suspended'] == 1){ ?>
                                     <a  class="btn btn-success tool" data-tip="Unsuspend" href="<?php echo BASE_URL.'users/activeusers/'.$row['id']; ?>"><i class="fa fa-eye-slash"></i></a>
                                    <?php } else{
                                    ?>
                                     <a class="btn btn-success tool" data-tip="Suspend" href="<?php echo BASE_URL.'users/suspendusers/'.$row['id']; ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                     
                                    <?php
                                    } ?>
                                                </li>
                                    <!--            <li>-->
                                    <!--            <?php// if($row['allowed_client_add'] != 1){ ?>-->
                                    <!--<a class="btn btn-warning tool" data-tip="Allow client privilage" href="<?php //echo BASE_URL.'users/allowclientprivilage/'.$row['id']; ?>"><i class="fa fa-users"></i></a>-->
                                    <!--<?php //}else{ ?>-->
                                    <!--<a class="btn btn-warning btn-warning-1 tool" data-tip="Disallow client privilage" href="<?php //echo BASE_URL.'users/disallowclientprivilage/'.$row['id']; ?>"><i class="fa fa-users"></i></a>-->
                                    <!--<?php// } ?>-->
                                    <!--</li>-->
                                    <!--<li>-->
                                    <!--  <?php// if($row['allowed_user_add'] != 1){ ?>-->
                                    <!--<a class="btn btn-user tool" data-tip="Allow user privilage" href="<?php //echo  BASE_URL.'users/allowuserprivilage/'.$row['id']; ?>"><i class="fa fa-user-plus"></i></a>-->
                                    <!--<?php //}else{ ?>-->
                                    <!--<a class="btn btn-user btn-user-1 tool" data-tip="Disallow user privilage" href="<?php //echo BASE_URL.'users/disallowuserprivilage/'.$row['id']; ?>"><i class="fa fa-user-plus"></i></a>-->
                                    <!--<?php// } ?>-->
                                    <!--</li>-->
                                     <li> <a  class="btn btn-danger tool" data-tip="Delete" onclick="return letsconfirm('Are you sure you want to Delete?<p><?php echo str_replace("'","-", str_replace('"','-', $row['name']));?></p>','<?php echo BASE_URL.'users/delete/'. $row['id']; ?>')" href="javascript:void(0)"><i class="fa red fa-trash"></i></a> </li>
                                              </ul>
                                            </div>
                                    </td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['phone']; ?></td>
                                   
                                    <td style="width: 250px">
					<ul class="allclient"> <?php
                        $pid = $row['clients'];
                        if($pid != null){
                            $uid = unserialize($pid);
                            $uid = implode(",",$uid);
                            $allClients =$mthis->model->getClientsWhereIn($uid);
                              ?>
                        <?php 
						$countClients=0;
							if(!empty($allClients)){
                              foreach($allClients as $clientResultData){ $countClients++;
						?>
                                <li><span><?php  echo $clientResultData['name'];  ?></span></li>
                        <?php } } ?> 
                    <?php } ?>
					 </ul>
					</td>
                               
                                    
                                    <td><?php
                                    if($row['suspended'] == 1){
                                      echo '<i class="fa fa-check green"></i>';  
                                    }else{
                                        echo '<i class="fa fa-times red">';
                                    }
                                    ?>
                                        
                                        </td>
                                    <td style="min-width:120px"><?php echo $row['last_login']; ?></td>
                                    <td style="min-width: 230px; display:none;">
                                        <div class="btn-rounded">
                                        <a  class="btn btn-danger tool" data-tip="Delete" onclick="return letsconfirm('Are you sure you want to Delete?<p><?php echo $row['name'];?></p>','<?php echo BASE_URL.'users/delete/'.$row['id']; ?>')" href="javascript:void(0)"><i class="fa red fa-trash"></i></a> 
                                        <a   class="btn btn-info tool" data-tip="Edit"  href="edit.php?id=<?php echo $row['id'];  ?>"><i class="fa green fa-edit"></i></a>
                                    <?php if($row['suspended'] == 1){ ?>
                                    <a  class="btn btn-success tool" data-tip="Unsuspend" href="<?php echo BASE_URL.'users/activeusers/'.$row['id']; ?>"><i class="fa fa-eye-slash"></i></a>
                                    <?php } else{
                                    ?>
                                     <a class="btn btn-success tool" data-tip="Suspend" href="<?php echo BASE_URL.'users/suspendusers/'.$row['id']; ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                     
                                    <?php
                                    } ?>
                                    <?php if($row['allowed_client_add'] != 1){ ?>
                                    <a class="btn btn-warning tool" data-tip="Allow client privilage" href="<?php echo BASE_URL.'users/allowclientprivilage/'.$row['id']; ?>"><i class="fa fa-users"></i></a>
                                    <?php }else{ ?>
                                    <a class="btn btn-warning btn-warning-1 tool" data-tip="Disallow client privilage" href="<?php echo BASE_URL.'users/disallowclientprivilage/'.$row['id']; ?>"><i class="fa fa-users"></i></a>
                                    <?php } ?>
                                      <?php if($row['allowed_user_add'] != 1){ ?>
                                    <a class="btn btn-user tool" data-tip="Allow user privilage" href="<?php echo BASE_URL.'users/allowuserprivilage/'.$row['id']; ?>"><i class="fa fa-user-plus"></i></a>
                                    <?php }else{ ?>
                                    <a class="btn btn-user btn-user-1 tool" data-tip="Disallow user privilage" href="<?php echo BASE_URL.'users/disallowuserprivilage/'.$row['id']; ?>"><i class="fa fa-user-plus"></i></a>
                                    <?php } ?>
                                     </div>
                                    </td>
                                </tr>
                                <?php  }  }
           } ?>
							</tbody>
                        </table>
                    </div>
                    </form>
                </div>
            </div>
            <?php
unset($_SESSION['cid']);
?>
 <script>
                            var d = localStorage.getItem('user_delete_msg');
                            if(d){
                               document.getElementById("sucessMessage").style.display = 'block';
                               localStorage.removeItem('user_delete_msg');
                               //removeMsg('sucessMessage');
                            }
                            var packageshow = localStorage.getItem('user_show');
                              if(packageshow){
                               document.getElementById("sucessMessage").style.display = 'block';
                               document.getElementById("suc_msg").innerHTML = 'User activated succesfully.';
                               
                               localStorage.removeItem('user_show');
                               //removeMsg('sucessMessage');

                            }
                            var packagehide = localStorage.getItem('user_hide');
                              if(packagehide){
                               document.getElementById("sucessMessage").style.display = 'block';
                               document.getElementById("suc_msg").innerHTML = 'User suspended succesfully.';
                               
                               localStorage.removeItem('user_hide');
                             //removeMsg('sucessMessage');

                            }
                             var user_Update = localStorage.getItem('user_update');
                              if(user_Update){
                               document.getElementById("sucessMessage").style.display = 'block';
                               document.getElementById("suc_msg").innerHTML = 'User updated succesfully.';
                               localStorage.removeItem('user_update');
                                //removeMsg('sucessMessage');

                            }
                            
                         
                        </script>
</div><!-- Panel Content -->
