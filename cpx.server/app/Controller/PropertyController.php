<?php 
//error_reporting(E_ALL);


class PropertyController extends AppController {
    
    public $helpers = array('Html', 'Form');
	public $components = array('Session','RequestHandler','Cookie');
	
	
    
    public function beforeFilter() {
		$logedinuser = $this->Session->read('User');
        $this->checkAdminLogin();
        
        $this->set('logedinuser',$logedinuser);
        parent::beforeFilter();
        
        
		
	}
    
    private function db_conn($preview = false,$publishers=false,$user_email_links=false)
    {
        $serUrl = Configure::read('CONNECT_SER');
    			
		$m1 = new MongoClient($serUrl);
		
		// select a database
		$db2 = $m1->properties;
		
		if($preview)
            $collection = $m1->$db2->realprop_preview;
        elseif($publishers)
            $collection = $m1->$db2->publishers;  
        elseif($user_email_links)
            $collection = $m1->$db2->user_email_links;                      
        else
           $collection = $m1->$db2->realprop;     
        
        $m1->close();
        
        return $collection;
    }
    
    
    public function index($status="All",$page=1)
    {
       
        $this->layout = "admin";
                
        $collection = $this->db_conn();
        
        if(isset($_GET['pageno']) && !empty($_GET['pageno']))
            $page = $_GET['pageno'];
        
        if(isset($_GET['tab_selected']) && !empty($_GET['tab_selected']))
            $status = $_GET['tab_selected'];            
        
        $newquery = array();
        
        $logedinuser = '';
        $logedinuser = $this->Session->read('User');
        
        if(!empty($logedinuser))
        {
            $user_type = $logedinuser['0']['type'];
            if($user_type!='superadmin')
            {
                
                $collection_user_email_links = $this->db_conn(false,false,true);
                        
                $fetch_linked_user['email'] = $logedinuser['0']['email'];
                $fetch_linked_user['status'] = 'approved';      
                                          
                $fetchquery = $fetch_linked_user;
                
                $cursor1 = $collection_user_email_links->find ($fetchquery);
               
                $linked_userDetail = array ();
                foreach ( $cursor1 as $result ) {
                    array_push ( $linked_userDetail, $result );
                }

                $linked_emails = array();
                foreach($linked_userDetail as $list)
                {
                    $linked_emails[] = $list['linked_email'];
                }
                  
//echo "<pre>aa";
//print_r($linked_emails);
//echo "</pre>";
//die;
                
                if(!empty($linked_emails))
                {
                    $newquery['$and'] = array();
                
                    $loggedin_user_email = trim($logedinuser['0']['email']);
                    $loggedin_user_email_query = array( '$or' => array( array('contact.email' => array('$in'=>$linked_emails)),array('agentID' => array('$in'=>$linked_emails))));  
                    
                    array_push($newquery['$and']  , $loggedin_user_email_query);                    
                }
                else
                {
                    $newquery['$and'] = array();
                
                    $loggedin_user_email = trim($logedinuser['0']['email']);
                    $loggedin_user_email_query = array( '$or' => array( array('contact.email' => new MongoRegex('/^' .  $loggedin_user_email . '/i')),array('agentID' => new MongoRegex('/^' .  $loggedin_user_email . '/i'))));  
                    
                    array_push($newquery['$and']  , $loggedin_user_email_query);
                }
            }
        }
        
        $skipdoc = ($page-1)*20;
        
        $this->set('search_done',0);
        $searchQueryStr = '?';
        
//echo "<pre>";
//print_r($logedinuser);
//print_r($_REQUEST);
//print_r($newquery);
//echo "</prE>"; 
//die;

        $collection_publishers = $this->db_conn(false,true);
        
        $newquery1= array('status' => false);
        $cursor1 = $collection_publishers->find ($newquery1);
        
		$deactivatepub = array ();
		foreach ( $cursor1 as $result ) {
		  $deactivatepub[] = $result['agentID'];
		} 
        
        if(isset($_REQUEST['property_id']) && !empty($_REQUEST['property_id']) && isset($_REQUEST['action']) && ($_REQUEST['action'] == 'purge'))
        {            
            $collection->remove(array('id' => $_REQUEST['property_id']));
        }
        
        if(isset($_REQUEST['filtertxt']) && !empty($_REQUEST['filtertxt']))
        {
            $filtertxt = $_REQUEST['filtertxt'];
            if($filtertxt == 'live_properties')
            {
                $filterquery =array('$and'=>array(array('offline'=>false),array('agentID'=>array('$nin'=>$deactivatepub))));
                
                if(!empty ($newquery['$and']['0']))
                    array_push($newquery['$and'], $filterquery); 
                else
                    $newquery =  $filterquery;                  
            }
        }

//echo "<pre>";
//print_r($newquery);
//echo "</prE>"; 
//die;
          
        if(isset($_REQUEST['purge']) && !empty($_REQUEST['purge']) && ($_REQUEST['purge']))
        {
            $newquery_properties = array('agentID' =>  array('$exists' => false));
            
            $cursor1 = $collection->find ($newquery_properties);
            //$cursor1 = $collection->find ($newquery_properties)->limit(3);//temp code for testing wtih 3 records            
        
    		$no_agent_propertyList = array ();
    		foreach ( $cursor1 as $result ) {
    		  array_push ( $no_agent_propertyList, $result );
    		} 
            
            $no_agent_property_ids = array();
            foreach ( $no_agent_propertyList as $result ) {
    		  array_push ( $no_agent_property_ids, $result['id'] );
    		} 

            $collection->remove(array('id' => array( '$in' => $no_agent_property_ids )));

            $_REQUEST['search_done'] = '0';
            $_REQUEST['no_agent_id'] = '';
            $_REQUEST['purge'] = '';                                   
        }
        
        if(isset($_REQUEST['search_done']) && !empty($_REQUEST['search_done']) && $_REQUEST['search_done'])
        {
            $searchQuery = array();
            $searchQuery['$and'] = array();
            
            if(isset($_REQUEST['pub_id_email']) && !empty($_REQUEST['pub_id_email']))
            {
                $pub_id_email = trim($_REQUEST['pub_id_email']);
                $pub_id_email_query =   array( '$or' => array( array('contact.email' => new MongoRegex('/^' .  $pub_id_email . '/i')),array('agentID' => new MongoRegex('/^' .  $pub_id_email . '/i'))));  
                
                array_push($searchQuery['$and']  , $pub_id_email_query);
                
                $this->set('pub_id_email',$pub_id_email);
                
                $searchQueryStr .= "pub_id_email=".$pub_id_email."&";
            }            
            
            if(isset($_REQUEST['paid_adv_exp_before']) && !empty($_REQUEST['paid_adv_exp_before']))
            {
                $paid_adv_exp_before = trim($_REQUEST['paid_adv_exp_before']);
                
                /*temp setting starts here*/
                $tmp_date = explode('/',$paid_adv_exp_before);
                $paid_adv_exp_before = date('Y-m-d-H:i:s',mktime(0,0,0,$tmp_date['1'],$tmp_date['0'],$tmp_date['2']));
                
                $paid_adv_exp_before_query =   array('adv_date'=>array ('$lte'=>$paid_adv_exp_before));
                
                array_push($searchQuery['$and']  , $paid_adv_exp_before_query);
                /*temp setting ends here*/
                
                $this->set('paid_adv_exp_before',trim($_REQUEST['paid_adv_exp_before']));
                
                $searchQueryStr .= "paid_adv_exp_before=".$paid_adv_exp_before."&";
            } 
            
            if(isset($_REQUEST['no_agent_id']) && !empty($_REQUEST['no_agent_id']))
            {
                $no_agent_id = trim($_REQUEST['no_agent_id']);
                //$no_agent_id_query =   array('agentID' =>  array('$exists' => false));
                $no_agent_id_query = array( '$or' => array( array('agentID'=>array('$exists' => false)),array('agentID'=>array('$size' => 0))));                
                
                array_push($searchQuery['$and']  , $no_agent_id_query);
                
                $this->set('no_agent_id',$no_agent_id);
                
                $searchQueryStr .= "no_agent_id=".$no_agent_id."&";
            }  
            
            if(isset($_REQUEST['prop_owner_id_email']) && !empty($_REQUEST['prop_owner_id_email']))
            {
                $prop_owner_id_email = trim($_REQUEST['prop_owner_id_email']);
                $prop_owner_id_email_query =    array( '$and' => array( array('contact.email' => new MongoRegex('/^' .  $prop_owner_id_email . '/i')),array('contact.type' => 'vendorDetails') )); 
                
                 array_push($searchQuery['$and']  , $prop_owner_id_email_query);
                 
                 $this->set('prop_owner_id_email',$prop_owner_id_email);
                 
                 $searchQueryStr .= "prop_owner_id_email=".$prop_owner_id_email."&";
            } 
            
            if(isset($_REQUEST['auctions_before']) && !empty($_REQUEST['auctions_before']))
            {
                $auctions_before = trim($_REQUEST['auctions_before']);
                
                $tmp_date = explode('/',$auctions_before);
                $auctions_before = date('Y-m-d-H:i:s',mktime(0,0,0,$tmp_date['1'],$tmp_date['0'],$tmp_date['2']));

                $auctions_before_query = array( '$and' => array( array('auction_date' => array ('$ne'=>'')),array('auction_date' => array ('$lte'=>$auctions_before))));  

                array_push($searchQuery['$and']  , $auctions_before_query);
                
                $this->set('auctions_before',trim($_REQUEST['auctions_before']));
                
                $searchQueryStr .= "auctions_before=".$auctions_before."&";
            } 
            
            if(isset($_REQUEST['prop_name_id_add']) && !empty($_REQUEST['prop_name_id_add']))
            {
                $prop_name_id_add = trim($_REQUEST['prop_name_id_add']);
                $prop_name_id_add_query =   array( '$or' => array( array('name' => new MongoRegex('/^' .  $prop_name_id_add . '/i')),array('id' => new MongoRegex('/^' .  $prop_name_id_add . '/i')),array('property_id' => new MongoRegex('/^' .  $prop_name_id_add . '/i')),array('address.LotNumber' => new MongoRegex('/^' .  $prop_name_id_add . '$/i')),array('address.subNumber' => new MongoRegex('/^' .  $prop_name_id_add . '$/i')),array('address.StreetNumber' => new MongoRegex('/^' .  $prop_name_id_add . '$/i')),array('address.street' => new MongoRegex('/^' .  $prop_name_id_add . '$/i')),array('address.suburb.text' => new MongoRegex('/^' .  $prop_name_id_add . '$/i')),array('address.state' => new MongoRegex('/^' .  $prop_name_id_add . '$/i')),array('address.country' => new MongoRegex('/^' .  $prop_name_id_add . '$/i')),array('address.postcode' => new MongoRegex('/^' .  $prop_name_id_add . '$/i'))));  
                
                array_push($searchQuery['$and']  , $prop_name_id_add_query);
                
                $this->set('prop_name_id_add',$prop_name_id_add);
                
                $searchQueryStr .= "prop_name_id_add=".$prop_name_id_add."&";
            } 
            
            if(isset($_REQUEST['pub_before']) && !empty($_REQUEST['pub_before']))
            {
                $pub_before = trim($_REQUEST['pub_before']);
                
                /*temp setting starts here*/
                $tmp_date = explode('/',$pub_before);
                $pub_before = date('Y-m-d-H:i:s',mktime(0,0,0,$tmp_date['1'],$tmp_date['0'],$tmp_date['2']));
                
                $pub_before_query =   array('published_date'=>array ('$lte'=>$pub_before));
                
                array_push($searchQuery['$and']  , $pub_before_query);
                /*temp setting ends here*/
                
                $this->set('pub_before',trim($_REQUEST['pub_before']));
                
                $searchQueryStr .= "pub_before=".$pub_before."&";
            }

            if(isset($_REQUEST['all']))
            {
                $all = $_REQUEST['all'];
                
                $today_date = date('Y-m-d-H:i:s',strtotime("now"));
                
                $all_query =   array( '$or' => array( array('established'=>'yes'),array('newConstruction'=>true),array('newConstruction'=>'yes'),array('homelandpackage'=>'yes'),array('auction_date'=>array ('$lte'=>$today_date)),array('smsf'=>true), array('domacom'=>true),array('deposit'=>'yes'),array('sold'=>true),array('vendorfinance'=>true),array('saving'=>array ('$gt'=>"0"))));  
                
                array_push($searchQuery['$and']  , $all_query);
                
                
                
                $this->set('all',$all);
                
                $searchQueryStr .= "all=".$all."&";
            }
            
            if(isset($_REQUEST['established']))
            {
                $established = $_REQUEST['established'];
                $established_query =   array('established'=>'yes');  
                
                array_push($searchQuery['$and']  , $established_query);
                
                $this->set('established',$established);
                
                $searchQueryStr .= "established=".$established."&";
            }
            
            if(isset($_REQUEST['new']))
            {
                $new = $_REQUEST['new'];
                //$new_query =   array('newconstruction'=>true);
                $new_query = array( '$or' => array( array('newConstruction'=>'yes'),array('newConstruction'=>true)));  
                
                array_push($searchQuery['$and']  , $new_query);
                
                $this->set('new',$new);
                
                $searchQueryStr .= "new=".$new."&";
            }
            
            if(isset($_REQUEST['home_and_land']))
            {
                $home_and_land = $_REQUEST['home_and_land'];
                $home_and_land_query =  array('homelandpackage'=>'yes');
                
                array_push($searchQuery['$and']  , $home_and_land_query);
                
                $this->set('home_and_land',$home_and_land);
                
                $searchQueryStr .= "home_and_land=".$home_and_land."&";
            }
            
            if(isset($_REQUEST['auction']))
            {
                $auction = $_REQUEST['auction'];
                //$today_date = date('Y-m-d-H:i:s',strtotime("now"));

                $auction_query =  array('auction_date'=>array ('$ne'=>''));

                array_push($searchQuery['$and']  , $auction_query);
                
                $this->set('auction',$auction);
                
                $searchQueryStr .= "auction=".$auction."&";
            }
            
            if(isset($_REQUEST['smsf']))
            {
                $smsf = $_REQUEST['smsf'];
                $smsf_query =  array('smsf'=>true);
                
                array_push($searchQuery['$and']  , $smsf_query);
                
                $this->set('smsf',$smsf);
                
                $searchQueryStr .= "smsf=".$smsf."&";
            }
            
            if(isset($_REQUEST['fractional']))
            {
                $fractional = $_REQUEST['fractional'];
                $fractional_query =  array('domacom'=>true);
                
                array_push($searchQuery['$and']  , $fractional_query);
                
                $this->set('fractional',$fractional);
                
                $searchQueryStr .= "fractional=".$fractional."&";
            }
            
            if(isset($_REQUEST['under_offer']))
            {
                $under_offer = $_REQUEST['under_offer'];
                $under_offer_query =  array('deposit'=>'yes');
                
                array_push($searchQuery['$and']  , $under_offer_query);
                
                $this->set('under_offer',$under_offer);
                
                $searchQueryStr .= "under_offer=".$under_offer."&";
            }
            
            if(isset($_REQUEST['sold']))
            {
                $sold = $_REQUEST['sold'];
                $sold_query =  array('sold'=>true);
                
                array_push($searchQuery['$and']  , $sold_query);
                
                $this->set('sold',$sold);
                
                $searchQueryStr .= "sold=".$sold."&";
            }
            
            if(isset($_REQUEST['vendorfinance']))
            {
                $vendorfinance = $_REQUEST['vendorfinance'];
                $vendorfinance_query =  array( '$and' => array( array('vendorfinance'=>true),array('vendor_finance_terms'=>array ('$exists' => true))));  
                
                array_push($searchQuery['$and']  , $vendorfinance_query);
                
                $this->set('vendorfinance',$vendorfinance);
                
                $searchQueryStr .= "vendorfinance=".$vendorfinance."&";
            }
            
            if(isset($_REQUEST['saving']))
            {
                $saving = $_REQUEST['saving'];
                $saving_query =  array( '$and' => array(array('saving' => array ('$gt'=>"0"))));  
                
                array_push($searchQuery['$and']  , $saving_query);
                
                $this->set('saving',$saving);
                
                $searchQueryStr .= "saving=".$saving."&";
            }
            
            if(!empty ($searchQuery['$and']['0']))
            {
                if(!empty ($newquery['$and']['0']))
                    array_push($newquery['$and'], $searchQuery); 
                else
                    $newquery =  $searchQuery; 
                    
                
                $searchQueryStr .= "search_done=1";
                $this->set('search_done',1);
            }
            else
            {
                if(empty ($newquery['$and']['0']))
                    $newquery =  array(); 
                
                $searchQueryStr .= "search_done=0";
                $this->set('search_done',0);
            }
            
            
            
//echo "<pre>";
//print_r($newquery);
//print_r($this->data);
//echo "</prE>"; 
//die;

        }

//echo $status;
//echo "<pre>newquery";
//print_r($newquery);
//print_r($this->data);
//echo "</prE>"; 
//die;
      
        
        
        $this->set('searchQueryStr',$searchQueryStr);
            
//echo "<br>str=>".$searchQueryStr;
//die;                        
        
        

        
        $countpropAll = $countpropStandard = $countpropPrepurchasedipr = $countpropPending = $countpropGraded = $countpropFeatured = $countpropOffline = 0;
        
        $gradedQuery = array();
        $filtergrade = array('$ne' => '');
        $gradedQuery['grade'] = $filtergrade;
        
        $featuredQuery = array();
        $featuredQuery['featured'] = true;
        
        $offlineQuery = array('offline'=>true);
        
        $standardQuery = array();
        $filtergrade = array('$eq' => '');
        $standardQuery['grade'] = $filtergrade;
        $standardQuery['offline'] = false;
        $standardQuery['featured'] = false;
        
        $countpropAll = $collection-> count($newquery);
        $this->set('countpropAll',$countpropAll);
        
        $featuredCountquery = array();
        if(!empty($newquery))
        {
            $featuredCountquery['$and'] = array($newquery,$featuredQuery);
        }
        else
        {
            $featuredCountquery=$featuredQuery;
        }
        $countpropFeatured = $collection->count($featuredCountquery);
        
        $offlineCountquery = array();
        if(!empty($newquery))
        {
            $offlineCountquery['$and'] = array($newquery,$offlineQuery);
        }else
        {
            $offlineCountquery=$offlineQuery;
        }
        $countpropOffline = $collection->count($offlineCountquery);
        
        $gradedCountquery = array();
        if(!empty($newquery))
        {
            $gradedCountquery['$and'] = array($newquery,$gradedQuery);
        }else
        {
            $gradedCountquery=$gradedQuery;
        }
        $countpropGraded = $collection->count($gradedCountquery);
        
        $standardCountquery = array();
        if(!empty($newquery))
        {
            $standardCountquery['$and'] = array($newquery,$standardQuery);
        }else
        {
            $standardCountquery=$standardQuery;
        }
        $countpropStandard = $collection->count($standardCountquery);
        
        
        $this->set('countpropStandard',$countpropStandard);
        $this->set('countpropPrepurchasedipr',$countpropPrepurchasedipr);
        $this->set('countpropPending',$countpropPending);
        $this->set('countpropGraded',$countpropGraded);
        $this->set('countpropFeatured',$countpropFeatured);
        $this->set('countpropOffline',$countpropOffline);
        
        if(!empty($status) && $status != "All")
        {
            switch($status)
            {
                case "Featured": 
                    $newquery = $featuredCountquery; 
                    $this->set('selected_tab','featured'); 
                break;
                    
                case "Graded": 
                    $newquery = $gradedCountquery; 
                    $this->set('selected_tab','graded'); 
                break;
                
                case "Offline": 
                    $newquery = $offlineCountquery; 
                    $this->set('selected_tab','offline'); 
                break;
                
                case "Standard": 
                    $newquery = $standardCountquery; 
                    $this->set('selected_tab','standard'); 
                break;
                
                case "Prepurchasedipr": 
                    $this->set('selected_tab','prepurchasedipr'); 
                break;
                
                case "Iprpending": 
                    $this->set('selected_tab','iprpending'); 
                break;
                
                default: 
                    $this->set('selected_tab','all'); 
                break;
            }
        }
        else
            $this->set('selected_tab','all');

        $countprop = $collection-> count($newquery);

//echo "<pre>"; print_r($newquery); echo "</pre>";
//echo "<pre>"; print_r($countprop); echo "</pre>";
//exit;
        
        $noOFPages = 0;
        if($countprop>20)
        {
            $noOFPages =  ceil($countprop/20);
            
        }
//echo $noOFPages;
//exit;
        
        $propertyList = array ();
    
        if(!empty($newquery) || $status == 'All')
        {            
       	    $featured = array('featured_timestamp' => -1, 'modifiedon'=>-1) ;
            $cursor1 = $collection->find ($newquery)->sort($featured)->skip($skipdoc)->limit(20);
    		
    		foreach ( $cursor1 as $result ) {
    		  array_push ( $propertyList, $result );
    		} 
        }

//echo "<pre>"; print_r($newquery); echo "</pre>";
//echo "<pre>"; print_r($countprop); echo "</pre>";
//exit;
        
        $statistics = $this->getStatistics($newquery,$deactivatepub);
        
        $anchor_id = '';        
        if(isset($_GET['propertyid']) && !empty($_GET['propertyid']))
            $anchor_id = $_GET['propertyid'];
            
        $this->set('anchor_id',$anchor_id);
        $this->set('currentPage',$page);
        $this->set('status',$status);
        $this->set('noOFPages',$noOFPages);
        $this->set('propertyList',$propertyList);      
        $this->set('page','property_listing');
        $this->set('user_type',$user_type);
        
        $this->set('total_live_properties',$statistics['total_live_properties']);                            
        $this->set('total_publishers',$statistics['total_publishers']);
        $this->set('grand_total_properties',$statistics['grand_total_properties']);
        $this->set('db_total_properties',$statistics['db_total_properties']);

        
//echo "<pre>property";
//print_r($newquery);
//print_r($propertyList);
//echo "</pre>";
//die;
    }
    
