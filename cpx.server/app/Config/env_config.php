<?php

$dbIp = "localhost:27017";

//$host = 'localhost';



if ($linkedIp = getenv("CPX.DB_PORT_27017_TCP_ADDR"))
 $dbIp = $linkedIp;

if ($manualIp = getenv("DB_IP"))
 $dbIp = $manualIp;

/* try{
$hosturl = $_SERVER['SERVER_NAME'];
}
catch(Exception $e){
	echo "UNDEFINED hosturl";
}

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
} */


$config = array (
 /* MONGO Constant for URL */
   'CONNECT_SER' => 'mongodb://'. $dbIp,
   'LOCAL_CONN' => 'mongodb://localhost:27017'
   /* 'API_URL'	=> $apiurl,
   'WEB_URL'	=> $weburl */
);
