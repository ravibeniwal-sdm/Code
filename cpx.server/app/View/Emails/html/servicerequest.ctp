
<div class="container cpxcontent" >
	<div class="row datacontainer">
		
		
			<div class="col-sm-12 nopadding">
				
				<p><b>Dear  <?php echo $data['to_contacts_email'] ?>,</b></p>
				<p><?php echo $data['name'] ?> | <?php echo $data['email'] ?>, nominated role: <?php echo $data['role'] ?>, is seeking the services of an independent industry professional to help evaluate/ buy property.</p>
					
				<p>Via CPx <?php echo $data['name'] ?> is able to seek the services of a number of professionals from different industries at once; giving <?php echo $data['name'] ?> the ability to have a team assist in the process.</p>
				<p>On this occassion <?php echo $data['name'] ?> has requested your role as: <?php echo $data['to_contacts_role'] ?></p>
				<p>Please reply directly to <?php echo $data['name'] ?>.</p>
                
                <?php 
                if(!empty($data['links']))
                {
                ?>
                    <p><?php echo $data['links']; ?></p>
                <?php
                }
                ?>
                
                <p>Additional comments by <?php echo $data['name'] ?>:<?php echo $data['message'] ?></p>   
                
			
			
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
