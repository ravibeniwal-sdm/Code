<?php 
//error_reporting(E_ALL);

class AccountholdersController extends AppController {
    
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
    
    public function index($page=1)
    {
        $this->layout = "admin";
              
		$collection_users = $this->db_conn(false,true);
        $collection_listing_agents = $this->db_conn(false,false,true);
        $collection_properties = $this->db_conn(true);
        $collection_publisher = $this->db_conn();
        $collection_vendors = $this->db_conn(false,false,false,true);
        
        $searchQueryStr = '?';
        
        $newquery = array();
        
        $skipdoc = ($page-1)*20;
        

        if(isset($_REQUEST['filtertxt']) && !empty($_REQUEST['filtertxt']))
        {
            $searchtxt = $_REQUEST['filtertxt'];
            
            $usersQuery = array();
            
            if($_REQUEST['filtertxt'] == 'verified')           
                $usersQuery =  array('status' => 'active');            
            elseif($_REQUEST['filtertxt'] == 'unverified')           
                $usersQuery =  array('status' => 'inactive');
            elseif($_REQUEST['filtertxt'] == 'social_media')           
                $usersQuery =  array('oauth_provider'=>array('$exists' => true));
            elseif($_REQUEST['filtertxt'] == 'cpx_form')           
                $usersQuery = array('$and' => array(array('system_generated_user' => array('$exists' => false)),array('oauth_provider'=>array('$exists' => false))));                   
            elseif($_REQUEST['filtertxt'] == 'via_feeds')           
                $usersQuery =  array('system_generated_user'=>array('$exists' => true));
            elseif($_REQUEST['filtertxt'] == 'total_account_holders')           
                $usersQuery =  array();                            
        
            $searchQueryStr .= "filtertxt=".$_REQUEST['filtertxt']."&";
                            
            $newquery = $usersQuery;
        }

        if(isset($_REQUEST['search_done']) && !empty($_REQUEST['search_done']) && $_REQUEST['search_done'])
        {
            $searchQuery = array();
            $searchtxt = $welcome_reminder = ''; 
                        
            if(isset($_REQUEST['search']) && !empty($_REQUEST['search']))
            {
                $searchtxt = trim($_REQUEST['search']);
               
                $usersSearchQuery =  array('username' => new MongoRegex('/^' .  $searchtxt . '/i'));            
                
                $searchQuery = $usersSearchQuery;
                
                $searchQueryStr .= "search_done=1&search=".$_REQUEST['search']."&";
                
                $this->set('searchtxt',$searchtxt);
            }        
            
            if(isset($_REQUEST['welcome_reminder']) && !empty($_REQUEST['welcome_reminder']))
            {
                $welcome_reminder = $_REQUEST['welcome_reminder'];
               
                $welcomeReminderQuery =  array('$and' => array(array('system_generated_user' => array('$exists' => true)),array('system_generated_user' => array('$eq' => true)),array('no_of_invitation_sent'=>array('$eq' => 1))));               
                
                $searchQuery = $welcomeReminderQuery;               
    
                $searchQueryStr .= "search_done=1&welcome_reminder=".$_REQUEST['welcome_reminder']."&";
                
                $this->set('welcome_reminder',$welcome_reminder);
            }   
            
            $newquery = $searchQuery;  
        }

//echo "<pre>";
//print_r($_REQUEST);
//echo "</pre>";
//
//echo "<pre>";
//print_r($newquery);
//echo "</pre>";
//die;        
        
        if(isset($_REQUEST['export']) && ($_REQUEST['export']))
        {
            $cursor1 = $collection_users->find ($newquery);
        
    		$accountholdersList = array();
    		foreach ( $cursor1 as $result ) {
    		  array_push ( $accountholdersList, $result );
    		} 
            
            $this->export_data($accountholdersList);
        }
        
        $countaccountholders = $collection_users-> count($newquery);
        
        $noOFPages = 0;
        if($countaccountholders>20)
        {
            $noOFPages =  ceil($countaccountholders/20);
            
        }
        
        $cursor1 = $collection_users->find ($newquery)->sort(array("_id" => -1))->skip($skipdoc)->limit(20);
        
		$accountholdersList = array();
		foreach ( $cursor1 as $result ) {
		  array_push ( $accountholdersList, $result );
		} 
        
        $newquery1 = array();
        $i = 0;
        foreach($accountholdersList as $accountholders)
        {                
            $countprop = 0;
            $newquery1 = array();
            $newquery1 = array('$or' => array(array('agentID' => $accountholders['email']),array('contact.email'=>$accountholders['email'])));   
                
            $countprop = $collection_properties-> count($newquery1);
           
            $accountholdersList[$i]['total_properties'] = $countprop;

//echo "<br>email==>".$accountholders['email'];
//echo "<br>cou==>".$countprop;
          
            $accountholdersList[$i]['live_properties'] = 0;
            if($countprop)
            {
                $countprop2 = $countprop3 = $countprop4 = 0;
                $newquery2 = $newquery3 = $newquery4 = array();
                
                $newquery2 = array('$and'=>array(array('$or' => array(array('agentID' => $accountholders['email']),array('contact.email'=>$accountholders['email']))),array('offline'=>false))); 
                    
                $countprop2 = $collection_properties-> count($newquery2);

//echo "<prE>";
//print_r($newquery2);
//echo "</pre>";
//echo "<br>cou2==>".$countprop2;
               
                if($countprop2)
                {
                    if($accountholders['type'] == 'publisher')
                    {
                        $newquery3 = array('$and'=>array(array('status'=>true),array('agentID'=>$accountholders['email'])));
                    
                        $countprop3 = $collection_publisher-> count($newquery3);
 
// echo "<prE>";
//print_r($newquery3);
//echo "</pre>";
//echo "<br>cou3==>".$countprop3;
                        
                        if($countprop3)
                           $countprop4 = $countprop2; 
                    }
                    elseif($accountholders['type'] == 'listing agent' )
                    {
                        $newquery4 = array('email'=>$accountholders['email']);
                        
                        $cursor1 = $collection_listing_agents->find ($newquery4);
            
                		$laList = array();
                		foreach ( $cursor1 as $result ) {
                		  array_push ( $laList, $result );
                		} 
                        
                        foreach($laList as $la)
                        {
                            $newquery3 = array('$and'=>array(array('status'=>true),array('agentID'=>$la['agentID']))); 
                    
                            $countprop3 = $collection_publisher-> count($newquery3);
                            
                            if($countprop3)
                               $countprop4 = $countprop2; 
                        }
                    }
                    elseif($accountholders['type'] == 'vendor' )
                    {
                        $newquery4 = array('email'=>$accountholders['email']);
                        
                        $cursor1 = $collection_vendors->find ($newquery4);
            
                		$laList = array();
                		foreach ( $cursor1 as $result ) {
                		  array_push ( $laList, $result );
                		} 
                        
                        foreach($laList as $la)
                        {
                            $newquery3 = array('$and'=>array(array('status'=>true),array('agentID'=>$la['agentID']))); 
                    
                            $countprop3 = $collection_publisher-> count($newquery3);
                            
                            if($countprop3)
                               $countprop4 = $countprop2; 
                        }
                    }
                }   
 
 //echo "<br>cou2=>".$countprop2;
// echo "<br>cou4==>".$countprop4;
                
                if($countprop2 && $countprop4)      
                    $accountholdersList[$i]['live_properties'] = $countprop4;
                
            }                                 
            $i++;
        }
        
        $newquery1 = array('$and'=>array(array('status'=>'inactive')));
        
        if(!empty($newquery))
            array_push ( $newquery1['$and'], $newquery ); 
        
        $total_unverified_users = $collection_users-> count($newquery1);
        
        $newquery1 = array('$and'=>array(array('status'=>'active')));
        
         if(!empty($newquery))
            array_push ( $newquery1['$and'], $newquery );
        
        $total_verified_users = $collection_users-> count($newquery1);
        
        $newquery1 = array('$and'=>array(array('oauth_provider' =>  array('$exists' => true))));
        
        if(!empty($newquery))
            array_push ( $newquery1['$and'], $newquery );
        
        $total_social_media_users = $collection_users-> count($newquery1);
        
        $newquery1 = array('$and'=>array( array('system_generated_user' =>  array('$exists' => false)), array('oauth_provider' =>  array('$exists' => false))));
        
        if(!empty($newquery))
            array_push ( $newquery1['$and'], $newquery );
        
        $total_cpx_form_users = $collection_users-> count($newquery1);
        
        $newquery1 = array('$and'=>array(array('system_generated_user' =>  array('$exists' => true))));
        
        if(!empty($newquery))
            array_push ( $newquery1['$and'], $newquery );
        
        $total_via_feeds_users = $collection_users-> count($newquery1);                                                   
        
        $newquery1 = array();
        
        $total_account_holders = $collection_users-> count($newquery1);
                                
        $this->set('accountholdersList',$accountholdersList); 
        $this->set('currentPage',$page);
        $this->set('noOFPages',$noOFPages);
        $this->set('page','accountholders');
        $this->set('searchQueryStr',$searchQueryStr);
        
        $this->set('total_verified_users',$total_verified_users);
        $this->set('total_unverified_users',$total_unverified_users);
        $this->set('total_social_media_users',$total_social_media_users);
        $this->set('total_cpx_form_users',$total_cpx_form_users);
        $this->set('total_via_feeds_users',$total_via_feeds_users);       
        $this->set('total_account_holders',$total_account_holders);        
        
        
//echo "<pre>userslist";
//
//print_r($accountholdersList);
//echo "</pre>";
//die;


        
    }
    
