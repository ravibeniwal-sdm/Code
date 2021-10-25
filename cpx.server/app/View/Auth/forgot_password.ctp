<script language="javascript" type="text/javascript">
 function validate_form()
{
    var email_val = $("#email").val();
    var response = grecaptcha.getResponse();
    
    if(email_val == '')
    {
         $('#error_email').show();
         return false;
    }   
    else if(response.length == 0)
    {
        $('#error_recpatcha').show();
         return false;
    }        
    $("#forgotpassword-form").submit();                                                                           
}	

function redirectpage(page)
{
    if(page == 'web')
        window.location.href='<?=WEB_PATH?>#!/list_ur_property';
    else
        window.location.href='<?=ADMIN_PATH?>auth/login';
}
</script>
<div id="main" role="main">

			<!-- MAIN CONTENT -->
			<div id="content" class="container">

				<div class="row">
				
					<div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
                    <?php echo $this->Session->flash();?>
						<div class="well no-padding">
							<form action="<?=ADMIN_PATH?>auth/forgot_password" id="forgotpassword-form" method="POST" class="smart-form client-form">
								<header>
									Forgot Password
								</header>

								<fieldset>
									
									<section>
										<label class="label">Enter your email address</label>
										<label class="input"> <i class="icon-append fa fa-envelope"></i>
											
                                            <input type="email" name="email" id="email" onfocus="$('#error_email').hide();" onkeydown="$('#error_email').hide();">
                                            <span id="error_email" style="color: red; font-size: 11px;display: none;">Please enter email address</span>
										</label>
									</section>
									
                                    <section>
										<div class="g-recaptcha" data-sitekey="<?php echo Configure::read('google_recatpcha_settings.site_key'); ?>"></div>
                                        <span id="error_recpatcha" style="color: red; font-size: 11px;display: none;">Please select I'm not a robot.</span>
									</section>
									

								</fieldset>
								<footer>
                                    <input type="submit" onclick="return validate_form();" value="Continue" class="btn btn-primary"/>
                                
									<input type="button" style="margin-right: 5px;" onclick="redirectpage('<?php echo $redirect ?>');" value="Cancel" class="btn btn-default"/>
                                    
                                    
								</footer>
							</form>

						</div>
						
					
						
					</div>
				</div>
			</div>

		</div>