    private function setValWidget0($data,$newquery,$save_all)
    {
        $collection = $this->db_conn();
        
        $saving_val ='';
        if(isset($data['savingprice_val']) && !empty($data['savingprice_val']))
            $saving_val = $data['savingprice_val'];
        
        $cpxprice_val ='';
        if(isset($data['cpxprice_val']) && !empty($data['cpxprice_val']))                
            $cpxprice_val = $data['cpxprice_val'];
        
        $save_arr = array ('saving'=>$saving_val,'cpxprice'=>$cpxprice_val);
        
        if($save_all)
            return $save_arr;
        else
        {                            
            $retval = $collection->findAndModify ( $newquery, array (
											'$set' => $save_arr
								
									), null, array (
											"sort" => array (
													"priority" => - 1
											),
											"new" => true,
											array ("safe" => true),
												
									) );
        }                                               
    }
    
    private function setValWidget1($data,$newquery,$save_all)
    {
        $collection = $this->db_conn();
        
        $contract_of_sale =false;
        if(isset($data['contract_of_sale']))
            $contract_of_sale = $data['contract_of_sale'];                
                                    
        $property_off_the_plan = false;
        if(isset($data['property_off_the_plan']))
            $property_off_the_plan = true;
        
        $estimated_completion_date = '';
        if(isset($data['estimated_completion_date']))
            $estimated_completion_date = $data['estimated_completion_date']; 
            
        
        $files_for_contract_of_sale = array();           
        if(isset($data['AgreementDoc_name']))
        {
            foreach($data['AgreementDoc_name'] as $key=>$docname)
            {
                $files_for_contract_of_sale[] =array('name'=>$docname,'path'=>$data['AgreementDoc_path'][$key],'size'=>$data['AgreementDoc_size'][$key],'type'=>$data['AgreementDoc_type'][$key],'isurl'=>$data['AgreementDoc_isurl'][$key]);
            }
        }  
        //echo "<pre>"; print_r($files_for_contract_of_sale); echo "</pre>";exit;
        
        $save_arr = array ('contract_of_sale'=>$contract_of_sale,'property_off_the_plan'=>$property_off_the_plan,'contract'=>$files_for_contract_of_sale,'estimated_completion_date'=>$estimated_completion_date);
        
        if($save_all)
            return $save_arr;
        else
        { 
        
            $retval = $collection->findAndModify ( $newquery, array (
    											'$set' => $save_arr
    								
    									), null, array (
    											"sort" => array (
    													"priority" => - 1
    											),
    											"new" => true,
    											array ("safe" => true),
    												
    									) ); 
                                        
                                        
             if($retval)
             {           
                $this->remove_docs($files_for_contract_of_sale,$newquery);
             }     
        }                                   
                                                   
    }
    
