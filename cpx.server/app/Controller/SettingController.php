<?php 
//error_reporting(E_ALL);

class SettingController extends AppController {
    
    public $helpers = array('Html', 'Form');
	public $components = array('Session','RequestHandler');
	
	
    
    
    public function beforeFilter() {
		$logedinuser = $this->Session->read('User');
        $this->checkAdminLogin();
        
        $this->set('logedinuser',$logedinuser);
        parent::beforeFilter();
        
        
		
	}
    
    private function db_conn($properties_conn=false,$users_conn=false,$listing_agents_conn=false,$vendors=false)
    {
        $serUrl = Configure::read('CONNECT_SER');
    			
		$m1 = new MongoClient($serUrl);
		
		// select a database
		$db2 = $m1->properties;
		
        if($properties_conn)
            $collection = $m1->$db2->realprop;
        elseif($users_conn)
            $collection = $m1->$db2->users;
        elseif($listing_agents_conn)
            $collection = $m1->$db2->listing_agents;
        elseif($vendors)
            $collection = $m1->$db2->vendors;
        else
            $collection = $m1->$db2->publishers;
        
        $m1->close();
        
        return $collection;
    }
    
    public function index($page=1,$agent_id='')
    {
        $this->layout = "admin";
        
        $collection = $this->db_conn();
        
		$collection_properties = $this->db_conn(true);
        
        $newquery = array();
        
        $skipdoc = ($page-1)*20;
        
        if(!empty($agent_id))
        {     
            $collection->remove(array('agentID' => $agent_id));
            $collection_properties->remove(array('agentID' => $agent_id));
        }
        
        if(isset($_POST['search']) && !empty($_POST['search']))
        {
            $searchtxt = $_POST['search'];
            
            $publishersQuery = array();
           
            
            $publishersQuery =  array('agentID' => new MongoRegex('/^' .  $searchtxt . '/i'));
            
            $newquery = $publishersQuery;

            $this->set('searchtxt',$searchtxt);
        }
        
//echo "<pre>";
//print_r($newquery);
//echo "</prE>"; 

//die;
        
        
        $countpub = $collection-> count($newquery);

        $noOFPages = 0;
        if($countpub>20)
        {
            $noOFPages =  ceil($countpub/20);
            
        }
        //echo $noOFPages;exit;
        
        $cursor1 = $collection->find ($newquery);
        
		$publisherList = array ();
		foreach ( $cursor1 as $result ) {
		  array_push ( $publisherList, $result );
		} 
        
        $newquery1= array('status' => false);
        $cursor1 = $collection->find ($newquery1);
        
		$deactivatepub = array ();
		foreach ( $cursor1 as $result ) {
		  $deactivatepub[] = $result['agentID'];
		} 
        
        $nq = array('$and'=>array(array('offline'=>false),array('agentID'=>array('$nin'=>$deactivatepub))));

//echo "<prE>";
//print_r($newquery);
//print_r($nq);
//echo "</prE>";
//die;
        
        if(!empty($newquery))
            array_push ( $nq['$and'], $newquery ); 

//echo "<prE>";
//print_r($nq);
//echo "</prE>";
//die;
            
        $total_live_properties = $collection_properties-> count($nq);

//echo "<prE>";
//print_r($statistics);
//echo "</prE>";
//die;        
        
        $newquery1= array();
        $total_publishers = $collection->count ($newquery1);
        
        
        $nq = array('$and'=>array(array('agentID'=>array('$exists' => true))));
        
        if(!empty($newquery))
            array_push ( $nq['$and'], $newquery ); 

//echo "<prE>";
//print_r($nq);
//echo "</prE>";
//die;
            
        $grand_total_properties = $collection_properties-> count($nq);
        
        $db_total_properties = $collection_properties-> count($newquery);
                                    
        $this->set('total_live_properties',$total_live_properties);                            
        $this->set('total_publishers',$total_publishers);
        $this->set('grand_total_properties',$grand_total_properties);
        $this->set('db_total_properties',$db_total_properties);
        
        $cursor1 = $collection->find ($newquery)->sort(array("_id" => -1))->skip($skipdoc)->limit(20);
    
		$publisherList = array ();
		foreach ( $cursor1 as $result ) {
		  array_push ( $publisherList, $result );
		} 
        
        $newquery1 = array();
        $i=0;
        
        foreach($publisherList as $publishers)
        {
            $countprop = 0;
            if(!empty($newquery))
                $nq['$and'] = array($newquery);
            else
                $nq = $newquery;                
            
            $newquery1 = array('agentID' => $publishers['agentID']);
            
            if(isset($nq['$and']) && !empty($nq['$and']))
                array_push($nq['$and'],$newquery1);
            else
                $nq =  $newquery1;
            
            $countprop = $collection_properties-> count($nq);
                                
            $publisherList[$i]['total_properties'] = $countprop;
                        
            $i++;
        }
        
        $this->set('publisherList',$publisherList); 
        $this->set('currentPage',$page);
        $this->set('noOFPages',$noOFPages);
        $this->set('page','publishers');
        
        //echo "<pre>publishers";
//        print_r($publisherList);
//        echo "</pre>";
//        die;


        
    }
    
