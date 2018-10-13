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
					
		if (isset($_POST['customer']) && $spam_flag == false) {

		foreach($_POST['customer'] AS $key => $value)
			$_POST['customer'][$key] = $clean->html($value);
			
			$_POST['customer']['name'] = html_entity_decode($_POST['customer']['name']);

			$_POST['customer']['created'] = date("Y-m-d H:i:s");
			$_POST['customer']['modified'] = date("Y-m-d H:i:s");

			$_POST['customer']['ref'] = $_SERVER['HTTP_REFERER'];
			$_POST['customer']['ip'] = $_SERVER['REMOTE_ADDR'];
			$_POST['customer']['forwarded_ip'] = $_SERVER['REMOTE_ADDR'];
			$_POST['customer']['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
			$_POST['customer']['accept_language'] = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

			App::import('Model', 'Customer');
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

				$assignments = array(
				'name' => $_POST['customer']['name'],
				'inn' => $_POST['customer']['inn'],
				'ogrn' => $_POST['customer']['ogrn'],
				'kpp' => $_POST['customer']['kpp'],
				'company_name' => $_POST['customer']['company_name'],
				'company_city' => $_POST['customer']['company_city'],
				'company_state' => $_POST['customer']['company_state'],
				'firstname' => isset($fio[0]) ? $fio[0] : $_POST['customer']['name'],
				'lastname' => isset($fio[1]) ? $fio[1] : $_POST['customer']['name'],
				'email' => $_POST['customer']['email'],
				'password' => $_POST['customer']['password']
				);
		
				$body = $this->Smarty->fetch($email_template['EmailTemplateDescription']['content'], $assignments);

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
			App::import('Model', 'Customer');
			$customer = new Customer();
			$customer->set($_POST['customer']);
			if ($customer->validates()) {

			foreach($_POST['customer'] AS $key => $value)
				$_POST['customer'][$key] = $clean->html($value);
				
				$_POST['customer']['id'] = $_SESSION['Customer']['customer_id'];

				$current_customer_data = $customer->find('first', array('conditions' => array('customer_id' => $_SESSION['Customer']['customer_id'])));
				
				if ($_POST['customer']['password'] == '') {
					$_POST['customer']['password'] = $current_customer_data['Customer']['password'];
				} else {
					$_POST['customer']['password'] = Security::hash($_POST['customer']['password'], 'sha1', true);
				}

				$_POST['customer']['created'] = date("Y-m-d H:i:s");
				$_POST['customer']['modified'] = date("Y-m-d H:i:s");
	
				$_POST['customer']['ref'] = $_SERVER['HTTP_REFERER'];
				$_POST['customer']['ip'] = $_SERVER['REMOTE_ADDR'];
				$_POST['customer']['forwarded_ip'] = $_SERVER['REMOTE_ADDR'];
				$_POST['customer']['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
				$_POST['customer']['accept_language'] = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
				
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
			App::import('Model', 'Customer');
			$customer = new Customer();
			$customer->set($_POST);
			$customer->AddressBook->set($_POST['AddressBook']);

			if ($customer->AddressBook->validates()) {

			foreach($_POST['AddressBook'] AS $key => $value)
				$_POST['AddressBook'][$key] = $clean->html($value);

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

		$customer_id = $this->Customer->find('first', array('order' => 'Customer.id DESC', 'conditions' => array('email' => $_POST['data']['Customer']['email'])));

		if ($customer_id['Customer']['password'] == Security::hash( $_POST['data']['Customer']['password'], 'sha1', true)) {

		$this->Session->write('Customer.customer_id', $customer_id['Customer']['id']);
		$this->Session->write('Customer.name', $customer_id['Customer']['name']);

		if(isset($customer_id['GroupsCustomer']['id']))$this->Session->write('Customer.customer_group_id', $customer_id['GroupsCustomer']['id']);
		else $this->Session->write('Customer.customer_group_id', 0);

		} else {

		$this->Session->setFlash(__('Login error. Check your email and/or password!'), 'bootstrap_alert_error');

		//$this->Session->delete('Customer.customer_id');
		//$this->Session->delete('Customer.customer_group_id');

		}

		$this->redirect($_SERVER['HTTP_REFERER']);

	}

	public function social_login()
	{
		global $config;
		
		$clientId = '849405182417-7i9u890vlp0l998u0tcc3giup6ldmqgb.apps.googleusercontent.com'; //Google CLIENT ID
		$clientSecret = 'nX550tbB6mGcSlHjXNzxfCHQ'; //Google CLIENT SECRET
		$redirectUrl = FULL_BASE_URL.BASE.'/site/social_login';  //return url (url to script)
		$homeUrl = FULL_BASE_URL.BASE;  //return to home

		App::import('Vendor', 'Google', array('file' => 'google'.DS.'Google_Client.php'));
		$gClient = new Google_Client();
		$gClient->setApplicationName('VamShop');
		$gClient->setClientId($clientId);
		$gClient->setClientSecret($clientSecret);
		$gClient->setRedirectUri($redirectUrl);
		
		App::import('Vendor', 'Google_OAuth', array('file' => 'google'.DS.'contrib'.DS.'Google_Oauth2Service.php'));
		$google_oauthV2 = new Google_Oauth2Service($gClient);

		//print_r($_GET);die;
		//echo debug($_REQUEST);
		//echo debug($gClient);
		
		if(isset($_REQUEST['code'])){
			$gClient->authenticate();
			$_SESSION['token'] = $gClient->getAccessToken();
			header('Location: ' . filter_var($redirectUrl, FILTER_SANITIZE_URL));
		}
		
		if (isset($_SESSION['token'])) {
			$gClient->setAccessToken($_SESSION['token']);
		}
		
		if ($gClient->getAccessToken()) {
			$userProfile = $google_oauthV2->userinfo->get();
			//echo debug($userProfile);

			// Register Customer
			$check = $this->Customer->find('first', array('conditions' => array('Customer.email' => $userProfile['email'])));
			if(!empty($check))
			$_POST['customer']['id']= $check['Customer']['id'];
				
			$_POST['customer']['oauth_provider'] = "google";
			$_POST['customer']['oauth_uid'] = html_entity_decode($userProfile['id']);
			$_POST['customer']['avatar'] = html_entity_decode($userProfile['picture']);
			
			$_POST['customer']['name'] = html_entity_decode($userProfile['given_name']." ".$userProfile['family_name']);
			$_POST['customer']['email'] = html_entity_decode($userProfile['email']);

			$_POST['customer']['password'] = $this->RandomString(8);

			$_POST['customer']['created'] = date("Y-m-d H:i:s");
			$_POST['customer']['modified'] = date("Y-m-d H:i:s");

			$_POST['customer']['ref'] = $_SERVER['HTTP_REFERER'];
			$_POST['customer']['ip'] = $_SERVER['REMOTE_ADDR'];
			$_POST['customer']['forwarded_ip'] = $_SERVER['REMOTE_ADDR'];
			$_POST['customer']['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
			$_POST['customer']['accept_language'] = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

			App::import('Model', 'Customer');
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

				$assignments = array(
				'name' => $_POST['customer']['name'],
				'inn' => $_POST['customer']['inn'],
				'ogrn' => $_POST['customer']['ogrn'],
				'kpp' => $_POST['customer']['kpp'],
				'company_name' => $_POST['customer']['company_name'],
				'company_city' => $_POST['customer']['company_city'],
				'company_state' => $_POST['customer']['company_state'],
				'firstname' => isset($fio[0]) ? $fio[0] : $_POST['customer']['name'],
				'lastname' => isset($fio[1]) ? $fio[1] : $_POST['customer']['name'],
				'email' => $_POST['customer']['email'],
				'password' => $_POST['customer']['password']
				);
		
				$body = $this->Smarty->fetch($email_template['EmailTemplateDescription']['content'], $assignments);

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
				$ret = $customer->save($_POST['customer']);
				}

				// Customer Login
				$customer_id = $this->Customer->find('first', array('order' => 'Customer.id DESC', 'conditions' => array('email' => $userProfile['email'])));

				if(!empty($customer_id)) {		
				$this->Session->write('Customer.customer_id', $customer_id['Customer']['id']);
				$this->Session->write('Customer.name', $customer_id['Customer']['name']);
		
				if(isset($customer_id['GroupsCustomer']['id']))$this->Session->write('Customer.customer_group_id', $customer_id['GroupsCustomer']['id']);
				else $this->Session->write('Customer.customer_group_id', 0);
				}

			$_SESSION['google_data'] = $userProfile; // Storing Google User Data in Session
			$_SESSION['token'] = $gClient->getAccessToken();

			$this->Session->setFlash(__('You successfully login.', true), 'bootstrap_alert_success');

			$this->redirect('/customer/register-success'  . $config['URL_EXTENSION']);

		} else {
			$authUrl = $gClient->createAuthUrl();
		}
		
		//if(isset($authUrl)) {
			//echo '<a href="'.$authUrl.'">Login</a>';
		//} else {
			//echo '<a href="/site/social_logout">Logout</a>';
		//}
		
	}
	
	public function logout()
	{

		$this->Session->delete('Customer.customer_id');
		$this->Session->delete('Customer.customer_group_id');

		//$this->Auth->logout();

		$this->Session->setFlash(__('You successfully logout.', true), 'bootstrap_alert_success');

		$this->redirect('/');
	}

	public function social_logout()
	{

		$this->Session->delete('Customer.customer_id');
		$this->Session->delete('Customer.customer_group_id');

		$clientId = '849405182417-7i9u890vlp0l998u0tcc3giup6ldmqgb.apps.googleusercontent.com'; //Google CLIENT ID
		$clientSecret = 'nX550tbB6mGcSlHjXNzxfCHQ'; //Google CLIENT SECRET
		$redirectUrl = 'http://demo2.vamshop.ru/site/social_login';  //return url (url to script)
		$homeUrl = 'http://demo2.vamshop.ru';  //return to home

		App::import('Vendor', 'Google', array('file' => 'google'.DS.'Google_Client.php'));
		$gClient = new Google_Client();
		$gClient->setApplicationName('VamShop');
		$gClient->setClientId($clientId);
		$gClient->setClientSecret($clientSecret);
		$gClient->setRedirectUri($redirectUrl);
		
		App::import('Vendor', 'Google_OAuth', array('file' => 'google'.DS.'contrib'.DS.'Google_Oauth2Service.php'));
		$google_oauthV2 = new Google_Oauth2Service($gClient);

		unset($_SESSION['token']);
		unset($_SESSION['google_data']); //Google session data unset
		$gClient->revokeToken();
		session_destroy();
	
		//$this->Auth->logout();

		$this->Session->setFlash(__('You successfully logout.', true), 'bootstrap_alert_success');

		$this->redirect('/');
	}

	public function password_recovery()
	{
		global $config;

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
					
		if (isset($_POST['customer']) && $spam_flag == false) {
			App::import('Model', 'Customer');
			$customer = new Customer();
			$customer->set($_POST['customer']);
			if ($customer->validates()) {
				
		App::uses('Sanitize', 'Utility');
		$clean = new Sanitize();
		$clean->clean($_POST);

			$user = $this->Customer->find('first', array('order' => 'Customer.id DESC', 'conditions' => array('email' => $_POST['customer']['email'])));

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

				$assignments = array(
				'link' => FULL_BASE_URL . BASE . '/site/new_password/' . $customer_data['Customer']['code'] . '/'
				);
		
				$body = $this->Smarty->fetch($email_template['EmailTemplateDescription']['content'], $assignments);

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
			  
			App::import('Model', 'Customer');
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

				$assignments = array(
				'name' => $_POST['customer']['name'],
				'firstname' => isset($fio[0]) ? $fio[0] : $_POST['customer']['name'],
				'lastname' => isset($fio[1]) ? $fio[1] : $_POST['customer']['name'],
				'email' => $user['Customer']['email'],
				'password' => $customer_password,
				'account_page' => FULL_BASE_URL . BASE . '/page/account' . $config['URL_EXTENSION']
				);
		
				$body = $this->Smarty->fetch($email_template['EmailTemplateDescription']['content'], $assignments);

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