    private function remove_docs($files_for_contract_of_sale,$newquery)
    {
        $doc_paths =array();
        foreach($files_for_contract_of_sale as $agreementdoc)
        {
            $doc_paths[] = basename($agreementdoc['path']);
        }
        
        
        $propertyAgrrementsFolder = 'uploads'.'/'.$newquery['id'];
        
        $files2new = '';
        if(file_exists($propertyAgrrementsFolder))
        {
            $files2new = scandir ( $propertyAgrrementsFolder, 1 );
        }
        
        if(!empty($files2new))
        {
            foreach($files2new as $key=>$filetoremove)
            {
                if($filetoremove==".." || $filetoremove==".")
                    continue;
                
                if(!in_array($filetoremove,$doc_paths))
                    unlink($propertyAgrrementsFolder.'/'.$filetoremove);
            }
        }
    }
    
    private function setValWidget2($data,$newquery,$save_all)
    {
        $collection = $this->db_conn();
        
        $domacom = false;             
        if(isset($data['frac_ownership']))
            $domacom = true;
        
        $save_arr = array ('domacom'=>$domacom);
        
        if($save_all)
            return $save_arr;
        else
        {
            $retval = $collection->findAndModify ( $newquery, array (
											'$set' => $save_arr
								
									), null, array (
											"sort" => array (
													"priority" => - 1
											),
											"new" => true,
											array ("safe" => true),
												
									) );
        }                                                     
    }
    
