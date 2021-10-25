
<?php
class DropdbController extends AppController {
	
	     public function index() {
	     	
	     	 $serUrl = Configure::read('CONNECT_SER');
	     	 	
	     	$m1 = new MongoClient($serUrl);
	     		
	     		
	     		
	     		
	     	// select a database
	     	echo "@ START" . "<br>";
	     	
	     	$db2 = $m1->properties;
	     	
	     	$collection = $m1->$db2->realprop;
	     	
	     	echo "count : " . ($collection->count()) . "<br>";
	     	
	     	
	     	
	     	echo "DROPING DB" . "<br>" ;
	     	
	     	$response = $db2->drop();
	     	
	     	echo "count : " . ($collection->count()) . "<br>";
	     	
	     	echo "DROPPED DB" . "<br>" ;
	     	
	     	print_r($response);
	     	
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
	     	echo nl2br ( $lomeJSON );
	     	
	     	
	     		     		     	
	     		     	
	        }

	     
}
?>