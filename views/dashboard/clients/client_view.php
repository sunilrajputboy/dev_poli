<div class="page-header-wrap">
    <h3>Clients</h3>
      <a href="<?php echo BASE_URL; ?>clients/add" title="" class="btn cus-btn">
                      <i class="fa fa-plus"></i>
                       <span>Add Clients </span>
                      </a>
</div>


            <div class="widget">
                <div class="table-area">
                    <div class="widget-title">
					<div class="alert alert-success" id="sucessMessage" style="display:none">
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
                 
                  </div>
                  <div class="patient-f-group-btns">
                       <div class="cl-filter">
        <div class="client-filter">
                         <div class="form-group">
                <label for="table-filter">Filter by client</label>
                        <select id="table-filter" class="form-control">
                        <option value="">All</option>
                        <?php foreach($dataClientall as $row) { ?>
                        <option><?php echo $row['name']; ?></option>
                        <?php }?>
                        
                        </select>
                       </div>
                    </div>
    </div>
                   <button class="btn btn-sort" onclick="saveshorting('clients')">
                       <i class="fa fa-sort"></i>
                       <span>Sort</span>
                   </button>
                </div>

                </div> 
                    <form method="post" action="" id="rearrange">
                        <table class="table table-striped" id="packages">
                            <thead>
                                <tr>
                                    <th style="max-width: 50px">Order</th>
                                    <th style="min-width: 200px">Name</th>
                                    <th style="min-width: 200px">Email</th>
                                    <th style="min-width: 100px">Phone</th>
                                    <th>Package</th>
                                    <th>No of Users</th>
                                    <th>Projects</th>
                                    <th>Registered Date</th>
                                    <th>Registered By</th>
                                    <th style="min-width: 200px; display:none">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                   <?php 
            if(!empty($dataClientall)){
        $count = 0;
       foreach($dataClientall as $row) {
           $count++;
          ?>
                                <tr <?php if($row['is_suspended'] == 1){ ?>class="tr_suspended"<?php } ?>>
                                    <td class="index"><?php echo $count; ?></td>
                                    <td style="width: 200px">
                                        <input type="hidden" value="<?php echo $row['id']; ?>" name="shortposition[]" class="shortposition">
                                   <div class="custom-checkbox">
                                        <input id="<?php echo $row['id']; ?>" type="checkbox" value="<?php echo $row['id']; ?>" class="chkbx" name="chkbx[]">
                                    	<label for="<?php echo $row['id']; ?>">
                                    		<span></span>
                                    		<a href="<?php echo  BASE_URL.'clients/edit/'.$row['id']; ?>"><?php echo $row['name']; ?></a>
                                    	</label>
                                   </div>
                                   
                                    </td>
                                    <td style="width: 200px"><?php echo $row['email']; ?></td>
                                    <td style="width: 100px"><?php echo $row['phone']; ?></td>
                                    <?php $pid = $row['package'];
									$querypackage=$mthis->model->getPackageById($pid);?>
                                    <td style="width: 250px"><?php
                                    if(!empty($querypackage)){
                                echo $querypackage[0]['name'];
                                    }
                                    ?></td>
                                  
                                   
                                    <td><?php 
                                    $cid = $row['id'];
                                    
            if(!empty($allUsers)){
                $userCount = 0;
                foreach($allUsers as $UserData){
                        $clients =  $UserData['clients'];
                        if($clients != null){
                       if(in_array($cid, unserialize($clients))){
                           $userCount++;
                       }
                        }
                }
            
            }                     ?><a class="badge badge-primary" href="<?php echo BASE_URL; ?>/users/profile/?id=<?php echo $row['id'];  ?>"><?php echo $userCount++;;  ?></a></td>
                                      <td><a class="badge badge-primary"  href="<?php echo BASE_URL; ?>projects/?id=<?php echo $row['id']; ?>"><span class=""><?php 
                                      $cid = $row['id'];
                                      $prodata = $mthis->model->getProjectById($cid);
                                      $countpro = 0;
									  if(!empty($prodata)){ $countpro=count($prodata); }
                                    echo $countpro;
                                      ?></a></span></td>
                                    <td><span class=""><?php 
$s =  $row['register_date'];
$dt = new DateTime($s);
$date = $dt->format('d/m/Y');
$time = $dt->format('H:i:s');

                                    echo $date; ?></span></td>
                                     <td><span class=""><?php 
                                     $userDataAll1 = $mthis->model->getUserById($row['register_by']);
									 $userDataAll=$userDataAll[0];
                                     ?>
                                     <a class="badge badge-primary" href="<?php echo BASE_URL; ?>users/profile/?id=<?php echo $userDataAll['id']; ?>"><?php echo $userDataAll['name']; ?></a>
                                     <?php ?></span></td>
                                  
                                    <td style="min-width: 200px; display:none">
                                        <div class="btn-rounded">
                                        <a class="btn btn-danger tool" onclick="return letsconfirm('Are you sure you want to Delete?<p><?php echo str_replace("'","-", $row['name']);?></p>','<?php echo  BASE_URL.'/clients/delete/?id='. $row['id']; ?>')" href="javascript:void(0)" data-tip="Delete"><i class="fa red fa-trash" ></i></a> 
                                        <a class="btn btn-info tool"  href="<?php echo BASE_URL.'clients/edit/?id='.$row['id'];  ?>" data-tip="Edit"><i class="fa green fa-edit"></i></a>
                                    <?php if($row['is_suspended'] == 0){ ?>
                                    <a  class="btn btn-success tool" href="<?php echo BASE_URL.'clients/suspendclients/?id='.$row['id']; ?>" data-tip="Suspend"><i class="fa fa-eye"  ></i></a>
                                    <?php } else{
                                    ?>
                                     <a class="btn btn-success tool" href="<?php echo BASE_URL.'clients/activeclients/?id='.$row['id']; ?>" data-tip="Unsuspend"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                     </div>
                                     
                                    <?php
                                    
                                    } ?>
                                    </td>
									
                                </tr>
                                <?php } } ?>
                            
							
							
							</tbody>
                        </table>
                    </div>
                    </form>
                </div>
            </div>
 <script>
                            var d = localStorage.getItem('client_delete_msg');
                            if(d){
                               document.getElementById("sucessMessage").style.display = 'block';
                               
                               localStorage.removeItem('client_delete_msg');
                               	removeMsg('sucessMessage');
                            }
                            var packageshow = localStorage.getItem('client_show');
                              if(packageshow){
                               document.getElementById("sucessMessage").style.display = 'block';
                               document.getElementById("suc_msg").innerHTML = 'Client activate succesfully !!';
                               removeMsg('sucessMessage');
                               localStorage.removeItem('client_show')

                            }
                            var packagehide = localStorage.getItem('client_hide');
                              if(packagehide){
                               document.getElementById("sucessMessage").style.display = 'block';
                               document.getElementById("suc_msg").innerHTML = 'Client suspended succesfully !!';
                               removeMsg('sucessMessage');
                               localStorage.removeItem('client_hide')

                            }
                               var clientAdded = localStorage.getItem('client_message_sucess');
                              if(clientAdded){
                               document.getElementById("sucessMessage").style.display = 'block';
                               document.getElementById("suc_msg").innerHTML = 'Client added succesfully !!';
                               removeMsg('sucessMessage');
                               localStorage.removeItem('client_message_sucess')

                            }
                            
                            
                             
    
    	var sucess_msg_up = localStorage.getItem("message_sucess_up");
	var error_msg_up = localStorage.getItem("message_error_up");
	if (sucess_msg_up != null) {

		document.getElementById("sucessMessage").style.display = 'block';
		document.getElementById("suc_msg").innerHTML = sucess_msg_up;
	removeMsg('sucessMessage');
	}  
	if (error_msg_up != null) {
	
		document.getElementById("errorMessage").style.display = 'block';
		document.getElementById("err_msg").innerHTML = error_msg_up;
			removeMsg('sucessMessage');
	}
	localStorage.removeItem("message_sucess_up");
	localStorage.removeItem("message_error_up");
     localStorage.setItem("activetab", 'general1');
      localStorage.setItem("tabid", '#1a');
     
                        </script>
</div><!-- Panel Content -->