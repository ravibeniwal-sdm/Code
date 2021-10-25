<?php 
App::uses('CakeEmail', 'Network/Email');

use Cake\Mailer\Email;


error_reporting(0);

define ( "SENGRID_SMTP", "sendgrid" );
//define ( "SENGRID_SMTP", "../../parsedDatafiles" );

class SharewithemailController extends AppController {
    
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
    	 
    	//echo "within add";
    	
    	//print_r($data);
    	
    	
    	$apiurl = Configure::read('API_URL');
    	$weburl = Configure::read('WEB_URL');
    	 
    	$data['apiurl'] = $apiurl;
    	$data['weburl'] = $weburl;
    	
    	//print_r($data);
    	
    	
    	//********* EMAIL TO CPx ADMIN *********\\
    	 
    	$sharewithemail = new CakeEmail('sendgrid');
    	$sharewithemail->from(array('contact@centralpropertyexchange.com.au' => 'CentralPropertyExchange.com.au'));
    	$sharewithemail->to($data['toemail']);
    	
    	$sharewithemail->subject($data['subject']);
    	$sharewithemail->template('sharewithemailtemp');
    	$sharewithemail->viewVars(array('data' => $data));
    	$sharewithemail->emailFormat('html');
    		if(isset($data['toemail'])){
    			$sharewithemail->send();
    		//echo "Sent To Admin";
    		}
    	//********* EMAIL TO CPx ADMIN END *********\\
    } 
  
    
   
    public function index() {
    	
    	$this->RequestHandler->addInputType('json', array('json_decode', true));
    	$data = $this->request->data;
    
    	//echo "Within index";
    
    	$this->add($data);
    	 
    	 
    }
    
}
?>