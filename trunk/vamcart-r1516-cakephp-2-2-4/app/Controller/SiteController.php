<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
class SiteController extends AppController {
	var $name = 'Site';
	var $uses = array('Customer');
	var $components = array('Email', 'Smarty', 'ConfigurationBase');

	function register()
	{
		global $config;

		App::uses('Sanitize', 'Utility');
		$clean = new Sanitize();
		$clean->clean($_POST);
		if (isset($_POST['customer'])) {
			$customer = new Customer();
			$customer->set($_POST['customer']);
			if ($customer->validates()) {
				$_POST['customer']['password'] = md5($_POST['customer']['password']);
				$_POST['customer']['retype'] = md5($_POST['customer']['retype']);
				$ret = $customer->save($_POST['customer']);
				
				// Retrieve email template
				App::import('Model', 'EmailTemplate');
				$this->EmailTemplate =& new EmailTemplate();

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
	
	function login()
	{
	}

	function logout()
	{
		$this->Auth->logout();

		if (isset($this->params['url']['return_url'])) {
			$return_url = urldecode(base64_decode($this->params['url'][return_url]));
		} else {
			$return_url = '/';
		}

		$this->redirect($return_url);
	}

}
