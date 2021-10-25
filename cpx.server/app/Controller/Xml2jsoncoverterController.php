<?php

App::uses('CakeEmail', 'Network/Email');

use Cake\Mailer\Email;

//error_reporting(0);
define ( "SENGRID_SMTP", "sendgrid" );
// use Cake\I18n\Time;

/* Configure logging */
// MongoLog::setModule( MongoLog::ALL );
// MongoLog::setLevel( MongoLog::ALL );
// error_reporting(E_ALL);
ini_set ( 'error_log', 'c:/wamp/logs/xml2jsonconverter.log' );

// require_once '..\Lib\lib\Analog.php';


ini_set ( 'memory_limit', '-1' );
ini_set ( 'max_execution_time', 3000 );

define ( "serverfolderUrl", "../../datafiles" );
//define ( "localfolderUrl", "../../../../newxml2" );
define ( "localfolderUrl", "../../newxml2" );
//define ( "localfolderUrl", "../../twofiles" );

define ( "parsedurl", "../../parsedDatafiles" );
define ("pc2url" , "../../test");


class Xml2jsoncoverterController extends AppController {
	
    private function getAllXmlFiles($folder,$subfolder="",$onlyFiles=false)
    {
        $dirFiles = array();
        $files2new = scandir ( $folder, 1 );
        //echo "<pre>"; print_r($files2new);echo "</pre>";exit;
        foreach($files2new as $file)
           { 
               
               
                if($file==".." || $file=="." || $file=="cronlog.txt")
                    continue;
               
               //echo "<br/>".$file;exit;
              // echo "<br>is dir=".is_dir( (realpath ( $folder )) . "/" .$file);
               
                if(is_dir( (realpath ( $folder )) . "/" .$file))
                {
                    $newsubfolder = $subfolder.$file. "/" ;
                   // echo "<br>new sub flder = $newsubfolder";
                    $n_files = $this->getAllXmlFiles($folder.'/'.$file,$newsubfolder,$onlyFiles);
                   // echo "<pre> return files";print_r($n_files);
                    if(count($n_files) && count($dirFiles))
                       { 
                       $dirFiles = array_merge($dirFiles,$n_files);
                      }  
                    elseif(count($n_files)) 
                    {
                        $dirFiles=$n_files;
                    }   
                    
                   // echo "<pre> final dir files";print_r($dirFiles);
                }
                if(is_file((realpath ( $folder )) . "/" .$file))
                {
                   
                    if($subfolder=="" || $onlyFiles)
                        $dirFiles[] = $file;
                    else                    
                        $dirFiles[] = $subfolder.$file;
                        
                  // echo "<pre>";print_r($dirFiles);echo "</pre>";     
                }
           }
          // echo "<pre>";print_r($dirFiles);echo "</pre>";exit;
          return  $dirFiles;
    }
    
    private function removeAllEmptyDir($folder,$subfolder="",$onlyFiles=false)
    {
        $dirFiles = array();
        $files2new = scandir ($folder, 1 );
        $removeDir = true;
        foreach($files2new as $file)
           { 
            if($file==".." || $file=="." || $file=="cronlog.txt")
                    continue;
            $removeDir = false;
            if(is_dir( (realpath ( $folder )) . "/" .$file))
                {
                    $newsubfolder = $subfolder.$file. "/" ;
                   // echo "<br>new sub flder = $newsubfolder";
                    $n_files = $this->removeAllEmptyDir($folder.'/'.$file,$newsubfolder,$onlyFiles);
                   // echo "<pre> return files";print_r($n_files);
                    if(count($n_files) && count($dirFiles))
                      { 
                       $dirFiles = array_merge($dirFiles,$n_files);
                      }  
                    elseif(count($n_files)) 
                    {
                        $dirFiles=$n_files;
                    }
                    if(in_array($folder.'/'.$file,$dirFiles))
                    {
                         $removeDir = true;
                    }
                       
                    
                   // echo "<pre> final dir files";print_r($dirFiles);
                }
                
                if(is_file((realpath ( $folder )) . "/" .$file))
                {
                    $removeDir = false;
                }
                
            
                
           } 
           
           if($removeDir && $subfolder!="") 
           {
                $dirFiles[] = $folder;
           }
        
        
        
        
          return  $dirFiles;
    }
    
    
    
    
	
