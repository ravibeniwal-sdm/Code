<?php 
App::uses('CakeEmail', 'Network/Email');

use Cake\Mailer\Email;

//error_reporting(0);
define ( "SENGRID_SMTP", "sendgrid" );

require '../Vendor/socialmedia/facebook/autoload.php';

require '../Vendor/socialmedia/googleplus/apiClient.php';
require '../Vendor/socialmedia/googleplus/contrib/apiOauth2Service.php';

require_once '../Vendor/socialmedia/linkedin/http.php';
require_once '../Vendor/socialmedia/linkedin/oauth_client.php';

use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;



/**
 * AuthController
 * 
 * @package cpx.server
 * @author Ahmet YUCEL
 * @copyright 2017
 * @version $Id$
 * @access public
 */
class AuthController extends AppController {
    
    public $helpers = array('Session', 'Html', 'Form');
	public $components = array('Session','RequestHandler');
	
    public function beforeFilter() {
		parent::beforeFilter();
		$this->response->header('Access-Control-Allow-Origin','*');
		$this->response->header('Access-Control-Allow-Methods','*');
		$this->response->header('Access-Control-Allow-Headers','X-Requested-With');
		$this->response->header('Access-Control-Allow-Headers','Content-Type, x-xsrf-token');
		$this->response->header('Access-Control-Max-Age','172800');
	}
    
	private function db_conn($publishers=false,$user_email_links=false,$properties=false)
    {
        $serUrl = Configure::read('CONNECT_SER');
			
		$m1 = new MongoClient($serUrl);
		
		// select a database
		$db2 = $m1->properties;
		
        if($publishers)
            $collection = $m1->$db2->publishers;
        elseif($user_email_links)
            $collection = $m1->$db2->user_email_links;
        elseif($properties)
            $collection = $m1->$db2->realprop;             
        else            
            $collection = $m1->$db2->users;
        
        $m1->close();
        
        return $collection;
    }
    
    public function ajax_session_expired($cnt = null,$act = null, $parm = null){
        $url = Router::url(array('controller' => $cnt, 'action' => $act, 'admin' => $parm));
        $ajax_output= 'SESSION_EXPIRED|'.$url;
        $data['0'] = $ajax_output; 
        $this->set('data', $data);
        $this->render ( '/Elements/ajaxreturn', 'admin_ajax' );
    }
    
    public function adduser() {
    	
    	//echo "in add user";exit;
           
        
        $this->layout = null ;
	
        $collection = $this->db_conn();
        
        $password = md5("admin123");
        
        $userdata = array("id"=>"1","username"=>"anthony@landlordcentral.com.au","password"=>$password,"firstname"=>"Anthony","lastname"=>"Aoun","email"=>"anthony@landlordcentral.com.au","type"=>"superadmin","status"=>"active");
        
        //echo "<pre>";print_r($userdata);exit;
                
        $collection->insert ( $userdata, array (
										"safe" => true
								) );
        
        exit;  
    }
    
    public function register()
    {
        $this->layout = null ;
	
        if(!empty($this->data))
        {
            $collection_publisher = $this->db_conn(true);
            
            $collection_user = $this->db_conn();
            
            $register['username'] =  $this->data['email'];
            $newquery = $register;
            
            
            $cursor1 = $collection_user->find ($newquery);
            
            $userExist = array ();
            foreach ( $cursor1 as $result ) {
                array_push ( $userExist, $result );
            }
            
            if(empty($userExist))
            {
                
                $cursor1 = $collection_publisher->find ($newquery);
            
                $publisherExist = array ();
                foreach ( $cursor1 as $result ) {
                    array_push ( $publisherExist, $result );
                }
                
                $user_type = 'user';
                if(!empty($publisherExist))
                    $user_type = 'publisher';
                
                $foundLastRecord = $collection_user->find()->sort(array("_id" => -1))->limit(1);
                $lastRecordArr = array ();
                foreach ( $foundLastRecord as $result ) {
                    array_push ( $lastRecordArr, $result );
                } 
    
                if(!empty($lastRecordArr))
                    $nextID = $lastRecordArr['0']['id']+1;
                else
                    $nextID = 1;
    
                $userdata['id'] = "$nextID";
                $userdata['username'] = $this->data['email'];
                $userdata['password'] = md5($this->data['password']);
                $userdata['firstname'] = $this->data['firstname'];
                $userdata['email'] = $this->data['email'];
                
                if(!empty($this->data['lastname']))
                    $userdata['lastname'] = $this->data['lastname'];
                
                if(!empty($this->data['phone_number']))
                    $userdata['phone_number'] = $this->data['phone_number'];
                
                if(!empty($this->data['company_name']))    
                    $userdata['company_name'] = $this->data['company_name'];
                    
                $userdata['type'] = $user_type;
                $userdata['status'] = "inactive";
                                
                $token = sha1(substr(uniqid(rand(), true), 12, 12));
                $userdata['verification_token'] = $token;
                
                $curr_date = date('Y m d h:i:s');
                
                $tmp_date = explode(' ',$curr_date);
                $tmp_time = explode(':',$tmp_date['3']);
                                                                
                $userdata['registration_timestamp'] = mktime($tmp_time['0'],$tmp_time['1'],$tmp_time['2'],$tmp_date['1'],$tmp_date['2'],$tmp_date['0']);
                                

//echo "<br>currdate==>".$curr_date;
//echo '<br>mktime==>'.date('d M Y h:i:s', $userdata['registration_timestamp'] );
//echo "<pre>tmp_dte";print_r($tmp_date);
//echo "<pre>tmp_time";print_r($tmp_time);
//echo "<pre>";
//print_r($this->data);
//print_r($userdata);
//echo "</pre>";
//die;
                        
                $collection_user->insert ( $userdata, array (
        										"safe" => true
        								) );
                
                
                $verificationLink = ADMIN_PATH . 'auth/verify_user/' . $token;
                
                $email = $this->data['email'];
                $firstname = $this->data['firstname'];
                
                $data['email'] = $email;
                $data['firstname'] = $firstname;
                $data['verificationLink'] = $verificationLink;

//echo "<pre>";
//print_r($data);
//print_r($userdata);
//echo "</pre>";
                
                //********* EMAIL TO CPx ADMIN *********\\
                
                $Email2registration = new CakeEmail('sendgrid');
                //$Email2registration = new CakeEmail('gmail');
                
                $Email2registration->from(array('contact@centralpropertyexchange.com.au' => 'CentralPropertyExchange.com.au'));
                $Email2registration->to($email);
                
                
                $Email2registration->subject("Registration");
                $Email2registration->template('registration');
                $Email2registration->viewVars(array('data' => $data));
                $Email2registration->emailFormat('html');
                
                $Email2registration->send();
   
                
                
                $this->layout = null ;
        
                $newarray ["message"] = 'An email has been sent to your email address';
                $newarray ["message_type"] = 'success';
                $lomeJSON = json_encode ( $newarray);
        		$newarray = array();
        		$newarray[0] = $lomeJSON;
                $this->render_json($newarray);  
                
                //exit; 

                
            }
            else
            {
                if($userExist[0]['status']=='inactive')
                {
                    $verification_token = sha1(substr(uniqid(rand(), true), 12, 12));
                        
                    $password = $this->generate_password();
                    
                    $curr_date = date('Y m d h:i:s');
                    
                    $tmp_date = explode(' ',$curr_date);
                    $tmp_time = explode(':',$tmp_date['3']);
                                                                    
                    $registration_timestamp = mktime($tmp_time['0'],$tmp_time['1'],$tmp_time['2'],$tmp_date['1'],$tmp_date['2'],$tmp_date['0']);
                    
                    $retval = $collection_user->findAndModify ( $newquery, array (
                    								'$set' => array (
                    										"verification_token" => $verification_token,
                                                            "registration_timestamp" => $registration_timestamp,
                                                            "password" => md5($password), 
                                                           
                    								)
                    					
                    						));
                    
                    
                    
                    $verificationLink = ADMIN_PATH . 'auth/verify_user/' . $verification_token;
                               
                    $email = $userExist[0]['username'];
                    
                    $userType = $userExist[0]['type'];
                    
                    $data['email'] = $email;
                    $data['link'] = $verificationLink;
                    $data['password'] = $password;
                    $data['user_type'] = $userType;
                    
                    $subject = 'Request to verify CPx account';
                    $template = 'unverified_user';
                    
                    //********* EMAIL TO CPx ADMIN *********\\
                    
                    $Email2registration_verified = new CakeEmail('sendgrid');
                    //$Email2registration_verified = new CakeEmail('gmail');
                                            
                    $Email2registration_verified->from(array('admin@centralpropertyexchange.com.au' => 'CPx Admin'));
                    $Email2registration_verified->to($email);
                    //$Email2registration_verified->to('irshadahmed.ansari@gmail.com');
                    
                    
                    $Email2registration_verified->subject($subject);
                    $Email2registration_verified->template($template);
                    $Email2registration_verified->viewVars(array('data' => $data));
                    $Email2registration_verified->emailFormat('html');
                    
                    $Email2registration_verified->send();
                    
                    
                    $this->layout = null ;
        
                    $newarray ["message"] = 'User is Inactive. Email is sent to activate account and change password.';
                    $newarray ["message_type"] = 'danger';
                    $lomeJSON = json_encode ( $newarray);
            		$newarray = array();
            		$newarray[0] = $lomeJSON;
                    $this->render_json($newarray);  
                }
                elseif($userExist[0]['status']=='active')
                {
                
                    $this->layout = null ;
            
                    $newarray ["message"] = 'User already exists';
                    $newarray ["message_type"] = 'danger';
                    $lomeJSON = json_encode ( $newarray);
            		$newarray = array();
            		$newarray[0] = $lomeJSON;
                    $this->render_json($newarray);  
                 
                    //exit;  
                }  
            }           
        } 
        
    }
    
