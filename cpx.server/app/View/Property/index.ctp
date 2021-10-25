<style>
.action-btn > a {
    margin-bottom: 1px;
}

.non-selected-btn {
    background-color: lightgrey;
    border-color: lightgrey;
    color: black;
}

/* 
Max width before this PARTICULAR table gets nasty
This query will take effect for any screen smaller than 760px
and also iPads specifically.
*/

@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

	/* Force table to not be like tables anymore */
	.responsive table, thead, tbody, th, td, tr { 
		display: block; 
	}
	
	/* Hide table headers (but not display: none;, for accessibility) */
	.responsive thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
	
	.responsive tr { border: 1px solid #ccc; }
	
	.responsive table tr td { 
		/* Behave  like a "row" */
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
		padding-left: 35%; 
	}
	
	.responsive td:before { 
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
	}
.responsive	tr:nth-of-type(odd) { 
      background: #eee; 
    }
	/*
	Label the data
	*/
	.responsive td:nth-of-type(1):before { content: "Properties"; }
	.responsive td:nth-of-type(2):before { content: "Tags"; }
	.responsive td:nth-of-type(3):before { content: "Status"; }
	.responsive td:nth-of-type(4):before { content: "CPx status"; }
	.responsive td:nth-of-type(5):before { content: "Action"; }
	
    .panel{
        background-color: #eee !important;
        border: 0px !important;
    }
    
    .panel-heading{
        background-color: #eee !important;
        border: 0px !important;
    }
}

#sparks li h5
{
    text-transform: none !important;
}
</style>

<style>
div.ui-datepicker-header 
a.ui-datepicker-prev,div.ui-datepicker-header 
a.ui-datepicker-next
{
    display: none;  
}
</style>
<style>
.ui-dialog .ui-dialog-title 
{
    color: red;
    font-weight: bold;
    font-size: 16px;
    margin-left: -12px !important;
}

.btn-purge {
    background-color: #db0435; 
    border-color: #db0435;
    color:white;
}

.btn-purge:hover, .btn-purge:focus
{
    color:white !important;
}


</style>

<style>
.first_para{
    padding-top: 20px;
}

.att_msg{
    padding-left: 10px;
    padding-right: 10px;
}

.second_point{
    padding-left: 52px;
}

.last_para{
    padding-bottom: 20px;
}

</style>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script language="javascript">
function toggleFeatured(ele,id)
{
    $.ajax({
        url: '<?=ADMIN_PATH?>/property/toggleStatus/featured/'+id ,
        cache: false,
        type: 'POST',
        dataType: 'json',
        error: function (data) {
                checkSessionForAjax(data);
            },
        success: function (data) {
            if(data.status)
            {
               /* if(data.value==true)
                {
                    $(ele).children().children().addClass("glyphicon-ok").removeClass("glyphicon-remove");
                }else
                {
                    $(ele).children().children().addClass("glyphicon-remove").removeClass("glyphicon-ok");
                }
                */                
            }          
            
        }
    });
    ele.preventDefault();
    return true;
    
}



function toggleOffline(ele,id)
{
    total_live_properties = $('#total_live_properties').val();
    $.ajax({
        url: '<?=ADMIN_PATH?>/property/toggleStatus/offline/'+id+'/'+total_live_properties ,
        cache: false,
        type: 'POST',
        dataType: 'json',
        error: function (data) {
                checkSessionForAjax(data);
            },
        success: function (data) {
            if(data.value == true)
               $('#purge_btn_'+id).show();
            else if(data.value == false)
               $('#purge_btn_'+id).hide();    
            
            $('#total_live_properties').val(data.total_live_properties);
            
            value_span_total_live_properties = '<i class="fa fa-globe"></i>&nbsp;'+data.total_live_properties;
            $('#span_total_live_properties').html(value_span_total_live_properties);            
        }
    });
    return false;
    
}

function toggleSMSF(ele,id)
{
    $.ajax({
        url: '<?=ADMIN_PATH?>/property/toggleStatus/smsf/'+id ,
        cache: false,
        type: 'POST',
        dataType: 'json',
        error: function (data) {
                checkSessionForAjax(data);
            },
        success: function (data) {
            if(data.status)
            {
               /* if(data.value==true)
                {
                    $(ele).children().children().addClass("glyphicon-ok").removeClass("glyphicon-remove");
                }else
                {
                    $(ele).children().children().addClass("glyphicon-remove").removeClass("glyphicon-ok");
                }
                */                
            }          
            
        }
    });
    return false;
    
}

function show_hide_search()
{
    if($('#show_search_link').text() == 'Show Search')
    {
        $('#show_search_link').text('Hide Search');
        $('#search_div').show();
    }
    else if($('#show_search_link').text() == 'Hide Search')
    {
        $('#show_search_link').text('Show Search');
        $('#search_div').hide();
    }
        
    
}

function search()
{
    if($('#no_agent_id'). prop("checked") == true)
        reset_search(true);
        
    $('#search_property_form').submit();
}

function reset_search(only_reset=false)
{
    $('#pub_id_email').val('');
    $('#paid_adv_exp_before').val('');
    $('#prop_owner_id_email').val('');
    $('#auctions_before').val('');
    $('#prop_name_id_add').val('');
    $('#pub_before').val('');
    
    $('#all').attr('checked', false);
    $('#established').attr('checked', false);
    $('#new').attr('checked', false);
    $('#home_and_land').attr('checked', false);
    $('#auction').attr('checked', false);
    $('#smsf').attr('checked', false);
    $('#fractional').attr('checked', false);
    $('#under_offer').attr('checked', false);
    $('#sold').attr('checked', false);
    $('#vendorfinance').attr('checked', false);
    
    if(only_reset == false)
    {
        $('#no_agent_id').attr('checked', false);
        
        $('#search_done').val('');
        
        $('#search_property_form').submit();
    }
}

$(function() 
 {   $( "#paid_adv_exp_before" ).datepicker({
         changeMonth:true,
         changeYear:true,
         yearRange:"-100:+0",
         prevText : '<i class="fa fa-chevron-left"></i>',
	     nextText : '<i class="fa fa-chevron-right"></i>',
         dateFormat:"dd/mm/yy" });
       
 });

