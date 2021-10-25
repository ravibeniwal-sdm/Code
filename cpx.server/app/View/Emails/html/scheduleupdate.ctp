
<html>
<head>
<style type ="text/css">
	.demo{
		border:1px solid #C0C0C0 !important;
		border-collapse:collapse !important;
		padding:5px !important;
		width: 70% !important;
	}
	.demo th{
		border:1px solid #C0C0C0 !important;
		padding:5px !important;
		background:#F0F0F0 !important;
	}
	.demo td{
		border:1px solid #C0C0C0 !important;
		padding:5px !important;
	}
</style>
</head>
<body>

				<span>Dear CPx Admin,</span>
				<br>
				
				
				<p><b>Total Properties Listed on cpx are : <?php echo $dataArray['totalliveproperties']; ?></b></p>	
				
				<?php if (sizeOf($dataArray['New']) != 0){ ?>
				<p><b>Newly added listings</b></p>
				<table class="demo" style="border:1px solid #C0C0C0 !important;border-collapse:collapse !important;padding:5px !important;width: 90% !important;">
					
					<thead>
					<tr>
						<th style="border:1px solid #C0C0C0 !important;padding:10px !important;background:#F0F0F0 !important;text-align: left !important; width: 40% !important;">Publisher ID/ email</th>
						<th style="border:1px solid #C0C0C0 !important;padding:5px !important;background:#F0F0F0 !important; width: 15% !important;">Total properties</th>
						<th style="border:1px solid #C0C0C0 !important;padding:5px !important;background:#F0F0F0 !important;">Property #/Id</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($dataArray['New'] as $agentId => $propCount){ ?>
					<tr>
						<td style="border:1px solid #C0C0C0 !important;padding:5px !important;"><?php echo $agentId ; ?></td>
						<td style="border:1px solid #C0C0C0 !important;padding:5px !important; text-align: center !important;"><?php echo $propCount['TotalCount']; ?></td>
						<td style="border:1px solid #C0C0C0 !important;padding:5px !important;">
						
							<ol>
							
								<?php foreach ($propCount['Ids'] as $id): ?>
								
								<li><?=$id?></li>
								
								<?php endforeach; ?>
							
							</ol>
						
						</td>
					</tr>
					<?php } ?>
					</tbody>
				</table> 
				<br/>
				<?php }else{ ?>
					<p><b>No new listings are added</b></p>
				<?php } ?>
				
				
				<?php if (sizeOf($dataArray['Update']) != 0){ ?>
				<p><b>Updated listings</b></p>
					<table class="demo" style="border:1px solid #C0C0C0 !important;border-collapse:collapse !important;padding:5px !important;width: 90% !important;">
					
					<thead>
					<tr>
						<th style="border:1px solid #C0C0C0 !important;padding:10px !important;background:#F0F0F0 !important;text-align: left !important; width: 40% !important;">Publisher ID/ email</th>
						<th style="border:1px solid #C0C0C0 !important;padding:5px !important;background:#F0F0F0 !important; width: 15% !important;">Total properties</th>
						<th style="border:1px solid #C0C0C0 !important;padding:5px !important;background:#F0F0F0 !important;">Property #/Id</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($dataArray['Update'] as $agentId => $propCount){ ?>
					<tr>
						<td style="border:1px solid #C0C0C0 !important;padding:5px !important;"><?php echo $agentId ; ?></td>
						<td style="border:1px solid #C0C0C0 !important;padding:5px !important; text-align: center !important;"><?php echo $propCount['TotalCount']; ?></td>
						<td style="border:1px solid #C0C0C0 !important;padding:5px !important;">
						
							<ol>
							
								<?php foreach ($propCount['Ids'] as $id): ?>
								
								<li><?=$id?></li>
								
								<?php endforeach; ?>
							
							</ol>
						
						</td>
					</tr>
					<?php } ?>
					</tbody>
				</table> 
				
				<?php }else{ ?>
					<p><b>No listings are updated</b></p>
				<?php } ?>
				
				<?php if (sizeOf($dataArray['Delete']) != 0){ ?>
				<p>Following table shows <b>Deleted listings</b></p>
				<table class="demo" style="border:1px solid #C0C0C0 !important;border-collapse:collapse !important;padding:5px !important;width: 90% !important;">
					
					<thead>
					<tr>
						<th style="border:1px solid #C0C0C0 !important;padding:10px !important;background:#F0F0F0 !important;text-align: left !important; width: 40% !important;">Publisher ID/ email</th>
						<th style="border:1px solid #C0C0C0 !important;padding:5px !important;background:#F0F0F0 !important; width: 15% !important;">Total properties</th>
						<th style="border:1px solid #C0C0C0 !important;padding:5px !important;background:#F0F0F0 !important;">Property #/Id</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($dataArray['Delete'] as $agentId => $propCount){ ?>
					<tr>
						<td style="border:1px solid #C0C0C0 !important;padding:5px !important;"><?php echo $agentId ; ?></td>
						<td style="border:1px solid #C0C0C0 !important;padding:5px !important; text-align: center !important;"><?php echo $propCount['TotalCount']; ?></td>
						<td style="border:1px solid #C0C0C0 !important;padding:5px !important;">
						
							<ol>
							
								<?php foreach ($propCount['Ids'] as $id): ?>
								
								<li><?=$id?></li>
								
								<?php endforeach; ?>
							
							</ol>
						
						</td>
					</tr>
					<?php } ?>
					</tbody>
				</table> 
				<?php }else{ ?>
				
				<?php } ?>
			
				
			
			
			
				<div class="col-sm-12 nopadding">
					
					<p class="colorstyleblue" style=" margin-bottom: 0px;">Regards,<br>
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
			

		
</body>
</html>