<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

if(!session_id()){
    session_start();
}  


/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    
    function checkAdminLogin() {
        $sessionInfo = $this->Session->read('User');
        if (!isset($sessionInfo) && empty($sessionInfo)) {
         if ($this->request->is ( 'ajax' )) {
          $url = Router::url(array('controller' => 'auth', 'action' => 'login'));
          //$this->Session->setFlash('Please login, your session is expired or you are not logged in.', 'error');
          $this->redirect(array('controller' => 'auth', 'action' => 'ajax_session_expired/auth/login/0' . $url ));
         }else{
             //$this->Session->setFlash('Please login, your session is expired or you are not logged in.', 'error');
             $this->redirect(array('controller' => 'auth', 'action' => 'login'));
         }
        }
        
    }
    
    public function verifyRecatpcha($aData)
     {
        if(!$aData)
        {
            return true;
        } 
        $recaptcha_secret = Configure::read('google_recatpcha_settings.secret_key');
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secret."&response=".$aData['g-recaptcha-response']; 
        $response = json_decode(@file_get_contents($url));          
                     
        if($response->success == true)
        {
            return true;
        }
        else
        {
            return false;
             
        }   
     }   
     
    function generate_password($length = 20)
    {
        $chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.
                '0123456789-_';
        
        $str = '';
        $max = strlen($chars) - 1;
        
        for ($i=0; $i < $length; $i++)
        $str .= $chars[rand(0, $max)];
        
        return $str;
    }
}