$(function() 
 {   $( "#auctions_before" ).datepicker({
         changeMonth:true,
         changeYear:true,
         yearRange:"-100:+0",
         prevText : '<i class="fa fa-chevron-left"></i>',
	     nextText : '<i class="fa fa-chevron-right"></i>',
         dateFormat:"dd/mm/yy" });
       
 });
     
     
$(function() 
 {   $( "#pub_before" ).datepicker({
         changeMonth:true,
         changeYear:true,
         yearRange:"-100:+0",
         prevText : '<i class="fa fa-chevron-left"></i>',
	     nextText : '<i class="fa fa-chevron-right"></i>',
         dateFormat:"dd/mm/yy" });
 });     

function confirm_purge(link,purge_all=false)
{
    $( "#dialog-confirm-purge" ).dialog({
          resizable: false,
          height:200,
          width:350,
          title:'WARNING',
          modal: true,
          buttons: {
            
            "Yes": {
                click: function () {
                    $(this).dialog("close");
                    
                    if(purge_all==true)
                    {
                        $('#purge_hidden_val').val(1);
                        $('#search_property_form').submit();
                    }
                    else if(purge_all==false)         
                        window.location.href=link;
                },
                text: 'Yes',
                class: 'btn btn-purge'
            },
            
            "No": {
                click: function () {
                    $( this ).dialog( "close" );
                },
                text: 'No',
                class: 'btn btn-default'
            },                
          },
          
        });
}           
</script>

<div id="dialog-confirm-purge" style="display: none;" >
  <p style="font-size: 12px;color: red;">
    <span >You are going to purge the data from the database.<br />Are you sure you want to purge data?</span>
  </p>
