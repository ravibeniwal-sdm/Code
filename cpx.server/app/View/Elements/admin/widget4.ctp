<div class="jarviswidget jarviswidget-color-darken" id="wid-id-4" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-deletebutton="false" data-widget-colorbutton="false">
						
		<header style="height:45px !important;">
            <h2 style="width: auto;"><strong>Vendor</strong> <i> Finance</i> </h2>
          
              
              <div class="pull-right custom-toolbar col-md-1 "> 
				
                <div style="margin-top: 0px;height: 17px;"><?php echo $vendor_finance_weightage; ?>%</div>
                
                <div class="progress" rel="tooltip" data-original-title="<?php echo $vendor_finance_weightage; ?>%" data-placement="bottom">
					<div class="progress-bar progress-bar-success" role="progressbar" style="width: <?php echo !($vendor_finance_value) ? 10 : 100 ?>%"></div>
				</div>
                
		      </div>
              
              
		</header>
       
        
		<!-- widget div-->
		<div>

			<!-- widget content -->
            <?php 
                $vendor_finance_default_text = "<p>Please type here the terms of Vendor Finance you offer</p>

<p>&nbsp;</p>

<p>Example:</p>

<p>90% lend of the purchase price on un-exchange contracts only for local residents</p>

<p>5.00% fixed interest rate (comparison rate 5.17% NSW. Comparison rate of 5.19% QLD ) for up to 2 years</p>

<p>No early discharge penalty fees</p>

<p>No valuation fees</p>

<p>No mortgage insurance payable</p>

<p>No brokerage fees</p>

<p>Pre-payment of interest allowed with no penalty</p>

<p>Lump sum principal reductions with no penalty</p>";
                
                $vendor_finance_text = '';
                if(!empty($propertyInfo['vendor_finance_terms']))
                {
                    $vendor_finance_text = $propertyInfo['vendor_finance_terms'];
                    
                }
                
                ?>
			<div class="widget-body no-padding" style="margin-left: 0px;margin-bottom: 20px;">
                
				<textarea name="vendor_finance_terms" id="vendor_finance_terms"  placeholder='<?php echo $vendor_finance_default_text;?>'>
                    <?php echo $vendor_finance_text;?>
                </textarea>

			</div>
			<!-- end widget content -->

		</div>
		<!-- end widget div -->

	</div>