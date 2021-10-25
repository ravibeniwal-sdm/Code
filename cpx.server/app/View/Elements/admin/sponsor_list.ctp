<?php
//echo "<pre>";
//print_r($sponsorsList);
//echo "</pre>";
?>
<thead>
	<tr>
        
        <th>Icon</th>
        <th>Name</th>
        <th>Type</th>
        <th>Term</th>
        <th>Intrest Rate</th>
        <th>Action</th>
	</tr>
</thead>
<tbody id="sortable-rows">
    <?php 
//                                                    echo "<pre>";
//                                                    print_r($sponsorsList);
//                                                    echo "</pre>";
    if(!empty($sponsorsList))
    {
    $i=0;        
    foreach($sponsorsList as $sponsors)
    {
        
    ?>
    
	<tr id="<?php echo $sponsors["id"]; ?>">
        
        
        
		
		
        <td style="width: 20px; " >
        <div style="margin-top: 10px;">
            <?php 
                if(!empty($sponsors['logo']['0']['name']))
                {
                    $logo_path = IMAGE_UPLOAD_PATH.$sponsors['logo']['0']['path'];
                    ?>
                    <img src="<?php echo $logo_path; ?>" width="25" />
                    <?php
                }                                        
                ?>
        </div>
        </td>
        
        <td style="width: 200px; " >
            <div style="margin-top: 10px;">
            <?=$sponsors['sponsor_name']?>
            </div>
        </td>
        
        <td style="width: 50px; " >
        <div style="margin-top: 10px;word-break: break-word;">
            <?php 
                echo $sponsors['loan_type'];                         
                ?>
        </div>
        </td>
        <td style="width: 50px; " >
        <div style="margin-top: 10px;word-break: break-word;">
            <?php 
                echo $sponsors['term'];                         
                ?>
        </div>
        </td>
        <td style="width: 50px; " >
        <div style="margin-top: 10px;word-break: break-word;">
            <?php 
                echo $sponsors['intrest_rate'];                         
                ?>
        </div>
        </td>
        
        <td style="width: 70px; " >
            <div class="action-btn smart-form" style="padding-right: 15px;margin-top: 10px;" >    
            
            <?php 
                $edit_link = ADMIN_PATH.'sponsors/edit/'.$sponsors['id'].'/'.$currentPage;
                
                $display_status = 'none';
                if(!$sponsors['status'])
                {
                    $display_status = 'block';
                }   
                
                $purge_link = ADMIN_PATH.'sponsors/index/'.$currentPage.'/'.$sponsors['id'];
            ?>
            
            <span style=" display:<?php echo  $display_status; ?>;" id="purge_btn_<?=$sponsors['id']?>">
                <a  href="javascript:void(0);" class="btn btn-purge container-full" style="margin-top: 5px;" onclick="confirm_purge('<?=$purge_link?>',false);">Purge </a><br />
            </span>
            
            <a  href="<?=$edit_link?>" class="btn btn-primary container-full" style="margin-top: 5px;">Edit </a><br />
            
            
            <label class="toggle" style="<?=(isset($sponsors['default']) && $sponsors['default'])?"display:none":"" ?>" >

				<input onclick="return toggleActivate(this,'<?=$sponsors['id']?>');" type="checkbox" name="Activate_<?=$sponsors['id']?>" <?=($sponsors['status'])?"checked='checked'":"" ?> /><i data-swchon-text="ON" data-swchoff-text="OFF"></i>Active
            </label>
            
            <label class="toggle" >
				<input onclick="return toggleDefault(this,'<?=$sponsors['id']?>');"  type="radio" name="Default_<?=$sponsors['loan_type']?>" <?=(isset($sponsors['default']) && $sponsors['default'])?"checked='checked'":"" ?> /><i data-swchon-text="ON" data-swchoff-text="OFF"></i>Default
            </label>
            
            <input type="hidden" name="total_live_properties" id="active_sponsors" value="<?php echo $active_sponsors; ?>" />
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
            <td colspan="4" style="text-align: center;"><strong>No sponsors were found</strong>
            </td>
        </tr>
        <?php
    }
    ?>
</tbody>