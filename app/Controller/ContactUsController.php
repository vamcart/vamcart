<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
class ContactUsController extends AppController {
	public $name = 'ContactUs';
	public $uses = null;
	public $components = array('Email', 'ConfigurationBase');

	public function send_email ()
	{
		// Clean up the post
		App::uses('Sanitize', 'Utility');
		$clean = new Sanitize();
		$clean->paranoid($_POST);

		foreach($_POST AS $key => $value)
			$_POST[$key] = $clean->html($value);

		$spam_flag = false;
		$antispam_error_message = '';

		if ( trim( $_POST['anti-bot-q'] ) != date('Y') ) { // answer is wrong - maybe spam
			$spam_flag = true;
			if ( empty( $_POST['anti-bot-q'] ) ) { // empty answer - maybe spam
				$antispam_error_message .= 'Error: empty answer. ['.$_POST['anti-bot-q'].']<br> ';
			} else {
				$antispam_error_message .= 'Error: answer is wrong. ['.$_POST['anti-bot-q'].']<br> ';
			}
		}
		if ( ! empty( $_POST['anti-bot-e-email-url'] ) ) { // field is not empty - maybe spam
			$spam_flag = true;
			$antispam_error_message .= 'Error: field should be empty. ['.$_POST['anti-bot-e-email-url'].']<br> ';
		}


		// Save to database
		
		App::import('Model', 'Contact');
		$contact = new Contact();
		
		$contact = array();

		$contact['name'] = $_POST['name'];
		$contact['email'] = $_POST['email'];
		$contact['message'] = $_POST['message'];

		$contact['customer_id'] = (($_SESSION['Customer']['customer_id'] > 0) ? $_SESSION['Customer']['customer_id'] : 0);
		$contact['answered'] = 0;

		$contact['created'] = date("Y-m-d H:i:s");
		$contact['modified'] = date("Y-m-d H:i:s");

		$contact['ref'] = $_SERVER['HTTP_REFERER'];
		$contact['ip'] = $_SERVER['REMOTE_ADDR'];
		$contact['forwarded_ip'] = $_SERVER['REMOTE_ADDR'];
		$contact['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
		$contact['accept_language'] = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

		$contact->save($contact);

		
		$config = $this->ConfigurationBase->load_configuration();
		
		// Send to admin
		if($config['SEND_CONTACT_US_EMAIL'] != '' && $spam_flag == false)
		{
		
		// Set up mail
		$this->Email->init();
		$this->Email->From = $config['SEND_CONTACT_US_EMAIL'];
		$this->Email->FromName = $config['SEND_CONTACT_US_EMAIL'];
		$this->Email->AddReplyTo($_POST['email'], $_POST['name']);
		$this->Email->AddAddress($config['SEND_CONTACT_US_EMAIL']);
		$this->Email->Subject = $config['SITE_NAME'] . ' - ' . __('Contact Us' ,true);

		// Email Body
		$this->Email->Body = $_POST['message'];
		
		// Sending mail
		$this->Email->send();
		
		}

		$this->Session->setFlash(__('Your enquiry has been successfully sent!'), 'bootstrap_alert_success');
				
		$this->redirect('/');
	}
	

}
?>