    private function setValWidget3($data,$propertyInfo,$newquery,$save_all)
    {
        $collection = $this->db_conn();
        
        $contacts_arr = array();
        foreach($propertyInfo['contact'] as $key=>$contacts)
        {
            $contacts_arr[$key] = $contacts;
            
            $contacts_arr[$key]['append_val'] = false;
            if(isset($data['append_val'][$key]))
                $contacts_arr[$key]['append_val'] = true;
            
            $contacts_arr[$key]['emails_val'] = false;
            if(isset($data['emails_val'][$key]))
                $contacts_arr[$key]['emails_val'] = true;
                
            $contacts_arr[$key]['display_val'] = false;
            if(isset($data['display_val'][$key]))
                $contacts_arr[$key]['display_val'] = true;                                        
        }
        
        $save_arr = array ('contact'=>$contacts_arr);
        
        if($save_all)
            return $save_arr;
        else
        {
            $retval = $collection->findAndModify ( $newquery, array (
											'$set' => $save_arr
								
									), null, array (
											"sort" => array (
													"priority" => - 1
											),
											"new" => true,
											array ("safe" => true),
												
									) );
        }                                                             
    }
    
    private function setValWidget4($data,$newquery,$save_all)
    {
        $collection = $this->db_conn();
        
        $vendor_finance_terms = '';
        $vendorfinance = false;
        if(isset($data['vendor_finance_terms']) && !empty($data['vendor_finance_terms']))
        {
            $vendor_finance_terms = $data['vendor_finance_terms'];
            $vendorfinance = true;   
        }
        
        $save_arr = array ('vendorfinance'=>$vendorfinance,'vendor_finance_terms'=>$vendor_finance_terms);
        
        if($save_all)
            return $save_arr;
        else
        {
            $retval = $collection->findAndModify ( $newquery, array (
											'$set' => $save_arr
								
									), null, array (
											"sort" => array (
													"priority" => - 1
											),
											"new" => true,
											array ("safe" => true),
												
									) );
        }                                         
    }
    
