<div class="page-header-wrap">
    <h3>Import View</h3>
</div>
            <div class="widget">
                <div class="table-area">
				<form id="doImportForm2" method="post" action="<?php echo BASE_URL;?>import/importEditedFile">
				<input type="hidden" name="project_id" class="" value="<?php echo $data["project_id"]; ?>">
				<input type="hidden" name="project_key" class="" value="<?php echo $data["project_key"]; ?>">
				<div class="row">
					<div class="col-md-12">
					    <div id="importtablep" class="table-responsive import-tables">
                     <?php echo $data["Mapp"]->buildTable2($data["project_id"]); ?> 
                    </div>
					</div>
				</div>
				
					<div class="row m-t-20">
					
					            <div class="col-md-6">
					                <span class="span-text"> <b>Filename:</b> <?php echo $data["Mapp"]->getCsvFileName();?></span><br>
					                <span class="span-text"><b>Total Row:</b> <?php echo ($data["countRow"]);?></span>
					            </div>
					            <div class="col-md-6">
					                <input type="hidden" name="tmp_csv" value="<?php echo $data["Mapp"]->getCsvTmpFile();?>">
									<input type="hidden" name="tmp_ext" value="<?php echo $data["ext"];?>">
					                <input id="use_csv_header" type="hidden" name="use_csv_header" value="<?php echo $data["use_csv_header"];?>">
					                <input id="select_table" type="hidden" name="select_table" value="<?php echo $data["select_tables"];?>">
					                <input id="filter_limit" type="hidden" name="filter_limit" value="<?php echo $data["filter_limit"];?>">
					                <input id="file_name" type="hidden" name="file_name" value="<?php echo $data["Mapp"]->getCsvFileName();?>">
					                <button type="button" href="<?php echo BASE_URL;?>import" class="btn btn-danger btn-round btn-fill pull-right importNowButton">
					                <i class="fa fa-upload" aria-hidden="true"></i> Import Data</button>
					                <a href="<?php echo BASE_URL;?>projects/viewprojects/<?php echo $data["project_key"]; ?>" class="btn btn-danger btn-round btn-fill pull-right mr-5">Cancel</a>
					            </div>
						
					            </div>
								
                </div>
				</form>
            </div>
			<!-- Modal -->
