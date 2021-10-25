<?php
App::uses('CakeEmail', 'Network/Email');
class SharemailController extends AppController {
	public $helpers = array('Html', 'Form');
	public $components = array('RequestHandler');


	public function add() {
		 

		 
		$this->RequestHandler->addInputType('json', array('json_decode', true));
		$data = $this->request->data;
		 
		ini_set('display_errors', 'On');
		$to = $data['toemail'];

		$subject = $data['subject'];
		$txt = nl2br($data['message'])."<br><br>This email was sent by: ".$data['youremail'];
		 
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
	}

}
?>