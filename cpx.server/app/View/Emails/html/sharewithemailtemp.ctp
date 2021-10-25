
<div class="container cpxcontent" >
	<div class="row datacontainer">
		
		<?php if ($data['from'] == 'property'): ?>
			<div class="col-sm-12 nopadding">
				
				
				
				
				<p>Hello,</p>
				<p>I found this property on CPx.</p>	
				
				<p>Please have a look/ review , residential<br>
				
				<?php echo $data['proparea']; ?><br>
				<a href="<?php echo $data['weburl']; ?>#!/details/<?php echo $data['propid']; ?>" target = "_blank"><?php echo $data['weburl']; ?>#!/details/<?php echo $data['propid']; ?></a><br/>
				
				<p style="padding-left:10px;"><b>This email was sent by:</b> <?php echo $data['youremail']; ?></p>
				
			
			</div>	
			
			<?php else: ?>
			<div class="col-sm-12 nopadding">
				
				
				<p>Hello,</p>
				
				<p>Please have a look/ review ,</p>
				
				
				
				<a href="<?php echo $data['absurl']; ?>" target = "_blank"><?php echo $data['absurl']; ?></a><br/>
				
				<p style="padding-left:10px;"><b>This email was sent by:</b> <?php echo $data['youremail']; ?></p>
				
			
			</div>	
				<?php endif; ?>
			
			
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
