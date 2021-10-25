<style>
.disable {
  opacity: 0.4;
  pointer-events: none;
  cursor: default;
}

.disable div,
.disable textarea {
  overflow: hidden;
}
</style>
<script language="javascript" type="text/javascript">
function form_validation()
{
    if($("#sponsor_name").val()=="")
    {
         $('#name_error').show();return false; 
    }else if($("#term").val()=="")
    {
        $('#term_error').show();return false;
    }else if($("#intrest_rate").val()=="")
    {
        $('#intrest_rate_error').show();return false;
    }else if($("#url").val()=="")
    {
        $('#url_error').show();return false;
    }
    
    
   // alert("form submited");
    
    $('#edit_form').submit();
}

function redirectpage()
{
    window.location.href='<?=ADMIN_PATH?>sponsors/';
}

function show_preview()
{
    url_val = $('#url').val();
    if (!/^https?:\/\//i.test(url_val)) {
        url_val = 'http://' + url_val;
    }
    var preview_tag = '<a href="'+url_val+'" target="_blank">'+url_val+'</a>';    
    $('#url_preview').html('Preview: '+preview_tag); 
}
function show_logo_preview()
{
    logo_path = $('#AgreementDoc_path').val();

    $('.logo_preview_div').removeClass('disable');
    $('#logo_preview').attr("src",'<?=IMAGE_UPLOAD_PATH?>'+logo_path);
    
    var img = '<?=IMAGE_UPLOAD_PATH?>'+logo_path;
    $("img").load(function() {
        logo_actual_width = $(this).width();
        logo_actual_height = $(this).height();
        
       
    });     
}
</script>

