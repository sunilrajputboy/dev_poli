<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="header">
                  <h4 class="title"><b>IMPORT FILE</b></h4>
               </div>
               <div class="content">
	               <div class="text-center margin-50" id="progress" style="display: none;">
				   		<img src="<?php echo BASE_URL;?>public/assets/img/ajax-loader.gif"><br><br>
				   		<small>Waiting...</small>
	               </div>
                  <form id="doImportUpload" method="post" action="<?php echo BASE_URL;?>import/doImportUpload" enctype="multipart/form-data">
                     <center>
                        <table class="table table-bordered" style="padding: 0px;">
                           <tbody>
                              <tr>
                                 <td>Upload File (*):
	                                 <span data-toggle="tooltip" data-placement="right" title="Accept Ext: xls, csv, xlsx, xlt, xlsm"> <i class="fa fa-info"></i></span>
                                 </td>
                                 <td>
	                                 <input class="btn btn-neutral btn-round btn-block" type="file" name="file_source" id="file_source" class="edt" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
	                              </td>
                              </tr>
                              <tr>
                                 <td>Header?</td>
                                 <td>
                                    <input type="checkbox" name="use_csv_header" id="use_csv_header" checked="checked">
                                    <small>If checked the first row is not imported</small>
                                 </td>
                              </tr>
                              <tr>
                                 <td>Select DB Table (*):</td>
                                 <td>
                                    <select required="" name="select_table" id="select_table" class="edt form-control">
                                       <option value="">select...</option>
                                       <?php if($data["table"]){
                                          foreach ($data["table"] as $table){
                                              ?>
                                       <option value="<?php echo $table[0];?>"><?php echo $table[0];?></option>
                                       <?php } }?>
                                    </select>
                                 </td>
                              </tr>
                              <tr>
                                 <td>Filter Limit: 
	                                 <span data-toggle="tooltip" data-placement="right" title="Live Preview you can import max 100 row for test"> <i class="fa fa-info"></i></span></td>
                                 <td>
                                    <input type="number" min="1" placeholder="number..." name="filter_limit" id="filter_limit" class="form-control">
                                 </td>
                              </tr>
                              <tr>
                                 <td>Select Mapping:</td>
                                 <td>
                                    <select name="list_mapp" id="list_mapp" class="edt form-control">
                                       <option value="">select...</option>
                                    </select>
                                 </td>
                              </tr>
                              <tr>
                                 <td></td>
                                 <td colspan="3" align="center">
                                    <button type="submit" name="Go" class="btn btn-warning btn-round pull-left btn-fill btn-xl btnUploadCSV">
                                    <i class="fa fa-upload"></i> Upload File</button>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </center>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>