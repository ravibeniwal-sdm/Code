<?php 
//error_reporting(E_ALL);

class LocationsController extends AppController {
    
    public $helpers = array('Html', 'Form');
	public $components = array('Session','RequestHandler');
	
	
    
    
    public function beforeFilter() {
        $logedinuser = $this->Session->read('User');
       
        $allowAction = array("fetchLocations");
        if(!in_array($this->action,$allowAction))    
            $this->checkAdminLogin();
        
        $this->set('logedinuser',$logedinuser);
        parent::beforeFilter();
	}
    
    private function db_conn()
    {
        $serUrl = Configure::read('CONNECT_SER');
    			
		$m1 = new MongoClient($serUrl);
		
		// select a database
		$db2 = $m1->properties;
		
        $collection = $m1->$db2->locations;
        
        $m1->close();     
        
        return $collection;
    }
    
    private function fetchSponsors($query)
    {
        $serUrl = Configure::read('CONNECT_SER');
    			
		$m1 = new MongoClient($serUrl);
		
		// select a database
		$db2 = $m1->properties;
		
        $collection = $m1->$db2->sponsors;
        
        $cursor1 = $collection->find ($query)->sort(array('id'=>1));
        
		$sponsorsList = array ();
		foreach ( $cursor1 as $result ) {
		  $logoPath = "";
          if(isset($result['logo']['0']['path']))
          {
            $logoPath =IMAGE_UPLOAD_PATH.$result['logo']['0']['path'];
          }
		  $r = array("value"=>$result['sponsor_name'],"name"=>$result['sponsor_name'],"id"=>$result['id'],"logo"=>$logoPath,"url"=>$result['url']);
    		  array_push ( $sponsorsList, $r );
		} 
        
        $m1->close();     
        return $sponsorsList;                        
        
    }
    
    
    public function fetchPIsponsors()
    {
        
        $newquery = array("loan_type"=>"PI","status"=>1,"sponsor_name"=>new MongoRegex('/^' .  $this->request->query['term'] . '/i'));
        
        $sponsorsList = $this->fetchSponsors($newquery);      
        
        echo json_encode($sponsorsList);exit;
        
    }
    
    public function fetchIOsponsors()
    {
        
        
        $newquery = array("loan_type"=>"IO","status"=>1,"sponsor_name"=>new MongoRegex('/^' .  $this->request->query['term'] . '/i'));
        
        
       $sponsorsList = $this->fetchSponsors($newquery);
        
        echo json_encode($sponsorsList);exit;
        
    }
    
    public function index($page=1,$id='')
    {
        $this->layout = "admin";
        
        $collection = $this->db_conn();
        
        $newquery = array();
        
        $skipdoc = ($page-1)*20;
        
        if(!empty($id))
        {     
            $collection->remove(array('id' => $id));
        }
        
        $countrec = $collection-> count($newquery);

        $noOFPages = 0;
        if($countrec>20)
        {
            $noOFPages =  ceil($countrec/20);
            
        }
        //echo $noOFPages;exit;
        
        $cursor1 = $collection->find ($newquery)->sort(array('order'=>1));
        
		$locationsList = array ();
		foreach ( $cursor1 as $result ) {
		  array_push ( $locationsList, $result );
		} 
        
        $total_locations = $active_locations = 0;
        
        $newquery1 = array('status' => 1);
        $active_locations = $collection-> count($newquery1);


                
        $this->set('locationsList',$locationsList); 
        $this->set('active_locations',$active_locations);
        $this->set('total_locations',$countrec);
        $this->set('currentPage',$page);
        $this->set('noOFPages',$noOFPages);
        $this->set('page','locations');
        
        //echo "<pre>locations";
//        print_r($locationsList);
//        echo "</pre>";
//        die;


        
    }
    
