<?php 
App::uses('CakeEmail', 'Network/Email');

use Cake\Mailer\Email;


error_reporting(0);

define ( "SENGRID_SMTP", "sendgrid" );
//define ( "SENGRID_SMTP", "../../parsedDatafiles" );

class ContactformsController extends AppController {
    
    public $helpers = array('Html', 'Form');
	public $components = array('RequestHandler');
	
	
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->response->header('Access-Control-Allow-Origin','*');
		$this->response->header('Access-Control-Allow-Methods','*');
		$this->response->header('Access-Control-Allow-Headers','X-Requested-With');
		$this->response->header('Access-Control-Allow-Headers','Content-Type, x-xsrf-token');
		$this->response->header('Access-Control-Max-Age','172800');
	}
    
    public function add($data) {
     	//echo phpinfo();
    	 
    	//echo "within add1";
    	
    	//print_r($data);
    	
    	
    	$apiurl = Configure::read('API_URL');
    	$weburl = Configure::read('WEB_URL');
    	 
    	$data['apiurl'] = $apiurl;
    	$data['weburl'] = $weburl;
    	
    	//print_r($data);
    	
    	//********* EMAIL TO CPx ADMIN *********\\
    	 
    	$Email2cpxadmin = new CakeEmail('sendgrid');
        //$Email2cpxadmin = new CakeEmail('gmail');
    	
        $Email2cpxadmin->from(array('contact@centralpropertyexchange.com.au' => 'CentralPropertyExchange.com.au'));
    	$Email2cpxadmin->to('contact@centralpropertyexchange.com.au');
        
        //$Email2cpxadmin->to("irshadahmed.ansari@gmail.com");
        //$Email2cpxadmin->cc("vhoraparvez@gmail.com");
    	$Email2cpxadmin->subject($data['dummysubject']);
    	$Email2cpxadmin->template('commontemp');
    	$Email2cpxadmin->viewVars(array('data' => $data));
    	$Email2cpxadmin->emailFormat('html');
    		if(isset($data['dummysubject'])){
    			$Email2cpxadmin->send();
    		//echo "Sent To Admin";
    		}
    	//********* EMAIL TO CPx ADMIN END *********\\
    } 
   
    public function index() {
    	
    	$this->RequestHandler->addInputType('json', array('json_decode', true));
    	$data = $this->request->data;
    
    	$this->add($data);
    }
    
	//this is a add function
    public function send_enquire($data) {
     	//echo phpinfo();
    	 
    //	echo "within add1";
    	
    	//print_r($data);
        
        //to fetch property details 
        $serUrl = Configure::read('CONNECT_SER');
			
		$m1 = new MongoClient($serUrl);
		
		// select a database
		$db2 = $m1->properties;
		
		$collection = $m1->$db2->realprop;
        
        $newquery = array('id'=>$data['propertyIds']);
               
        $cursor1 = $collection->find ($newquery);
        
        
	
        $properties = array();
		foreach ( $cursor1 as $result ) {
			array_push ( $properties, $result );
		}
       
       
        //$data["properties"] = $properties;
        $to_contact_str = array();
        foreach($properties as $property)
        {
            foreach($property['contact'] as $contact)
            {
                if((isset($contact['emails_val'])) && ($contact['emails_val']))
                    $to_contact_str[] = $contact['email'];
                else if(!(isset($contact['emails_val'])))
                    $to_contact_str[] = $contact['email'];                    
            }
        }
        //$to_contact_str = trim($to_contact_str,', '); 

//echo "<pre>";
//print_r($properties);
//echo "</pre>";
//
//
//echo "<pre>";
//print_r($to_contact_str);
//echo "</pre>";
//die;


        
        $data['to_contacts_email']=$to_contact_str;
                
        $apiurl = Configure::read('API_URL');
    	$weburl = Configure::read('WEB_URL');
    	 
    	$data['apiurl'] = $apiurl;
    	$data['weburl'] = $weburl;
    	
    	//print_r($data);
    	
    	//********* EMAIL TO CPx ADMIN *********\\
    	 	
    	    	
        
   		$Email2cpxadmin = new CakeEmail('sendgrid');
        //$Email2cpxadmin = new CakeEmail('gmail');
    	
        $Email2cpxadmin->from($data['email'],'CentralPropertyExchange.com.au');
    	
        $Email2cpxadmin->to($to_contact_str);
        $Email2cpxadmin->cc('contact@centralpropertyexchange.com.au','CPx Admin');
        //$Email2cpxadmin->to("vhoraparvez@gmail.com");
        //$Email2cpxadmin->cc("irshadahmed.ansari@gmail.com");
    	
        $Email2cpxadmin->subject($data['subject']);
    	$Email2cpxadmin->template('enquire');
    	$Email2cpxadmin->viewVars(array('data' => $data));
    	$Email2cpxadmin->emailFormat('html');

//echo json_encode($data);
//die;  
      
  	   if(isset($data['subject'])){
    			$Email2cpxadmin->send();
    	//	echo "1";die;
    		}
     //   echo "0";die;
    	//********* EMAIL TO CPx ADMIN END *********\\
        
        $m1->close();     
    } 
   
    public function enquire() {
    	
    	$this->RequestHandler->addInputType('json', array('json_decode', true));
    	$data = $this->request->data;
 
 //print_r($data);
        
    	$this->send_enquire($data);
    }
    
    
    public function send_service_request($data) {
     	//echo phpinfo();
    	 
    //	echo "within add1";
    	
    	//print_r($data);
        
        //to fetch property details 
       
        //$data["properties"] = $properties;
        $to_contact_str = array();
        foreach($data['rec_emails'] as $rec_email)
        {
            
            $data['to_contacts_email']=$rec_email['email_add'];
            $data['to_contacts_role'] = $rec_email['role'];
                
            $apiurl = Configure::read('API_URL');
        	$weburl = Configure::read('WEB_URL');
        	 
        	$data['apiurl'] = $apiurl;
        	$data['weburl'] = $weburl;
        	
        	//print_r($data);
        	
        	//********* EMAIL TO CPx ADMIN *********\\
        	 
        	$Email2cpxadmin = new CakeEmail('sendgrid');
            //$Email2cpxadmin = new CakeEmail('gmail');
        	
            $Email2cpxadmin->from($data['email'],'CentralPropertyExchange.com.au');
        	
            $Email2cpxadmin->to($rec_email['email_add']);
            $Email2cpxadmin->cc('contact@centralpropertyexchange.com.au','CPx Admin');
            //$Email2cpxadmin->to("vhoraparvez@gmail.com");
            //$Email2cpxadmin->cc("irshadahmed.ansari@gmail.com");
        	
            $Email2cpxadmin->subject($data['subject']);
        	$Email2cpxadmin->template('servicerequest');
        	$Email2cpxadmin->viewVars(array('data' => $data));
        	$Email2cpxadmin->emailFormat('html');
        
        
//echo json_encode($data);

          
      		if(isset($data['subject'])){
        			$Email2cpxadmin->send();
        		//echo "Sent To Admin";
        		}    
            
        }

    //    echo "1";

      //  die;        
        //$to_contact_str = trim($to_contact_str,', '); 



        
        

    	//********* EMAIL TO CPx ADMIN END *********\\
    } 
    
    
    public function servicerequest() {
    	
    	$this->RequestHandler->addInputType('json', array('json_decode', true));
    	$data = $this->request->data;
       // echo json_encode($data);die;
 //print_r($data);
        
    	$this->send_service_request($data);
    }
    
    
    public function send_buythisproperty_request($data) {
     	//echo phpinfo();
    	 
    //	echo "within add1";
    	
    	//print_r($data);
        
        //to fetch property details 
        $serUrl = Configure::read('CONNECT_SER');
			
		$m1 = new MongoClient($serUrl);
		
		// select a database
		$db2 = $m1->properties;
		
		$collection = $m1->$db2->realprop;
        
        $newquery = array('id'=>$data['propertyIds']);
               
        $cursor1 = $collection->find ($newquery);
        
        
	
        $properties = array();
		foreach ( $cursor1 as $result ) {
			array_push ( $properties, $result );
		}
       
        $to_contact_str = array();
        
        if($data['pass_params'] == 'Domacom')       
            $to_contact_str = array('sean.crisp@domacom.com.au');
        
        if($data['pass_params'] == 'AffordAssist')       
            $to_contact_str = array('anthony@aoun.co');
                    
        
        foreach($properties as $property)
        {
            foreach($property['contact'] as $contact)
            {
                if((isset($contact['emails_val'])) && ($contact['emails_val']))
                    $to_contact_str[] = $contact['email'];
                else if(!(isset($contact['emails_val'])))
                    $to_contact_str[] = $contact['email'];
            }
        }
        //$to_contact_str = trim($to_contact_str,', '); 



        
        $data['to_contacts_email']=$to_contact_str;
                
        $apiurl = Configure::read('API_URL');
    	$weburl = Configure::read('WEB_URL');
    	 
    	$data['apiurl'] = $apiurl;
    	$data['weburl'] = $weburl;
    	
    	//print_r($data);

//echo json_encode($data);
//die;
    	
    	//********* EMAIL TO CPx ADMIN *********\\
    	 
    	$Email2cpxadmin = new CakeEmail('sendgrid');
        //$Email2cpxadmin = new CakeEmail('gmail');
    	
        $Email2cpxadmin->from($data['email'],'CentralPropertyExchange.com.au');
    	
        $Email2cpxadmin->to($to_contact_str);
        $Email2cpxadmin->cc('contact@centralpropertyexchange.com.au','CPx Admin');
        //$Email2cpxadmin->to("vhoraparvez@gmail.com");
        //$Email2cpxadmin->cc("irshadahmed.ansari@gmail.com");
        
    	$Email2cpxadmin->subject($data['subject']);
    	$Email2cpxadmin->template('buythisproperty');
    	$Email2cpxadmin->viewVars(array('data' => $data));
    	$Email2cpxadmin->emailFormat('html');

//echo json_encode($data);
//die;
      
  		if(isset($data['subject'])){
    			$Email2cpxadmin->send();
    		//echo "Sent To Admin";
         //   echo "1";die;   
    		}
     //   echo "0"; die;       
    	//********* EMAIL TO CPx ADMIN END *********\\
        
        $m1->close();     
    } 
    
    
    public function buythisproperty() {
    	
    	$this->RequestHandler->addInputType('json', array('json_decode', true));
    	$data = $this->request->data;
        
//echo json_encode($data);
//die;
        
    	$this->send_buythisproperty_request($data);
    }
}
?>/