    private function setValWidget5($data,$newquery,$save_all)
    {
        $collection = $this->db_conn();

//echo "<pre>"; print_r($data);echo "</pre>";die;
        
        $iprArray = array();
        $score = $grade = '';
        if(!empty($data['property']['iprs']))
        {
            foreach($data['property']['iprs'] as $ipr)
                $iprArray[] = json_decode($ipr);
            
            
            //echo "<pre>"; print_r($iprArray);exit;
            
            $total_iprs = count($iprArray) - 1;
            //$latest_ipr = $iprArray[$total_iprs];
            
                         
        }


        
        $grade_status = 0;
        
        //echo "<pre>"; print_r($iprArray); echo "</pre>";
        //exit;
        
        foreach($iprArray as &$ipr)
        {
            $publishDate = $ipr->publishedAt;

            $tmp_datetime = explode('T', $publishDate);
                                
            $tmp_date = explode('-',$tmp_datetime['0']);
            
            $published_date = $tmp_date['1'].'/'.$tmp_date['2'].'/'.$tmp_date['0'].' '.$tmp_datetime['1'];
            
            $published_dateTimeStamp = strtotime($published_date);
            $completion_dateTimeStamp = $published_dateTimeStamp+(95*86400);
            $completionDate = date('d/m/Y',$completion_dateTimeStamp);
            $iprStatus = "0";

            if(time()<$completion_dateTimeStamp)
            {
                $iprStatus = "1";
                $grade_status = 2;
                
                
                $latest_ipr = $ipr;
                
                $score = $latest_ipr->results['0']->score;
                
                $grade = $latest_ipr->results['0']->grade;
            
            }

            $ipr->completionDate = $completionDate;
            $ipr->completionTimeStamp = $completion_dateTimeStamp;
            $ipr->iprStatus = $iprStatus;
        }

        $save_arr = array ("iprs" => $iprArray,"gradestatus" => $grade_status,"grade" => $grade,"score" => $score,);
        
        if($save_all)
            return $save_arr;
        else
        {
            $retval = $collection->findAndModify ( $newquery, array (
											'$set' => $save_arr
								
									), null, array (
											"sort" => array (
													"priority" => - 1
											),
											"new" => true,
											array ("safe" => true),
												
									) );
        }                                         
    }
    
    
    
