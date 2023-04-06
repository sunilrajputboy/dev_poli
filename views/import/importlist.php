<div class="content">
<div class="container-fluid">
   <div class="col-md-12 card">
      <div class="header">
         <h4 class="title"><b>Import View</b></h4>
         <hr>
	      <table id="importLists" class="table table-hover table-striped  table-bordered" cellspacing="0" width="100%">
	         <thead>
	            <tr>
	               <th>ID</th>
	               <th>FILENAME</th>
	               <th>EXT</th>
				   <th>UNIQUID</th>
	               <th>ROW</th>
	               <th>TABLE</th>
				   <th>DATA</th>
	               <th>DEL</th>
	               <th>EXPORT</th>
	            </tr>
	         </thead>
	         <tfoot>
	            <tr>
	               <th>ID</th>
	               <th>FILENAME</th>
	               <th>EXT</th>
				   <th>UNIQUID</th>
	               <th>ROW</th>
	               <th>TABLE</th>
	               <th>DATA</th>
	               <th>DEL</th>
	               <th>EXPORT</th>
				</tr>
	         </tfoot>
	         <tbody>
	         </tbody>
	      </table>
   </div>
</div>
</div>
</div>

<!-- AJAX MODAL -->
 <div id="view-row" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
             <div class="modal-dialog modal-lg"> 
                  <div class="modal-content"> 
                       <div class="modal-header"> 
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                            <h4 class="modal-title">
	                             <b>IMPORTED ROWS</b>
                            </h4> 
                       </div> 
                       <div class="modal-body"> 
                       	   <div id="modal-loader1" style="display: none; text-align: center;">
                       	   	<img src="<?php echo BASE_URL;?>public/assets/img/ajax-loader.gif">
                       	   </div>
                           <div id="dynamic-content1"></div>
                        </div> 
                        <div class="modal-footer"> 
                              <button type="button" class="btn btn-round btn-danger btn-fill" data-dismiss="modal"><i class="fa fa-close"></i>Close</button>  
                        </div> 
                 </div> 
              </div>
       </div>   
</div>    

