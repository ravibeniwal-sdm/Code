<?php


ini_set ( 'error_log', 'c:/wamp/logs/xml2jsonconverter.log' );

// require_once '..\Lib\lib\Analog.php';


ini_set ( 'memory_limit', '-1' );
ini_set ( 'max_execution_time', 3000 );

define ( "serverfolderUrl", "/app/datafiles" );
//define ( "localfolderUrl", "../../../../newxml2" );
define ( "localfolderUrl", "../../../newxml2" );
//define ( "localfolderUrl", "../../twofiles" );
define ( "parsedurl", "/app/parsedDatafiles" );
define ("pc2url" , "../../test");


class XmlparserShell extends AppShell {
    /*  public function main() {
        $this->out('Hello world.');
    } */
	
	public function main(){
		
include '/app/app/Config/env_config.php';

		//////////////////////
		
		//echo is_dir("../../newxml2\parsed");die;
		
		
		
		//$serUrl = Configure::read('CONNECT_SER');

		$serUrl = 'mongodb://'. $dbIp;

		$m1 = new MongoClient($serUrl);
			
			
			
			
		// select a database
		$db2 = $m1->properties;
			
		$collection = $m1->$db2->realprop;
		
		/////////////////////
		
		//$dir = localfolderUrl; // THIS IS TO LOAD LOCAL FILE [START]
		
		$dir = serverfolderUrl; // THIS IS TO LOAD SERVER FILE [START]
		
		$parseddir  = parsedurl;
		
		$files2 = scandir ( $dir, 1 );
		
		//$files2 = glob($dir.'/*.xml');
		
		//print_r($files2); die;
		//print_r($files2);
		// echo (realpath($dir))."<br/>";
		foreach ( $files2 as &$value ) {
			$value = (realpath ( $dir )) . "/" . $value;
			//$value = (realpath ( $dir )) . "\\" . $value;
		}
		
		$max2 = (sizeOf ( $files2 ) - 2);
		// echo $max2;
		for($r = 0; $r < $max2; $r ++) {
			//echo ($files2[$r])."<br/>";
				
			//////Check if Xml is in valid format
				
			libxml_use_internal_errors(true);
			$a = simplexml_load_file($files2 [$r]);
			if($a===FALSE) {
				//echo 'Not valid :'.$files2[$r]."<br/>";
			} else {
				//echo 'valid: '.$files2[$r]."<br/>";
					
		
					
				$xmlNode = simplexml_load_file ( $files2 [$r] );
				$arrayData = $this->xmlToArray ( $xmlNode );
					
				// THIS IS TO LOAD LOCAL FILE [END]
					
				/*
				 * $max2 = (sizeOf ( $h ) - 2);
				 * // echo $max2;
				 * for($r = 0; $r < $max2; $r ++) {
				 *
				 * try {
				 * $xmlNode = simplexml_load_file ( $h [$r] );
				 * $arrayData = $this->xmlToArray ( $xmlNode );
				 * } catch ( Exception $e ) {
				 * error_log("Caught Exception @ parsing: " . $e->getMessage() . "\n");
				 * }
				*/
					
				// print_r($arrayData);
				//$json12 = json_encode ( $arrayData, JSON_PRETTY_PRINT );
					
					
					
					
					
				$json12 = json_encode ( $arrayData);
				// echo $json12; die;
				$data12 = json_decode ( $json12, true );
					
				//print_r($data12);
					
				$someJSON12 = json_encode ( $data12 ['propertyList'] );
					
				// print_r($data12);
					
				// Convert JSON string to Array
				$someArray = json_decode ( $someJSON12, true );
				//print_r($someArray);
		
				$realproperties = array ();
					
				foreach ( $someArray as $key => $value ) {
		
					if ($key == 'residential') { // if($key == 'residential' || $key == 'land'){
						//echo $key." is started";
						//echo $value ['uniqueID'];
							
						if((isset ( $value ['uniqueID'] )) && (isset ( $value ['status'] )) && (isset ( $value ['modTime'] ))){
		
							$realproperties [0] ['id'] = $value ['uniqueID'];
							$realproperties [0] ['gradestatus'] = 0;
							$realproperties [0] ['modifiedon'] = $value ['modTime'];
							$realproperties [0] ['status'] = $value ['status'];
							// $realproperties[0]['modifiedon'] =(isset($value['modTime']))? $value['modTime'] :"";
							// $realproperties[0]['status'] = (isset($value['status']))?$value['status'] :"";
							$realproperties [0] ['headline'] = (isset ( $value ['headline'] )) ? $value ['headline'] : "";
							$realproperties [0] ['name'] = "";
							$realproperties [0] ['authority'] = (isset ( $value ['authority'] ['value'] )) ? $value ['authority'] ['value'] : "";
							$realproperties [0] ['auction_date'] = (isset ( $value ['auction'] ['date'] )) ? $value ['auction'] ['date'] : "";
								
							$realproperties [0] ['type'] = $key;
							$realproperties [0] ['category'] = (isset ( $value ['category'] ['name'] )) ? $value ['category'] ['name'] : "";
								
							// $realproperties[0]['inspectionTimes'] = (isset($value['inspectionTimes']))?$value['inspectionTimes']:"";
								
							//print_r($value ["listingAgent"]) ."<br/>" ;
								
							/* if( (isset ( $value ["listingAgent"] [0] ['id'])) || (isset ( $value ["listingAgent"] [0] ['id']) && $value ["listingAgent"] [1] ['id'] == 2) ){
							 foreach($value['listingAgent'] as $key9 => $agent) {
		
							 $realproperties [0] ['contact'] [$key9] ['type'] = 'listingAgent';
							 $realproperties [0] ['contact'] [$key9] ['id'] = $key9;
							 $realproperties [0] ['contact'] [$key9]  ['name'] = (isset ( $agent ["name"])) ?  $agent ["name"] : '';
		
							 $realproperties [0] ['contact'] [$key9]  ['telephoneType'] = (isset ( $agent ["telephone"] ['type'] )) ? $agent ["telephone"] ['type'] :"";
							 $realproperties [0] ['contact'] [$key9]  ['telephone'] =(isset ( $agent ["telephone"] [''] )) ? $agent ["telephone"] [''] : "";;
		
							 $realproperties [0] ['contact'] [$key9]  ['email'] = (isset ( $agent ["email"] )) ?$agent ["email"] : "";
		
							 }
								}
									
								else if(isset ( $value ["listingAgent"]) || (isset ( $value ["listingAgent"] ) && $value ["listingAgent"][0]['id'] == 1)){
		
								$realproperties [0] ['contact'] [0] ['type'] = 'listingAgent';
								$realproperties [0] ['contact'] [0] ['id'] = (isset ( $value ['listingAgent'] ["id"] )) ? $value ['listingAgent'] ["id"] : "1";
								$realproperties [0] ['contact'] [0] ['name'] = (isset ( $value ['listingAgent'] ["name"] )) ? $value ['listingAgent'] ["name"] : "";
								$realproperties [0] ['contact'] [0] ["telephoneType"] = (isset ( $value ['listingAgent'] ["telephone"] ['type'] )) ? $value ['listingAgent'] ["telephone"] ['type'] : "";
								$realproperties [0] ['contact'] [0] ['telephone'] = (isset ( $value ['listingAgent'] ["telephone"] [''] )) ? $value ['listingAgent'] ["telephone"] [''] : "";
								$realproperties [0] ['contact'] [0] ['email'] = (isset ( $value ['listingAgent'] ["email"] )) ? $value ['listingAgent'] ["email"] : "";
		
								} */
		
							if(isset($value ["vendorDetails"])){
								$realproperties [0] ['contact'] [0] ['type'] = 'vendorDetails';
								$realproperties [0] ['contact'] [0] ['name'] = (isset ( $value ['vendorDetails'] ["name"] )) ? $value ['vendorDetails'] ["name"] : "";
								$realproperties [0] ['contact'] [0] ["telephoneType"] = (isset ( $value ['vendorDetails'] ["telephone"] ['type'] )) ? $value ['vendorDetails'] ["telephone"] ['type'] : "";
								$realproperties [0] ['contact'] [0] ['telephone'] = (isset ( $value ['vendorDetails'] ["telephone"] [''] )) ? $value ['vendorDetails'] ["telephone"] [''] : "";
								$realproperties [0] ['contact'] [0] ['email'] = (isset ( $value ['vendorDetails'] ["email"] )) ? $value ['vendorDetails'] ["email"] : "";
		
							}
		
							if( isset ( $value ["listingAgent"]['id']) || isset ( $value ["listingAgent"]['name']) || isset ( $value ["listingAgent"]['email'])){
								//echo "single";
								if(isset($value ["vendorDetails"])){$agentkey = 1;}else{$agentkey = 0;}
								$realproperties [0] ['contact'] [$agentkey] ['type'] = 'listingAgent';
								$realproperties [0] ['contact'] [$agentkey] ['id'] = (isset ( $value ['listingAgent'] ["id"] )) ? $value ['listingAgent'] ["id"] : "1";
								$realproperties [0] ['contact'] [$agentkey] ['name'] = (isset ( $value ['listingAgent'] ["name"] )) ? $value ['listingAgent'] ["name"] : "";
								$realproperties [0] ['contact'] [$agentkey] ["telephoneType"] = (isset ( $value ['listingAgent'] ["telephone"] ['type'] )) ? $value ['listingAgent'] ["telephone"] ['type'] : "";
								$realproperties [0] ['contact'] [$agentkey] ['telephone'] = (isset ( $value ['listingAgent'] ["telephone"] [''] )) ? $value ['listingAgent'] ["telephone"] [''] : "";
								$realproperties [0] ['contact'] [$agentkey] ['email'] = (isset ( $value ['listingAgent'] ["email"] )) ? $value ['listingAgent'] ["email"] : "";
		
							}
							else if(isset($value['listingAgent'])){
								//echo "multiple";
								foreach($value['listingAgent'] as $key9 => $agent) {
									if(isset($value ["vendorDetails"])){$agentkey = $key9 + 1;}else{$agentkey = $key9;}
									$realproperties [0] ['contact'] [$agentkey] ['type'] = 'listingAgent';
									$realproperties [0] ['contact'] [$agentkey] ['id'] = (isset ( $agent ["id"])) ?  $agent ["id"] : $key9;
									$realproperties [0] ['contact'] [$agentkey]  ['name'] = (isset ( $agent ["name"])) ?  $agent ["name"] : "";
										
									$realproperties [0] ['contact'] [$agentkey]  ['telephoneType'] = (isset ( $agent ["telephone"] ['type'] )) ? $agent ["telephone"] ['type'] :"";
									$realproperties [0] ['contact'] [$agentkey]  ['telephone'] =(isset ( $agent ["telephone"] [''] )) ? $agent ["telephone"] [''] : "";
										
									$realproperties [0] ['contact'] [$agentkey]  ['email'] = (isset ( $agent ["email"] )) ?$agent ["email"] : "";
										
								}
							}
							else{$realproperties [0] ['contact'] = array();}
								
		
		
								
							////////////////////
								
							//echo $value['price'][''];die;
		
							if(isset($value['price']['display'])){
								//print_r($value1 ['price'] ['']);die;
								$cpxprice = intval($value['price']['']);
								$listedprice = intval($value['price']['']);
							}
								
							else{
								if(isset($value ['price'])){$cpxprice = intval($value ['price']);}
								if(isset($value['price'])){$listedprice = intval($value['price']);}
							}
							//echo (isset ( $cpxprice ));
							if(isset($value['priceView'])){$priceview = $value['priceView'];}else{$priceview = '';}
								
								
							$realproperties [0] ['cpxprice'] = (isset ( $cpxprice )) ? $cpxprice : 0;
								
		
							$realproperties [0] ['listedprice'] = (isset ( $listedprice )) ? $listedprice : 0;
							$realproperties [0] ['viewprice'] = (isset ( $priceview )) ? $priceview : '';
							$realproperties [0] ['saving'] = 0;
								
							$realproperties [0] ['marketrent'] = (isset ( $value ['marketrent'] )) ? $value ['marketrent'] : "";
								
							$realproperties [0] ["beds"] = (isset ( $value ['features'] ["bedrooms"] )) ? $value ['features'] ["bedrooms"] : "";
							$realproperties [0] ["bath"] = (isset ( $value ['features'] ["bathrooms"] )) ? $value ['features'] ["bathrooms"] : "";
		
							$realproperties [0] ["externalLink"] = (isset ( $value ['externalLink'] ["href"] )) ? $value ['externalLink'] ["href"] : "";
							$realproperties [0] ["videoLink"] = (isset ( $value ['videoLink'] ["href"] )) ? $value ['videoLink'] ["href"] : "";
		
		
							$carports = (isset ( $value ['features'] ["carports"] )) ? $value ['features'] ["carports"] : "";
							$garages = (isset ( $value ['features'] ["garages"] )) ? $value ['features'] ["garages"] : "";
							$carspaces = (isset ( $value ['features'] ["carSpaces"] )) ? $value ['features'] ["carSpaces"] : "";
							$cars = $carports + $garages + $carspaces;
								
							$realproperties [0] ["cars"] = $cars;
							$realproperties [0] ['IsHouseLandPackage'] = 'no';
								
							if(isset ( $value ['landDetails'] ["area"])){
								$realproperties [0] ['landarea'] = (isset ( $value ['landDetails'] ["area"] [''] )) ? $value ['landDetails'] ["area"] [''] : "";
								$realproperties [0] ['areaunit'] = (isset ( $value ['landDetails'] ["area"] ['unit'] )) ? $value ['landDetails'] ["area"] ['unit'] : "";
								$realproperties [0] ['buildingarea'] = (isset ( $value ['buildingDetails'] ["area"] [''] )) ? $value ['buildingDetails'] ["area"] [''] : "";
							}
							else{
								$realproperties [0] ['landarea'] =  "";
								$realproperties [0] ['areaunit'] =  "";
								$realproperties [0] ['buildingarea'] =  "";
							}
							$realproperties [0] ['date_created'] = "";
							$realproperties [0] ['featured'] = false;
							$realproperties [0] ['latest'] = false;
							$realproperties [0] ['smsf'] = "";
							if ($value ['status'] == 'sold'){$realproperties [0] ['sold'] = true;}
							else{$realproperties [0] ['sold'] = false;}
							$realproperties [0] ['deposit'] = (isset ( $value ['underOffer'] ['value'] )) ? $value ['underOffer'] ['value'] : "";
							$realproperties [0] ['domacom'] = "";
								
							$realproperties [0] ['grade'] =  "";
							$realproperties [0] ['score'] = (isset ( $value ["Score"] )) ? $value ["Score"] * 1 : "";
								
							if (isset ( $value ["Grade"] ) && $value ["Grade"] == 'AA') {
								$realproperties [0] ['gradelabel'] = "Filter by grade: AA - a score equal or above 275";
							}
		
							elseif (isset ( $value ["Grade"] ) && $value ["Grade"] == 'A') {
								$realproperties [0] ['gradelabel'] = "Filter by grade: A - a score equal or above 215";
							}
		
							elseif (isset ( $value ["Grade"] ) && $value ["Grade"] == 'B') {
								$realproperties [0] ['gradelabel'] = "Filter by grade: B - a score equal or above 155";
							}
		
							elseif (isset ( $value ["Grade"] ) && $value ["Grade"] == 'C') {
								$realproperties [0] ['gradelabel'] = "Filter by grade: C - a score equal or above 95";
							}
		
							elseif (isset ( $value ["Grade"] ) && $value ["Grade"] == 'D') {
								$realproperties [0] ['gradelabel'] = "Filter by grade: D - a score less than 95";
							}
		
							else {
								$realproperties [0] ['gradelabel'] = "";
							}
		
							/* else {
							 $realproperties [0] ['gradelabel'] = "Filter by grade: Any";
							 } */
							$address = array ();
							$realproperties [0] ["address"] = array ();
							/*
							 * $realproperties[0]["address"]["display"] = (isset($value["address"]["display"]))?$value["address"]["display"] :"yes";
							 * $realproperties[0]["address"]["LotNumber"] = (isset($value["address"]["LotNumber"]))?$value["address"]["LotNumber"]:null;
							 * $realproperties[0]["address"]["StreetNumber"] = (isset($value["address"]["streetNumber"]))?$value["address"]["streetNumber"] :"";
							 * $realproperties[0]["address"]["street"] = (isset($value["address"]["street"]))?$value["address"]["street"] :"";
							 * $realproperties[0]["address"]["suburb"]['display'] = (isset($value["address"]["suburb"]['display']))?$value["address"]["suburb"]['display'] :"";
							 * $realproperties[0]["address"]["suburb"]['text'] = (isset($value["address"]["suburb"]['']))?$value["address"]["suburb"][''] :"";
							 * $realproperties[0]["address"]["state"] = (isset($value["address"]["state"]))?$value["address"]["state"] :"";
							 * $realproperties[0]["address"]["country"] = (isset($value["address"]["country"]))?$value["address"]["country"] :"";
							 * $realproperties[0]["address"]["postcode"] = (isset($value["address"]["postcode"]))?$value["address"]["postcode"] :"";
							*/
							$address [0] ["display"] = (isset ( $value ["address"] ["display"] )) ? $value ["address"] ["display"] : "yes";
							$address [0] ["LotNumber"] = (isset ( $value ["address"] ["LotNumber"] )) ? $value ["address"] ["LotNumber"] : null;
		
		
							if(isset ( $value ["address"] ["subNumber"] ) && ($value ["address"] ["subNumber"] == [])){
								$address [0] ["subNumber"] = $value ["address"] ["subNumber"] = null;}
								else{
										
									$address [0] ["subNumber"] = (isset ( $value ["address"] ["subNumber"] )) ? $value ["address"] ["subNumber"] : null;
								}
								if(isset ( $value ["address"] ["streetNumber"] ) && ($value ["address"] ["streetNumber"] == [])){
									$address [0] ["StreetNumber"]= $value ["address"] ["streetNumber"] = "";}
									else{
										$address [0] ["StreetNumber"] = (isset ( $value ["address"] ["streetNumber"] )) ? $value ["address"] ["streetNumber"] : "";
									}
									$address [0] ["street"] = (isset ( $value ["address"] ["street"] )) ? $value ["address"] ["street"] : "";
									if(isset ( $value ["address"] ["suburb"])){
										$address [0] ["suburb"] ['display'] = (isset ( $value ["address"] ["suburb"] ['display'] )) ? $value ["address"] ["suburb"] ['display'] : "";
										$address [0] ["suburb"] ['text'] = (isset ( $value ["address"] ["suburb"] [''] )) ? $value ["address"] ["suburb"] [''] : "";
									} else{
										$address [0] ["suburb"] ['display'] =  "";
										$address [0] ["suburb"] ['text'] =  "";
									}
									$address [0] ["state"] = (isset ( $value ["address"] ["state"] )) ? $value ["address"] ["state"] : "";
									$address [0] ["country"] = (isset ( $value ["address"] ["country"] )) ? $value ["address"] ["country"] : "";
									$address [0] ["postcode"] = (isset ( $value ["address"] ["postcode"] )) ? $value ["address"] ["postcode"] : "";
										
									array_push ( $realproperties [0] ["address"], $address [0] );
		
									/*  $some = array();
									 array_push ( $some , $address [0] ["StreetNumber"]);
									 array_push ( $some , $address [0] ["street"]);
									 array_push ( $some , $address [0] ["suburb"] ['text']);
									 array_push ( $some , $address [0] ["state"]);
									 array_push ( $some , $address [0] ["country"]);
									 array_push ( $some , $address [0] ["postcode"]);
		
									 $city = join(' ',$some);
		
									 //$city = "382 Goulburn Valley Highway, SEYMOUR, VIC 3660";
		
									 $array = $this->lookup($city);
		
									 //$realproperties [0] ["cityAddress"] = $city;
		
		
									 $realproperties [0] ["coords"] ["latitude"] = $array['latitude'];
									 $realproperties [0] ["coords"] ["longitude"] =$array['longitude'];
		
		
									 if($realproperties [0] ["coords"] ["longitude"]==null){
		
									 while($realproperties [0] ["coords"] ["longitude"]==null){
		
									 $array = $this->lookup($city);
									 //print_r($array);die;
		
									 $realproperties [0] ["cityAddress"] = $city;
		
		
									 $realproperties [0] ["coords"] ["latitude"] = $array['latitude'];
									 $realproperties [0] ["coords"] ["longitude"] =$array['longitude'];
									 }
									} */
		
										
									$realproperties [0] ["coords"] ["latitude"] = null;
									$realproperties [0] ["coords"] ["longitude"] =null;
										
										
									// echo(isset($value["images"]["img"]["id"]));
										
										
									if($address [0] ["suburb"] ['text'] == "" && $value ['status'] == 'sold'){
										$realproperties [0] ['offline'] = true;
									}
									else{
										$realproperties [0] ['offline'] = false;
									}
										
										
									if (! isset ( $value ["images"] ["img"] )) {
										//echo "NO";
										$realproperties [0] ['images'] = array();
									} else {
										//echo "ONE";
										if (isset ( $value ["images"] ["img"] ["id"] )) {
											$realproperties [0] ['images'][0]['id'] = 0;
											$realproperties [0] ['images'][0]['url'] = $value ['images'] ["img"] ["url"];
										}
		
										else {
		
											foreach ( $value ["images"] ["img"] as $key2 => $image ) {
												//echo"withi";
												// print_r($image["url"]);
												// echo $key2;print_r($image);
		
												$realproperties [0] ['images'] [$key2] ['id'] = $key2;
												$realproperties [0] ['images'] [$key2] ['url'] = (isset ( $image ['url'] )) ? $image ['url'] : "";
												//echo $image['id'];
											}
											//print_r ($realproperties); die;
										}
									}
										
									if (! isset ( $value ["objects"] ["img"] )) {
										//$realproperties [0] ['images'] = array();
									} else {
										if (isset ( $value ["objects"] ["img"] ["id"] )) {
											$realproperties [0] ['images'][0]['id'] = 0;
											$realproperties [0] ['images'][0]['url'] = $value ['objects'] ["img"] ["url"];
										}
		
										else {
											foreach ( $value ["objects"] ["img"] as $key11 => $image ) {
		
												// print_r($value["images"]);
												// echo $key10;print_r($image);
		
												$realproperties [0] ['images'] [$key11] ['id'] = $key11;
												$realproperties [0] ['images'] [$key11] ['url'] = $image ["url"];
											}
										}
									}
									$realproperties [0] ['documents'] = array();
									if (! isset ( $value ["objects"] ["document"] )) {
										//echo "none;so blank documents";
									} else {
										if (isset ( $value ["objects"] ["document"] ["id"] )) {
											//echo "found one";
											$realproperties [0] ['documents'][0]['id'] = 0;
											$realproperties [0] ['documents'][0]['url'] = $value ['objects'] ["document"] ["url"];
										}
		
										else {
											foreach ( $value ["objects"] ["document"] as $key12 => $image ) {
		
												// print_r($value["images"]);
												// echo $key2;print_r($image);
		
												$realproperties [0] ['documents'] [$key12] ['id'] = $key12;
												$realproperties [0] ['documents'] [$key12] ['url'] = $image ["url"];
											}
										}
									}
										
									if (isset ( $value ["features"] )) {
										foreach($value["features"] as $key4 => $feature) {
												
											if(sizeOf($feature)>1  && isset($feature['type'])){
												$realproperties [0] ['features'] [$key4] = $feature['type'];
											}
												
											else if(sizeOf($feature)>1  && !isset($feature['type'])){
		
											}
												
											// print_r($value["images"]);
											// echo $key2;print_r($image);
												
											else{
												$realproperties [0] ['features'] [$key4] = $feature;
											}
										}
									}
		
		
									if(isset ($value ["ecoFriendly"] )) {
		
										foreach($value["ecoFriendly"] as $key6 => $ecofriendly) {
		
											$realproperties [0] ['ecoFriendly'] [$key6] = $ecofriendly;
										}
											
									}else{
										$realproperties [0] ['ecoFriendly'] = array();
									}
										
									if(isset ($value ["idealFor"] )) {
		
										foreach($value["idealFor"] as $key6 => $idealfor) {
		
											$realproperties [0] ['idealFor'] [$key6] = $idealfor;
										}
									}else{
										//echo ($value ["idealFor"] );
										$realproperties [0] ['idealFor'] = array();
									}
										
										
										
									if(isset ($value ["views"] )) {
										foreach($value["views"] as $key7 => $view) {
												
											$realproperties [0] ['views'] [$key7] = $view;
										}
									}
									else{
										//echo ($value ["views"] );
										$realproperties [0] ['views'] = array();
									}
										
										
									$realproperties [0] ['estimate'] = array ();
									$realproperties [0] ['contract'] = array ();
									$realproperties [0] ['sale_summary'] = array ();
									$realproperties [0] ['history'] = array ();
									$realproperties [0] ['how_to_buy'] = array ();
									$realproperties [0] ['loan_cal'] = array ();
									$realproperties [0] ['invest_cal'] = array ();
									$realproperties [0] ['support_info'] = array ();
										
									// print_r($value["objects"]["floorplan"]);
										
									if (! isset ( $value ["objects"] ["floorplan"] )) {
		
										$realproperties [0] ['floorplans'] = array ();
									} else {
		
										// echo isset($value["objects"]["floorplan"]["id"]);
										if (isset ( $value ["objects"] ["floorplan"] ["id"] )) {
											// echo isset($value["objects"]["floorplan"]["id"]);
											$realproperties [0] ['floorplans'] [0] ['id'] = 0;
											$realproperties [0] ['floorplans'] [0] ['title'] = "";
											$realproperties [0] ['floorplans'] [0] ['url'] = $value ['objects'] ["floorplan"] ["url"];
										}
		
										else {
											// echo isset($value["objects"]["floorplan"]["id"]);
											foreach ( $value ["objects"] ["floorplan"] as $key3 => $floorplan ) {
		
												// print_r($value["objects"]);
												// echo $key3;//
												// print_r($floorplan);
												$realproperties [0] ['floorplans'] [$key3] ['id'] = $key3;
												$realproperties [0] ['floorplans'] [$key3]['title'] = "";
												$realproperties [0] ['floorplans'] [$key3] ['url'] = $floorplan ["url"];
											}
										}
									}
										
										
										
									if (! isset ( $value ["inspectionTimes"] ["inspection"] )) {
										$realproperties [0] ['inspectionTimes'] = array ();
									} else {
		
										if (( isset ( $value ["inspectionTimes"] ["inspection"] ) ) && (count( $value ['inspectionTimes'] ["inspection"])==1)){
												
											$realproperties [0] ['inspectionTimes'][0]['id'] = 0;
											$realproperties[0]['inspectionTimes'][0]['inspection'] = $value ["inspectionTimes"] ["inspection"];
												
										}
		
										elseif(( isset ( $value ["inspectionTimes"] ["inspection"] ) ) && (count( $value ['inspectionTimes'] ["inspection"])>1)){
											//echo "xxxxxxxxxxxxxxxxxxxxxxxx" . (count( $value ['inspectionTimes'] ["inspection"]));
												
		
											foreach ($value["inspectionTimes"]["inspection"] as $key5 => $inspection) {
												$realproperties [0] ['inspectionTimes'] [$key5] ['id'] = $key5;
												$realproperties[0]['inspectionTimes'][$key5]['inspection'] = $inspection;
											}
		
										}
									}
										
									$realproperties [0] ['ipr'] = array ();
									$realproperties [0] ['description'] = (isset ( $value ['description'] )) ? $value ['description'] : "";
									$realproperties [0] ['observation'] = "";
		
						}
							
						else{
		
							$key1 = 0;
							foreach ( $value as $customKey => $value1 ) {
		
								//print_r(array_keys($value1))."<br/>";
								//echo ( $customKey)."<br/>";
		
		
								if ((isset ( $value1 ['uniqueID'] )) && (isset ( $value1 ['status'] )) && (isset ( $value1 ['modTime'] ))) { // ($value1['status'] == 'current')
									// $realproperties[$key1][$key]['status'] = $value1['status'];
									$realproperties [$key1] ['id'] = $value1 ['uniqueID'];
									$realproperties [$key1] ['gradestatus'] = 0;
									$realproperties [$key1] ['modifiedon'] = $value1 ['modTime'];
									$realproperties [$key1] ['status'] = $value1 ['status'];
									// $realproperties[$key1]['modifiedon'] =(isset($value1['modTime']))? $value1['modTime'] :"";
									// $realproperties[$key1]['status'] = (isset($value1['status']))?$value1['status'] :"";
									$realproperties [$key1] ['headline'] = (isset ( $value1 ['headline'] )) ? $value1 ['headline'] : "";
									$realproperties [$key1] ['name'] = "";
									$realproperties [$key1] ['authority'] = (isset ( $value1 ['authority'] ['value'] )) ? $value1 ['authority'] ['value'] : "";
									$realproperties [$key1] ['auction_date'] = (isset ( $value1 ['auction'] ['date'] )) ? $value1 ['auction'] ['date'] : "";
										
									$realproperties [$key1] ['type'] = $key;
									$realproperties [$key1] ['category'] = (isset ( $value1 ['category'] ['name'] )) ? $value1 ['category'] ['name'] : "";
										
									// $realproperties[$key1]['inspectionTimes'] = (isset($value1['inspectionTimes']))?$value1['inspectionTimes']:"";
										
										
									if(isset($value1 ["vendorDetails"])){
		
										$realproperties [$key1] ['contact'] [0] ['type'] = 'vendorDetails';
										$realproperties [$key1] ['contact'] [0] ['name'] = (isset ( $value1 ['vendorDetails'] ["name"] )) ? $value1 ['vendorDetails'] ["name"] : "";
										$realproperties [$key1] ['contact'] [0] ["telephoneType"] = (isset ( $value1 ['vendorDetails'] ["telephone"] ['type'] )) ? $value1 ['vendorDetails'] ["telephone"] ['type'] : "";
										$realproperties [$key1] ['contact'] [0] ['telephone'] = (isset ( $value1 ['vendorDetails'] ["telephone"] [''] )) ? $value1 ['vendorDetails'] ["telephone"] [''] : "";
										$realproperties [$key1] ['contact'] [0] ['email'] = (isset ( $value1 ['vendorDetails'] ["email"] )) ? $value1 ['vendorDetails'] ["email"] : "";
											
									}
										
									if( isset ( $value1 ["listingAgent"]['id']) || isset ( $value1 ["listingAgent"]['name']) || isset ( $value1 ["listingAgent"]['email'])){
										//echo "single";
		
										if(isset($value1 ["vendorDetails"])){
											$agentkey = 1;
											//echo "one";
										}else{
											$agentkey = 0;
											//echo "zero";
										}
										$realproperties [$key1] ['contact'] [$agentkey] ['type'] = 'listingAgent';
										$realproperties [$key1] ['contact'] [$agentkey] ['id'] = (isset ( $value1 ['listingAgent'] ["id"] )) ? $value1 ['listingAgent'] ["id"] : "1";
										$realproperties [$key1] ['contact'] [$agentkey] ['name'] = (isset ( $value1 ['listingAgent'] ["name"] )) ? $value1 ['listingAgent'] ["name"] : "";
										$realproperties [$key1] ['contact'] [$agentkey] ["telephoneType"] = (isset ( $value1 ['listingAgent'] ["telephone"] ['type'] )) ? $value1 ['listingAgent'] ["telephone"] ['type'] : "";
										$realproperties [$key1] ['contact'] [$agentkey] ['telephone'] = (isset ( $value1 ['listingAgent'] ["telephone"] [''] )) ? $value1 ['listingAgent'] ["telephone"] [''] : "";
										$realproperties [$key1] ['contact'] [$agentkey] ['email'] = (isset ( $value1 ['listingAgent'] ["email"] )) ? $value1 ['listingAgent'] ["email"] : "";
											
									}
									else if(isset($value1['listingAgent'])){
										//echo "multiple";
										foreach($value1['listingAgent'] as $key9 => $agent) {
											//$agentkey = $key9 + 1;
											if(isset($value1 ["vendorDetails"])){$agentkey = $key9 + 1; }else{$agentkey = $key9;}
		
											$realproperties [$key1] ['contact'] [$agentkey] ['type'] = 'listingAgent';
											$realproperties [$key1] ['contact'] [$agentkey] ['id'] = (isset ( $agent ["id"])) ?  $agent ["id"] : $key9;
											$realproperties [$key1] ['contact'] [$agentkey]  ['name'] = (isset ( $agent ["name"])) ?  $agent ["name"] : '';
		
											$realproperties [$key1] ['contact'] [$agentkey]  ['telephoneType'] = (isset ( $agent ["telephone"] ['type'] )) ? $agent ["telephone"] ['type'] :"";
											$realproperties [$key1] ['contact'] [$agentkey]  ['telephone'] =(isset ( $agent ["telephone"] [''] )) ? $agent ["telephone"] [''] : "";;
		
											$realproperties [$key1] ['contact'] [$agentkey]  ['email'] = (isset ( $agent ["email"] )) ?$agent ["email"] : "";
		
										}
									}
									else {$realproperties [$key1] ['contact'] = array();}
									////////////////////
									if(isset($value1 ['price']['display'])){
										//print_r($value1 ['price'] ['']);die;
										$cpxprice = intval($value1 ['price']['']);
										$listedprice = intval($value1['price']['']);
									}
										
									else{
										if(isset($value1 ['price'])){$cpxprice = intval($value1 ['price']);}
										if(isset($value1 ['price'])){$listedprice = intval($value1['price']);}
									}
										
									if(isset($value1['priceView'])){$priceview = $value1['priceView'];}else{$priceview = '';}
										
										
									$realproperties [$key1] ['cpxprice'] = (isset ( $cpxprice )) ? $cpxprice : 0;
										
		
									$realproperties [$key1] ['listedprice'] = (isset ( $listedprice )) ? $listedprice : 0;
									$realproperties [$key1] ['viewprice'] = (isset ( $priceview )) ? $priceview : '';
									$realproperties [$key1] ['saving'] = 0;
										
									$realproperties [$key1] ['marketrent'] = (isset ( $value1 ['marketrent'] )) ? $value1 ['marketrent'] : "";
										
									$realproperties [$key1] ["beds"] = (isset ( $value1 ['features'] ["bedrooms"] )) ? $value1 ['features'] ["bedrooms"] : "";
									$realproperties [$key1] ["bath"] = (isset ( $value1 ['features'] ["bathrooms"] )) ? $value1 ['features'] ["bathrooms"] : "";
										
									$realproperties [$key1] ["externalLink"] = (isset ( $value1 ['externalLink'] ["href"] )) ? $value1 ['externalLink'] ["href"] : "";
									$realproperties [$key1] ["videoLink"] = (isset ( $value1 ['videoLink'] ["href"] )) ? $value1 ['videoLink'] ["href"] : "";
		
										
									$carports = (isset ( $value1 ['features'] ["carports"] )) ? $value1 ['features'] ["carports"] : "";
									$garages = (isset ( $value1 ['features'] ["garages"] )) ? $value1 ['features'] ["garages"] : "";
									$carspaces = (isset ( $value1 ['features'] ["carSpaces"] )) ? $value1 ['features'] ["carSpaces"] : "";
									$cars = $carports + $garages + $carspaces;
										
									$realproperties [$key1] ["cars"] = $cars;
									$realproperties [$key1] ['IsHouseLandPackage'] = 'no';
										
									if(isset ( $value1 ['landDetails'] ["area"])){
										$realproperties [$key1] ['landarea'] = (isset ( $value1 ['landDetails'] ["area"] [''] )) ? $value1 ['landDetails'] ["area"] [''] : "";
										$realproperties [$key1] ['areaunit'] = (isset ( $value1 ['landDetails'] ["area"] ['unit'] )) ? $value1 ['landDetails'] ["area"] ['unit'] : "";
										$realproperties [$key1] ['buildingarea'] = (isset ( $value1 ['buildingDetails'] ["area"] [''] )) ? $value1 ['buildingDetails'] ["area"] [''] : "";
									}
									else{
										$realproperties [$key1] ['landarea'] =  "";
										$realproperties [$key1] ['areaunit'] =  "";
										$realproperties [$key1] ['buildingarea'] =  "";
									}
									$realproperties [$key1] ['date_created'] = "";
									$realproperties [$key1] ['featured'] = false;
									$realproperties [$key1] ['latest'] = false;
									$realproperties [$key1] ['smsf'] = "";
									if ($value1 ['status'] == 'sold'){$realproperties [$key1] ['sold'] = true;}
									else{$realproperties [$key1] ['sold'] = false;}
									$realproperties [$key1] ['deposit'] = (isset ( $value1 ['underOffer'] ['value'] )) ? $value1 ['underOffer'] ['value'] : "";
									$realproperties [$key1] ['domacom'] = "";
										
									$realproperties [$key1] ['grade'] =  "";
									$realproperties [$key1] ['score'] = (isset ( $value1 ["Score"] )) ? $value1 ["Score"] * 1 : "";
										
									if (isset ( $value1 ["Grade"] ) && $value1 ["Grade"] == 'AA') {
										$realproperties [$key1] ['gradelabel'] = "Filter by grade: AA - a score equal or above 275";
									}
		
									elseif (isset ( $value1 ["Grade"] ) && $value1 ["Grade"] == 'A') {
										$realproperties [$key1] ['gradelabel'] = "Filter by grade: A - a score equal or above 215";
									}
		
									elseif (isset ( $value1 ["Grade"] ) && $value1 ["Grade"] == 'B') {
										$realproperties [$key1] ['gradelabel'] = "Filter by grade: B - a score equal or above 155";
									}
		
									elseif (isset ( $value1 ["Grade"] ) && $value1 ["Grade"] == 'C') {
										$realproperties [$key1] ['gradelabel'] = "Filter by grade: C - a score equal or above 95";
									}
		
									elseif (isset ( $value1 ["Grade"] ) && $value1 ["Grade"] == 'D') {
										$realproperties [$key1] ['gradelabel'] = "Filter by grade: D - a score less than 95";
									}
		
									else {
										$realproperties [$key1] ['gradelabel'] = "";
									}
		
									/* else {
										$realproperties [$key1] ['gradelabel'] = "Filter by grade: Any";
										} */
									$address = array ();
									$realproperties [$key1] ["address"] = array ();
									/*
									 * $realproperties[$key1]["address"]["display"] = (isset($value1["address"]["display"]))?$value1["address"]["display"] :"yes";
									 * $realproperties[$key1]["address"]["LotNumber"] = (isset($value1["address"]["LotNumber"]))?$value1["address"]["LotNumber"]:null;
									 * $realproperties[$key1]["address"]["StreetNumber"] = (isset($value1["address"]["streetNumber"]))?$value1["address"]["streetNumber"] :"";
									 * $realproperties[$key1]["address"]["street"] = (isset($value1["address"]["street"]))?$value1["address"]["street"] :"";
									 * $realproperties[$key1]["address"]["suburb"]['display'] = (isset($value1["address"]["suburb"]['display']))?$value1["address"]["suburb"]['display'] :"";
									 * $realproperties[$key1]["address"]["suburb"]['text'] = (isset($value1["address"]["suburb"]['']))?$value1["address"]["suburb"][''] :"";
									 * $realproperties[$key1]["address"]["state"] = (isset($value1["address"]["state"]))?$value1["address"]["state"] :"";
									 * $realproperties[$key1]["address"]["country"] = (isset($value1["address"]["country"]))?$value1["address"]["country"] :"";
									 * $realproperties[$key1]["address"]["postcode"] = (isset($value1["address"]["postcode"]))?$value1["address"]["postcode"] :"";
									*/
									$address [0] ["display"] = (isset ( $value1 ["address"] ["display"] )) ? $value1 ["address"] ["display"] : "yes";
									$address [0] ["LotNumber"] = (isset ( $value1 ["address"] ["LotNumber"] )) ? $value1 ["address"] ["LotNumber"] : null;
									/* 							$address [0] ["subNumber"] = (isset ( $value1 ["address"] ["subNumber"] )) ? $value1 ["address"] ["subNumber"] : null;
									 $address [0] ["StreetNumber"] = (isset ( $value1 ["address"] ["streetNumber"] )) ? $value1 ["address"] ["streetNumber"] : "";
									 */
										
									if(isset ( $value1 ["address"] ["subNumber"] ) && ($value1 ["address"] ["subNumber"] == [])){
										$address [0] ["subNumber"]= $value1 ["address"] ["subNumber"] = null;}
										else{
											$address [0] ["subNumber"] = (isset ( $value1 ["address"] ["subNumber"] )) ? $value1 ["address"] ["subNumber"] : null;
										}
										if(isset ( $value1 ["address"] ["streetNumber"] ) && ($value1 ["address"] ["streetNumber"] == [])){
											$address [0] ["StreetNumber"]= $value1 ["address"] ["streetNumber"] = "";}
											else{
												$address [0] ["StreetNumber"] = (isset ( $value1 ["address"] ["streetNumber"] )) ? $value1 ["address"] ["streetNumber"] : "";
											}
												
												
											$address [0] ["street"] = (isset ( $value1 ["address"] ["street"] )) ? $value1 ["address"] ["street"] : "";
											if(isset ( $value1 ["address"] ["suburb"])){
												$address [0] ["suburb"] ['display'] = (isset ( $value1 ["address"] ["suburb"] ['display'] )) ? $value1 ["address"] ["suburb"] ['display'] : "";
												$address [0] ["suburb"] ['text'] = (isset ( $value1 ["address"] ["suburb"] [''] )) ? $value1 ["address"] ["suburb"] [''] : "";
											} else{
												$address [0] ["suburb"] ['display'] =  "";
												$address [0] ["suburb"] ['text'] =  "";
											}
											$address [0] ["state"] = (isset ( $value1 ["address"] ["state"] )) ? $value1 ["address"] ["state"] : "";
											$address [0] ["country"] = (isset ( $value1 ["address"] ["country"] )) ? $value1 ["address"] ["country"] : "";
											$address [0] ["postcode"] = (isset ( $value1 ["address"] ["postcode"] )) ? $value1 ["address"] ["postcode"] : "";
												
											array_push ( $realproperties [$key1] ["address"], $address [0] );
												
											/*  $some = array();
											 array_push ( $some , $address [0] ["StreetNumber"]);
											 array_push ( $some , $address [0] ["street"]);
											 array_push ( $some , $address [0] ["suburb"] ['text']);
											 array_push ( $some , $address [0] ["state"]);
											 array_push ( $some , $address [0] ["country"]);
											 array_push ( $some , $address [0] ["postcode"]);
											 	
											 $city = join(' ',$some);
											 	
											 //$city = "382 Goulburn Valley Highway, SEYMOUR, VIC 3660";
											 	
											 $array = $this->lookup($city);
											 	
											 //$realproperties [$key1] ["cityAddress"] = $city;
		
		
											 $realproperties [$key1] ["coords"] ["latitude"] = $array['latitude'];
											 $realproperties [$key1] ["coords"] ["longitude"] =$array['longitude'];
		
		
											 if($realproperties [$key1] ["coords"] ["longitude"]==null){
											 	
											 while($realproperties [$key1] ["coords"] ["longitude"]==null){
											 	
											 $array = $this->lookup($city);
											 //print_r($array);die;
		
											 $realproperties [$key1] ["cityAddress"] = $city;
		
		
											 $realproperties [$key1] ["coords"] ["latitude"] = $array['latitude'];
											 $realproperties [$key1] ["coords"] ["longitude"] =$array['longitude'];
											 }
											} */
		
												
											$realproperties [$key1] ["coords"] ["latitude"] = null;
											$realproperties [$key1] ["coords"] ["longitude"] =null;
												
												
											// echo(isset($value1["images"]["img"]["id"]));
												
												
											if($address [0] ["suburb"] ['text'] == "" && $value1 ['status'] == 'sold'){
												$realproperties [$key1] ['offline'] = true;
											}
											else{
												$realproperties [$key1] ['offline'] = false;
											}
												
												
											if (! isset ( $value1 ["images"] ["img"] )) {
												$realproperties [$key1] ['images'] = array();
											} else {
												if (isset ( $value1 ["images"] ["img"] ["id"] )) {
													$realproperties [$key1] ['images'][0]['id'] = 0;
													$realproperties [$key1] ['images'][0]['url'] = $value1 ['images'] ["img"] ["url"];
												}
		
												else {
														
													foreach ( $value1 ["images"] ["img"] as $key2 => $image ) {
														//echo"within for each";
														// print_r($value1["images"]);
														// echo $key2;print_r($image);
		
														$realproperties [$key1] ['images'] [$key2] ['id'] = $key2;
														$realproperties [$key1] ['images'] [$key2] ['url'] = (isset ( $image ["url"] )) ?  $image ["url"] : "";
															
													}
												}
											}
												
											if (! isset ( $value1 ["objects"] ["img"] )) {
												//$realproperties [$key1] ['images'] = array();
											} else {
												if (isset ( $value1 ["objects"] ["img"] ["id"] )) {
													$realproperties [$key1] ['images'][0]['id'] = 0;
													$realproperties [$key1] ['images'][0]['url'] = $value1 ['objects'] ["img"] ["url"];
												}
													
												else {
													foreach ( $value1 ["objects"] ["img"] as $key11 => $image ) {
															
														// print_r($value1["images"]);
														// echo $key10;print_r($image);
															
														$realproperties [$key1] ['images'] [$key11] ['id'] = $key11;
														$realproperties [$key1] ['images'] [$key11] ['url'] = (isset ( $image ["url"] )) ?  $image ["url"] : "";
													}
												}
											}
											$realproperties [$key1] ['documents'] = array();
											if (! isset ( $value1 ["objects"] ["document"] )) {
		
											} else {
												if (isset ( $value1 ["objects"] ["document"] ["id"] )) {
													$realproperties [$key1] ['documents'][0]['id'] = 0;
													$realproperties [$key1] ['documents'][0]['url'] = $value1 ["objects"] ['document']["url"];
												}
													
												else {
													foreach ( $value1 ["objects"] ["document"] as $key12 => $image ) {
															
														// print_r($value1["images"]);
														// echo $key2;print_r($image);
															
														$realproperties [$key1] ['documents'] [$key12] ['id'] = $key12;
														$realproperties [$key1] ['documents'] [$key12] ['url'] = (isset ( $image ["url"] )) ?  $image ["url"] : "";
													}
												}
											}
												
											if (isset ( $value1 ["features"] )) {
												foreach($value1["features"] as $key4 => $feature) {
														
													if(sizeOf($feature)>1  && isset($feature['type'])){
														$realproperties [$key1] ['features'] [$key4] = $feature['type'];
													}
														
													else if(sizeOf($feature)>1  && !isset($feature['type'])){
		
													}
														
													// print_r($value1["images"]);
													// echo $key2;print_r($image);
														
													else{
														$realproperties [$key1] ['features'] [$key4] = $feature;
													}
												}
											}
												
											if(isset ($value1 ["ecoFriendly"] )) {
													
												foreach($value1["ecoFriendly"] as $key6 => $ecofriendly) {
														
													$realproperties [$key1] ['ecoFriendly'] [$key6] = $ecofriendly;
												}
													
											}else{
												$realproperties [$key1] ['ecoFriendly'] = array();
											}
												
											if(isset ($value1 ["idealFor"] )) {
		
												foreach($value1["idealFor"] as $key6 => $idealfor) {
		
													$realproperties [$key1] ['idealFor'] [$key6] = $idealfor;
												}
											}else{
												//echo ($value1 ["idealFor"] );
												$realproperties [$key1] ['idealFor'] = array();
											}
												
												
												
											if(isset ($value1 ["views"] )) {
												foreach($value1["views"] as $key7 => $view) {
														
													$realproperties [$key1] ['views'] [$key7] = $view;
												}
											}
											else{
												//echo ($value1 ["views"] );
												$realproperties [$key1] ['views'] = array();
											}
												
												
											$realproperties [$key1] ['estimate'] = array ();
											$realproperties [$key1] ['contract'] = array ();
											$realproperties [$key1] ['sale_summary'] = array ();
											$realproperties [$key1] ['history'] = array ();
											$realproperties [$key1] ['how_to_buy'] = array ();
											$realproperties [$key1] ['loan_cal'] = array ();
											$realproperties [$key1] ['invest_cal'] = array ();
											$realproperties [$key1] ['support_info'] = array ();
												
											// print_r($value1["objects"]["floorplan"]);
												
											if (! isset ( $value1 ["objects"] ["floorplan"] )) {
		
												$realproperties [$key1] ['floorplans'] = array ();
											} else {
		
												// echo isset($value1["objects"]["floorplan"]["id"]);
												if (isset ( $value1 ["objects"] ["floorplan"] ["id"] )) {
													// echo isset($value1["objects"]["floorplan"]["id"]);
													$realproperties [$key1] ['floorplans'] [0] ['id'] = 0;
													$realproperties [$key1] ['floorplans'] [0] ['title'] = "";
													$realproperties [$key1] ['floorplans'] [0] ['url'] = $value1 ['objects'] ["floorplan"] ["url"];
												}
		
												else {
													// echo isset($value1["objects"]["floorplan"]["id"]);
													foreach ( $value1 ["objects"] ["floorplan"] as $key3 => $floorplan ) {
		
														// print_r($value1["objects"]);
														// echo $key3;//
														// print_r($floorplan);
														$realproperties [$key1] ['floorplans'] [$key3] ['id'] = $key3;
														$realproperties [$key1] ['floorplans'] [$key3]['title'] = "";
														$realproperties [$key1] ['floorplans'] [$key3] ['url'] = $floorplan ["url"];
													}
												}
											}
												
												
												
											if (! isset ( $value1 ["inspectionTimes"] ["inspection"] )) {
												$realproperties [$key1] ['inspectionTimes'] = array ();
											} else {
		
												if (( isset ( $value1 ["inspectionTimes"] ["inspection"] ) ) && (count( $value1 ['inspectionTimes'] ["inspection"])==1)){
														
													$realproperties [$key1]['inspectionTimes'][0]['id'] = 0;
													$realproperties[$key1]['inspectionTimes'][0]['inspection'] = $value1 ["inspectionTimes"] ["inspection"];
														
												}
		
												elseif(( isset ( $value1 ["inspectionTimes"] ["inspection"] ) ) && (count( $value1 ['inspectionTimes'] ["inspection"])>1)){
													//echo "xxxxxxxxxxxxxxxxxxxxxxxx" . (count( $value1 ['inspectionTimes'] ["inspection"]));
														
		
											  foreach ($value1["inspectionTimes"]["inspection"] as $key5 => $inspection) {
											  	$realproperties [$key1] ['inspectionTimes'] [$key5] ['id'] = $key5;
											  	$realproperties[$key1]['inspectionTimes'][$key5]['inspection'] = $inspection;
											  }
		
												}
											}
												
											$realproperties [$key1] ['ipr'] = array ();
											$realproperties [$key1] ['description'] = (isset ( $value1 ['description'] )) ? $value1 ['description'] : "";
											$realproperties [$key1] ['observation'] = "";
											$key1 ++;
								}
									
							}
								
						}
							
					}
						
					//////////Q///////////////
				}
				//print_r($realproperties);
					
					
					
					
				// Convert Array to JSON String
					
				$results ['realproperties'] = $realproperties;
					
				$realpropertyArrayObject = new ArrayObject ( $realproperties );
				$copy = $realpropertyArrayObject->getArrayCopy ();
				// print_r($copy);
				//$someJSON = json_encode ( $results, JSON_PRETTY_PRINT );
				$someJSON = json_encode ( $results);
				//echo nl2br($someJSON);
				//print_r($realproperties);
					
				// Log to a MongoDB log collection
					
				//$m1 = new MongoClient ();
					
				//$serUrl = Configure::read('LOCAL_CONN');
		
				 
					
				//$response = $collection->drop(); // DFROPING DB
					
				//RE-INSTANTIATE
					
				//$db2 = $m1->properties;
		
				//$collection = $m1->$db2->realprop;
					
				// $document = array();
					
				// array_push($document, $realproperties);
					
				// $collection->insert($document);
				$max = sizeOf ( $realproperties );
					
				// $doc1 = array_chunk($realproperties[0], 39);
				// print_r($realproperties);
					
				/*
				 * $collection->insert($realproperties[0]);
				 * $collection->insert($realproperties[1]);
				 * $collection->insert($realproperties[2]);
				 * $collection->insert($realproperties[3]);
				*/
					
				// $collection2 = $m1->$db2->realpropcopy;
				/*
				 * for ($i = 0; $i <$max; $i++) {
				 * echo $iod= $realproperties[$i]['id'];
				 * $dbid=$realproperties['id'];
				 * //if($iod)
					 * }
				*/
					
				$collection->ensureIndex ( array (
						'id' => 1
				), array (
						"unique" => true
				) );
					
					
				$cursor12 = $collection->find ();
					
				//$cursor1 = $collection->find ();
				// var_dump($collection->count());
				while ( $cursor12->hasNext () ) {
					// var_dump( $cursor12->getNext() );
		
					foreach ( $cursor12 as $realproperties ) {
							
						// echo "cpxprice" . $realproperties['cpxprice']."<br/>";
						// echo $realproperties['id']."<br/>";
					}
				}
				$cursor13 = $collection->find ();
					
				while ( $cursor13->hasNext () ) {
					// var_dump( $cursor12->getNext() );
		
					foreach ( $cursor13 as $co ) {
							
						// echo "cpxprice" . $co['cpxprice']."<br/>";
							
						// echo $co['id']."<br/>";
							
						for($i = 0; $i < $max; $i ++) {
							// echo $co['id']."<br/>";
							// echo $co['id']."=".$copy[$i]['id'];
							// echo ($co['id']==$copy[$i]['id'])."<br/>";
							// var_dump($copy[$i]['id']);
		
							if ($co ['id'] == $copy [$i] ['id']) {
		
								// echo $co['modifiedon']." ";
								//echo $co ['id']."=>".$copy [$i] ['id']."<br>";
								$datearray = date_create_from_format ( 'Y-m-d-H:i:s', $copy [$i] ['modifiedon'] );
								$datedb = date_create_from_format ( 'Y-m-d-H:i:s', $co ['modifiedon'] );
								$arraymoddate = date_format ( $datearray, 'Y-m-d' );
								$dbmoddate = date_format ( $datedb, 'Y-m-d' );
									
								// echo $arraymoddate."<br/>";
								// echo $dbmoddate."<br/>";
								// var_dump($arraymoddate > $dbmoddate);
								if ($arraymoddate > $dbmoddate) {
									// var_dump($copy[$i]['status']);
									if ($copy [$i] ['status'] == 'current' || $copy [$i] ['status'] == 'sold') {
										echo "in update"  .$copy [$i] ['id'] ."<br/>";
											
										$newquery = array (
												"id" => $copy [$i] ['id']
										);
										// $article = $collection->findOne($newquery);
										// var_dump($article);
										// var_dump($copy[$i]);
										// $result=array_diff($copy[$i],$article);
										// var_dump($result);
											
										$retval = $collection->findAndModify ( $newquery, array (
												'$set' => array (
														"modifiedon" => $copy [$i] ['modifiedon'],
														"name" => $copy [$i] ['name'],
														"authority" => $copy [$i] ['authority'],
														"auction_date" => $copy [$i] ['auction_date'],
														"category" => $copy [$i] ['category'],
														"contact" => $copy [$i] ['contact'],
														/*  "cpxprice" => $copy [$i] ['cpxprice'],  */
														"listedprice" => $copy [$i] ['listedprice'],
														"viewprice" => $copy [$i] ['viewprice'],
														/* "saving" => $copy [$i] ['saving'],
															"marketrent" => $copy [$i] ['marketrent'], */
														"beds" => $copy [$i] ['beds'],
														"bath" => $copy [$i] ['bath'],
														"cars" => $copy [$i] ['cars'],
														"IsHouseLandPackage" => $copy [$i] ['IsHouseLandPackage'],
														"landarea" => $copy [$i] ['landarea'],
														"areaunit" => $copy [$i] ['areaunit'],
														"buildingarea" => $copy [$i] ['buildingarea'],
														"date_created" => $copy [$i] ['date_created'],
														/* "featured" => $copy [$i] ['featured'],
															"latest" => $copy [$i] ['latest'],
														"smsf" => $copy [$i] ['smsf'], */
														"cars" => $copy [$i] ['cars'],
														"sold" => $copy [$i] ['sold'],
														"deposit" => $copy [$i] ['deposit'],
														/*"domacom" => $copy [$i] ['domacom'],
														 "grade" => $copy [$i] ['grade'],
														"score" => $copy [$i] ['score'],
														"gradelabel" => $copy [$i] ['gradelabel'], */
														"address" => $copy [$i] ['address'],
														"images" => $copy [$i] ['images'],
														"features" => $copy [$i] ['features'],
														/* "estimate" => $copy [$i] ['estimate'],
															"contract" => $copy [$i] ['contract'],
														"sale_summary" => $copy [$i] ['sale_summary'],
														"history" => $copy [$i] ['history'],
														"how_to_buy" => $copy [$i] ['how_to_buy'],
														"loan_cal" => $copy [$i] ['loan_cal'],
														"invest_cal" => $copy [$i] ['invest_cal'], */
														"support_info" => $copy [$i] ['support_info'],
														"documents" => $copy [$i] ['documents'],
														"floorplans" => $copy [$i] ['floorplans'],
														"inspectionTimes" => $copy [$i] ['inspectionTimes'],
														/* "ipr" => $copy [$i] ['ipr'], */
														"description" => $copy [$i] ['description'],
														"observation" => $copy [$i] ['observation']
												)
		
										), null, array (
												"sort" => array (
														"priority" => - 1
												),
												"new" => true,
												array ("safe" => true),
													
										) );
											
		
											
										//var_dump($retval);
											
										//echo 'Saving:'.$retval['saving']."<br>";
											
										if($retval['saving'] == 0){
											$retval = $collection->findAndModify ( $newquery, array (
													'$set' => array (
															"cpxprice" => $copy [$i] ['cpxprice'],
													)
		
											), null, array (
													"sort" => array (
															"priority" => - 1
													),
													"new" => true,
													array ("safe" => true),
														
											) );
												
											//echo "savings 0"	;
										}
										else{//echo "savings NON0"	;
										}
											
									}
		
									else {
											
										// echo "in delete";
										// DELETE
										$newquery = array (
												"id" => $copy [$i] ['id']
										);
											
										$retval = $collection->findAndModify ( $newquery, null, null, array (
													
												"remove" => true
										) );
		
											
									}
								}
							}
		
							else {
									
								if ($copy [$i] ['status'] == 'current' || $copy [$i] ['status'] == 'sold') {
									// insert
		
									// echo "in insert";
		
									try {
											
										$collection->insert ( $copy [$i], array (
												"safe" => true
										) );
										// Add unique index for field 'asda'
										$collection->ensureIndex ( array (
												'id' => 1
										), array (
												"unique" => true
										) );
											
										// echo "ADDED from ELSE";
									} catch ( MongoCursorException $e ) {
										// echo "Error: " . $e->getMessage()."\n";
										// error_log("You messed up!", 3, "c:/wamp/logs/xml2jsonconverter.log");
										error_log ( $e->getMessage () . "\n" );
									}
								}
							}
						}
					}
				}
					
				for($i = 0; $i < $max; $i ++) {
		
					// echo ($copy[$i]['status']=='current');
					if ($copy [$i] ['status'] == 'current') {
						try {
		
							$collection->insert ( $copy [$i], array (
									"safe" => true
							) );
							// Add unique index for field 'asda'
							$collection->ensureIndex ( array (
									'id' => 1
							), array (
									"unique" => true,
									'dropDups' => true
							) );
		
							// echo "Added";
						} catch ( MongoCursorException $e ) {
							// echo "Error: " . $e->getMessage()."\n";
							error_log ( $e->getMessage () . "\n" );
						}
					}
				}
		
			}
		
			// MOVING FILES
		
		
		
		
			/*  $files = scandir($dir);
			 	
			// Identify directories
			$source = localfolderUrl."/";
			$destination = parsedurl."/";
			// Cycle through all source files
			foreach ($files as $file) {
			if (in_array($file, array(".",".."))) continue;
			// If we copied this successfully, mark it for deletion
			if (copy($source.$file, $destination.$file)) {
			$delete[] = $source.$file;
			}
			}
			// Delete all successfully-copied files
			foreach ($delete as $file) {
			echo " : deleting <br/>";
			unlink($file);
			}  */
		
			$parsingfiles = scandir ( $dir, 1 );
		
			//$parsingfiles = glob($dir.'/*.xml');
		
			foreach ( $parsingfiles as &$value ) {
				//$value = substr($value, strrpos($value, '/') + 1);
				$value = $value;
				//$value = (realpath ( $dir )) . "\\" . $value;
			}
		
		
			//print_r($parsingfiles);
		
			$source = $dir."/";
			$destination = $parseddir."/";
			//if (in_array($parsingfiles[$r], array(".",".."))) continue;
			copy($source.$parsingfiles[$r], $destination.$parsingfiles[$r]);
		
			$delete[] = $source.$parsingfiles[$r];
				
			//usleep(2000000);
		
		
		
		
		
		}
		
		
		
		//print_r($delete);
		if( !empty( $delete ) ){
			$this ->deleteFiles($delete);
		}
		
		else{}
		
		
		$dhj = array ();
		
		
		
		foreach ( $collection->find () as $result ) {
			// print_r($result);
				
			array_push ( $dhj, $result );
				
			// $someBSON = bson_decode($result);
			// print_r($dhj);
		}
		$newarray ["cpxpropertynow"] = $dhj;
		// print_r($newarray);
		$lomeJSON = json_encode ( $newarray, JSON_PRETTY_PRINT );
		//echo nl2br ( $lomeJSON );
		
		$fruitQuery = array (
				'cpxprice' => '699000'
		);
		$query = array (
				"cpxprice" => array (
						'$gt' => '710000'
				)
		);
		/*
		 * $newquery = array("id" =>"addedded");
		 *
		 * $retval = $collection->findAndModify(
		 * $newquery,
		 * array('$set' => array('id' => 'XXXXXXX', "cpxprice" => "99999999")),
		 * null,
		 * array(
		 * "sort" => array("priority" => -1),
		 * "new" => true,
		 * )
		 *
		 * );
		*/
		// var_dump($retval);
		
		$cursor12 = $collection->find ();
		
		$cursor1 = $collection->find ();
		while ( $cursor12->hasNext () ) {
			// var_dump( $cursor12->getNext() );
				
			foreach ( $cursor12 as $realproperties ) {
		
				// echo "cpxprice" . $realproperties['cpxprice']."<br/>";
				// echo ($collection->count())." : ".($realproperties['id'])."<br/>";
			}
		}
		
		
	}
	
