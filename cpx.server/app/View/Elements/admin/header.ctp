<!-- HEADER -->
<header id="header">

    <div id="logo-group">

		<!-- PLACE YOUR LOGO HERE -->
		<span id="logo" > <img style="height: 100%;width: auto;" src="<?php echo IMG_PATH; ?>/inner_logo.png" alt="CPx Admin"> </span>
    </div>
    
    <div class="pull-right">
				
        <!-- collapse menu button -->
    	<div id="hide-menu" class="btn-header pull-right">
    		<span> <a href="javascript:void(0);" data-action="toggleMenu" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
    	</div>
    	<!-- end collapse menu -->
    	
    	<!-- #MOBILE -->
    	<!-- Top menu profile link : this shows only when top menu is active -->
    	<ul id="mobile-profile-img" class="header-dropdown-list hidden-xs padding-5">
    		<li class="">
    			<a href="<?=ADMIN_PATH?>auth/profile" class="dropdown-toggle no-margin userdropdown" > 
    				<img src="<?php echo IMG_PATH; ?>/avatars/male.png"  class="online" />  
    			</a>
    			
    		</li>
    	</ul>
    
    	<!-- logout button -->
    	<div id="logout" class="btn-header transparent pull-right">
    		<span> <a href="<?=ADMIN_PATH?>auth/logout" title="Logout" data-action="userLogout" data-logout-msg="You can improve your security further after logging out by closing this opened browser"><i class="fa fa-sign-out"></i></a> </span>
    	</div>
    	<!-- end logout button -->
    
    	<!-- fullscreen button -->
    	<div id="fullscreen" class="btn-header transparent pull-right">
    		<span> <a href="javascript:void(0);" data-action="launchFullscreen" title="Full Screen"><i class="fa fa-arrows-alt"></i></a> </span>
    	</div>
    	<!-- end fullscreen button -->
    	
    </div>
    
</header>