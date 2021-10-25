<?php

use Cake\Routing\Router;
//ini_set ( 'max_execution_time', -1 );
ini_set('max_execution_time', 0);
error_reporting(0);

ignore_user_abort(true);
set_time_limit(0);

define ( "logfilesUrl", "../../datafiles/");

class ValidateimageController extends AppController {
	
	public $helpers = array('Html', 'Form');
	public $components = array('RequestHandler');
	public $totalCount;
	public $foo = '';
	
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		$this->response->header('Access-Control-Allow-Origin','*');
		$this->response->header('Access-Control-Allow-Methods','*');
		$this->response->header('Access-Control-Allow-Headers','X-Requested-With');
		$this->response->header('Access-Control-Allow-Headers','Content-Type, x-xsrf-token');
		$this->response->header('Access-Control-Max-Age','172800');
		
		/* $this->response->header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0"); // // HTTP/1.1
		$this->response->header("Pragma: no-cache"); */
	}
	
	
	public function index() {
		/*  $imagec= 'https://i1.au.reastatic.net/800x600/f1923a8418ef14c03786101d58b95ea5a25e4c1404d187c94d02c9390f382437/121637514-image-M.jpg';
		$imge2 = 'http://www.mantisproperty.com.au//database//images//extra_residential_710327.jpg';
		$imge3 = 'https://propertycompass.s3.amazonaws.com/properties/7bf5bcac-3b87-47a2-a206-2d07727786d6/images/Vibe 1.jpg';
		
		print_r(get_headers($imagec ,1 ));echo '<br>';echo '<br>';
		print_r(get_headers($imge2,1));echo '<br>';echo '<br>';
		print_r(get_headers($imge3,1));echo '<br>';echo '<br>'; die; */
		 
		
		$serUrl = Configure::read('CONNECT_SER');
			
		$m1 = new MongoClient($serUrl);
		
		// select a database
		$db2 = $m1->properties;
		
		$collection = $m1->$db2->realprop;
		
		//$cursor = $collection -> find();
		
		//$count = $cursor->count();
	
		//echo $count;
		
		/* $url = 'http://www.mantisproperty.com.au/database/images/extra_residential_767875.jpg';
		$info = get_headers($url ,1 );
		print_r($info);die; */
		
		/* 
		
		 // Create a curl handle
		 $ch = curl_init($imagec);
		 $ch2 = curl_init($imge2);
		 $ch3 = curl_init($imge3);
		 // Execute
		 curl_exec($ch);
		 curl_exec($ch2);
		 curl_exec($ch3);
		 // Check if any error occurred
		 //if(!curl_errno($ch))
		// {
		 	$info = curl_getinfo($ch);
		  $http_status = curl_getinfo($ch);
		  $info2 = curl_getinfo($ch2);
		  $http_status2 = curl_getinfo($ch2);
		  $info3 = curl_getinfo($ch3);
		  $http_status3 = curl_getinfo($ch3);
    //print_r(get_headers($imge2, 1));
		  echo '<br>';echo '<br>';
		 	print_r($info);
		 	echo '<br>';echo '<br>';
		 	print_r($info2);
		 	echo '<br>';echo '<br>';
		 	print_r($info3);
		 	echo '<br>';
		 	//print curl_error($ch);
		
		 	//echo 'Took ' . $info['total_time'] . ' seconds to send a request to ' . $info['url'] ;
		// }
		 
		 // Close handle
		 curl_close($ch);
		 curl_close($ch2);
		 curl_close($ch3);
		 
		 
		 die; */
		 
		/* $idArray =  array();
		
		foreach ( $cursor as $result ) {
			
			array_push ( $idArray,  $result['id'] );
			
			//echo $result['id'];
			
		}
		//print_r($idArray);
		
		$max = sizeOf($idArray);
		//echo $max;
		for($i = 0; $i < $max ; $i ++) {
			//print_r($idArray[0]);
			
				$newquery = array (
						"id" => $idArray[0]
				);
			
			$val = $collection->find ( $newquery);
				
			//$coll->update( $newquery , array('$set' => array("validImages" => "")));
			foreach ($val as $listing) {
				$imagesArray = $listing['images'];
			}
			/* foreach ($imagesArray as $image) {
				print_r($image);
				//echo sizeOf($imagesArray);
				$imagec = $image['url'];
				print_r($this -> exists($imagec));
			}	 
			 */
			
		//}
			
		
		 /*  echo "1)"; print_r(getimagesize($imagec));echo '<br>';echo '<br>';
		 echo "2)"; print_r(getimagesize($imge2));echo '<br>';echo '<br>';
		  echo "3)";print_r(getimagesize('https://propertycompass.s3.amazonaws.com/properties/7bf5bcac-3b87-47a2-a206-2d07727786d6/images/Vibe 1.jpg'));echo '<br>';echo '<br>';  die;
		
		  
		 
		 
		 // $content = file_get_contents($imge2);
		 
		 print_r($this->testCurl('http://www.centralpropertyexchange.com.au/images/nophotoavailable.png')); 
		 
		*/
		 
		// $limitDocs = 2;
		//$skipDocs = 0; 
		
		
		//echo "URL PARAMS ===";
		//print_r($this->params['url']);echo "<br><br>";
		
		 $docParams = $this->params['url'];
		
		//print_r($docParams); die;
        
        
        $loghandle = fopen(logfilesUrl."cronlog.txt", "a+");
        fwrite($loghandle,"\n"."inside Validate Images==>".$docParams['skip']);
        
		$limitDocs = 500;
		if( !empty( $docParams ) && isset($docParams['batchID']) )
		{
			$skipDocs = $docParams['skip'] ;
			$batchId = $docParams['batchID'];	
			$cusor12 = $collection -> find(array('batchID' => $batchId))->sort(array('modifiedon'=>-1)) ->skip($skipDocs) ->limit($limitDocs) ;
		}
		else if (!empty( $docParams ) && !isset($docParams['batchID'])){
			$skipDocs = $docParams['skip'] ;
			//echo "herecscscs";print_r($docParams);exit;
             if (!empty( $docParams ) && isset($docParams['id'])){
            
                    $cusor12 = $collection -> find(array('id' => $docParams['id']))->sort(array('modifiedon'=>-1)) ->skip($skipDocs) ->limit($limitDocs) ;
            }
            else
            {
                $cusor12 = $collection -> find()->sort(array('modifiedon'=>-1)) ->skip($skipDocs) ->limit($limitDocs) ;    
            }
            
            
		}
		else{
			
			$skipDocs = 0;
			$cusor12 = $collection -> find()->sort(array('modifiedon'=>-1)) ->skip($skipDocs) ->limit($limitDocs) ;
		}
		
		//echo "SkipDocs -> ".$skipDocs. "  ++++  LimitDocs" .$limitDocs . "<br>";
		//echo " here";exit;
 		// $cusor12 = $collection -> find()->sort(array('modifiedon'=>-1)) ->skip($skipDocs) ->limit($limitDocs) ;
        
		$counter = 0;
 		foreach ($cusor12 as $doc){
 		
 			
 			$propId = $doc['id'];
 			
            fwrite($loghandle,"\n"."skip doc -> {$skipDocs} Update Images For property ID   ".$propId);
             
            $propImages = $doc['images'];
            
            $oldvalidImages = $doc['validImages'];
           
            
            
             
 			
            //echo $doc['id'];
            
           // print_r($doc);
            
 		  //  print_r($propImages);
            
            
 			$ii = [];
            
            $imageUpdateFound = true;
 			
            if(is_array($propImages) && count($propImages)==0)
            {
                $imageUpdateFound = false;
            }
            
            foreach ($propImages as $image){
 				
 				$sal = $this->isImage($image['url']);
 				//echo  $image['url']. " ===> " .$sal ."<br>"; 
 			    //echo "sal ==>".$sal."  for".$image['url'];
	 			if($image['url'] !=''){	
	 				
	 				if($sal){
                         $notAddedInDB = false;
                         foreach($oldvalidImages as $oldvalidImage)
                         {
                           if($oldvalidImage['url']==$image['url']) 
                            {
                                $notAddedInDB = true;
                                break;
                            }
                         }
                         
                         if(!$notAddedInDB)
                         {
                           $imageUpdateFound = false; 
                         }
                         
                         
                         array_push($ii , $image) ;
	 					
                        // echo "<br>in if";
                         //array_push($ii['url'] , $image['url']) ;
	 				}
	 				else{
	 				  
                      $imageUpdateFound = false;
	 				}
	 				//array_push($ii , $sal) ;
	 				//print_r($ii);
 				
 				}else{
	 				  
                      $imageUpdateFound = false;
	 				}
 				
 			}
 			//$validImages ["validImages"] = $ii;
 			//  print_r($validImages);
 			
 			
            if(sizeOf($ii) == 0){
 				array_push($ii , array('id' => 0 , 'url' =>'http://www.centralpropertyexchange.com.au/images/nophotoavailable.png')) ;
 			    $imageFound = false;
             }
 			
 			if(!$imageUpdateFound)
            {
                    
                    $getPropertyQuery = array('id' => $propId);
         			//$collection -> update($getPropertyQuery , $validImages); 
         			
         			$retval = $collection->findAndModify(
         					$getPropertyQuery,
         					array('$set' => array('validImages' => $ii)),
         					null,
         					array(
         							"sort" => array("priority" => -1),
         							"new" => true,
         					)
         			);
            }
 			
 			//print_r($retval);
 			$counter ++;
 		}
 		fclose($loghandle);
        $m1->close();
 		
 	//	echo "<br> REDIRECTING <br>";
 		//echo $limitDocs + $skipDocs.' here now';
 		
 		 /* $this->redirect(array("controller" => "Validateimage",
 				"action" => "index",
	 				"?" => array(
	              "limit" => $limitDocs,
	              "skip" => $limitDocs + $skipDocs
	         		 ),
 				));  */
 		
 	
 		
		
		
		
			
			
			
		
 		
	}
	
	function url_exists($url) {
		if(@file_get_contents($url,0,NULL,0,1))
		{return 1;}
		else
		{ return 0;}
	}
	
			function exists($uri)
			{
			    $ch = curl_init($uri);
			    curl_setopt($ch, CURLOPT_NOBODY, true);
			    curl_exec($ch);
			    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			    curl_close($ch);
			
			    return $code;
}

function urlExists($url=NULL)
{
	if($url == NULL) return false;
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$data = curl_exec($ch);
	$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	if($httpcode>=200 && $httpcode<300){
		return true;
	} else {
		return false;
	}
}

/* function testCurl($url) {
	$notAllowedType = 'text/html';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT_MS, 1);
	// Execute
	curl_exec($ch);
	
	// Check if any error occurred
	//if(!curl_errno($ch))
	// {
	$info = curl_getinfo($ch);
	print_r($info);
	//$http_status = curl_getinfo($ch);
	if($info['content_type'] != $notAllowedType){
		return 1;
	}
	else{
		return 0;
	}
} */
	
//	function isImage($url){
//		$notAllowedType = 'text/html';
//		$info = getimagesize($url);
//
////echo "<pre>info==>".$url;
////echo print_r($info);
////echo "</pre>";        
//        
//		if(isset($info['mime']) && $info['mime'] != $notAllowedType){
//			return 1;
//		}
//		else{
//			return 0;
//		}
//	}
    
    function isImage($url){
		
		$info = get_headers($url ,1 );
        if (strpos($info['Content-Type'], 'image/') === FALSE) {
            return 0;
          }else
          {
            	return 1;
          }
		
	}
	
}
?>