    function append($id,$save_all = false,$preview=false)
    {
        if(empty($id))
        {
           $this->redirect("/propery/index"); 
        }
        
        $this->layout = "admin";

//echo "<pre>";
//print_r($_GET);
//echo "</pre>";
//die;

        
        $searchQueryStr = '?';
        if((isset($_GET['search_done']) && $_GET['search_done']) || (isset($_GET['tab_selected']) && !empty($_GET['tab_selected'])) || (isset($_GET['pageno']) && !empty($_GET['pageno'])))
        {
            foreach($_GET as $key=>$val)
            {
                $searchQueryStr .= $key.'='.$val.'&';                          
            }    
            
            $searchQueryStr = trim ($searchQueryStr,'&');
        }
        elseif(isset($this->data['searchQueryStr']) && !empty($this->data['searchQueryStr']))
            $searchQueryStr = $this->data['searchQueryStr'];

//echo $searchQueryStr;
//die;
        
        

//echo $searchQueryStr;
//die;
                        
        $collection = $this->db_conn();
        
        $DetailsId = $id;
		$xyz['id'] =  $DetailsId;
        $newquery = $xyz; 
       // print_r($newquery);
        if(!empty($this->data))
        {
            $cursor1 = $collection->find ($newquery);
            $propertyInfo = array ();
    		foreach ( $cursor1 as $result ) {
    		  array_push ( $propertyInfo, $result );
    		}
            //print_r($propertyInfo);
            $propertyInfo = $propertyInfo['0'];
            
           // echo "<pre>"; print_r($propertyInfo); echo "</pre>";
                        
//echo "<pre>"; print_r($this->data);echo "</pre>";
//echo "<pre>"; print_r($propertyInfo['files_for_contract_of_sale']);echo "</pre>";
//exit;
            
            $widget_id = '';
            if(isset($this->data['widget_id']) && !empty($this->data['widget_id']))
                $widget_id = $this->data['widget_id'];
                
            if(empty($widget_id))
            {
                $save_arr = array();
                                
                $save_arr0 = $this->setValWidget0($this->data,$newquery,$save_all);
                $save_arr = array_merge($save_arr,$save_arr0);
                
                $save_arr1 = $this->setValWidget1($this->data,$newquery,$save_all);
                $save_arr =  array_merge($save_arr,$save_arr1);
                
                $save_arr2 = $this->setValWidget2($this->data,$newquery,$save_all);
                $save_arr =  array_merge($save_arr,$save_arr2);
                
                $save_arr3 = $this->setValWidget3($this->data,$propertyInfo,$newquery,$save_all);
                $save_arr =  array_merge($save_arr,$save_arr3);
                
                $save_arr4 = $this->setValWidget4($this->data,$newquery,$save_all);
                $save_arr = array_merge($save_arr,$save_arr4);
                
                $save_arr5 = $this->setValWidget5($this->data,$newquery,$save_all);
                $save_arr =  array_merge($save_arr,$save_arr5);
               
                //echo "<pre>Final sace array";
                //print_r($save_arr);
               
                
               // print_r($propertyInfo);
               // echo "</pre>";exit;
               
               if($preview)
               {
                     
                     $propertyInfo = array_merge($propertyInfo,$save_arr);
                                                               
                     $collection_preview = $this->db_conn(true);
                     $listing = $collection_preview->findOne(array('id' => $newquery['id'] ));
					 $listingSize = sizeof($listing);
    				
    					if($listingSize != 0)
                         {
                            $retval = $collection_preview->findAndModify ( $newquery, array (
    											'$set' => $save_arr
    								
    									), null, array (
    											"sort" => array (
    													"priority" => - 1
    											),
    											"new" => true,
    											array ("safe" => true),
    												
    									) ); 
                         }
                         else
                         {
                            $retval =	$collection_preview->insert ( $propertyInfo, array (
    										"safe" => true
    								) );
                            
                         }
                        
                     $r = array();
                     $r['success'] = $retval;
                     echo json_encode($r);
                     exit;
               }
               else
               {
                
                    $retval = $collection->findAndModify ( $newquery, array (
    											'$set' => $save_arr
    								
    									), null, array (
    											"sort" => array (
    													"priority" => - 1
    											),
    											"new" => true,
    											array ("safe" => true),
    												
    									) ); 
                                        
                                        
                     if($retval)
                     {       
                        $files_for_contract_of_sale = array();           
                        if(isset($this->data['AgreementDoc_name']))
                        {
                            foreach($this->data['AgreementDoc_name'] as $key=>$docname)
                            {
                                $files_for_contract_of_sale[] =array('name'=>$docname,'path'=>$this->data['AgreementDoc_path'][$key],'size'=>$this->data['AgreementDoc_size'][$key],'type'=>$this->data['AgreementDoc_type'][$key],'isurl'=>$this->data['AgreementDoc_isurl'][$key]);
                            }
                        }  
                        
                        $this->remove_docs($files_for_contract_of_sale,$newquery);
                     }     
               }
            }
            elseif(!empty($widget_id))
            {
               //echo "in else"; exit;
               
                if($preview)
                {
                    $save_all = true;
                    $save_arr = array();
                }                
                               
                switch($widget_id)
                {
                    case "wid-id-0":
                        
                        $save_arr0 = $this->setValWidget0($this->data,$newquery,$save_all);
                        
                        if($preview)
                            $save_arr = array_merge($save_arr,$save_arr0);
                            
                        break;
                    
                    case "wid-id-1":
                        
                        $save_arr1 = $this->setValWidget1($this->data,$newquery,$save_all);
                        
                        if($preview)
                            $save_arr = array_merge($save_arr,$save_arr1);
                        
                        break;
                        
                    case "wid-id-2":
                        
                        $save_arr2 = $this->setValWidget2($this->data,$newquery,$save_all);
                        
                        if($preview)
                            $save_arr = array_merge($save_arr,$save_arr2);
                        
                        break;
                        
                    case "wid-id-3":
                        
                        $save_arr3 = $this->setValWidget3($this->data,$propertyInfo,$newquery,$save_all);
                        
                        if($preview)
                            $save_arr = array_merge($save_arr,$save_arr3);
                            
                        break;
                        
                    case "wid-id-4":
                        
                        $save_arr4 = $this->setValWidget4($this->data,$newquery,$save_all);
                        
                        if($preview)
                            $save_arr = array_merge($save_arr,$save_arr4);
                        
                        break;
                        
                    case "wid-id-5":
                    
                        $save_arr5 = $this->setValWidget5($this->data,$newquery,$save_all);
                        
                        if($preview)
                            $save_arr = array_merge($save_arr,$save_arr5);
                        
                        break;                                                                                                                                            
                }
                
                if($preview)
                {
                     
                     $propertyInfo = array_merge($propertyInfo,$save_arr);
                     
                     $collection_preview = $this->db_conn(true);
                     $listing = $collection_preview->findOne(array('id' => $newquery['id'] ));
                	 $listingSize = sizeof($listing);
                	
                		if($listingSize != 0)
                         {
                            $retval = $collection_preview->findAndModify ( $newquery, array (
                								'$set' => $save_arr
                					
                						), null, array (
                								"sort" => array (
                										"priority" => - 1
                								),
                								"new" => true,
                								array ("safe" => true),
                									
                						) ); 
                         }
                         else
                         {
                            $retval =	$collection_preview->insert ( $propertyInfo, array (
                							"safe" => true
                					) );
                            
                         }
                        
                     $r = array();
                     $r['success'] = $retval;
                     echo json_encode($r);
                     exit;
                }
            }
            
            $this->set('success_msg','Property appended successfully');            
        }
        else
        {
            $searchQueryStr = $searchQueryStr.'&propertyid='.$id;
        }

        $this->set('searchQueryStr',$searchQueryStr);
     
        
        $cursor1 = $collection->find ($newquery);
        $propertyInfo = array ();
		foreach ( $cursor1 as $result ) {
		  array_push ( $propertyInfo, $result );
		}
        
        $propertyInfo = @$propertyInfo['0'];
        
//echo "<pre>"; print_r($propertyInfo);echo "</pre>";
//exit;        
        
        $completeness_status = 0;
                                                        
        $property_for_sale_weightage = 25;
        $property_for_sale_value = 0;
        
        $contract_of_sale_weightage = 15;
        $contract_of_sale_value = 0;
        
        $fractional_ownership_weightage = 10;
        $fractional_ownership_value = 0;
        
        $contact_details_weightage = 10;
        $contact_details_value = 0;
        
        $vendor_finance_weightage = 10;
        $vendor_finance_value = 0;
        
        $ipr_details_weightage = 30;
        $ipr_details_value = 0;
        
        if(isset($propertyInfo['saving']) && !empty($propertyInfo['saving']))
        {
            $completeness_status += $property_for_sale_weightage; 
            $property_for_sale_value = 1;
        }
        
        if(isset($propertyInfo['contract']) && !empty($propertyInfo['contract']))
        {
            $completeness_status += $contract_of_sale_weightage;
            $contract_of_sale_value = 1;
        }
        
        if(isset($propertyInfo['domacom']) && $propertyInfo['domacom'])
        {
            $completeness_status += $fractional_ownership_weightage;
            $fractional_ownership_value = 1;
        }
            
        $contacts_completeness_flag = 0;    
        if(!empty($propertyInfo['contact']))
        {        
            foreach($propertyInfo['contact'] as $contacts)
            {
                if((isset($contacts['append_val']) && ($contacts['append_val'])) || (isset($contacts['emails_val']) && ($contacts['emails_val'])) || (isset($contacts['display_val']) && ($contacts['display_val'])))
                    $contacts_completeness_flag = 1;      
            }            
        }
                        
        if($contacts_completeness_flag)
        {
            $completeness_status += $contact_details_weightage;
            $contact_details_value = 1;
        }
            
            
        if(isset($propertyInfo['vendor_finance_terms']) && !empty($propertyInfo['vendor_finance_terms']))
        {
            $completeness_status += $vendor_finance_weightage;
            $vendor_finance_value = 1;
        }       
            
       // if(isset($propertyInfo['iprs']['0']['Id']) && !empty($propertyInfo['iprs']['0']['Id']))
        if(isset($propertyInfo['gradestatus']) && $propertyInfo['gradestatus'] ==2)
        {
            $completeness_status += $ipr_details_weightage;
            $ipr_details_value = 1;
        }
        
        
        $status_str = '';
        $status_str .= (($propertyInfo['gradestatus']) ? 'Graded, ' : '');
        $status_str .= (($propertyInfo['featured']) ? 'Featured, ' : '');
        $status_str .= (($propertyInfo['offline']) ? 'Offline, ' : '');
        $status_str .= ((!$propertyInfo['offline'] && !$propertyInfo['gradestatus']) ? 'Standard, ' : '');
                                        
        $status_str = trim($status_str,', '); 
        
        $total_files_for_contract_of_sale = 0;
        if(isset($propertyInfo['files_for_contract_of_sale']) && !empty($propertyInfo['files_for_contract_of_sale']))
            $total_files_for_contract_of_sale = count($propertyInfo['files_for_contract_of_sale']);
        
        $this->set('status_str',$status_str);
        $this->set('completeness_status',$completeness_status);
        
        $this->set('property_for_sale_weightage',$property_for_sale_weightage);
        $this->set('contract_of_sale_weightage',$contract_of_sale_weightage);
        $this->set('fractional_ownership_weightage',$fractional_ownership_weightage);
        $this->set('contact_details_weightage',$contact_details_weightage);
        $this->set('vendor_finance_weightage',$vendor_finance_weightage);
        $this->set('ipr_details_weightage',$ipr_details_weightage);
        
        $this->set('property_for_sale_value',$property_for_sale_value);
        $this->set('contract_of_sale_value',$contract_of_sale_value);
        $this->set('fractional_ownership_value',$fractional_ownership_value);
        $this->set('contact_details_value',$contact_details_value);
        $this->set('vendor_finance_value',$vendor_finance_value);
        $this->set('ipr_details_value',$ipr_details_value);
        
        $this->set('propertyInfo',$propertyInfo);
        $this->set('page','append');
        $this->set('total_files_for_contract_of_sale',$total_files_for_contract_of_sale);
        
        if(isset($this->data['save_type']) && !empty($this->data['save_type']))
        {
            $save_type = $this->data['save_type'];
            
            $property_id = $this->data['id'];
            
            if($save_type == 'Save & previous')
            {
                $temp_widget_id = substr($widget_id, -1);
                $temp_widget_id = $temp_widget_id - 1;
                $new_widget_id =  'wid-id-'.$temp_widget_id;
                
                $this->redirect('/property/append_widgets/'.$property_id.'/'.$new_widget_id.$searchQueryStr);
            }
            elseif($save_type == 'Save & next')
            {
                $temp_widget_id = substr($widget_id, -1);
                $temp_widget_id = $temp_widget_id + 1;
                $new_widget_id =  'wid-id-'.$temp_widget_id;

                $this->redirect('/property/append_widgets/'.$property_id.'/'.$new_widget_id.$searchQueryStr);
            }
            elseif($save_type == 'Save')
            {                
                $this->redirect('/property?prop_name_id_add='.$property_id.'&search_done=1');
            }
        }
        
    }
    
