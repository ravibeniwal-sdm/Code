<div id="content" class="container">
    
	<div class="row">
	    
		<div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
         <?php echo $this->Session->flash('flash'); ?>
			<div class="well no-padding">
				<form action="<?=ADMIN_PATH?>auth/login" id="login-form" method="POST" class="smart-form client-form">
					<header>
						Sign In
					</header>

					<fieldset>
						
						<section>
							<label class="label">E-mail</label>
							<label class="input"> <i class="icon-append fa fa-user"></i>
								<input type="email" value="<?=(isset($authInfo['username'])?$authInfo['username']:"")?>" name="username" id="username" onfocus="$('#error_username').hide();" onkeydown="$('#error_username').hide();">
                                <span id="error_username" style="color: red; font-size: 11px;display: none;">Please enter email address</span>
								</label>
						</section>

						<section>
							<label class="label">Password</label>
							<label class="input"> <i class="icon-append fa fa-lock"></i>
								<input type="password" value="<?=(isset($authInfo['password'])?$authInfo['password']:"")?>" name="password" id="password" onfocus="$('#error_password').hide();" onkeydown="$('#error_password').hide();"/>
                                
                                <span id="error_password" style="color: red; font-size: 11px;display: none;">Please enter password</span>
							</label>
							<div class="note">
								<a href="<?=ADMIN_PATH?>auth/forgot_password">Forgot password?</a>
							</div>
						</section>

						<section>
							<label class="checkbox">
								<input type="checkbox" name="rememberme" <?=((isset($authInfo['rememberme']) && $authInfo['rememberme']==1) ? "checked":"")?>>
								<i></i>Stay signed in</label>
						</section>
					</fieldset>
					<footer>
						<input type="submit" onclick="return validate_form();" value="Sign in" class="btn btn-primary"/>
					</footer>
				</form>

			</div>
			
		</div>
        
	</div>
</div>