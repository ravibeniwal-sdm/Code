<script language="javascript" type="text/javascript">
function form_validation()
{
    new_password = $('#new_password').val();
    confirm_password = $('#confirm_password').val();
    
    
    if(new_password == '')
    {
        $('#new_password_error').show();
                
        return false;        
    }    
    else if(confirm_password == '')
    {
        $('#confirm_password_error').show();
                
        return false;        
    }  
    else if((confirm_password != '') && (new_password != confirm_password))
    {
        
        $('#confirm_password_doesnotmatch_error').show();
                
        return false;        
    }
    
    $('#change_password_form').submit();
}



function redirectpage()
{
    window.location.href='<?=ADMIN_PATH?>property/';
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
					<li>Home</li><li>Change Password</li>
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
				<h1 class="page-title txt-color-blueDark"><i class="fa fa-table fa-fw "></i> Change Password</h1>
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
            <form id="change_password_form" class="" method="post" action="<?=ADMIN_PATH?>auth/change_password">
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
                                
                                <?php 
                                if($logedinuser['0']['type'] != 'superadmin')
                                {
                                ?>
                                
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                    	<label class="input">Email address</label>
								</div>
                                
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom: 10px;" >
									  
          	                         <label class="input">
                                        <select name="linked_email" class="form-control">
                                            <?php
                                                foreach($linkedEmailsList as $list)
                                                {
                                                    ?>
                                                        <option value="<?php echo $list ?>"><?php echo $list ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
									   </label>
                                    
								</div>
                                
                                <?php
                                }
                                ?>
                                										
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                    	<label class="input">New Password</label>
								</div>
                                
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom: 10px;" >
									  
                                    	<label class="input"><input class="form-control"  onfocus="$('#new_password_error').hide();" onkeydown="$('#new_password_error').hide();" type="password" name="new_password" id="new_password" style="width: 218px;" />
									</label>
                                    <span id="new_password_error" style="color: red; font-size: 14px;display: none;">Please enter new password</span>
								</div>
                               
                               <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                    	<label class="input">Confirm Password</label>
								</div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom: 10px;" >
                                    
                                    	<label class="input"><input class="form-control" onfocus="$('#confirm_password_error').hide();" onkeydown="$('#confirm_password_error').hide();" type="password" name="confirm_password" id="confirm_password"  style="width: 218px;"/>
									</label>
                                    <span id="confirm_password_error" style="color: red; font-size: 14px;display: none;">Please enter confirm password</span>
                                    <span id="confirm_password_doesnotmatch_error" style="color: red; font-size: 14px;display: none;">New password and Confirm password doesn't match</span>
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
            
            
            
            <input style="float: right;" class="btn btn-primary " type="button" onclick="return form_validation();" value="Save" />
            <input style="float: right;margin-right: 5px;" class="btn btn-default" type="button" onclick="redirectpage();" value="Cancel" />
                
            </form>
			<!-- end row -->

			
		</section>
		<!-- end widget grid -->

	</div>
			<!-- END MAIN CONTENT -->

		</div>