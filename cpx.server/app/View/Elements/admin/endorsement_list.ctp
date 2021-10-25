<thead>
	<tr>
        <th class="hide_ele order_ele"></th>
        <th>Order</th>
        <th>Logo/Text</th>
        <th>Url</th>
        <th>Action</th>
	</tr>
</thead>
<tbody id="sortable-rows">
    <?php 
//                                                    echo "<pre>";
//                                                    print_r($endorsementsList);
//                                                    echo "</pre>";
    if(!empty($endorsementsList))
    {
    $i=0;        
    foreach($endorsementsList as $endorsements)
    {
        
    ?>
    
	<tr id="<?php echo $endorsements["id"]; ?>">
        
        <td class="hide_ele order_ele" style="width: 40px; ">
            <span>                    
                <a class="up" href="javascript:void(0);"><span class="glyphicon glyphicon-arrow-up" style="padding-top: 13px;"></span></a>
            </span>                    

            <span>                                                
                <a class="down" href="javascript:void(0);"><span class="glyphicon glyphicon-arrow-down" style="padding-top: 13px;"></span></a>
            </span>                    

        </td>
        
		<td style="width: 20px; " >
            <div style="margin-top: 10px;">
            <?=$endorsements['order']?>
            </div>
        </td>
		
        <td style="width: 200px; " >
        <div style="margin-top: 10px;text-align: center;word-break: break-word;">
            <?php 
                if(!empty($endorsements['logo']['0']['name']))
                {
                    $logo_path = IMAGE_UPLOAD_PATH.$endorsements['logo']['0']['path'];
                    ?>
                    <img src="<?php echo $logo_path; ?>" width="100" />
                    <?php
                }
                elseif(!empty($endorsements['text']))
                    echo $endorsements['text'];                          
                ?>
        </div>
        </td>
        
        <td style="width: 300px; " >
        <div style="margin-top: 10px;word-break: break-word;">
            <?php 
                echo $endorsements['url'];                         
                ?>
        </div>
        </td>
        
        <td style="width: 70px; " >
            <div class="action-btn smart-form" style="padding-right: 15px;margin-top: 10px;" >    
            
            <?php 
                $edit_link = ADMIN_PATH.'endorsements/edit/'.$endorsements['id'].'/'.$currentPage;
                
                $display_status = 'none';
                if(!$endorsements['status'])
                {
                    $display_status = 'block';
                }   
                
                $purge_link = ADMIN_PATH.'endorsements/index/'.$currentPage.'/'.$endorsements['id'];
            ?>
            
            <span style=" display:<?php echo  $display_status; ?>;" id="purge_btn_<?=$endorsements['id']?>">
                <a  href="javascript:void(0);" class="btn btn-purge container-full" style="margin-top: 5px;" onclick="confirm_purge('<?=$purge_link?>',false);">Purge </a><br />
            </span>
            
            <a  href="<?=$edit_link?>" class="btn btn-primary container-full" style="margin-top: 5px;">Edit </a><br />
            
            
            <label class="toggle" >
				<input onclick="return toggleActivate(this,'<?=$endorsements['id']?>');" type="checkbox" name="Activate_<?=$endorsements['id']?>" <?=($endorsements['status'])?"checked='checked'":"" ?>"><i data-swchon-text="ON" data-swchoff-text="OFF"></i>Active
            </label>
            <input type="hidden" name="total_live_properties" id="active_endorsements" value="<?php echo $active_endorsements; ?>" />
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
            <td colspan="4" style="text-align: center;"><strong>No endorsements were found</strong>
            </td>
        </tr>
        <?php
    }
    ?>
</tbody>