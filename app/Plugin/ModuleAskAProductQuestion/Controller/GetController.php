<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

class GetController extends ModuleAskAProductQuestionAppController {
	public $uses = array('EmailTemplate');
	public $components = array('Email', 'Smarty', 'ContentBase');
		
	public function ask_link ($id = null)
	{
		global $content, $config;
		if ($id > 0) $content['Content']['id'] = $id;
		$assignments = array('ask_a_product_question_link' => BASE . '/module_ask_a_product_question/get/ask_form/'.$content['Content']['id']);
		return $assignments;
	}
	
	public function ask_form ($content_id = null)
	{
		$this->layout = null;
		global $content, $config;

		$_POST['content_id'] = (isset($_POST['content_id']) ? $_POST['content_id'] : (int)$content_id);

		if ($_POST['content_id'] > 0) {
			$content_id = (int)$_POST['content_id'];
		} else {
			$content_id = (int)$content_id;
		}

		$content = $this->ContentBase->get_content_information($content_id);			
		$content_description = $this->ContentBase->get_content_description($content_id);			

		$this->set('content_id', $content_id);
		$this->set('content_name', $content_description['ContentDescription']['name']);

		$this->set('content_name', $content_description['ContentDescription']['name']);

		App::import('Model', 'ContentImage');
		$ContentImage = new ContentImage();

		$ContentImage = $ContentImage->find('first', array('conditions' => array('ContentImage.content_id' => $content_id)));

		$this->set('content_image', $ContentImage['ContentImage']['image']);

		if(!empty($_POST) && !$this->request->is('ajax'))
		{

		App::uses('Sanitize', 'Utility');
		$clean = new Sanitize();
		$clean->clean($_POST);

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
	
			if($spam_flag == true)
			{
				$this->redirect('/' . $content['ContentType']['name'] . '/' . $content['Content']['alias'] . $config['URL_EXTENSION']);
			}
			
			if ($_POST['email'] != '' && $_POST['content'] != '') {

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
				$email_template = $this->EmailTemplate->findByAlias('ask_a_product_question');

				// Email Subject
				$subject = $email_template['EmailTemplateDescription']['subject'];
				$subject = str_replace('{$product_name}',$content_description['ContentDescription']['name'], $subject);
				$subject = str_replace('{$store_name}',$config['SITE_NAME'], $subject);

				$body = $email_template['EmailTemplateDescription']['content'];
				$body = str_replace('{$product_name}', $content_description['ContentDescription']['name'], $body);
				$body = str_replace('{$question}', $_POST['content'], $body);

				$this->Email->init();
				$this->Email->From = $config['SEND_CONTACT_US_EMAIL'];
				$this->Email->FromName = $config['SEND_CONTACT_US_EMAIL'];
				$this->Email->AddReplyTo($_POST['email'], $_POST['name']);

				// Send email to admin
				if (filter_var($config['SEND_CONTACT_US_EMAIL'], FILTER_VALIDATE_EMAIL)) {
				$this->Email->AddAddress($config['SEND_CONTACT_US_EMAIL']);
				}
				
				// Send email to customer
				if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
				$this->Email->AddAddress($_POST['email']);
				}
				
				$this->Email->Subject = $subject;

				// Email Body
				$this->Email->Body = $body;

				// Sending mail
				$this->Email->send();

			}

			$this->redirect('/page/ask_a_product_question'.$config['URL_EXTENSION']);
		}

	}

	public function ask_success ()
	{
		$assignments = array();		
		return $assignments;
	}
	
	/**
	* The template function simply calls the view specified by the $action parameter.
	*
	*/
	public function template ($action)
	{
	}

}
