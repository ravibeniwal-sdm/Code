<div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-deletebutton="false" data-widget-colorbutton="false">
						
	<header style="height:45px !important;">
        <h2 style="width: auto;"><strong>Contract</strong> <i> of sale</i> </h2>
                                      
          
          <div class="pull-right custom-toolbar col-md-2 "> 
			
            <div style="margin-top: 0px;height: 17px;"><?php echo $contract_of_sale_weightage; ?>%</div>
            
            <div class="progress" rel="tooltip" data-original-title="<?php echo $contract_of_sale_weightage; ?>%" data-placement="bottom">
				<div class="progress-bar progress-bar-success" role="progressbar" style="width: <?php echo !($contract_of_sale_value) ? 10 : 100 ?>%"></div>
			</div>
            
	      </div>
          
	</header>
    
    
	<!-- widget div-->
	<div>

		<!-- widget content -->
		<div class="widget-body no-padding" style="padding-top: 120px;">
            <div style="margin-left: 10px;margin-right: 10px;margin-top: 10px;margin-bottom: 10px;border: 1px solid black;background-color: #ffffcc;">
            
                CPx governance: a copy of the complete contract-of-sale or contract-of-sale summary is included in the available property information.
            </div>
            
           
            
            <div class="input-wrap col-xs-12 col-sm-12 nopadding">
    			<div class="custom_upload_file_widget">
    				<!-- Redirect browsers with JavaScript disabled to the origin page -->
    				<!-- Below are all hidden variables required tobe passed -->
    				 <div class="radiaobutton" >
    						 Contract-of-sale 
                                
                                <input type="radio" <?php if(isset($propertyInfo['contract_of_sale']) && $propertyInfo['contract_of_sale']=='Copy') echo 'checked'; else echo '' ; ?> name="contract_of_sale" value="Copy" style="vertical-align: top;" onchange="changeUpdateDoneValue();"/> Copy
                                
                                <input type="radio" <?php if(isset($propertyInfo['contract_of_sale']) && $propertyInfo['contract_of_sale']=='Summary') echo 'checked'; else echo '' ; ?> name="contract_of_sale" value="Summary" style="vertical-align: top;" onchange="changeUpdateDoneValue();"/> Summary 
                                
                               
                                
                                
                    </div>
                                                                        
    				<input type="hidden" id="auto_upload" value="yes"/> 
    				<input type="hidden" id="isMultiple" value="no"/> 
    				<input type="hidden" name="sub_folder_path"
    					value="<?php echo IMAGE_UPLOAD_FOLDER.'/'.$propertyInfo['id']; ?>"
    					class="sub_folder_path"/> 
    				<input type="hidden" name="document_type"
    					value="AGREEMENT"
    					id="document_type"/>
    				
    				<input type="hidden" name="script_url"
    					value="<?=ADMIN_PATH?>UploadFiles/"
    					id="script_url"/> 
    				<input type="hidden"
    					name="upload_from_url_script_url"
    					value="<?=ADMIN_PATH?>UploadFiles/remote_file_upload"
    					id="upload_from_url_script_url">
    			<!--	<input type="hidden" name="template-download-field"	value="template-download-1"/>
    				<input type="hidden" name="template-upload-field"	value="template-upload-1"/>-->
    				<noscript>
    					<input type="hidden" name="redirect" value="/">
    				</noscript>
    
    			
    				
    				<!-- The table listing the files available for upload/download -->
    				<div id="dropzone" class="dropzone well col-sm-12 nopadding" style="margin-top: 10px;margin-bottom: 10px;">
    					<div class="col-sm-12 text-center txt mar-t15" id="drop-heading">Drop files here</div>
    					<div class="fileupload-buttonbar col-sm-12 row" style="padding-left: 0px;">
    						<div class="col-sm-6 col-md-5">
    							<!-- The fileinput-button span is used to style the file input field as button -->
    							<span class="btn btn-default fileinput-button"> <i
    								class="glyphicon glyphicon-plus"></i> <span>Add files...</span>
    								<input type="file" name="files"  onchange="changeUpdateDoneValue();" multiple>
    							</span>
    
    							<!-- The global file processing state -->
    							<span class="fileupload-process"></span>
    						</div>
    						<!-- The global progress state -->
    						<div class="col-sm-6 col-md-7 fileupload-progress fade">
    							<!-- The global progress bar -->
    							<div class="progress progress-striped active" role="progressbar"
    								aria-valuemin="0" aria-valuemax="100">
    								<div class="progress-bar progress-bar-success"
    									style="width: 0%;"></div>
    							</div>
    							<!-- The extended global progress state -->
    							<div class="progress-extended">&nbsp;</div>
    						</div>
    					</div>
    						
    					<div class="col-sm-16">
    						<div class="input-group">
    							<div class="input text">
    								<input type="text" class="form-control" placeholder="OR Enter URL of file to upload" name="remote_url" value=""  onchange="changeUpdateDoneValue();">
    							</div>
    							<span class="input-group-btn group-span"><button
    									class="btn btn-default urlUpload url-upload-button" type="button">Upload</button></span>
    						</div>
    					</div>
                        
                        <div class="col-sm-16" style="padding-top: 10px;">
    						<div class="input-group">
    							<div class="input text">
    								<input type="text" class="form-control" placeholder="e.g. http://www.centralpropertyexchange.com.au/#!/about/what-is-cpx" name="remote_link" value=""  onchange="changeUpdateDoneValue();">
    							</div>
    							<span class="input-group-btn group-span"><button
    									class="btn btn-default urlLink" type="button">Add link</button></span>
    						</div>
    					</div>
                        
                        
    					<div class="mar-t15" style=" padding-top: 10px;">
    						<table role="presentation" class="table table-striped">
    							<tbody class="files">
    											<?php
    	if(isset($propertyInfo['contract'])){
    
    	$Docdetails = $propertyInfo['contract'];  
    		
    		foreach ( $Docdetails as $dockey => $detaildoc ) {
                
                $doc_url = $detaildoc['path'];
                if (!preg_match("~^(?:f|ht)tps?://~i", $detaildoc['path'])) {
                    $doc_url = IMAGE_UPLOAD_PATH.$detaildoc['path'];
                }
    			?>
    							<tr class="template-download fade in">
    								<td style="padding-left: 0px;">
    									<p class="up-name">
    										<?php
    				
    					echo $this->Html->link ( '' . $detaildoc['name'], $doc_url, array (
    							"class" => "",
    							'escape' => false,
    							'title' => 'Click to view/download',
    							'target' => '_blank' 
    					) );
    				
    				?>
                    
                    <input type="hidden" id="AgreementDoc_name" name="AgreementDoc_name[]" value=" <?php echo $detaildoc['name'];?>"/>
    				<input type="hidden" id="AgreementDoc_path" name="AgreementDoc_path[]" value="<?php echo $detaildoc['path'];?>"/>
                    <input type="hidden" name="AgreementDoc_size[]" value="<?php echo $detaildoc['size'];?>"/>
                    <input type="hidden" name="AgreementDoc_type[]" value="<?php echo $detaildoc['type'];?>"/>
                    <input type="hidden" name="AgreementDoc_isurl[]" value="<?php echo (isset($detaildoc['isurl'])? $detaildoc['isurl']:'0');?>"/>
    				
    				
    				
    				
    				
                    
    									</p>
    								</td>
    								<td>
                                    <?php
                                    if(!isset( $detaildoc['isurl']) || !$detaildoc['isurl'] )
                                    {
                                    ?>
                                    <span class="size"><?php echo round($detaildoc["size"]/1000,2); ?>&nbsp;KB</span>
                                    <?php
                                    }
                                    ?>
    								</td>
    								<td><a href="#" onclick="removeFile();" class="table-icon nomargin" title="Delete"> <i
    										class="glyphicon glyphicon-trash delete"></i>
    								</a></td>
    							</tr>
    							<?php
    		
    		}
    	}
    	?>
    							</tbody>
    						</table>
    					</div>
                        
                        
    					<div class="col-sm-12 nopadding">
    					<ul class="upload-note-ul">
    						<li>The maximum file size for uploads is 5 MB</li>
    						<li>Only files (JPG, GIF, PNG, PDF, DOC, XLS) are allowed</li>
    					</ul>
    					</div>													
    				</div>
    				<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
    				
    				<script id="template-upload" type="text/x-tmpl">
    				{% for (var i=0, file; file=o.files[i]; i++) { %}
    				<tr class="template-upload fade" {% if (file.url_upload_sql_no) { %} id="url_{%=file.url_upload_sql_no%}" {% } %}>
    					<td>
    					<p class="up-name">{%=file.name%}</p>
    					<strong class="error text-danger"></strong>
    					</td>
    					<td>
    					<p class="size">Processing...</p>
    					<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
    					</td>
    					<td>
    					{% if (!i && !o.options.autoUpload) { %}
    					<button class="btn btn-primary start" disabled>
    					<i class="glyphicon glyphicon-upload"></i>
    					<span>Start</span>
    					</button>
    					{% } %}
    					{% if (!i) { %}
    					<a href="#" class="table-icon nomargin" title="Cancel">
    					<i class="glyphicon glyphicon-ban-circle cancel {% if (file.url_upload_sql_no) { %} cancel-url-upload {% } %}"></i>
    					</a>
    					{% } %}
    					</td>
    				</tr>
    				{% } %}
    			</script>
    			<!-- The template to display files available for download -->
    			<script id="template-download" type="text/x-tmpl">
    
    
    				{% for (var i=0, file; file=o.files[i]; i++) { %}
    				<tr class="template-download fade" {% if (file.url_upload_sql_no) { %} id="url_{%=file.url_upload_sql_no%}" {% } %}>
    					<td>
    					{% if (!file.error) { %}
    					<input type="hidden" id="AgreementDoc_name" name="AgreementDoc_name[]" value="{%=file.name%}"/>
    					<input type="hidden" id="AgreementDoc_path" name="AgreementDoc_path[]" value="{%=file.path%}"/>
                        <input type="hidden" name="AgreementDoc_size[]" value="{%=file.size%}"/>
                        <input type="hidden" name="AgreementDoc_type[]" value="{%=file.type%}"/>
    						{% if (file.isurl) { %}
    						<input type="hidden" name="AgreementDoc_isurl[]" value="1"/>
    						{% }else{ %}
    						<input type="hidden" name="AgreementDoc_isurl[]" value="0"/>
    						{% } %}
    					{% } %}
    					<p class="up-name">
    					{% if (file.url) { %}
    						{% if (file.isurl) { %}
    							<a href="{%=file.url%}" title="{%=file.url%}" target="_new">{%=file.name%}</a>
    						{% }else{ %}
    							<a href="<?php echo IMAGE_UPLOAD_PATH ?>{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
    						{% } %}
    					{% } else { %}
    					<span>{%=file.name%}</span>
    					{% } %}
    					</p>
    					{% if (file.error) { %}
    					<div><span class="label label-danger">Error</span> {%=file.error%}</div>
    					{% } %}
    					</td>
    					<td>
    					<span class="size">{%=o.formatFileSize(file.size)%}</span>
    					</td>
    					<td>
    					{% if (file.deleteUrl) { %}
    					<a href="#" onclick="removeFile();" class="table-icon nomargin" title="Delete">
    					<i class="glyphicon glyphicon-trash delete"></i>
    					</a>
    
    					{% } else { %}
    					<a href="#" class="table-icon nomargin" title="Cancel">
    					<i class="glyphicon glyphicon-ban-circle cancel"></i>
    					</a>
    					{% } %}
    					</td>
    				</tr>
    				{% } %}
    			</script>
    			</div>
    		</div>
            
            
               <div style="padding-left: 13px;padding-bottom: 20px;">
                    <strong>Property is off-the-plan</strong><input type="checkbox" name="property_off_the_plan" style="vertical-align: top;margin-left:10px;" <?php if(isset($propertyInfo['property_off_the_plan']) && $propertyInfo['property_off_the_plan']) echo 'checked'; else echo '' ; ?> onclick="$('#completion_date_div').toggle();" onchange="changeUpdateDoneValue();"/>
				</div>
                
                <?php
                $style = "display: none;";
                if(isset($propertyInfo['property_off_the_plan']) && $propertyInfo['property_off_the_plan'])
                    $style = "display: block;";
                ?>
                
                <div style="padding-left: 13px;padding-bottom: 20px; <?php echo $style; ?> " id="completion_date_div">
                    Estimate completion date: <input type="text" readonly="true" name="estimated_completion_date" id="estimated_completion_date" style="margin-left: 15px;" value="<?php echo !empty($propertyInfo['estimated_completion_date']) ? $propertyInfo['estimated_completion_date'] : '' ?>" /><img id="estimated_completion_date_cal" onclick="$('#estimated_completion_date').datepicker('show');" style="padding-left: 5px;vertical-align: sub;" src="<?php echo IMG_PATH; ?>/cal.gif" />
				</div>   
                
                                         
            
		</div>
		<!-- end widget content -->

	</div>
	<!-- end widget div -->

</div>