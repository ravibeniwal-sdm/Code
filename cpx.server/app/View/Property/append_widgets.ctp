<script language="javascript" type="text/javascript">
function call_preview()
{
    id = $('#id').val();
    
    var instance = CKEDITOR.instances['vendor_finance_terms'];
    
    var vendor_finance_terms_val_serialized = '';
    
    if(instance)
    {
        CKEDITOR.instances['vendor_finance_terms'].updateElement();
        vendor_finance_terms_val_serialized =  $('#vendor_finance_terms').serialize();
    }
   
   var data = $('#propertyAppend').serialize() + '&' + $('.fileupload').serialize() + '&' + vendor_finance_terms_val_serialized;
   
    $.ajax({
            url: '<?=ADMIN_PATH?>/property/append/'+id+'/true/true',
            cache: false,
            type: 'POST',
            dataType: "json",
            data : data,
            success: function (data) {
                if(data.success)
                {
                 
                 //alert("Done");
                  previewurl = "<?=WEB_PATH?>#!/details/preview_"+id
                  window.open(previewurl,'_blank');  
                }         
            }
        });
}

function callApi()
{
    review_id = $('#review_id').val();
    property_id = $('#property_id').val();
    
    if(review_id == '')
    {
        $('#reviewid_error').show();
                
        return false;        
    }
    else
    {
        
        $.ajax({
            url: '<?=ADMIN_PATH?>/property/fetchApi/'+review_id+'/'+property_id ,
            cache: false,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                
                if(data.status)
                {
                    $('#iprTable tbody').prepend(data.output);
                    $('#review_id').val('');
                }
                else
                {
                    $('#reviewid_notfound_error').show();
                    $('#reviewid_notfound_error').html(data.message);
                    return false;        
                }                    
            }
        });
    }        
}

function removeIpr(ele)
{
    $(ele).parent().parent().remove();
}

function redirectpage(id)
{
    window.location.href='<?=ADMIN_PATH?>property?prop_name_id_add='+id+'&search_done=1';
}

function setSavingVal(listed_price)
{
    
    saving_val = $('#saving_val').val();
    
    if(saving_val !=0)
    {
    $('#cpx_saving_cal').show();    
    }else
    {
        $('#cpx_saving_cal').hide();
    }
    
    
    $('#cpxprice_div').show();
    $('#savingprice_div').show();
    
    pricetype = $('#pricetype').val();
    
    if(pricetype == '$')
    {
        saving_val = $('#saving_val').val();
        
        cpx_val =  parseInt(listed_price) - parseInt(saving_val);
        
        $('#label_saving').html('$'+saving_val);
        $('#label_cpx').html('$'+cpx_val);
        $('#cpxprice_val').val(cpx_val);
        $('#savingprice_val').val(saving_val);
        
        
    }
    else if(pricetype == '%')
    {
        saving_val = $('#saving_val').val();
        
        saving_val =  (parseInt(listed_price) * parseInt(saving_val))/100;
        
        cpx_val =  parseInt(listed_price) - parseInt(saving_val);
        
        $('#label_saving').html('$'+saving_val);
        $('#label_cpx').html('$'+cpx_val);
        $('#cpxprice_val').val(cpx_val);
        $('#savingprice_val').val(saving_val);
    }        
}

$(function() 
 {   $( "#estimated_completion_date" ).datepicker({
         changeMonth:true,
         changeYear:true,
         yearRange:"-100:+0",
         dateFormat:"dd/mm/yy" });
       
 });

</script>

<style>
div.ui-datepicker-header 
a.ui-datepicker-prev,div.ui-datepicker-header 
a.ui-datepicker-next
{
    display: none;  
}
.custom-toolbar .progress {height: 16px !important;}
.invalid,.error{color: red;}
</style>
<?php

$name = $lot_no = $sub_no = $street_no = $street = $suburb = $city = $state = $postcode = '';
                                                        
$name = !empty($propertyInfo['name']) ? $propertyInfo['name'].' - ' : '';

