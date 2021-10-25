<nav>
	<ul>
    
		<li class="<?php echo ($page == 'dashboard') ? 'active' : '' ?>">
        
			<a onclick="checkpage('<?php echo $page; ?>','<?=ADMIN_PATH?>dashboard');" href="javascript:void(0);" title="Dashboard"><i class="fa fa-lg fa-fw fa-desktop"></i> <span class="menu-item-parent">Dashboard</span></a>
		</li>
		
		<li class="<?php if($page == 'property_listing' || $page == 'append' || $page == 'append_widgets') echo 'active'; else echo ''; ?>">
			<a onclick="checkpage('<?php echo $page; ?>','<?=ADMIN_PATH?>property');" href="javascript:void(0);" title="My listings"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">My listings</span></a>
		</li>
        
        
        <!--
<li >
			<a href="javascript:void(0);" title="ipr and Grade Requests"><i class="fa fa-lg fa-fw fa-info"></i> <span class="menu-item-parent">ipr and Grade Requests</span></a>
		</li>
        
        <li >
			<a href="javascript:void(0);" title="Published Calendar"><i class="fa fa-lg fa-fw fa-calendar"></i> <span class="menu-item-parent">Published Calendar</span></a>
		</li>
-->
        
        
        <li >
			<a href="javascript:void(0);" title="Settings"><i class="fa fa-lg fa-fw fa-cog"></i> <span class="menu-item-parent">Settings</span></a>
			<ul >
                
				<li class="<?php echo ($page == 'profile') ? 'active' : '' ?>">
					<a onclick="checkpage('<?php echo $page; ?>','<?=ADMIN_PATH?>auth/profile');" href="javascript:void(0);" title="Profile">Profile</a>
				</li>
                <li class="<?php echo ($page == 'myaccounts') ? 'active' : '' ?>">
					<a onclick="checkpage('<?php echo $page; ?>','<?=ADMIN_PATH?>auth/myaccounts');" href="javascript:void(0);" title="Profile">My Accounts</a>
				</li>
				<li class="<?php echo ($page == 'change_password') ? 'active' : '' ?>">
    				<a onclick="checkpage('<?php echo $page; ?>','<?=ADMIN_PATH?>auth/change_password');" href="javascript:void(0);" title="Change Password"><span class="menu-item-parent">Change Password</span></a>
    			</li>
				
			</ul>
		</li>
        
       <!--
<li >
			<a href="javascript:void(0);" title="Notifications/alert"><i class="fa fa-lg fa-fw fa-bell-o"></i> <span class="menu-item-parent">Notifications/alert</span></a>
		</li>
-->
        
        
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