    function append_widgets($id,$widget_id)
    {
        if(empty($id))
        {
           $this->redirect("/propery/index"); 
        }
        
        $this->layout = "admin";
        
        $searchQueryStr = '?';
        if((isset($_GET['search_done']) && $_GET['search_done']) || (isset($_GET['tab_selected']) && !empty($_GET['tab_selected'])) || (isset($_GET['pageno']) && !empty($_GET['pageno'])))
        {
            foreach($_GET as $key=>$val)
            {
                $searchQueryStr .= $key.'='.$val.'&';                          
            }    
            
            $searchQueryStr = trim ($searchQueryStr,'&');
            
            $searchQueryStr = $searchQueryStr.'&propertyid='.$id;
        }
        $this->set('searchQueryStr',$searchQueryStr);
                        
        $collection = $this->db_conn();
        
        $DetailsId = $id;
		$xyz['id'] =  $DetailsId;
        $newquery = $xyz; 
        
        $cursor1 = $collection->find ($newquery);
        $propertyInfo = array ();
		foreach ( $cursor1 as $result ) {
		  array_push ( $propertyInfo, $result );
		}
        
        $propertyInfo = $propertyInfo['0'];
//echo "<pre>"; print_r($propertyInfo);echo "</pre>";
//exit;        
        
        $completeness_status = 0;
                                                        
        $property_for_sale_weightage = 25;
        $property_for_sale_value = 0;
        
        $contract_of_sale_weightage = 15;
        $contract_of_sale_value = 0;
        
        $fractional_ownership_weightage = 10;
        $fractional_ownership_value = 0;
        
        $contact_details_weightage = 10;
        $contact_details_value = 0;
        
        $vendor_finance_weightage = 10;
        $vendor_finance_value = 0;
        
        $ipr_details_weightage = 30;
        $ipr_details_value = 0;
        
        if(isset($propertyInfo['saving']) && !empty($propertyInfo['saving']))
        {
            $completeness_status += $property_for_sale_weightage; 
            $property_for_sale_value = 1;
        }
        
        if(isset($propertyInfo['files_for_contract_of_sale']) && !empty($propertyInfo['files_for_contract_of_sale']))
        {
            $completeness_status += $contract_of_sale_weightage;
            $contract_of_sale_value = 1;
        }
        
        if(isset($propertyInfo['domacom']) && $propertyInfo['domacom'])
        {
            $completeness_status += $fractional_ownership_weightage;
            $fractional_ownership_value = 1;
        }
            
        $contacts_completeness_flag = 0;
        if(!empty($propertyInfo['contact']))
        {            
            foreach($propertyInfo['contact'] as $contacts)
            {
                if((isset($contacts['append_val']) && ($contacts['append_val'])) || (isset($contacts['emails_val']) && ($contacts['emails_val'])) || (isset($contacts['display_val']) && ($contacts['display_val'])))
                    $contacts_completeness_flag = 1;      
            }
        }   
                 
        if($contacts_completeness_flag)
        {
            $completeness_status += $contact_details_weightage;
            $contact_details_value = 1;
        }
            
            
        if(isset($propertyInfo['vendor_finance_terms']) && !empty($propertyInfo['vendor_finance_terms']))
        {
            $completeness_status += $vendor_finance_weightage;
            $vendor_finance_value = 1;
        }       
            
        if(isset($propertyInfo['iprs']['0']['Id']) && !empty($propertyInfo['iprs']['0']['Id']))
        {
            $completeness_status += $ipr_details_weightage;
            $ipr_details_value = 1;
        }
        
        
        $status_str = '';
        $status_str .= (($propertyInfo['gradestatus']) ? 'Graded, ' : '');
        $status_str .= (($propertyInfo['featured']) ? 'Featured, ' : '');
        $status_str .= (($propertyInfo['offline']) ? 'Offline, ' : '');
        $status_str .= ((!$propertyInfo['offline'] && !$propertyInfo['gradestatus']) ? 'Standard, ' : '');
                                        
        $status_str = trim($status_str,', '); 
        
        $total_files_for_contract_of_sale = 0;
        if(isset($propertyInfo['files_for_contract_of_sale']) && !empty($propertyInfo['files_for_contract_of_sale']))
            $total_files_for_contract_of_sale = count($propertyInfo['files_for_contract_of_sale']);
        
        if(!empty($widget_id))
            $this->set('widget_id',$widget_id);
        
        $this->set('status_str',$status_str);
        $this->set('completeness_status',$completeness_status);
        
        $this->set('property_for_sale_weightage',$property_for_sale_weightage);
        $this->set('contract_of_sale_weightage',$contract_of_sale_weightage);
        $this->set('fractional_ownership_weightage',$fractional_ownership_weightage);
        $this->set('contact_details_weightage',$contact_details_weightage);
        $this->set('vendor_finance_weightage',$vendor_finance_weightage);
        $this->set('ipr_details_weightage',$ipr_details_weightage);
        
        $this->set('property_for_sale_value',$property_for_sale_value);
        $this->set('contract_of_sale_value',$contract_of_sale_value);
        $this->set('fractional_ownership_value',$fractional_ownership_value);
        $this->set('contact_details_value',$contact_details_value);
        $this->set('vendor_finance_value',$vendor_finance_value);
        $this->set('ipr_details_value',$ipr_details_value);
        
        $this->set('propertyInfo',$propertyInfo);
        $this->set('page','append_widgets');
        $this->set('total_files_for_contract_of_sale',$total_files_for_contract_of_sale);
        
    }
            
