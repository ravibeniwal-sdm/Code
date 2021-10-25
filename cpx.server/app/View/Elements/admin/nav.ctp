<script language="javascript" type="text/javascript">
function changeUpdateDoneValue()
{
    $('#update_done').val(1);
}

function checkpage(page,link)
{
    if((page == 'append' || page == 'append_widgets'))
    {
        var instance = CKEDITOR.instances['vendor_finance_terms'];

        if (instance && CKEDITOR.instances.vendor_finance_terms.checkDirty() ) 
            $('#update_done').val(1);
        
        var update_done_val = $('#update_done').val();
                
        if(update_done_val == 1)        
        {                
            $( "#dialog-confirm" ).dialog({
              resizable: false,
              height:180,
              width:350,
              modal: true,
              title:'Do you want to leave this page?',
              buttons: {
                
                "Leave": {
                    click: function () {
                        $(this).dialog("close");
                        window.location.href=link;
                    },
                    text: 'Leave',
                    class: 'btn btn-primary'
                },
                
                "Stay": {
                    click: function () {
                        $( this ).dialog( "close" );
                    },
                    text: 'Stay',
                    class: 'btn btn-default'
                },                
              },
              
            });
        } 
        else
        {
            window.location.href=link;
        }           
    }
    else
    {
        window.location.href=link;
    }
}
</script>

<style>
#dialog-confirm{
    height: 45px !important;
    margin-top: 14px !important;
}

.ui-dialog-buttonpane.ui-widget-content.ui-helper-clearfix
{
    height:65px !important;
}

.ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix
{
    padding-top:10px !important;
}

.ui-dialog .ui-dialog-title 
{
    font-weight: 100;
    font-size:14px;
}

.smart-style-4 nav>ul ul li:before, .smart-style-4 nav>ul>li>ul:before {
    border-left: 1px solid #7A7A7A !important;
}    

.smart-style-4 nav>ul ul li:before, .smart-style-4 nav>ul>li>ul:before {
    border-top: 1px solid #7A7A7A !important;
}
</style>

<input type="hidden" id="update_done" value="0" />

<div id="dialog-confirm" style="display: none;">
  <p style="font-size: 12px;">
    <span >Changes have not been saved.</span>
  </p>
</div>


<!-- Note: This width of the aside area can be adjusted through LESS variables -->
<aside id="left-panel">

	<!-- User info -->
	<div class="login-info">
		<span> <!-- User image size is adjusted inside CSS, it should stay as it --> 
			
			<a href="javascript:void(0);" >
				<img src="<?php echo IMG_PATH; ?>/avatars/male.png" alt="me" class="online" /> 
				<span>
                Hello, 
					<?php
                    echo $logedinuser['0']['firstname'].' '.$logedinuser['0']['lastname'];                            
                    ?>
				</span>
				
			</a> 
			
		</span>
	</div>
	<!-- end user info -->

	<!-- NAVIGATION : This navigation is also responsive

	To make this navigation dynamic please make sure to link the node
	(the reference to the nav > ul) after page load. Or the navigation
	will not initialize.
	-->
    <?php
    if($logedinuser['0']['type'] == 'superadmin' || $logedinuser['0']['type'] == 'admin')
    {
        echo $this->element('admin/nav_bar');  
    }
    else
    {
        echo $this->element('nav_bar'); 
    }
    ?>
	<span class="minifyme" data-action="minifyMenu"> 
		<i class="fa fa-arrow-circle-left hit"></i> 
	</span>

</aside>
<!-- END NAVIGATION -->