<div class="jarviswidget jarviswidget-color-darken" id="wid-id-2" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-deletebutton="false" data-widget-colorbutton="false">
						
	<header style="height:45px !important;">
        <h2 style="width: auto;"><strong>Fractional</strong> <i> ownership</i> </h2>
        
          
          <div class="pull-right custom-toolbar col-md-2 "> 
			
            <div style="margin-top: 0px;height: 17px;"><?php echo $fractional_ownership_weightage; ?>%</div>
            
            <div class="progress" rel="tooltip" data-original-title="<?php echo $fractional_ownership_weightage; ?>%" data-placement="bottom">
				<div class="progress-bar progress-bar-success" role="progressbar" style="width: <?php echo !($fractional_ownership_value) ? 10 : 100 ?>%"></div>
			</div>
            
	      </div>
          
          
          
          
	</header>
    
    
	<!-- widget div-->
	<div>

		<!-- widget content -->
		<div class="widget-body no-padding" style="margin-left: 0px;margin-bottom: 20px;">

        <strong>DomaCom</strong>: Fractional property investment platform is the world's first regulated fractional property fund.
        <br />
        <br />
        Please select if your property has a 'title' and you want to make it available to DomaCom buyers <input type="checkbox" name="frac_ownership" <?php if(isset($propertyInfo['domacom']) && $propertyInfo['domacom']) echo 'checked'; else echo '' ; ?> style="vertical-align: top;" onchange="changeUpdateDoneValue();"/>
		</div>
		<!-- end widget content -->

	</div>
	<!-- end widget div -->

</div>