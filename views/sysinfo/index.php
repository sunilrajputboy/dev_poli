
<div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title"><b><?php echo $this->title;?></b></h4>
                                <p class="category"><?php echo $this->subtitle;?></p>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <th>PARAMETER</th>
                                    	<th>RECOMMENDED</th>
                                    	<th>YOUR SYSTEM</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        	<td><b>PHP VERSION</b></td>
                                        	<td>>= v5.2</td>
                                        	<td><?php echo $this->phpversion;?></td>
                                        </tr>
                                        <tr>
                                        	<td><b>MEMORY LIMIT</b></td>
                                        	<td>256M</td>
                                        	<td><?php echo $this->memory_limit;?></td>
                                        </tr>
                                        <tr>
											<td><b>UPLOAD MAX FILESIZE</b></td>
                                        	<td>20M</td>
                                        	<td><?php echo $this->upload_max_filesize;?></td>
                                        </tr>
                                        <tr>
											<td><b>POST MAX SIZE</b></td>
                                        	<td>100M</td>
                                        	<td><?php echo $this->post_max_size;?></td>
                                        </tr>
                                        <tr>
											<td><b>MAX EXECUTION TIME</b></td>
                                        	<td>300</td>
                                        	<td><?php echo $this->max_execution_time;?></td>
                                        </tr>
                                        <tr>
											<td><b>MAX INPUT TIME</b></td>
                                        	<td>60</td>
                                        	<td><?php echo $this->max_input_time;?></td>
                                        </tr>
                                        <tr>
											<td><b>ALLOW URL FOPEN</b></td>
                                        	<td>Yes</td>
                                        	<td><?php echo Functions::returnTxt($this->allow_url_fopen);?></td>
										</tr>
                                        <tr>
											<td><b>SHORT OPEN TAG</b></td>
                                        	<td>Yes</td>
                                        	<td><?php echo Functions::returnTxt($this->short_open_tag);?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <th>PARAMETER</th>
                                    	<th>RECOMMENDED</th>
                                    	<th>YOUR SYSTEM</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        	<td><b>BROWSER</b></td>
                                        	<td>Chroome</b></td>
                                        	<td><?php echo Detect::browser();?></td>
                                        </tr>
                                        <tr>
											<td><b>OS</b></td>
                                        	<td>Linux</td>
                                        	<td><?php echo $this->System;?></td>
                                        </tr>
                                        <tr>
											<td><b>TARGET DEVICE</b></td>
                                        	<td>Mobile/Desktop</td>
                                        	<td><?php echo Detect::systemInfo()["device"];?></td>
                                        </tr>
                                        <tr>
											<td><b>LANGUAGE</b></td>
                                        	<td>En</td>
                                        	<td><?php echo Detect::langEscape();?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

