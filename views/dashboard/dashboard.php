<div class="dashboard">
<div class="page-header-wrap">
    <h3>Dashboard</h3>
<div class="current-user">
    <span class="c-user-icon">
	
	<?php $name = explode(" ",  $userDatass['name']);
	$word = "";
	foreach ($name as $n ) {
	  $word .= $n[0];
	}
	echo $word;
	?>
	</span>
<p><?php echo $userDatass['name'];?></p>
</div>
</div>
<?php if(USERROLE==2){ ?>
    <div class="widget">
        <div class="table-area">
<div class="message">
<?php if(isset($_SESSION['success_message'])){ ?>
<div class="alert alert-success" id="success_message">
	</button><p id="suc_msg"><?php echo $_SESSION['success_message']; ?></p>
</div>
	<?php unset($_SESSION['success_message']); } ?>
	
    <?php if(isset($_SESSION['error_message'])){ ?>
	<div class="alert alert-success" id="error_message">
		</button><p id="suc_msg"><?php echo $_SESSION['error_message']; ?></p>
	</div>
	<?php unset($_SESSION['error_message']); } ?>
	   </div>
   
    <div class="clientdata">
 
    </div>
        <?php 
        if(!empty($alldataclient)){
            $count = count($alldataclient);
            if($count==1){
               // print_r($alldataclient);
               foreach($alldataclient as $clint){
               $_SESSION['selectid'] = $clint['id'];
               }
            }
            ?>
           <?php if( $count != 1){ ?>
        <div class="row"><div class="col-md-6">
             <ul class="company">
                    <li class="active">Company</li>
        </ul>
        <div class="select-c-box">
        <div class="form-group">
          
       <?php if( $count != 1){
            echo "<label>Select Your Company</label>";
           ?>
        <select   class="form-control" onchange="selectCompany(this)">
            <option value="0" >Select your company</option>
            <?php foreach($alldataclient as $clientData){?>
            <option value="<?php echo $clientData['id']; ?>" <?php  if(isset($_SESSION['selectid']) && $clientData['id'] == $_SESSION['selectid']){ echo 'selected'; } ?>><?php echo $clientData['name']; ?></option>
            <?php } ?>
        </select>
        <?php } ?>
        </div>
        </div>
        </div></div>
        <?php } ?>
        <?php } ?>
        <div class="dash-contact">
         
            <form action="javascript:void(0)" id="upgradeDowngradeform" method="post">
                <div class="row">
                <div class="col-md-6">
                     <div class="alert alert-success admin-info">
                        <!--<p>Contact admin to upgrade/downgrade your package or to add more users to your company.</p>-->
                        <p>Contact the PoliMapper team to discuss your package, including adding extra projects and users.</p>
                    </div>
                <div class="project-dtails">
                   
                       <div class="pro-heading">
												<h4>Contact Form</h4>
											</div>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text"value="<?php echo $userDatass['name'];?>" class="form-control" disabled>
                </div>
                <input type="hidden" name="uid" value="<?php echo $userDatass['id']; ?>" />
                 <input type="hidden" name="email" value="<?php echo $userDatass['email']; ?>" />
                  <input type="hidden" name="phone" value="<?php echo $userDatass['phone']; ?>" />
                <input type="hidden" name="uname" value="<?php echo $userDatass['name']; ?>" />
                <div class="form-group">
                    <label>Title</label>
                    <select class="form-control" name="title">
                        <option>Support</option>
                        <option>Upgrade Your Package</option>
                        <option>Add More User </option>
                        <option>Other</option>
                    </select>
                </div>
                 <div class="form-group">
                    <label>Message</label>
                    <textarea class="form-control" name="message">Message</textarea>
                </div>
                <div class="text-center">
                    <button type="submit" id="upgradeDowngrademailbtn" class="btn cus-btn">Send</button>
                </div>
                </div>
                </div>
                </div>
            </form>
        </div>
    </div>
    
	<?php }else{ ?>
	    <div class="dashboard-wrapper">
	<div class="row">
                        <div class="col-md-6">
                            <div class="widget">
                               <a href="<?php echo BASE_URL?>clients">
                                    <div class="mini-stats t-clients">
                                    <div>
                                    <h3><?php echo $ClientCount; ?></h3>
                                        <p> Total Clients</p>
                                    </div>
                                       <label><i class="fa fa-user-plus"></i></label>
                                </div>
                               </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="widget">
                                <a href="<?php echo BASE_URL?>users">
                                <div class="mini-stats t-users">
                                    <div>
                                    <h3><?php echo $UserCount -1; ?></h3>
                                    <p>Total Users</p>
                                    </div>
                                    <label><i class="fa fa-users"></i></label>
                                </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="widget">
                                <a href="<?php echo BASE_URL?>projects">
                                <div class="mini-stats t-projects">
                                    <div>
                                    <h3><?php echo $ProjectCount; ?></h3>
                                     <p> Total Projects</p>
                                    </div>
                                      <label><i class="fa fa-inbox"></i></label>
                                </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="widget">
                                <div class="mini-stats t-visitor">
                                   <div> 
                                    <h3><?php echo $visitorCount; ?></h3>
                                     <p>Total Visitors</p>
                                    </div>
                                    <label><i class="fa fa-user"></i></label>
                                </div>
                            </div>
                        </div>
                    </div>
	</div>
	<?php } ?>
</div>
</div>