    function toggleStatus($field,$id,$total_live_properties,$agentID)
    {
        
        if(empty($id))
        {
            echo "0";exit;
        }
        
        $this->layout = "admin";
                
        $collection = $this->db_conn();
        $collection_properties = $this->db_conn(true);
        $collection_vendors = $this->db_conn(false,false,false,true);
        $collection_listing_agents = $this->db_conn(false,false,true);
        
        $DetailsId = $id;
		$xyz['id'] =  $DetailsId;
        $newquery = $xyz; 
        
        $cursor1 = $collection->find ($newquery);
        $pubInfo = array ();
		foreach ( $cursor1 as $result ) {
  		    array_push ( $pubInfo, $result );
		}

        $savedvalue = $pubInfo[0][$field];
        
        switch($field)
        {
            case "status" : $value = (($savedvalue==true)?false:true);break;
        }
        
        $retval = $collection->findAndModify ( $newquery, array (
											'$set' => array (
													$field => $value,
											)
								
									), null, array (
											"sort" => array (
													"priority" => - 1
											),
											"new" => true,
											array ("safe" => true),
												
									) );


		$abc['agentID'] =  $agentID;
        $newquery1 = $abc; 
        
        $propertyvalue = (($value==true)?false:true);
        
        $retval = $collection_properties->update ( $newquery1, array ('$set' => array ('offline' => $propertyvalue,)),array("multiple" => true) );
        
                         
        $newquery1 = array('agentID' => $pubInfo[0]['agentID']);
        $countprop = $collection_properties-> count($newquery1);
        
        if($value == true)
            $total_live_properties = $total_live_properties + $countprop;
        elseif($value == false)
            $total_live_properties = $total_live_properties - $countprop;   
        
        $returnArray=array();
        $returnArray['value'] = $value;
        $returnArray['status'] = true;
        $returnArray['total_live_properties'] = $total_live_properties;      
               
        echo json_encode($returnArray);
        exit;
        
        
    }
    
