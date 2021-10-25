<div class="jarviswidget jarviswidget-color-darken" id="wid-id-3" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-deletebutton="false" data-widget-colorbutton="false">
						
   <header style="height:45px !important;">
        <h2 style="width: auto;"><strong>Contact</strong> <i> details</i> </h2>
        
          
          <div class="pull-right custom-toolbar col-md-2 "> 
			
            <div style="margin-top: 0px;height: 17px;"><?php echo $contact_details_weightage; ?>%</div>
            
            <div class="progress" rel="tooltip" data-original-title="<?php echo $contact_details_weightage; ?>%" data-placement="bottom">
				<div class="progress-bar progress-bar-success" role="progressbar" style="width: <?php echo !($contact_details_value) ? 10 : 100 ?>%"></div>
			</div>
            
	      </div>
          
          
	</header>
    
	<!-- widget div-->
	<div>

		<!-- widget content -->
		<div class="widget-body no-padding">
        <div class="custom-scroll table-responsive">
			<table id="contactTable" class="table table-bordered">
            
            <thead>
            <tr>
                    <th></th>
                    <th>Append</th>
                    <th>Emails</th>
                    <th>Display</th>
                </tr>
            </thead>
            <tbody>
            	
				<?php
                if(isset($propertyInfo['contact']) && !empty($propertyInfo['contact']))
                {
                    foreach($propertyInfo['contact'] as $key=>$contacts)
                    {
                        if($contacts['type'] == 'listingAgent')
                        {
                        ?>
                        
                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <td style="text-align: center;"><strong>Primary</strong></td>
                                        
                                    </tr>
                                    
                                    
                                    <?php 
                                        if (!empty($contacts['name']))
                                        {
                                    ?>
                                        <tr>
                                            <td><strong>Contact:</strong> </td>
                                            
                                        </tr>
                                        <tr>
                                            <td><?php echo $contacts['name']; ?></td>
                                        </tr>
                                    <?php
                                        }
                                        
                                        if (!empty($contacts['email']))
                                        {
                                    ?>
                                         <tr>
                                            <td><strong>Email:</strong> </td>
                                            
                                        </tr>
                                        <tr>
                                            <td><?php echo $contacts['email']; ?></td>
                                        </tr>
                                    <?php
                                        }

                                        if(is_array($contacts['telephone']))
                                        {
                                            foreach($contacts['telephone'] as $tel)
                                            {
                                                if (!empty($tel['telephone']))
                                                {
                                                ?>
                                                    <tr>
                                                        <td><strong><?php echo $tel['telephoneType']; ?>:</strong> </td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td><?php echo $tel['telephone']; ?></td>
                                                    </tr>
                                                <?php
                                                }
                                            }
                                        }
                                        else
                                        {
                                            if (!empty($contacts['telephone']))
                                            {
                                        ?>
                                             <tr>
                                                <td><strong>Mobile:</strong> </td>
                                                
                                            </tr>
                                            <tr>
                                                <td><?php echo $contacts['telephone']; ?></td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                    ?>
                                </table>
                                
                            </td>
                            <td>
                                <?php 
                                    if(isset($contacts['append_val']) && $contacts['append_val'])
                                    {
                                    ?>
                                    <input type="checkbox"  name="append_val[<?php echo $key;?>]" checked="checked" onchange="changeUpdateDoneValue();"/>
                                    <?php
                                    }
                                    elseif(isset($contacts['append_val']) && !$contacts['append_val'])
                                    {
                                    ?>
                                    <input type="checkbox"  name="append_val[<?php echo $key;?>]" onchange="changeUpdateDoneValue();"/>
                                    <?php
                                    }
                                    elseif(!isset($contacts['append_val']))
                                    {
                                        ?>
                                        <input type="checkbox"  name="append_val[<?php echo $key;?>]" checked="checked" onchange="changeUpdateDoneValue();"/>
                                        <?php
                                    }
                            ?>
                            </td>
                            <td>
                            <?php 
                                if(isset($contacts['emails_val']) && $contacts['emails_val'])
                                {
                                ?>
                                <input type="checkbox"  name="emails_val[<?php echo $key;?>]" checked="checked" onchange="changeUpdateDoneValue();"/>
                                <?php
                                }
                                elseif(isset($contacts['emails_val']) && !$contacts['emails_val'])
                                {
                                ?>
                                <input type="checkbox"  name="emails_val[<?php echo $key;?>]" onchange="changeUpdateDoneValue();"/>
                                <?php
                                }
                                elseif(!isset($contacts['emails_val']))
                                {
                                    ?>
                                    <input type="checkbox"  name="emails_val[<?php echo $key;?>]" checked="checked" onchange="changeUpdateDoneValue();"/>
                                    <?php
                                }
                            ?>
                                
                            </td>
                            <td>
                            <?php 
                                    if(isset($contacts['display_val']) && $contacts['display_val'])
                                    {
                                    ?>
                                    <input type="checkbox"  name="display_val[<?php echo $key;?>]" checked="checked" onchange="changeUpdateDoneValue();"/>
                                    <?php
                                    }
                                    elseif(isset($contacts['display_val']) && !$contacts['display_val'])
                                    {
                                    ?>
                                    <input type="checkbox"  name="display_val[<?php echo $key;?>]" onchange="changeUpdateDoneValue();"/>
                                    <?php
                                    }
                                    elseif(!isset($contacts['display_val']))
                                    {
                                        ?>
                                        <input type="checkbox"  name="display_val[<?php echo $key;?>]" checked="checked" onchange="changeUpdateDoneValue();"/>
                                        <?php
                                    }
                            ?>
                                
                            </td>
                        
                            
                        </tr>
                        <?php
                        }
                            
                    }
                    foreach($propertyInfo['contact'] as $key=>$contacts)
                    {
                        if($contacts['type'] == 'vendorDetails')
                        {
                        ?>
                        
                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <td style="text-align: center;"><strong>Owner</strong></td>
                                        
                                    </tr>
                                    
                                    
                                    <?php 
                                        if (!empty($contacts['name']))
                                        {
                                    ?>
                                        <tr>
                                            <td><strong>Contact:</strong> </td>
                                            
                                        </tr>
                                        <tr>
                                            <td><?php echo $contacts['name']; ?></td>
                                        </tr>
                                    <?php
                                        }
                                        
                                        if (!empty($contacts['email']))
                                        {
                                    ?>
                                         <tr>
                                            <td><strong>Email:</strong> </td>
                                            
                                        </tr>
                                        <tr>
                                            <td><?php echo $contacts['email']; ?></td>
                                        </tr>
                                    <?php
                                        }

                                        if(is_array($contacts['telephone']))
                                        {
                                            foreach($contacts['telephone'] as $tel)
                                            {
                                                if (!empty($tel['telephone']))
                                                {
                                                ?>
                                                    <tr>
                                                        <td><strong><?php echo $tel['telephoneType']; ?>:</strong> </td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td><?php echo $tel['telephone']; ?></td>
                                                    </tr>
                                                <?php
                                                }
                                            }
                                        }
                                        else
                                        {
                                            if (!empty($contacts['telephone']))
                                            {
                                        ?>
                                             <tr>
                                                <td><strong>Mobile:</strong> </td>
                                                
                                            </tr>
                                            <tr>
                                                <td><?php echo $contacts['telephone']; ?></td>
                                            </tr>
                                        <?php
                                            }
                                        }
                                    ?>
                                </table>
                                
                            </td>
                            <td>
                                    <input type="checkbox"  name="append_val[<?php echo $key;?>]" <?php echo (isset($contacts['append_val']) && $contacts['append_val']) ? 'checked' : '' ; ?> onchange="changeUpdateDoneValue();"/>
                            </td>
                            <td>
                            <?php 
                                if(isset($contacts['emails_val']) && $contacts['emails_val'])
                                {
                                ?>
                                <input type="checkbox"  name="emails_val[<?php echo $key;?>]" checked="checked" onchange="changeUpdateDoneValue();"/>
                                <?php
                                }
                                elseif(isset($contacts['emails_val']) && !$contacts['emails_val'])
                                {
                                ?>
                                <input type="checkbox"  name="emails_val[<?php echo $key;?>]" onchange="changeUpdateDoneValue();"/>
                                <?php
                                }
                                elseif(!isset($contacts['emails_val']))
                                {
                                    ?>
                                    <input type="checkbox"  name="emails_val[<?php echo $key;?>]" checked="checked" onchange="changeUpdateDoneValue();"/>
                                    <?php
                                }
                            ?>
                                
                            </td>
                            <td>
                            <input type="checkbox"  name="display_val[<?php echo $key;?>]" <?php echo (isset($contacts['display_val']) && $contacts['display_val']) ? 'checked' : '' ; ?> onchange="changeUpdateDoneValue();"/>
                                
                            </td>
                        
                            
                        </tr>
                        <?php
                        }
                            
                    }
                    
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