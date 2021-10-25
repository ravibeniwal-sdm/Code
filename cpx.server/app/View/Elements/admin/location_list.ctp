<thead>
	<tr>
        
        <th>ID</th>
        <th>Location</th>
        <th>Abbreviation</th>
        <th>IO</th>
        <th>PI</th>
        <th>Action</th>
	</tr>
</thead>
<tbody id="sortable-rows">
    <?php 
//                                                    echo "<pre>";
//                                                    print_r($locationsList);
//                                                    echo "</pre>";
    if(!empty($locationsList))
    {
    $i=0;        
    foreach($locationsList as $locations)
    {
        
    ?>
    
	<tr id="<?php echo $locations["id"]; ?>">
        
        
        
		<td style="width: 20px; " >
            <div style="margin-top: 10px;">
            <?=$locations['id']?>
            </div>
        </td>
		
        <td style="width: 200px; " >
        <div style="margin-top: 10px;text-align: center;word-break: break-word;">
            <?php 
               
                    echo $locations['name'];                          
                ?>
        </div>
        </td>
        <td style="width: 300px; " >
        <div style="margin-top: 10px;word-break: break-word;">
            <?php 
                echo $locations['abbreviation'];                         
                ?>
        </div>
        </td>
        <td style="width: 300px; " >
        <div style="margin-top: 10px;word-break: break-word;">
            <?php 
                echo (isset($locations['sponsors']['IO']['name']))?$locations['sponsors']['IO']['name']:"N/A";                         
                ?>
        </div>
        </td>
        
        <td style="width: 300px; " >
        <div style="margin-top: 10px;word-break: break-word;">
            <?php 
                echo (isset($locations['sponsors']['PI']['name']))?$locations['sponsors']['PI']['name']:"N/A";                         
                ?>
        </div>
        </td>
        
        
        
        <td style="width: 70px; " >
            <div class="action-btn smart-form" style="padding-right: 15px;margin-top: 10px;" >    
            
            <?php 
                $edit_link = ADMIN_PATH.'locations/edit/'.$locations['id'].'/'.$currentPage;
                
                $display_status = 'none';
                if(!$locations['status'])
                {
                    $display_status = 'block';
                }   
                
                $purge_link = ADMIN_PATH.'locations/index/'.$currentPage.'/'.$locations['id'];
            ?>
            
            <span style=" display:<?php echo  $display_status; ?>;" id="purge_btn_<?=$locations['id']?>">
                <a  href="javascript:void(0);" class="btn btn-purge container-full" style="margin-top: 5px;" onclick="confirm_purge('<?=$purge_link?>',false);">Purge </a><br />
            </span>
            
            <a  href="<?=$edit_link?>" class="btn btn-primary container-full" style="margin-top: 5px;">Edit </a><br />
            
            
            <label class="toggle" >
				<input onclick="return toggleActivate(this,'<?=$locations['id']?>');" type="checkbox" name="Activate_<?=$locations['id']?>" <?=($locations['status'])?"checked='checked'":"" ?>"><i data-swchon-text="ON" data-swchoff-text="OFF"></i>Active
            </label>
            
            <input type="hidden" name="total_live_properties" id="active_locations" value="<?php echo $active_locations; ?>" />
            </div> 
       
        </td>
	</tr>
    <?php
        $i++;    
    }
    }
    else
    {
        ?>
        <tr>
            <td colspan="4" style="text-align: center;"><strong>No locations were found</strong>
            </td>
        </tr>
        <?php
    }
    ?>
</tbody>