	public function index() {
		
		//////////////////////
		
		//echo is_dir("../../newxml2\parsed");die;
		
		$date = new DateTime();
		$batchId = $date->format('U');
		//echo  $batchId. "\n";die;
		
		$newlyAddedProperties = array();
		$newlyAddedProperties1 = array();
		$updatedProperties1 = array();
		$updatedProperties = array();
		$deletedProperties1 = array();
		$deletedProperties = array();
		$masterDataArray = array();
		$counterAgents = 0;
		$updateCounterAgents = 0;
		$deleteCounterAgents = 0;
		$delete = array();
		
		$serUrl = Configure::read('CONNECT_SER');
			
		$m1 = new MongoClient($serUrl);
			
			
			
			
		// select a database
		$db2 = $m1->properties;
			
		$collection = $m1->$db2->realprop;
		
	    /////////////////////
	
		//$dir = pc2url; // THIS IS TO LOAD LOCAL FILE [START]
		
		$dir = serverfolderUrl; // THIS IS TO LOAD SERVER FILE [START]
		
		$parseddir  = parsedurl;
		

       		
        $parsingfiles = $this->getAllXmlFiles($dir,"");
        $newparsingfiles = $this->getAllXmlFiles($dir,"");        
        //echo "<pre>";print_r($parsingfiles);
        
        $destparsingfiles = $this->getAllXmlFiles($dir,"",$onlyFiles=true);
		
		foreach ( $parsingfiles as &$value ) {
		              $value = $value;
				}
		
        $source = $dir."/";
		$destination = $parseddir."/";
	    
        $files2 = $this->getAllXmlFiles($dir);
       
        //echo "<pre>all files in datafiles :";print_r($files2);echo "</pre>";
        //print_r($newFileArray); 
		///////////single File START////////////
		foreach ( $files2 as &$v_file ) {
			$v_file = (realpath ( $dir )) . "/" . $v_file;
			//$value = (realpath ( $dir )) . "\\" . $value;
		}
		// echo "<pre> ";print_r($files2);exit;
       // $files2 = $newFileArray;
        $max2 = (sizeOf ( $files2 ));
        //echo "<pre>";
        //print_r($files2); 
        //exit;
		for($r = 0; $r < $max2; $r ++) {
			//echo ($files2[$r])."<br/>";
			
			//////Check if Xml is in valid format
			
			libxml_use_internal_errors(true);
			$a = simplexml_load_file($files2 [$r]);
			if($a===FALSE) {
				echo 'Not valid :'.$files2[$r]."<br/>";

                $delete[] = $files2[$r];
                
			} else {
				//echo 'valid: '.$files2[$r]."<br/>";
			
		
			//echo "Current File for $r =>".$files2[$r];
			$xmlNode = simplexml_load_file ( $files2 [$r] );
			$arrayData = $this->xmlToArray ( $xmlNode );

//echo "<pre>xmlnode";
//print_r($xmlNode);
//echo "</pre>";
			
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
			
//echo "<pre>json";
//print_r($someArray);
//echo "</pre>";
//exit;
			$realproperties = array ();

        
        
        
			foreach ( $someArray as $key => $value ) {
				
        
        
				if ($key == 'residential') { // if($key == 'residential' || $key == 'land'){
				        //echo $key." is started";
					//echo $value ['uniqueID'];
		
                    if(isset ( $value ['status'] ) && ($value ['status'] == "offmarket" || $value ['status'] == "withdrawn"))
                    {
                        $id = $value ['uniqueID'];

                        $rep = $collection->remove(array('property_id' => $id));
                        
                        //echo "del==>".print_r($rep);
//                        die;    
                    }
					else if((isset ( $value ['uniqueID'] )) && (isset ( $value ['status'] )) && ($value ['status'] == "current" || $value ['status'] == "sold")  && (isset ( $value ['modTime'] ))){
					   
                       
                       
						//$realproperties [0] ['id'] = 'cpx'.mt_rand(100000,999999);
                        $realproperties [0] ['id'] = $this->checkCpxIdExist();
						$realproperties [0] ['property_id'] = $value ['uniqueID'];
						$realproperties [0] ['agentID'] = $value ['agentID'];
						$realproperties [0] ['gradestatus'] = 0;
							
                        
                        $realproperties [0] ['batchID'] = $batchId;
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
							
								
                                
                                if(is_array($agent ["telephone"]) && (count($agent ["telephone"]) > 0) && (isset($agent["telephone"][0])))
                                {
                                    foreach($agent ["telephone"] as $k=>$telephone)
                                    {
                                        $realproperties [0] ['contact'] [$agentkey] ["telephone"][$k] ["telephoneType"] = (isset ( $telephone ['type'] )) ? $telephone ['type'] : "";
								        $realproperties [0] ['contact'] [$agentkey] ["telephone"][$k] ['telephone'] = (isset ( $telephone  [''] )) ? $telephone[''] : "";
                                    }
                                   
                                }
                                else
                                {
								    $realproperties [0] ['contact'] [$agentkey]  ['telephoneType'] = (isset ( $agent ["telephone"] ['type'] )) ? $agent ["telephone"] ['type'] :"";
								    $realproperties [0] ['contact'] [$agentkey]  ['telephone'] =(isset ( $agent ["telephone"] [''] )) ? $agent ["telephone"] [''] : "";
                                }
                                
                                
                                
							
								$realproperties [0] ['contact'] [$agentkey]  ['email'] = (isset ( $agent ["email"] )) ?$agent ["email"] : "";
							
							}
                            
    
						}
						else{$realproperties [0] ['contact'] = array();}	
							
						
						
							
						////////////////////
							
						//echo $value['price'][''];die;
						$displayprice = 'no';
						if(isset($value['price']['display'])){
							//print_r($value1 ['price'] ['']);die; 
							$cpxprice = intval($value['price']['']);
							$listedprice = intval($value['price']['']);
                            
                                //added Parvez for listed price dispaly
                                if(strtolower($value['price']['display'])=='yes')
                                {
                                    $displayprice = 'yes';
                                }
                                //changes end
                            
							}
							
							else{
								if(isset($value ['price'])){$cpxprice = intval($value ['price']);}
								if(isset($value['price'])){$listedprice = intval($value['price']);}
							}
						//echo (isset ( $cpxprice ));
						if(isset($value['priceView'])){$priceview = $value['priceView'];}else{$priceview = '';}
							
							
						$realproperties [0] ['cpxprice'] = (isset ( $cpxprice )) ? $cpxprice : 0;
						
                        //added Parvez for listed price dispaly	
						$realproperties [0] ['displayprice'] = $displayprice;
                        
						$realproperties [0] ['listedprice'] = (isset ( $listedprice )) ? $listedprice : 0;
						$realproperties [0] ['viewprice'] = (isset ( $priceview )) ? $priceview : '';
                        
						$realproperties [0] ['saving'] = 0;
							
						$realproperties [0] ['marketrent'] = (isset ( $value ['marketrent'] )) ? $value ['marketrent'] : "";
							
						$realproperties [0] ["beds"] = (isset ( $value ['features'] ["bedrooms"] )) ? $value ['features'] ["bedrooms"] : "";
						$realproperties [0] ["bath"] = (isset ( $value ['features'] ["bathrooms"] )) ? $value ['features'] ["bathrooms"] : "";

						$realproperties [0] ["externalLink"] = (isset ( $value ['externalLink'] ["href"] )) ? $value ['externalLink'] ["href"] : "";
						$realproperties [0] ["videoLink"] = (isset ( $value ['videoLink'] ["href"] )) ? $value ['videoLink'] ["href"] : "";
						
						$realproperties [0] ["reverseCycleAircon"] = (isset ( $value ['features'] ["reverseCycleAircon"] )) ? $value ['features'] ["reverseCycleAircon"] : "";
                        
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
                        elseif(isset ( $value ['buildingDetails'] ["area"])){
							$realproperties [0] ['areaunit'] = (isset ( $value ['buildingDetails'] ["area"] ['unit'] )) ? $value ['buildingDetails'] ["area"] ['unit'] : "";
							$realproperties [0] ['buildingarea'] = (isset ( $value ['buildingDetails'] ["area"] [''] )) ? $value ['buildingDetails'] ["area"] [''] : "";
						}
						else{
							$realproperties [0] ['landarea'] =  "";
							$realproperties [0] ['areaunit'] =  "";
							$realproperties [0] ['buildingarea'] =  "";
						}
                        
                        
                        
                        if(isset($value ['extraFields'] ["eField"]))
                        {
                            foreach($value ['extraFields'] ["eField"] as $extrafields)
                            {
                                if($extrafields['name'] == 'lat')
                                    $realproperties [0] ['lat'] = $extrafields[''];
                                elseif($extrafields['name'] == 'lng')
                                    $realproperties [0] ['lon'] = $extrafields[''];
                            }
                        }
                        else
                        {
                            $realproperties [0] ['lat'] =  "";
							$realproperties [0] ['lon'] =  "";
                        }
                        
						$realproperties [0] ['date_created'] = "";
						$realproperties [0] ['featured'] = false;
						$realproperties [0] ['latest'] = false;
						$realproperties [0] ['smsf'] = "";
						if ($value ['status'] == 'sold'){$realproperties [0] ['sold'] = true;}
						else{$realproperties [0] ['sold'] = false;}
						$realproperties [0] ['deposit'] = (isset ( $value ['underOffer'] ['value'] )) ? $value ['underOffer'] ['value'] : "";
						$realproperties [0] ['domacom'] = "";
                        $realproperties [0] ['vendorfinance'] = "";
                        
                        $realproperties [0] ['homelandpackage'] = (isset ( $value ['isHomeLandPackage'] ['value'] )) ? $value ['isHomeLandPackage'] ['value'] : "";
                        $realproperties [0] ['newConstruction'] = (isset ( $value ['newConstruction'] )) ? $value ['newConstruction'] : "";
                        
                        $realproperties [0] ['established'] = 'no';
                        if((isset($value ['isHomeLandPackage'] ['value']) && ($value ['isHomeLandPackage'] ['value'] == 'no')) && (isset($value ['newConstruction'] ) && ($value ['newConstruction'] == '0')) || (!isset($value ['isHomeLandPackage'] ['value']) && !isset($value ['newConstruction'] )))
                        {
                            $realproperties [0] ['established'] = 'yes';
                        }
                        							
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
						      if(isset ( $value ["address"] ["suburb"] ['display']) ){
						          
							$address [0] ["suburb"] ['display'] = (isset ( $value ["address"] ["suburb"] ['display'] )) ? $value ["address"] ["suburb"] ['display'] : "";
							$address [0] ["suburb"] ['text'] = (isset ( $value ["address"] ["suburb"] [''] )) ? $value ["address"] ["suburb"] [''] : "";
                            } else {
                                 $address [0] ["suburb"] ['display'] = "yes";
							     $address [0] ["suburb"] ['text'] = (isset ( $value ["address"] ["suburb"]  )) ? $value ["address"] ["suburb"] : "";
                            }
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
							
						if(empty ($address [0] ["suburb"] ['text']) && $value ['status'] == 'sold'){
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
                        //When new property is added then we will give no image untill download and uploading of images is done on our server
                        $realproperties [0] ['validImages'] = array();
                        $realproperties [0] ['validImages'][] = array('id' => 0 , 'url' =>'http://www.centralpropertyexchange.com.au/images/nophotoavailable.png');
                        
						$realproperties [0] ['documents'] = array();
						if (! isset ( $value ["objects"] ["document"] )) {
							//echo "none;so blank documents";
						} else {
							if (isset ( $value ["objects"] ["document"] ["id"] )) {
								//echo "found one";
								$realproperties [0] ['documents'][0]['id'] = 0;
								$realproperties [0] ['documents'][0]['title'] = (isset ( $value ['objects'] ["document"] ["title"])) ? $value ['objects'] ["document"] ["title"] : "";
								$realproperties [0] ['documents'][0]['url'] = $value ['objects'] ["document"] ["url"];
							}
								
							else {
								foreach ( $value ["objects"] ["document"] as $key12 => $image ) {
										
									// print_r($value["images"]);
									// echo $key2;print_r($image);
										
									$realproperties [0] ['documents'] [$key12] ['id'] = $key12;
									$realproperties [0] ['documents'] [$key12] ['title'] = (isset ( $image ["title"] )) ? $image ["title"] : "";
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
									
								else
                                {
                                    if($key4 == 'otherFeatures' && isset($feature))
                                    {
                                        $realproperties [0] ['features'] [$key4] = str_replace(',',', ',$feature);
                                    }	
                                    else
                                    {							    
									   $realproperties [0] ['features'] [$key4] = $feature;
                                    }
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
                        
                        //echo "<pre>"; print_r($realproperties);
                        //echo "</pre>"; exit;
                        
						
					}
					
					else{
						
					$key1 = 0;
					foreach ( $value as $customKey => $value1 ) {
						
						 //print_r(array_keys($value1))."<br/>";
						//echo ( $customKey)."<br/>";
						
                        if(isset ( $value1 ['status'] ) && ($value1 ['status'] == "offmarket"  || $value1 ['status'] == "withdrawn"))
                        {
                            $id = $value1 ['uniqueID'];
    
                            $rep = $collection->remove(array('property_id' => $id));
                            
                            //echo "del==>".print_r($rep);
    //                        die;    
                            continue;
                        }
                        
                        
                        
						
						if ((isset ( $value1 ['uniqueID'] )) && (isset ( $value1 ['status'] ))&& ($value1 ['status'] == "current" || $value1 ['status'] == "sold") && (isset ( $value1 ['modTime'] ))) { // ($value1['status'] == 'current')
							// $realproperties[$key1][$key]['status'] = $value1['status'];
							
                            $realproperties [$key1] ['id'] = 'cpx'.mt_rand(100000,999999);
	                        $realproperties [$key1] ['property_id'] = $value1 ['uniqueID'];
							$realproperties [$key1] ['agentID'] = $value1 ['agentID'];
							$realproperties [$key1] ['gradestatus'] = 0;
							$realproperties [$key1] ['batchID'] = $batchId;
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
                                
                                if(is_array($value1 ['listingAgent'] ["telephone"]) && (count($value1 ['listingAgent'] ["telephone"]) > 0) && (isset($value1 ['listingAgent'] ["telephone"][0])))
                                {
                                    foreach($value1 ['listingAgent'] ["telephone"] as $k=>$telephone)
                                    {
                                        $realproperties [$key1] ['contact'] [$agentkey] ["telephone"][$k] ["telephoneType"] = (isset ( $telephone ['type'] )) ? $telephone ['type'] : "";
								        $realproperties [$key1] ['contact'] [$agentkey] ["telephone"][$k] ['telephone'] = (isset ( $telephone  [''] )) ? $telephone[''] : "";
                                    }
                                   
                                }
                                else
                                {
								    $realproperties [$key1] ['contact'] [$agentkey] ["telephoneType"] = (isset ( $value1 ['listingAgent'] ["telephone"] ['type'] )) ? $value1 ['listingAgent'] ["telephone"] ['type'] : "";
								    $realproperties [$key1] ['contact'] [$agentkey] ['telephone'] = (isset ( $value1 ['listingAgent'] ["telephone"] [''] )) ? $value1 ['listingAgent'] ["telephone"] [''] : "";
                                }
								$realproperties [$key1] ['contact'] [$agentkey] ['email'] = (isset ( $value1 ['listingAgent'] ["email"] )) ? $value1 ['listingAgent'] ["email"] : "";



//echo "<pre>listing check";
//print_r($value1 ['listingAgent']);
//print_r($realproperties [$key1] ['contact'][$agentkey]);
//echo "</pre>";
							
							}
							else if(isset($value1['listingAgent'])){
								//echo "multiple";
								foreach($value1['listingAgent'] as $key9 => $agent) {
									//$agentkey = $key9 + 1;
								if(isset($value1 ["vendorDetails"])){$agentkey = $key9 + 1; }else{$agentkey = $key9;}	
								
									$realproperties [$key1] ['contact'] [$agentkey] ['type'] = 'listingAgent';
									$realproperties [$key1] ['contact'] [$agentkey] ['id'] = (isset ( $agent ["id"])) ?  $agent ["id"] : $key9;
									$realproperties [$key1] ['contact'] [$agentkey]  ['name'] = (isset ( $agent ["name"])) ?  $agent ["name"] : '';
									
                                    
                                    
                                    if(is_array($agent ["telephone"]) && (count($agent ["telephone"]) > 0) && (isset($agent["telephone"][0])))
                                    {
                                        foreach($agent ["telephone"] as $k=>$telephone)
                                        {
                                            $realproperties [$key1] ['contact'] [$agentkey] ["telephone"][$k] ["telephoneType"] = (isset ( $telephone ['type'] )) ? $telephone ['type'] : "";
    								        $realproperties [$key1] ['contact'] [$agentkey] ["telephone"][$k] ['telephone'] = (isset ( $telephone  [''] )) ? $telephone[''] : "";
                                        }
                                       
                                    }
                                    else
                                    {
    								    $realproperties [$key1] ['contact'] [$agentkey]  ['telephoneType'] = (isset ( $agent ["telephone"] ['type'] )) ? $agent ["telephone"] ['type'] :"";
									   $realproperties [$key1] ['contact'] [$agentkey]  ['telephone'] =(isset ( $agent ["telephone"] [''] )) ? $agent ["telephone"] [''] : "";;
                                    }
                                    
                                    	
									
										
									$realproperties [$key1] ['contact'] [$agentkey]  ['email'] = (isset ( $agent ["email"] )) ?$agent ["email"] : "";
										
								}
							}
								else {$realproperties [$key1] ['contact'] = array();}
							////////////////////
						/*
                        if(isset($value1 ['price']['display'])){
							//print_r($value1 ['price'] ['']);die; 
							$cpxprice = intval($value1 ['price']['']);
							$listedprice = intval($value1['price']['']);
							}
                        */
                        	
                        $displayprice = 'no';
						if(isset($value1['price']['display'])){
							//print_r($value1 ['price'] ['']);die; 
							$cpxprice = intval($value1['price']['']);
							$listedprice = intval($value1['price']['']);
                            
                                //added Parvez for listed price dispaly
                                if(strtolower($value1['price']['display'])=='yes')
                                {
                                    $displayprice = 'yes';
                                }
                                //changes end
                            
							}                
							
							else{
								if(isset($value1 ['price'])){$cpxprice = intval($value1 ['price']);}
								if(isset($value1 ['price'])){$listedprice = intval($value1['price']);}
							}
							
							if(isset($value1['priceView'])){$priceview = $value1['priceView'];}else{$priceview = '';}
							
							
							$realproperties [$key1] ['cpxprice'] = (isset ( $cpxprice )) ? $cpxprice : 0;
							
							$realproperties [$key1] ['displayprice'] = $displayprice; 
							$realproperties [$key1] ['listedprice'] = (isset ( $listedprice )) ? $listedprice : 0;
							$realproperties [$key1] ['viewprice'] = (isset ( $priceview )) ? $priceview : '';
							$realproperties [$key1] ['saving'] = 0;
							
							$realproperties [$key1] ['marketrent'] = (isset ( $value1 ['marketrent'] )) ? $value1 ['marketrent'] : "";
							
							$realproperties [$key1] ["beds"] = (isset ( $value1 ['features'] ["bedrooms"] )) ? $value1 ['features'] ["bedrooms"] : "";
							$realproperties [$key1] ["bath"] = (isset ( $value1 ['features'] ["bathrooms"] )) ? $value1 ['features'] ["bathrooms"] : "";
							
							$realproperties [$key1] ["externalLink"] = (isset ( $value1 ['externalLink'] ["href"] )) ? $value1 ['externalLink'] ["href"] : "";
							$realproperties [$key1] ["videoLink"] = (isset ( $value1 ['videoLink'] ["href"] )) ? $value1 ['videoLink'] ["href"] : "";
                            
                            $realproperties [$key1] ["reverseCycleAircon"] = (isset ( $value1 ['features'] ["reverseCycleAircon"] )) ? $value1 ['features'] ["reverseCycleAircon"] : "";								
							
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
							}elseif(isset ( $value ['buildingDetails'] ["area"])){
							$realproperties [0] ['areaunit'] = (isset ( $value ['buildingDetails'] ["area"] ['unit'] )) ? $value ['buildingDetails'] ["area"] ['unit'] : "";
							$realproperties [0] ['buildingarea'] = (isset ( $value ['buildingDetails'] ["area"] [''] )) ? $value ['buildingDetails'] ["area"] [''] : "";
						  }else{
								$realproperties [$key1] ['landarea'] =  "";
								$realproperties [$key1] ['areaunit'] =  "";
								$realproperties [$key1] ['buildingarea'] =  "";
							}
                            
                            if(isset($value1 ['extraFields'] ["eField"]))
                            {
                                foreach($value1 ['extraFields'] ["eField"] as $extrafields)
                                {
                                    if($extrafields['name'] == 'lat')
                                        $realproperties [$key1] ['lat'] = $extrafields[''];
                                    elseif($extrafields['name'] == 'lng')
                                        $realproperties [$key1] ['lon'] = $extrafields[''];
                                }
                            }
                            else
                            {
                                $realproperties [$key1] ['lat'] =  "";
								$realproperties [$key1] ['lon'] =  "";
                            }
                            
							$realproperties [$key1] ['date_created'] = "";
							$realproperties [$key1] ['featured'] = false;
							$realproperties [$key1] ['latest'] = false;
							$realproperties [$key1] ['smsf'] = "";
							if ($value1 ['status'] == 'sold'){$realproperties [$key1] ['sold'] = true;}
							else{$realproperties [$key1] ['sold'] = false;}
							$realproperties [$key1] ['deposit'] = (isset ( $value1 ['underOffer'] ['value'] )) ? $value1 ['underOffer'] ['value'] : "";
							$realproperties [$key1] ['domacom'] = "";
                            $realproperties [$key1] ['vendorfinance'] = "";
							
                            $realproperties [$key1] ['homelandpackage'] = (isset ( $value1 ['isHomeLandPackage'] ['value'] )) ? $value1 ['isHomeLandPackage'] ['value'] : "";
                            $realproperties [$key1] ['newConstruction'] = (isset ( $value1 ['newConstruction'] )) ? $value1 ['newConstruction'] : "";
                            
                            $realproperties [$key1] ['established'] = 'no';
                            if((isset($value1 ['isHomeLandPackage'] ['value']) && ($value1 ['isHomeLandPackage'] ['value'] == 'no')) && (isset($value1 ['newConstruction'] ) && ($value1 ['newConstruction'] == '0')) || (!isset($value1 ['isHomeLandPackage'] ['value']) && !isset($value1 ['newConstruction'] )))
                            {
                                $realproperties [$key1] ['established'] = 'yes';
                            }
                            
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
							     if(isset ( $value1 ["address"] ["suburb"]['display'])){
							$address [0] ["suburb"] ['display'] = (isset ( $value1 ["address"] ["suburb"] ['display'] )) ? $value1 ["address"] ["suburb"] ['display'] : "";
							$address [0] ["suburb"] ['text'] = (isset ( $value1 ["address"] ["suburb"] [''] )) ? $value1 ["address"] ["suburb"] [''] : "";                   
                                }else{
                                    $address [0] ["suburb"] ['display'] =  "yes";
							         $address [0] ["suburb"] ['text'] = (isset ( $value1 ["address"] ["suburb"]  )) ? $value1 ["address"] ["suburb"] : "";                   
                                }
							} else{
								$address [0] ["suburb"] ['display'] =  "";
								$address [0] ["suburb"] ['text'] =  "";
							}
                            
                            //echo "<pre>";print_r($address);echo "</pre>";
                            
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
							
							
							if(empty($address [0] ["suburb"] ['text'] ) && $value1 ['status'] == 'sold'){
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
                            //When new property is added then we will give no image untill download and uploading of images is done on our server
                            $realproperties [$key1] ['validImages'] = array();
                            $realproperties [$key1] ['validImages'][] = array('id' => 0 , 'url' =>'http://www.centralpropertyexchange.com.au/images/nophotoavailable.png');
							$realproperties [$key1] ['documents'] = array();
							if (! isset ( $value1 ["objects"] ["document"] )) {
								
							} else {
								if (isset ( $value1 ["objects"] ["document"] ["id"] )) {
									$realproperties [$key1] ['documents'][0]['id'] = 0;
									$realproperties [$key1] ['documents'][0]['title'] = (isset ( $value1 ['objects'] ["document"] ["title"])) ? $value1 ['objects'] ["document"] ["title"] : "";
									$realproperties [$key1] ['documents'][0]['url'] = $value1 ["objects"] ['document']["url"];
								}
									
								else {
									foreach ( $value1 ["objects"] ["document"] as $key12 => $image ) {
											
										// print_r($value1["images"]);
										// echo $key2;print_r($image);
											
										$realproperties [$key1] ['documents'] [$key12] ['id'] = $key12;
										$realproperties [$key1] ['documents'] [$key12] ['title'] = (isset ( $image ["title"] )) ?  $image ["title"] : "";
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
									
									else
                                    {
                                        if($key4 == 'otherFeatures' && isset($feature))
                                        {
                                            $realproperties [$key1] ['features'] [$key4] = str_replace(',',', ',$feature);
                                        }	
                                        else
                                        {							    
    									   $realproperties [$key1] ['features'] [$key4] = $feature;
                                        }
										
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
			
			
			
			
			// Convert Array to JSON String
			
			$results ['realproperties'] = $realproperties;

//echo "<pre>results";
//print_r($realproperties);
//exit;
			
			$realpropertyArrayObject = new ArrayObject ( $realproperties );
			$copy = $realpropertyArrayObject->getArrayCopy ();
			//echo "<pre>";
            //  print_r($copy);
            // exit;
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
			
			
			
			$cursor13 = $collection->find ();
			
			//while ( $cursor13->hasNext () ) {
				// var_dump( $cursor12->getNext() );
				
				//foreach ( $cursor13 as $co ) {
					
					// echo "cpxprice" . $co['cpxprice']."<br/>";
					
					// echo $co['id']."<br/>";
					
		 ///////////////////////////////IF DB iS EMPTY///////////////////////////////
		 /* if($collection -> count() == 0){
		 	for($i = 0; $i < $max; $i ++) {
		 			
		 		// echo ($copy[$i]['status']=='current');
		 		if ($copy [$i] ['status'] == 'current' || $copy [$i] ['status'] == 'sold') {
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
		 } */
		 
		// else{

//echo "<pre>results copy";
//print_r($copy);

//echo "<pre>results";
//print_r($realproperties);
//echo "</pre>";
//die;
                    
                    //adding publisher to publisher table starts here
                    $collection_publishers = $m1->$db2->publishers;
                    $collection_users = $m1->$db2->users;
                    $collection_listing_agents = $m1->$db2->listing_agents;
                    $collection_vendors= $m1->$db2->vendors;
                    foreach($realproperties as $properties)
                    {
                        $publisherId = '';
                        if(!empty($properties['agentID']))
                            $publisherId = $properties['agentID'];
                            
                        $foundUser = '';
                        $searchUserQueryArr = array();
                                
                        if(!empty($publisherId))
                        {
                            $searchUserQueryArr = array('$and'=>array(array('username'=>$publisherId),array('type'=>'user')));
                        }     
                        
                        if(!empty($searchUserQueryArr))
                            $foundUser = $collection_users->findOne($searchUserQueryArr);
                        
                        if(!empty($foundUser))
                        {
                            $retval = $collection_users->findAndModify ( $searchUserQueryArr, array (
            											'$set' => array (
            													"type" => 'publisher',
            											)
            								
            									));
                        }
                        
                        $foundContact = 'notfound';
                        
                        $searchQueryArr = array();
            
                        if(!empty($publisherId))
                            $searchQueryArr['agentID']= $publisherId;    

        //  echo "<pre>contact";
        //print_r($searchQueryArr);
        //echo "</pre>";                      
                        
                        if(!empty($searchQueryArr))
                            $foundContact = $collection_publishers->findOne($searchQueryArr);

//echo "<pre>contact";
//print_r($foundContact);
//echo "</pre>";
                                
                        if(empty($foundContact))
                        {
                            
                            $foundLastContact = $collection_publishers->find()->sort(array("_id" => -1))->limit(1);
                            $lastContactArr = array ();
                    		foreach ( $foundLastContact as $result ) {
                    		  array_push ( $lastContactArr, $result );
                    		} 

//echo "<pre>lastcontact";
//print_r($lastContactArr);
//echo "</pre>";
                            
                            $publisherdata = '';
                            $publisherdata['agentID'] = $publisherId; 
                            
                            if(!empty($lastContactArr))
                                $nextID = $lastContactArr['0']['id']+1;
                            else
                                $nextID = 1;
                                
                            $publisherdata['id'] = "$nextID";
                            
                            $publisherdata['status'] = true;
                            
                            
                            //echo "<pre>publisherdata";print_r($publisherdata);
                            //exit;
                                    
                            $collection_publishers->insert ( $publisherdata, array ("safe" => true) );
                        }
                         
                        //adding publisher to publisher table ends here
                        
                        //adding publisher as user to user table starts here

                        $publisherId = '';
                        if(!empty($properties['agentID']) && filter_var($properties['agentID'], FILTER_VALIDATE_EMAIL))
                        {
                            $publisherId = $properties['agentID'];
                        
                            $foundUser = '';
                            $searchUserQueryArr = array();
                                    
                            if(!empty($publisherId))
                                $searchUserQueryArr['username']= $publisherId;    
                            
                            if(!empty($searchUserQueryArr))
                                $foundUser = $collection_users->findOne($searchUserQueryArr);
                            
                            if(empty($foundUser))
                            {
                                
                                $foundLastRecord = $collection_users->find()->sort(array("_id" => -1))->limit(1);
                                $lastRecordArr = array ();
                                foreach ( $foundLastRecord as $result ) {
                                    array_push ( $lastRecordArr, $result );
                                } 
                    
                                if(!empty($lastRecordArr))
                                    $nextID = $lastRecordArr['0']['id']+1;
                                else
                                    $nextID = 1;
                                    
                                $verification_token = sha1(substr(uniqid(rand(), true), 12, 12));
            
                                $password = $this->generate_password();
                                
                                $curr_date = date('Y m d h:i:s');
                                
                                $tmp_date = explode(' ',$curr_date);
                                $tmp_time = explode(':',$tmp_date['3']);
                                                                                
                                $registration_timestamp = mktime($tmp_time['0'],$tmp_time['1'],$tmp_time['2'],$tmp_date['1'],$tmp_date['2'],$tmp_date['0']);                                    
                                    
                                $userdata = array();
                                $userdata['id'] = "$nextID";
                                $userdata['username'] = $properties['agentID'];
                                $userdata['password'] = $password;
                                $userdata['firstname'] = '';
                                $userdata['email'] = $properties['agentID'];
                                $userdata['type'] = 'publisher';
                                $userdata['lastname'] = '';
                                $userdata['phone_number'] = '';
                                $userdata['company_name'] = '';
                                $userdata['status'] = "inactive";
                                $userdata['system_generated_user'] = true;
                                                
                                /*$userdata['verification_token'] = $verification_token;
                                $userdata['registration_timestamp'] = $registration_timestamp;*/
                                                
                
//echo "<br>currdate==>".$curr_date;
//echo '<br>mktime==>'.date('d M Y h:i:s', $userdata['registration_timestamp'] );
//echo "<pre>tmp_dte";print_r($tmp_date);
//echo "<pre>tmp_time";print_r($tmp_time);
//echo "<pre>";
//print_r($this->data);
//print_r($userdata);
//echo "</pre>";

                                
                                /*$verificationLink = ADMIN_PATH . 'auth/verify_user/' . $verification_token;
            
                                $properties_link = WEB_PATH . '#!/' . $properties['agentID'];
                                           
                                $email = $properties['agentID'];
                                
                                $userType = 'publisher';
                                
                                $data['email'] = $email;
                                $data['link'] = $verificationLink;
                                $data['password'] = $password;
                                $data['properties_link'] = $properties_link;
                                $data['user_type'] = $userType;
                                
                                $subject = 'Welcome to CPx for the management of published properties';
                                $template = 'welcome_user';
                                $message = 'A welcome mail has been sent to the user.';
                                
                                
                                $Email2registration_verified = new CakeEmail('sendgrid');
                                                        
                                $Email2registration_verified->from(array('admin@centralpropertyexchange.com.au' => 'CPx Admin'));
                                $Email2registration_verified->to($email);
                                
                                
                                $Email2registration_verified->subject($subject);
                                $Email2registration_verified->template($template);
                                $Email2registration_verified->viewVars(array('data' => $data));
                                $Email2registration_verified->emailFormat('html');
                                
                                $Email2registration_verified->send();*/
                                                                        
                                $collection_users->insert ( $userdata, array (
                        										"safe" => true
                        								) );
                            }
                        }
                        
                        //adding publihser as user to user table ends here
                        
                        //adding listing agent to listing agent table starts here
                        $agentID = $properties['agentID'];
                        foreach($properties['contact'] as $contacts)
                        {
                            if($contacts['type'] == 'listingAgent')
                            {
            //echo "<br>agentid==>".$agentID;
            //echo "<pre>contact";
            //print_r($contacts);
            //echo "</pre>";
            //die;
                                
                                $listing_agent_email = '';
                                if(!empty($contacts['email']))
                                    $listing_agent_email = $contacts['email'];
                            
                                $foundUser = '';
                                $searchUserQueryArr = array();
                                        
                                if(!empty($listing_agent_id))
                                {
                                    $searchUserQueryArr = array('$and'=>array(array('username'=>$listing_agent_email),array('type'=>'user')));
                                } 
                                        
                                
                                if(!empty($searchUserQueryArr))
                                    $foundUser = $collection_users->findOne($searchUserQueryArr);
                                
                                if(!empty($foundUser))
                                {
                                    $retval = $collection_users->findAndModify ( $searchUserQueryArr, array (
                    											'$set' => array (
                    													"type" => 'listing agent',
                    											)
                    								
                    									));
                                }
                                
                                
                                $foundListingAgent = 'notfound';
                                $searchQueryArr = array();
                                        
                                if(!empty($listing_agent_email))
                                    $searchQueryArr['email']= $listing_agent_email;    
                                
                                if(!empty($searchQueryArr))
                                    $foundListingAgent = $collection_listing_agents->findOne($searchQueryArr);
                                       
                                if(empty($foundListingAgent))
                                {
                                    
                                    $foundLastListingAgent = $collection_listing_agents->find()->sort(array("_id" => -1))->limit(1);
                                    $lastListingAgentArr = array ();
                            		foreach ( $foundLastListingAgent as $result ) {
                            		  array_push ( $lastListingAgentArr, $result );
                            		} 
                                    
                                    $listingAgentdata = '';
                                    
                                    if(!empty($lastListingAgentArr))
                                        $nextID = $lastListingAgentArr['0']['id']+1;
                                    else
                                        $nextID = 1;
                                                                                        
                                    $listingAgentdata['id'] = "$nextID";
                                    $listingAgentdata['agentID'] = $agentID; 
                                    $listingAgentdata['email'] = $listing_agent_email; 
                                    $listingAgentdata['name'] = $contacts['name'];
                                    $listingAgentdata['telephone'] = $contacts['telephone'];
                                    $listingAgentdata['status'] = true;
                                    
                                    
            //        echo "<pre>publisherdata";print_r($listingAgentdata);
            //        exit;
                                    $collection_listing_agents->insert ( $listingAgentdata, array ("safe" => true) );                                   
                                        
                                }
                                //adding listing agent to listing agent table ends here
                                
                                //adding listing agent to users table starts here
                                $listingAgentId = '';
                                if(!empty($contacts['email']) && filter_var($contacts['email'], FILTER_VALIDATE_EMAIL))
                                {
                                    $listingAgentId = $contacts['email'];
                                
                                    $foundUser = '';
                                    $searchUserQueryArr = array();
                                            
                                    if(!empty($listingAgentId))
                                        $searchUserQueryArr['username']= $listingAgentId;    
                                    
                                    if(!empty($searchUserQueryArr))
                                        $foundUser = $collection_users->findOne($searchUserQueryArr);
                                    
                                    if(empty($foundUser))
                                    {
                                        
                                        $foundLastRecord = $collection_users->find()->sort(array("_id" => -1))->limit(1);
                                        $lastRecordArr = array ();
                                        foreach ( $foundLastRecord as $result ) {
                                            array_push ( $lastRecordArr, $result );
                                        } 
                            
                                        if(!empty($lastRecordArr))
                                            $nextID = $lastRecordArr['0']['id']+1;
                                        else
                                            $nextID = 1;
                                        
                                        $verification_token = sha1(substr(uniqid(rand(), true), 12, 12));
            
                                        $password = $this->generate_password();
                                        
                                        $curr_date = date('Y m d h:i:s');
                                        
                                        $tmp_date = explode(' ',$curr_date);
                                        $tmp_time = explode(':',$tmp_date['3']);
                                                                                        
                                        $registration_timestamp = mktime($tmp_time['0'],$tmp_time['1'],$tmp_time['2'],$tmp_date['1'],$tmp_date['2'],$tmp_date['0']);     
                                        
                                        $userdata = array();
                                        
                                        $userdata['id'] = "$nextID";
                                        $userdata['username'] = $contacts['email'];
                                        $userdata['password'] = $password;
                                        $userdata['firstname'] = '';
                                        $userdata['email'] = $contacts['email'];
                                        $userdata['type'] = 'listing agent';
                                        $userdata['lastname'] = '';
                                        $userdata['phone_number'] = '';
                                        $userdata['company_name'] = '';
                                        $userdata['status'] = "inactive";
                                        $userdata['system_generated_user'] = true;
                                        
                                        
                                        /*$userdata['verification_token'] = $verification_token;
                                        $userdata['registration_timestamp'] = $registration_timestamp;*/
                                        
                        //echo "<pre>";
                        //
                        //print_r($userdata);
                        //echo "</pre>";
                        //die;
                                        
                                        /*$verificationLink = ADMIN_PATH . 'auth/verify_user/' . $verification_token;
            
                                        $properties_link = WEB_PATH . '#!/' . $contacts['email'];
                                                   
                                        $email = $contacts['email'];
                                        
                                        $userType = 'listing agent';
                                        
                                        $data['email'] = $email;
                                        $data['link'] = $verificationLink;
                                        $data['password'] = $password;
                                        $data['properties_link'] = $properties_link;
                                        $data['user_type'] = $userType;
                                        
                                        $subject = 'Welcome to CPx for the management of published properties';
                                        $template = 'welcome_user';
                                        $message = 'A welcome mail has been sent to the user.';
                                        
                                        
                                        $Email2registration_verified = new CakeEmail('sendgrid');
                                                                
                                        $Email2registration_verified->from(array('admin@centralpropertyexchange.com.au' => 'CPx Admin'));
                                        $Email2registration_verified->to($email);
                                        
                                        $Email2registration_verified->subject($subject);
                                        $Email2registration_verified->template($template);
                                        $Email2registration_verified->viewVars(array('data' => $data));
                                        $Email2registration_verified->emailFormat('html');
                                        
                                        $Email2registration_verified->send();*/
                                                
                                        $collection_users->insert ( $userdata, array (
                                										"safe" => true,"new"=>true, 'upsert'=>true
                                								) );
                                    }
                                }
                                //adding listing agent to users table ends here
                            }
                            elseif($contacts['type'] == 'vendorDetails')//adding vendors to vendor table starts here
                            {
                                $vendor_email = '';
                                if(!empty($contacts['email']) )
                                    $vendor_email = $contacts['email'];
                                    
                                $foundUser = '';
                                $searchUserQueryArr = array();
                                        
                                if(!empty($vendor_email))
                                {
                                    $searchUserQueryArr = array('$and'=>array(array('username'=>$vendor_email),array('type'=>'user')));
                                } 
                                    
                                
                                if(!empty($searchUserQueryArr))
                                    $foundUser = $collection_users->findOne($searchUserQueryArr);
                                
                                if(!empty($foundUser))
                                {
                                    $retval = $collection_users->findAndModify ( $searchUserQueryArr, array (
                    											'$set' => array (
                    													"type" => 'vendor',
                    											)
                    								
                    									));
                                }
                                
                                
                                
                                
                                $foundVendor = 'notfound';
                                $searchQueryArr = array();
                                        
                                if(!empty($vendor_email))
                                    $searchQueryArr['email']= $vendor_email;    
                                
                                if(!empty($searchQueryArr))
                                    $foundVendor = $collection_vendors->findOne($searchQueryArr);
                                       
                                if(empty($foundVendor))
                                {
                                    
                                    $foundLastVendor = $collection_vendors->find()->sort(array("_id" => -1))->limit(1);
                                    $lastVendorArr = array ();
                            		foreach ( $foundLastVendor as $result ) {
                            		  array_push ( $lastVendorArr, $result );
                            		} 
                                    
                                    $vendordata = '';
                                    
                                    if(!empty($lastVendorArr))
                                        $nextID = $lastVendorArr['0']['id']+1;
                                    else
                                        $nextID = 1;
                                                                                        
                                    $vendordata['id'] = "$nextID";
                                    $vendordata['agentID'] = $agentID; 
                                    $vendordata['email'] = $vendor_email; 
                                    $vendordata['name'] = $contacts['name'];
                                    $vendordata['telephone'] = $contacts['telephone'];
                                    $vendordata['status'] = true;
                                    
                                    
            //        echo "<pre>publisherdata";print_r($listingAgentdata);
            //        exit;
                                                                   
                                    $collection_vendors->insert ( $vendordata, array ("safe" => true) );
                                }
                                //adding vendors to vendor table ends here
                                
                                //adding vendors to user table starts here
                                $vendorId = '';
                                if(!empty($contacts['email']) && filter_var($contacts['email'], FILTER_VALIDATE_EMAIL))
                                {
                                    $vendorId = $contacts['email'];
                                
                                    $foundUser = '';
                                    $searchUserQueryArr = array();
                                            
                                    if(!empty($vendorId))
                                        $searchUserQueryArr['username']= $vendorId;    
                                    
                                    if(!empty($searchUserQueryArr))
                                        $foundUser = $collection_users->findOne($searchUserQueryArr);
                                    
                                    if(empty($foundUser))
                                    {
                                        
                                        $foundLastRecord = $collection_users->find()->sort(array("_id" => -1))->limit(1);
                                        $lastRecordArr = array ();
                                        foreach ( $foundLastRecord as $result ) {
                                            array_push ( $lastRecordArr, $result );
                                        } 
                            
                                        if(!empty($lastRecordArr))
                                            $nextID = $lastRecordArr['0']['id']+1;
                                        else
                                            $nextID = 1;
                                        
                                        $verification_token = sha1(substr(uniqid(rand(), true), 12, 12));
            
                                        $password = $this->generate_password();
                                        
                                        $curr_date = date('Y m d h:i:s');
                                        
                                        $tmp_date = explode(' ',$curr_date);
                                        $tmp_time = explode(':',$tmp_date['3']);
                                                                                        
                                        $registration_timestamp = mktime($tmp_time['0'],$tmp_time['1'],$tmp_time['2'],$tmp_date['1'],$tmp_date['2'],$tmp_date['0']);     
                                        
                                        $userdata = array();
                                        
                                        $userdata['id'] = "$nextID";
                                        $userdata['username'] = $contacts['email'];
                                        $userdata['password'] = $password;
                                        $userdata['firstname'] = '';
                                        $userdata['email'] = $contacts['email'];
                                        $userdata['type'] = 'vendor';
                                        $userdata['lastname'] = '';
                                        $userdata['phone_number'] = '';
                                        $userdata['company_name'] = '';
                                        $userdata['status'] = "inactive";
                                        $userdata['system_generated_user'] = true;
                                        
                                        /*$userdata['verification_token'] = $verification_token;
                                        $userdata['registration_timestamp'] = $registration_timestamp;*/
                                        
                        //echo "<pre>";
                        //
                        //print_r($userdata);
                        //echo "</pre>";
                        //die;
                                        
                                        /*$verificationLink = ADMIN_PATH . 'auth/verify_user/' . $verification_token;
            
                                        $properties_link = WEB_PATH . '#!/' . $contacts['email'];
                                                   
                                        $email = $contacts['email'];
                                        
                                        $userType = 'vendor';
                                        
                                        $data['email'] = $email;
                                        $data['link'] = $verificationLink;
                                        $data['password'] = $password;
                                        $data['properties_link'] = $properties_link;
                                        $data['user_type'] = $userType;
                                        
                                        $subject = 'Welcome to CPx for the management of published properties';
                                        $template = 'welcome_user';
                                        $message = 'A welcome mail has been sent to the user.';
                                        
                                        
                                        $Email2registration_verified = new CakeEmail('sendgrid');
                                                                
                                        $Email2registration_verified->from(array('admin@centralpropertyexchange.com.au' => 'CPx Admin'));
                                        $Email2registration_verified->to($email);
                                        
                                        $Email2registration_verified->subject($subject);
                                        $Email2registration_verified->template($template);
                                        $Email2registration_verified->viewVars(array('data' => $data));
                                        $Email2registration_verified->emailFormat('html');
                                        
                                        $Email2registration_verified->send();*/
                                                                                        
                                        $collection_users->insert ( $userdata, array (
                                										"safe" => true,"new"=>true, 'upsert'=>true
                                								) );
                                    }
                                }
                                //adding vendorst to user table ends here
                            }
                        }
                    }
                    
                    
                    
		
					for($i = 0; $i < $max; $i ++) {
						// echo $co['id']."<br/>";
						// echo $co['id']."=".$copy[$i]['id'];
						// echo ($co['id']==$copy[$i]['id'])."<br/>";
						// var_dump($copy[$i]['id']);
						
						$listing = $collection->findOne(array('property_id' => $copy [$i] ['property_id'] ));
						$listingSize = sizeof($listing);
						echo " LISTING LENTH == " . sizeof($listing);
						if($listingSize != 0){
						
							$datearray = date_create_from_format ( 'Y-m-d-H:i:s', $copy [$i] ['modifiedon'] );
							$datedb = date_create_from_format ( 'Y-m-d-H:i:s', $listing ['modifiedon'] );
							$arraymoddate = date_format ( $datearray, 'Y-m-d-H:i:s' );
							$dbmoddate = date_format ( $datedb, 'Y-m-d-H:i:s' );
							//print_r($listing); die;
							
						//echo "<br/>date compaire $arraymoddate == $dbmoddate";exit;	
						if($arraymoddate > $dbmoddate){
							if ($copy [$i] ['status'] == 'current' || $copy [$i] ['status'] == 'sold') {
								echo "DATES MODIFIED THUS UPDATING RECORD of ID =>" . $copy [$i] ['property_id'] ."<br>";
								
								$updateAgentsID = $copy [$i] ['agentID'];
								$updateId = $copy [$i] ['property_id'];
								
								if( isset($updatedProperties1[$updateAgentsID] )){
									//echo "TEUe";
									$updateCounterAgents ++;
									//$updatedProperties1[$updateAgentsID]['Ids'][$i] = $updateId;
									$updatedProperties1[$updateAgentsID]['Ids'][$updateCounterAgents] = $updateId;
								}
								else{
									//echo "RESET";
									$updateCounterAgents = 1;
									//$updatedProperties1[$updateAgentsID]['Ids'][$i] = $updateId;
									$updatedProperties1[$updateAgentsID]['Ids'][$updateCounterAgents] = $updateId;
								}
								
								//////////IMAGE UPDATE////////
								
								//print_r($validImages);die;
								
								
								//////////////////////////////
								$newquery = array (
										"property_id" => $copy [$i] ['property_id']
								);

//
//echo "<pre>new query";
//print_r($newquery);
//exit;
//								
								$retval = $collection->findAndModify ( $newquery, array (
										'$set' => array (
												"modifiedon" => $copy [$i] ['modifiedon'],
                                                "agentID" => $copy [$i] ['agentID'],
												"batchID" => $batchId,
												"name" => $copy [$i] ['name'],
												"headline" => $copy [$i] ['headline'],
												"authority" => $copy [$i] ['authority'],
												"auction_date" => $copy [$i] ['auction_date'],
												"category" => $copy [$i] ['category'],
												"contact" => $copy [$i] ['contact'],
												// "cpxprice" => $copy [$i] ['cpxprice'],  
                                                "displayprice" => $copy [$i] ['displayprice'],
												"listedprice" => $copy [$i] ['listedprice'],
												"viewprice" => $copy [$i] ['viewprice'],
												// "saving" => $copy [$i] ['saving'],
												// "marketrent" => $copy [$i] ['marketrent'], 
												"beds" => $copy [$i] ['beds'],
												"bath" => $copy [$i] ['bath'],
												"cars" => $copy [$i] ['cars'],
												//"IsHouseLandPackage" => $copy [$i] ['IsHouseLandPackage'],
												"landarea" => $copy [$i] ['landarea'],
												"areaunit" => $copy [$i] ['areaunit'],
												"buildingarea" => $copy [$i] ['buildingarea'],
                                                "lat" => $copy [$i] ['lat'],
                                                "lon" => $copy [$i] ['lon'],
												"date_created" => $copy [$i] ['date_created'],
           	                                    "offline" => $copy [$i] ['offline'],
												// "featured" => $copy [$i] ['featured'],
												//"latest" => $copy [$i] ['latest'],
												//"smsf" => $copy [$i] ['smsf'],
												"sold" => $copy [$i] ['sold'],
												"deposit" => $copy [$i] ['deposit'],
                                                "homelandpackage" => $copy [$i] ['homelandpackage'],
                                                "newConstruction" => $copy [$i] ['newConstruction'],
                                                //"vendorfinance" => $copy [$i] ['vendorfinance'],
												//"domacom" => $copy [$i] ['domacom'],
												// "grade" => $copy [$i] ['grade'],
												//"score" => $copy [$i] ['score'],
												//"gradelabel" => $copy [$i] ['gradelabel'], */
												"address" => $copy [$i] ['address'],
												"images" => $copy [$i] ['images'],
												//"validImages" => $validImages,
												"features" => $copy [$i] ['features'],
												"views" => $copy [$i] ['views'],
												"idealFor" => $copy [$i] ['idealFor'],
												"ecoFriendly" => $copy [$i] ['ecoFriendly'],
												// "estimate" => $copy [$i] ['estimate'],
												 "contract" => $copy [$i] ['contract'],
								//"sale_summary" => $copy [$i] ['sale_summary'],
								//"history" => $copy [$i] ['history'],
								//"how_to_buy" => $copy [$i] ['how_to_buy'],
								//"loan_cal" => $copy [$i] ['loan_cal'],
								//"invest_cal" => $copy [$i] ['invest_cal'], 
												//"support_info" => $copy [$i] ['support_info'],
												"documents" => $copy [$i] ['documents'],
												"floorplans" => $copy [$i] ['floorplans'],
												"inspectionTimes" => $copy [$i] ['inspectionTimes'],
												/* "ipr" => $copy [$i] ['ipr'], */
												"description" => $copy [$i] ['description'],
												"observation" => $copy [$i] ['observation'],
                                                "cpximages"=>0,
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
								
								//if(sizeOf($updatedProperties1) >= 0){
								$updatedProperties1[$updateAgentsID]['TotalCount'] = sizeOf($updatedProperties1[$updateAgentsID]['Ids']);
								//}
								
							}
							else {
									
								// echo "in delete";
								// DELETE
								//echo "DELETING RECORD of ID =>" . $copy [$i] ['id']."<br>";
								echo "MAXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX <br>";
								print_r($copy [$i]);
								echo "<br> ENDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDD";
								$deletedAgentsID = $copy [$i] ['agentID'];
									
								if( isset($deletedProperties1[$deletedAgentsID] )){
									echo "TRUE";
									$deleteCounterAgents ++;
									//$deletedProperties1[$deletedAgentsID]['Ids'][$i] = $deletedId;
									$deletedProperties1[$deletedAgentsID]['Ids'][$deleteCounterAgents] = $deletedId;
								}
								else{
									echo "RESET";
									$deleteCounterAgents = 1;
									//$deletedProperties1[$deletedAgentsID]['Ids'][$i] = $deletedId;
									$deletedProperties1[$deletedAgentsID]['Ids'][$deleteCounterAgents] = $deletedId;
								}
								
								
								$newquery = array (
										"property_id" => $copy [$i] ['property_id']
								);
									
								$retval = $collection->findAndModify ( $newquery, null, null, array (
											
										"remove" => true
								) );
							
								//if(sizeOf($deletedProperties1) >= 0){
								$deletedProperties1[$deletedAgentsID]['TotalCount'] = sizeOf($deletedProperties1[$deletedAgentsID]['Ids']);
								//$deletedProperties1[$deletedAgentsID] = 5;
								//}
							}
							
							
							
							//$updatedProperties1[$updateAgentsID] = $updateCounterAgents;
							
						}
						else { echo " Not modified Dates "; }
					}
					else{
						echo " ADDING NEW RECORD of ID =>" . $copy [$i] ['property_id']."<br>";
						
						
						
						if ($copy [$i] ['status'] == 'current' || $copy [$i] ['status'] == 'sold') {
							
							
							$agentsID = $copy [$i] ['agentID'];
							$newId = $copy [$i] ['property_id'];
							
							if( isset($newlyAddedProperties1[$agentsID] )){
								echo "TRUE";
								$counterAgents ++;
								$newlyAddedProperties1[$agentsID]['Ids'][$counterAgents] = $newId;
								//array_push($newlyAddedProperties1[$agentsID]['Ids'][$counterAgents], $newId);
								
							}
							else{
								//$newlyAddedProperties1[$agentsID] = array();
								echo "RESET";
								$counterAgents = 1;
								//array_push($newlyAddedProperties1[$agentsID]['Ids'][$counterAgents], $newId);
								$newlyAddedProperties1[$agentsID]['Ids'][$counterAgents] = $newId;
								
							}
							
							
							// if($newId != ''){
							//array_push($newIds , $newId);
							//} 
							
							//array_push($newlyAddedProperties['AGENT']['Count'] , $counterAgents);
							
							//$newlyAddedProperties['AGENT']['Name'] = $copy [$i] ['agentID'];
							//$newlyAddedProperties[$agentsID] = $counterAgents;
							//array_push($newlyAddedProperties1['title'] ,$agentsID);
							//array_push($newlyAddedProperties1['Count'] ,$counterAgents);
							
							
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
													
							 //print_r($retval);die;
						}
						//echo "SIIIIIZZZZWWWW ============ " .sizeOf($newlyAddedProperties1) ;
						
						//if(!empty($counterAgents)){
						//$newlyAddedProperties1[$agentsID]['Count'] = $counterAgents;
						$newlyAddedProperties1[$agentsID]['TotalCount'] = sizeOf($newlyAddedProperties1[$agentsID]['Ids']);
						//$newlyAddedProperties1[$agentsID]['Ids'] = $newIds;
						//}
					}
				}	
				
			//}
			
			
			
			
			
		// MOVING FILES
				
	
	
        //echo "<pre>";print_r($newparsingfiles);print_r($destparsingfiles);exit;
    	copy($source.$newparsingfiles[$r], $destination.$destparsingfiles[$r]);
        //copy($source.$parsingfiles[$r], $destination.$parsingfiles[$r]);
		
		$delete[] = $source.$newparsingfiles[$r];
			
		//usleep(2000000);
		
	/* if($r == 1){
		die;
	} */
	
		
		///////////single File END////////////
			}	
		
	}
	//array_push($newlyAddedProperties , $newlyAddedProperties1);
	//array_push($updatedProperties , $updatedProperties1);
	//array_push($deletedProperties , $deletedProperties1);
	$newlyAddedProperties =  $newlyAddedProperties1;
	$updatedProperties = $updatedProperties1;
	$deletedProperties = $deletedProperties1;
	
	/* $newcount = $collection ->count();
	echo "NEWCOUNT => " . $newcount;
	
	 $newProps['AgentId'] = array();
	
	
	
	 $recently_added_count =  $newcount - $oldcount;
	
	$cursorgetUpdated = $collection->find()->sort(array('modifiedon'=>-1))->limit($recently_added_count);
	if($recently_added_count != 0){
		foreach ( $cursorgetUpdated as $updateresult ) {
			
			array_push ( $newProps['AgentId'], $updateresult['agentID'] );
			
		}
	}
	else{
		$newProps = array();
	}*/
    
    echo "<pre>"; print_r($delete);echo "</pre>";
    
	echo "<br>";
	echo " NewlyADDED >>>>"; print_r($newlyAddedProperties);
	echo "<br>";
	echo " UpDATED >>>>"; print_r($updatedProperties);
	echo "<br>"; 
	echo " DELETED >>>>"; print_r($deletedProperties1);
	echo "<br>";	
	
	$masterDataArray['New'] = $newlyAddedProperties;
	$masterDataArray['Update'] = $updatedProperties;
	$masterDataArray['Delete'] = $deletedProperties1;
	
    $totalPropCount = 0;
	foreach ($newlyAddedProperties as $updatekey => $updateval) {
		//print_r($updateval);
		if (isset($updateval['TotalCount']))
		{
			$totalPropCount = $totalPropCount + $updateval['TotalCount'];
		}
		else{
			//echo "Not Found";
		}
	}
	foreach ($updatedProperties as $updatekey => $updateval) {
		//print_r($updateval);
		if (isset($updateval['TotalCount']))
		{
			$totalPropCount = $totalPropCount + $updateval['TotalCount'];
		}
		else{
			//echo "Not Found";
		}
	}
	echo "<br> FinalCount => ". $totalPropCount;
	
	//print_r($newlyAddedProperties);die;
	$apiurl = Configure::read('API_URL');
	/*
    if($totalPropCount != 0 && !empty($batchId)){
		 echo "<br> DB updated";
         echo $apiurl.'/Updateimagearray?batchID='.$batchId;
		$this -> callImageUpdater($apiurl.'/Updateimagearray?batchID='.$batchId);
	}
	else {echo "<br> No DB updates";}
    */

//echo "<pre>";
//print_r($delete); 
//die;
	
	//print_r($delete);
	if( !empty( $delete ) ){
		$this ->deleteFiles($delete);
	}
	
	else{}

    //removing all folders	
     
     /* $removeDir = $this->removeAllEmptyDir($dir);
      
      foreach($removeDir as $k=>$dirpath)
      {
        if(rmdir($dirpath))
            echo "<br>".$dirpath."  removed";
        else
           echo "<br>".$dirpath." not removed";     
      }
      
      */          
        
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
		
	  //To add total Listed Properties in the mail sent to the admin	
        $newquery = array ('offline' => false);
        $masterDataArray['totallistedProp'] = $collection-> count($newquery);
        
        $masterDataArray['totalliveproperties'] = $this->getLivePropertiesCount();
                        
       //echo "<pre>"; print_r($masterDataArray);echo "</pre>"; 
        $this -> sendEmailToAdmin($masterDataArray);
        
        $m1->close();
	}
	
    public function getLivePropertiesCount()
    {
        $serUrl = Configure::read('CONNECT_SER');
			
		$m1 = new MongoClient($serUrl);

		$db2 = $m1->properties;
        
        $collection_properties = $m1->$db2->realprop;
        
        $collection_publishers = $m1->$db2->publishers;
        
        $newquery1= array('status' => false);
        $cursor1 = $collection_publishers->find ($newquery1);
        
		$deactivatepub = array ();
		foreach ( $cursor1 as $result ) {
		  $deactivatepub[] = $result['agentID'];
		} 
        
        $nq = array('$and'=>array(array('offline'=>false),array('agentID'=>array('$nin'=>$deactivatepub))));
        
        $total_live_properties = $collection_properties-> count($nq);

        $m1->close();
      
        return $total_live_properties;
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
	
    public function createCpxPropertyId()
    {
        $serUrl = Configure::read('CONNECT_SER');
			
		$m1 = new MongoClient($serUrl);
			
		$db2 = $m1->properties;
			
		$collection = $m1->$db2->realprop;
        
        $cursor1 = $collection->find ();
        
        $propertyList = array();
            		
		foreach ( $cursor1 as $result ) 
        {
		  array_push ( $propertyList, $result );
		}         
        
//echo "<pre>list1";
//print_r($propertyList);
//echo "</pre>";
//die;


       foreach($propertyList as $key=>$val)
       {
            
            //echo $val['id'];
            if(substr($val['id'],0,3)=="cpx")
                {
                    echo "<br>already changed==>".$val['id'];
                    continue;
                }else
                {
            
            
            $propertyList[$key]['property_id'] = $val['id'];
            $propertyList[$key]['auto_gerated'] = 1;
            
            $DetailsId = $val['id'];
    		$xyz['id'] =  $DetailsId;
            $newquery = $xyz; 
            
           /* $retval = $collection->findAndModify ( $newquery, array (
											'$set' => array ('property_id'=>$val['id'])
								
									), null, array (
											"sort" => array (
													"priority" => - 1
											),
											"new" => true,
											array ("safe" => true),
												
									) );
             */                       
               }                                    
       } 
        
        $m1->close();
        
//echo "<pre>list2";
//print_r($propertyList);
echo "Done";
  
die;      
    }
    
    public function generateId()
    {
        $serUrl = Configure::read('CONNECT_SER');
			
		$m1 = new MongoClient($serUrl);
			
		$db2 = $m1->properties;
			
		$collection = $m1->$db2->realprop;
        
        $cursor1 = $collection->find ();
        
        $propertyList = array();
            		
		foreach ( $cursor1 as $result ) 
        {
		  array_push ( $propertyList, $result );
		}         
        
//echo "<pre>list1";
//print_r($propertyList);
//echo "</pre>";
//die;

       $idArray = array(); 
       foreach($propertyList as $key=>$val)
       {
            if(substr($val['id'],0,3)=="cpx")
            {
                    echo "<br>already changed==>".$val['id'];
                    $idArray[]=$val['id'];
                    continue;
            }else
                {
            
            $random_no = $this->RandomNumber($idArray);
            
            
            $idArray[] = $random_no;
            
            $propertyList[$key]['id'] = $random_no;   
            
            $DetailsId = $val['property_id'];
    		$xyz['property_id'] =  $DetailsId;
            $newquery = $xyz; 
            
           /* $retval = $collection->findAndModify ( $newquery, array (
											'$set' => array ('id'=>$random_no)
								
									), null, array (
											"sort" => array (
													"priority" => - 1
											),
											"new" => true,
											array ("safe" => true),
												
									) );      */
                                    
                                    
                                    
           }                                  
       } 
        $m1->close();
//echo "<pre>list2";
//print_r($propertyList);
//echo "</pre>";
echo "Done";  
die;      
    }
    
    public function RandomNumber($idArray)
    {
        $random_no = 'cpx'.mt_rand(100000,999999);
        
        if(in_array($random_no,$idArray))
        {
           return $this->RandomNumber($idArray);
        }
        else
        {
            return $random_no;
        }
        
        
    }
    
    //public function checkRandomNumber()
//    {
//        echo "<br>final random no".$this->checkCpxIdExist();
//        exit;
//    }
    
    public function checkCpxIdExist()
    {
        $serUrl = Configure::read('CONNECT_SER');
			
		$m1 = new MongoClient($serUrl);
			
		$db2 = $m1->properties;
			
		$collection = $m1->$db2->realprop;
        
        /*$randomnumber_array = array('cpx775261','cpx510790','cpx910569','cpx656342','cpx385612','cpx594039','cpx240932','cpx240932134');
        
        
        echo "<br>".$r_no = mt_rand(0,7);
        echo "<br>".$randomnumber_array[$r_no];
        
        $random_no = $randomnumber_array[$r_no];*/
        
        $random_no = 'cpx'.mt_rand(100000,999999);
        
        $Id = $random_no;
		$xyz['id'] =  $Id;
        $newquery = $xyz; 
        
        $cursor1 = $collection->find ($newquery);   
        
        $propertyList = array();
            		
		foreach ( $cursor1 as $result ) 
        {
		  array_push ( $propertyList, $result );
		}  
        
//echo "<br>randomno==>".$random_no;
//echo "<pre>query";
//print_r($newquery);
//echo "</pre>";
//
//echo "<pre>curson";
//print_r($propertyList);
//echo "</pre>";
//        echo $propertyList[0]['id'];
//        die;
        
        $m1->close();
        
        if(isset($propertyList[0]) && ($propertyList[0]['id'] == $random_no))
        {
           return $this->checkCpxIdExist();
        } 
        else
        {
            return $random_no;
        }
    }
    
	public function callImageUpdater($url){
	    $ch = curl_init($url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
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
			//chmod($file, 0755); 
            unlink($file);
		}
	}
	
	
	public function sendEmailToAdmin($dataArray) {
		
		
		 $apiurl = Configure::read('API_URL');
		$weburl = Configure::read('WEB_URL');
		
// 		$data['apiurl'] = $apiurl;
// 		$data['weburl'] = $weburl;
		if($apiurl == 'staging.api.centralpropertyexchange.com.au'){
			$subject = 'System notification: CPx property update report [STAGING]';
		}
		/* else if($apiurl == 'localhost/cpx/cpx.server'){
			$subject = 'System notification: CPx property update report [Local]';
		} */
		else{
			$subject = 'System notification: CPx property update report';
		}
		 //echo "SUBJ --- " .$subject;die;
		
	  // print_r($dataArray);
		
		//********* EMAIL TO CPx ADMIN *********\\
		
		$Email2cpxadmin = new CakeEmail('sendgrid');
		$Email2cpxadmin->from(array('contact@centralpropertyexchange.com.au' => 'CPx System email'));
		$Email2cpxadmin->to('contact@centralpropertyexchange.com.au');
        //$Email2cpxadmin->to('irshadahmed.ansari@gmail.com');
		$Email2cpxadmin->subject($subject);
		$Email2cpxadmin->template('scheduleupdate');
		$Email2cpxadmin->viewVars(array('dataArray' => $dataArray));
		$Email2cpxadmin->emailFormat('html');
		// if(isset($data['dummysubject'])){
			$Email2cpxadmin->send();
			//echo "Sent To Admin";
		//}
		//********* EMAIL TO CPx ADMIN END *********\\
		
		
	}
	
	
	function isImage($url){
		$notAllowedType = 'text/html';
		$info = get_headers($url ,1 );
		if($info['Content-Type'] != $notAllowedType){
			return 1;
		}
		else{
			return 0;
		}
	}
	
	
}

?>