<div id="main" role="main">

		      <!-- RIBBON -->
			<div id="ribbon">

				<span class="ribbon-button-alignment"> 
					<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
						<i class="fa fa-refresh"></i>
					</span> 
				</span>

				<!-- breadcrumb -->
				<ol class="breadcrumb">
					<li>Home</li><li>Add new sponsors</li>
				</ol>
				<!-- end breadcrumb -->

				<!-- You can also add more buttons to the
				ribbon for further usability

				Example below:

				<span class="ribbon-button-alignment pull-right">
				<span id="search" class="btn btn-ribbon hidden-xs" data-title="search"><i class="fa-grid"></i> Change Grid</span>
				<span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa-plus"></i> Add</span>
				<span id="search" class="btn btn-ribbon" data-title="search"><i class="fa-search"></i> <span class="hidden-mobile">Search</span></span>
				</span> -->

			</div>
			<!-- END RIBBON -->
            
			<!-- MAIN CONTENT -->
        <div id="content">

		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark"><i class="fa fa-table fa-fw "></i> Add new sponsors</h1>
			</div>
			
		</div>
        
        
        <?php
            if(isset($success_msg) && !empty($success_msg))
            {
        ?>
            <div class="alert alert-success fade in">
    			<button class="close" data-dismiss="alert">
    				×
    			</button>
    			<i class="fa-fw fa fa-check"></i>
    			<?php echo $success_msg; ?>
    		</div>
            
            <script language="javascript" type="text/javascript">
                setTimeout("redirectpage()",1000);
            </script>        
      <?php
            }
        ?>
        
        <?php
            if(isset($error_msg) && !empty($error_msg))
            {
        ?>
            <div class="alert alert-danger fade in">
    			<button class="close" data-dismiss="alert">
    				×
    			</button>
    			<i class="fa-fw fa fa-times"></i>
    			<?php echo $error_msg; ?>
    		</div>
            
            <script language="javascript" type="text/javascript">
                setTimeout("redirectpage()",1000);
            </script>        
      <?php
            }
        ?>
        
		<!-- widget grid -->
		<section id="widget-grid" class="">
            <form id="edit_form" class="customeUploadForm" method="post" action="<?=ADMIN_PATH?>sponsors/edit/<?=$sponsors['id']?>">
			<!-- row -->
			<div class="row">

				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

				

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-deletebutton="false" data-widget-colorbutton="false">
						<!-- widget options:
						usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

						data-widget-colorbutton="false"
						data-widget-editbutton="false"
						data-widget-togglebutton="false"
						data-widget-deletebutton="false"
						data-widget-fullscreenbutton="false"
						data-widget-custombutton="false"
						data-widget-collapsed="true"
						data-widget-sortable="false"

						-->
						<header>
                            
						</header>
                        <div style="padding-bottom: 10px;">
							
                            <fieldset>
                                
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 smart-form "  >
                                    <span id="name_error" style="color: red; font-size: 11px;display: none;">Please enter Sponsor name</span>
                                    <section class="col col-3">     
                                        <label class="input">Sponsor name</label>
                                    </section>
                                    
                                    
                                    
                                    <section class="col col-9">
                                    
                                        <span>
                                            <input  class="form-control" type="text" name="sponsor_name" id="sponsor_name" placeholder="Enter Sponsor name" value="<?=$sponsors['sponsor_name']?>" />
                                        </span>
                                        
                                    </section>
                                    
                                    
								</div>
                                
                                
                                
                                
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 smart-form" >
                                    <span id="radio_error" style="color: red; font-size: 11px;display: none;">Please select logo or text option</span>
                                     <section class="col col-3"  >
                                        
                                        <label class="input ">Sponsor 's favicon</label>
                                     </section>
                                    
                                    
                                    
                                    <section class="col col-9">
                                        
                                        <div class="custom_upload_file_widget logo_div"  >
                            				<!-- Redirect browsers with JavaScript disabled to the origin page -->
                            				<!-- Below are all hidden variables required tobe passed -->
                            				                        
                            				<input type="hidden" id="auto_upload" value="yes"/> 
                            				<input type="hidden" id="isMultiple" value="no"/> 
                            				<input type="hidden" name="sub_folder_path"
                            					value="<?=IMAGE_UPLOAD_FOLDER?>/sponsors/logos"
                            					class="sub_folder_path"/> 
                            				<input type="hidden" name="document_type"
                            					value=""
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
                            					<div class="col-sm-12 text-center txt mar-t15" id="drop-heading" style="padding-top: 10px;">Drop files here</div>
                            					<div class="fileupload-buttonbar col-sm-12 row" style="padding-left: 28px;">
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
                            						<div class="col-sm-6 col-md-5 fileupload-progress fade">
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
                            						
                            					<div class="col-sm-16" style="padding-left: 15px;padding-right: 14px;">
                            						<div class="input-group">
                            							<div class="input text">
                            								<input type="text" class="form-control" placeholder="OR Enter URL of file to upload" name="remote_url" value=""  onchange="changeUpdateDoneValue();">
                            							</div>
                            							<span class="input-group-btn group-span"><button
                            									class="btn btn-default urlUpload url-upload-button" type="button">Upload</button></span>
                            						</div>
                            					</div>
                                                
                            					<div class="mar-t15" style=" padding-top: 10px;padding-left: 15px;">
                            						<table role="presentation" class="table table-striped">
                            							<tbody class="files">
                            											<?php
                            	if(isset($sponsors['logo'])){
                            
                            	$Logodetails = $sponsors['logo'];  
                            		
                            		foreach ( $Logodetails as $logokey => $detail_logo ) {
                            			
                            			?>
                            							<tr class="template-download fade in">
                            								<td style="padding-left: 0px;">
                            									<p class="up-name">
                            										<?php
                            				
                            					echo $this->Html->link ( '' . $detail_logo['name'], '/'.$detail_logo['path'], array (
                            							"class" => "",
                            							'escape' => false,
                            							'title' => 'Click to view/download',
                            							'target' => '_blank' 
                            					) );
                            				
                            				?>
                                            
                                            <input type="hidden" id="AgreementDoc_name" name="AgreementDoc_name[]" value=" <?php echo $detail_logo['name'];?>"/>
                            				<input type="hidden" id="AgreementDoc_path" name="AgreementDoc_path[]" value="<?php echo $detail_logo['path'];?>"/>
                                            <input type="hidden" name="AgreementDoc_size[]" value="<?php echo $detail_logo['size'];?>"/>
                                            <input type="hidden" name="AgreementDoc_type[]" value="<?php echo $detail_logo['type'];?>"/>
                                            <input type="hidden" name="AgreementDoc_isurl[]" value="<?php echo (isset($detail_logo['isurl'])? $detail_logo['isurl']:'0');?>"/>
                            				
                            				
                            				
                            				
                            				
                                            
                            									</p>
                            								</td>
                            								<td>
                                                            <?php
                                                            if(!isset( $detail_logo['isurl']) || !$detail_logo['isurl'] )
                                                            {
                                                            ?>
                                                            <span class="size"><?php echo round($detail_logo["size"]/1000,2); ?>&nbsp;KB</span>
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
                                                
                                                
                            					<div class="col-sm-12 nopadding" style="padding-left: 28px;padding-bottom: 20px;">
                            					<ul class="upload-note-ul">
                            						<li>The maximum file size for uploads is 5 MB</li>
                            						<li>Only files (JPG, GIF, PNG, ICO) are allowed</li>
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
                                                
                                                {% if(document.getElementById('logo_preview').src = '<?php echo IMAGE_UPLOAD_PATH ?>'+file.url){ } %}
                                                                                                                                                                                                
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
                                        
                                        <span id="logo_error" style="color: red; font-size: 11px;display: none;">Please select logo</span>
                                    </section>
                                    
                                    
                                    
								</div>
                               
                               <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 smart-form "  >
                                    <section class="col col-2">     
                                        
                                    </section>
                                    
                                    <section class="col col-1">
                                       
                                    </section>
                                    
                                    <section class="col col-9 " >
                                        <strong>Preview image</strong>
                                    </section>
                                    
								</div>
                                
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 smart-form "  >
                                    <section class="col col-2">     
                                        
                                    </section>
                                    
                                    <section class="col col-1">
                                       
                                    </section>
                                    
                                    <section class="col col-9 " >
                                        <img src="" id="logo_preview" />
                                                                                
                                    </section>
                                    
                                    
								</div>
                               
                              
                               
                               <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 smart-form "  >
                                   <section class="col-6 col-sm-6 col-md-6" > 
                                    <section class="col col-6">     
                                        <label class="input">Loan type</label>
                                    </section>
                                    
                                    
                                    
                                    <section class="col col-6">
                                    
                                        <span>
                                            <select disabled="disabled" class="form-control " name="loan_type" id="loan_type" placeholder="Select loan type">
                                            <option <?=($sponsors['loan_type']=="IO")?"selected":""?> value="IO">IO</option>
                                            <option <?=($sponsors['loan_type']=="PI")?"selected":""?> value="PI" >PI</option>
                                            
                                            </select>
                                            <input type="hidden" name="loan_type" value="<?=$sponsors['loan_type']?>" />
                                            
                                        </span>
                                        
                                    </section>
                                   </section>  
                                    
								</div>
                                
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 smart-form "  >
                                    <section class="col-6 col-sm-6 col-md-6" >
                                        <span id="term_error" style="color: red; font-size: 11px;display: none;">Please enter Loan term</span>
                                        <section class="col col-6">     
                                            <label class="input">Loan term</label>
                                        </section>
                                        
                                        
                                        
                                        <section class="col col-6" >
                                        
                                            <span>
                                                <input class="form-control" type="text" name="term" id="term" placeholder="Enter Loan term" value="<?=$sponsors['term'];?>" />
                                            </span>
                                            
                                        </section>
                                    
                                    
                                    </section>
                                    <section class="col-6 col-sm-6 col-md-6" >
                                    <span id="intrest_rate_error" style="color: red; font-size: 11px;display: none;">Please enter Interest rate</span>
                                        <section class="col col-6">                                
                                            <label class="input text-center">Interest rate</label>
                                        </section>
                                        
                                        
                                        
                                        <section class="col col-6">
                                            
                                            
                                            <span>
                                                <input class="form-control " type="text" name="intrest_rate" id="intrest_rate" placeholder="Enter Interest rate" value="<?=$sponsors['intrest_rate'];?>" />
        									</span>
                                            
                                            
        								</section>
                                    </section>
                                    
								</div>
                                
                               
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 smart-form" >
                                    <span id="url_error" style="color: red; font-size: 11px;display: none;">Please enter Advertising link</span>
                                    <section class="col col-3">     
                                        <label class="input">Advertising link</label>
                                    </section>
                                    
                                    
                                    
                                    <section class="col col-9">
                                    
                                        <span>
                                            <input  class="form-control" onfocus="$('#url_error').hide();" onkeydown="$('#url_error').hide();" onblur="show_preview();" type="text" name="url" id="url" placeholder="Enter Advertising link" value="<?=$sponsors['url'];?>"/>
                                        </span>
                                        
                                        <span id="url_error" style="color: red; font-size: 11px;display: none;">Please enter url</span>
                                        <span id="url_preview" style="font-size: 12px;"></span>
                                    </section>
                                    
                                    
								</div>
                                
                             </fieldset>           
                            
						</div>
                        
						<!-- widget div-->
						
						<!-- end widget div -->

					</div>
					<!-- end widget -->

				</article>
				<!-- WIDGET END -->

				

				

			</div>
            
            
            
            <input style="float: right;" class="btn btn-primary " onclick="form_validation();" type="button" value="Save" />
            <input style="float: right;margin-right: 5px;" class="btn btn-default" type="button" onclick="redirectpage();" value="Cancel" />
                
            </form>
			<!-- end row -->

			
		</section>
		<!-- end widget grid -->

	</div>
			<!-- END MAIN CONTENT -->

</div>
<script language="javascript">
$(document).ready(function () {
    show_preview();
    show_logo_preview();
});    
</script>