<?php
App::uses ( 'Component', 'Controller' );

/**
 *
 * @author shiv
 * 
 * USE THIS CLASS FOR SENDING ANY EMAIL
 */
class CommonEmailComponent extends Component {
	var $components = array (
			'Email' 
	);
	private $Controller;

	public function initialize(Controller $controller) {
		$this->Email->smtpOptions = array (
				'host' => Configure::read ( 'EmailConfig.host' ),
				'username' => Configure::read ( 'EmailConfig.username' ),
				'password' => Configure::read ( 'EmailConfig.password' ),
				'timeout' => Configure::read ( 'EmailConfig.timeout' )
				
		);
		
		$this->Email->delivery = 'mail'; // possible values smtp or mail
		// Get the email template details with respect to the subject
		$this->Controller = $controller;
	}

	public function sendEmail($templatecode = NULL, $replaceArray = NULL, $replaceWithArray = NULL, $to = NULL, $cc = NULL, $bcc = NULL, $subject = NULL, $fromName = NULL, $attachment=NULL, $from=NULL) {
		
		$this->EmailTemplate = ClassRegistry::init('EmailTemplate');
		$templateDetails = $this->EmailTemplate->find ( 'first', array (
				'conditions' => array (
						'EmailTemplate.template_code' => $templatecode 
				),
				'fields' => array (
						'EmailTemplate.template_message',
						'EmailTemplate.template_subject' 
				) 
		) );
		
		$this->GlobalSetting = ClassRegistry::init('GlobalSetting');
		
		$allGlobalSettings = $this->GlobalSetting->getGlobalSettings();
		//set message
		
		$message = $templateDetails ['EmailTemplate'] ['template_message'];
		$updatedMessage = str_replace ( $replaceArray, $replaceWithArray, $message );
		
		//set subject
		if (isset ( $subject ) && $subject != '') {
			$this->Email->subject = $subject;
		} else {
			$this->Email->subject = $templateDetails ['EmailTemplate'] ['template_subject'];
		}
		
		//set from
		
		//$admin_name = Configure::read ( 'EmailConfig.adminName' );
		$admin_name = $allGlobalSettings['EmailConfig.adminName'];
		$from_name = $admin_name;
		if (isset ( $fromName ) && $fromName != '' ) {
			$from_name = $fromName;
		}
		if (empty ( $from )) {
			$from = $from_name . '<' . $allGlobalSettings['EmailConfig.fromEmail'] . '>';
		}
		$this->Email->from = $from;
		
		//set reply to 
		if (empty ( $reply )) {
			$reply = $admin_name . '<' . $allGlobalSettings['EmailConfig.replytoEmail'] . '>';
		}
		$this->Email->replyTo = $reply;
		
		//set to
		if ($to == 'admin') {
			$this->Email->to = $from;
		} else {
			$this->Email->to = $to;
		}
		$cc = (!empty($cc)) ? array_filter($cc) : array();
		if (! empty ( $cc )) {
			$this->Email->cc = $cc;
		}
		$bcc =  (!empty($bcc)) ? array_filter($bcc) : array();
		if (! empty ( $bcc )) {
			$this->Email->bcc = $bcc;
		}
// 		if (! empty ( $path ) && ! empty ( $file_name ))
// 			$this->Email->attachments = array (
// 					$file_name,
// 					$path . $file_name 
// 			);
		
		$this->Controller->set ( 'data', $updatedMessage );
		$this->Controller->set ( 'smtp_errors', $this->Email->smtpError );
		$this->Email->sendAs = 'both';
		$this->Email->template = 'common_template';
		// $this->$Email->attachments($attachment);
		
		if ($this->Email->send ()) {
			return true;
		} else {
			die ( 'not' );
			return false;
		}
	}
}
?>