    function adddefaultLocation()
    {
            $collection = $this->db_conn();
            $locationdata['type'] =  "country";
            $locationdata['name'] =  "Australia";
            $locationdata['abbreviation'] =  "AU";
            $locationdata['status'] =  1;
             
            

            $locationdata['id'] = "1";
           // $locationdata['order'] = "$order";

//echo "<pre>locations";
//print_r($locationdata);
//echo "</pre>";
//die;

            $res = $collection->insert ( $locationdata, array ("safe" => true) );
    }
    
    
    function add()
    {
        $this->layout = 'admin' ; 
        $collection = $this->db_conn();

        if(!empty($this->data))
        {
//echo "<pre>locations";
//print_r($this->data);
//echo "</pre>";
//die;
            
            $locationdata = array();
            
                        
            $locationdata['type'] =  $this->data['type'];
            if($locationdata['type']=="suburb")
            {
                $locationdata['region'] =  $this->data['region'];
                $locationdata['region_abbreviation'] =  $this->data['region_abbreviation'];
            }else
            {
                $locationdata['region'] =  "";
                $locationdata['region_abbreviation'] =  "";
            }
            $locationdata['name'] =  $this->data['name'];
            $locationdata['abbreviation'] =  $this->data['abbreviation'];
            $locationdata['status'] =  1;
             
            $foundLastRecord = $collection->find()->sort(array("_id" => -1))->limit(1);
            $lastRecordArr = array ();
            foreach ( $foundLastRecord as $result ) {
                array_push ( $lastRecordArr, $result );
            } 

            if(!empty($lastRecordArr))
                $order = $nextID = $lastRecordArr['0']['id']+1;
            else
                $order = $nextID = 1;

            $locationdata['id'] = "$nextID";
           // $locationdata['order'] = "$order";

//echo "<pre>locations";
//print_r($locationdata);
//echo "</pre>";
//die;

            $res = $collection->insert ( $locationdata, array ("safe" => true) );
            
            if($res)
                $this->set('success_msg','New location added successfully');
            else
                $this->set('error_msg','Failed to add new location'); 
        }
        $newquery = array("type"=>"region");
        
        $cursor1 = $collection->find ($newquery)->sort(array('order'=>1));
            
    		$locationsList = array ();
    		foreach ( $cursor1 as $result ) {
    		  $r = array("value"=>$result['name'],"data"=>$result['abbreviation']);
    		  array_push ( $locationsList, $r );
    		} 
        
        $this->set('locationsList',$locationsList);
        $this->set('page','locations');
    }
    
    function edit($id,$page='1')
    {
        $this->layout = 'admin' ; 
        $collection = $this->db_conn();


        if(!empty($this->data))
        {
          
            $locationdata = array();
            
            if($id==1)
            {
            $locationdata['type'] =  "country";    
            }else
            {
            $locationdata['type'] =  $this->data['type'];    
            }             
            
            if($locationdata['type']=="suburb")
            {
                $locationdata['region'] =  $this->data['region'];
                $locationdata['region_abbreviation'] =  $this->data['region_abbreviation'];
            }else
            {
                $locationdata['region'] =  "";
                $locationdata['region_abbreviation'] =  "";
            }
            $sponsors =array();
            if(isset($this->data['PI_sponsor_id']))
            {
                 $sponsors['PI']['id'] = $this->data['PI_sponsor_id'];
                 $sponsors['PI']['name'] = $this->data['PI_sponsor'];
            }
            
            if(isset($this->data['IO_sponsor_id']))
            {
                 $sponsors['IO']['id'] = $this->data['IO_sponsor_id'];
                 $sponsors['IO']['name'] = $this->data['IO_sponsor'];
            }
           
            
            if(count($sponsors))
            {
                $locationdata['sponsors'] =  $sponsors;
            }
            
            $locationdata['name'] =  $this->data['name'];
            $locationdata['abbreviation'] =  $this->data['abbreviation'];
            $DetailsId = $id;
    		$xyz['id'] =  $DetailsId;
            $newquery = $xyz; 

            $retval = $collection->findAndModify ( $newquery, array (
											'$set' => $locationdata
								
									), null, array (
											"sort" => array (
													"priority" => - 1
											),
											"new" => true,
											array ("safe" => true),
												
									) );
            
            if($retval)
                $this->set('success_msg','location edited successfully');
            else
                $this->set('error_msg','Failed to edit location'); 
        }
        
        if(empty($id))
            $this->redirect("/locations/");
        
        $newquery = array('id' =>  $id);
        
        $cursor1 = $collection->find ($newquery);
    
		$locationsEdit = array ();
		foreach ( $cursor1 as $result ) {
		  array_push ( $locationsEdit, $result );
		}  
        
        if(!empty($locationsEdit['0']['sponsors']['PI']['id']))
        {
            $newquery = array("id"=>$locationsEdit['0']['sponsors']['PI']['id']);
            //$newquery = array("id"=>1);            
            $PISponsor = $this->fetchSponsors($newquery);
            //echo "<pre>";print_r($PISponsor);echo "</pre>";                        
            $locationsEdit['0']['sponsors']['PI'] = $PISponsor[0];       
        }  
        if(!empty($locationsEdit['0']['sponsors']['IO']['id']))
        {
            $newquery = array("id"=>$locationsEdit['0']['sponsors']['IO']['id']);
            //$newquery = array("id"=>1);            
            $PISponsor = $this->fetchSponsors($newquery);
            //echo "<pre>";print_r($PISponsor);echo "</pre>";                        
            $locationsEdit['0']['sponsors']['IO'] = $PISponsor[0];       
        }         
                                                             //
       // echo "<pre>"; print_r($locationsEdit); echo "</pre>";exit;   
        
        $this->set('locations',$locationsEdit['0']);
        
        $newquery = array("type"=>"region");
        
        $cursor1 = $collection->find ($newquery)->sort(array('order'=>1));
            
    		$locationsList = array ();
    		foreach ( $cursor1 as $result ) {
    		  $r = array("value"=>$result['name'],"data"=>$result['abbreviation']);
    		  array_push ( $locationsList, $r );
    		} 
        
        $this->set('locationsList',$locationsList);
        
        
                
        
        $this->set('currentPage',$page);
        $this->set('page','locations');
    }
    