</div>

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
			<li>Home</li><li>Listing</li>
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
        
        <?php 
        if($user_type == 'superadmin') 
        {
        ?>
		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-home"></i> Listings</h1>
			</div>
			
            <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8 smart-form" >
            <section class="col col-9" style="float: right;" >
                                                   
                <section class="col col-3">
    				<ul id="sparks" class="">
                        <li class="sparks-info counter_link">
    						<h5> Live properties <a style="text-decoration: none;" href="<?=ADMIN_PATH?>property?filtertxt=live_properties"><span id="span_total_live_properties"><i class="fa fa-globe"></i>&nbsp;<?php echo $total_live_properties ?></span></a></h5>
    					</li>
                    </ul>
				</section>
               
                <section class="col col-2">  
                    <ul id="sparks" class="">                  
    					<li class="sparks-info">
    						<h5> Publishers <span ><i class="fa fa-group"></i>&nbsp;<?php echo $total_publishers ?></span></h5>
    					</li>
                    </ul>
				</section>
               
                <section class="col col-4">        
                    <ul id="sparks" class="">                
    					<li class="sparks-info">
    						<h5> Publishers properties <span ><i class="fa fa-home"></i>&nbsp;<?php echo $grand_total_properties ?></span></h5>
    					</li>
                    </ul>
				</section>
               
                <section class="col col-3">        
                    <ul id="sparks" class="">                         
    					<li class="sparks-info">
    						<h5> Total properties <span ><i class="fa fa-database"></i>&nbsp;<?php echo $db_total_properties ?></span></h5>
    					</li>
    				</ul>
                </section>
                
                </section>
			</div>
		</div>
        <?php
        }
        else
        {
            ?>
            <div class="row">
    			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
    				<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-home"></i> My Listings</h1>
    			</div>
    		</div>
            <?php
        }
        ?>
		<!-- widget grid -->
        
		<section id="widget-grid" class="">
			<!-- row -->
			<div class="row">
                
                <div>
                    <div style="padding-top: 5px;padding-bottom: 10px;padding-left: 15px;font-size: 14px;margin-left: 13px;margin-right: 13px;margin-bottom:10px;background-color: #4C4F53 !important;color: white;">
                        <strong>Can't</strong> <i> find your properties?</i>
                        
                        <span style="float: right;padding-right: 10px;cursor: pointer;" onclick='$("#div_cantfindproperties").toggle();$("#toggle_icon_cantfindproperties").toggleClass("fa fa-minus fa fa-plus");'>
                            <i id="toggle_icon_cantfindproperties" class="fa fa-plus"></i>
                        </span>
                    </div> 
                    
                    <div id="div_cantfindproperties" style="display: none;margin-left: 13px;margin-right: 13px;margin-bottom: 10px;border: 1px solid black;background-color: #ffffcc;">
                        <p class="first_para att_msg">Please review the following before contacting us for assistance:</p>
                        
                        <p class="att_msg"><strong>Scenario 1</strong> - If you have listed and publish properties on CPx via your preferred portal/ uploader</p>
                        <p class="att_msg">Cause: Your CPx account is not in sync with your property listing platform/ uploader account.</p>
                        <br />
                        <p class="att_msg"><strong>Scenario 2</strong> -  If you are the property owner</p>
                        <p class="att_msg">Cause: i) Your agent may need to add your email into the 'property owner details' in their preferred property portal/ uploader.</p>   
                        <p class="second_point att_msg">ii) The agent has entered an email that does not match your CPx account ID.</p>        
                        <br />
                        <p class="att_msg"><strong>Solution</strong></p>
                        <p class="att_msg">Your CPx account ID is your email; it is vital to use the same email to ensure the property listing platform/ uploader and CPx accounts are in sync.</p>   
                        <p class="second_point att_msg"> 
                        <ul>
                        <li>
                        <a style="text-decoration: underline;" href="javascript:void(0);">Click here</a> to add another email.
                        </li>
                        </ul>
                        </p>
                        <br />
                        <p class="att_msg"><strong>Assistance</strong></p>
                        <p class="last_para att_msg">If you have followed the above steps and are still not able to see your properties, <a style="text-decoration: underline;" href="<?php echo WEB_PATH;?>#!/contact" target="_blank">contact us</a> for assistance.</p>   
                        
                    </div>
                    
                </div>
            
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<!-- new widget -->
					<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-0" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-deletebutton="false" data-widget-colorbutton="false" >
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
						<header></header>
                
						<!-- widget div-->
                        <div class="text-right">
                        <a href="javascript:void(0);" id="show_search_link" onclick="show_hide_search();" style="text-decoration: none !important;">Show Search</a>
                        </div>
                        
						<div>
                            
                            
                            <div  id="search_div" style="<?php echo  ($search_done) ? 'display: block;' : 'display: none;' ?>">
								<form class="smart-form" method="POST" id="search_property_form" action="<?=ADMIN_PATH?>property/">
									
									<fieldset>
										
		                                <div class="row">
										
											<section class="col col-3">
												<label class="input">
													<strong>Publisher ID/email</strong>
												</label>
											</section>
											<section class="col col-3">
												<label class="input">
													<input type="text" name="pub_id_email" id="pub_id_email" value="<?php echo !empty($pub_id_email) ? $pub_id_email : '' ?>" />
												</label>
											</section>
											<section class="col col-3">
												<label class="input">
													<strong>Paid advertisement expiring before</strong>
												</label>
											</section>
											<section class="col col-3">
												<label class="input">
                                                    <i class="icon-append fa fa-calendar"></i>
                                                    <input type="text" name="paid_adv_exp_before" id="paid_adv_exp_before" value="<?php echo !empty($paid_adv_exp_before) ? $paid_adv_exp_before : '' ?>" />
												</label>
											</section>
											
										</div>
                                        
                                        <?php
                                        $checkbox_val = '';
                                        if(isset($no_agent_id) && !empty($no_agent_id))
                                        {
                                            $checkbox_val = 'CHECKED';   
                                        }
                                        ?>
                                        
                                        <div class="row">
                                            <section class="col col-3">
												<label class="input">
													<strong>No publisher ID/email</strong>
												</label>
											</section>
											<section class="col col-3">
												
												<input type="checkbox" id="no_agent_id" name="no_agent_id" <?php echo $checkbox_val ?>/>
												
											</section>
                                            										      
											<section class="col col-3">
												<label class="input">
													<strong>Auctions Before </strong>
												</label>
											</section>
											<section class="col col-3">
												<label class="input"><i class="icon-append fa fa-calendar"></i>
													<input type="text" name="auctions_before" id="auctions_before"  value="<?php echo !empty($auctions_before) ? $auctions_before : '' ?>" />
												</label>
											</section>
											
										</div>
                                        
                                        <div class="row">
                                            <section class="col col-3">
												<label class="input">
													<strong>Property owner ID/email</strong>
												</label>
											</section>
											<section class="col col-3">
												<label class="input">
													<input type="text" name="prop_owner_id_email" id="prop_owner_id_email" value="<?php echo !empty($prop_owner_id_email) ? $prop_owner_id_email : '' ?>" />
												</label>
											</section>
                                            										      
											<section class="col col-3">
												<label class="input">
													<strong>Published Before </strong>
												</label>
											</section>
											<section class="col col-3">
												<label class="input"><i class="icon-append fa fa-calendar"></i>
													<input type="text" name="pub_before" id="pub_before"  value="<?php echo !empty($pub_before) ? $pub_before : '' ?>" />
												</label>
											</section>
											
										</div>
                                        
                                        <div class="row">
                                            <section class="col col-3">
												<label class="input">
													<strong>Property name/ID/address </strong>
												</label>
											</section>
											<section class="col col-3">
												<label class="input">
													<input type="text" name="prop_name_id_add" id="prop_name_id_add"  value="<?php echo !empty($prop_name_id_add) ? $prop_name_id_add : '' ?>" />
												</label>
											</section>
                                            
                                        </div>
                                        
                                        <div class="row">
                                        
                                        
                                            <section class="col col-2">
												<label class="input">
													<strong>Tags </strong>
												</label>
											</section>
                                            <section >
                                            
                                            <div class="inline-group">
												<label class="checkbox">
													<input type="checkbox" name="all" id="all"  <?php echo (isset($all)) ? 'checked' : '' ?>/>
													<i></i>All</label>
												<label class="checkbox">
													<input type="checkbox" name="established" id="established"   <?php echo (isset($established)) ? 'checked' : '' ?>/>
													<i></i>Established</label>
												<label class="checkbox">
													<input type="checkbox" name="new" id="new"  <?php echo (isset($new)) ? 'checked' : '' ?>/>
													<i></i>New</label>
												<label class="checkbox">
													<input type="checkbox" name="home_and_land" id="home_and_land"   <?php echo (isset($home_and_land)) ? 'checked' : '' ?>/>
													<i></i>Home And Land</label>
												<label class="checkbox">
													<input type="checkbox" name="auction" id="auction"   <?php echo (isset($auction)) ? 'checked' : '' ?>/>
													<i></i>Auction</label>
                                                <label class="checkbox">
													<input type="checkbox" name="smsf" id="smsf"  <?php echo (isset($smsf)) ? 'checked' : '' ?>/>
													<i></i>SMSF</label>
                                                <label class="checkbox">
													<input type="checkbox" name="fractional" id="fractional"  <?php echo (isset($fractional)) ? 'checked' : '' ?>/>
													<i></i>Fractional</label>
                                                <label class="checkbox">
													<input type="checkbox" name="under_offer" id="under_offer"  <?php echo (isset($under_offer)) ? 'checked' : '' ?> />
													<i></i>Under Offer</label>
                                                    
                                                <label class="checkbox">
													<input type="checkbox"  name="sold" id="sold"  <?php echo (isset($sold)) ? 'checked' : '' ?>/>
													<i></i>Sold</label>
                                                  
                                               <label class="checkbox">
													<input type="checkbox" name="vendorfinance" id="vendorfinance"   <?php echo (isset($vendorfinance)) ? 'checked' : '' ?>/>
													<i></i>Vendor Finance</label>             
                                                    
                                               <label class="checkbox">
													<input type="checkbox" name="saving" id="saving"   <?php echo (isset($saving)) ? 'checked' : '' ?>/>
													<i></i>Saving</label>                                                                                  
                                                    
											</div>
                                              
                                            </section>
                                        </div>
                                        
									</fieldset>
		
									
		
									<footer>
                                        <input type="hidden" id="search_done" name="search_done" value="1" />
                                        
                                        <?php
                                        if(isset($no_agent_id) && !empty($no_agent_id))
                                        {
                                        ?>
                                        <input type="hidden" id="purge_hidden_val" name="purge" value="0" />
                                        <button type="button" onclick="confirm_purge('',true);" name="purge" value="1" class="btn btn-purge" >
											Purge
										</button>
                                        <?php
                                        }
                                        ?>
                                                                                        
										<button type="button" onclick="search();" class="btn btn-primary">
											Search
										</button>
										<button type="button" class="btn btn-default" onclick="reset_search();">
											Reset
										</button>
									</footer>
								</form>
		
							</div>
                        
                            
                            
                            
                            
                            <ul class="demo-btns">
								<li>
									<a href="<?=ADMIN_PATH?>property/index/All/" id="eg1" class="<?php if($selected_tab == 'all') echo "btn btn-primary"; else echo "btn non-selected-btn";?>"> <i class="fa"></i> All (<?=$countpropAll?>)</a>
								</li>
                                
                                <li>
									<a href="<?=ADMIN_PATH?>property/index/Standard/" id="eg1" class="<?php if($selected_tab == 'standard') echo "btn btn-primary"; else echo "btn non-selected-btn";?>"> <i class="fa"></i> Standard (<?=$countpropStandard?>)</a>
								</li>
                                
                                <li>
									<a href="<?=ADMIN_PATH?>property/index/Prepurchasedipr/" id="eg1" class="<?php if($selected_tab == 'prepurchasedipr') echo "btn btn-primary"; else echo "btn non-selected-btn";?>"> <i class="fa"></i> Pre-purchased ipr (<?=$countpropPrepurchasedipr?>)</a>
								</li>
                                
                                <li>
									<a href="<?=ADMIN_PATH?>property/index/Iprpending/" id="eg1" class="<?php if($selected_tab == 'iprpending') echo "btn btn-primary"; else echo "btn non-selected-btn";?>"> <i class="fa"></i> ipr Pending (<?=$countpropPending?>)</a>
								</li>
                                
								<li>
									<a href="<?=ADMIN_PATH?>property/index/Graded/" id="eg2" class="<?php if($selected_tab == 'graded') echo "btn btn-primary"; else echo "btn non-selected-btn";?>"> <i class="fa"></i> Graded (<?=$countpropGraded?>)</a>
								</li>
								<li>
									<a href="<?=ADMIN_PATH?>property/index/Featured/" id="eg3" class="<?php if($selected_tab == 'featured') echo "btn btn-primary"; else echo "btn non-selected-btn";?>"> <i class="fa"></i> Featured (<?=$countpropFeatured?>)</a>
								</li>
								<li>
									<a href="<?=ADMIN_PATH?>property/index/Offline/" id="eg4" class="<?php if($selected_tab == 'offline') echo "btn btn-primary"; else echo "btn non-selected-btn";?>"> <i class="fa"></i> Offline (<?=$countpropOffline?>)</a>
								</li>
						    </ul>
                            
							<!-- widget content -->
							<div class="widget-body">
								<!--