    public function export_data($accountholdersList)
    {
//echo "<pre>";
//print_r($accountholdersList);
//echo "</pre>";
//die;
        
        // output headers so that the file is downloaded rather than displayed
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=data.csv');
        
        // create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');
        
        // output the column headings
        fputcsv($output, array('Username', 'Firstname', 'Lastname', 'Email', 'User Type', 'Status'));
        
        foreach($accountholdersList as $accountholders)
        {          
            
            if(!empty($accountholders['username']))                        
                $row['username']=htmlspecialchars($accountholders['username'], ENT_QUOTES);
            else
                $row['username']= 'null';
                
            if(!empty($accountholders['firstname']))      
                $row['firstname']=htmlspecialchars($accountholders['firstname'], ENT_QUOTES);
            else
                $row['firstname']= 'null';
                
            if(!empty($accountholders['lastname']))  
                $row['lastname']=htmlspecialchars($accountholders['lastname'], ENT_QUOTES);
            else
                $row['lastname']= 'null';
                
            if(!empty($accountholders['email']))  
                $row['email']=htmlspecialchars($accountholders['email'], ENT_QUOTES);
            else
                $row['email']= 'null';
                
            if(!empty($accountholders['type']))  
                $row['type']=htmlspecialchars($accountholders['type'], ENT_QUOTES);
            else
                $row['type']= 'null';
                
            if(!empty($accountholders['status']))  
            {
                if($accountholders['status'] == 'active')
                    $user_status = 'Verified';
                elseif($accountholders['status'] == 'inactive')
                {
                    if($accountholders['system_generated_user'] && isset($accountholders['no_of_invitation_sent']) && ($accountholders['no_of_invitation_sent']==1))
                        $user_status = 'Invited';
                    elseif($accountholders['system_generated_user'] && isset($accountholders['no_of_invitation_sent']) &&  ($accountholders['no_of_invitation_sent']==2))
                        $user_status = 'Reinvited'; 
                    else                                               
                        $user_status = 'Unverified';
                }
                $row['status']=$user_status;                   
            }
            else
                $row['status']= 'null';
                
            fputcsv($output, $row);
        }
        die;
        
    }
}
?>