    function render_json($fhf){
		$this->set('data', $fhf);
		$this->render('../Elements/ajaxreturn');
		
	}
    
    public function verify_user($token)
    {
        $collection_user = $this->db_conn();
        
        $verify['verification_token'] =  $token;
        
        $newquery = $verify;
        
        
        $cursor1 = $collection_user->find ($newquery);
        
        $tokenExist = array ();
        foreach ( $cursor1 as $result ) {
            array_push ( $tokenExist, $result );
        }
        
              
        if(!empty($tokenExist['0']))
        {
            $tokenExist = $tokenExist['0'];
            
            $registration_timestamp = $tokenExist['registration_timestamp'];
            
            $cDate = strtotime(date('Y-m-d H:i:s'));

            // Getting the value of old date + 24 hours
            $registrationDateAfterOneDay = $registration_timestamp + 86400; // 86400 seconds in 24 hrs

//echo "<pre>";
//print_r($tokenExist);
//echo "</pre>";
//
//echo "<br>registration timestamp==>".$registration_timestamp;
//echo "<br>current timestamp==>".$cDate;
//echo "<br>registration dte==>".$registrationDate;

            
            if($registrationDateAfterOneDay > $cDate)
            {
            
  
                $retval = $collection_user->findAndModify ( $newquery, array (
    											'$set' => array (
    													"verification_token" => '',
                                                        "status" => 'active',
                                                        
    											)
    								
    									));
                
                
                
                $link = ADMIN_PATH . '/auth/login/';
                $email = $tokenExist['username'];
                $firstname = $tokenExist['firstname'];
                
                
                $data['email'] = $email;
                $data['link'] = $link;
                $data['firstname'] = $firstname;
                
                //********* EMAIL TO CPx ADMIN *********\\
                
                $Email2registration_verified = new CakeEmail('sendgrid');
                //$Email2registration_verified = new CakeEmail('gmail');
                                        
                $Email2registration_verified->from(array('contact@centralpropertyexchange.com.au' => 'CentralPropertyExchange.com.au'));
                $Email2registration_verified->to($email);
                //$Email2registration_verified->to('irshadahmed.ansari@gmail.com');
                
                $Email2registration_verified->subject("Registration Verified");
                $Email2registration_verified->template('registration_verified');
                $Email2registration_verified->viewVars(array('data' => $data));
                $Email2registration_verified->emailFormat('html');
                
                $Email2registration_verified->send();
                
                $this->Session->setFlash('Your account has been verified. You can login to your account.', 'success');
                $this->redirect(array("controller" => "auth", "action" => "login"));
                
                exit; 
            }
            else
            {                
                $this->Session->setFlash('Your verification token has been expired.', 'error');   
                $this->redirect(array("controller" => "auth", "action" => "login"));      
            } 
            
        }
        else
        {                
            $this->Session->setFlash('No user with such verification token is found. Please click again on verify button in mail.', 'error');   
            $this->redirect(array("controller" => "auth", "action" => "login"));      
        } 
    }
    
    public function welcome_user($option,$user_id)
    {
        $collection_user = $this->db_conn();
        
        $verify['id'] =  $user_id;
        
        $newquery = $verify;
        
        
        $cursor1 = $collection_user->find ($newquery);
        
        $userExist = array ();
        foreach ( $cursor1 as $result ) {
            array_push ( $userExist, $result );
        }
        
              
        if(!empty($userExist['0']))
        {
            $userExist = $userExist['0'];
            
            $verification_token = sha1(substr(uniqid(rand(), true), 12, 12));
            
            $password = $this->generate_password();
            
            $no_of_invitation_sent = 0;
            if(isset($userExist['no_of_invitation_sent']) && !empty($userExist['no_of_invitation_sent']))
                $no_of_invitation_sent = $userExist['no_of_invitation_sent'];
            
            $curr_date = date('Y m d h:i:s');
            
            $tmp_date = explode(' ',$curr_date);
            $tmp_time = explode(':',$tmp_date['3']);
                                                            
            $registration_timestamp = mktime($tmp_time['0'],$tmp_time['1'],$tmp_time['2'],$tmp_date['1'],$tmp_date['2'],$tmp_date['0']);

            $retval = $collection_user->findAndModify ( $newquery, array (
											'$set' => array (
													"verification_token" => $verification_token,
                                                    "registration_timestamp" => $registration_timestamp,
                                                    "password" => md5($password), 
                                                    "no_of_invitation_sent" => ($no_of_invitation_sent + 1), 
											)
								
									));
            
            
            
            $verificationLink = ADMIN_PATH . 'auth/verify_user/' . $verification_token;
            
            $properties_link = WEB_PATH . '#!/' . $userExist['username'];
                       
            $email = $userExist['username'];
            
            $userType = $userExist['type'];
            
            $data['email'] = $email;
            $data['link'] = $verificationLink;
            $data['password'] = $password;
            $data['properties_link'] = $properties_link;
            $data['user_type'] = $userType;
            
            if($option == 'welcome')
            {
                $subject = 'Welcome to CPx for the management of published properties';
                $template = 'welcome_user';
                $message = 'A welcome mail has been sent to the user.';
            }
            elseif($option == 'resend')
            {
                $subject = 'CPx account - verify your email registration with CPx';
                $template = 'resend_verification';
                $message = 'A verification mail has been sent to the user.';
            }
            
            //********* EMAIL TO CPx ADMIN *********\\
            
            $Email2registration_verified = new CakeEmail('sendgrid');
            //$Email2registration_verified = new CakeEmail('gmail');
                                    
            $Email2registration_verified->from(array('admin@centralpropertyexchange.com.au' => 'CPx Admin'));
            $Email2registration_verified->to($email);
            //$Email2registration_verified->to('irshadahmed.ansari@gmail.com');
            
            
            $Email2registration_verified->subject($subject);
            $Email2registration_verified->template($template);
            $Email2registration_verified->viewVars(array('data' => $data));
            $Email2registration_verified->emailFormat('html');
            
            $Email2registration_verified->send();
            
            $this->Session->setFlash($message, 'success');
            $this->redirect(array("controller" => "accountholders", "action" => "index"));
            
            exit; 
        }
        else
        {                
            $this->Session->setFlash('No such user exist.', 'error');   
            $this->redirect(array("controller" => "accountholders", "action" => "index"));
        } 
    }
    
