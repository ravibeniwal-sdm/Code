<?php

error_reporting(0);
class SearchController extends AppController {
	
	public $helpers = array('Html', 'Form');
	public $components = array('Session','RequestHandler');
	public $totalCount;
	public $foo = '';
	
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->response->header('Access-Control-Allow-Origin','*');
		$this->response->header('Access-Control-Allow-Methods','*');
		$this->response->header('Access-Control-Allow-Headers','X-Requested-With');
		$this->response->header('Access-Control-Allow-Headers','Content-Type, x-xsrf-token');
		$this->response->header('Access-Control-Max-Age','172800');
	}
	
	public function array_iunique($array) {
		return array_intersect_key(
				$array,
				array_unique(array_map("StrToLower",$array))
		);
	}
	
    public function changePropertyValue($id=null,$field=null,$value=null)
    {
        
        if($id==null)
            exit;
        
        if($value=="true")
        {
            
            $value=true;
        }
        
        $this->layout = null ;
	
		//$serUrl = Configure::read('LOCAL_CONN');
		
		$serUrl = Configure::read('CONNECT_SER');
			
		$m1 = new MongoClient($serUrl);
		
		// select a database
		$db2 = $m1->properties;
		
		$collection = $m1->$db2->realprop;
        
        $DetailsId = $id;
		//array_push($xyz, array('id' => $filterId));
		$xyz['id'] =  $DetailsId;
        $newquery = $xyz;
        
        
        $cursor1 = $collection->find ($newquery);
		
		
		$dhj = array ();
		foreach ( $cursor1 as $result ) {
			 //print_r($result);
		
			array_push ( $dhj, $result );
		
			// $someBSON = bson_decode($result);
			// print_r($dhj);
		}
        
        echo "<pre>";
        
        print_r($dhj);
        
        if($field==null)
            exit;
        
        if($field=="delete")
        {
            $rep = $collection->remove(array('id' => $id));
            echo "<span style='font-size: 45px;color: green;'><b>remove successfully!!!!!</b></span>";   
        }
        else{
        
        
        $retval = $collection->findAndModify ( $newquery, array (
										'$set' => array (
												"$field" => $value
											
										)
								
								), null, array (
										"sort" => array (
												"priority" => - 1
										),
										"new" => true,
										array ("safe" => true),
											
								) );
        
        
        $cursor1 = $collection->find ($newquery);
		
		
		$dhj = array ();
		foreach ( $cursor1 as $result ) {
			 //print_r($result);
		
			array_push ( $dhj, $result );
		
			// $someBSON = bson_decode($result);
			// print_r($dhj);
		}
        
        echo "<pre>";
        
        print_r($dhj);
        
        }
        
        $m1->close();
        exit;
        
        
    }
    
     private function getLocationCondition($collection_loc,$location)
    {
        
        $locationQuery = array("status"=>1);
        $locationQuery['$or'] = array(array("name"=>new MongoRegex('/^' .$location.'$/i')),array("abbreviation"=>new MongoRegex('/^' .$location.'$/i')));
        $cursor_loc = $collection_loc->find ($locationQuery);
        $location_info = array();
		foreach ( $cursor_loc as $result ) {
                $location_info[] = $result;
                
                                               
		} 
        
         
        $locationObj = $location_info;
        $orLocationCondition = array();
                if(isset($locationObj[0]['name']))
                {
                   $orLocationCondition[] = array('address.state' => new MongoRegex('/^' .  $locationObj[0]['name'] . '$/i'));
                   $orLocationCondition[] = array('address.suburb.text' => new MongoRegex('/^' .  $locationObj[0]['name'] . '$/i'));
                    if(isset($locationObj[0]['name']))
                        {
                            $orLocationCondition[] = array('address.state' => new MongoRegex('/^' .  $locationObj[0]['abbreviation'] . '$/i'));
                            $orLocationCondition[] = array('address.suburb.text' => new MongoRegex('/^' .  $locationObj[0]['abbreviation'] . '$/i'));
                            
                        }    
                   
                  
                }else
                {
                     $orLocationCondition[] = array('address.state' => new MongoRegex('/^' .  $location . '$/i'));
                     $orLocationCondition[] = array('address.suburb.text' => new MongoRegex('/^' .  $location . '$/i'));
                }
        
        
        //echo "<pre>"; print_r($location_info); echo "</pre>";exit;
       return $orLocationCondition; 
    }
    
	public function query(){
		
		
		$this->RequestHandler->addInputType('json', array('json_decode', true));
		$data12 = $this->request->data;
		$trace = array();
        $trace['start_tiime'] = date("d M Y h:i:s u");
        
		//print_r($data12);
		
		//echo $data['minprice'];
		
		$this->layout = null ;
	
		//$serUrl = Configure::read('LOCAL_CONN');
		
		$serUrl = Configure::read('CONNECT_SER');
			
		$m1 = new MongoClient($serUrl);
		
		// select a database
		$db2 = $m1->properties;
		
		$collection = $m1->$db2->realprop;
        
        $collection_pub = $m1->$db2->publishers;
        $collection_loc = $m1->$db2->locations;
        		
		$xyz = array();
			
			
			
		if(isset($data12['currentPage']) && !isset($data12['id'])){
		
			$currpage = $data12['currentPage'];
		
		}
			
		if(!isset($data12['currentPage'])){
		
			$currpage = 1;
		
		}

		if(isset($data12['currentPage']) && isset($data12['id'])){
		
			$currpage = 1;
		
		}
		
		if(isset($data12['id'])){
			
			
			$DetailsId = $data12['id'];
			//array_push($xyz, array('id' => $filterId));
			$xyz['id'] =  $DetailsId;
		
			//$id=  array('id' => $filterId);
		}
		
		
		if(isset($data12['doSortByFeatured'])){
				
			$doSortByFeatured = $data12['doSortByFeatured'];
			
		}	
			
		
		
			
		if(isset($data12['grade']) && ($data12['grade'] == '')){
			//$filterGrade = 'current';
			//array_push($xyz, array('id' => $filterId));
			//$xyz['status'] =  $filterGrade;
			
			array( '$or' => array( array($xyz['status'] => array('$ne' => null) ) ) );
			//$id=  array('id' => $filterId);
		}
			
		else if(isset($data12['grade']) && $data12['grade'] == 'Any'){
			//echo "CONDITION MATCHES";
			$filterGrade = 2;
			//array_push($xyz, array('id' => $filterId));
			$xyz['gradestatus'] =  $filterGrade;
		
			//$id=  array('id' => $filterId);
		}
			
		else if(isset($data12['grade']) &&  $data12['grade'] != 'Any' &&  $data12['grade'] != ''){
			$filterGrade = $data12['grade'];
			//array_push($xyz, array('id' => $filterId));
			$xyz['grade'] =  $filterGrade;
		
			//$id=  array('id' => $filterId);
		}
			
			
		
		if(isset($data12['type']) && $data12['type'] != 'Any'){
			$filterType = $data12['type'];
			//array_push($xyz,array('category' => $filtertype));
			$xyz['category'] =  $filterType;
			//$typ =   array('category' => $filtertype);
		}
		
		$xyz['$and'] = array();
		$xyz['$or'] = array();
		
        $deactivatepub = $deactivatepub_email = array();
        
        $deactivatepubquery = array('status' => false);
        $cursor_pub = $collection_pub->find ($deactivatepubquery);
        $deactivatePublisher_info = array();
		foreach ( $cursor_pub as $result ) {
                $deactivatePublisher_info[] = $result;
                
                if(!empty($result['agentID']))
                    $deactivatepub[] = $result['agentID'];
                
                if(!empty($result['email']))
                    $deactivatepub_email[] = $result['email'];                                
		}                      
         
         
        //$deactivatepub = array('0'=>'johnsmithsuperman@outlook.com');
        
              


//echo "<pre>deactivate";
//print_r($deactivatepub);
//print_r($deactivatepub_email);
//echo "</pre>";
//die;
        
        if(isset($deactivatepub) && count($deactivatepub))
        {
            $andSearchText =   array( 'agentID' => array('$nin'=>$deactivatepub));
            array_push($xyz['$and']  , $andSearchText);
        }
        
        if(isset($deactivatepub_email) && count($deactivatepub_email))
        {
            $andSearchText =   array( 'contact.email' => array('$nin'=>$deactivatepub_email));
            array_push($xyz['$and']  , $andSearchText);
        }
        
//echo "<pre>deactivate";
//print_r($andSearchText);
//echo "</pre>";        
//die;   
     
		if( isset($data12['searchtext']) && $data12['searchtext'] !=''){
			
			if (strpos($data12['searchtext'],',') !== false) {
				//echo 'true';
			
		
				list($filterState , $filterSuburb , $filterName) = explode( ',', $data12['searchtext'] );
			
			
				$filterState  = trim($filterState);
				$filterSuburb  =  trim($filterSuburb);
				$filterName  =  trim($filterName);
				
				//echo $filterState . "------" . $filterSuburb;
				
				$max = sizeOf ( $text );
				/* for($i = 0; $i < $max; $i ++) {
				 if(isset($text[$i])){
				 $filterText = $text[$i];
				} */
				
				
			
					if(isset($filterState) && !empty($filterState)){
						//$xyz['address.state'] = $filterState ;
						//$ab = array('$or' => array( array('address.state' => new MongoRegex('/^' .  $filterState . '$/i')), array('address.suburb.text' => new MongoRegex('/^' .  $filterState . '$/i')), array('name' => new MongoRegex('/^' .  $filterState . '$/i')) ) );
                        
                        $ab = $this->getLocationCondition($collection_loc,$filterState);
                        
                        
						array_push($xyz['$and']  , array('$or'=>$ab));
					}
					
					if(isset($filterSuburb) && !empty($filterSuburb)){
							
						//$xyz['address.suburb.text']= $filterSuburb ;
						//$bb =array('$or' =>array( array('address.state' => new MongoRegex('/^' .  $filterSuburb . '$/i')), array('address.suburb.text' => new MongoRegex('/^' .  $filterSuburb . '$/i')), array('aname' => new MongoRegex('/^' .  $filterSuburb . '$/i')) ) );
                        $bb = $this->getLocationCondition($collection_loc,$filterSuburb);
                        
						//array_push($xyz['$and']  , $bb);
                        array_push($xyz['$and']  , array('$or'=>$bb));
					}
					
					if(isset($filterName) && !empty($filterName)){
							
						//$xyz['name'] = $filterName;
						
						//$cb =array('$or' =>array(array('address.state' => new MongoRegex('/^' .  $filterName . '$/i')), array('address.suburb.text' => new MongoRegex('/^' .  $filterName . '$/i')), array('name' => new MongoRegex('/^' .  $filterName . '$/i')) ) );
                        
                        $cb = $this->getLocationCondition($collection_loc,$filterName);
                        
						//array_push($xyz['$and']  , $cb);
                         array_push($xyz['$and']  , array('$or'=>$cb));
					}
					
					
				
					
				//$xyz['$and'] =array( $ab ,$bb ,$cb);
			}
		
		
			
		
		
			//$filterState = $data12['searchtext'];
			//array_push($xyz, array('id' => $filterId));
			//$xyz['address'] =  array('state' => $filterState);
			//$id=  array('id' => $filterId);
			//}
			
			else{
				
				 $filterAddrs = $data12['searchtext'];
			//	exit;
				//echo "here in Else";
				
			//	$orSearchText =  array( '$or' => array( array('address.state' => new MongoRegex('/^' .  $filterAddrs . '$/i')), array('address.suburb.text'=>new MongoRegex('/^' .  $filterAddrs . '$/i')) , array('name'=>new MongoRegex('/^' .  $filterAddrs . '$/i'))));
				        
                $orLocationCondition = $this->getLocationCondition($collection_loc,$filterAddrs);
                //echo "<pre>"; print_r($locationObj); echo "</pre>";exit;
                
                
                
			//	$xyz['$or'] = array( array('address.state' => new MongoRegex('/^' .  $filterAddrs . '$/i')), array('address.suburb.text'=>new MongoRegex('/^' .  $filterAddrs . '$/i')) , array('name'=>new MongoRegex('/^' .  $filterAddrs . '$/i')));
            
                $xyz['$or'] = $orLocationCondition;    
            
				
				//$xyz['$or'] = $orSearchText;
				
				//array_push($xyz , $orSearchText);
				
			}
		}
		
		if(isset($data12['searchid']) && $data12['searchid'] !=''){
			$filterId = $data12['searchid'];
			//array_push($xyz, array('id' => $filterId));
			$xyz_searchID['$or']['id'] =  $filterId;
            $xyz_searchID['$or']['agentID'] =  $filterId;
            $xyz_searchID['$or']['property_id'] =  $filterId;
             
            $orSearchText =  array( '$or' => array( array('contact.email' => new MongoRegex('/^' .  $filterId . '/i')),array('agentID' => new MongoRegex('/^' .  $filterId . '/i')), array('id'=>new MongoRegex('/^' .  $filterId . '/i')), array('property_id'=>new MongoRegex('/^' .  $filterId . '/i'))));
            array_push($xyz['$and']  , $orSearchText);
			//$id=  array('id' => $filterId);
		}
        
		 
        
        
		if(isset($data12['publisher']) && $data12['publisher'] !=''){
			$filterId = $data12['publisher'];
			//array_push($xyz, array('id' => $filterId));
			//$xyz_searchID['$or']['id'] =  $filterId;
            $xyz_searchID['$or']['agentID'] =  $filterId;
            //$xyz_searchID['$or']['property_id'] =  $filterId;
            
            $orSearchText =  array( '$or' => array( array('contact.email' => new MongoRegex('/^' .  $filterId . '/i')),array('agentID' => new MongoRegex('/^' .  $filterId . '/i')), array('id'=>new MongoRegex('/^' .  $filterId . '/i')), array('property_id'=>new MongoRegex('/^' .  $filterId . '/i'))));
            array_push($xyz['$and']  , $orSearchText);
			//$id=  array('id' => $filterId);
		}
		
		
		
		
		
		if(  isset($data12['minprice']) &&  isset($data12['maxprice']) && $data12['minprice'] != '' && $data12['maxprice'] != ''){
			$data12['minprice']= intval($data12['minprice']);
			$filterMinprice = $data12['minprice'];
		
			$data12['maxprice']= intval($data12['maxprice']);
			$filterMaxprice = $data12['maxprice'];
		
			$xyz['cpxprice'] = array('$gte' => $filterMinprice, '$lte' => $filterMaxprice);
		
			//$pricewithin = array('$gt' => $filterminprice, '$lt' => $filtermaxprice);
		}
		
		else if(isset($data12['minprice']) && $data12['minprice'] != ''){
			$data12['minprice']= intval($data12['minprice']);
			$filterMinprice = $data12['minprice'];
		
			$xyz['cpxprice'] = array('$gte' => $filterMinprice);
		
			//$kami = array('$gt' => $filterminprice);
		}
		
		else if(( isset($data12['maxprice']))&& $data12['maxprice'] != ''){
			$data12['maxprice']= intval($data12['maxprice']);
			$filterMaxprice = $data12['maxprice'];
		
			$xyz['cpxprice'] =  array('$lte' => $filterMaxprice);
			//$jast =   array('$lt' => $filtermaxprice);
		}
		
		if( isset($data12['minbeds']) && isset($data12['maxbeds']) && $data12['minbeds'] != 'Any' && $data12['maxbeds'] != 'Any'){
			//$data12['minbeds']= intval($data12['minbeds']);
			$filterMinbeds = $data12['minbeds'];
		
			//$data12['maxbeds']= intval($data12['maxbeds']);
			$filterMaxbeds = $data12['maxbeds'];
		
			$xyz['beds'] = array('$gte' => $filterMinbeds, '$lte' => $filterMaxbeds);
		
			//$bedswithin = array('$gt' => $filterminbeds, '$lt' => $filtermaxbeds);
		}
		
		else if(( isset($data12['minbeds'])) && $data12['minbeds'] != 'Any'){
			//$data12['minbeds']= intval($data12['minbeds']);
			$filterMinbeds = $data12['minbeds'];
		
			$xyz['beds'] = array('$gte' => $filterMinbeds);
		
			//$kami = array('$gt' => $filterminbeds);
		}
		
		else if(( isset($data12['maxbeds']))&& $data12['maxbeds'] != 'Any' ){
			//$data12['maxbeds']= intval($data12['maxbeds']);
			$filterMaxbeds = $data12['maxbeds'];
		
			$xyz['beds'] =  array('$lte' => $filterMaxbeds);
			//$jast =   array('$lt' => $filtermaxbeds);
		}
		
		
		if(  isset($data12['repaypricerange']) && $data12['repaypricerange'][0] != null && $data12['repaypricerange'][0] != '' && $data12['repaypricerange'][0] != 0){
			
			$maxpricefromrepayIO = intval($data12['repaypricerange'][0]);
			
			$minpricefromrepayIO= intval($data12['repaypricerange'][2]);
			
			$maxpricefromrepayPI= intval($data12['repaypricerange'][1]);
				
			$minpricefromrepayPI= intval($data12['repaypricerange'][3]);
			
			$newQ2 = array('$or' => array(array("cpxprice" => array('$gte' => $minpricefromrepayIO, '$lte' => $maxpricefromrepayIO)),array( "cpxprice" => array('$gte' => $minpricefromrepayPI, '$lte' => $maxpricefromrepayPI))));
			
			//array_push($xyz['$or']  , $newQ2);
			
			if(!empty($orSearchText)){
				//echo "djdj" ;
				
				array_push($xyz['$and']  , $newQ2);
				array_push($xyz['$and']  , $orSearchText);
				unset($xyz['$or']);
			}
			else{
				$xyz['$or'] = array(array("cpxprice" => array('$gte' => $minpricefromrepayIO, '$lte' => $maxpricefromrepayIO)),array( "cpxprice" => array('$gte' => $minpricefromrepayPI, '$lte' => $maxpricefromrepayPI)));
			}
			
			//$xyz['$or'] = array(array("cpxprice" => array('$gte' => $minpricefromrepayIO, '$lte' => $maxpricefromrepayIO)),array( "cpxprice" => array('$gte' => $minpricefromrepayPI, '$lte' => $maxpricefromrepayPI)));
			
		}
		
		
		if( isset($data12['left']) && $data12['left']==true ){
			$filterSmsf = $data12['left'];
			$xyz['smsf'] =  $filterSmsf;
		
		}
		
        if(isset($data12['domacom']) && $data12['domacom']==true ){
			$filterDomacom = $data12['domacom'];
			$xyz['domacom'] =  $filterDomacom;
		
		}
        
		if(isset($data12['saving']) && $data12['saving']==true ){
			$filterSaving = array('$gt' => '0');
			$xyz['saving'] =  $filterSaving;
		}
        
        if(isset($data12['vendorfinance']) && $data12['vendorfinance']==true ){
			$filterVendorfinance = true;
			$xyz['vendorfinance'] =  $filterVendorfinance;
		
		}
        
		if( isset($data12['sold']) && $data12['sold']==true){
			$filterSold = true;
			$xyz['sold'] =  $filterSold;
		
		}
		if( isset($data12['underoffer']) && $data12['underoffer']==true){
			$filterUnderOffer = 'yes';
			$xyz['deposit'] =  $filterUnderOffer;
		
		}
		
        if( isset($data12['homeland']) && $data12['homeland']==true){
			$filterhomeland = 'yes';
			$xyz['homelandpackage'] =  $filterhomeland;
		
		}
        
        if( isset($data12['newprop']) && $data12['newprop']==true){
			//$filternewprop = 'yes';
//			$xyz['newConstruction'] =  $filternewprop;
            
            
            $filternewprop =array('$or' => array(array('newConstruction' => 'yes'),array( 'newConstruction' => true)));
            
            $filternewprop = array('newConstruction' => 'yes');
            $filternewprop1 = array('newConstruction' => true);
                                                                            
			$xyz['$or'] =  array($filternewprop,$filternewprop1);
            
		}
        
        
        if( isset($data12['established']) && $data12['established']==true){
            
            
            //$orSearchText =  array( '$and' => array( array('newConstruction' => array('$ne'=>"1")),array('homelandpackage' => array('$ne'=>"yes"))));
//            array_push($xyz['$and']  , $orSearchText);
          
            $filterestablished = 'yes';
			$xyz['established'] =  $filterestablished;          
            
       }     
        
        
		$xyz['offline'] =  false;
		
		
		
		
		/* if(isset($startTime) && isset($endTime)) {
		 // Add the timestamp array
		 $qry['timestamp'] = array('$gt' => $startTime, '$lt' => $endTime);
		 } */
		
		
        $noAgentCondition =  array( '$nor' =>array( array('agentID'=>array('$exists' => false)),array('agentID'=>array('$size' => 0))));
        
        
        array_push($xyz['$and']  , $noAgentCondition);
        
		if( (isset($deactivatepub) && count(isset($deactivatepub))) || (isset($xyz['gradestatus'])) || (isset($xyz['status'])) || (isset($xyz['grade'])) || ( isset($data12['id'])) || (( isset($data12['type'])) && ($data12['type'] !='Any')) || ( isset($data12['searchid'])) || ( isset($data12['searchtext'])) || ( isset($data12['minprice'])) || ( isset($data12['maxprice'])) || (( isset($data12['minbeds'])) && ($data12['minbeds'] !='Any')) || (( isset($data12['maxbeds'])) && ($data12['maxbeds'] !='Any')) || ($data12['left']==true) || ( $data12['domacom']==true) || ( $data12['underoffer']==true) || ( $data12['sold']==true) || ( $data12['homeland']==true) || ( $data12['saving']==true)|| ( $data12['vendorfinance']==true) || ( $data12['newprop']==true) || ($data12['repaypricerange'][0] != null && $data12['repaypricerange'][0] != '') )
		{
    		if(empty($xyz['$or'])){
    			unset($xyz['$or']);
    		}
    		if(empty($xyz['$and'])){
    			unset($xyz['$and']);
    		}
			//$newquery = array("id" => "4931",'cpxprice' => array('$lt' => 400000,'$gt' => 300000)) ;
		
			/* $newquery  = array( '$or' =>
					
			array(
		
			array( '$or' =>
			array (
			array("id" => $data12['searchid']) , array("id" => '' )
		
			)
			),
		
			array( '$or' =>
			array (
		
			array('cpxprice' => array('$lt' => $data12['maxprice'],'$gt' => $data12['minprice'])),
		
			)
			),
		
			array( '$or' =>
			array (
		
			array("category" => 'Townhouse')
		
			)
			),
			)
			); */
		
		      
		
			$newquery = $xyz;
		  
			//print_r($newquery);
		
		}else{	
		
			//echo "in else";
		    $newquery = $xyz;
              
			//$newquery = array ('offline' => false);
            
            
		
		}
		
        
        
		/* $propertyids = array ();
		foreach ( $collection->find ($newquery) as $result ) {
			// print_r($result);
				
			array_push ( $propertyids, $result['id']);
				
			// $someBSON = bson_decode($result);
			// print_r($dhj);
		} */
		
		
		
		
		//print_r($propertyids);die;
		
		$limitdoc = 18;
		$skipdoc = ($currpage - 1)* $limitdoc;
		//echo $skipdoc;
		//echo "SKIP:" . $skipdoc . "LIMIT:" . $limitdoc;
		
		/* my_id = coll.find()[20]['_id']
		coll.find({ '_id': {'$lt': my_id}}).sort([('_id', -1)]).limit(3)  # before
		coll.find({ '_id': {'$gt': my_id}}).sort('_id').limit(3)  # after */
		
		
		//print_r($propertyids2);die;
		
		$dhj = array ();
		
		$featured = array('featured_timestamp' => -1, 'modifiedon'=>-1) ;
		
		if(isset($data12['sortOptionVal']) && $data12['sortOptionVal'] == '1'){
			$featured = array('featured_timestamp' => -1, 'modifiedon'=>-1) ;
		}
		else if(isset($data12['sortOptionVal']) && $data12['sortOptionVal'] == '2'){
			$featured = array('beds' => -1,'featured_timestamp' => -1, 'modifiedon'=>-1) ;
		}
		else if(isset($data12['sortOptionVal']) && $data12['sortOptionVal'] == '3'){
			$featured = array('beds' => 1,'featured_timestamp' => -1, 'modifiedon'=>-1) ;
		}
		else if(isset($data12['sortOptionVal']) && $data12['sortOptionVal'] == '4'){
			$featured = array('cpxprice' => -1,'featured_timestamp' => -1, 'modifiedon'=>-1) ;
		}
		else if(isset($data12['sortOptionVal']) && $data12['sortOptionVal'] == '5'){
			$featured = array('cpxprice' => 1,'featured_timestamp' => -1, 'modifiedon'=>-1) ;
		}
		else if(isset($data12['sortOptionVal']) && $data12['sortOptionVal'] == '6'){
			$featured = array('score' => 1,'featured_timestamp' => -1, 'modifiedon'=>-1) ;
		}
		else if(isset($data12['sortOptionVal']) && $data12['sortOptionVal'] == '7'){
			$featured = array('score' => -1,'featured_timestamp' => -1, 'modifiedon'=>-1) ;
		}
		
		
//echo "<pre>newquery";
//print_r($newquery);
//echo "</pre>";
//
//echo "<pre>xyz";
//print_r($xyz);
//echo "</pre>";
		$trace['before_count'] = date("d M Y h:i:s u");
		//$totalCount =  $collection-> count($newquery);
		$countprop = $collection-> count($newquery);
		$this ->totalCount = $collection-> count($newquery);
		$this ->totalCategories = $this->array_iunique($collection -> distinct('category'));
        $trace['after_cat'] = date("d M Y h:i:s u");
		
		///////////////////NEW IMPL////////////////////////
		
		$newqueryArrayObject = new ArrayObject ( $newquery );
		$nextquery = $newqueryArrayObject->getArrayCopy ();
		
		unset($nextquery['id']);
		
		if(isset($data12['getonlyfeatured']['val']) && $data12['getonlyfeatured']['val'] == true){
			$nextquery['featured'] = true;
		}
		
		
        if(isset($data12['id']))
        {
        
		$propertyids2 = array ();
		if(isset($data12['getonlyfeatured']['val']) && $data12['getonlyfeatured']['val'] == false  && $data12['getonlyfeatured']['from'] == 'home'){
			foreach ( $collection->find ($nextquery)->sort(array('modifiedon'=>-1)) as $result ) {
				array_push ( $propertyids2, $result['id']);
			}
            
            $keyl = array_search($data12['id'], $propertyids2);
            $nextprop = $propertyids2[$keyl + 1];
		    $prevprop = $propertyids2[$keyl - 1];
            
		}
		else if(isset($data12['shorlistedPropertyids']) && isset($data12['shorlistedPropertyStatus']) && !empty( $data12['shorlistedPropertyids'] ) && $data12['shorlistedPropertyStatus'] == 1){
			$propertyids2 = $data12['shorlistedPropertyids'];
            $keyl = array_search($data12['id'], $propertyids2);
            $nextprop = $propertyids2[$keyl + 1];
		    $prevprop = $propertyids2[$keyl - 1];
		}
		else{
		  $trace['before_for'] = date("d M Y h:i:s u");
          
          $nextId = null;
          $prevId = null;
          $found = false;
           foreach ( $collection->find ($nextquery)->sort(array('featured_timestamp' => -1, 'modifiedon'=>-1)) as $result )  {
            
                if($found)
                {
                    $nextId = $result['id'];
                    break;
                }
                if($data12['id']==$result['id'])
                {
                    $found = true;
                }
                if(!$found)
                {
                    $prevId = $result['id'];
                }
		
			}	
         
          $nextprop = $nextId;
		  $prevprop = $prevId;
		
        /*	foreach ( $collection->find ($nextquery)->sort(array('featured' => -1, 'modifiedon'=>-1)) as $result ) {
				array_push ( $propertyids2, $result['id']);
			}
            
         */   	
           $trace['after_for'] = date("d M Y h:i:s u"); 
		}
		//print_r($propertyids2);
		
		
		//echo $keyl;
		
		
        
        }
		
		/* echo "NEXT : ".$nextprop."<br>";
		echo "PREV : ".$prevprop."<br>"; */
		
		///////////////////////////////////////////////////

//echo "<pre>newquery";
//print_r($newquery);
//echo "</pre>";
		
		//$cursor1 = $collection->find ($newquery)->skip($skipdoc)->limit($limitdoc);
		 $trace['before_find'] = date("d M Y h:i:s u");
         $checkPreview = explode("_",@$xyz['id']);
         
         if(isset($xyz['id']) && !empty($xyz['id']) && $checkPreview[0]=="preview" )
         {
            
            // echo "in if".$xyz['id'].$this->Session->read('Preview1').$this->Session->read('Preview');
            //$data_to_preview = $this->Session->read('Preview');
            
            // echo "<pre> before data"; print_r($data_to_preview); exit;
            // $cursor1 = array("0"=>$data_to_preview);
            //$cursor1 = array();
            //$cursor1[] =  $data_to_preview;
            $newquery2 = array();
            $newquery2['id'] = $checkPreview[1];
            $collection_preview = $m1->$db2->realprop_preview;
            
            $cursor1 = $collection_preview->find ($newquery2)->sort($featured)->skip($skipdoc)->limit($limitdoc);
             
            
            // echo "<pre>"; print_r($cursor1); exit;
         
         }
         else
         {
            
            $cursor1 = $collection->find ($newquery)->sort($featured)->skip($skipdoc)->limit($limitdoc);
         }
        
		$trace['after_find'] = date("d M Y h:i:s u");
		
		//$cursor1 = $collection->find ($newquery)->limit(10);
		//$cursor1->limit(10);
		//$cursor1->skip(10)->limit(10);
        $i=0;
		foreach ( $cursor1 as $result ) {
			
		
			array_push ( $dhj, $result );
           
            
            if(isset($xyz['id']) && !empty($xyz['id']))
            {
                
                if(isset($dhj[0]['iprs']) && !empty($dhj[0]['iprs']))
                {
                    // echo "<pre>"; print_r($dhj[0]['iprs']); echo "</pre>";
                    foreach($dhj[0]['iprs'] as &$ipr)
                    {   
                        // echo "<pre>"; print_r($ipr); echo "</pre>";
                        $ipr = (array)$ipr;
                        if(!empty($ipr['publishedAt'])) 
                            {
                                $today_date = date('Y/m/d h:m');

                                        $tmp_datetime = explode('T', $ipr['publishedAt']);
                                    
                                        $tmp_date = explode('-',$tmp_datetime['0']);
                                        
                                        $published_date = $tmp_date['0'].'/'.$tmp_date['1'].'/'.$tmp_date['2'].' '.$tmp_datetime['1'];
                        
                                        $startTimeStamp = strtotime($today_date);
                                        $endTimeStamp = strtotime($published_date);
                                        
                                        $timeDiff = abs($endTimeStamp - $startTimeStamp);
                                        
                                        $numberDays = $timeDiff/86400;  // 86400 seconds in one day
                                        
                                        // and you might want to convert to integer
                                        $numberDays = intval($numberDays); 
                                        $ipr['numberof_days_old'] = $numberDays;
                                        //echo $numberDays; 
                            }
                    }        
                }
                
                
               // echo "<pre>"; print_r($dhj); echo "</pre>"; 
                
            }
            $dhj[$i]['sponsors'] = array();
            $sponsors = &$dhj[$i]['sponsors'];
                
            $sponsors = $this->defaultSponsors($dhj[$i]['address'][0]);
            $i++;
            
            
           // exit;
		
			// $someBSON = bson_decode($result);
			// print_r($dhj);
		}
		$trace['after_process'] = date("d M Y h:i:s u");
		
		/* $date1 = $dhj[0]['modifiedon'];
		
		//coll.find({ '_id': {'$lt': my_id}}).sort([('_id', -1)]).limit(3) # before
		//coll.find({ '_id': {'$gt': my_id}}).sort('_id').limit(3)  # after 
		
		
		//$findNextPropId = array('modifiedon' => array('$lt'=>$date1));
		
		$newqueryArrayObject = new ArrayObject ( $newquery );
		$nextquery = $newqueryArrayObject->getArrayCopy ();
		
		unset($nextquery['id']);
		//print_r($nextquery);
		
		$nextquery['modifiedon'] = array( '$lt' => $date1);
		//array_push($nextquery,$findNextPropId);
		
		//print_r($nextquery);
		if(isset($data12['getonlyfeatured']) && $data12['getonlyfeatured'] == true){
			$nextquery['featured'] = true;
		}
		else{}
		
		$sortBymongoId = array('modifiedon'=>-1,'featured' => -1)  ;
		
		
		
		
		$cursornext = $collection->find ()->sort($sortBymongoId);
		
		$nextprop = array();
		
		foreach ( $cursornext as $resultnextprop ) {
			// print_r($result);
		
			array_push ( $nextprop, $resultnextprop['id'] );
			
			// $someBSON = bson_decode($result);
			
		}
		//print_r($nextprop);
		
		$newqueryArrayObject = new ArrayObject ( $newquery );
		$previousquery = $newqueryArrayObject->getArrayCopy ();
		
		unset($previousquery['id']);
		//print_r($previousquery);
		
		$previousquery['modifiedon'] = array( '$gt' => $date1);
		//array_push($nextquery,$findNextPropId);
		
		if(isset($data12['getonlyfeatured']) && $data12['getonlyfeatured'] == true){
			$previousquery['featured'] = true;
		}
		else{}
		
		
		$sortBymongoId1 = array('modifiedon'=>1,'featured' => 1)  ;
		
		
		
		$cursorprevious =  $collection->find ()->sort($sortBymongoId1);
		
		$previousprop = array();
		
		foreach ( $cursorprevious as $resultnextprop1 ) {
			// print_r($result);
		
			array_push ( $previousprop, $resultnextprop1['id'] );
		
			// $someBSON = bson_decode($result);
				
		}
		//echo "<br>";
		//print_r($previousprop);die; 
		*/
		
		
		//$newarray ["deactivated_publisher"] = $deactivatePublisher_info;
	       $default_sponsors = $this->defaultSponsors(array());
        
		$newarray ["properties"] = $dhj;
        $newarray ["default_sponsors"] = $default_sponsors;
		$newarray ["count"] = $this ->totalCount;
		$newarray ["categories"] = $this ->totalCategories;
		$newarray ["currentPageFromSearch"] = $currpage;
		/* $newarray ["prpertyIds"] = $propertyids ; */
		//if(isset($data12['id'])){
			$newarray ["Query"] = $newquery ;
			$newarray ["DATA"] = $data12 ;
			$newarray["nextquery"] = $nextquery;
			if(isset($data12['id']))
                {
                    $newarray ["nextpropIds"] = $nextprop ;
        			$newarray ["previouspropIds"] = $prevprop ;
                 }   
			
		//}
        
//echo "<pre>resu";
//print_r($newarray);
//echo "</pre>";
        
		// print_r($newarray);
		//$lomeJSON = json_encode ( $newarray, JSON_PRETTY_PRINT );
		$trace['at_end'] = date("d M Y h:i:s u");
        $newarray['trace'] =  $trace;
        $lomeJSON = json_encode ( $newarray);
		$newarray = array();
		$newarray[0] = $lomeJSON;
		$newarray[1] = $collection-> count($newquery);
		$newarray[2] = $this ->totalCategories;
        
		$m1->close();
		//print_r($newarray);
		return $newarray;
	}
	
    public function defaultSponsors($address)
    {
        
        $sponsors = array();
        
        $serUrl = Configure::read('CONNECT_SER');
			
		$m1 = new MongoClient($serUrl);
		
		// select a database
		$db2 = $m1->properties;
		
        $collection_spn = $m1->$db2->sponsors;
        
        $sponsorQuery = array("status"=>1,"default"=>1);
        $cursor_spn = $collection_spn->find ($sponsorQuery);
        $default_spns = array();
		foreach ( $cursor_spn as $result ) {
                $default_spns[$result['loan_type']] = $result;
                          
		} 
        
        if(!isset($address['state']))
        {
            return $default_spns;
        }
        
        
        $collection_loc = $m1->$db2->locations;
        $location_info = array();
        
              
        $location = $address['state'];
        $locationQuery = array("status"=>1);
        $locationQuery['$or'] = array(array("name"=>new MongoRegex('/^' .$location.'$/i')),array("abbreviation"=>new MongoRegex('/^' .$location.'$/i')));
        $cursor_loc = $collection_loc->find ($locationQuery);
        
		foreach ( $cursor_loc as $result ) {
                $location_info[] = $result;
        } 
        
        if(isset($location_info['0']['sponsors']['PI']['id']))
        {
            $sponsors['PI'] = $this->getLocationInfo($location_info['0']['sponsors']['PI']['id'],$default_spns['PI'],$collection_spn);
        }else
        {
            $sponsors['PI'] = $default_spns['PI'];
        }
        
        if(isset($location_info['0']['sponsors']['IO']['id']))
        {
            $sponsors['IO'] = $this->getLocationInfo($location_info['0']['sponsors']['IO']['id'],$default_spns['IO'],$collection_spn);
        }else
        {
            $sponsors['IO'] = $default_spns['IO'];
        }
        
        //$m1->close();
        return (array)$sponsors;
       // echo "<pre>"; print_r($sponsors);exit;
        
        
    }
    function getLocationInfo($id,$default,$collection_spn)
    {
        $sponsorQuery = array("status"=>1,"id"=>$id);
        
        $cursor_spn = $collection_spn->find ($sponsorQuery);
        $sponsor_info = array();
		foreach ( $cursor_spn as $result ) {
                $sponsor_info = $result;
        }
        if(isset($sponsor_info['id']))
        {
            return (array) $sponsor_info;
        }else
        {
          return (array) $default;  
        }
         
    }
    
    
    
    
	
	function render_json($fhf){
		$this->set('data', $fhf);
		$this->render('../Elements/ajaxreturn');
		
	}
	
	
	public function index() {
		
		/* echo "URL PARAMS ===";
		print_r($this->params['url']);echo "<br><br>"; */
		//echo $this ->totalCount;
		
		//$this->set('totalCount', $collection-> count($newquery));
		
		//$this ->totalCount = $this->data;
		
		$propertiesData = $this->query();
		
		$lomeJSON = $propertiesData;
		

		//echo nl2br ( $lomeJSON );
		
	
		
	$this->render_json($lomeJSON);
		
	
		//return $this->totalCount;
		
		
	}
	
    public function fetchEndorsements()
    {
        $serUrl = Configure::read('CONNECT_SER');
			
		$m1 = new MongoClient($serUrl);
		
		// select a database
		$db2 = $m1->properties;
		
		$collection = $m1->$db2->endorsements;
        
        $newquery = array('status'=>1);
        
        $cursor1 = $collection->find ($newquery)->sort(array('order'=>1));
        
		$endorsementsList = array ();
		foreach ( $cursor1 as $result ) {
		  array_push ( $endorsementsList, $result );
		} 

//echo "<pre>endorsements";
//print_r($endorsementsList);
//echo "</pre>";
//die;
        
        $this->layout = null ;
        
        $newarray ["endorsements"] = $endorsementsList;
        $lomeJSON = json_encode ( $newarray);
		$newarray = array();
		$newarray[0] = $lomeJSON;
        $this->render_json($newarray);  
        
        $m1->close();      
    }
    
    
 /* public function searchquery(){

 	$this->layout = null ;

 	$propertiesCount = $this->query();
 	
 	
 	
 	$proCount =  $propertiesCount[1];
 	
 	$romeJSON = json_encode ( $propertiesCount, JSON_PRETTY_PRINT );
 	echo nl2br ( $romeJSON );
 	
 	$this->set('data1', $propertiesCount);
	$this->render('../Elements/ajaxreturn2');
 	
 	print_r($proCount);
 	$this -> index();
 	
 	 $m1 = new MongoClient($serUrl);
 	
 	 select a database
 	$db2 = $m1->properties;
 	
 	$collection = $m1->$db2->realprop;
 	
 	
 	$totalCount = $collection-> count();
 	
 	echo $totalCount; 
 	
 	
	print_r($data);
	
	echo $data['minprice'];
	}  */
	
    public function checkSession()
    {
        $data_to_preview = $this->Session->read('Preview');
        
        echo "<pre>data===>";
        print_r($data_to_preview);
        echo "</pre>";
        die('done');      
    }	
	
}
?> 