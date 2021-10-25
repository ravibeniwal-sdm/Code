
<div class="container cpxcontent" >
	<div class="row datacontainer">
		
		
			<div class="col-sm-12 nopadding">
				<p class="colorstyleblue">Dear property owner/ agent,</p><br />
				<p>Great News! A <?php echo $data['requestformrole']; ?> from <?php echo $data['requestformplace']; ?>, <?php echo $data['requestformstate']; ?>
				has expressed interest in your property:  <a href="http://<?php echo $data['weburl']; ?>#!/details/<?php echo $data['propertyid']; ?>" target = "_blank"><?php echo $data['weburl']; ?>#!/details/<?php echo $data['propertyid']; ?></a><br/>
				</p>
				<p>To assist in making their purchase decision this <?php echo $data['requestformrole']; ?> has requested an Independent Property Review (ipr) which includes your 
				property's grade in a 6 page report on your CPx listed property.</p>
				<p>The grade works like a hotel star rating. It provides the disclosure buyers/ advisors need to find the right property.</p>
				<p>Properties are independently reviewed and graded by <a href="http://www.jll.com.au/australia/en-au/research" target="_blank" style="text-decoration:underline;">JLL</a></p>
				<p>The completed ipr and grade report will be posted against your property and will be available FREE to download by potential buyers/ advisors. 
					The ipr will also be emailed to you and may assist you in further marketing your property.</p>
				<p style="font-size:16px;font-weight:600;">Providing buyers/ advisors with this independent information may assist you in selling your property.</p>	
			
				<p>Please respond with a <b>YES</b> or <b>NO</b> to this request as soon as possible to avoid losing a potential buyer.
					A copy of your response will be sent to the interested <?php echo $data['requestformrole']; ?>.</p>
				
			</div>	
			
				<div class="col-sm-12 nopadding">
					<p><b>Click to respond:</b>
						<a class="" href="http://<?php echo $data['apiurl'] ?>/requestipr/acceptrequest?query=<?php echo $data['query'] ?>" style="text-decoration: underline;" title="YES buy ipr and grade report" target="_blank"><b>YES</b> buy ipr and grade report</a> |
						<a class="" href="http://<?php echo $data['apiurl'] ?>/requestipr/rejectrequest?query=<?php echo $data['query'] ?>" style="text-decoration: underline;" title="NO reject request" target="_blank"><b>NO</b> reject request</a> 
					</p>
				</div>
			
				<div class="col-sm-12 nopadding">
					<p><b>More details:</b>
						<a class="" href="http://<?php echo $data['weburl']; ?>#!/blog/FAQs/why-grade-a-property" style="text-decoration: underline;font-size: 12px;" title="Why grade a property?" target="_blank">Why grade a property?</a> | 
						<a class="" href="http://<?php echo $data['weburl']; ?>#!/about/independent-property-review" target="_blank" style="text-decoration: underline;font-size: 12px;" title="Independent property review(ipr)">What is an ipr,
						grade and score?</a> | 
						<a class="" href="http://<?php echo $data['weburl']; ?>docs/sample-CPx-ipr.pdf" style="text-decoration: underline;font-size: 12px;" title="See the sample ipr" target="_blank">Sample ipr and grade report</a> |
						<a class="" href="http://<?php echo $data['weburl']; ?>#!/list-your-property-on-cpx/list-property#rate" style="text-decoration: underline;font-size: 12px;" title="Rates" target="_blank">Rates</a>
					</p>
					
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
