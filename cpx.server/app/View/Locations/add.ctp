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
.autocomplete-suggestions { border: 1px solid #999; background: #FFF; overflow: auto; }
.autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
.autocomplete-selected { background: #F0F0F0; }
.autocomplete-suggestions strong { font-weight: normal; color: #3399FF; }
.autocomplete-group { padding: 2px 5px; }
.autocomplete-group strong { display: block; border-bottom: 1px solid #000; }
</style>
<script language="javascript" type="text/javascript">
function make_disable(val)
{
    if(val == 'suburb')
    {
        $('.region_div').removeClass('disable');
        
    }
    else if(val == 'region')
    {
        $('.region_div').addClass('disable');
        
    }
}
function form_validation()
{
    
    location_val = $('#name').val();
  // alert($("input[name='name']:checked").val());

    if(!$("input[name='type']:checked").val())
    {
        $('#type_error').show();
                
        return false; 
    }
    else if((location_val == undefined))
    {
        $('#name_error').show();
                
        return false; 
    }    
    
    
    $('#add_form').submit();
}

function redirectpage()
{
    window.location.href='<?=ADMIN_PATH?>locations/';
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
					<li>Home</li><li>Add new locations</li>
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
				<h1 class="page-title txt-color-blueDark"><i class="fa fa-table fa-fw "></i> Add new locations</h1>
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
            <form id="add_form" class="customeUploadForm" method="post" action="<?=ADMIN_PATH?>locations/add">
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
                                 <span id="type_error" style="color: red; font-size: 11px;display: none;">Please select location type</span>
                                    <section class="col col-3">     
                                        <label class="input">Type</label>
                                    </section>
                                    
                                    <section class="col col-9 ">
                                    
                                        <span class="col-6">
                                          Region  <input type="radio" name="type" id="type"  value="region" onclick="make_disable('region');" />
                                        </span>
                                        <span class="col-6">
                                          Suburb  <input type="radio" name="type" id="type" value="suburb" onclick="make_disable('suburb');" />
                                        </span>
                                        
                                    </section>
                                    
                                    
								</div>
                                
                               <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 smart-form region_div disable "  >
                                 <span id="type_error" style="color: red; font-size: 11px;display: none;">Please select location type</span>
                                    <section class="col col-3">     
                                        <label class="input">Region</label>
                                    </section>
                                    
                                    <section class="col col-9 ">
                                    
                                        <input class="form-control" type="text" name="region" id="region" placeholder="Enter Region" />
                                        <input type="hidden" name="region_abbreviation" id="region_abbreviation" />
                                        
                                    </section>
                                    
                                    
								</div>
                               
                               
                               <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 smart-form "  >
                                <span id="name_error" style="color: red; font-size: 11px;display: none;">Please enter location </span>
                                    <section class="col col-3">     
                                        <label class="input">Location</label>
                                    </section>
                                    
                                    <section class="col col-9  ">
                                    
                                        <span>
                                            <input class="form-control" type="text" name="name" id="name" placeholder="Enter Location" />
                                        </span>
                                        
                                    </section>
                                    
                                    
								</div>
                                
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 smart-form "  >
                                    <section class="col col-3">     
                                        <label class="input">Abbreviation </label>
                                    </section>
                                    
                                    <section class="col col-9">
                                    
                                        <span>
                                            <input class="form-control" type="text" name="abbreviation" id="abbreviation" placeholder="Enter Abbrevation" />
                                        </span>
                                        
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
            
            
            
            <input style="float: right;" class="btn btn-primary " type="button" onclick="form_validation();" value="Save" />
            <input style="float: right;margin-right: 5px;" class="btn btn-default" type="button" onclick="redirectpage();" value="Cancel" />
                
            </form>
			<!-- end row -->

			
		</section>
		<!-- end widget grid -->

	</div>
			<!-- END MAIN CONTENT -->

</div>
<script language="javascript">
var countries = <?=json_encode($locationsList);?>;

$('#region').autocomplete({
    source: countries,
    /*onSelect: function (suggestion) {
        alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
    }*/
    select: function (event, ui) {
               
                var value = ui.item.value;
                var data = ui.item.data;
                $("#region_abbreviation").val(data);
               //store in session
              //alert(data); 
            }
});

</script>