<?php


ini_set ( 'memory_limit', '-1' );
ini_set ( 'max_execution_time', 3000 );

class SeedataController extends AppController {
	
	
	
	public function index() {
		
		//////////////////////
		
		$serUrl = Configure::read('CONNECT_SER');
			
		$m1 = new MongoClient($serUrl);
			
			
			
			
		// select a database
		$db2 = $m1->properties;
			
		$collection = $m1->$db2->realprop;
		
	    /////////////////////


		/* $propjson1 = file_get_contents('../../notgraded-property.txt' ,true );
		$propjson2 = file_get_contents('../../graded-property.txt' ,true );
		$propjson3 = file_get_contents('../../being-graded-property.txt' ,true );
		//$prop = strval($propjson);
		//echo $prop; die;
		
		
		$propjson1 = file_get_contents('../../Gradedprop1.txt' ,true );
		$propjson2 = file_get_contents('../../Gradedprop2.txt' ,true );
		$propjson3 = file_get_contents('../../Gradedprop3.txt' ,true );
		$propjson4 = file_get_contents('../../Gradedprop4.txt' ,true );
		
		
		
		$data1 = json_decode($propjson1, true);
		$data2 = json_decode($propjson2, true);
		$data3 = json_decode($propjson3, true);
		$data4 = json_decode($propjson4, true);
		//print_r($data1);
		//print_r($data2);
		
		
	
		try {
				$collection->insert ( $data1, array (
								"safe" => true 
						) );
		}catch( MongoCursorException $e ){
			
		}	
		 try {
			
			
								$collection->insert ( $data2, array (
								"safe" => true 
						) );	
		}catch( MongoCursorException $e ){
			
		}
		try {
			$collection->insert ( $data3, array (
					"safe" => true
			) );
		}catch( MongoCursorException $e ){
				
		} 
		
		 try {
			$collection->insert ( $data4, array (
					"safe" => true
			) );
		}catch( MongoCursorException $e ){
				
		} 
		 */
		
			$dhj = array();
			
			
			foreach ( $collection->find () as $result ) {
				// print_r($result);
					
				array_push ( $dhj, $result );
					
				// $someBSON = bson_decode($result);
				// print_r($dhj);
			}
			$newarray ["cpxpropertynow"] = $dhj;
			// print_r($newarray);
			$comeJSON = json_encode ( $newarray, JSON_PRETTY_PRINT );
			echo nl2br ( $comeJSON );
			
		/* $propjson1 = file_get_contents('../../Gradedprop1.txt' ,true );
		$data1 = json_decode($propjson1, true);
		
		$mongo = new Mongo();
		$db = $mongo->selectDB('properties');
		$coll = $db->selectCollection('my_collection');
		$cursor = $coll->find()->tailable(true);
		$cursor2 = $coll->find();
		
		try {
			$coll->insert ( $data1, array (
					"safe" => true,
					"unique" => true
			) );
		}catch( MongoCursorException $e ){
				
		} */
		
		
		
		 while (true) {
			if ($cursor->hasNext()) {
				$doc = $cursor->getNext();
				//print_r($doc);
				echo "XXX";
			} else {
				echo "YYY";
				echo $cursor -> count();
				echo $cursor2 -> count();
			}
			//echo $coll -> count();
		} 
		
		

		
		
		}	
		
	}
	
	

	
	
	
	
	
	
	
	


?>