    public function forgot_password() {
    	
    	   
        //$this->layout = 'ajax';
        $this->layout = 'login' ; 
        // $this->load->view('login');
        // echo "in controller";exit;
        
        // $logedinuser = $this->Session->read('User');
         //echo "<pre>"; print_r($_REQUEST);echo "</pre>";die;
        
        $this->set('redirect', '');
        if(isset($_REQUEST['calling_from']) && ($_REQUEST['calling_from'] == 'wb'))
            $this->set('redirect', 'web');
                   
        if(!empty($this->data))
        {
            
            if(!$this->verifyRecatpcha($this->request->data))
            {   
                $this->Session->setFlash('Captcha incorrect.', 'error');
                $this->redirect(array("controller" => "auth", "action" => "forgot_password"));
            }
                        
           // echo "<pre>";
           // print_r($this->data);
          //  echo "</pre>";
            
            $collection = $this->db_conn();
            
            $auth = array();
            $auth['username'] =  $this->data['email'];
            //$auth['password'] =  md5($this->data['password']);
            $newquery = $auth;
        
        
            $cursor1 = $collection->find ($newquery);
            
        	$userExist = array ();
        	foreach ( $cursor1 as $result ) {
        	     array_push ( $userExist, $result );
        	}
         
            if(!empty($userExist))
            {
                //echo "<pre>"; print_r($userExist);echo "</pre>";exit;
                if($userExist[0]['status']=='active')
                {
                    $token = sha1(substr(uniqid(rand(), true), 12, 12));
                    $userId = $userExist[0]['id'];
                    $encodedId = base64_encode(convert_uuencode($userId));
                    //echo $token;
                    //echo "<br>".$encodedId;
                    //$collection = $this->db_conn();
                
                    $retval = $collection->findAndModify ( $newquery, array (
                								'$set' => array (
                										"token" => $token,
                								)
                					
                						));
                   $activationLink = ADMIN_PATH . '/auth/reset_password/' . $encodedId . '/' . $token;
                   $fullName = (!empty($userExist[0]['lastname']))?ucfirst($userExist[0]['firstname'] . ' ' . $userExist[0]['lastname']):ucfirst($userExist[0]['firstname']);
                   $email = $userExist[0]['username'];
                   //$email = "vhoraparvez@gmail.com";
                   
                   $replaceWith = array($fullName, $activationLink);
                   $data['fullName'] = $fullName;
                   $data['activationLink'] = $activationLink;
                   
                   //********* EMAIL TO CPx ADMIN *********\\
                
                	$Email2resetpassword = new CakeEmail('sendgrid');
                                                        
                	$Email2resetpassword->from(array('contact@centralpropertyexchange.com.au' => 'CentralPropertyExchange.com.au'));
                	$Email2resetpassword->to($email);
                	//$Email2resetpassword->to("irshadahmed.ansari@gmail.com");
                            
                	$Email2resetpassword->subject("Reset Password link");
                	$Email2resetpassword->template('resetpassword');
                	$Email2resetpassword->viewVars(array('data' => $data));
                	$Email2resetpassword->emailFormat('html');
                	   
                	$Email2resetpassword->send();
                	
                    $this->Session->setFlash('An email has been sent to your email address.', 'success');
                    $this->redirect(array("controller" => "auth", "action" => "login"));
                    
                    exit; 
                    
                }
                elseif($userExist[0]['status']=='inactive')
                {
                 
                    $verification_token = sha1(substr(uniqid(rand(), true), 12, 12));
                    
                    $password = $this->generate_password();
                    
                    $curr_date = date('Y m d h:i:s');
                    
                    $tmp_date = explode(' ',$curr_date);
                    $tmp_time = explode(':',$tmp_date['3']);
                                                                    
                    $registration_timestamp = mktime($tmp_time['0'],$tmp_time['1'],$tmp_time['2'],$tmp_date['1'],$tmp_date['2'],$tmp_date['0']);
                    
                    $retval = $collection->findAndModify ( $newquery, array (
                    								'$set' => array (
                    										"verification_token" => $verification_token,
                                                            "registration_timestamp" => $registration_timestamp,
                                                            "password" => md5($password), 
                                                           
                    								)
                    					
                    						));
                    
                    
                    
                    $verificationLink = ADMIN_PATH . 'auth/verify_user/' . $verification_token;
                               
                    $email = $userExist[0]['username'];
                    
                    $userType = $userExist[0]['type'];
                    
                    $data['email'] = $email;
                    $data['link'] = $verificationLink;
                    $data['password'] = $password;
                    $data['user_type'] = $userType;
                    
                    $subject = 'Request to verify CPx account';
                    $template = 'unverified_user';
                    
                    //********* EMAIL TO CPx ADMIN *********\\
                    
                    $Email2registration_verified = new CakeEmail('sendgrid');
                    //$Email2registration_verified = new CakeEmail('gmail');
                                            
                    $Email2registration_verified->from(array('admin@centralpropertyexchange.com.au' => 'CPx Admin'));
                    $Email2registration_verified->to($email);
                    //$Email2registration_verified->to('irshadahmed.ansari@gmail.com');
                    
                    
                    $Email2registration_verified->subject($subject);
                    $Email2registration_verified->template($template);
                    $Email2registration_verified->viewVars(array('data' => $data));
                    $Email2registration_verified->emailFormat('html');
                    
                    $Email2registration_verified->send();
                    
                    $this->Session->setFlash('User is Inactive. Email is sent to activate account and change password.', 'error');
                    $this->redirect(array("controller" => "auth", "action" => "login"));
                    
                    exit; 
               }
            }
            else
            {
                $this->Session->setFlash('No user found.', 'error');    
            }           
        }  
    }
    
        
   
    public function login() 
    {

        $this->layout = 'login' ; 
        
        if(!empty($this->data))
        {
        
            $collection = $this->db_conn();
            
            $auth['username'] =  $this->data['username'];
            $auth['password'] =  md5($this->data['password']);
            $newquery = $auth;
            
            
            $cursor1 = $collection->find ($newquery);
            
            $userExist = array ();
            foreach ( $cursor1 as $result ) {
                array_push ( $userExist, $result );
            }
            if(!empty($userExist))
            {
                $userStatus = $userExist['0']['status'];
                if($userStatus == 'active')
                {
                    if (isset($this->request->data['rememberme']) && $this->request->data['rememberme']) {
                        $passwordr = base64_encode($this->data['password']);
                        $hour = TIME() + 60 * 60 * 24 * 30;
                        SETCOOKIE("EMAIL_COOKIE", $this->data['username'], $hour);
                        SETCOOKIE("PASSWORD_COOKIE", $passwordr, $hour);
                    } else {
                        SETCOOKIE("EMAIL_COOKIE", "", time() - 3600);
                        SETCOOKIE("PASSWORD_COOKIE", "", time() - 3600);
                    }
    
                    
                    $this->Session->write('User', $userExist);
                    
                    if(isset($userExist['0']['system_generated_user']) && $userExist['0']['system_generated_user'])
                        $this->redirect(array("controller" => "auth", "action" => "change_password"));   
                    
                    $this->redirect("/dashboard/");
                }
                else
                {
                    $this->Session->setFlash('Your account is inactive or suspended. Please contact admin.', 'error');
                
                    $this->redirect(array("controller" => "auth", "action" => "login"));
                }
            }
            else
            {
                $this->Session->setFlash('Incorrect e-mail or password.', 'error');
                
                $this->redirect(array("controller" => "auth", "action" => "login"));             
            }           
        }
        elseif (!empty($_COOKIE['EMAIL_COOKIE'])) 
        {

            $this->request->data['username'] = @$_COOKIE['EMAIL_COOKIE'];
            $this->request->data['password'] = base64_decode(@$_COOKIE['PASSWORD_COOKIE']);
            $this->request->data['rememberme'] = 1;
            
            
            $this->set('authInfo',$this->request->data);
        }
        
        //fb login code starts

        if(isset($_GET['provider']) && ($_GET['provider'] == 'facebook'))
            $this->login_with_facebook();        
        
        //fb login code ends
        
        
        //googleplus code starts
        
        if(isset($_GET['provider']) && ($_GET['provider'] == 'googleplus'))
            $this->login_with_googleplus();
        
        //googleplus code ends
        
        
        //linkedin code starts
        
        if(isset($_GET['provider']) && ($_GET['provider'] == 'linkedin'))
            $this->login_with_linkedin();
        
                      
        //linkedin code ends
    }
    
