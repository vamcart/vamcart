<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
class SiteController extends AppController {
	public $name = 'Site';
	public $uses = array('Customer', 'EmailTemplate');
	public $components = array('Email', 'Smarty', 'ConfigurationBase');

	public function register()
	{
		global $config;

		App::uses('Sanitize', 'Utility');
		$clean = new Sanitize();
		$clean->clean($_POST);
		if (isset($_POST['customer'])) {
			$customer = new Customer();
			$customer->set($_POST['customer']);
			if ($customer->validates()) {
				$_POST['customer']['password'] = Security::hash($_POST['customer']['password'], 'sha1', true);
				$_POST['customer']['retype'] = Security::hash($_POST['customer']['retype'], 'sha1', true);
				$ret = $customer->save($_POST['customer']);
				
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

				$this->Email->init();
				$this->Email->From = $config['NEW_ORDER_FROM_EMAIL'];
				$this->Email->FromName = __($config['NEW_ORDER_FROM_NAME'],true);

				// Send to customer
				$this->Email->AddAddress($_POST['customer']['email']);
				$this->Email->Subject = $subject;

				// Email Body
				$this->Email->Body = $body;

				// Sending mail
				$this->Email->send();

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
				$_POST['customer']['password'] = Security::hash($_POST['customer']['password'], 'sha1', true);
				$_POST['customer']['retype'] = Security::hash($_POST['customer']['retype'], 'sha1', true);
				$ret = $customer->save($_POST['customer']);

				$this->redirect('/customer/account_edit'  . $config['URL_EXTENSION']);
				
			} else {
				$errors = $customer->invalidFields();
				$this->Session->write('loginFormErrors', $errors);
				$this->Session->write('loginFormData', $customer->data['Customer']);
				$this->redirect('/customer/account_edit'  . $config['URL_EXTENSION']);
			}
		} else {
			$this->redirect('/customer/account_edit'  . $config['URL_EXTENSION']);
		}
	}
	
	public function login()
	{
		App::uses('Sanitize', 'Utility');
		$clean = new Sanitize();
		$clean->clean($_POST);

		$customer_id = $this->Customer->find('first', array('conditions' => array('email' => $_POST['data']['Customer']['email'])));

		if ($customer_id['Customer']['password'] == Security::hash( $_POST['data']['Customer']['password'], 'sha1', true)) {

		$this->Session->write('customer_id', $customer_id['Customer']['id']);

		} else {

		$this->Session->delete('customer_id');
			
		}

		$this->redirect($_SERVER['HTTP_REFERER']);

	}

	public function logout()
	{

		$this->Session->delete('customer_id');

		//$this->Auth->logout();

		$this->redirect($_SERVER['HTTP_REFERER']);
	}

}
