<style>
#email_txt-error{
    padding-left: 93px;
    padding-top: 5px;
    color: red;
}
.ui-dialog-title{
    font-weight: bold !important;
}
</style>
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
					<li>Home</li><li>Profile</li>
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
				<h1 class="page-title txt-color-blueDark"><i class="fa fa-table fa-fw "></i> Profile </h1>
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
      <?php
            }
        ?>
        
		<!-- widget grid -->
		<section id="widget-grid" class="">
            
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
							
                            <?php
                            if($logedinuser[0]['type'] == 'superadmin')
                            {
                                ?>
                                <fieldset>
                                
                                    <?php
                                        $firstname = '';
                                        if(isset($logedinuser[0]['firstname']) && !empty($logedinuser[0]['firstname']))
                                            $firstname = $logedinuser[0]['firstname'];
                                    ?>
                                    										
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                        	<label class="input"><strong>First Name:</strong></label>
                                            <label class="input"><?php echo $firstname; ?></label>
    								</div>
                                     
                                   <?php
                                        $lastname = '';
                                        if(isset($logedinuser[0]['lastname']) && !empty($logedinuser[0]['lastname']))
                                            $lastname = $logedinuser[0]['lastname'];
                                    ?>
                                   
                                   <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                        	<label class="input"><strong>Last Name:</strong></label>
                                            <label class="input"><?php echo $lastname; ?></label>
    								</div>
                                   
                                   <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                        	<label class="input"><strong>Account Id:</strong></label>
                                            <label class="input"><?php echo $logedinuser[0]['username']; ?></label>
    								</div>
                                   
                                   <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                        	<label class="input"><strong>User Type:</strong></label>
                                            <label class="input"><?php echo ucfirst($logedinuser[0]['type']); ?></label>
    								</div>
                                   
                                   <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                        	<label class="input"><strong>Status:</strong></label>
                                            <label class="input"><?php echo ucfirst($logedinuser[0]['status']); ?></label>
    								</div>
                                    
                                 </fieldset>  
                                <?php                                
                            }
                            else
                            {
                                ?>
                                
                            <div style="padding-bottom: 20px;">
                                <div id="div_cantfindproperties" style="padding:10px 10px 10px 10px;padding-left: 10px;padding-left: 10px;padding-left: 10px;background-color: #ffffcc;">
                                The following email addresses are linked to your CPx account; allowing you to aggregate published properties into a single page.
                                </div>
                            </div>
                            
                            <div style="padding-bottom: 40px;">
                                <button type="button" id="dialog_open_btn" class="btn btn-primary" style="float: right; margin-bottom: 20px;cursor: pointer;">Link another email</button>
                                
                                <div id="link_email_popup" style="display: none;" title="Link email address">
                                  
                                  <form id="frm_link_email" action="<?=ADMIN_PATH?>Auth/Profile" method="post">
                                  
                                      <div style="padding-bottom: 20px;">
                                        <div style="float: left;padding-right: 10px;">Email address</div>
                                        <div><input type="email" name="email" id="email_txt" style="width: 205px;" required /></div>
                                      </div>
                                      
                                      <div>
                                        <div style="float: left;padding-right: 10px;">
                                            <input type="submit" class="btn btn-primary" id="submit_btn" value="Verify and link to my CPx account" />
                                        </div>
                                        
                                        <div>
                                            <input type="button" class="btn non-selected-btn" id="cancel_btn" value="Cancel" />
                                        </div>
                                      </div>
                                      
                                  </form>
                                  
                                </div>
                            </div>
                            
                            <div class="widget-body">
								
								<div class="custom-scroll table-responsive responsive">
								
									<table class="table table-bordered">
										<thead>
											<tr>
												<th>Email address</th>
                                                <th>Total properites</th>
                                                <th>Action</th>
											</tr>
										</thead>
										<tbody>
                                            
                                            <tr>
                                                <td>
                                                    Default:
                                                    <br />
                                                    <?php echo $logedinuser['0']['username']; ?>
                                                </td>
                                                <td><?php echo $default_email['total_properties']; ?></td>
                                                <td></td>
                                            </tr>
                                            
                                            
                                            <?php 
                                            //echo "<pre>";
                                            //print_r($linkedEmailList);
                                            //echo "</pre>";
                                            
                                            
                                            if(!empty($linkedEmailList))
                                            {
                                                foreach($linkedEmailList as $list)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            Linked:
                                                            <br />
                                                            <?php echo $list['linked_email']; ?>
                                                        </td>
                                                        
                                                        <td>
                                                            <?php
                                                                if(isset($list['total_properties'])) 
                                                                    echo $list['total_properties']; 
                                                            ?>
                                                        </td>
                                                        
                                                        <td style="vertical-align: bottom;width: 150px;text-align: center;">
                                                            <?php 
                                                            if($list['status']=='pending')
                                                            {
                                                                echo "Pending verification";
                                                            } 
                                                            elseif($list['status']=='approved')
                                                            {
                                                                ?>
                                                                    <a href="<?=ADMIN_PATH?>Auth/unlink_email/<?=$list['id']?>">Unlink</a>    
                                                                <?php
                                                            }
                                                            
                                                            if(isset($list['email_link_timestamp']))
                                                            {
                                                                $email_link_timestamp = $list['email_link_timestamp'];
                        
                                                                $cDate = strtotime(date('Y-m-d H:i:s'));
                                                                
                                                                // Getting the value of old date + 24 hours
                                                                $emailLinkDateAfterOneDay = $email_link_timestamp + 86400; // 86400 seconds in 24 hrs

                                                                if(($list['status'] == 'pending') && ($emailLinkDateAfterOneDay < $cDate)) 
                                                                {
                                                                ?>
                                                                    <br /><br />
                                                                  <a href="<?=ADMIN_PATH?>auth/resend_email_link_verification/<?=$list['id']?>" class="btn btn-primary container-full">Resend Verification </a><br />                                                                                                 
                                                                  <?php
                                                                  }
                                                            }
                                                            ?>
                                                            
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
										</tbody>
									</table>
                                    
								</div>
							</div>       
                            <?php
                            }
                            ?>
						</div>
                        
						<!-- widget div-->
						
						<!-- end widget div -->

					</div>
					<!-- end widget -->

				</article>
				<!-- WIDGET END -->

			</div>         
            
			<!-- end row -->
			
		</section>
		<!-- end widget grid -->

	</div>
			<!-- END MAIN CONTENT -->

</div>

<script language="javascript" type="text/javascript">
$(function () {

  $('#link_email_popup').dialog({
    autoOpen: false,
    height: 200,
    width: 350,
    resizable: false,
  });
  
  
  $('#submit_btn').on('click', function() {
    if ($('#frm_link_email').valid()) {
          
          $("#frm_link_email").submit();
          
          $('#link_email_popup').dialog('close');
        }
  });
  
  $('#cancel_btn').on('click', function() {
    $('#link_email_popup').dialog('close');
  });
  
  $('#dialog_open_btn').on('click', function() {
    $('#link_email_popup').dialog('open');
  });
  
  
  $('#frm_link_email').validate({
    rules: {
      field: {
        required: true,
        email: true,
      }
    },


  });
});
</script>