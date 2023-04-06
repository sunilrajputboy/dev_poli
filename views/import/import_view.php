<div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title"><b>Import View--</b></h4>
                            </div>
                            <div class="content">
                                <form id="doImportForm" method="post" action="<?php echo BASE_URL;?>import/doImport">
					            <div class="row">
					            <div class="col-md-6">
					                <a href="<?php echo BASE_URL;?>import" class="btn btn-round btn-warning btn-fill"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a>
					            </div>
					            <div class="col-md-6">
					                <button type="button" class="btn btn-success btn-round btn-fill pull-right saveMapp"><i class="fa fa-save"></i> Save Mapping</button>
					            </div>
					            </div>
					            <hr>
					            <div class="row">
					            <div class="col-md-12">
					                    <div class="table-full-width" style="overflow: auto; padding: 10px;">
					                        <?php echo $data["Mapp"]->buildTable();?>
					                    </div>
					            </div>
					            </div>
					            <hr>
					            <div class="row">
					            <div class="col-md-6">
					                <span class="span-text"><b>Filename:</b> <?php echo $data["Mapp"]->getCsvFileName();?></span><br>
					                <span class="span-text"><b>Total Row:</b> <?php echo ($data["countRow"]);?></span>
					            </div>
					            <div class="col-md-6">
					                <input type="hidden" name="tmp_csv" value="<?php echo $data["Mapp"]->getCsvTmpFile();?>">
									<input type="hidden" name="tmp_ext" value="<?php echo $data["ext"];?>">
					                <input id="use_csv_header" type="hidden" name="use_csv_header" value="<?php echo $data["use_csv_header"];?>">
					                <input id="select_table" type="hidden" name="select_table" value="<?php echo $data["select_tables"];?>">
					                <input id="filter_limit" type="hidden" name="filter_limit" value="<?php echo $data["filter_limit"];?>">
					                <input id="file_name" type="hidden" name="file_name" value="<?php echo $data["Mapp"]->getCsvFileName();?>">
					                <button type="button" href="<?php echo BASE_URL;?>import" class="btn btn-danger btn-round btn-fill pull-right beforeUploadToServer">
					                <i class="fa fa-upload" aria-hidden="true"></i> Import Data</button>
					            </div>
					            </div>
					        	</form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