<div id="myDatafieldModal" class="modal cus-modal-f fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Data field</h4>
      </div>
      <div class="modal-body">
   <form action="javascript:void(0)" id="setDataFields" class="edit-project" method="post">
		<div class="form-group">
			<label for="">Name</label>
			<input type="text"  class="form-control required DFname" name="name" id="name" placeholder="Name" value="">
			<div class="text-danger"></div>
			<span class="error">Name is required</span>
		</div>
			<div class="form-group">
			<label for="">Display name</label>
			<input type="text" class="form-control required DPname" name="dname" id="dname" placeholder="Display Name" value="">
			<div class="text-danger"></div>
			<span class="error">Display name is required</span>
		</div>
		<div class="form-group">
			<label for="">Description</label>
	<textarea type="text" class="form-control" name="description" id="description" placeholder="Description"></textarea>
		</div>
		<div class="form-group">
			<label for="">Type</label>
			<select class="form-control" id="dataType" onchange="getType(this)" name="type">
			<option value="Text" >Text</option>
			<option value="Number" selected>Number</option>
			<option value="Percentage" >Percentage</option>
			<option value="Decimal" >Decimal</option>
			<option value="Hyperlink" >Hyperlink</option>
			<option value="Pound" >Pound</option> 
			<option value="Euro" >Euro</option>
			<option value="Dollar" >Dollar</option>
			</select>
		</div>
		<div class="form-group comparable-data">
			<div class="toggleWrapper">
				<label for="">Display data on heatmap </label> 
				<input type="checkbox" name="comparable" id="comparable" class="dn" value="true" checked>
				<label for="comparable" class="toggle"><span class="toggle__handler"></span></label>
			</div>
		</div>
			<input type="hidden" value="Percentiles" id="Percentiles" name="grouping" />
		<div class="inner-data">
		<div class="form-group">
		<div class="toggleWrapper">
		<label for="">Show average</label>  
		<input type="checkbox" name="overall_range" id="overall_range" class="dn" value="true">
		<label for="overall_range" class="toggle"><span class="toggle__handler"></span></label>
		</div>
		</div>
		<div class="form-group">
		<div class="toggleWrapper">
		<label for="">Override calculated average</label>  
		<input type="checkbox" name="override_average" id="override_average" class="dn" value="true">
		<label for="override_average" class="toggle"><span class="toggle__handler"></span></label>
		</div>
		<div class="average-override">
		<label for="">Average Override</label>
		<input type="number" class="form-control" name="average_override_number" id="average_override_number" placeholder="" value="">
		</div>
		</div>

		<!--<div class="form-group">-->
		<!--<div class="toggleWrapper">-->
		<!--<label for="">Show chart in the data set summary</label>  -->
		<!--<input type="checkbox" name="chart_data_set_summary" id="chart_data_set_summary" class="dn" value="true">-->
		<!--<label for="chart_data_set_summary" class="toggle"><span class="toggle__handler"></span></label>-->
		<!--</div>-->
		<!--<div class="dataset_summary">-->
		<!--<div class="toggleWrapper">-->
		<!--<label for="">Exclude minimum from data set summary chart</label>  -->
		<!--<input type="checkbox" name="exclude_minimum_data_set_summary" id="exclude_minimum_data_set_summary" class="dn" value="true">-->
		<!--<label for="exclude_minimum_data_set_summary" class="toggle"><span class="toggle__handler"></span></label>-->
		<!--</div>-->

		<!--<div class="toggleWrapper">-->
		<!--<label for="">Exclude maximum from data set summary chart</label>  -->
		<!--<input type="checkbox" name="exclude_maximum_data_set_summary" id="exclude_maximum_data_set_summary" class="dn" value="true">-->
		<!--<label for="exclude_maximum_data_set_summary" class="toggle"><span class="toggle__handler"></span></label>-->
		<!--</div>-->

		<!--<div class="toggleWrapper">-->
		<!--<label for="">Exclude average from data set summary chart</label>  -->
		<!--<input type="checkbox" name="exclude_average_data_set_summary" id="exclude_average_data_set_summary" class="dn" value="true">-->
		<!--<label for="exclude_average_data_set_summary" class="toggle"><span class="toggle__handler"></span></label>-->
		<!--</div>-->
		<!--</div>-->

		<!--</div>-->
		<!--<div class="form-group">-->
		<!--<div class="toggleWrapper">-->
		<!--<label for="">Show total in the data set summary</label>-->
		<!--<input type="checkbox" name="total_data_set_summary" id="total_data_set_summary" class="dn" value="true">-->
		<!--<label for="total_data_set_summary" class="toggle"><span class="toggle__handler"></span></label>-->
		<!--</div>-->
		<!--</div>-->
		</div>
		<div class="form-group multivalued-data hide" >
		<div class="toggleWrapper">
		<label for="">Multivalued</label>  
		<input type="checkbox" name="multivalued" id="multivalued" class="dn" value="true">
		<label for="multivalued" class="toggle"><span class="toggle__handler"></span></label>
		</div>
		<div class="graph-type">
		<label for="">Graph Type</label>
		<select class="form-control" name="graphtype">
		<option disabled selected>Select graph</option> 
		<option value="BarGraph" >Bar graph</option> 
		<option value="LineGraph" >Line graph</option> 
		</select>
		</div>
		</div>
			<div class="form-group node-ranking-data">
		<div class="toggleWrapper">
		<label for="">Display the node rankings</label> 
		<input type="checkbox" name="node_ranking" id="node_ranking" class="dn" value="true">
		<label for="node_ranking" class="toggle"><span class="toggle__handler"></span></label>
		</div>
		</div>
		<div class="form-group invert-node">
		<div class="toggleWrapper">
		<label for="">Invert the node rankings</label>  
		<input type="checkbox" name="invert_node_ranking" id="invert_node_ranking" class="dn" value="true">
		<label for="invert_node_ranking" class="toggle"><span class="toggle__handler"></span></label>
		</div>
		</div>
		<input type="hidden" value="<?php echo $data["project_id"]; ?>" name="id" />
		<input type="hidden" value="" id="datakeyVal" name="datakeyVal" />
		<input type="hidden" value="" id="sequenceVal" name="sequenceVal" />
		<div class="text-center"><button type="button" id="dataFieldSubmitBtn" class="btn cus-btn">Confirm</button></div>
		</div>
	
	</form>
      </div>
      <!--<div class="modal-footer">-->
      <!--  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
      <!--</div>-->
    </div>
  </div>
 <!--************************-->
 <!--************************-->
 <div id="renameDataFieldsModal" class="modal cus-modal-f fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Rename Data field</h4>
      </div>
      <div class="modal-body">
   <form action="javascript:void(0)" id="RenameDataField" class="edit-project" method="post">
   		<div class="form-group">
			<label for="">Data Field</label>
			<select  class="form-control required" id="datafieldid" name="datafieldid">
			<?php if(!empty($allProjectFields)){ foreach($allProjectFields as $flds){ ?>
			 <option value="<?php echo $flds['id_project_field']; ?>" ><?php echo $flds['field_name']; ?></option>
			<?php } } ?>
			</select>
			<span class="error">Data Field is required</span>
		</div>
   
		<div class="form-group">
			<label for="">Name</label>
			<input type="text"  class="form-control required DFname" name="name" id="datafieldName" placeholder="Name" value="">
			<div class="text-danger"></div>
			<span class="error">Name is required</span>
		</div>
		
		<div class="form-group">
			<label for="">Display name</label>
			<input type="text" class="form-control required DPname" name="dname" id="datafieldDisplayName" placeholder="Display Name" value="">
			<div class="text-danger"></div>
			<span class="error">Display name is required</span>
		</div>
	<?php /*****	
		<div class="form-group">
			<label for="">Description</label>
	<textarea type="text" class="form-control" name="description" id="description" placeholder="Description"></textarea>
		</div>
		<div class="form-group">
			<label for="">Type</label>
			<select class="form-control" id="dataType" onchange="getType(this)" name="type">
			<option value="Text" >Text</option>
			<option value="Number" selected>Number</option>
			<option value="Percentage" >Percentage</option>
			<option value="Decimal" >Decimal</option>
			<option value="Hyperlink" >Hyperlink</option>
			<option value="Pound" >Pound</option> 
			<option value="Euro" >Euro</option>
			<option value="Dollar" >Dollar</option>
			</select>
		</div>
		<div class="form-group comparable-data">
			<div class="toggleWrapper">
				<label for="">Comparable</label> 
				<input type="checkbox" name="comparable" id="comparable" class="dn" value="true">
				<label for="comparable" class="toggle"><span class="toggle__handler"></span></label>
			</div>
		</div>
			<input type="hidden" value="Percentiles" id="Percentiles" name="grouping" />
		<div class="inner-data">
		<div class="form-group">
		<div class="toggleWrapper">
		<label for="">Include overall average in node graphs</label>  
		<input type="checkbox" name="overall_range" id="overall_range" class="dn" value="true">
		<label for="overall_range" class="toggle"><span class="toggle__handler"></span></label>
		</div>
		</div>
		<div class="form-group">
		<div class="toggleWrapper">
		<label for="">Override the calculated average</label>  
		<input type="checkbox" name="override_average" id="override_average" class="dn" value="true">
		<label for="override_average" class="toggle"><span class="toggle__handler"></span></label>
		</div>
		<div class="average-override">
		<label for="">Average Override</label>
		<input type="number" class="form-control" name="average_override_number" id="average_override_number" placeholder="" value="">
		</div>
		</div>

		<div class="form-group">
		<div class="toggleWrapper">
		<label for="">Show chart in the data set summary</label>  
		<input type="checkbox" name="chart_data_set_summary" id="chart_data_set_summary" class="dn" value="true">
		<label for="chart_data_set_summary" class="toggle"><span class="toggle__handler"></span></label>
		</div>
		<div class="dataset_summary">
		<div class="toggleWrapper">
		<label for="">Exclude minimum from data set summary chart</label>  
		<input type="checkbox" name="exclude_minimum_data_set_summary" id="exclude_minimum_data_set_summary" class="dn" value="true">
		<label for="exclude_minimum_data_set_summary" class="toggle"><span class="toggle__handler"></span></label>
		</div>

		<div class="toggleWrapper">
		<label for="">Exclude maximum from data set summary chart</label>  
		<input type="checkbox" name="exclude_maximum_data_set_summary" id="exclude_maximum_data_set_summary" class="dn" value="true">
		<label for="exclude_maximum_data_set_summary" class="toggle"><span class="toggle__handler"></span></label>
		</div>

		<div class="toggleWrapper">
		<label for="">Exclude average from data set summary chart</label>  
		<input type="checkbox" name="exclude_average_data_set_summary" id="exclude_average_data_set_summary" class="dn" value="true">
		<label for="exclude_average_data_set_summary" class="toggle"><span class="toggle__handler"></span></label>
		</div>
		</div>

		</div>
		<div class="form-group">
		<div class="toggleWrapper">
		<label for="">Show total in the data set summary</label>
		<input type="checkbox" name="total_data_set_summary" id="total_data_set_summary" class="dn" value="true">
		<label for="total_data_set_summary" class="toggle"><span class="toggle__handler"></span></label>
		</div>
		</div>
		</div>
		<div class="form-group multivalued-data hide" >
		<div class="toggleWrapper">
		<label for="">Multivalued</label>  
		<input type="checkbox" name="multivalued" id="multivalued" class="dn" value="true">
		<label for="multivalued" class="toggle"><span class="toggle__handler"></span></label>
		</div>
		<div class="graph-type">
		<label for="">Graph Type</label>
		<select class="form-control" name="graphtype">
		<option disabled selected>Select graph</option> 
		<option value="BarGraph" >Bar graph</option> 
		<option value="LineGraph" >Line graph</option> 
		</select>
		</div>
		</div>
			<div class="form-group node-ranking-data">
		<div class="toggleWrapper">
		<label for="">Display the node rankings</label> 
		<input type="checkbox" name="node_ranking" id="node_ranking" class="dn" value="true">
		<label for="node_ranking" class="toggle"><span class="toggle__handler"></span></label>
		</div>
		</div>
		<div class="form-group invert-node">
		<div class="toggleWrapper">
		<label for="">Invert the node rankings</label>  
		<input type="checkbox" name="invert_node_ranking" id="invert_node_ranking" class="dn" value="true">
		<label for="invert_node_ranking" class="toggle"><span class="toggle__handler"></span></label>
		</div>
		</div> *****/ ?>
		<input type="hidden" value="<?php echo $data["project_id"]; ?>" name="id" />
		<input type="hidden" value="" id="dataKeyVal2" name="datakeyVal" />
		<div class="text-center"><button type="button" id="RenamedataFieldSubmitBtn" class="btn cus-btn">Confirm</button></div>
		</div>
	
	</form>
      </div>
      <!--<div class="modal-footer">-->
      <!--  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
      <!--</div>-->
    </div>
  </div>
 <!--************************-->
</div>
           
</div>
	 <div class="loader">
		<div>
		     <!-- <img src="<?php //echo BASE_URL;?>/public/img/loader.gif" class="img-responsive"> -->
			 <div class="loader-custom"></div>
		</div>
	</div>
	<style>
		.loader > div {
			width: auto;
			height: auto;
		}
		.loader-custom {
    width : 50px;
    height: 50px;
    border-radius: 50%;
    display: inline-block;
    border-top:5px solid #c1c1c1;
    border-right:5px solid transparent;
    animation: rotation 1s linear infinite;
		}
    .loader-custom:after {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      width : 50px;
      height: 50px;
      border-radius: 50%;
      border-bottom:5px solid #e6133d;
      border-left:5px solid transparent;
    }
	@-webkit-keyframes rotation {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
@keyframes rotation {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
	</style>