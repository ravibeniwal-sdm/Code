<?php 
App::uses('CakeEmail', 'Network/Email');

use Cake\Mailer\Email;


error_reporting(0);

define ( "SENGRID_SMTP", "sendgrid" );
//define ( "SENGRID_SMTP", "../../parsedDatafiles" );

class RequestiprController extends AppController {
    
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
    	$query = http_build_query(array('cluster' => $data));
    	
    	
    	
    	$data['query'] = $query;
    	
    	$apiurl = Configure::read('API_URL');
    	$weburl = Configure::read('WEB_URL');
    	 
    	$data['apiurl'] = $apiurl;
    	$data['weburl'] = $weburl;
    	
  
  
//print_r ($data);
//die;    
    	
    	
    	//********* EMAIL TO CPx ADMIN *********\\
    	 
    	$Email2cpxadmin = new CakeEmail('sendgrid');
        //$Email2cpxadmin = new CakeEmail('gmail');
                        
    	$Email2cpxadmin->from(array('contact@centralpropertyexchange.com.au' => 'CentralPropertyExchange.com.au'));
    	
        $Email2cpxadmin->to('contact@centralpropertyexchange.com.au');
    	//$Email2cpxadmin->to("irshadahmed.ansari@gmail.com");
                
    	$Email2cpxadmin->subject($data['requestformsubject']);
    	$Email2cpxadmin->template('adminrequestipr');
    	$Email2cpxadmin->viewVars(array('data' => $data));
    	$Email2cpxadmin->emailFormat('html');
		    if(isset($data['email']) || isset($data['name'])){
		    	$Email2cpxadmin->send();
		    	//echo "Sent To Admin";
		    }
    	//********* EMAIL TO CPx ADMIN END *********\\
    	

    	//********* EMAIL TO SUBMITTER *********\\
    	$Email2submitter = new CakeEmail('sendgrid');
        //$Email2submitter = new CakeEmail('gmail');
                        
    	$Email2submitter->from(array('contact@centralpropertyexchange.com.au' => 'CentralPropertyExchange.com.au'));
    	$Email2submitter->subject($data['requestformsubject']);
    	$Email2submitter->template('submitterrequestipr');
    	$Email2submitter->viewVars(array('data' => $data));
    	$Email2submitter->emailFormat('html');

    	if (isset($data['email'])){
    		$Email2submitter->to($data['email']);
            //$Email2submitter->to("irshadahmed.ansari@gmail.com");            
    		$Email2submitter->send();
    		//echo "sent to:" .$data['email'];
    	}
    		else{
    			//echo "not sent to Submitter";
    		}
    	
    	//********* EMAIL TO SUBMITTER END *********\\
   	
    	$max= sizeOf($data['emailRecipients']);
    	
    	//********* EMAIL TO AGENT/OWNER *********\\
    	$Email2owner = new CakeEmail('sendgrid');
        //$Email2owner = new CakeEmail('gmail');
                        
    	$Email2owner->from(array('contact@centralpropertyexchange.com.au' => 'CentralPropertyExchange.com.au'));
        $Email2owner->cc('contact@centralpropertyexchange.com.au','CPx Admin');
        
    	$Email2owner->subject($data['requestformsubject']);
    	$Email2owner->template('ownerrequestipr');
    	$Email2owner->viewVars(array('data' => $data));
    	$Email2owner->emailFormat('html');
        
    	if($max!=0){
    		$Email2owner->to($data['emailRecipients'][0]['label']);
            //$Email2owner->to("irshad_ahmed_ansari@hotmail.com");
                                    
    		if($max>=2){
    			for($r = 1; $r < $max; $r ++) {
    				$Email2owner->addTo($data['emailRecipients'][$r]['label']);
                    //$Email2owner->addTo("irshadahmed.ansari@gmail.com");
    			}
    		}
    		$Email2owner->send();
    	}
    	else{
    		//echo "NOT SENT TO AGENT/OWNER";
    	}
    	