    function toggleStatus($id)
    {
        
        if(empty($id))
        {
            echo "0";exit;
        }
        
        $this->layout = "admin";
                
        $collection = $this->db_conn();
        
        $DetailsId = $id;
		$xyz['id'] =  $DetailsId;
        $newquery = $xyz; 
        
        $cursor1 = $collection->find ($newquery);
        $locationInfo = array ();
		foreach ( $cursor1 as $result ) {
  		    array_push ( $locationInfo, $result );
		}

//echo "<pre>";
//print_r($locationInfo);
//echo "</pre>";     
   
        $savedvalue = $locationInfo[0]['status'];
        
        $value = 1;
        if($savedvalue==1)
            $value = 0;

       
        $retval = $collection->findAndModify ( $newquery, array (
											'$set' => array (
													'status' => $value,
											)
								
									), null, array (
											"sort" => array (
													"priority" => - 1
											),
											"new" => true,
											array ("safe" => true),
												
									) );

        
        $newquery1 = array('status' => 1);
        $countactive = $collection-> count($newquery1);
        
        $returnArray=array();
        $returnArray['value'] = $value;
        $returnArray['status'] = true;
        $returnArray['active_locations'] = $countactive;
               
        echo json_encode($returnArray);
        exit;
        
        
    }
    
    function changeorder($page)
    {
        if(isset($_POST["sort_order"])) 
        {
            $id_ary = explode(",",$_POST["sort_order"]);
            
            $collection = $this->db_conn();
            
            for($i=1;$i <= count($id_ary);$i++) 
            {
                
                $DetailsId = $id_ary[$i-1];
        		$xyz['id'] =  $DetailsId;
                $newquery = $xyz; 
                
                $retval = $collection->findAndModify ( $newquery, array (
    											'$set' => array (
    													'order' => $i,
    											)
    								
    									), null, array (
    											"sort" => array (
    													"priority" => - 1
    											),
    											"new" => true,
    											array ("safe" => true),
    												
    									) );
            }
            
            $newquery = array();
            
            $skipdoc = ($page-1)*20;
            
            $countrec = $collection-> count($newquery);
    
            $noOFPages = 0;
            if($countrec>20)
            {
                $noOFPages =  ceil($countrec/20);
                
            }
            //echo $noOFPages;exit;
            
            $cursor1 = $collection->find ($newquery)->sort(array('order'=>1));
            
    		$locationsList = array ();
    		foreach ( $cursor1 as $result ) {
    		  array_push ( $locationsList, $result );
    		} 
            
            $newquery1 = array('status' => 1);
            $countactive = $collection-> count($newquery1);
            
            $this->set('locationsList',$locationsList); 
            $this->set('currentPage',$page);
            $this->set('active_locations',$countactive);
            $this->set('total_locations',$countrec);
        }        
    }    
    
}
//http://angularcode.com/how-to-create-a-facebook-style-autocomplete-using-angularjs/
//http://angular-js.in/angucomplete-alt/
?>