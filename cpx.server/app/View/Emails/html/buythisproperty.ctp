
<div class="container cpxcontent" >
	<div class="row datacontainer">
		
		
			<div class="col-sm-12 nopadding">
				
				<p><b>Dear  property owner/ agent<?php if($data['pass_params']== 'AffordAssist' || $data['pass_params']== 'Domacom') echo " and ".$data['pass_params']; ?>,</b></p>
				<p>I/we would like to buy this property <?php if($data['pass_params']== 'Vendor Finance') echo 'with '; else echo 'via ';?> <?php echo $data['pass_params']; ?><?php if($data['pass_params']== 'Domacom') echo '; fractional property investing.'; else echo '.';?></p>
					
				<p><b>Submitted by:</b></p>
				<p style="padding-left:10px;"><b>Name:</b> <?php echo $data['name']; ?></p>
				<p style="padding-left:10px;"><b>Email:</b> <?php echo $data['email']; ?></p>
                <p style="padding-left:10px;"><b>Role:</b> <?php echo $data['role']; ?></p>
				
                <p style="padding-left:10px;"><?php echo $data['links']; ?> </p>    
                
                <?php 
                    if($data['pass_params']== 'AffordAssist')
                    {
                        ?>
                        <b>Note:</b> AffordAssist will manage this process. <a href="http://www.affordassist.com/contact-us/" target="_blank">Contact AffordAssist</a>
                        <?php
                    } 
                ?> 
                
                <?php 
                    if($data['pass_params']== 'Domacom')
                    {
                        ?>
                        <b>Note:</b> DomaCom Pty Ltd will manage this process. <a href="http://www.domacom.com.au/contact-us/" target="_blank">Contact DomaCom</a>
                        <?php
                    } 
                ?> 
                
                <p>Additional comments by <?php echo $data['name']; ?>:<?php echo $data['message']; ?></p>
                
			</div>	
			
			
			
				<div class="col-sm-12 nopadding">
					
					<p class="colorstyleblue" >Regards,<br>
					CPx Administration</p><br>
					<div class="">
						<img src="http://staging.centralpropertyexchange.com.au/images/CPxLogo-email.jpg">
					</div><br>
					<address>
						  <abbr title="Telephone"><b>Telephone: </b></abbr> +61 2 8006 1979 <br>
						  <abbr title="Mobile"><b>Mobile/cell: </b></abbr> +61 410 510 997<br>
						  <abbr title="Email"><b>Email: </b></abbr><a href="mailto:#">contact@centralpropertyexchange.com.au</a><br>
						  <abbr title="web"><b>Web: </b></abbr> centralpropertyexchange.com.au<br>
						  <abbr title="Skype"><b>Skype: </b></abbr> property.compass<br>
					</address>
					
				</div>
			

		</div>
	
</div>
