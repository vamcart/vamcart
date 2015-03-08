<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
class SiteController extends AppController {
	public $name = 'Site';
	public $uses = array('Customer', 'EmailTemplate', 'AddressBook');
	public $components = array('Email', 'Smarty', 'ConfigurationBase');

	public function register()
	{
		global $config;

		App::uses('Sanitize', 'Utility');
		$clean = new Sanitize();
		$clean->clean($_POST);

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
					
		if (isset($_POST['customer']) && $spam_flag == false) {
			$customer = new Customer();
			$customer->set($_POST['customer']);
			if ($customer->validates()) {
				
				// Retrieve email template
				$this->EmailTemplate->unbindModel(array('hasMany' => array('EmailTemplateDescription')));
				$this->EmailTemplate->bindModel(array(
					'hasOne' => array(
						'EmailTemplateDescription' => array(
							'className'  => 'EmailTemplateDescription',
							'conditions' => 'language_id = ' . $this->Session->read('Customer.language_id')
						)
					)
				));

				// Get email template
				$email_template = $this->EmailTemplate->findByAlias('new-customer');

				// Email Subject
				$subject = $email_template['EmailTemplateDescription']['subject'];
				$subject = $config['SITE_NAME'] . ' - ' . $subject;

				$body = $email_template['EmailTemplateDescription']['content'];
				$body = str_replace('{$name}', $_POST['customer']['name'], $body);
				$fio = explode(" ", $_POST['customer']['name']);				
				$body = str_replace('{$firstname}', isset($fio[0]) ? $fio[0] : $_POST['customer']['name'], $body);
				$body = str_replace('{$lastname}', isset($fio[1]) ? $fio[1] : $_POST['customer']['name'], $body);
				$body = str_replace('{$email}', $_POST['customer']['email'], $body);
				$body = str_replace('{$password}', $_POST['customer']['password'], $body);

				$this->Email->init();
				$this->Email->From = $config['NEW_ORDER_FROM_EMAIL'];
				$this->Email->FromName = __($config['NEW_ORDER_FROM_NAME'],true);

				// Send to customer
				$this->Email->AddAddress($_POST['customer']['email']);
				// Send to admin
				//$this->Email->AddCC($config['SEND_EXTRA_EMAIL']);
				$this->Email->Subject = $subject;

				// Email Body
				$this->Email->Body = $body;

				// Sending mail
				$this->Email->send();

				$_POST['customer']['password'] = Security::hash($_POST['customer']['password'], 'sha1', true);
				$_POST['customer']['retype'] = Security::hash($_POST['customer']['retype'], 'sha1', true);
				$ret = $customer->save($_POST['customer']);

				$this->redirect('/customer/register-success'  . $config['URL_EXTENSION']);
				
			} else {
				$errors = $customer->invalidFields();
				$this->Session->write('loginFormErrors', $errors);
				$this->Session->write('loginFormData', $customer->data['Customer']);
				$this->redirect('/customer/register'  . $config['URL_EXTENSION']);
			}
		} else {
			$this->redirect('/customer/register'  . $config['URL_EXTENSION']);
		}
	}

	public function account_edit()
	{
		global $config;

		App::uses('Sanitize', 'Utility');
		$clean = new Sanitize();
		$clean->clean($_POST);
		if (isset($_POST['customer'])) {
			$customer = new Customer();
			$customer->set($_POST['customer']);
			if ($customer->validates()) {
				
				$_POST['customer']['id'] = $_SESSION['Customer']['customer_id'];

				$current_customer_data = $customer->find('first', array('conditions' => array('customer_id' => $_SESSION['Customer']['customer_id'])));
				
				if ($_POST['customer']['password'] == '') {
					$_POST['customer']['password'] = $current_customer_data['Customer']['password'];
				} else {
					$_POST['customer']['password'] = Security::hash($_POST['customer']['password'], 'sha1', true);
				}
				
				$ret = $customer->save($_POST['customer']);

				$this->Session->setFlash(__('Your account has been updated successfully.'), 'bootstrap_alert_success');

				$this->redirect('/customer/account'  . $config['URL_EXTENSION']);
				
			} else {
				$errors = $customer->invalidFields();
				$this->Session->write('FormErrors', $errors);
				$this->Session->write('FormData', $customer->data['Customer']);
				$this->redirect('/customer/account_edit'  . $config['URL_EXTENSION']);
			}
		} else {
			$this->redirect('/customer/account'  . $config['URL_EXTENSION']);
		}
	}

