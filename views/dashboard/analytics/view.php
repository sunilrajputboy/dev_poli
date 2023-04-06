<div class="dashboard">
<div class="page-header-wrap">
    <h3>Analytics</h3>
</div>
    <div class="">
<div class="">
	 	<div class="dashboard-wrapper">
	<div class="row">
	    <div class="col-md-12 form-group">
	         <div class="widget">
	     <div class="select-c-box project-details">
	         <div class="row">
	             <div class="col-md-3">
        <div class="form-group">
         <label> Select Client </label>
        <select class="form-control select_clients" id="allclient" onchange="selectClient(this)">
            <option value="0" >All clients</option>
           <?php
          foreach($allClients as $cname){
              ?>
              <option value="<?php echo $cname['id']; ?>" ><?php echo $cname['name']; ?></option>
              <?php
          }
           ?>
        </select>
        </div>
        </div>
        <div class="col-md-3">
        <div class="form-group">
         <label> Select Projects </label>
        <select class="form-control select_projects" id="allproject" onchange="selectprojects(this)">
            <option value="0" >All projects</option>
          <?php foreach($projects as $pro){ ?>
          <option value="<?php echo $pro['proKey']; ?>" ><?php echo $pro['name']; ?></option>
          <?php
          } ?>
        </select>
        </div>
        </div>
          <div class="col-md-2">
           <div class="form-group" id="projects_views">
         <label>No of visits</label>
        <select class="form-control" id="selectnovisit" onchange="selectnovisits(this)">
            <option value="all" >Total visits</option>
              <option value="week" >Last week</option>
            <option value="30d" >Last 30 days</option>
            <option value="6m" >Last 6 months</option>
          <option value="12m" >Last 12 months</option>
          <option value="custom" >Custom range</option>
        </select>
        </div>
        </div>
        <div class="col-md-2">
        <div class="form-group" id="custom_from">
         <label>From</label>
         <input class="form-control" type="date" disabled name="from" id="from">
        </div>
        </div>
        <div class="col-md-2">
        <div class="form-group" id="custom_to">
         <label>To</label>
         <input class="form-control" type="date" disabled name="to" id="to">
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
                      <div class="row">
                        <div class="col-md-4">
                            <div class="widget">
                               <a href="javascript:void(0)">
                                    <div class="mini-stats t-clients">
                                    <div>
                                    <h3 id="no_of_visits"><?php echo count($views); ?></h3>
                                        <p id="no_of_visits_text">Total visits</p>
                                    </div>
                                       <label><i class="fa fa-user-plus"></i></label>
                                </div>
                               </a>
                            </div>
                        </div>
                          <div class="col-md-4">
                            <div class="widget">
                               <a href="javascript:void(0)">
                                    <div class="mini-stats t-users">
                                    <div>
                                    <h3 id="faecbook_share"><?php echo count($facebook_share); ?></h3>
                                        <p id="">Total facebook share</p>
                                    </div>
                                       <label><i class="fa fa-facebook"></i></label>
                                </div>
                               </a>
                            </div>
                        </div>
                         <div class="col-md-4">
                            <div class="widget">
                               <a href="javascript:void(0)">
                                    <div class="mini-stats t-projects">
                                    <div>
                                    <h3 id="linkedin_share"><?php echo count($linkedin_share); ?></h3>
                                        <p id="">Total linkedin share</p>
                                    </div>
                                       <label><i class="fa fa-linkedin"></i></label>
                                </div>
                               </a>
                            </div>
                        </div>
                          <div class="col-md-4">
                            <div class="widget">
                               <a href="javascript:void(0)">
                                    <div class="mini-stats t-visitor">
                                    <div>
                                    <h3 id="twitter_share"><?php echo count($twitter_share); ?></h3>
                                        <p id="">Total twitter share</p>
                                    </div>
                                       <label><i class="fa fa-twitter"></i></label>
                                </div>
                               </a>
                            </div>
                        </div>
                        
                          <div class="col-md-4">
                            <div class="widget">
                               <a href="javascript:void(0)">
                                    <div class="mini-stats t-email-s">
                                    <div>
                                    <h3 id="mail_share"><?php echo count($mail_friend); ?></h3>
                                        <p id="">Total email share</p>
                                    </div>
                                       <label><i class="fa fa-envelope"></i></label>
                                </div>
                               </a>
                            </div>
                        </div>
                            <div class="col-md-4">
                            <div class="widget">
                               <a href="javascript:void(0)">
                                    <div class="mini-stats t-mp-tweet">
                                    <div>
                                    <h3 id="mp_tweets"><?php echo count($mp_tweets); ?></h3>
                                        <p id="">Total mp tweets</p>
                                        <img id="loaderedit" style="display:none" src="<?php echo BASE_URL.'public/web/'; ?>images/ajax-loader.gif">
                                    </div>
                                       <label><i class="fa fa-twitter"></i></label>
                                </div>
                               </a>
                            </div>
                        </div>
                            <div class="col-md-4">
                            <div class="widget">
                               <a href="javascript:void(0)">
                                    <div class="mini-stats t-email-mp">
                                    <div>
                                    <h3 id="mail_mp"><?php echo count($mp_emails); ?></h3>
                                        <p id="">Total email mp</p>
                                          <img id="loaderedit" style="display:none" src="<?php echo BASE_URL.'public/web/'; ?>images/ajax-loader.gif">
                                    </div>
                                       <label><i class="fa fa-envelope"></i></label>
                                </div>
                               </a>
                            </div>
                        </div>
             </div> 
             
             </div>
	</div>

</div>
</div>

<!-- tweet mp view model start  -->

<div class="modal cus-modal-f" id="tweet_mp_view_Modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">Tweet Mp View </h5>
            </div>
             <div>
                <span style='color:green' class="responsemsg"></span>
                </div>
            <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="tweet_mp_view_data">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
            <button class="btn btn-secondary" id="exportBTN" style="display:none;" onclick="exportData()">Export</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- tmm end  -->
