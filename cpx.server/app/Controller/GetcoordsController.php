<?php


ini_set ( 'memory_limit', '-1' );
ini_set ( 'max_execution_time', 3000 );

class GetcoordsController extends AppController {
	
	
	
	public function lookup($string){
		$string = str_replace (" ", "+", urlencode($string));
		$details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$string."&sensor=false";
		
		//echo "This is from LOOKUP" . $string . "<br/>";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $details_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = json_decode(curl_exec($ch), true);
        curl_close($ch);	   
		
		// If Status Code is ZERO_RESULTS, OVER_QUERY_LIMIT, REQUEST_DENIED or INVALID_REQUEST
		if ($response['status'] != 'OK') {
			return null;
		}
		
		else if ($response['status'] == 'OVER_QUERY_LIMIT') {
			
			echo "<br/><br/>" . "Limit's over buddy...Try afterwards => OVER_QUERY_LIMIT";
						 	
			die;
		}
	
		//print_r($response);
		$geometry = $response['results'][0]['geometry'];
	
		$longitude = $geometry['location']['lat'];
		$latitude = $geometry['location']['lng'];
	
		$array = array(
				'latitude' => $geometry['location']['lat'],
				'longitude' => $geometry['location']['lng'],
				'location_type' => $geometry['location_type'],
		);
		//print_r($array);
		return $array;
	}
	
	
	
	
	public function index() {
		
		//////////////////////
		
		echo "counting.....";
		
		 $serUrl = Configure::read('CONNECT_SER');
			
		$m1 = new MongoClient($serUrl);
			
			
			
			
		// select a database
		$db2 = $m1->properties;
			
		$collection = $m1->$db2->realprop;
		
	    /////////////////////

			//$query = array('coords.latitude' => null);
		
			$where=array( '$and' => array( array('coords.latitude' =>null), array('sold' => array('$ne'=>true) ) ) );
		
			$cursor12 = $collection->find ($where);
			
			$sdj = $collection->count ($where);
			
			echo "Total records with valid address but NO coordinates found : " . $sdj ."<br/>" ;
			
			$counter = 0;
			
			echo "Processing..." ."<br/><br/>";
			
 			 while ( $cursor12->hasNext () ) {
				// var_dump( $cursor12->getNext() );
				
				foreach ( $cursor12 as $realproperties ) {
					
					 //echo $counter++ ."]". "cityAddress => " . $realproperties['cityAddress']."<br/>";
					 
					 
					 //print_r($realproperties['id']);echo "<br/>";
                    
                    if(isset($realproperties['lat']) && !empty($realproperties['lat']) && isset($realproperties['lon']) && !empty($realproperties['lon']))
                    {
                        $lat =  $realproperties['lat'];
    					$lon =  $realproperties['lon'];
                    }	
                    else
                    {
                        $some = array();
    					array_push ( $some , $realproperties ["address"] [0] ["StreetNumber"]);
    					array_push ( $some , $realproperties ["address"] [0] ["street"]);
    					array_push ( $some , $realproperties ["address"] [0] ["suburb"] ['text']);
    					array_push ( $some , $realproperties ["address"] [0] ["state"]);
    					array_push ( $some , $realproperties ["address"] [0] ["country"]);
    					array_push ( $some , $realproperties ["address"] [0] ["postcode"]);
    						
    					$city = join(' ',$some);
    					
    					 //echo $city ."<br/>"; 
    
    					 $array = $this->lookup($city);
    					 
    					 $counter++;
    					 
    					 echo "Request Count : ".  $counter. "</br>";
    					 
    					 //print_r($array); echo  "<br/>";
    					 
    					 $lat =  $array['latitude'];
    					 $lon =  $array['longitude'];
                    }				 
					
					 
                    $collection->update (array("id" => $realproperties['id'] ), array('$set' => array("coords.latitude"=> $lat ,"coords.longitude"=> $lon ))) ;

					$updatedproperty = $collection->findOne (array("id" => $realproperties['id'] ));
					 
					
				
				
					  if($updatedproperty ['coords'] ['latitude']==null){
					 	//while($realproperties ["coords"] ["longitude"]==null){

					  	$array = $this->lookup($city);
						 
					  	$counter++;
						 //print_r($array); echo  "<br/>";
						 echo "Request Count From if: ".  $counter. "</br>";
						 
						 $lat =  $array['latitude'];
						 $lon =  $array['longitude'];
						 
						 $collection->update (array("id" => $realproperties['id'] ), array('$set' => array("coords.latitude"=> $lat ,"coords.longitude"=> $lon ))) ;
	
						 //echo $city ."=> Latitude:". $realproperties ["coords"]." & Longitude:" ."<br/>";die;
						 	//}
						 }  
					
						 echo "Coords updated for ".($updatedproperty ['id']) . " => Latitude : "  . ($updatedproperty ['coords'] ['latitude']) ." & Longitude " .($updatedproperty ['coords'] ['longitude'])."<br/>";
						 
						 if($counter == 2500){
						 	
						 	echo "<br/><br/>" . "Limit's over buddy...Try afterwards => 2500 Req";
						 	
						 	die;
						 }
					 
					 //print_r($array);die;
					 
					usleep(100000);
				
				}
			}  
			
			echo "Done !";
			
			/* $dhj = array();
			
			foreach ( $collection->find () as $result ) {
				// print_r($result);
					
				array_push ( $dhj, $result );
					
				// $someBSON = bson_decode($result);
				// print_r($dhj);
			}
			$newarray ["cpxpropertynow"] = $dhj;
			// print_r($newarray);
			$comeJSON = json_encode ( $newarray, JSON_PRETTY_PRINT );
			//echo nl2br ( $comeJSON );
			 */
            
            $m1->close();			
		}	
		
	}
	
	

	
	
	
	
	
	
	
	


?>