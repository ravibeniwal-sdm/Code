<script language="javascript" type="text/javascript">
jQuery(document).ready(function($) {
    $("#linked_email").on('change', function() {
        
        $('#social_media_img').attr('src', '');
        $('#social_media_img_div').hide();
                
        var sel_linked_email = $(this).val();
        if(sel_linked_email){
            $.ajax ({
                type: 'POST',
                url: '<?php echo ADMIN_PATH ?>/Auth/fetch_sel_user_details',
                data: { linked_email:sel_linked_email },
                success : function(htmlresponse) {
                    $('#user_details_div').html(htmlresponse);
                }
            });
        }
    });
});
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
					<li>Home</li><li>My Accounts</li>
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
				<h1 class="page-title txt-color-blueDark"><i class="fa fa-table fa-fw "></i> My Accounts </h1>
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
							
                            <fieldset>
                            <form method="post">
                            
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" >
                                
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" >
                                        	<label class="input">Email address</label>
    								</div>
                                    
                                    <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7" style="padding-bottom: 10px;" >
    									  
              	                         <label class="input">
                                            <select name="linked_email" class="form-control" id="linked_email">
                                                <?php
                                                    foreach($linkedEmailsList as $list)
                                                    {
                                                        $selected_str = '';
                                                        if($list == $request_email)
                                                            $selected_str = 'SELECTED';
                                                        ?>
                                                            <option <?php echo $selected_str;?> value="<?php echo $list ?>"><?php echo $list ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
    									   </label>
                                           
                                            <span id="social_media_img_div" style="display: none;">
                                            <img src="" id="social_media_img"/>
                                            </span>
                                           
    								</div>
                                
                                </div>
                                
                                <div id="user_details_div">
                                    <?php
                                    echo $this->element("/myaccounts_user_details",array('output'=>$fetchUserDetails));
                                    ?>
                                
                                </div>
                                
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" >
                                
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" >
                                        	
                                	</div>
                                    
                                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5" style="padding-bottom: 10px;" >
                                        <label class="input">
                                          
                                          <input type="button" class="btn non-selected-btn" value="Cancel" onclick="window.location.href='<?=ADMIN_PATH?>property/';" />
                                          <input type="submit" class="btn btn-primary" value="Save" />
                                          
                                          </label>
                                	</div>
                                
                                </div>
                                            
                                
                                </form>
                             </fieldset>           
                            
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

<?php
if(isset($logedinuser[0]['social_media_logo']) && !empty($logedinuser[0]['social_media_logo']))
{
?>

<script language="javascript" type="text/javascript">
    $('#social_media_img_div').show();
    $('#social_media_img').attr('src', '<?php echo IMG_PATH.'/'.$logedinuser[0]['social_media_logo'];?>');

</script>

<?php
}
?>        