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

		$spam_flag = false;

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
		
		$config = $this->ConfigurationBase->load_configuration();
		
		// Send to admin
		if($config['SEND_CONTACT_US_EMAIL'] != '' && $spam_flag == false)
		{
		
		// Set up mail
		$this->Email->init();
		$this->Email->From = $_POST['email'];
		$this->Email->FromName = $_POST['name'];
		$this->Email->AddAddress($config['SEND_CONTACT_US_EMAIL']);
		$this->Email->Subject = $config['SITE_NAME'] . ' - ' . __('Contact Us' ,true);

		// Email Body
		$this->Email->Body = $_POST['message'];
		
		// Sending mail
		$this->Email->send();
		
		}

		$this->redirect('/');
	}
	

}
?>