    	//********* EMAIL TO AGENT/OWNER END *********\\
    	
    
    
    	
    } 
    
     
    
    public function acceptrequest() {
    	//echo phpinfo();
    	
    	$apiurl = Configure::read('API_URL');
    	$weburl = Configure::read('WEB_URL');
    	
    	
    	$formdata = $_GET["cluster"];
    	//print_r($_GET["cluster"]) ;
    	$formdata['apiurl'] = $apiurl;
    	$formdata['weburl'] = $weburl;
    	
    	$max= sizeOf($formdata['emailRecipients']);
    	
    	$dd = $_GET["query"];
    	parse_str($dd, $get_array);

    	$formdata['propertyid'] = $get_array['cluster']['propertyid'];
    	
    	
    	//print_r($formdata);
    	//echo $formdata['propertyid'];
    	//die;
    	
    	//$submitteremail = $_GET["senderemail"]; 
    	
    	
    	//********* EMAIL FROM SUBMITTER [YES] *********\\
    	 
    	$Emailresponseyes = new CakeEmail('sendgrid');
        //$Emailresponseyes = new CakeEmail('gmail');
        
    	$Emailresponseyes->from(array('contact@centralpropertyexchange.com.au' => 'CentralPropertyExchange.com.au'));
    	
    	
    	$Emailresponseyes->to($formdata['email']);
        //$Emailresponseyes->to('irshadahmed.ansari@gmail.com');
    	
    	
    	
    	$Emailresponseyes->cc('contact@centralpropertyexchange.com.au','CPx Admin');
        //$Emailresponseyes->cc('irshadahmed.ansari@gmail.com');        
    	
    	if($max!=0){
			for($r = 0; $r < $max; $r ++) {
				$Emailresponseyes->addTo($formdata['emailRecipients'][$r]['label']);
                //$Emailresponseyes->addTo("irshadahmed.ansari@gmail.com");
			}
    	}
    	
    	 
    	
    	$Emailresponseyes->subject('Request for ipr and grade report on your CPx listed property');
    	$Emailresponseyes->template('responseyes');
    	$Emailresponseyes->viewVars(array('formdata' => $formdata));
    	$Emailresponseyes->emailFormat('html');
    	$Emailresponseyes->send();
    	//********* EMAIL FROM SUBMITTER END *********\\
    	
    	//$this->set('formdata', $formdata);
    	
    	
    }
    
    public function rejectrequest() {
    	//echo phpinfo();
    
    
    	$formdata = $_GET["cluster"];
    	//print_r($_GET["cluster"]) ;
    	
    	$apiurl = Configure::read('API_URL');
    	$weburl = Configure::read('WEB_URL');
    	
    	
    	$formdata = $_GET["cluster"];
    	//print_r($_GET["cluster"]) ;
    	$formdata['apiurl'] = $apiurl;
    	$formdata['weburl'] = $weburl;
    	
    	$max= sizeOf($formdata['emailRecipients']);
    	
    	$dd = $_GET["query"];
    	parse_str($dd, $get_array);

    	$formdata['propertyid'] = $get_array['cluster']['propertyid'];
    	
    	print_r($formdata);
    	//echo $formdata['propertyid'];
    	 
    	
    	
    	//********* EMAIL FROM SUBMITTER [NO] *********\\
    
    	$Emailresponseno = new CakeEmail('sendgrid');
        //$Emailresponseno = new CakeEmail('gmail');
        
    	$Emailresponseno->from(array('contact@centralpropertyexchange.com.au' => 'CentralPropertyExchange.com.au'));
        
    	$Emailresponseno->to($formdata['email']);
    	//$Emailresponseno->to('irshadahmed.ansari@gmail.com');
    	
    	$Emailresponseno->cc('contact@centralpropertyexchange.com.au','CPx Admin');
        //$Emailresponseno->cc('irshadahmed.ansari@gmail.com');        
    	 
    	if($max!=0){
			for($r = 0; $r < $max; $r ++) {
				$Emailresponseno->addTo($formdata['emailRecipients'][$r]['label']);
                //$Emailresponseno->addTo("irshadahmed.ansari@gmail.com");
			}
    	}
    	
        
    	$Emailresponseno->subject('Request for ipr and grade report on your CPx listed property');
    	$Emailresponseno->template('responseno');
    	$Emailresponseno->viewVars(array('formdata' => $formdata));
    	$Emailresponseno->emailFormat('html');
    	$Emailresponseno->send();
    	//********* EMAIL FROM SUBMITTER END *********\\
    	
       
    }
    
   
    public function index() {
    	
    	$this->RequestHandler->addInputType('json', array('json_decode', true));
    	$data = $this->request->data;
    
//echo json_encode($data);
  
    
    	$this->add($data);
    	 
    	 
    }
    
    public function testmail($data) 
    {

        $Email2cpxadmin = new CakeEmail('gmail');
                        
    	$Email2cpxadmin->from(array('contact@centralpropertyexchange.com.au' => 'CentralPropertyExchange.com.au'));
    	
    	$Email2cpxadmin->to("irshadahmed.ansari@gmail.com");
                
    	$Email2cpxadmin->subject("test cron");
    	$Email2cpxadmin->template('commontemp');
    	
    	$Email2cpxadmin->emailFormat('html');
        
        $Email2cpxadmin->send();
        
        die('check mail for testing cron');
    } 
        
}
?>