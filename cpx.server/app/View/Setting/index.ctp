
<style>
.action-btn > a {
    margin-bottom: 1px;
    
}

.non-selected-btn {
    background-color: lightgrey;
    border-color: lightgrey;
    color: black;
}

.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 5px 10px;
}

#sparks li h5
{
    text-transform: none !important;
}
</style>
<style>
.ui-dialog .ui-dialog-title 
{
    color: red;
    font-weight: bold;
    font-size: 16px;
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

@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

    .submitbtn{
        margin-right: 0px !important;
    }
    
}

</style>
<script language="javascript">

function reset_search()
{
    $('#search').val('');
    
    $('#search_setting_form').submit();
}

function toggleActivate(ele,id,agentid)
{
    total_live_properties = $('#total_live_properties').val();
    $.ajax({
        url: '<?=ADMIN_PATH?>setting/toggleStatus/status/'+id+'/'+total_live_properties+'/'+agentid ,
        cache: false,
        type: 'POST',
        dataType: 'json',
        error: function (data) {
                checkSessionForAjax(data);
            },
        success: function (data) {
            if(data.value == false)
               $('#purge_btn_'+id).show();
            else if(data.value == true)
               $('#purge_btn_'+id).hide();         
            
            $('#total_live_properties').val(data.total_live_properties);
            
            value_span_total_live_properties = '<i class="fa fa-globe"></i>&nbsp;'+data.total_live_properties;
            $('#span_total_live_properties').html(value_span_total_live_properties);
                        
        }
    });
    ele.preventDefault();
    return false;
    
}


function confirm_purge(link)
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
			<li>Home</li><li>Publishers</li>
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
				<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-home"></i> Settings <span>&gt; Publishers</span></h1>
			</div>
			
            <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8 smart-form" >
            <section class="col col-9" style="float: right;" >
                                                   
                <section class="col col-3">
    				<ul id="sparks" class="">
                        <li class="sparks-info">
    						<h5> Live properties <span id="span_total_live_properties"><i class="fa fa-globe"></i>&nbsp;<?php echo $total_live_properties ?></span></h5>
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
        
                                
		<!-- widget grid -->
		<section id="widget-grid" class="">

			<!-- row -->
			<div class="row">
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
						<header>
							
							

						</header>

						<!-- widget div-->
						<div>

							<!-- widget content -->
                            
							<div class="widget-body">
								
                                <div class="table-responsive">
                                
                                <form class="smart-form" id="search_setting_form" method="post" action="<?=ADMIN_PATH?>setting/">
                                
                                        <fieldset>
                                        	<div class="row">
                                            
                                                <section class="col col-6">
                                                    <section class="col col-4">
    													<label class="input"  >
                                                            <strong>Publisher ID/email </strong>
    													</label>
    												</section>
                                                    <section class="col col-8">
    													<label class="input">
    														<input  type="text" id="search" name="search"  value="<?php echo !empty($searchtxt) ? $searchtxt : '' ?>"/>
    													</label>
    												</section>
                                                   </section> 
                                                   
                                               </div>
                                                
                                            </fieldset>
                                            
                                            <footer>
                                            
												<button type="submit" class="btn btn-primary  submitbtn" >
													Search
												</button>
												<button type="button" class="btn btn-default " onclick="reset_search();">
													Reset
												</button>
                                        
                                       
									   </footer>
									
                                </form> 
                                
								</div>
                                
                                
                                
								<div class="custom-scroll table-responsive">
								
									<table class="table table-bordered">
										<thead>
											<tr>
												<th>Publisher email</th>
                                                <th>Total properties</th>
                                                <th>Action</th>
											</tr>
										</thead>
										<tbody>
                                            <?php 
//                                                    echo "<pre>";
//                                                    print_r($publisherList);
//                                                    echo "</pre>";
                                            
                                            foreach($publisherList as $publishers)
                                            {
                                                
                                                 if(!empty($publishers['agentID']))
                                                 {
                                            ?>
                                            
											<tr>
												<td>
                                                <div style="margin-top: 10px;">
                                                <strong>Default: </strong><?php echo $publishers['agentID']; ?><br /><br />
                                                </div>
                                                </td>
												
                                                <td style="width: 130px; " >
                                                <div style="margin-top: 10px;text-align: center;">
                                                    <?php echo $publishers['total_properties']; ?>
                                                </div>
                                                </td>
                                                
                                                <td style="width: 100px; " >
                                                    <div class="action-btn smart-form" style="padding-right: 15px;margin-top: 10px;" >    
                                                    
                                                    <?php
                                                    $display_status = 'none';
                                                    if(!$publishers['status'])
                                                    {
                                                        $display_status = 'block';
                                                    }   
                                                    
                                                    $purge_link = ADMIN_PATH.'setting/index/'.$currentPage.'/'.$publishers['agentID'];
                                                    ?>
                                                    
                                                    <a id="purge_btn_<?=$publishers['id']?>" href="javascript:void(0);" class="btn btn-purge container-full" style="margin-top: 5px; display:<?php echo  $display_status; ?>;" onclick="confirm_purge('<?=$purge_link?>',false);">Purge </a><br />
                                                    
                                                    
                                                    <label class="toggle" >
    													<input onclick="return toggleActivate(this,'<?=$publishers['id']?>','<?=$publishers['agentID']?>');" type="checkbox" name="Activate_<?=$publishers['id']?>" <?=($publishers['status'])?"checked='checked'":"" ?>"><i data-swchon-text="ON" data-swchoff-text="OFF"></i>Published
                                                    </label>
                                                    <input type="hidden" name="total_live_properties" id="total_live_properties" value="<?php echo $total_live_properties; ?>" />
                                                    </div> 
                                               
                                                </td>
											</tr>
                                            <?php
                                                }
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
                                    ?>
                                    <ul class="pagination pagination-sm">
    								<?php
                                    if(($currentPage-1)>0)
                                    {
                                    ?>
                                    <li>
    									<a href="<?=ADMIN_PATH?>setting/index/<?=($currentPage-1)?>"><i class="fa fa-angle-left"></i></a>
    								</li>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    for($i=$startPage;$i<=$disPages;$i++)
                                    {
                                    ?>
                                    
                                    <li class="<?=(($i==$currentPage)?"active":"")?>">
    									<a  href="<?=ADMIN_PATH?>setting/index/<?=($i)?>"><?=$i?></a>
    								</li>
    								<?php
                                    }
                                    ?>
                                    <?php
                                    if(($currentPage+1)<=$noOFPages)
                                    {
                                    ?>
                                    
    								<li>
    									<a href="<?=ADMIN_PATH?>setting/index/<?=($currentPage+1)?>"><i class="fa fa-angle-right"></i></a>
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

		</section>
		<!-- end widget grid -->
	</div>
	<!-- END MAIN CONTENT -->
</div>