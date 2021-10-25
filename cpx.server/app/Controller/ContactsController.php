<?php 
App::uses('CakeEmail', 'Network/Email');

use Cake\Mailer\Email;

class ContactsController extends AppController {
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
    
    
   /*  public function add() {
    	
    	
    	$this->RequestHandler->addInputType('json', array('json_decode', true));
    	$data = $this->request->data;
    	print_r ($data);
    	ini_set('display_errors', 'On');
    	$to = 'contact@centralpropertyexchange.com';
    	
    	//$to ="testingp888@gmail.com";
		
		
    	$subject =$data['dummysubject'];
    	$txt = "Hello CPx Admin,<br>You have received a new enquiry.<br><br>Name: ".$data['name']."
					<br>
					Email address: ".$data['email']."
					<br>
					Subject: ".$data['subject']."
					<br>
					Message: ".nl2br($data['message'])."";
    	
    	// Always set content-type when sending HTML email
    	$headers = "MIME-Version: 1.0" . "\r\n";
    	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    	
    	// More headers
    	$headers .= "From: contact@centralpropertyexchange.com" . "\r\n";
    	//$headers .= "CC: contact@centralpropertyexchange.com" . "\r\n";
    	

    	if(mail($to,$subject,$txt,$headers)){
    		 $content = array('success' => true);
	    	 $output = array(
	    	 		"status" => "OK",
	    	 		"message" => "Message sent successfully",
	    	 		"content" => $content
	    	 );
    	}else{
    		$content = array('success' => false);
	    	 $output = array(
	    	 		"status" => "FAILED",
	    	 		"message" => "Message not sent.",
	    	 		"content" => $content
	    	 );
    	}
    	 
    	 $this->set($output);
    	 $this->set("_serialize", array("status", "message", "content"));
    	 
    	 
    	 
    	 $this->RequestHandler->renderAs($this, 'json');
    } */
    
 public function add($data) {
    	
    	
    
    	$apiurl = Configure::read('API_URL');
    	$weburl = Configure::read('WEB_URL');
    	
    	$data['apiurl'] = $apiurl;
    	$data['weburl'] = $weburl;
    	 
    	print_r($data);
    	 
    	 
    	//********* EMAIL TO CPx ADMIN *********\\
    	
    	$Email2cpxadmin = new CakeEmail('sendgrid');
    	$Email2cpxadmin->from(array('contact@centralpropertyexchange.com' => 'CentralPropertyExchange.com.au'));
    	//$Email2cpxadmin->to('contact@centralpropertyexchange.com');
    	$Email2cpxadmin->to('django@mailinator.com');
    	$Email2cpxadmin->subject($data['dummysubject']);
    	$Email2cpxadmin->template('commontemp');
    	$Email2cpxadmin->viewVars(array('data' => $data));
    	$Email2cpxadmin->emailFormat('html');
    	$Email2cpxadmin->send();
    	//********* EMAIL TO CPx ADMIN END *********\\
    	 
    	 
    }
    

    public function index() {
    	
    	$this->RequestHandler->addInputType('json', array('json_decode', true));
    	$data = $this->request->data;
    	
    	echo "Within index";
    
    	$this->add($data);
    }
    
}
?>