    // this function is used to add publishers to publishers table fetched from properties
    public function addpublishers($start=0,$end=500,$insert=1)
    {
        $collection_publishers = $this->db_conn();
        
		$collection_properties = $this->db_conn(true);
        
        $collection_users = $this->db_conn(false,true);
        
        $cursor1 = $collection_properties->find ()->skip($start)->limit($end);
       
		$propertyList = array ();
		foreach ( $cursor1 as $result ) {
		  array_push ( $propertyList, $result );
		} 

//echo "<pre>contact";
//print_r($propertyList);
//echo "</pre>";
//die;
        
        foreach($propertyList as $properties)
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
            
            if(!empty($searchQueryArr))
                $foundContact = $collection_publishers->findOne($searchQueryArr);
                  

//echo "<br>publisherid==>".$publisherId;                        
//echo "<pre>count";
//print_r($foundContact);
//echo "</pre>";

//echo "<pre>query";
//print_r($searchQueryArr);
//echo "</pre>";
//die;                        
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
                if($insert)                                    
                    $collection_publishers->insert ( $publisherdata, array ("safe" => true) );
            }
            
        }
        die('done');
    }
    
    public function register_publishers_as_users()
    {
        $collection_publishers = $this->db_conn();
               
        $collection_users = $this->db_conn(false,true);
        
        $cursor1 = $collection_publishers->find ();
       
		$publishersList = array ();
		foreach ( $cursor1 as $result ) {
		  array_push ( $publishersList, $result );
		} 

//echo "<pre>contact";
//print_r($publishersList);
//echo "</pre>";
//die;
        
        foreach($publishersList as $publishers)
        {
            $publisherId = '';
            if(!empty($publishers['agentID']) && filter_var($publishers['agentID'], FILTER_VALIDATE_EMAIL))
            {
                $publisherId = $publishers['agentID'];
            
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
                    
                    $userdata = array();
                    
                    $userdata['id'] = "$nextID";
                    $userdata['username'] = $publishers['agentID'];
                    $userdata['password'] = '';
                    $userdata['firstname'] = '';
                    $userdata['email'] = $publishers['agentID'];
                    $userdata['type'] = 'publisher';
                    $userdata['lastname'] = '';
                    $userdata['phone_number'] = '';
                    $userdata['company_name'] = '';
                    $userdata['status'] = "inactive";
                    $userdata['system_generated_user'] = true;
                    $userdata['verification_token'] = '';
                    $userdata['registration_timestamp'] = '';
    
    //echo "<pre>";
    //print_r($userdata);
    //echo "</pre>";
    //die;
                            
                    $collection_users->insert ( $userdata, array (
            										"safe" => true,"new"=>true, 'upsert'=>true
            								) );
                }
            }
        }
        die('done');
    }
    
     // this function is used to add publishers to publishers table fetched from properties
    public function addlistingagents($start=0,$end=500,$insert=1)
    {
        $collection_listing_agents = $this->db_conn(false,false,true);
        
		$collection_properties = $this->db_conn(true);
        
        $collection_users = $this->db_conn(false,true);
        
        $cursor1 = $collection_properties->find ()->skip($start)->limit($end);
       
		$propertyList = array ();
		foreach ( $cursor1 as $result ) {
		  array_push ( $propertyList, $result );
		} 

//echo "<pre>contact";
//print_r($propertyList);
//echo "</pre>";
//die;
        
        foreach($propertyList as $properties)
        {
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
                        if($insert)                                    
                            $collection_listing_agents->insert ( $listingAgentdata, array ("safe" => true) );
                    }
                }
            }
        }
        die('done');
    }
    
    public function register_listing_agents_as_users()
    {
        $collection_listing_agents = $this->db_conn(false,false,true);
               
        $collection_users = $this->db_conn(false,true);
        
        $cursor1 = $collection_listing_agents->find ();
       
		$listingAgentsList = array ();
		foreach ( $cursor1 as $result ) {
		  array_push ( $listingAgentsList, $result );
		} 

//echo "<pre>contact";
//print_r($listingAgentsList);
//echo "</pre>";
//die;
        
        foreach($listingAgentsList as $listingAgents)
        {
            $listingAgentId = '';
            if(!empty($listingAgents['email']) && filter_var($listingAgents['email'], FILTER_VALIDATE_EMAIL))
            {
                $listingAgentId = $listingAgents['email'];
            
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
                    
                    $userdata = array();
                    
                    $userdata['id'] = "$nextID";
                    $userdata['username'] = $listingAgents['email'];
                    $userdata['password'] = '';
                    $userdata['firstname'] = '';
                    $userdata['email'] = $listingAgents['email'];
                    $userdata['type'] = 'listing agent';
                    $userdata['lastname'] = '';
                    $userdata['phone_number'] = '';
                    $userdata['company_name'] = '';
                    $userdata['status'] = "inactive";
                    $userdata['system_generated_user'] = true;
                    $userdata['verification_token'] = '';
                    $userdata['registration_timestamp'] = '';
                    
                    
                    
                    
    
    
    //echo "<pre>";
    //
    //print_r($userdata);
    //echo "</pre>";
    //die;
                            
                    $collection_users->insert ( $userdata, array (
            										"safe" => true,"new"=>true, 'upsert'=>true
            								) );
                }
            }
        }
        die('done');
    }
    
     // this function is used to add vendors to vendors table fetched from properties
    public function addvendors($start=0,$end=500,$insert=1)
    {
        $collection_vendors = $this->db_conn(false,false,false,true);
        
		$collection_properties = $this->db_conn(true);
        
        $collection_users = $this->db_conn(false,true);
        
        $cursor1 = $collection_properties->find ()->skip($start)->limit($end);
       
		$propertyList = array ();
		foreach ( $cursor1 as $result ) {
		  array_push ( $propertyList, $result );
		} 

//echo "<pre>contact";
//print_r($propertyList);
//echo "</pre>";
//die;
        
        foreach($propertyList as $properties)
        {
            $agentID = $properties['agentID'];
            foreach($properties['contact'] as $contacts)
            {
                if($contacts['type'] == 'vendorDetails')
                {
//echo "<br>agentid==>".$agentID;
//echo "<pre>contact";
//print_r($contacts);
//echo "</pre>";
//die;
                    
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
                        if($insert)                                    
                            $collection_vendors->insert ( $vendordata, array ("safe" => true) );
                    }
                    
                }
            }
        }
        die('done');
    }
    
    public function register_vendors_as_users()
    {
        $collection_vendors = $this->db_conn(false,false,false,true);
               
        $collection_users = $this->db_conn(false,true);
        
        $cursor1 = $collection_vendors->find ();
       
		$vendorsList = array ();
		foreach ( $cursor1 as $result ) {
		  array_push ( $vendorsList, $result );
		} 

//echo "<pre>contact";
//print_r($vendorsList);
//echo "</pre>";
//die;
        
        foreach($vendorsList as $vendors)
        {
            $vendorId = '';
            if(!empty($vendors['email']) && filter_var($vendors['email'], FILTER_VALIDATE_EMAIL))
            {
                $vendorId = $vendors['email'];
            
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
                    
                    $userdata = array();
                    
                    $userdata['id'] = "$nextID";
                    $userdata['username'] = $vendors['email'];
                    $userdata['password'] = '';
                    $userdata['firstname'] = '';
                    $userdata['email'] = $vendors['email'];
                    $userdata['type'] = 'vendor';
                    $userdata['lastname'] = '';
                    $userdata['phone_number'] = '';
                    $userdata['company_name'] = '';
                    $userdata['status'] = "inactive";
                    $userdata['system_generated_user'] = true;
                    $userdata['verification_token'] = '';
                    $userdata['registration_timestamp'] = '';
                    
                    
                    
                    
    
    
    //echo "<pre>";
    //
    //print_r($userdata);
    //echo "</pre>";
    //die;
                            
                    $collection_users->insert ( $userdata, array (
            										"safe" => true,"new"=>true, 'upsert'=>true
            								) );
                }
            }
        }
        die('done');
    }
}
?>