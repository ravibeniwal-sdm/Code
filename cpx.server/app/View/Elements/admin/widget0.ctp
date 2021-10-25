<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-deletebutton="false" data-widget-colorbutton="false" >
						
			<header style="height:45px !important;">
                <h2 style="width: auto;"><strong>Property</strong> <i> for-sale-price</i> </h2>
                
                <div class="pull-right custom-toolbar col-md-2 "> 
					
                    <div style="margin-top: 0px;height: 17px;"><?php echo $property_for_sale_weightage; ?>%</div>
                    
                    <div class="progress" rel="tooltip" data-original-title="<?php echo $property_for_sale_weightage; ?>%" data-placement="bottom">
						<div class="progress-bar progress-bar-success" role="progressbar" style="width: <?php echo !($property_for_sale_value) ? 10 : 100 ?>%"></div>
					</div>
                    
			      </div>
			</header>
            
			<!-- widget div-->
			<div>

				<!-- widget content -->
				<div class="widget-body no-padding">
                    
                    <div style="margin-left: 10px;margin-right: 10px;margin-top: 10px;margin-bottom: 10px;border: 1px solid black;background-color: #ffffcc;">
                        <strong>Optional ‘Buyer Saving’:</strong>
                        <br />
                        If the property for-sale-price includes a real estate agent, 'selling-fee', you may opt to pass some or all the 'Selling-fee' directly to a buyer via a saving.
                        <br />
                        <ul style="list-style-type:none;padding-left: inherit;">
                        <li>1) If applicable CPx will advertise the property for-sale-price in the following manner:
                            <ul>
                             <li> <b>Listed price</b>: this is the property for-sale-price includes the Selling-fees</li>
                             <li> <b>CPx price</b>: this is the property for-sale-price less the Saving</li>
                             <li> <b>Savings</b>: this is the portion nominated on what the buyer can save</li>
                             </ul>
                        </li>                                     
                        <li>2) It is illegal in Australia to list/advertise the same property with different for-sale-prices.</li>
                        <li>3) Buyers are advised that the CPx price will be the declared contract buy/sold price</li>
                        </ul>
                    </div>
					
                    <div>
                        <?php 
                        if(isset($propertyInfo['viewprice']) && !empty($propertyInfo['viewprice']))
                        {                        
                        ?>                                                
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom: 10px;padding-left: 10px;">
                            <div style="padding-left: 0px;" class="col-xs-6 col-sm-6 col-md-6 col-lg-6" >Display Price (AUD)</div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" ><?php echo $propertyInfo['viewprice']; ?></div>                                                                            
                        </div>
                        <?php
                        }
                        ?>                                                
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom: 10px;padding-left: 10px;">
                            <div style="padding-left: 0px;" class="col-xs-6 col-sm-6 col-md-6 col-lg-6" >Listed Price (AUD)</div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" >$<?php echo $propertyInfo['listedprice']; ?></div>                                                                            
                        </div>
                                                            
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom: 10px;padding-left: 10px;" >
                            <div style="padding-left: 0px;" class="col-xs-6 col-sm-6 col-md-6 col-lg-6" >Saving (AUD)</div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" >
                                <select class="form-control" name="pricetype" id="pricetype" onchange="changeUpdateDoneValue();">
                                    <option value="$">$</option>
                                    <option value="%">%</option>
                                </select>
                                
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom: 10px;padding-left: 10px;" >
                            <div style="padding-left: 0px;" class="col-xs-6 col-sm-6 col-md-6 col-lg-6" ></div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" >
                               
                                <input class="form-control" type="text" name="saving_val" value="<?php echo !empty($propertyInfo['saving']) ? $propertyInfo['saving'] : '0' ; ?>" id="saving_val" onchange="setSavingVal('<?php echo $propertyInfo['listedprice']; ?>');changeUpdateDoneValue();" />
                                                                            
                            </div>
                        </div>
                        
                        <div style="display:<?=($propertyInfo['saving'] != 0)?"block":"none" ?> ;" id="cpx_saving_cal" >
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom: 10px;padding-left: 10px;">
                                <div style="padding-left: 0px;" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <strong>Will be displayed as shown below</strong>
                                </div>
                            </div>
                            
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom: 10px;padding-left: 10px;">
                                <div style="padding-left: 0px;" class="col-xs-6 col-sm-6 col-md-6 col-lg-6" >Listed Price </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" >$<?php echo $propertyInfo['listedprice']; ?></div>
                            </div>  
                                                                                  
                            <div  id="cpxprice_div" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-left: 10px;padding-bottom: 10px;display: <?php echo ($propertyInfo['saving'] > 0) ? 'block' : 'none' ?> ;">
                                <div style="padding-left: 0px;" class="col-xs-6 col-sm-6 col-md-6 col-lg-6" ><strong>CPx Price </strong></div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"  id="label_cpx"><?php echo !empty($propertyInfo['cpxprice']) ? '$'.$propertyInfo['cpxprice'] : '' ; ?>
                                </div>
                                <input type="hidden" value="<?php echo ($propertyInfo['listedprice']-$propertyInfo['saving']) ?>" name="cpxprice_val" id="cpxprice_val" />
                            </div>
                            
                            <div id="savingprice_div" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-left: 10px;padding-bottom: 10px;display:<?php echo ($propertyInfo['saving'] > 0) ? 'block' : 'none' ?> ;">
                                <div style="padding-left: 0px;" class="col-xs-6 col-sm-6 col-md-6 col-lg-6" >Saving </div>
                                <div  class="col-xs-6 col-sm-6 col-md-6 col-lg-6"  id="label_saving"><?php echo !empty($propertyInfo['saving']) ? '$'.$propertyInfo['saving'] : '$0' ; ?>
                                
                                </div>
                                <input type="hidden" value="<?php echo ($propertyInfo['saving']) ?>" name="savingprice_val" id="savingprice_val" />
                            </div>
                        </div>                                                                                                                         
                    </div>                                

					

				</div>
				<!-- end widget content -->

			</div>
			<!-- end widget div -->

		</div>