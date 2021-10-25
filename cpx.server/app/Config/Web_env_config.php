<?php


$hosturl = $_SERVER['SERVER_NAME'];

if($hosturl == 'localhost'){
	$apiurl = 'localhost/cpx/cpx.server';
	$weburl = 'localhost/cpx/cpx.web/';
}
else if($hosturl == 'staging.api.centralpropertyexchange.com.au'){
	$apiurl = $hosturl;
	$weburl = 'staging.centralpropertyexchange.com.au/';
}
else if($hosturl == 'api.centralpropertyexchange.com.au'){
	$apiurl = $hosturl;
	$weburl = 'centralpropertyexchange.com.au/';
}



$config = array (
		/* Constant for response codes */
		
				'API_URL'	=> $apiurl,
   				'WEB_URL'	=> $weburl
		
);

?>