<script language="javascript" type="text/javascript">
function form_validation()
{
    new_password = $('#new_password').val();
    confirm_password = $('#confirm_password').val();
    
    
    if(new_password == '')
    {
        $('#new_password_error').show();
                
        return false;        
    }    
    else if(confirm_password == '')
    {
        $('#confirm_password_error').show();
                
        return false;        
    }  
    else if((confirm_password != '') && (new_password != confirm_password))
    {
        
        $('#confirm_password_doesnotmatch_error').show();
                
        return false;        
    }
    
    $('#change_password_form').submit();
}



function redirectpage()
{
    window.location.href='<?=ADMIN_PATH?>property/';
}

</script>
<div id="main" role="main">

			<!-- MAIN CONTENT -->
			<div id="content" class="container">

				<div class="row">
				<?php echo $this->Session->flash();?>
					<div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
						<div class="well no-padding">
							<form action="<?=ADMIN_PATH?>auth/reset_password/<?=$userId?>/<?=$token?>" id="login-form" method="POST" class="smart-form client-form">
								<header>
									Reset Password
								</header>

								<fieldset>
										
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                    	<label class="input">New Password</label>
								</div>
                                
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
									  
                                    	<label class="input"><input class="form-control"  onfocus="$('#new_password_error').hide();" onkeydown="$('#new_password_error').hide();" type="password" name="new_password" id="new_password" />
									</label>
                                    <span id="new_password_error" style="color: red; font-size: 11px;display: none;">Please enter new password</span>
								</div>
                               
                               <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                    	<label class="input">Confirm Password</label>
								</div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    
                                    	<label class="input"><input class="form-control" onfocus="$('#confirm_password_error').hide();" onkeydown="$('#confirm_password_error').hide();" type="password" name="confirm_password" id="confirm_password" />
									</label>
                                    <span id="confirm_password_error" style="color: red; font-size: 11px;display: none;">Please enter confirm password</span>
                                    <span id="confirm_password_doesnotmatch_error" style="color: red; font-size: 11px;display: none;">New password and Confirm password doesn't match</span>
								</div>
                               
                               </fieldset> 
								<footer>
									<button type="submit" onclick="return form_validation();" class="btn btn-primary">
										<i class="fa fa-refresh"></i> Reset Password
									</button>
								</footer>
							</form>

						</div>
						
					
						
					</div>
				</div>
			</div>

		</div>