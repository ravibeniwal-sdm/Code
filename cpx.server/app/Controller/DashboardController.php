<?php 
//error_reporting(E_ALL);

class DashboardController extends AppController {
    
    public $helpers = array('Html', 'Form');
	public $components = array('Session','RequestHandler');
	
    public function beforeFilter() {
		$logedinuser = $this->Session->read('User');
        if(empty($logedinuser) && !isset($logedinuser['username']))
        {
            $this->redirect("/auth/login");
        }
        
        parent::beforeFilter();
	}

    private function db_conn($publishers=false,$users=false)
    {
        $serUrl = Configure::read('CONNECT_SER');
    			
		$m1 = new MongoClient($serUrl);
		
		// select a database
		$db2 = $m1->properties;
		
        if($publishers)
            $collection = $m1->$db2->publishers;  
        elseif($users)
            $collection = $m1->$db2->users;                       
        else
           $collection = $m1->$db2->realprop;     
        
        $m1->close();
        
        return $collection;
    }

    
    public function index()
    {
        $this->layout = "admin";
        $logedinuser = $this->Session->read('User');

        $finallistingQuery = $finalofflineQuery = $finalfeaturedQuery = array();
        
        if(!empty($logedinuser))
        {
            $user_type = $logedinuser['0']['type'];
            if($user_type!='superadmin')
            {
                $finallistingQuery['$and'] = $finalofflineQuery['$and'] = $finalfeaturedQuery['$and'] = array();
                
                $loggedin_user_email = trim($logedinuser['0']['email']);
                $loggedin_user_email_query = array( '$or' => array( array('contact.email' => new MongoRegex('/^' .  $loggedin_user_email . '/i')),array('agentID' => new MongoRegex('/^' .  $loggedin_user_email . '/i'))));  
                
                array_push($finallistingQuery['$and']  , $loggedin_user_email_query);
                array_push($finalofflineQuery['$and']  , $loggedin_user_email_query);
                array_push($finalfeaturedQuery['$and']  , $loggedin_user_email_query);
            }
        }

        $collection = $this->db_conn();

        $countlisting = $collection-> count($finallistingQuery);
        $this->set('countlisting',$countlisting);

        $offlineQuery = array('offline'=>true);
        if(!empty ($finalofflineQuery['$and']['0']))
            array_push($finalofflineQuery['$and'], $offlineQuery); 
        else
            $finalofflineQuery = $offlineQuery;               
        
        $countoffline = $collection-> count($finalofflineQuery);
        $this->set('countoffline',$countoffline);        

        $featuredQuery = array('featured'=>true);
        
        if(!empty ($finalfeaturedQuery['$and']['0']))
            array_push($finalfeaturedQuery['$and'], $featuredQuery); 
        else
            $finalfeaturedQuery = $featuredQuery;                             
                        
        $countfeatured = $collection-> count($finalfeaturedQuery);
        $this->set('countfeatured',$countfeatured);        

        $this->set('logedinuser',$logedinuser);
        $this->set('page','dashboard');
       
    }
    
    public function close_attention_msg($username)
    {
        $collection = $this->db_conn(false,true);
        
        if(!empty($username))
        {
            $UserId = $username;
    		$xyz['username'] =  $UserId;
            $newquery = $xyz; 
            
            $retval = $collection->findAndModify ( $newquery, array (
    											'$set' => array('show_attention_user_msg'=>false)
    								
    									), null, array (
    											"sort" => array (
    													"priority" => - 1
    											),
    											"new" => true,
    											array ("safe" => true),
    												
    									) );      
            
            
            
            $this->Session->write('User.0.show_attention_user_msg', false);

        }            
    }
}
?>