<?php
    $firstname = '';
    if(isset($fetchUserDetails[0]['firstname']) && !empty($fetchUserDetails[0]['firstname']))
        $firstname = $fetchUserDetails[0]['firstname'];
?>

<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" >

    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" >
        	<label class="input">First Name</label>
	</div>
    
    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5" style="padding-bottom: 10px;" >
        <label class="input">
          <input type="text" value="<?php echo $firstname; ?>" name="firstname" />
          </label>
	</div>

</div>
                                										

                                 
<?php
    $lastname = '';
    if(isset($fetchUserDetails[0]['lastname']) && !empty($fetchUserDetails[0]['lastname']))
        $lastname = $fetchUserDetails[0]['lastname'];
?>
<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" >

    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" >
        	<label class="input">Last Name</label>
	</div>
    
    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5" style="padding-bottom: 10px;" >
         <label class="input">
           <input type="text" value="<?php echo $lastname; ?>" name="lastname"/>
           </label>
	</div>

</div>

<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" >

    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" >
        	<label class="input">Account Id</label>
	</div>
    
    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5" style="padding-bottom: 10px;" >
        <label class="input"><?php echo $fetchUserDetails[0]['username']; ?></label>
	</div>

</div>

<?php
$account_type = 'CPx account';
if(isset($fetchUserDetails[0]['oauth_provider']) && !empty($fetchUserDetails[0]['oauth_provider']))
     $account_type = 'Social';   
elseif(isset($fetchUserDetails[0]['system_generated_user']))
    $account_type = 'Publisher feed';   
    
?>
<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" >

    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" >
        	<label class="input">Account Type</label>
	</div>
    
    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5" style="padding-bottom: 10px;" >
        <label class="input"><?php echo $account_type;?></label>
	</div>

</div>

<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" >

    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" >
        	<label class="input">User Type</label>
	</div>
    
    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5" style="padding-bottom: 10px;" >
        <label class="input"><?php echo ucfirst($fetchUserDetails[0]['type']) ?></label>
	</div>

</div>

<?php

if(isset($fetchUserDetails['0']['phone_number']) && !empty($fetchUserDetails['0']['phone_number']))
{
?>
    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" >

        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" >
            	<label class="input">Phone number</label>
		</div>
        
        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5" style="padding-bottom: 10px;" >
            <input type="text" value="<?php echo $fetchUserDetails[0]['phone_number']; ?>" name="phone_number"/>
		</div>
    
    </div>

<?php
}
?>

<?php

if(isset($fetchUserDetails['0']['company_name']) && !empty($fetchUserDetails['0']['company_name']))
{
?>
    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" >

        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" >
            	<label class="input">Company name</label>
		</div>
        
        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5" style="padding-bottom: 10px;" >
            <input type="text" value="<?php echo $fetchUserDetails[0]['company_name']; ?>" name="company_name"/>
		</div>
    
    </div>

<?php
}
?>


<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" >

    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" >
        	<label class="input">Status</label>
	</div>
    
    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5" style="padding-bottom: 10px;" >
        <label class="input"><?php echo ucfirst($fetchUserDetails[0]['status']); ?></label>
	</div>

</div>

<?php

if(isset($fetchUserDetails['0']['publisher_status']))
{
?>
    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" >

        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" >
            	<label class="input">Publisher</label>
		</div>
        
        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5" style="padding-bottom: 10px;" >
            <label class="input"><?php echo ucfirst($fetchUserDetails[0]['publisher_status']); ?></label>
		</div>
    
    </div>

<?php
}
?>

<?php
if(isset($fetchUserDetails[0]['social_media_logo']) && !empty($fetchUserDetails[0]['social_media_logo']))
{
?>

<script language="javascript" type="text/javascript">
    $('#social_media_img_div').show();
    $('#social_media_img').attr('src', '<?php echo IMG_PATH.'/'.$fetchUserDetails[0]['social_media_logo'];?>');

</script>

<?php
}
?>        