    function fetchApi($review_id, $property_id)
    {
        
        $endpoint = "https://id.propertycompass.com.au/connect/token";

        // Use one of the parameter configurations listed at the top of the post
        $params = array(
          "client_id" => "cpx.api",
          "client_secret" => "PBR]508Qo17Nj|s7Z87Fzr5W`{4v1Y",
          "grant_type" => "client_credentials",
          "scope" => "pc.api",
          );
        
        $curl = curl_init($endpoint);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HEADER,'Content-Type: application/x-www-form-urlencoded');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        
        // Remove comment if you have a setup that causes ssl validation to fail
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $postData = "";
        
        //This is needed to properly form post the credentials object
        foreach($params as $k => $v)
        {
           $postData .= $k . '='.urlencode($v).'&';
        }
        
        $postData = rtrim($postData, '&');
        
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        
        //echo "Performing Request...";
        
        $json_response = curl_exec($curl);
        
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        // evaluate for success response
        if ($status != 200) {
          throw new Exception("Error: call to URL $endpoint failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl) . "\n");
        }
        curl_close($curl);
        
        //echo "<br>Response==><br>". $json_response;
        
        $data = json_decode($json_response);
        
        $access_key = $data->access_token;
        
        $curl = curl_init( 'https://api.propertycompass.com.au/review/property/'.$review_id );
        curl_setopt( $curl, CURLOPT_HTTPHEADER, array( 'Authorization: Bearer ' . $access_key ) );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $json_response2 = curl_exec( $curl );
        
        //echo "<br>Response2==><br>". $json_response2;
        
        $data2 = json_decode($json_response2);

        $output = $data2;
        
        //if(!$this->checkIPRProperty($output,$property_id))
//        {
//            $output->message = 'Review id do not belong to this property';
//        }        
        
//echo "<pre>output";
//print_r($output);
//echo "</pre>";
//die;
        
        $this->layout = "ajax";
        $this->set('output',$output);
    }  
    
    function checkIPRProperty($output,$property_id)
    {
        if(!empty($output->property->id))
        {
            if($output->property->id == $property_id)
                return true;
            else
                return false;
        } 
    }
    
    function toggleStatus($field,$id,$total_live_properties)
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
        $propertyInfo = array ();
		foreach ( $cursor1 as $result ) {
		  array_push ( $propertyInfo, $result );
		}
        
        $savedvalue = $propertyInfo[0][$field];
        
        switch($field)
        {
            case "featured" : $value = (($savedvalue==true)?false:true);
                              if($value)
                              {
                                $field2 = "featured_date";
                                $value2 = date("Y-m-d H:i:s");
                                $field3 = "featured_timestamp";
                                $value3 = time();
                                
                              }else{
                                $field2 = "featured_date";
                                $value2 = "";
                                $field3 = "featured_timestamp";
                                $value3 = NULL;
                              }  
                              $savearray = array (
													$field => $value,
                                                    $field2 => $value2,
                                                    $field3 => $value3,
											);  
                              break;
            case "offline" : $value = (($savedvalue==true)?false:true);
                                $savearray = array (
													$field => $value,
                                              
											);
                                if($value == true)
                                    $total_live_properties = $total_live_properties - 1;
                                elseif($value == false)
                                    $total_live_properties = $total_live_properties + 1;                                            
                                break;
            case "smsf" : $value = (($savedvalue==true)?false:true);
                           $savearray = array (
													$field => $value,
                                              
											);         
                                break;
        }
                        
        $retval = $collection->findAndModify ( $newquery, array (
											'$set' => $savearray
								
									), null, array (
											"sort" => array (
													"priority" => - 1
											),
											"new" => true,
											array ("safe" => true),
												
									) );
        
        
        $returnArray=array();
        $returnArray['value'] = $value;
        $returnArray['status'] = true;
        $returnArray['total_live_properties'] = $total_live_properties;      
               
        echo json_encode($returnArray);
        exit;
        
        
    }
    
    public function getStatistics($newquery,$deactivatepub)
    {
        $newquery1 = $nq = $statistics = array();
        
        $collection_properties = $this->db_conn();
        
        $collection_publishers = $this->db_conn(false,true);

//echo "<prE>";
//print_r($deactivatepub);
//echo "</prE>";
//die;
         
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
            
        $statistics['total_live_properties'] = $collection_properties-> count($nq);

//echo "<prE>";
//print_r($statistics);
//echo "</prE>";
//die;        
        
        $newquery1= array();
        $statistics['total_publishers'] = $collection_publishers->count ($newquery1);
        
        
        $nq = array('$and'=>array(array('agentID'=>array('$exists' => true))));
        
        if(!empty($newquery))
            array_push ( $nq['$and'], $newquery ); 

//echo "<prE>";
//print_r($nq);
//echo "</prE>";
//die;
            
        $statistics['grand_total_properties'] = $collection_properties-> count($nq);
        
        $db_total_properties = $collection_properties-> count($newquery);
        $statistics['db_total_properties'] = $db_total_properties;
        
                  
        
//echo "<prE>";
//print_r($statistics);
//echo "</prE>";
//die;
                            
        return $statistics;
    }
    
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