<div class="jarviswidget jarviswidget-color-darken" id="wid-id-5" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-deletebutton="false" data-widget-colorbutton="false">
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
		<header style="height:45px !important;">
            <h2 style="width: auto;"><strong>ipr</strong> <i> details</i> </h2>
            
              <div class="pull-right custom-toolbar col-md-1 "> 
				
                <div style="margin-top: 0px;height: 17px;"><?php echo $ipr_details_weightage; ?>%</div>
                
                <div class="progress" rel="tooltip" data-original-title="<?php echo $ipr_details_weightage; ?>%" data-placement="bottom">
					<div class="progress-bar progress-bar-success" role="progressbar" style="width: <?php echo !($ipr_details_value) ? 10 : 100 ?>%"></div>
				</div>
                
		      </div>
              
              
		</header>
        <div style="padding-bottom: 10px;">
			
            
            <fieldset>
						
				<div class="col-xs-9 col-sm-5 col-md-5 col-lg-5">
					
					
					
                        <input class="form-control" onfocus="$('#reviewid_error').hide();$('#reviewid_notfound_error').hide();" onkeydown="$('#reviewid_error').hide();$('#reviewid_notfound_error').hide();" type="text" name="review_id" id="review_id" />
				
                    <span id="reviewid_error" style="color: red; font-size: 11px;display: none;">Please enter review id</span>
                    <span id="reviewid_notfound_error" style="color: red; font-size: 11px;display: none;"></span>

				</div>
                <div class="col-xs-3 col-sm-7 col-md-7 col-lg-7 text-left" style="margin-top:-3px ;">
					
					
                    <a type="submit" href="javascript:void(0);" onclick="callApi();changeUpdateDoneValue();" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i></a>
				</div>
                
             </fieldset>           
            
		</div>
        
        <div style="padding-bottom: 10px;padding-left: 2px;border: 1px solid black;background-color: #ffffcc !important;">
            CPx governance: ipr and grade expire 95 days after published date.
        </div>
		<!-- widget div-->
		<div>

			<!-- widget content -->
			<div class="widget-body no-padding">
            
            <div class="custom-scroll table-responsive">
            
				<table id="iprTable" class="table table-bordered">
				<thead>
                <tr>
                        <th>Review Id</th>
                        <th>Grade</th>
                        <th>Score</th>
                        <th>Price Assessed</th>
                        <th>Rent / Lease</th>
                        <th>Publish Date</th>
                        <th>Days Old</th>
                        <th>Beds</th>
                        <th>Bath</th>
                        <th>Car</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                	
					<?php
                    if(isset($propertyInfo['iprs']['0']['results']) && !empty($propertyInfo['iprs']['0']['results']))
                    {
                        foreach($propertyInfo['iprs'] as $ipr)
                        {
                           //echo "<pre>";print_r($ipr); echo "</pre>";
                            $ipr = json_decode(json_encode($ipr));
                            echo $this->element("/admin/iprDetail",array('output'=>$ipr));
                        }
                    }
                    else
                    {
                        ?>
                        <tr>
                        <td colspan="11" style="text-align: center;"><strong>This property has NOT been graded</strong></td>
                        </tr>                                        
                        <?php
                    }
                    ?>
                </tbody>                                    
                    
				</table>
                </div>
			</div>
			<!-- end widget content -->

		</div>
		<!-- end widget div -->

	</div>