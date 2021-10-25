<?php 
class GradedpropertyController extends AppController {
    
    public $helpers = array('Html', 'Form');
	public $components = array('RequestHandler','Session');
	
    public function index() {

        $this->layout = null ;
	
		$serUrl = Configure::read('CONNECT_SER');
			
		$m1 = new MongoClient($serUrl);
		
		// select a database
		$db2 = $m1->properties;
		
		$collection = $m1->$db2->realprop;
        
		$status['gradestatus'] =  array('$gt' => 0);
        $findQuery = $status;
        
        $cursor1 = $collection->find ($findQuery);
        
        $propertyList = array ();
		foreach ( $cursor1 as $result ) {
            array_push ( $propertyList, $result );
		} 
        

echo "<pre>list";
print_r($propertyList);
echo "</pre>";

//die;
        
        $today_year = date('Y');
        $today_month = date('m');
        $today_date = mktime(0,0,0,$today_month,0,$today_year);
        
echo "<br>today date==>".$today_year.'-'.$today_month;        
echo "<br>today date timestamp==>".$today_date ;

        foreach ($propertyList as $property)
        {
            $expiry_date=0;
            
            $propertyId = $property['id'];
    		$prop['id'] =  $propertyId;
            $updatequery = $prop; 
        
            if(isset($property['iprs']['0']) && !empty($property['iprs']['0']))
            {
                $completion_mon = $property['iprs']['0']['Request']['CompletionDate']['Month'];
                $completion_year = $property['iprs']['0']['Request']['CompletionDate']['Year'];
                
                $completion_date =  mktime(0,0,0,$completion_mon,0,$completion_year);
                
echo "<br>completion date===>".$completion_year.'-'.$completion_mon;          
echo "<br>completion date timestamp==>".$completion_date ;
                                
                $expiry_day_rem = $today_date -  $completion_date;                             

echo "<br>expiry days rem====>".$expiry_day_rem;
echo "<br>property id===>".$propertyId;
echo "<pre>update query";
print_r($updatequery);
echo "</pre>";
                if(!$expiry_day_rem)
                {
echo "<br>in if";                    
                    $retval = $collection->findAndModify ( $updatequery, array (
											'$set' => array (
													"gradestatus" => 0,
											)) );
                }                
            }
        }                            
        
        exit;
    }
}
?>