<p><a href="javascript:void(0);">Display in Published calendar</a></p>
-->
								
								<div class="custom-scroll table-responsive responsive">
								
									<table class="table table-bordered">
										<thead>
											<tr>
												<th>Properties</th>
												<th>Tags</th>
												<?php
                                                if($selected_tab=="prepurchasedipr")
                                                {
                                                ?>
                                                <th>Publish date</th>
												<th>Expires in days</th>
                                                <?php   
                                                }
                                                elseif($selected_tab=="graded")
                                                {
                                                ?>
                                                <th>Publish date</th>
												<th>Expires in days</th>
                                               <?php     
                                                }
                                                elseif($selected_tab=="featured")
                                                { 
                                                ?>
                                                <th>Current featured date</th>
												<th>Featured days</th>
                                                <?php    
                                                }
                                                ?>
                                                
                                                <th>Status</th>
												<th>CPx completeness status</th>
                                                <th>Action</th>
											</tr>
										</thead>
										<tbody>
                                            <?php 
                                            //echo "<pre>";
                                            //print_r($propertyList);
                                            //echo "</pre>";
                                            
                                            
                                            if(!empty($propertyList))
                                            {
                                            foreach($propertyList as $property)
                                            {
                                                //$searchQueryStr1 = '';
//                                                $searchQueryStr1 = $searchQueryStr;
//                                                
//                                                parse_str($searchQueryStr,$output);
//                                                
//                                                foreach($output as $key=>$val)
//                                                {
//                                                    if((!isset($output['search_done'])) || (isset($output['search_done']) && !$output['search_done']))
//                                                    {
//                                                        $searchQueryStr1 .= '&search_done=1';
//                                                    }
//                                                    
//                                                    if((!isset($output['prop_name_id_add'])) && (!isset($output['?prop_name_id_add'])))
//                                                    {
//                                                        $searchQueryStr1 .= '&prop_name_id_add='.$property['id'];
//                                                    }
//                                                }
                                                
                                                //echo $searchQueryStr1;
                                                                                           
                                                $name = $lot_no = $sub_no = $street_no = $street = $suburb = $city = $state = $postcode = '';
                                                
                                                $name = !empty($property['name']) ? $property['name'].' - ' : '';
                                                
                                                $lot_no = !empty($property['address'][0]['LotNumber']) ? $property['address'][0]['LotNumber'] : '';
                                                $sub_no = !empty($property['address'][0]['subNumber']) ? ' '.$property['address'][0]['subNumber'] : '';
                                                //$street_no = (!empty($property['address'][0]['subNumber']) && !empty($property['address'][0]['StreetNumber'])) ? ' / '.$property['address'][0]['StreetNumber'] : '';
                                                
                                                //$street_no = (empty($property['address'][0]['subNumber']) && !empty($property['address'][0]['StreetNumber'])) ? ' '.$property['address'][0]['StreetNumber'] : '';

                                                
                                                if(!empty($property['address'][0]['subNumber']) && !empty($property['address'][0]['StreetNumber']))
                                                    $street_no = '/'.$property['address'][0]['StreetNumber'];
                                                
                                                if(empty($property['address'][0]['subNumber']) && !empty($property['address'][0]['StreetNumber']))
                                                    $street_no = ' '.$property['address'][0]['StreetNumber'];
                                                
                                                $street = !empty($property['address'][0]['street']) ? ' '.$property['address'][0]['street'] : '';
                                                $suburb = !empty($property['address'][0]['suburb']['text']) ? ', '.$property['address'][0]['suburb']['text'] : '';
                                                $city = !empty($property['address'][0]['city']) ? ' '.$property['address'][0]['city'] : '';
                                                $state = !empty($property['address'][0]['state']) ? ' '.$property['address'][0]['state'] : '';
                                                $postcode = !empty($property['address'][0]['postcode']) ? ' '.$property['address'][0]['postcode'] : '';
                                                
                                                $owner_email = $listing_agents = '';
                                                if(isset($property['contact']) && !empty($property['contact']))
                                                {
                                                    foreach($property['contact'] as $contact)
                                                    {
                                                        if($contact['type'] == 'vendorDetails')
                                                            $owner_email = $contact['email'];
                                                        if($contact['type'] == 'listingAgent')
                                                            $listing_agents .= $contact['email'].',';
                                                    }
                                                }
                                                $listing_agents = trim($listing_agents,',');
                                                
                                                $publisher_email = '';
                                                if(!empty($property['agentID']))
                                                    $publisher_email = $property['agentID'];    
                                                
                                                $tag_str = '';
                                                
                                                $tag_str .= ((isset($property['smsf']) && $property['smsf']==1) ? 'SMSF, ' : ''); 
                                                $tag_str .= ((isset($property['sold']) && $property['sold']==1) ? 'Sold, ' : '');
                                                $tag_str .= (isset($property['domacom']) && $property['domacom']==1) ? 'Domacom, ' : '';
                                                $tag_str .= ((isset($property['vendorfinance']) && ($property['vendorfinance']==1) && isset($property['vendor_finance_terms']) && !empty($property['vendor_finance_terms'])) ? 'Vendor Finance, ' : '');
                                                $tag_str .= ((isset($property['saving']) && $property['saving']>1) ? 'Saving, ' : '');
                                                $tag_str .= (isset($property['established']) && $property['established']=='yes') ? 'Established, ' : '';
                                                $tag_str .= (isset($property['homelandpackage']) && $property['homelandpackage']=='yes') ? 'Home Land, ' : '';
                                                $tag_str .= (isset($property['newConstruction']) && ($property['newConstruction']==1 || $property['newConstruction']=='yes')) ? 'New, ' : '';
                                                
                                                $tag_str .= ((isset($property['auction_date']) && !empty($property['auction_date'])) ? 'Auction, ' : '');
                                                $tag_str .= ((isset($property['deposit']) && $property['deposit']=='yes') ? 'Under Offer, ' : '');

                                                $tag_str = trim($tag_str,', ');
                                                
                                                
                                                $status_str = '';
                                                $status_str .= (($property['gradestatus']) ? 'Graded, ' : '');
                                                $status_str .= (($property['featured']) ? 'Featured, ' : '');
                                                $status_str .= (($property['offline']) ? 'Offline, ' : '');
                                                $status_str .= ((!$property['offline'] && !$property['gradestatus']) ? 'Standard, ' : '');
                                                                                
                                                $status_str = trim($status_str,', '); 
                                                
                                                $completeness_status = 0;
                                                
                                                $property_for_sale_weightage = 25;
                                                $property_for_sale_value = 0;
                                                
                                                $contract_of_sale_weightage = 15;
                                                $contract_of_sale_value = 0;
                                                
                                                $fractional_ownership_weightage = 10;
                                                $fractional_ownership_value = 0;
                                                
                                                $contact_details_weightage = 10;
                                                $contact_details_value = 0;
                                                
                                                $vendor_finance_weightage = 10;
                                                $vendor_finance_value = 0;
                                                
                                                $ipr_details_weightage = 30;
                                                $ipr_details_value = 0;
                                                
                                                if(isset($property['saving']) && !empty($property['saving']))
                                                {
                                                    $completeness_status += $property_for_sale_weightage; 
                                                    $property_for_sale_value = 1;
                                                }
                                                
                                                if(isset($property['contract']) && !empty($property['contract']))
                                                {
                                                    $completeness_status += $contract_of_sale_weightage;
                                                    $contract_of_sale_value = 1;
                                                }
                                                
                                                if(isset($property['domacom']) && $property['domacom'])
                                                {
                                                    $completeness_status += $fractional_ownership_weightage;
                                                    $fractional_ownership_value = 1;
                                                }
                                                    
                                                $contacts_completeness_flag = 0;
                                                if(isset($property['contact']) && !empty($property['contact']))
                                                {            
                                                    foreach($property['contact'] as $contacts)
                                                    {
                                                        if((isset($contacts['append_val']) && ($contacts['append_val'])) || (isset($contacts['emails_val']) && ($contacts['emails_val'])) || (isset($contacts['display_val']) && ($contacts['display_val'])))
                                                            $contacts_completeness_flag = 1;      
                                                    }
                                                }
                                                            
                                                if($contacts_completeness_flag)
                                                {
                                                    $completeness_status += $contact_details_weightage;
                                                    $contact_details_value = 1;
                                                }
                                                    
                                                if(isset($property['vendor_finance_terms']) && !empty($property['vendor_finance_terms']))
                                                {
                                                    $completeness_status += $vendor_finance_weightage;
                                                    $vendor_finance_value = 1;
                                                }       
                                                    
                                               // if(isset($property['iprs']['0']['Id']) && !empty($property['iprs']['0']['Id']))
                                              
                                               if(isset($property['gradestatus']) && $property['gradestatus'] ==2)
                                                {
                                              
                                                   
                                                    $completeness_status += $ipr_details_weightage;
                                                    $ipr_details_value = 1;
                                                }
                                                   
                                            ?>
                                            
											<tr id="<?=$property['id']?>">
												<td>
                                                <strong>Property [View]: </strong>
                                                <a href="<?=WEB_PATH?>#!/details/<?=$property['id']?>" target="_blank"><?php echo $name.$lot_no.$sub_no.$street_no.$street.$suburb.$city.$state.$postcode; ?></a><br /><br />
                                                
                                                <strong>Id [Append]: </strong>
                                                <a href="<?=ADMIN_PATH?>property/append/<?=$property['id'].$searchQueryStr.'&tab_selected='.$status.'&pageno='.($currentPage)?>"><?php echo $property['id']; ?></a><br /><br />
                                                
                                                <strong>Property Id: </strong>
                                                <a href="<?=ADMIN_PATH?>property/append/<?=$property['id'].$searchQueryStr.'&tab_selected='.$status.'&pageno='.($currentPage)?>"><?php echo $property['property_id']; ?></a><br /><br />
                                                
                                                                                                                                                                    
                                                                                                                                                                    <?php
                                                if(!empty($publisher_email) && !empty($listing_agents))
                                                {
                                                ?>
                                                
                                                <div class="panel-group smart-accordion-default" id="accordion-2" style="padding-bottom: 20px;">
        											<div class="panel panel-default" style="border: 0px;background-color: #fff;">
        												<div class="panel-heading" style="background-color: #fff;">
        													<div style="font-size: 13px;" class="panel-title"><a data-toggle="collapse" data-parent="#accordion-2" href="#div_<?=$property['id']?>" class="collapsed" style="padding-left: 0px;"> <i class="fa fa-fw fa-plus"></i> <i class="fa fa-fw fa-minus"></i> <strong>Publisher: </strong> <?php echo $publisher_email; ?> </a></div>
        												</div>
        												<div id="div_<?=$property['id']?>" class="panel-collapse collapse" style="height: 0px;">
        													<div class="panel-body">
        														<strong>Listing Agent: </strong> <?php echo $listing_agents; ?> 
        													</div>
        												</div>
        											</div>
        										</div>
                                                
                                                <?php
                                                }
                                                elseif(empty($publisher_email) && !empty($listing_agents))
                                                {
                                                    ?>
                                                    
                                                    <div class="panel-group smart-accordion-default" id="accordion-2" style="padding-bottom: 20px;">
            											<div class="panel panel-default" style="border: 0px;background-color: #fff">
            												<div class="panel-heading" style="background-color: #fff;">
            													<div style="font-size: 13px;" class="panel-title"><a data-toggle="collapse" data-parent="#accordion-2" href="#div_<?=$property['id']?>" class="collapsed" style="padding-left: 0px;"> <i class="fa fa-fw fa-plus"></i> <i class="fa fa-fw fa-minus"></i> <strong>No publisher </strong>  </a></div>
            												</div>
            												<div id="div_<?=$property['id']?>" class="panel-collapse collapse" style="height: 0px;">
            													<div class="panel-body">
            														<strong>Listing agent: </strong> <?php echo $listing_agents; ?> 
            													</div>
            												</div>
            											</div>
            										</div>
                                                    
                                                    <?php
                                                }                                                
                                                elseif(!empty($publisher_email) && empty($listing_agents))
                                                {
                                                    ?>
                                                    <div class="panel-group smart-accordion-default" id="accordion-2" style="padding-bottom: 20px;">
            											<div class="panel panel-default" style="border: 0px;background-color: #fff;">
            												<div class="panel-heading" style="background-color: #fff;">
            													<div style="font-size: 13px;" class="panel-title"><a data-toggle="collapse" data-parent="#accordion-2" href="#div_<?=$property['id']?>" class="collapsed" style="padding-left: 0px;"> <i class="fa fa-fw fa-plus"></i> <i class="fa fa-fw fa-minus"></i> <strong>Publisher: </strong> <?php echo $publisher_email; ?> </a></div>
            												</div>
            												<div id="div_<?=$property['id']?>" class="panel-collapse collapse" style="height: 0px;">
            													<div class="panel-body">
            														<strong>No listing agent </strong>
            													</div>
            												</div>
            											</div>
            										</div>
                                                    <?php
                                                }
                                                
                                                if(!empty($owner_email))
                                                {
                                                ?>
                                                    <strong>Owner: </strong> <?php echo $owner_email; ?>
                                                <?php
                                                }
                                                ?>
                                                </td>
												<td><?php echo $tag_str;?></td>
												
                                                <?php
                                                if($selected_tab=="prepurchasedipr")
                                                {?>
                                                <td></td>
												<td></td>
                                                <?php   
                                                }elseif($selected_tab=="graded")
                                                {?>
                                                <td>
                                                    <?php
                                                        if(!empty($property['iprs']['0'])) 
                                                        {
                                                            $published_date = $property['iprs']['0']['publishedAt'];
                                                            
                                                            $tmp_datetime = explode('T', $published_date);
                                                            
                                                            $tmp_date = explode('-',$tmp_datetime['0']);
                                                            $day = $tmp_date['2'];
                                                            $month = $tmp_date['1'];
                                                            $year = $tmp_date['0'];
                                                            
                                                            $tmp_time = explode(':',$tmp_datetime['1']);
                                                            $hours = $tmp_time['0'];
                                                            $min = $tmp_time['1'];
                                                            $sec = '0';
                                                         
                                                        
                                                            echo date('d M Y',mktime($hours, $min, $sec ,$month, $day,$year));
                                                        }   
                                                    ?>
                                                </td>
												<td>
                                                    <?php
                                                    if(!empty($property['iprs']['0'])) 
                                                    {
                                                        $published_on = $property['iprs']['0']['publishedAt'];
                                                        
                                                        $today_date = date('Y/m/d h:m');
                                        
                                                        $tmp_datetime = explode('T', $published_on);
                                                    
                                                        $tmp_date = explode('-',$tmp_datetime['0']);
                                                        
                                                        $published_date = $tmp_date['0'].'/'.$tmp_date['1'].'/'.$tmp_date['2'].' '.$tmp_datetime['1'];
                                        
                                                        $startTimeStamp = strtotime($today_date);
                                                        $endTimeStamp = strtotime($published_date);
                                                        
                                                        $timeDiff = abs($endTimeStamp - $startTimeStamp);
                                                        
                                                        $numberDays = $timeDiff/86400;  // 86400 seconds in one day
                                                        
                                                        // and you might want to convert to integer
                                                        $expiresOn = 95 - intval($numberDays); 
                                                        
                                                        if($expiresOn < 0)
                                                            $expiresOn = 0;
                                                        
                                                        echo $expiresOn; 
                                                    }                 
                                                    ?>
                                                </td>
                                               <?php     
                                                }
                                                elseif($selected_tab=="featured")
                                                { ?>
                                                <td><?php $date = date_create($property['featured_date']);
echo date_format($date, 'd M Y');?></td>
												<td>
                                                <?php
                                                 $dStart = new DateTime($property['featured_date']);
                                                               $dEnd  = new DateTime(date('Y-m-d'));
                                                               $dDiff = $dStart->diff($dEnd);
                                                              // echo $dDiff->format('%R'); // use for point out relation: smaller/greater
                                                              if($dDiff->days==0)
                                                              {
                                                                echo "Today";
                                                              }else
                                                              {
                                                                echo $dDiff->days;
                                                              }
                                                ?>
                                               </td>
                                                <?php    
                                                }
                                               ?>
                                                
                                                <td><?php echo $status_str;?></td>
												<td>
                                                    
                                                    <div class="widget-toolbar pull-left" style="border: 0px;"> 
                                        			<div class="progress progress-xs" data-progressbar-value="<?php echo $completeness_status;?>">
                                                            <div class="progress-bar"></div>
                                                        </div>
                                        		      </div>
                                                    
                                                    <div style="clear: both;padding-top: 10px;"> 
                                                    
                                                    <?php
                                                    if(!$property_for_sale_value)
                                                    {
                                                    ?>
                                                        <div style="padding-left: 7px;"><a href="<?=ADMIN_PATH?>property/append_widgets/<?=$property['id']?>/wid-id-0<?=$searchQueryStr.'&tab_selected='.$status.'&pageno='.($currentPage)?>">Property for-sale-price</a></div>
                                                    <?php
                                                    }
                                                    if(!$contract_of_sale_value)
                                                    {
                                                    ?>
                                                        <div style="padding-left: 7px;"><a href="<?=ADMIN_PATH?>property/append_widgets/<?=$property['id']?>/wid-id-1<?=$searchQueryStr.'&tab_selected='.$status.'&pageno='.($currentPage)?>">Contract for sale</a></div>
                                                    <?php
                                                    }
                                                    if(!$fractional_ownership_value)
                                                    {
                                                    ?>
                                                        <div style="padding-left: 7px;"><a href="<?=ADMIN_PATH?>property/append_widgets/<?=$property['id']?>/wid-id-2<?=$searchQueryStr.'&tab_selected='.$status.'&pageno='.($currentPage)?>">Fractional ownership</a></div>
                                                    <?php
                                                    }
                                                    if(!$contact_details_value)
                                                    {
                                                    ?>    
                                                        <div style="padding-left: 7px;"><a href="<?=ADMIN_PATH?>property/append_widgets/<?=$property['id']?>/wid-id-3<?=$searchQueryStr.'&tab_selected='.$status.'&pageno='.($currentPage)?>">Contact details</a></div>
                                                    <?php
                                                    }
                                                    if(!$vendor_finance_value)
                                                    {
                                                    ?>
                                                        <div style="padding-left: 7px;"><a href="<?=ADMIN_PATH?>property/append_widgets/<?=$property['id']?>/wid-id-4<?=$searchQueryStr.'&tab_selected='.$status.'&pageno='.($currentPage)?>">Vendor Finance</a></div>
                                                    <?php
                                                    }
                                                    if(!$ipr_details_value)
                                                    {
                                                    ?>
                                                        <div style="padding-left: 7px;"><a href="<?=ADMIN_PATH?>property/append_widgets/<?=$property['id']?>/wid-id-5<?=$searchQueryStr.'&tab_selected='.$status.'&pageno='.($currentPage)?>">ipr details</a></div>
                                                    <?php
                                                    }
                                                    
                                                    ?>
                                                    
                                                    </div>
                                                </td>
                                                <td>
                                                
                                                <?php
                                                if($logedinuser['0']['type'] == 'superadmin')
                                                {
                                                ?>
                                                
                                                <div class="action-btn smart-form" >    
                                                    <a href="<?=ADMIN_PATH?>property/append/<?=$property['id'].$searchQueryStr.'&tab_selected='.$status.'&pageno='.($currentPage)?>" class="btn btn-primary container-full">Append </a><br />
                                                    <?php
                                                    $display_status = 'none';
                                                    if($property['offline'])
                                                    {
                                                        $display_status = 'block';
                                                    }   
                                                    
                                                    $purge_link = ADMIN_PATH.'property/index/'.$status.'/'.$currentPage.'?property_id='.$property['id'].'&action=purge';
                                                    ?>
                                                    
                                                    <a id="purge_btn_<?=$property['id']?>" href="javascript:void(0);" class="btn btn-purge container-full" style="margin-top: 5px; display:<?php echo  $display_status; ?>;" onclick="confirm_purge('<?=$purge_link?>',false);">Purge </a><br />
                                                    
                                                    <label class="toggle" >
													<input onclick="return toggleFeatured(this,'<?=$property['id']?>');" type="checkbox" name="Featured_<?=$property['id']?>" <?=($property['featured'])?"checked='checked'":"" ?>">
													<i data-swchon-text="ON" data-swchoff-text="OFF"></i>Featured</label>
                                                    
                                                     <label class="toggle" >
													 <input onclick="toggleSMSF(this,'<?=$property['id']?>');" type="checkbox" name="SMSF_<?=$property['id']?>" <?=($property['smsf'])?"checked='checked'":"" ?>">
													<i data-swchon-text="ON" data-swchoff-text="OFF"></i>SMSF</label>
                                                    
                                                    <label class="toggle" >
													<input  type="checkbox" >
													<i data-swchon-text="ON" data-swchoff-text="OFF"></i>ipr ordered</label>
                                                    
                                                     <label class="toggle" >
													<input onclick="toggleOffline(this,'<?=$property['id']?>');" type="checkbox" name="Offline_<?=$property['id']?>" <?=($property['offline'])?"checked='checked'":"" ?>">
													<i data-swchon-text="ON" data-swchoff-text="OFF"></i>Offline</label>
                                                    
                                                    <input type="hidden" name="total_live_properties" id="total_live_properties" value="<?php echo $total_live_properties; ?>" />
                                                                                                                
                                             </div>
                                            <?php
                                            }
                                            else
                                            {
                                            ?>
                                            <div class="action-btn smart-form" >    
                                                <a href="<?=ADMIN_PATH?>property/append/<?=$property['id'].$searchQueryStr.'&tab_selected='.$status.'&pageno='.($currentPage)?>" class="btn btn-primary container-full">Append </a><br />
                                                
                                                
                                                <!--
<label class="toggle" >
												<input onclick="return toggleFeatured(this,'<?=$property['id']?>');" type="checkbox" name="Featured_<?=$property['id']?>" <?=($property['featured'])?"checked='checked'":"" ?>">
												<i data-swchon-text="ON" data-swchoff-text="OFF"></i>Featured</label>
-->
                                                
                                                 <label class="toggle" >
												 <input onclick="toggleSMSF(this,'<?=$property['id']?>');" type="checkbox" name="SMSF_<?=$property['id']?>" <?=($property['smsf'])?"checked='checked'":"" ?>">
												<i data-swchon-text="ON" data-swchoff-text="OFF"></i>SMSF</label>
                                                
                                                <!--
<label class="toggle" >
												<input  type="checkbox" >
												<i data-swchon-text="ON" data-swchoff-text="OFF"></i>ipr ordered</label>
-->
                                                
                                                 <!--
<label class="toggle" >
												<input onclick="toggleOffline(this,'<?=$property['id']?>');" type="checkbox" name="Offline_<?=$property['id']?>" <?=($property['offline'])?"checked='checked'":"" ?>">
												<i data-swchon-text="ON" data-swchoff-text="OFF"></i>Offline</label>
-->
                                                
                                             </div>
                                            <?php
                                            }
                                            ?>
                                                </td>
											</tr>
                                            <?php
                                            }
                                            }
                                            else
                                            {
                                                $colspan_val = 5;
                                                if($selected_tab=="prepurchasedipr" || $selected_tab=="graded" || $selected_tab=="featured")
                                                    $colspan_val = 7;
                                                ?>
                                                <tr>
                                                    <td colspan="<?php echo $colspan_val;?>" style="text-align: center;"><strong>No properties were found</strong>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
										</tbody>
									</table>
                                    <div class="text-right">
                                    
    								<?php
                                    $startPage = 1;
                                    $disPages = 10;
                                    if($currentPage>10)
                                    {
                                        $startPage = ((floor($currentPage/10))*10)+1;
                                        $disPages = ($startPage + 10)-1;
                                        
                                    }
                                    
                                    if($currentPage == ($startPage-1))
                                    {
                                        $startPage = $startPage - 10;
                                        $disPages = $disPages - 10;
                                    }
//echo "<br>nopages==>".$noOFPages;
//echo "<br>currentpage==>".$currentPage;
//echo "<br>startpage==>".$startPage;                                    
//echo "<br>dispage==>".$disPages;
                                    
                                    if($disPages > $noOFPages)
                                    {
                                        if($noOFPages>10)
                                        {
                                            $startPage = $disPages - 9;
                                            $disPages = $noOFPages;
                                        }
                                        else
                                        {
                                            $startPage = 1;
                                            $disPages = $noOFPages;
                                        }    
                                    }
                                    
                                    
//echo "<br>startpage==>".$startPage;                                    
//echo "<br>dispage==>".$disPages;
                                    
                                    ?>
                                    <ul class="pagination pagination-sm">
    								<?php
                                    if(($currentPage-1)>0)
                                    {
                                    ?>
                                    <li>
    									<a href="<?=ADMIN_PATH?>property/index/<?php echo $status?>/<?=($currentPage-1).$searchQueryStr?>"><i class="fa fa-angle-left"></i></a>
    								</li>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    for($i=$startPage;$i<=$disPages;$i++)
                                    {
                                    ?>
                                    <li class="<?=(($i==$currentPage)?"active":"")?>">
    									<a  href="<?=ADMIN_PATH?>property/index/<?php echo $status?>/<?=($i).$searchQueryStr;?>"><?=$i?></a>
    								</li>
    								<?php
                                    }
                                    ?>
                                    <?php
                                    if(($currentPage+1)<=$noOFPages)
                                    {
                                    ?>
                                    
    								<li>
    									<a href="<?=ADMIN_PATH?>property/index/<?php echo $status?>/<?=($currentPage+1).$searchQueryStr;?>"><i class="fa fa-angle-right"></i></a>
    								</li>
                                    <?php
                                    }
                                    ?>
    							</ul>
									</div>
								</div>
							</div>
							<!-- end widget content -->

						</div>
						<!-- end widget div -->

					</div>
					<!-- end widget -->

				</article>
			</div>

			<!-- end row -->

			<!-- row -->

			

			<!-- end row -->

		</section>
		<!-- end widget grid -->

	</div>
	<!-- END MAIN CONTENT -->

</div>
<?php
if(isset($anchor_id) && !empty($anchor_id))
{
?>
    <script type="text/javascript">
        function call_scroll()
        {
            window.location.hash="<?php echo $anchor_id; ?>";
        }
        
        setTimeout('call_scroll();',500);
            
    </script>
<?php
}
?>        