	public function address_book()
	{
		global $config;

		App::uses('Sanitize', 'Utility');
		$clean = new Sanitize();
		$clean->clean($_POST);
		if (isset($_POST)) {
			$customer = new Customer();
			$customer->set($_POST);
			$customer->AddressBook->set($_POST['AddressBook']);

			if ($customer->AddressBook->validates()) {

				$_POST['Customer']['id'] = $_SESSION['Customer']['customer_id'];

				$ret = $customer->save($_POST['Customer']);
				
				$_POST['AddressBook']['customer_id'] = $_SESSION['Customer']['customer_id'];

				// Check if we already have a record for this type of special content, if so delete it.
				// I'm sure there's a better way to do this
				$check_specified_type = $customer->AddressBook->find('first', array('conditions' => array('customer_id' => $_SESSION['Customer']['customer_id'])));
			
				if(!empty($check_specified_type))
					$_POST['AddressBook']['id']= $check_specified_type['AddressBook']['id'];
			
				$customer->AddressBook->save($_POST['AddressBook']);

				$this->Session->setFlash(__('Your account has been updated successfully.'), 'bootstrap_alert_success');

				$this->redirect('/customer/account'  . $config['URL_EXTENSION']);
				
			} else {
				$errors = $customer->AddressBook->invalidFields();
				$this->Session->write('FormErrors', $errors);
				$this->Session->write('FormData', $customer->data);
				$this->redirect('/customer/address_book'  . $config['URL_EXTENSION']);
			}
		} else {
			$this->redirect('/customer/account'  . $config['URL_EXTENSION']);
		}
	}
		
	public function login()
	{
		App::uses('Sanitize', 'Utility');
		$clean = new Sanitize();
		$clean->clean($_POST);

		$customer_id = $this->Customer->find('first', array('conditions' => array('email' => $_POST['data']['Customer']['email'])));

		if ($customer_id['Customer']['password'] == Security::hash( $_POST['data']['Customer']['password'], 'sha1', true)) {

		$this->Session->write('Customer.customer_id', $customer_id['Customer']['id']);

		if(isset($customer_id['GroupsCustomer']['id']))$this->Session->write('Customer.customer_group_id', $customer_id['GroupsCustomer']['id']);
		else $this->Session->write('Customer.customer_group_id', 0);

		} else {

		$this->Session->setFlash(__('Login error. Check your email and/or password!'), 'bootstrap_alert_error');

		//$this->Session->delete('Customer.customer_id');
		//$this->Session->delete('Customer.customer_group_id');

		}

		$this->redirect($_SERVER['HTTP_REFERER']);

	}

	public function logout()
	{

		$this->Session->delete('Customer.customer_id');

		//$this->Auth->logout();

		$this->redirect('/');
	}

	public function password_recovery()
	{
		global $config;

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
					
		if (isset($_POST['customer']) && $spam_flag == false) {
			$customer = new Customer();
			$customer->set($_POST['customer']);
			if ($customer->validates()) {
				
		App::uses('Sanitize', 'Utility');
		$clean = new Sanitize();
		$clean->clean($_POST);

			$user = $this->Customer->find('first', array('conditions' => array('email' => $_POST['customer']['email'])));

			if(empty($user))
			{
				$this->Session->setFlash(__('No customers found for this email.', true), 'bootstrap_alert_error');
  			$this->redirect('/customer/password_recovery'  . $config['URL_EXTENSION']);
			}

			if(!empty($user))
			{
			  
			  $customer_data = array();
			  
			  $customer_data['Customer']['id'] = $user['Customer']['id'];
			  $customer_data['Customer']['code'] = $this->RandomString(32);
			  
				$customer->save($customer_data);

				// Retrieve email template
				$this->EmailTemplate->unbindModel(array('hasMany' => array('EmailTemplateDescription')));
				$this->EmailTemplate->bindModel(array(
					'hasOne' => array(
						'EmailTemplateDescription' => array(
							'className'  => 'EmailTemplateDescription',
							'conditions' => 'language_id = ' . $this->Session->read('Customer.language_id')
						)
					)
				));

				// Get email template
				$email_template = $this->EmailTemplate->findByAlias('password_recovery_verification');

				// Email Subject
				$subject = $email_template['EmailTemplateDescription']['subject'];
				$subject = $config['SITE_NAME'] . ' - ' . $subject;

				$body = $email_template['EmailTemplateDescription']['content'];
				$body = str_replace('{$link}', FULL_BASE_URL . BASE . '/site/new_password/' . $customer_data['Customer']['code'] . '/', $body);

				$this->Email->init();
				$this->Email->From = $config['NEW_ORDER_FROM_EMAIL'];
				$this->Email->FromName = __($config['NEW_ORDER_FROM_NAME'],true);

				// Send to customer
				$this->Email->AddAddress($_POST['customer']['email']);
				// Send to admin
				//$this->Email->AddCC($config['SEND_EXTRA_EMAIL']);
				$this->Email->Subject = $subject;

				// Email Body
				$this->Email->Body = $body;

				// Sending mail
				$this->Email->send();

			$this->Session->setFlash(__('New password validation email was send.', true), 'bootstrap_alert_success');
			$this->redirect('/customer/password_recovery'  . $config['URL_EXTENSION']);
			}	
				
			} else {
				$errors = $customer->invalidFields();
				$this->Session->write('loginFormErrors', $errors);
				$this->Session->write('loginFormData', $customer->data['Customer']);
				$this->redirect('/customer/password_recovery'  . $config['URL_EXTENSION']);
			}
		} else {
			$this->redirect('/customer/password_recovery'  . $config['URL_EXTENSION']);
		}
	}