$lot_no = !empty($propertyInfo['address'][0]['LotNumber']) ? $propertyInfo['address'][0]['LotNumber'] : '';
$sub_no = !empty($propertyInfo['address'][0]['subNumber']) ? ' '.$propertyInfo['address'][0]['subNumber'] : '';

if(!empty($propertyInfo['address'][0]['subNumber']) && !empty($propertyInfo['address'][0]['StreetNumber'])) 
    $street_no = '/'.$propertyInfo['address'][0]['StreetNumber'];

if(empty($propertyInfo['address'][0]['subNumber']) & !empty($propertyInfo['address'][0]['StreetNumber']) )
    $street_no = ' '.$propertyInfo['address'][0]['StreetNumber'];

$street = !empty($propertyInfo['address'][0]['street']) ? ' '.$propertyInfo['address'][0]['street'] : '';
$suburb = !empty($propertyInfo['address'][0]['suburb']['text']) ? ', '.$propertyInfo['address'][0]['suburb']['text'] : '';
$city = !empty($propertyInfo['address'][0]['city']) ? ' '.$propertyInfo['address'][0]['city'] : '';
$state = !empty($propertyInfo['address'][0]['state']) ? ' '.$propertyInfo['address'][0]['state'] : '';
$postcode = !empty($propertyInfo['address'][0]['postcode']) ? ' '.$propertyInfo['address'][0]['postcode'] : '';


?>