	public function xmlToArray($xml, $options = array()) {
		$defaults = array (
				'namespaceSeparator' => ':', // you may want this to be something other than a colon
				'attributePrefix' => '', // to distinguish between attributes and nodes with the same name
				'alwaysArray' => array (), // array of xml tag names which should always become arrays
				'autoArray' => true, // only create arrays for tags which appear more than once
				'textContent' => '', // key used for the text content of elements
				'autoText' => true, // skip textContent key if node has no attributes or child nodes
				'keySearch' => false, // optional search and replace on tag and attribute names
				'keyReplace' => false
		); // replace values for above search values (as passed to str_replace())
	
		$options = array_merge ( $defaults, $options );
		$namespaces = $xml->getDocNamespaces ();
		$namespaces [''] = null; // add base (empty) namespace
		 
		// get attributes from all namespaces
		$attributesArray = array ();
		foreach ( $namespaces as $prefix => $namespace ) {
			foreach ( $xml->attributes ( $namespace ) as $attributeName => $attribute ) {
				// replace characters in attribute name
				if ($options ['keySearch'])
					$attributeName = str_replace ( $options ['keySearch'], $options ['keyReplace'], $attributeName );
				$attributeKey = $options ['attributePrefix'] . ($prefix ? $prefix . $options ['namespaceSeparator'] : '') . $attributeName;
				$attributesArray [$attributeKey] = ( string ) $attribute;
			}
		}
	
		// get child nodes from all namespaces
		$tagsArray = array ();
		foreach ( $namespaces as $prefix => $namespace ) {
			foreach ( $xml->children ( $namespace ) as $childXml ) {
				// recurse into child nodes
				$childArray = $this->xmlToArray ( $childXml, $options );
				list ( $childTagName, $childProperties ) = each ( $childArray );
	
				// replace characters in tag name
				if ($options ['keySearch'])
					$childTagName = str_replace ( $options ['keySearch'], $options ['keyReplace'], $childTagName );
				// add namespace prefix, if any
				if ($prefix)
					$childTagName = $prefix . $options ['namespaceSeparator'] . $childTagName;
	
				if (! isset ( $tagsArray [$childTagName] )) {
					// only entry with this key
					// test if tags of this type should always be arrays, no matter the element count
					$tagsArray [$childTagName] = in_array ( $childTagName, $options ['alwaysArray'] ) || ! $options ['autoArray'] ? array (
							$childProperties
					) : $childProperties;
				} elseif (is_array ( $tagsArray [$childTagName] ) && array_keys ( $tagsArray [$childTagName] ) === range ( 0, count ( $tagsArray [$childTagName] ) - 1 )) {
					// key already exists and is integer indexed array
					$tagsArray [$childTagName] [] = $childProperties;
				} else {
					// key exists so convert to integer indexed array with previous value in position 0
					$tagsArray [$childTagName] = array (
							$tagsArray [$childTagName],
							$childProperties
					);
				}
			}
		}
	
		// get text content of node
		$textContentArray = array ();
		$plainText = trim ( ( string ) $xml );
		if ($plainText !== '')
			$textContentArray [$options ['textContent']] = $plainText;
			
		// stick it all together
		$propertiesArray = ! $options ['autoText'] || $attributesArray || $tagsArray || ($plainText === '') ? array_merge ( $attributesArray, $tagsArray, $textContentArray ) : $plainText;
	
		// return node as array
		return array (
				$xml->getName () => $propertiesArray
		);
	
		// echo $propertiesArray;die;
	}
	
	public function isValidXml($doc){
		 
		$dom = new DOMDocument;
		$dom->loadXML($doc);
		if (!$dom) {
			echo 'Error while parsing the document';
			exit;
		}
	}
	
	
	
	public  function deleteFiles($del){
		// Delete all successfully-copied files
		foreach ($del as $file) {
			echo " : deleting : " .$file. " <br/>";
			unlink($file);
		}
	}
	
}