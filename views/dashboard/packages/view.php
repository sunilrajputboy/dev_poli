<div class="page-header-wrap">
    <h3>Packages</h3>
     <a href="<?php echo  BASE_URL.'packages/add'; ?>" title="" class="btn cus-btn">
                     
                      <i class="fa fa-plus"></i>
                       <span>Add package </span>
                      </a>
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
					
                        <div class="alert alert-success" id="sucessMessage" style="display:none">
                                <p id="suc_msg">Data deleted Successfully !!</p>
                        </div>
						
                    </div>
                 <div class="patient-f-group-wrapper">
                   <div class="patient-f-group">
                  <div class="table-data-suspend">
                <button class="btn btn-light-red" onclick="return dowithselected('delete','packages',event)"  value="delete" > <i class="fa red fa-trash"></i>  <span>Delete</span></button>
                <button class="btn btn-light-gray" onclick="return dowithselected('hide','packages',event)"  value="hide" > <i class="fa fa-eye-slash"></i> <span>Hide</span> </button>
                <button class="btn btn-light-green" onclick="return dowithselected('show','packages',event)"  value="show" > <i class="fa fa-eye"></i> <span>Show</span> </button>
            </div>
                  </div>
                  <div class="patient-f-group-btns">
                
                
                   <button class="btn btn-sort" onclick="saveshorting('packages')">
                       <i class="fa fa-sort"></i>
                       <span>Sort</span>
                   </button>
                </div>

                </div> 
                    <form method="post" action="" id="rearrange">
                    <div class="">
                        <table class="table table-striped" id="packages">
                            <thead>
                                <tr>
                                    <th style="max-width: 50px">Order</th>
                                    <th style="min-width:250px;">Name</th>
                                    <th>No of allowed users</th>
                                    <th>No of allowed projects</th>
                                    <th>Allowed maps</th>
                                    <th>Logo</th>
                                    <th>Charts</th>
                                    <th>Fonts</th>
                                    <th>Email MP</th>
                                    <th>No of clients</th>
                                    <th style="min-width: 200px; display:none;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
       <?php
       if(!empty($packageList)){
        $count = 0;
       foreach($packageList as $row) {
           $count++;
		   $clientList = $mthis->model->getClientBypackageId($row['id']);
          ?>
                                <tr <?php if($row['visibility'] == 0){ ?>class="tr_suspended"<?php } ?>>
                                    <td class="index"><?php echo $count; ?></td>
                    
                                    <td style="min-width: 170px">
                                        <input type="hidden" value="<?php echo $row['id']; ?>" name="shortposition[]" class="shortposition">
                                        
                                   <div class="custom-checkbox">
                                        <input id="<?php echo $row['id']; ?>" type="checkbox" value="<?php echo $row['id']; ?>" class="chkbx" name="chkbx[]">
                                    	<label for="<?php echo $row['id']; ?>">
                                    		<span></span>
                                    		<a href="<?php echo  BASE_URL.'packages/edit/'.$row['id']; ?>"><?php echo $row['name']; ?></a>
                                    		</label>
                                   </div>  
                                    		<div class="btn-group btn-rounded ml-2">
                                              <button type="button" class="btn cus-btn-border dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v"></i>
                                              </button>
                                              <ul class="dropdown-menu btn-rounded">
                                                   <li> <a class="btn btn-info tool" data-tip="Edit"  href="<?php echo  BASE_URL.'packages/edit/'.$row['id'];  ?>"><i class="fa green fa-edit"></i></a></li>
                                                <li>
                                                    <?php if($row['visibility'] == 1){ ?>
                                   <a class="btn btn-success tool" data-tip="Hide" href="<?php echo  BASE_URL.'packages/hidepackage/?id='.$row['id']; ?>"><i class="fa fa-eye"></i></a>
                                    <?php } else{
                                    ?>
                                     <a class="btn btn-success tool" data-tip="Show" href="<?php echo  BASE_URL.'packages/showpackage/?id='.$row['id']; ?>"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                      </li>
                                    <?php
                                    } ?>
                                             <li> <a class="btn btn-danger tool" data-tip="Delete" onclick="<?php if(count($clientList) < 1){ ?>return letsconfirm('Are you sure you want to Delete?<p><?php echo str_replace("'","-", str_replace('"','-', $row['name']));?></p>','<?php echo  BASE_URL.'packages/delete/?id='. $row['id']; ?>')<?php }else{ ?>displayClientList('<?php echo $row['id']; ?>')<?php } ?>" href="javascript:void(0)"><i class="fa red fa-trash"></i></a></li>
                                              </ul>
                                            </div>
                                   
                                    </td>
                                    <td><?php echo $row['no_allowed_user']; ?></td>
                                    <td><?php echo $row['no_allowed_projects']; ?></td>
                                    <td><ul class="allclient">
                                        <!--<?php //echo $row['no_allowed_maps']; ?>-->
                                        <?php 
                                         $maplist = explode(",", $row['no_allowed_maps']);
                                            $maps = "";
                                            // foreach ($maplist as $map) {
                                            //   echo $maps = '<li><span>'.$map.'</span></li>';
                                            // }
                                            
                                            	foreach ($maptemplates as $row) {
									                foreach ($maplist as $map)
									                {
														if ($row['map_name'] == $map || $row['id_map_templates'] == $map) 
														{
															echo '<li><span>'.$row['map_name'].'</span></li>';
														}
													}
										        }
                                            
                                            
                                        ?>
                                        </ul>
                                        </td>
                                    <td><?php
                                    if($row['is_logo'] == 'yes'){
                                      echo '<i class="fa fa-check green"></i>';  
                                    }else{
                                        echo '<i class="fa fa-times red">';
                                    }
                                    ?>
                                        
                                        </td>
                                    <td><?php
                                    if($row['is_charts'] == 'yes'){
                                      echo '<i class="fa fa-check green"></i>';  
                                    }else{
                                        echo '<i class="fa fa-times red">';
                                    }
                                    ?></i></td>
                                    <td><?php
                                    if($row['is_fonts'] == 'yes'){
                                      echo '<i class="fa fa-check green"></i>';  
                                    }else{
                                        echo '<i class="fa fa-times red">';
                                    }
                                    ?></i></td>
                                    <td><?php
                                    if($row['email_mp'] == 'yes'){
                                      echo '<i class="fa fa-check green"></i>';  
                                    }else{
                                        echo '<i class="fa fa-times red">';
                                    }
                                    ?></td>
                                    <td><span class=""><?php 
                                    $id = $row['id']; echo count($clientList); ?></span></td>
                                
                                    <td style="min-width: 200px; display:none;">
                                        <div class="btn-rounded">
                                        <a  class="btn btn-danger tool" data-tip="Delete" onclick="<?php if(count($clientList) < 1){ ?>return letsconfirm('Are you sure you want to Delete?<p><?php echo str_replace("'"," ", $row['name'])?></p>','<?php echo  BASE_URL.'packages/delete/?id='. $row['id']; ?>')<?php }else{ ?>displayClientList('<?php echo $row['id']; ?>')<?php } ?>" href="javascript:void(0)"><i class="fa red fa-trash"></i></a>
                                        
                                        <a   class="btn btn-info tool" data-tip="Edit"  href="<?php echo  BASE_URL.'packages/edit/?id='.$row['id'];  ?>"><i class="fa green fa-edit"></i></a>
                                    <?php if($row['visibility'] == 1){ ?>
                                    <a  class="btn btn-success tool" data-tip="Hide" href="<?php echo  BASE_URL.'packages/hidepackage/?id='.$row['id']; ?>"><i class="fa fa-eye"></i></a>
                                    <?php } else{
                                    ?>
                                     <a class="btn btn-success tool" data-tip="Show" href="<?php echo  BASE_URL.'packages/showpackage/?id='.$row['id']; ?>"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
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
</div><!-- Panel Content -->

<div class="modal fade client-list-popup cus-modal-f" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
        
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title">Note</h5>
      </div>
        
	<div class="modal-body">
	    <div class="alert alert-danger mb-10">Assign the related companies to one of the current packages.</div>
     <ul class="assign-com">
         <?php $count = 0; foreach($clientList as $client){ $count++; ?>
         <li>
             <i class="fa fa-user-plus"></i> <?php echo $client['name']; ?>
             <!--$count.'. ' .-->
         </li>
         <?php } ?>
     </ul>
    </div>
	
  </div>
</div>
</div>

<script>
// delete model script
  var d = localStorage.getItem('package_delete_msg');
                            if(d){
                               document.getElementById("sucessMessage").style.display = 'block';
                               
                               localStorage.removeItem('package_delete_msg');
                               	removeMsg('sucessMessage');

                            }
                            var packageshow = localStorage.getItem('packageshow');
                              if(packageshow){
                               document.getElementById("sucessMessage").style.display = 'block';
                               document.getElementById("suc_msg").innerHTML = 'Projects shown succesfully !!';
                               
                               localStorage.removeItem('packageshow');
                                // 	removeMsg('sucessMessage');

                            }
                            var packagehide = localStorage.getItem('packagehide');
                              if(packagehide){
                               document.getElementById("sucessMessage").style.display = 'block';
                               document.getElementById("suc_msg").innerHTML = 'Projects hidden succesfully !!';
                               localStorage.removeItem('packagehide')

                            }
                            
                            
   var sucess_msg = localStorage.getItem("message_sucess_package");


   var error_msg = localStorage.getItem("message_error_package");
    if(sucess_msg != null){
         document.getElementById("sucessMessage").style.display = 'block';
 document.getElementById("suc_msg").innerHTML = sucess_msg;
     	removeMsg('sucessMessage');
    }else if(error_msg != null){
        document.getElementById("errorMessage").style.display = 'block';
 document.getElementById("err_msg").innerHTML = error_msg;
         	removeMsg('errorMessage');
    }
    localStorage.removeItem("message_sucess_package");
    localStorage.removeItem("message_error_package");
    
    	var sucess_msg_up = localStorage.getItem("message_sucess_package_update");
	var error_msg_up = localStorage.getItem("message_error_package_update");
	if (sucess_msg_up != null) {

			document.getElementById("sucessMessage").style.display = 'block';
		document.getElementById("suc_msg").innerHTML = sucess_msg_up;
			removeMsg('sucessMessage');
	} else if (error_msg_up != null) {
	
			document.getElementById("sucessMessage").style.display = 'block';
		document.getElementById("err_msg").innerHTML = error_msg_up;
			removeMsg('sucessMessage');
	}
	localStorage.removeItem("message_sucess_package_update");
	localStorage.removeItem("message_error_package_update");

</script>