<script language="javascript">
$(window).bind("load", function() { 
   // alert("hi in");
    
    $('#propertyAppend').validate(
      {
        rules:
        {
          "contract_of_sale":{ required:true,
                               depends: function(element) {
                                   return $('#AgreementDoc_name').val().length > 0 
                                        }
          
           }
        },
        messages:
        {
          "contract_of_sale":
          {
            required:"Please select type of Contract of Sale"
          }
        },
        errorPlacement: function(error, element) 
        {
            if ( element.is(":radio") && 0 ) 
            {
                error.appendTo( element.parents('.container') );
            }
            else 
            { // This is the default behavior 
                error.insertBefore( element.parents(".radiaobutton") );
            }
         }
      });
    
  });
  
  function removeFile()
  {
     
    $("input:radio[name='contract_of_sale']").each(function(i) {
       this.checked = false;
        });
    
    return true;
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
					<li>Home</li><li>Append property details - <?php echo $name.$lot_no.$sub_no.$street_no.$street.$suburb.$city.$state.$postcode; ?></li>
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
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-12">
				<h1 class="page-title txt-color-blueDark">
                    <i class="fa fa-table fa-fw "></i> 
                      
						Append property details - <?php echo $name.$lot_no.$sub_no.$street_no.$street.$suburb.$city.$state.$postcode; ?>
					
                </h1>
			</div>
		</div>
        
        
        <?php
            if(isset($success_msg) && !empty($success_msg))
            {
        ?>
        <div class="row">
            <div class="alert alert-success fade in">
    			<button class="close" data-dismiss="alert">
    				×
    			</button>
    			<i class="fa-fw fa fa-check"></i>
    			<?php echo $success_msg; ?>
    		</div>
         </div>   
      <?php
            }
        ?>
        
        <?php echo $this->element('admin/completeness_status'); ?>
        
        <form class=""  id="propertyAppend" method="post" action="<?=ADMIN_PATH?>property/append/<?=$propertyInfo['id']?>" enctype="multipart/form-data">
        
        
		<!-- widget grid -->
		<section id="widget-grid" class="">
            
			<!-- row -->
			<div class="row">
                
                <!-- NEW WIDGET START -->
				
                     
                    <?php
                    if($widget_id == 'wid-id-0')
                    {
                    ?>
                    <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6" >
					<!-- Widget ID (each widget will need unique ID)-->
					   <?php echo $this->element('admin/widget0'); ?>  
                    </article>
					<!-- end widget -->
                	<?php
                    }
                    else if($widget_id == 'wid-id-2')
                    {
                    ?>

				
                    <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6" >
					<!-- Widget ID (each widget will need unique ID)-->
					   <?php echo $this->element('admin/widget2'); ?>
                    </article>
					<!-- end widget -->
                    
                    <?php
                    }
                    else if($widget_id == 'wid-id-1')
                    {
                    ?>
				

					<article class="col-xs-12 col-sm-6 col-md-6 col-lg-6" >
                 
                        <?php echo $this->element('admin/widget1'); ?>
                    </article>
                <?php
                    }
                    else if($widget_id == 'wid-id-3')
                    {
                    ?>
                    
                    <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6" >
                        <?php echo $this->element('admin/widget3'); ?>
                    </article>
               <?php
                    }
                    elseif($widget_id == 'wid-id-4')
                    {
                    ?>
                    
                    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
					<!-- Widget ID (each widget will need unique ID)-->
					   <?php echo $this->element('admin/widget4'); ?>
					<!-- end widget -->
                    </article>
			
                    <?php
                    }
                    else if($widget_id == 'wid-id-5')
                    {
                    ?>
				
                    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
					<!-- Widget ID (each widget will need unique ID)-->
					   <?php echo $this->element('admin/widget5'); ?>
                    </article>
					<!-- end widget -->
                    <?php
                    }
                    
                    ?>
                    
				
				<!-- WIDGET END -->

				

				

			</div>

            <input type="hidden" name="searchQueryStr" value="<?php echo $searchQueryStr; ?>" />
            
            <input type="hidden" name="property_id" id="property_id" value="<?php echo $propertyInfo['property_id']; ?>" />
            <input type="hidden" name="id" id="id" value="<?php echo $propertyInfo['id']; ?>" />
            
            <input type="hidden" name="widget_id" value="<?php echo $widget_id; ?>" />
            
            <input style="float: left;margin-right: 5px;" class="btn  btn-default" type="button" onclick="redirectpage('<?=$propertyInfo['id']?>');" value="Cancel" />
            <input style="float: left;margin-right: 5px;" class="btn btn-primary " type="submit" name="save_type" value="Save" />
            <?php
            if($widget_id != 'wid-id-0')
            {
            ?>
                <input style="float: left;margin-right: 5px;" class="btn btn-primary " type="submit" name="save_type" value="Save & previous" />
                
            <?php
            }
            
            if($widget_id != 'wid-id-5')
            {
            ?>
                <input style="float: left;margin-right: 5px;" class="btn btn-primary " type="submit" name="save_type" value="Save & next" />
             <?php
            }
            
            ?>            
           
			<!-- end row -->

			
		</section>
        
         </form>
		<!-- end widget grid -->

	</div>
			<!-- END MAIN CONTENT -->

</div>

<!-- PAGE RELATED PLUGIN(S) -->
<script src="<?=JS_PATH?>/plugin/ckeditor/ckeditor.js"></script>


<script language="javascript">
$(document).ready(function(){
	 $('.search_remove_param').click(function() {
 		var getID = this.id;
 		var fieldToRemove = getID.substring(7);
 		$('#AgreementRemoveCriteria,#DealRemoveCriteria,#ProjectRemoveCriteria').val(fieldToRemove);
 		$('#form_agreement_search,#form_deal_search,#form_project_search').submit();
 		
 		return false;
 	});

<?php
if($widget_id=="wid-id-4")
{
?>
    
// DO NOT REMOVE : GLOBAL FUNCTIONS!
CKEDITOR.config.toolbar = [
   
   ['Bold','Italic','Underline','-','Undo','Redo','-','Cut','Copy','Paste','-','Outdent','Indent'],
   
   ['NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
  
] ;

CKEDITOR.replace( 'vendor_finance_terms', { height: '380px', width:'auto' ,startupFocus : false,extraPlugins: 'confighelper'} );
<?php
}
?>    
    
	
});

function checkSessionForAjax(data){
	//alert('here');
	
	if (data !== undefined){
		var CP_id = data.split('|');
		var session_msg = CP_id[0];
		if(session_msg == 'SESSION_EXPIRED'){
		var session_url = CP_id[1];
		 window.location.assign(session_url)
		}
	}
}
//function ErrorCheckSessionPostAjax(XMLHttpRequest, textStatus, errorThrown){
//	alert(XMLHttpRequest + ' textStatus:' + textStatus + ' errorThrown: ' + errorThrown);
//}
</script>