	public function new_password($verification_code = false)
	{
		global $config;
	  
	  if ($verification_code) {
	  
			$user = $this->Customer->find('first', array('conditions' => array('code' => $verification_code)));

			if(empty($user))
			{
				$this->Session->setFlash(__('Customer not found for this verification code.', true), 'bootstrap_alert_error');
  			$this->redirect('/customer/password_recovery'  . $config['URL_EXTENSION']);
			}

			if(!empty($user))
			{
			  
  			$customer = new Customer();

			  $customer_data = array();
			  
			  $customer_password = $this->RandomString(8);
			  
			  $customer_data['Customer']['id'] = $user['Customer']['id'];
			  $customer_data['Customer']['password'] = Security::hash($customer_password, 'sha1', true);

				$customer->save($customer_data);

				// Retrieve email template
				$this->EmailTemplate->unbindModel(array('hasMany' => array('EmailTemplateDescription')));
				$this->EmailTemplate->bindModel(array(
					'hasOne' => array(
						'EmailTemplateDescription' => array(
							'className'  => 'EmailTemplateDescription',
							'conditions' => 'language_id = ' . $this->Session->read('Customer.language_id')
						)
					)
				));

				// Get email template
				$email_template = $this->EmailTemplate->findByAlias('password_recovery_new_password');

				// Email Subject
				$subject = $email_template['EmailTemplateDescription']['subject'];
				$subject = $config['SITE_NAME'] . ' - ' . $subject;

				$body = $email_template['EmailTemplateDescription']['content'];
				$body = str_replace('{$email}', $user['Customer']['email'], $body);
				$body = str_replace('{$password}', $customer_password, $body);
				$body = str_replace('{$account_page}', FULL_BASE_URL . BASE . '/page/account' . $config['URL_EXTENSION'], $body);

				$this->Email->init();
				$this->Email->From = $config['NEW_ORDER_FROM_EMAIL'];
				$this->Email->FromName = __($config['NEW_ORDER_FROM_NAME'],true);

				// Send to customer
				$this->Email->AddAddress($user['Customer']['email']);
				// Send to admin
				//$this->Email->AddCC($config['SEND_EXTRA_EMAIL']);
				$this->Email->Subject = $subject;

				// Email Body
				$this->Email->Body = $body;

				// Sending mail
				$this->Email->send();

			$this->Session->setFlash(__('New password email was send.', true), 'bootstrap_alert_success');
			$this->redirect('/page/account'  . $config['URL_EXTENSION']);
			}	
		}	else {
			$this->Session->setFlash(__('Login Error.', true), 'bootstrap_alert_error');
			$this->redirect('/page/account'  . $config['URL_EXTENSION']);
		}	
	}


	private function RandomString($length) 
		{
		$chars = array( 'a', 'A', 'b', 'B', 'c', 'C', 'd', 'D', 'e', 'E', 'f', 'F', 'g', 'G', 'h', 'H', 'i', 'I', 'j', 'J',  'k', 'K', 'l', 'L', 'm', 'M', 'n','N', 'o', 'O', 'p', 'P', 'q', 'Q', 'r', 'R', 's', 'S', 't', 'T',  'u', 'U', 'v','V', 'w', 'W', 'x', 'X', 'y', 'Y', 'z', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
		
		$max_chars = count($chars) - 1;
		srand( (double) microtime()*1000000);
		
		$rand_str = '';
		for($i=0;$i<$length;$i++)
		{
		$rand_str = ( $i == 0 ) ? $chars[rand(0, $max_chars)] : $rand_str . $chars[rand(0, $max_chars)];
		}
		
		return $rand_str;
		}

}
