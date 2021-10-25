
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

.hide_ele{
    display: none;
}
tr:first-of-type td:first-of-type .up{
  display:none;
}
tr:first-of-type td:first-of-type .down{
  padding-left:17px;
}


tr:last-of-type td:first-of-type .down{
  display:none;
}
</style>
<script language="javascript">



function toggleActivate(ele,id)
{
    active_endorsements = $('#active_endorsements').val();
    $.ajax({
        url: '<?=ADMIN_PATH?>endorsements/toggleStatus/'+id,
        cache: false,
        type: 'POST',
        dataType: 'json',
        error: function (data) {
                checkSessionForAjax(data);
            },
        success: function (data) {
            if(!data.value)
               $('#purge_btn_'+id).show();
            else if(data.value)
               $('#purge_btn_'+id).hide();         
            
            
            $('#active_endorsements').val(data.active_endorsements);
            
            value_span_active_endorsements = data.active_endorsements;
            $('#span_active_endorsements').html(value_span_active_endorsements);                        
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
<script>
function updateDisplayOrder() {
    
    
    var selectedLanguage = new Array();
    $('tbody#sortable-rows tr').each(function() {
        selectedLanguage.push($(this).attr("id"));
    });
    var dataString = 'sort_order='+selectedLanguage;
        $.ajax({
            type: "POST",
            url: '<?=ADMIN_PATH?>endorsements/changeorder/<?=$currentPage?>',
            data: dataString,
            cache: false,
            error: function(data){alert("in error");},
            success: function(data){
                var resp = checkSessionForAjax(data);
                
                if(resp)
                {
                    $('#endorsements_list').html(data);
                    
                        $('.up,.down').click(function () {
                
                          var row = $(this).parents('tr:first');
                          if ($(this).is('.up')) {
                                row.insertBefore(row.prev());
                          }
                          else {
                                row.insertAfter(row.next());
                          }
                    });
                    
                    $('.order_bt').toggle();
                }
            }
        });
}


</script>

<div id="dialog-confirm-purge" style="display: none;" >
  <p style="font-size: 12px;color: red;">
    <span>Are you sure you want to purge ?</span>
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
			<li>Home</li><li>Endorsements</li>
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
				<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-home"></i> Settings <span>&gt; Endorsements</span></h1>
			</div>
			
            <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8 smart-form" >
            <section class="col col-9" style="float: right;" >
                
                <section class="col col-4" >          
                    <ul id="sparks" class="">                
    					<li class="sparks-info">
    						<h5> Active endorsements <span id="span_active_endorsements" style="text-align: center;" ><?php echo $active_endorsements; ?></span></h5>
    					</li>
                    </ul>
				</section>
                
                <section class="col col-4" >        
                    <ul id="sparks" class="">                         
    					<li class="sparks-info">
    						<h5> Total endorsements <span  style="text-align: center;" ><?php echo $total_endorsements ?></span></h5>
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
                                <div class="col col-12" style="float: right;">
                                    
                                    <a class="btn btn-primary col col-3 order_bt  " href="javascript:void(0);" onclick="$('.order_ele').toggle();$('.order_bt').toggle();" style="margin-bottom: 10px;">Change Order</a>             
                                    
                                    <span class="order_bt hide_ele">
                                    <a class="btn btn-primary col col-3 " href="javascript:void(0);" onclick="return updateDisplayOrder();" style="margin-bottom: 10px;" >Save Order</a>             
                                    </span>
                                    
                                    <a class="btn btn-primary col col-3" href="javascript:void(0);" onclick="window.location.href='<?=ADMIN_PATH?>endorsements/add'" style="margin-bottom: 10px;">Add new endorsement</a>                                                      
                                   
                                        
                                </div>
								
								<div class="custom-scroll table-responsive" >
								
									<table class="table table-bordered" id="endorsements_list">
										<?php echo $this->element('admin/endorsement_list'); ?>
									</table>
                                    <!--
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
    									<a href="<?=ADMIN_PATH?>endorsements/index/<?=($currentPage-1)?>"><i class="fa fa-angle-left"></i></a>
    								</li>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    for($i=$startPage;$i<=$disPages;$i++)
                                    {
                                    ?>
                                    
                                    <li class="<?=(($i==$currentPage)?"active":"")?>">
    									<a  href="<?=ADMIN_PATH?>endorsements/index/<?=($i)?>"><?=$i?></a>
    								</li>
    								<?php
                                    }
                                    ?>
                                    <?php
                                    if(($currentPage+1)<=$noOFPages)
                                    {
                                    ?>
                                    
    								<li>
    									<a href="<?=ADMIN_PATH?>endorsements/index/<?=($currentPage+1)?>"><i class="fa fa-angle-right"></i></a>
    								</li>
                                    <?php
                                    }
                                    ?>
    							</ul>
									</div>
-->
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

<script language="javascript" type="text/javascript">
$('.up,.down').click(function () {
    
      var row = $(this).parents('tr:first');
      if ($(this).is('.up')) {
            row.insertBefore(row.prev());
      }
      else {
            row.insertAfter(row.next());
      }
});

</script>