<?php
class JsonconverterController extends AppController {
	public $helpers = array('Html', 'Form');
	public $components = array('RequestHandler');



	     public function index() {
	     	
	     	
	     	
	     	$json = file_get_contents('http://graded.centralpropertyexchange.com.au/data/cpx-advertisements.json');
	     	$data1 = json_decode($json, true);
	     	
	     	$someJSON = json_encode($data1['Advertisements']);
	     	
	     	//print_r($jsonfromurl); 
	     	
	
	     	// JSON string
	     //	$someJSON = '[{"Headline":"EDEN PARK","Type":"residential","Category":"house","Key":"4942","CPXPrice":355000.0,"ListedPrice":365000.0,"Saving":10000.0,"Rent":320.0,"Beds":"3","Baths":"2","Cars":"1","IsHouseLandPackage":"no","ExternalSize":"255","BuildingSize":"144.52","ReviewId":"712ce3dd-e648-4450-9c37-dbee39d7fe03","ReviewDataUri":"http://api.propdata.com.au/review/712ce3dd-e648-4450-9c37-dbee39d7fe03","Grade":"B","Score":"200","Address":{"LotNumber":"Lot 220","StreetNumber":null,"Street":"Oscar Circuit","Locality":"Roxburgh Park","Region":"VIC","Country":"Australia","PostCode":"3064","Lat":"-37.6315441","Lon":"144.9237825"},"Images":["http://cdn.cpx.net.au/image?id=65529","http://cdn.cpx.net.au/image?id=65530","http://cdn.cpx.net.au/image?id=65531","http://cdn.cpx.net.au/image?id=65532","http://cdn.cpx.net.au/image?id=65528"],"Documents":[{"Title":"Independant Property Review","Uri":"http://cdn.cpx.net.au/reports/independent/ipr/download/712ce3dd-e648-4450-9c37-dbee39d7fe03"},{"Title":"Brochure","Uri":"http://static.centralpropertyexchange.com.au.s3.amazonaws.com/VillaWorld/EDEN%20PARK/Brochure.pdf"},{"Title":"VillaWorld Quality Promise","Uri":"http://static.centralpropertyexchange.com.au.s3.amazonaws.com/VillaWorld/EDEN%20PARK/VillaWorld%20Quality%20Promise.pdf"},{"Title":"Inclusions","Uri":"http://static.centralpropertyexchange.com.au.s3.amazonaws.com/VillaWorld/EDEN%20PARK/Inclusions.pdf"},{"Title":"Floor plan","Uri":"http://static.centralpropertyexchange.com.au.s3.amazonaws.com/VillaWorld/EDEN%20PARK/Lot%20220%20-%20Melaleuca%20IV%20220Plan.pdf"}],"Floorplans":null},{"Headline":"PARKVIEW","Type":"residential","Category":"house","Key":"4941","CPXPrice":400000.0,"ListedPrice":410000.0,"Saving":10000.0,"Rent":340.0,"Beds":"4","Baths":"2","Cars":"2","IsHouseLandPackage":"no","ExternalSize":"336","BuildingSize":"207.35","ReviewId":"ccfd26ff-1066-40e3-b6ac-d0f70ab7fb5b","ReviewDataUri":"http://api.propdata.com.au/review/ccfd26ff-1066-40e3-b6ac-d0f70ab7fb5b","Grade":"B","Score":"205","Address":{"LotNumber":"Lot 75","StreetNumber":null,"Street":"Westbury Drive","Locality":"Truganina","Region":"VIC","Country":"Australia","PostCode":"3029","Lat":"-37.8522302","Lon":"144.7267248"},"Images":["http://cdn.cpx.net.au/image?id=65527","http://cdn.cpx.net.au/image?id=65983","http://cdn.cpx.net.au/image?id=65526"],"Documents":[{"Title":"Independant Property Review","Uri":"http://cdn.cpx.net.au/reports/independent/ipr/download/ccfd26ff-1066-40e3-b6ac-d0f70ab7fb5b"},{"Title":"Brochure","Uri":"http://static.centralpropertyexchange.com.au.s3.amazonaws.com/VillaWorld/PARKVIEW/Brochure.pdf"},{"Title":"Floor plan","Uri":"http://static.centralpropertyexchange.com.au.s3.amazonaws.com/VillaWorld/PARKVIEW/FloorPlan-Lot-75-Crescent%20I%20162%20MR.pdf"}],"Floorplans":null},{"Headline":"538 North","Type":"residential","Category":"apartment","Key":"4931","CPXPrice":362875.0,"ListedPrice":375000.0,"Saving":12125.0,"Rent":320.0,"Beds":"1","Baths":"1","Cars":"1","IsHouseLandPackage":"no","ExternalSize":"9","BuildingSize":"50","ReviewId":"fe5d7f3f-383d-4170-a349-c200167d8499","ReviewDataUri":"http://api.propdata.com.au/review/fe5d7f3f-383d-4170-a349-c200167d8499","Grade":"B","Score":"190","Address":{"LotNumber":null,"StreetNumber":"1.15","Street":"538 North Rd","Locality":"Ormond","Region":"VIC","Country":"Australia","PostCode":"3204","Lat":"-37.903855","Lon":"145.0388196"},"Images":["http://cdn.cpx.net.au/image?id=65341","http://cdn.cpx.net.au/image?id=65342","http://cdn.cpx.net.au/image?id=65340"],"Documents":[{"Title":"Independant Property Review","Uri":"http://cdn.cpx.net.au/reports/independent/ipr/download/fe5d7f3f-383d-4170-a349-c200167d8499"},{"Title":"Contract of Sale","Uri":"http://static.centralpropertyexchange.com.au/538North/NorthRdOrmondCOS.pdf"},{"Title":"Brochure","Uri":"http://static.centralpropertyexchange.com.au/538North/Brochure-538North.pdf"},{"Title":"Inclusions","Uri":"http://static.centralpropertyexchange.com.au/538North/Inclusions.pdf"}],"Floorplans":["http://cdn.cpx.net.au/image?id=65343","http://cdn.cpx.net.au/image?id=65472"]}]';
	     	
	     	// Convert JSON string to Array
	     	$someArray = json_decode($someJSON, true);
	     	//print_r($someArray);        // Dump all data of the Array
	     	//echo $someArray[0]["name"]; // Access Array data
	     	
	     	// Convert JSON string to Object
// 	     	$someObject = json_decode($someJSON);
// 	     	print_r($someObject);      // Dump all data of the Object
// 	     	//echo $someObject[0]->name; // Access Object data
	     	
	     	

	     	
	     	$properties = array();
	     	foreach ($someArray as $key => $value) {
	     		
	     		
	     		
	     		$properties[$key]['id'] = $value["Key"];
	     		$properties[$key]['gradestatus'] = 2;
	     		$properties[$key]['modifiedon'] = "";
	     		$properties[$key]['status'] = "current";
	     		$properties[$key]['headline'] = "";
	     		$properties[$key]['name'] = $value["Headline"];
	     		
	     		$properties[$key]['authority'] = "";
	     		$properties[$key]['auction_date'] = "";
	     		
	     		
	     		$properties[$key]['type'] = $value["Type"];
	     		$properties[$key]['category'] = $value["Category"];
	     		
	     		$properties[$key]['contact']['name'] = "";
	     		$properties[$key]['contact']['telephoneType'] = "";
	     		$properties[$key]['contact']['telephone'] = "";
	     		$properties[$key]['contact']['email'] = "";
	     		
// 	     		$cpxprice = strval($value["CPXPrice"]);
// 	     		$listedprice = strval($value["ListedPrice"]);
// 	     		$saving = strval($value["Saving"]);
// 	     		$rent = strval($value["Rent"]);
	     		
	     		$properties[$key]['cpxprice'] = $value["CPXPrice"];
	     		$properties[$key]['listedprice'] = $value["ListedPrice"];
	     		$properties[$key]['viewprice'] = 0;
	     		$properties[$key]['saving'] = $value["Saving"];
	     		$properties[$key]['marketrent'] =$value["Rent"];
	     		
	     		$properties[$key]['beds'] = $value["Beds"];
	     		$properties[$key]['bath'] = $value["Baths"];
	     		$properties[$key]['cars'] = $value["Cars"];
	     		
	     		$properties[$key]['IsHouseLandPackage'] = $value["IsHouseLandPackage"];
	     		$properties[$key]['landarea'] = $value["ExternalSize"];
	     		$properties[$key]['areaunit'] ="";
	     		$properties[$key]['buildingarea'] = $value["BuildingSize"];
	     		
	     		$properties[$key]['date_created'] = "";
	     		$properties[$key]['featured'] = true;
	     		$properties[$key]['latest'] = true;
	     		$properties[$key]['smsf'] = "";
	     		$properties[$key]['sold'] = "";
	     		$properties[$key]['deposit'] = "";
	     		$properties[$key]['domacom'] = "";
	     		
	     		$properties[$key]['grade'] = $value["Grade"];
	     		$properties[$key]['score'] = $value["Score"] * 1;
	     		
	     					
	     		
	     					if($value["Grade"] == 'AA'){
	     					$properties[$key]['gradelabel'] = "Filter by grade: AA - a score equal or above 275";
	     					}
	     					
	     					elseif ($value["Grade"] == 'A'){
	     						$properties[$key]['gradelabel'] = "Filter by grade: A - a score equal or above 215";
	     					}
	     					
	     					elseif ($value["Grade"] == 'B'){
	     						$properties[$key]['gradelabel'] = "Filter by grade: B - a score equal or above 155";
	     					}
	     					
	     					elseif ($value["Grade"] == 'C'){
	     						$properties[$key]['gradelabel'] = "Filter by grade: C - a score equal or above 95";
	     					}
	     					
	     					elseif ($value["Grade"] == 'D'){
	     						$properties[$key]['gradelabel'] = "Filter by grade: D - a score less than 95";
	     					}	
	     					
	     					elseif ($value["Grade"] == ''){
	     						$properties[$key]['gradelabel'] = "Filter by: Not graded (all)";
	     					}
	     					
	     					else
	     					{
	     						$properties[$key]['gradelabel'] = "Filter by grade: Any";
	     					}	
	     					
	     		$properties[$key]["address"][0]["display"] = "yes";
	     		$properties[$key]["address"][0]["LotNumber"] = $value["Address"]["LotNumber"];
	     		$properties[$key]["address"][0]["StreetNumber"] = $value["Address"]["StreetNumber"];
	     		
	     		$properties[$key]["address"][0]["street"] = $value["Address"]["Street"];
	     		$properties[$key]["address"][0]["suburb"]["display"] = "yes";
	     		$properties[$key]["address"][0]["suburb"]["text"] = $value["Address"]["Locality"];
	     		$properties[$key]["address"][0]["state"] = $value["Address"]["Region"];
	     		$properties[$key]["address"][0]["country"] = $value["Address"]["Country"];	     		
	     		$properties[$key]["address"][0]["postcode"] = $value["Address"]["PostCode"];

	     					/* $properties[$key]["address"]["LotNumber"] = $value["Address"]["LotNumber"];
	     					$properties[$key]["address"]["StreetNumber"] = $value["Address"]["StreetNumber"];
	     					
	     					$properties[$key]["address"]["street"] = $value["Address"]["Street"];
	     					$properties[$key]["address"]["suburb"] = $value["Address"]["Locality"];
	     					$properties[$key]["address"]["state"] = $value["Address"]["Region"];
	     					$properties[$key]["address"]["country"] = $value["Address"]["Country"];
	     					$properties[$key]["address"]["postcode"] = $value["Address"]["PostCode"]; */
	     					   					
	     		
	     		$properties[$key]["coords"]["latitude"] = $value["Address"]["Lat"];
	     		$properties[$key]["coords"]["longitude"] = $value["Address"]["Lon"];
	     		
	     		
	     		foreach ($value["Images"] as $key2 => $image) {
	     			
	     			$properties[$key]['images'][$key2]['id'] = $key2;
	     			$properties[$key]['images'][$key2]['url'] = $image;
	     			
	     		}
	     		
	     		
	     		$properties[$key]['features'] = array();
	     		
	     		$properties[$key]['estimate'] = array();
	     		$properties[$key]['contract'] = array();
	     		$properties[$key]['sale_summary'] = array();
	     		$properties[$key]['history'] = array();
	     		$properties[$key]['how_to_buy'] = array();
	     		$properties[$key]['loan_cal'] = array();
	     		$properties[$key]['invest_cal'] = array();
	     		
	     		
	     		$properties[$key]['support_info'] = array();
	     		$properties[$key]['floorplans'] = array();
	     		
	     		
	     		foreach ($value["Documents"] as $key3 => $doc) {
	     			 
	     			
	     			if((strcasecmp($doc['Title'], 'Independant Property Review') == 0)){
	     			$properties[$key]["ipr"][0]["url"] = $doc['Uri'];
	     			}
	     			elseif ((strcasecmp($doc['Title'], 'Contract of Sale') == 0)){
	     				
	     			array_push($properties[$key]['contract'],$doc);
	     			}
	     			elseif ((strcasecmp($doc['Title'], 'Floor plans') == 0)){
	     				
	     			$properties[$key]['floorplans'][0]['id'] = 0;
	     			$properties[$key]['floorplans'][0]['title'] = "Floor plans";
	     			$properties[$key]['floorplans'][0]['url'] = $doc['Uri'];
	     			}
	     			
	     			
	     			
	     			else 
	     			{array_push($properties[$key]['support_info'],$doc);}
	     				
	     				
	     		}
	     		
	     		
	     		
	     		
	     		if ($properties[$key]['grade'] != null){
	     			
	     			
	     			
	     			$url = $value["ReviewDataUri"];
	     			$xmldata = file_get_contents($url);
	     			$xmlArray = json_decode($xmldata, true);
	     			 
	     			
	     			
	     		$properties[$key]['observation'] = $xmlArray['Content']['Sections'][0]['Text'];
	     			
	     			
	     				
	     		//$properties[$key]["ipr"][0]["url"] = "";
	     		$properties[$key]["ipr"][0]["propertyGrade"] = array();
	     		
	     		
	     		$properties[$key]["ipr"][0]["propertyGrade"][0]["name"] = "Historical growth rate";
	     		$properties[$key]["ipr"][0]["propertyGrade"][0]["value"] = $xmlArray['Content']['Grading']['Grades'][0]['Score'] / 10;
	     		
	     		$properties[$key]["ipr"][0]["propertyGrade"][1]["name"] = "Price risk";
	     		$properties[$key]["ipr"][0]["propertyGrade"][1]["value"] = $xmlArray['Content']['Grading']['Grades'][1]['Score'] / 10;
	     		
	     		$properties[$key]["ipr"][0]["propertyGrade"][2]["name"] = "Demographics";
	     		$properties[$key]["ipr"][0]["propertyGrade"][2]["value"] = $xmlArray['Content']['Grading']['Grades'][2]['Score'] / 10;
	     		
	     		$properties[$key]["ipr"][0]["propertyGrade"][3]["name"] = "Internal floor plan flow";
	     		$properties[$key]["ipr"][0]["propertyGrade"][3]["value"] = $xmlArray['Content']['Grading']['Grades'][3]['Score'] / 10;
	     		
	     		$properties[$key]["ipr"][0]["propertyGrade"][4]["name"] = "Street scape/traffic flow";
	     		$properties[$key]["ipr"][0]["propertyGrade"][4]["value"] = $xmlArray['Content']['Grading']['Grades'][4]['Score'] / 10;
	     		
	     		$properties[$key]["ipr"][0]["propertyGrade"][5]["name"] = "Parking";
	     		$properties[$key]["ipr"][0]["propertyGrade"][5]["value"] = $xmlArray['Content']['Grading']['Grades'][5]['Score'] / 5;
	     		
	     		$properties[$key]["ipr"][0]["propertyGrade"][6]["name"] = "Outdoor space";
	     		$properties[$key]["ipr"][0]["propertyGrade"][6]["value"] = $xmlArray['Content']['Grading']['Grades'][6]['Score'] / 5;
	     		}else{
	     			$properties[$key]['observation'] = "";
	     			$properties[$key]["ipr"] = array();
	     		}
	 
	     		
	     		
	     	}
	     	 
	     	 	     	// Convert Array to JSON String
	     	 	     	
	     				$result['properties'] = $properties;
	     		     	$someJSON = json_encode($result, JSON_PRETTY_PRINT);
	     		     	//echo nl2br($someJSON);
	     		   		
	     	// Acessing MONGO
	     				
	     		     	//$serUrl = Configure::read('LOCAL_CONN');
	     		     	
	     		     	$serUrl = Configure::read('CONNECT_SER');
	     		     	
	     		     	$m1 = new MongoClient($serUrl);
	     		     	
	     		     	// select a database
	     		     	$db2 = $m1->properties;
	     		     	
	     		     	$collection = $m1->$db2->realprop;
	     		     	for ($i = 0; $i <2; $i++) {
	     		     	try {
	     		     	
	     		     		$collection->insert($properties[$i],array("safe" => true));
	     		     		//Add unique index for field 'asda'
	     		     		$collection->ensureIndex(array('id' => 1), array("unique" => true,'dropDups' => true));
	     		     	
	     		     		//echo "ADDED from ELSE";
	     		     	}
	     		     	catch(MongoCursorException $e) {
	     		     		//echo "Error: " . $e->getMessage()."\n";
	     		     	}
	     		     	}
	     		     	
	     		     	
	     		     	$cursor1 = $collection->find();
	     		     	while ( $cursor1->hasNext() )
	     		     	{
	     		     		//var_dump( $cursor12->getNext() );
	     		     	
	     		     		foreach ($cursor1 as $jk) {
	     		     			//echo "id" . $jk['id']."<br/>";
	     		     			//echo "cpxprice" . $jk['cpxprice']."<br/>";
	     		     			//echo ($collection->count())." : ".($jk['id'])."<br/>";
	     		     		}
	     		     	}
	     		     	
	     		     	
	     		     	 $dhj=array();
	     		     	foreach($collection->find() as $resulta) {
	     		     	//print_r($result);
	     		     	
	     		     		array_push($dhj, $resulta);
	     		     	
	     		     		// $someBSON = bson_decode($result);
	     		     		//print_r($dhj);
	     		     	}
	     		     	$newarray["compassprop"] = $dhj;
	     		     	//print_r($newarray);
	     		     	$lomeJSON = json_encode($newarray, JSON_PRETTY_PRINT);
	     		     	echo nl2br($lomeJSON); 
	     		     	
	     		     	
	        }
	        
	        
	        


// 	        "name":"538 North",
// 	        "date_created": "2015-03-30T11:35:44",
	     
// 	        "name":"EDEN PARK",
// 	        "date_created": "2015-04-13T11:14:44",
	     
// 	        "name":"PARKVIEW",
// 	        "date_created": "2015-05-04T11:49:44",
	     
	     
	     
	     
	     
	     
	     
	     
	     
}
?>