    function login_with_linkedin()
    {
        /*
         * Configuration and setup LinkedIn API
         */
        $apiKey     = IN_API_KEY;
        $apiSecret  = IN_API_SECRET;
        $redirectURL= ADMIN_PATH.'auth/login?provider=linkedin';
        $scope      = 'r_basicprofile r_emailaddress'; //API permissions
        
        
        $authUrl = $output = '';


        if((isset($_GET["oauth_init"]) && $_GET["oauth_init"] == 1) || (isset($_GET['oauth_token']) && isset($_GET['oauth_verifier']))){
            
            $inclient = new oauth_client_class;
            
            $inclient->client_id = $apiKey;
            $inclient->client_secret = $apiSecret;
            $inclient->redirect_uri = $redirectURL;
            $inclient->scope = $scope;
            $inclient->debug = false;
            $inclient->debug_http = true;
            $application_line = __LINE__;
            
            if(strlen($inclient->client_id) == 0 || strlen($inclient->client_secret) == 0){
                die('Please go to LinkedIn Apps page https://www.linkedin.com/secure/developer?newapp= , '.
                    'create an application, and in the line '.$application_line.
                    ' set the client_id to Consumer key and client_secret with Consumer secret. '.
                    'The Callback URL must be '.$inclient->redirect_uri.'. Make sure you enable the '.
                    'necessary permissions to execute the API calls your application needs.');
            }
            
            //If authentication returns success
            if($success = $inclient->Initialize()){
                if(($success = $inclient->Process())){
                    if(strlen($inclient->authorization_error)){
                        $inclient->error = $client->authorization_error;
                        $success = false;
                    }elseif(strlen($inclient->access_token)){
                        $success = $inclient->CallAPI('http://api.linkedin.com/v1/people/~:(id,email-address,first-name,last-name,location,picture-url,public-profile-url,formatted-name)', 
                        'GET',
                        array('format'=>'json'),
                        array('FailOnAccessError'=>true), $userInfo);
                    }
                }
                $success = $inclient->Finalize($success);
            }
            
            if($inclient->exit) exit;
            
            if($success){
                
                //Insert or update user data to the database
                $fname = $userInfo->firstName;
                $lname = $userInfo->lastName;
                $inUserData = array(
                    'oauth_provider'=> 'linkedin',
                    'oauth_uid'     => $userInfo->id,
                    'first_name'    => $fname,
                    'last_name'     => $lname,
                    'email'         => $userInfo->emailAddress,
                );
                
                $inUserData = $this->checkUser($inUserData);
                
                //Storing user data into session
                $_SESSION['inUserData'] = $inUserData;
                $_SESSION['oauth_status'] = 'verified';
                
                $_SESSION['User'] = $inUserData;            
                $this->redirect("/dashboard/"); 
            }
        }
        else
        {           
            $inUrl = '?oauth_init=1&provider=linkedin';
            $this->redirect($inUrl);
        }  
    }
    
