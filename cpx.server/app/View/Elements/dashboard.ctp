<script language="javascript">
function close_attention_msg(username)
{
    $('#attention_msg').hide();
    
    $.ajax({
        url: '<?=ADMIN_PATH?>/dashboard/close_attention_msg/'+username ,
        cache: false,
        type: 'POST',
        dataType: 'json',
        error: function (data) {

            },
        success: function (data) {
            
        }
    });
    ele.preventDefault();
    return true;
    
}
</script>

<div id="content">

	<div class="row">
		<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
			<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-home"></i> Dashboard <span></span></h1>
		</div>
		<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
			<ul id="sparks" class="">
				<li class="sparks-info">
					<!--
<h5> My Income <span class="txt-color-blue">$47,171</span></h5>
					<div class="sparkline txt-color-blue hidden-mobile hidden-md hidden-sm">
						1300, 1877, 2500, 2577, 2000, 2100, 3000, 2700, 3631, 2471, 2700, 3631, 2471
					</div>
-->
				</li>
			</ul>
		</div>
	</div>
    
    <?php
    if((!isset($logedinuser['0']['show_attention_user_msg'])) || (isset($logedinuser['0']['show_attention_user_msg']) && ($logedinuser['0']['show_attention_user_msg'])))
    {
    ?>
    <div id="attention_msg" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="padding-top: 10px;padding-bottom: 10px;margin-bottom: 20px;background:#ffffcc;border-color: #ffffab;">
        
            <div style="border-bottom: 1px solid;" >
            <div style="text-align: center;">
            <span style="font-weight: bold;font-size: 20px;">Attention first time user</span>
            <a style="float: right;" href="javascript:void(0);" onclick="$('#attention_msg').hide();" data-placement="bottom" data-original-title="Delete"><i class="fa fa-times"></i></a></div>
            </div>
            
            <div style="text-align: center;padding-top: 10px;padding-bottom: 10px;">
                <p>CentralPropertyExchange.com.au (CPx) allows property owners, developers and agents to advertise properties for FREE</p>
                <p>Properties can be published via multiple portals/ uploaders. For this reason CPx only provides the functions to 'append' ie only add extra information to your properties.</p>
                <p>CPx has an arrangement with PropertyCompass.com.au where you can list, mange and publish properties to CPx for free. Within CPx, you can append, manage and track your advertised properties.</p>
                <p>Please <a href="https://login.propertycompass.com.au/" target="_blank">click here</a> to open a FREE PropertyCompass.com.au account</p>
                <p>If you already have an account with a property listing portal/ uploader - <a href="javascript:void(0);" onclick="return close_attention_msg('<?=$logedinuser['0']['username']?>');">close this message</a></p>
            </div>
        
    </div>
    <?php
    }
    ?>
    
	<!-- widget grid -->
	<section id="widget-grid" class="">
            
			<!-- row -->
			<div class="row">
                
                <!-- NEW WIDGET START -->
				
                    <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6" >
					<!-- Widget ID (each widget will need unique ID)-->
					     <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-deletebutton="false" data-widget-colorbutton="false" >
                            <header>
        						<h2> My FREE listings </h2>
        					</header>
        
        					<!-- widget div-->
        					<div>
        						<div class="widget-body no-padding smart-form">
        							<!-- content goes here -->
                                    <div style="text-align: center;font-size: 16px;padding-top: 5px;padding-bottom: 5px;">
        							<span style="padding-right: 20px;"> Total (<small class="num-of-tasks"><a style="text-decoration: underline;" href="<?=ADMIN_PATH?>property/index/All/"><?php echo $countlisting;?></a></small>)</span>
        							<span> Offline (<small class="num-of-tasks"><a style="text-decoration: underline;" href="<?=ADMIN_PATH?>property/index/Offline/"><?php echo $countoffline;?></a></small>)</span>
                                    </div>
        							<!-- end content -->
        						</div>
        
        					</div>
                         </div>
                    </article>
					<!-- end widget -->
                	
                    <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6" >
					<!-- Widget ID (each widget will need unique ID)-->
					   <div class="jarviswidget jarviswidget-color-darken" id="wid-id-2" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-deletebutton="false" data-widget-colorbutton="false">
                            
                            <header>
        						<h2> My Featured listings </h2>
        					</header>
        
        					<!-- widget div-->
        					<div>
        
        						<div class="widget-body no-padding smart-form">
        							<!-- content goes here -->
        							<div style="text-align: center;font-size: 16px;padding-top: 5px;padding-bottom: 5px;">
        							<span> Total (<small class="num-of-tasks"><a style="text-decoration: underline;" href="<?=ADMIN_PATH?>property/index/Featured/"><?php echo $countfeatured;?></a></small>)</span>
        						
                                    </div>
        							<!-- end content -->
        						</div>
        
        					</div>
                            
                       </div>
                    </article>
					<!-- end widget -->

				<!-- WIDGET END -->

			</div>

			<!-- end row -->

		</section>
	<!-- end widget grid -->

</div>