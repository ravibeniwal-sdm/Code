<nav>
	<!-- NOTE: Notice the gaps after each icon usage <i></i>..
	Please note that these links work a bit different than
	traditional href="" links. See documentation for details.
	-->
	<ul>
    
		<li class="<?php echo ($page == 'dashboard') ? 'active' : '' ?>">
        
			<a onclick="checkpage('<?php echo $page; ?>','<?=ADMIN_PATH?>dashboard');" href="javascript:void(0);" title="Dashboard"><i class="fa fa-lg fa-fw fa-desktop"></i> <span class="menu-item-parent">Dashboard</span></a>
		</li>
		
		<li class="<?php if($page == 'property_listing' || $page == 'append' || $page == 'append_widgets') echo 'active'; else echo ''; ?>">
			<a onclick="checkpage('<?php echo $page; ?>','<?=ADMIN_PATH?>property');" href="javascript:void(0);" title="Listings"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Listings</span></a>
		</li>
        
        
        <li >
			<a href="javascript:void(0);" title="ipr and Grade Requests"><i class="fa fa-lg fa-fw fa-info"></i> <span class="menu-item-parent">ipr and Grade Requests</span></a>
		</li>
        
        <li >
			<a href="javascript:void(0);" title="Published Calendar"><i class="fa fa-lg fa-fw fa-calendar"></i> <span class="menu-item-parent">Published Calendar</span></a>
		</li>
        
        
        <li >
			<a href="javascript:void(0);" title="Settings"><i class="fa fa-lg fa-fw fa-cog"></i> <span class="menu-item-parent">Settings</span></a>
			<ul >
                
				<li class="<?php echo ($page == 'publishers') ? 'active' : '' ?>">
                
					<a onclick="checkpage('<?php echo $page; ?>','<?=ADMIN_PATH?>setting');" href="javascript:void(0);" title="Publishers">Publishers</a>
				</li>
				<li class="<?php echo ($page == 'sponsors') ? 'active' : '' ?>">
                
					<a onclick="checkpage('<?php echo $page; ?>','<?=ADMIN_PATH?>sponsors');" href="javascript:void(0);" title="Sponsors">Sponsors</a>
				</li>
				<li class="<?php echo ($page == 'endorsements') ? 'active' : '' ?>">
                
					<a onclick="checkpage('<?php echo $page; ?>','<?=ADMIN_PATH?>endorsements');" href="javascript:void(0);" title="Endorsements">Endorsements</a>
				</li>
                <li class="<?php echo ($page == 'locations') ? 'active' : '' ?>">
                
					<a onclick="checkpage('<?php echo $page; ?>','<?=ADMIN_PATH?>locations');" href="javascript:void(0);" title="Locations">Locations</a>
				</li>
                <li class="<?php echo ($page == 'accountholders') ? 'active' : '' ?>">
                
					<a onclick="checkpage('<?php echo $page; ?>','<?=ADMIN_PATH?>accountholders');" href="javascript:void(0);" title="Account Holders">Account holders</a>
				</li>
			</ul>
		</li>
        
        <li >
			<a href="javascript:void(0);" title="Notifications/alert"><i class="fa fa-lg fa-fw fa-bell-o"></i> <span class="menu-item-parent">Notifications/alert</span></a>
		</li>
        
        <li class="<?php echo ($page == 'change_password') ? 'active' : '' ?>">
			<a onclick="checkpage('<?php echo $page; ?>','<?=ADMIN_PATH?>auth/change_password');" href="javascript:void(0);" title="Change Password"><i class="fa fa-lg fa-fw fa-lock"></i> <span class="menu-item-parent">Change Password</span></a>
		</li>
        
        <li>
			<a  href="<?=ADMIN_PATH?>auth/logout" title="Logout" data-action="userLogout" data-logout-msg="You can improve your security further after logging out by closing this opened browser"><i class="fa fa-lg fa-fw fa-sign-out"></i> <span class="menu-item-parent">Logout</span></a>
           
		</li>
        
        <li>
			<a href="javascript:void(0);" > <span class="menu-item-parent"></span></a>
		</li>
        
        <li>
		<a href="javascript:void(0);" > <span class="menu-item-parent"></span></a>
		</li>
        
        <li >
			<a href="https://login.propertycompass.com.au/" target="_blank" title="Property Compass" ><i class="fa fa-lg fa-fw "><img src="<?=ADMIN_PATH?>/img/PC-Fav-Icon.png" /> </i> <span class="menu-item-parent">Property Compass&reg;</span></a>
		</li>
        
	</ul>
</nav>