<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
class ContactUsController extends AppController {
	public $name = 'ContactUs';
	public $components = array('Email', 'ConfigurationBase');
	public $helpers = array('Time','Text','TinyMce');
	public $uses = array('EmailTemplate', 'AnswerTemplate', 'Contact', 'ContactAnswer');
	public $paginate = array('limit' => 20, 'order' => array('Contact.id' => 'desc'));

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
		
		$contact_data = array();

		$contact_data['name'] = $_POST['name'];
		$contact_data['email'] = $_POST['email'];
		$contact_data['message'] = $_POST['message'];

		$contact_data['customer_id'] = (($_SESSION['Customer']['customer_id'] > 0) ? $_SESSION['Customer']['customer_id'] : 0);
		$contact_data['answered'] = 0;

		$contact_data['created'] = date("Y-m-d H:i:s");
		$contact_data['modified'] = date("Y-m-d H:i:s");

		$contact_data['ref'] = $_SERVER['HTTP_REFERER'];
		$contact_data['ip'] = $_SERVER['REMOTE_ADDR'];
		$contact_data['forwarded_ip'] = $_SERVER['REMOTE_ADDR'];
		$contact_data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
		$contact_data['accept_language'] = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

		$contact->save($contact_data);

		
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
	
	public function admin_modify_selected() 	
	{
		$build_flash = "";
		foreach($this->params['data']['Contact']['modify'] AS $value)
		{
			// Make sure the id is valid
			if($value > 0)
			{
				$this->Contact->id = $value;
				$order = $this->Contact->read();
		
				switch ($this->data['multiaction']) 
				{
					case "delete":

						// Delete contact us message
						$this->Contact->delete($value);

						$build_flash .= __('Record deleted.', true) . '<br />';									
			
					break;								
				}
			}
		}
		$this->Session->setFlash($build_flash);
		$this->redirect('/contact_us/admin/');
	}	

	public function admin_delete ($contact_id)
	{
		// Get the contact and make sure it's not the default
		$this->Contact->id = $contact_id;
		$contact = $this->Contact->read();
		
		$this->Contact->delete($contact_id);	
		$this->Session->setFlash( __('Record deleted.', true));		

		$this->redirect('/contact_us/admin/');
	}

	public function admin_delete_answer ($answer_id,$contact_id)
	{
		$this->ContactAnswer->delete($answer_id);	
		$this->Session->setFlash( __('Record deleted.', true));		

		$this->redirect('/contact_us/admin_view/'.$contact_id);
	}	
	
	public function admin_edit ($contact_id = null)
	{
		$this->set('current_crumb', __('Answer Form', true));
		$this->set('title_for_layout', __('Answer Form', true));
		// If they pressed cancel
		if(isset($this->data['cancelbutton']))
		{
			$this->redirect('/contact_us/admin/');
			die();
		}
		
		if(empty($this->data))
		{
			$this->request->data = $this->Contact->read(null,$contact_id);
		}
		else
		{
			$this->Contact->save($this->data['Contact']);	
			
			$answer = array();
			$answer['ContactAnswer'] = $this->data['ContactAnswer'];

			$answer['ContactAnswer']['contact_id']= $this->data['Contact']['id'];

			$this->ContactAnswer->save($answer);
						
			global $config;
			$config = $this->ConfigurationBase->load_configuration();
					
			// Send to admin
			if($config['SEND_CONTACT_US_EMAIL'] != '')
			{
			
			// Set up mail
			$this->Email->init();
			$this->Email->From = $config['SEND_CONTACT_US_EMAIL'];
			$this->Email->FromName = $config['SEND_CONTACT_US_EMAIL'];
			$this->Email->AddAddress($this->data['Contact']['email'], $this->data['Contact']['name']);
			$this->Email->Subject = 'Re: '.$config['SITE_NAME'] . ' - ' . __('Contact Us' ,true);
	
			// Email Body
			$this->Email->Body = str_replace("\r\n","<br />",$this->data['ContactAnswer']['answer'])."<br /><br />>>".str_replace("\r\n","<br />>>",$this->data['Contact']['message']);
			
			// Sending mail
			$this->Email->send();
			
			}			

			$this->Session->setFlash(__('Reply Sent.', true));
			
			$this->redirect('/contact_us/admin');
		}		
	}

	public function admin_view ($id)
	{
		global $config;
		
		$this->set('current_crumb', __('Answers List', true));
		$this->set('title_for_layout', __('Answers List', true));
		$this->set('config', $config);
		$answers = $this->ContactAnswer->find('all', array('conditions' => array('ContactAnswer.contact_id' => $id)));
		$this->set('data',$answers);
		
	}	
	
	public function admin ($ajax = false)
	{
		$this->set('current_crumb', __('Messages List', true));
		$this->set('title_for_layout', __('Messages List', true));
		$data = $this->paginate('Contact');
		$this->set('data',$data);
	}	
	
}
?>