    function login_with_googleplus()
    {
        /*
         * Configuration and setup Google API
         */
        $clientId = GP_CLIENT_ID;
        $clientSecret = GP_CLIENT_SECRET;
        $redirectURL= ADMIN_PATH.'auth/login?provider=googleplus';
        
        //Call Google API
        $gClient = new apiClient();
        $gClient->setApplicationName('Login to Googleplus');
        $gClient->setClientId($clientId);
        $gClient->setClientSecret($clientSecret);
        $gClient->setRedirectUri($redirectURL);
        
        $google_oauthV2 = new apiOauth2Service($gClient);
        
        
        if(isset($_GET['code'])){
            $gClient->authenticate($_GET['code']);
            $_SESSION['token'] = $gClient->getAccessToken();
            header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));
        }
        
        if (isset($_SESSION['token'])) {
            $gClient->setAccessToken($_SESSION['token']);
        }
        
        if ($gClient->getAccessToken()) {
            //Get user profile data from google
            $gpUserProfile = $google_oauthV2->userinfo->get();
            
            //Insert or update user data to the database
            $gpUserData = array(
                'oauth_provider'=> 'google',
                'oauth_uid'     => $gpUserProfile['id'],
                'first_name'    => $gpUserProfile['given_name'],
                'last_name'     => $gpUserProfile['family_name'],
                'email'         => $gpUserProfile['email'],
            );
            $gpUserData = $this->checkUser($gpUserData);
            
            //Storing user data into session
            $_SESSION['gpUserData'] = $gpUserData;
            
            $_SESSION['User'] = $gpUserData;            
            $this->redirect("/dashboard/"); 
            
        } else {
            $gpUrl = $gClient->createAuthUrl();
            $gpUrl = filter_var($gpUrl, FILTER_SANITIZE_URL);
            $this->redirect($gpUrl);
        }
    }
    
    function login_with_facebook()
    {
        /*
         * Configuration and setup Facebook SDK
         */
                
        $appId         = FB_APP_ID; //Facebook App ID
        $appSecret     = FB_APP_SECRET; //Facebook App Secret
        $redirectURL= ADMIN_PATH.'auth/login?provider=facebook';
        $fbPermissions = array('email');  //Optional permissions
        
        $fb = new Facebook(array(
            'app_id' => $appId,
            'app_secret' => $appSecret,
            'default_graph_version' => 'v2.2',
        ));

        // Get redirect login helper
        $fbhelper = $fb->getRedirectLoginHelper();
        
        // Try to get access token
        try {
            if(isset($_SESSION['facebook_access_token'])){
                $accessToken = $_SESSION['facebook_access_token'];
            }else{
                $accessToken = $fbhelper->getAccessToken();
            }
        } catch(FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        
        if(isset($accessToken))
        {
            if(isset($_SESSION['facebook_access_token'])){
                $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
            }else{
                // Put short-lived access token in session
                $_SESSION['facebook_access_token'] = (string) $accessToken;
                
                  // OAuth 2.0 client handler helps to manage access tokens
                $oAuth2Client = $fb->getOAuth2Client();
                
                // Exchanges a short-lived access token for a long-lived one
                $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
                $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
                
                // Set default access token to be used in script
                $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
            }
            
            // Redirect the user back to the same page if url has "code" parameter in query string
            if(isset($_GET['code'])){
                header('Location: ./');
            }
            
            // Getting user facebook profile info
            try 
            {
                $profileRequest = $fb->get('/me?fields=name,first_name,last_name,email,link,gender,locale,picture');
                $fbUserProfile = $profileRequest->getGraphNode()->asArray();
            } 
            catch(FacebookResponseException $e) 
            {
                echo 'Graph returned an error: ' . $e->getMessage();
                session_destroy();
                // Redirect user back to app login page
                header("Location: ./");
                exit;
            } 
            catch(FacebookSDKException $e) 
            {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }
            
            // Insert or update user data to the database
            $fbUserData = array(
                'oauth_provider'=> 'facebook',
                'oauth_uid'     => $fbUserProfile['id'],
                'first_name'    => $fbUserProfile['first_name'],
                'last_name'     => $fbUserProfile['last_name'],
                'email'         => $fbUserProfile['email'],
            );
            $fbUserData = $this->checkUser($fbUserData);
            
            // Put user data into session
            $_SESSION['fbuserData'] = $fbUserData;
            
            
            $_SESSION['User'] = $fbUserData;            
            $this->redirect("/dashboard/");                                    
        }
        else
        {
            // Get login url
            $fbloginURL = $fbhelper->getLoginUrl($redirectURL, $fbPermissions);
         
            $this->redirect($fbloginURL);
        }
    }
    
    function checkUser($userData = array()){
        if(!empty($userData))
        {
            // Check whether user data already exists in database
            $collection_publisher = $this->db_conn(true);
            $collection_user = $this->db_conn();
            
            
            $user['username'] = $userData['email'];                                    
            $fetchquery = $user;
            
            
            $cursor1 = $collection_user->find ($fetchquery);
            
            $userExist = array ();
            foreach ( $cursor1 as $result ) {
                array_push ( $userExist, $result );
            }
            
            if(empty($userExist))
            {
                $user['username'] =  $userData['email'];
                $newquery = $user;
            
                $cursor1 = $collection_publisher->find ($newquery);
            
                $publisherExist = array ();
                foreach ( $cursor1 as $result ) {
                    array_push ( $publisherExist, $result );
                }
                
                $user_type = 'user';
                if(!empty($publisherExist))
                    $user_type = 'publisher';
                
                $foundLastRecord = $collection_user->find()->sort(array("_id" => -1))->limit(1);
                $lastRecordArr = array ();
                foreach ( $foundLastRecord as $result ) {
                    array_push ( $lastRecordArr, $result );
                } 
    
                if(!empty($lastRecordArr))
                    $nextID = $lastRecordArr['0']['id']+1;
                else
                    $nextID = 1;
    
                $userdata['id'] = "$nextID";
                $userdata['username'] = $userData['email'];                                                
                $userdata['firstname'] = $userData['first_name'];
                $userdata['lastname'] = $userData['last_name'];
                $userdata['oauth_provider'] = $userData['oauth_provider'];
                $userdata['email'] = $userData['email'];
                $userdata['type'] = $user_type;
                $userdata['status'] = "active";
                
                        
                $collection_user->insert ( $userdata, array (
        										"safe" => true
        								) );
            }
            else
            {
                $userdata = array (

                                    'firstname'=>$userData['first_name'],
                                    'lastname'=>$userData['last_name'],
                                    'username'=>$userData['email'],
                                    
                                    );
                    
                
                $retval = $collection_user->findAndModify ( $fetchquery, array (
    											'$set' => $userdata
    								
    									));                                        
            }
            
            
            $cursor1 = $collection_user->find ($fetchquery);
            
            $userData = array ();
            foreach ( $cursor1 as $result ) {
                array_push ( $userData, $result );
            }
        }
        
        // Return user data
        return $userData;
    }
    
    /*
     * 
     * 
     * @author        Amit Gupta
     * @copyright     smartData Enterprise Inc.
     * @method        admin_reset_password
     * @param         none 
     * @return        void 
     * @since         version 0.0.1
     * @version       0.0.1 
     */

    public function reset_password($userId, $token) {
        $this->set(compact('userId', 'token'));
        $userId = convert_uudecode(base64_decode($userId));
        // Layout
        $this->layout = 'login';
        // Title for layout
        $this->set('title_for_layout', 'Reset Password');
        
            $collection = $this->db_conn();
            
            $auth['id'] =  $userId;
            $auth['token'] =  $token;
            $newquery = $auth;
        
        
            $cursor1 = $collection->find ($newquery);
            $tokenExist = array ();
    		foreach ( $cursor1 as $result ) {
			     array_push ( $tokenExist, $result );
    		}
            
        // check whether the token is still available or has expired
        
        if (!empty($tokenExist)) {
           
            
            if (!empty($this->data)) {
                // Save the new password in the DB and empty the token field value
                $newPassword = md5($this->data['new_password']);
                $token = '';
                echo "<pre>";print_r($this->data); echo "</pre>";
                $retval = $collection->findAndModify ( $newquery, array (
    											'$set' => array (
    													"password" => $newPassword,
                                                        "token"=>$token,
                                                        
    											)
    								
    									));
                
                
                //$this->User->updateAll(array('User.token' => "'" . $token . "'", 'User.password' => "'" . $newPassword . "'"), array('User.id' => $userId));
                $this->Session->setFlash('You have successfully changed your password.', 'success');
                $this->redirect(array("controller" => "auth", "action" => "login"));
            }
        } else {
            $this->Session->setFlash('The token has expired.', 'error');
            $this->redirect(array("controller" => "auth", "action" => "login"));
        }
    }
    
    
    
    
    
    public function change_password()
    {
        $this->layout = 'admin' ; 
        
        $logedinuser = $this->Session->read('User');
        if(empty($logedinuser) && !isset($logedinuser['username']))
        {
            $this->redirect("/auth/login");
        }

//echo "<prE>";
//
//print_r($logedinuser);                        
//echo "</pre>";
//die;
        $collection = $this->db_conn();
        if($logedinuser['0']['type'] != 'superadmin')
        {
            $collection_user_email_links = $this->db_conn(false,true);
            $collection = $this->db_conn();
            
            $checklinkedemail['email'] =  $logedinuser['0']['username'];
            $checklinkedemail['status'] =  'approved';
            
            $newquery = $checklinkedemail;
            
            $cursor1 = $collection_user_email_links->find ($newquery);
            
            $linkedEmailsExist = array ('0'=>array('linked_email'=>$logedinuser['0']['username']));
            
            foreach ( $cursor1 as $result ) {
                array_push ( $linkedEmailsExist, $result );
            }

//echo "<prE>";
//print_r($linkedEmailsExist);                        
//echo "</pre>";
//die;

            $linkedEmailsList = array();
            foreach($linkedEmailsExist as $list)
            {
                $userDetail['username'] =  $list['linked_email'];
                $newquery = $userDetail;
                
                $cursor1 = $collection->find ($newquery);
                
                $fetchUser = array ();
                foreach ( $cursor1 as $result ) {
                    array_push ( $fetchUser, $result );
                }
//echo "<prE>";
//print_r($fetchUser);                        
//echo "</pre>";
                
                if(isset($fetchUser['0']['oauth_provider']) && !empty($fetchUser['0']['oauth_provider']))
                {
                    //do nothing
                }   
                else
                {
                    array_push($linkedEmailsList,$list['linked_email']);
                }                            
                
            }

//echo "<prE>";
//print_r($linkedEmailsList);                        
//echo "</pre>";            
//die;            
            
            $this->set('linkedEmailsList',$linkedEmailsList);
        }
        
        
        $this->set('logedinuser',$logedinuser);
        
        $this->set('page','change_password');
        
        if((!empty($this->data['new_password'])) && (!empty($this->data['confirm_password'])))
        {
//echo "<prE>";
//print_r($this->data);
//print_r($logedinuser);                        
//echo "</pre>";
//die;
            
            $new_password = $this->data['new_password'];
            $confirm_password = $this->data['confirm_password'];
            
            if($confirm_password == $new_password)
            {
                $password_process = true;
                
                $verify = $userFound = array();
                if($logedinuser['0']['type'] == 'superadmin')
                    $verify['username'] =  $logedinuser['0']['username'];
                elseif(isset($this->data['linked_email']) && !empty($this->data['linked_email']))
                    $verify['username'] =  $this->data['linked_email'];
                
                if(!empty($verify))
                {
                    $newquery = $verify;
                    
                    $cursor1 = $collection->find ($newquery);
                    
                    foreach ( $cursor1 as $result ) {
                        array_push ( $userFound, $result );
                    }
                }

//echo "<prE>";
//print_r($userFound);                        
//echo "</pre>";
//die;
                
                if(!empty($userFound['0']))
                {
                    $userFound = $userFound['0'];
                    
                    if(isset($userFound['system_generated_user']) && $userFound['system_generated_user'])
                    {
                        $registration_timestamp = $userFound['registration_timestamp'];
                    
                        $cDate = strtotime(date('Y-m-d H:i:s'));
            
                        // Getting the value of old date + 24 hours
                        $registrationDateAfterOneDay = $registration_timestamp + 86400; // 86400 seconds in 24 hrs
                        
                        if($registrationDateAfterOneDay < $cDate)
                        {
                            $password_process = false;
                            
                            $this->Session->setFlash('Your password has been expired. Please contact admin.', 'error');   
                            $this->redirect(array("controller" => "auth", "action" => "login"));    
                        }
                    }
 
// echo  $password_process;
// die;
                   
                    if($password_process)
                    {
                        $new_password = md5($new_password);
                        
                        $UserId = $logedinuser['0']['id'];
                		$xyz['id'] =  $UserId;
                        $newquery = $xyz; 
            
            //echo $new_password;
//            echo "<prE>";
//            print_r($xyz);                        
//            echo "</pre>";
//            die;
                        
                        $collection = $this->db_conn();
                        
                        $retval = $collection->findAndModify ( $newquery, array (
            											'$set' => array (
            													"password" => $new_password,
                                                                "system_generated_user" => false,
            											)
            								
            									));
                        
                        
                          
                        $this->Session->setFlash('Your password changed successfully.', 'success');
                        $this->redirect("/dashboard/");
                    }
                }
            }
            else
            {
                $this->set('error_msg','New password does not match with confirm password'); 
            }                
        }
        
    }
    
    function check_linked_email_exists($email,$linked_email)
    {
        $collection_user_email_links = $this->db_conn(false,true);
                        
        $linked_user['email'] = $email;   
        $linked_user['linked_email'] = $linked_email  ;
                                  
        $fetchquery = $linked_user;
        
        $cursor1 = $collection_user_email_links->find ($fetchquery);
        
        $linked_userDetail = array ();
        foreach ( $cursor1 as $result ) {
            array_push ( $linked_userDetail, $result );
        }
        
        return $linked_userDetail;                
    }
    
    function insert_linked_email($email,$linked_email,$status,$token_val)
    {
        $collection_user_email_links = $this->db_conn(false,true);
                        
        $foundLastRecord = $collection_user_email_links->find()->sort(array("_id" => -1))->limit(1);
        $lastRecordArr = array ();
        foreach ( $foundLastRecord as $result ) {
            array_push ( $lastRecordArr, $result );
        } 

        if(!empty($lastRecordArr))
            $nextID = $lastRecordArr['0']['id']+1;
        else
            $nextID = 1;
        
        
        
        $user_email_link_data['id'] = "$nextID";
        $user_email_link_data['email'] = $email;
        $user_email_link_data['linked_email'] = $linked_email;
        $user_email_link_data['status'] = $status;
        
        $token = '';
        if($token_val)
        {
            $token = sha1(substr(uniqid(rand(), true), 12, 12));
        }            
        
        $user_email_link_data['verification_token'] = $token;
        
        $curr_date = date('Y m d h:i:s');

        $tmp_date = explode(' ',$curr_date);
        $tmp_time = explode(':',$tmp_date['3']);
                                                        
        $user_email_link_data['email_link_timestamp'] = mktime($tmp_time['0'],$tmp_time['1'],$tmp_time['2'],$tmp_date['1'],$tmp_date['2'],$tmp_date['0']);
        
        
        $collection_user_email_links->insert ( $user_email_link_data, array (
										"safe" => true
								) );
                                  
        
        
        return $token;                
    }
    
    public function profile()
    {
        $this->layout = 'admin' ; 
        
        $logedinuser = $this->Session->read('User');
        if(empty($logedinuser['0']) && !isset($logedinuser['0']['username']))
        {
            $this->redirect("/auth/login");
        }
        
        if($logedinuser['0']['type'] != 'superadmin')
        {
            $linkedEmailList = array();
            $collection_user_email_links = $this->db_conn(false,true);
            
            if(isset($_REQUEST) && !empty($_REQUEST))
            {
                $collection_user = $this->db_conn();
                $registered_user['username'] = $_REQUEST['email'];
                                                          
                $fetchquery = $registered_user;
                
                $cursor1 = $collection_user->find ($fetchquery);
                
                $registered_userDetail = array ();
                foreach ( $cursor1 as $result ) {
                    array_push ( $registered_userDetail, $result );
                }

//echo "<pre>";
//print_r($registered_userDetail);
//echo "</pre>";
//die;
                
                if(!empty($registered_userDetail['0']))
                {
                    $linked_userDetail = array ();
                    $linked_userDetail = $this->check_linked_email_exists($logedinuser['0']['username'],$_REQUEST['email']);
                                        
                    if(empty($linked_userDetail))
                    {
                        
                        $token = $this->insert_linked_email($logedinuser['0']['username'],$_REQUEST['email'],'pending',true);
                        
                        $verificationLink = ADMIN_PATH . 'auth/verify_user_email_links/' . $token;
        
        echo $verificationLink;
                        
                        $email = $_REQUEST['email'];
                        
                        $data['email'] = $email;
                        $data['verificationLink'] = $verificationLink;
            
            //echo "<pre>";
            //print_r($data);
            //echo "</pre>";
            //die;
                        
                        //********* EMAIL TO CPx ADMIN *********\\
                        
                        $Email2useremaillink = new CakeEmail('sendgrid');
                        
                        $Email2useremaillink->from(array('contact@centralpropertyexchange.com.au' => 'CentralPropertyExchange.com.au'));
                        $Email2useremaillink->to($email);
                        
                        $Email2useremaillink->subject("CPx account - verify and link your CPx accounts");
                        $Email2useremaillink->template('verify_email_links');
                        $Email2useremaillink->viewVars(array('data' => $data));
                        $Email2useremaillink->emailFormat('html');
                        
                        //$Email2useremaillink->send();
                        
                        $this->set('success_msg','Verification link has been sent to the email account.'); 
                        
                        
                        
                        if($registered_userDetail[0]['status']=='inactive')
                        {
                            $register['username'] =  $registered_userDetail[0]['username'];
                            $newquery = $register;
            
                            $verification_token = sha1(substr(uniqid(rand(), true), 12, 12));
                                
                            $password = $this->generate_password();
                            
                            $curr_date = date('Y m d h:i:s');
                            
                            $tmp_date = explode(' ',$curr_date);
                            $tmp_time = explode(':',$tmp_date['3']);
                                                                            
                            $registration_timestamp = mktime($tmp_time['0'],$tmp_time['1'],$tmp_time['2'],$tmp_date['1'],$tmp_date['2'],$tmp_date['0']);
                            
                            $retval = $collection_user->findAndModify ( $newquery, array (
                            								'$set' => array (
                            										"verification_token" => $verification_token,
                                                                    "registration_timestamp" => $registration_timestamp,
                                                                    "password" => md5($password), 
                                                                   
                            								)
                            					
                            						));
                            
                            
                            
                            $verificationLink = ADMIN_PATH . 'auth/verify_user/' . $verification_token;
                                       
                            $email = $registered_userDetail[0]['username'];
                            
                            $userType = $registered_userDetail[0]['type'];
                            
                            $data['email'] = $email;
                            $data['link'] = $verificationLink;
                            $data['password'] = $password;
                            $data['user_type'] = $userType;
                            
                            $subject = 'Request to verify CPx account';
                            $template = 'unverified_user';
                            
                            //********* EMAIL TO CPx ADMIN *********\\
                            
                            $Email2registration_verified = new CakeEmail('sendgrid');
                            //$Email2registration_verified = new CakeEmail('gmail');
                                                    
                            $Email2registration_verified->from(array('admin@centralpropertyexchange.com.au' => 'CPx Admin'));
                            $Email2registration_verified->to($email);
                            //$Email2registration_verified->to('irshadahmed.ansari@gmail.com');
                            
                            
                            $Email2registration_verified->subject($subject);
                            $Email2registration_verified->template($template);
                            $Email2registration_verified->viewVars(array('data' => $data));
                            $Email2registration_verified->emailFormat('html');
                            
                            //$Email2registration_verified->send();
                        }
                    }
                    else
                    {
                        $this->set('error_msg','Email address already link.'); 
                    }
                }
                else
                {
                    $click_here_str = '<a style="color: white;text-decoration: underline;" href="'.WEB_PATH.'/#!/list_ur_property" target="_blank" >Click here</a>';
                    $this->set('error_msg','Email address is not registered with CPx. '.$click_here_str.' to register or contact CPx admin for assistance.');     
                }
                                
            }
    
            $user['email'] = $logedinuser['0']['username'];                               
            $fetchquery = $user;
            
            $cursor1 = $collection_user_email_links->find ($fetchquery);
            
            $userDetail = array ();
            foreach ( $cursor1 as $result ) {
                array_push ( $userDetail, $result );
            }
            
            $linkedEmailList = $userDetail;
            
 //   echo "<pre>";
//    print_r($linkedEmailList);
//    echo "</pre>";

            
            $i = 0;
            foreach($linkedEmailList as $list)
            {
                if($list['status'] == 'approved')
                {
                    $linkedEmailList[$i]['total_properties'] = $this->get_properties_count($list['linked_email']);
                }
                
                $i++;
            }
            
            $default_email['total_properties'] = $this->get_properties_count($logedinuser['0']['username']);
            
//echo "<pre>";
//print_r($linkedEmailList);
//echo "</pre>";
//die;
            
            $this->set('default_email',$default_email);                                            
            $this->set('linkedEmailList',$linkedEmailList);
        }
                    
        $this->set('logedinuser',$logedinuser);
        $this->set('page','profile');
    }
    
    public function get_properties_count($email_id)
    {
        $collection_properties = $this->db_conn(false,false,true);
        
        $countprop = 0;
        $newquery1 = array();
        $newquery1 = array('$or' => array(array('agentID' => $email_id),array('contact.email'=>$email_id)));   
            
        $countprop = $collection_properties-> count($newquery1);
       
        return $countprop;
    }
    
    public function resend_email_link_verification($id)
    {
        $collection_user_email_links = $this->db_conn(false,true);
        
        $linked_user['id'] = $id;
                                              
        $fetchquery = $linked_user;
        
        $cursor1 = $collection_user_email_links->find ($fetchquery);
        
        $linked_userDetail = array ();
        foreach ( $cursor1 as $result ) {
            array_push ( $linked_userDetail, $result );
        }

//echo "<pre>";
//print_r($linked_userDetail);
//echo "</pre>";
//die;


        if(!empty($linked_userDetail['0']))
        {
            $email = $linked_userDetail['0']['linked_email'];
        
            $token = sha1(substr(uniqid(rand(), true), 12, 12));
            $user_email_link_data['verification_token'] = $token;
            
            $curr_date = date('Y m d h:i:s');
            
            $tmp_date = explode(' ',$curr_date);
            $tmp_time = explode(':',$tmp_date['3']);
                                                            
            $user_email_link_data['email_link_timestamp'] = mktime($tmp_time['0'],$tmp_time['1'],$tmp_time['2'],$tmp_date['1'],$tmp_date['2'],$tmp_date['0']);
            
            $emaillink['id'] =  $id;
            $newquery = $emaillink;


//echo "<br>email=>/".$email;
//echo "<pre>";
//print_r($newquery);
//print_r($user_email_link_data);
//echo "</pre>";
//die;

            
            $retval = $collection_user_email_links->findAndModify ( $newquery, array (
                        								'$set' => $user_email_link_data
                					
                						));
            
            $verificationLink = ADMIN_PATH . 'auth/verify_user_email_links/' . $token;
    
//echo $verificationLink;
                            
            $data['email'] = $email;
            $data['verificationLink'] = $verificationLink;
                    
            //********* EMAIL TO CPx ADMIN *********\\
                            
            $Email2useremaillink = new CakeEmail('sendgrid');
            
            $Email2useremaillink->from(array('contact@centralpropertyexchange.com.au' => 'CentralPropertyExchange.com.au'));
            $Email2useremaillink->to($email);
            
            $Email2useremaillink->subject("CPx account - verify and link your CPx accounts");
            $Email2useremaillink->template('verify_email_links');
            $Email2useremaillink->viewVars(array('data' => $data));
            $Email2useremaillink->emailFormat('html');
            
            //$Email2useremaillink->send();
            
            $this->Session->setFlash('Verification link has been sent to the email account.', 'success');
            $this->redirect(array("controller" => "auth", "action" => "profile"));
        }
        else
        {
            $this->Session->setFlash('No such user exists.', 'error');
            $this->redirect(array("controller" => "auth", "action" => "profile")); 
        }            
        
    }
    
    public function verify_user_email_links($token)
    {
        $collection_user_email_links = $this->db_conn(false,true);
        
        $verify['verification_token'] =  $token;
        
        $newquery = $verify;
        
        $cursor1 = $collection_user_email_links->find ($newquery);
        
        $tokenExist = array ();
        foreach ( $cursor1 as $result ) {
            array_push ( $tokenExist, $result );
        }
        
              
        if(!empty($tokenExist['0']))
        {
            $tokenExist = $tokenExist['0'];
            
            $email_link_timestamp = $tokenExist['email_link_timestamp'];
            
            $cDate = strtotime(date('Y-m-d H:i:s'));

            // Getting the value of old date + 24 hours
            $emailLinkDateAfterOneDay = $email_link_timestamp + 86400; // 86400 seconds in 24 hrs

            if($emailLinkDateAfterOneDay > $cDate)
            {
                
//echo "<pre>";
//print_r($tokenExist);
//echo "</pre>";
//die;

                $fetchlinkedemail['verification_token'] =  $tokenExist['verification_token'];
                $newquery = $fetchlinkedemail;
                
                $retval = $collection_user_email_links->findAndModify ( $newquery, array (
    											'$set' => array (
    													"verification_token" => '',
                                                        "status" => 'approved',
    											)
    									));

                
                $fetchlinkedemaildetails['email'] =  $tokenExist['email'];
                $newquery = $fetchlinkedemaildetails;
                
                $cursor1 = $collection_user_email_links->find ($newquery);
                
                $linked_email_list = array ('0'=>$tokenExist['email']);
                foreach ( $cursor1 as $result ) {
                    if($tokenExist['linked_email'] != $result['linked_email'])
                        array_push ( $linked_email_list, $result['linked_email'] );
                }
                

//echo "<pre>";
//print_r($linked_email_list);
//echo "</pre>";
//die;

                foreach($linked_email_list as $list)
                {
                    $linked_userDetail = array();
                    $linked_userDetail = $this->check_linked_email_exists($tokenExist['linked_email'],$list);
                    if(empty($linked_userDetail))
                    {
                        $token = $this->insert_linked_email($tokenExist['linked_email'],$list,'approved',false);
                        
                        $linked_userDetail=$this->check_linked_email_exists($list,$tokenExist['linked_email']);
                        if(empty($linked_userDetail))
                        {
                            $token = $this->insert_linked_email($list,$tokenExist['linked_email'],'approved',false);
                            
                        }   
                    }                        
                }            

            

                $this->Session->setFlash('Your account has been verified.', 'success');
                $this->redirect(array("controller" => "auth", "action" => "login"));
                
                exit; 
            }
            else
            {
                $this->Session->setFlash('Your verification token has been expired.', 'error');   
                $this->redirect(array("controller" => "auth", "action" => "login"));      
            }                
        }
        else
        {                
            $this->Session->setFlash('No user with such verification token is found. Please click again on verify button in mail.', 'error');   
            $this->redirect(array("controller" => "auth", "action" => "login"));      
        } 
    }
    
    public function unlink_email($id)
    {
        $collection_user_email_links = $this->db_conn(false,true);
        if(!empty($id))
        {     
            
            $verify['id'] =  $id;
        
            $newquery = $verify;
            
            $cursor1 = $collection_user_email_links->find ($newquery);
            
            $linkedEmailExist = array ();
            foreach ( $cursor1 as $result ) {
                array_push ( $linkedEmailExist, $result );
            }
            
            $linkedEmailExist = $linkedEmailExist['0'];
            
//echo "<pre>";
//print_r($linkedEmailExist);
//echo "</pre>";
//die;            
            
            $fetchlinkedemaildetails['email'] =  $linkedEmailExist['email'];
            $newquery = $fetchlinkedemaildetails;
            
            $cursor1 = $collection_user_email_links->find ($newquery);
            
            $linked_email_list = array ('0'=>$linkedEmailExist['email']);
            foreach ( $cursor1 as $result ) {
                if($linkedEmailExist['linked_email'] != $result['linked_email'])
                    array_push ( $linked_email_list, $result['linked_email'] );
            }
            

//echo "<pre>";
//print_r($linked_email_list);
//echo "</pre>";
//die;
            
            foreach($linked_email_list as $list)
            {
                $fetched_id = $this->get_linked_email_ids($linkedEmailExist['linked_email'],$list);

                $linked_email_ids[] = $fetched_id['0'];
                if(empty($linked_userDetail))
                {
                    
                    $fetched_id = $this->get_linked_email_ids($list,$linkedEmailExist['linked_email']);
                    $linked_email_ids[]=$fetched_id['0'];
                     
                }                        
            }    
            
//echo "<pre>";
//print_r($linked_email_ids);
//echo "</pre>";
//die;            
            
            $collection_user_email_links->remove(array('id' => array( '$in' => $linked_email_ids )));
            
            
            $this->set('success_msg','Email is unlinked successfully.'); 
            
            $this->Session->setFlash('Email is unlinked successfully.', 'success');   
            $this->redirect(array("controller" => "auth", "action" => "profile")); 
        }
    }
    
    public function get_linked_email_ids($email,$linked_email)
    {
        $collection_user_email_links = $this->db_conn(false,true);
                        
        $linked_user['email'] = $email;   
        $linked_user['linked_email'] = $linked_email  ;
                                  
        $fetchquery = $linked_user;
        
        $cursor1 = $collection_user_email_links->find ($fetchquery);
        
        $linked_userDetail = array ();
        foreach ( $cursor1 as $result ) {
            array_push ( $linked_userDetail, $result['id'] );
        }
        
        return $linked_userDetail; 
    }
    
    public function fetch_sel_user_details()
    {
        $collection = $this->db_conn();
        $userDetail['username'] =  $_POST['linked_email'];
        $newquery = $userDetail;
        
        $cursor1 = $collection->find ($newquery);
        
        $fetchUserDetails = array ();
        foreach ( $cursor1 as $result ) {
            array_push ( $fetchUserDetails, $result );
        }  

        if(isset($fetchUserDetails[0]['oauth_provider']) && !empty($fetchUserDetails[0]['oauth_provider']))
        {
            switch($fetchUserDetails[0]['oauth_provider'])
            {
                case "facebook":
                    $fetchUserDetails[0]['social_media_logo'] = 'facebook.png';
                    break;
                case "linkedin":
                    $fetchUserDetails[0]['social_media_logo'] = 'linkedin.png';
                    break;
                case "google":
                    $fetchUserDetails[0]['social_media_logo'] = 'googleplus.png';
                    break;
                default:
                    break;                                                                                
            }
        }

//echo "<prE>";
//print_r($logedinuser);                        
//echo "</pre>";
//die;
        
        $this->set('fetchUserDetails',$fetchUserDetails);
        
        $this->layout = 'ajax';

        $this->render('/Elements/myaccounts_user_details');              
    }
    
    public function myaccounts()
    {
        $this->layout = 'admin' ; 
        
        $logedinuser = $this->Session->read('User');
        if(empty($logedinuser) && !isset($logedinuser['username']))
        {
            $this->redirect("/auth/login");
        }
        
        $collection = $this->db_conn();
        $request_email = '';
        if(!empty($this->data))
        {
            $firstname = $lastname = $phone_number = $company_name = '';
            
            if(isset($_REQUEST['firstname']) && !empty($_REQUEST['firstname']))
                $firstname = $_REQUEST['firstname'];
                
            if(isset($_REQUEST['lastname']) && !empty($_REQUEST['lastname']))            
                $lastname = $_REQUEST['lastname'];
                
            if(isset($_REQUEST['phone_number']) && !empty($_REQUEST['phone_number']))            
                $phone_number = $_REQUEST['phone_number'];
                
            if(isset($_REQUEST['company_name']) && !empty($_REQUEST['company_name']))            
                $company_name = $_REQUEST['company_name'];
            
            $username['username'] =  $_REQUEST['linked_email'];
            $newquery = $username;
            
            $retval = $collection->findAndModify ( $newquery, array (
                        								'$set' => array (
                        										"firstname" => $firstname,
                                                                "lastname" => $lastname,
                                                                "phone_number" => $phone_number,
                                                                "company_name" => $company_name,
                                                               
                        								)
                        					
                        						));
                                                
            $request_email = $_REQUEST['linked_email'];  
            $this->set('request_email',$request_email);                                          
        }
        
        $collection_user_email_links = $this->db_conn(false,true);
        
        $checklinkedemail['email'] =  $logedinuser['0']['username'];
        $checklinkedemail['status'] =  'approved';
            
        $newquery = $checklinkedemail;
        
        $cursor1 = $collection_user_email_links->find ($newquery);
        
        $linkedEmailsExist = array ('0'=>array('linked_email'=>$logedinuser['0']['username']));
        
        foreach ( $cursor1 as $result ) {
            array_push ( $linkedEmailsExist, $result );
        }

//echo "<prE>";
//print_r($linkedEmailsExist);                        
//echo "</pre>";
//die;

        $linkedEmailsList = array();
        foreach($linkedEmailsExist as $list)
        {
            array_push($linkedEmailsList,$list['linked_email']);
        }

//echo "<prE>";
//print_r($linkedEmailsList);
//print_r($logedinuser);                                       
//echo "</pre>";            
//die;            
        
        $this->set('linkedEmailsList',$linkedEmailsList);
        
        if(!empty($request_email))
            $fetchuser['username'] =  $request_email;
        else            
            $fetchuser['username'] =  $logedinuser['0']['username'];
            
        $newquery = $fetchuser;
        
        $cursor1 = $collection->find ($newquery);
        
        $fetchUserDetails = array ();
        
        foreach ( $cursor1 as $result ) {
            array_push ( $fetchUserDetails, $result );
        }

//echo "<prE>";
//print_r($fetchUserDetails);                        
//echo "</pre>";
//die;
        
        if(isset($fetchUserDetails[0]['oauth_provider']) && !empty($fetchUserDetails[0]['oauth_provider']))
        {
            switch($fetchUserDetails[0]['oauth_provider'])
            {
                case "facebook":
                    $fetchUserDetails[0]['social_media_logo'] = 'facebook.png';
                    break;
                case "linkedin":
                    $fetchUserDetails[0]['social_media_logo'] = 'linkedin.png';
                    break;
                case "google":
                    $fetchUserDetails[0]['social_media_logo'] = 'googleplus.png';
                    break;
                default:
                    break;                                                                                
            }
        }

//echo "<prE>";
//print_r($fetchUserDetails);                        
//echo "</pre>";
//die;
        
        if($fetchUserDetails['0']['type'] == 'publisher')
        {
            $collection_publisher = $this->db_conn(true);
            
            $publisher['agentID'] =  $fetchUserDetails['0']['username'];
            $newquery = $publisher;            
            
            $cursor1 = $collection_publisher->find ($newquery);
        
            $publisherInfo = array ();
            foreach ( $cursor1 as $result ) {
                array_push ( $publisherInfo, $result );
            }

            $fetchUserDetails['0']['publisher_status'] =  'Offline';
                        
            if($publisherInfo['0']['status'])
                $fetchUserDetails['0']['publisher_status'] =  'Online';      
        }
        
        $this->set('fetchUserDetails',$fetchUserDetails);
        $this->set('logedinuser',$logedinuser);
        
        $this->set('page','myaccounts');
        
        
    }
    
    public function logout()
    {
        //fb code starts
        if(isset($_SESSION['facebook_access_token']))
        {
            $this->logout_from_facebook();
        }
        
        //fb code ends
        
        //gp code starts
        
        if(isset($_SESSION['token']))
        {
            $this->logout_from_googleplus();
        }
         
        //gp code ends
        
        //linkedin code starts
        if(isset($_SESSION['oauth_status']))
        {
            $this->logout_from_linkedin();
        }
        
        //linkedin code ends
        
        $this->Session->destroy();
        
        $this->redirect("login");
    }
    
    function logout_from_facebook()
    {
        /*
         * Configuration and setup Facebook SDK
         */
        $appId         = FB_APP_ID; //Facebook App ID
        $appSecret     = FB_APP_SECRET; //Facebook App Secret
        $redirectURL   = ADMIN_PATH; //Callback URL
        $fbPermissions = array('email');  //Optional permissions
        
        $fb = new Facebook(array(
            'app_id' => $appId,
            'app_secret' => $appSecret,
            'default_graph_version' => 'v2.2',
        ));
        
        // Get redirect login helper
        $helper = $fb->getRedirectLoginHelper();
        
        // Try to get access token
        try {
            if(isset($_SESSION['facebook_access_token'])){
                $accessToken = $_SESSION['facebook_access_token'];
            }else{
                  $accessToken = $helper->getAccessToken();
            }
        } catch(FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        
        // Remove access token from session
        unset($_SESSION['facebook_access_token']);
        
        // Remove user data from session
        unset($_SESSION['fbuserData']);
    }
    
    function logout_from_googleplus()
    {
        /*
         * Configuration and setup Google API
         */
        $clientId = GP_CLIENT_ID;
        $clientSecret = GP_CLIENT_SECRET;
        $redirectURL = ADMIN_PATH;
        
        //Call Google API
        $gClient = new apiClient();
        $gClient->setApplicationName('Login to Googleplus');
        $gClient->setClientId($clientId);
        $gClient->setClientSecret($clientSecret);
        $gClient->setRedirectUri($redirectURL);
        
        $google_oauthV2 = new apiOauth2Service($gClient);
        
        //Unset token and user data from session
        unset($_SESSION['token']);
        unset($_SESSION['gpuserData']);
        
        //Reset OAuth access token
        $gClient->revokeToken();
    }
    
    function logout_from_linkedin()
    {
        //Unset token and user data from session
        unset($_SESSION['oauth_status']);
        unset($_SESSION['userData']);
    }
}
?>