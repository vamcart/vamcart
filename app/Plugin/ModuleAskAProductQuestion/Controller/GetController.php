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
		
	public function ask_link ()
	{
		global $content, $config;
		$assignments = array('ask_a_product_question_link' => BASE . '/module_ask_a_product_question/get/ask_form/'.$content['Content']['id']);
		return $assignments;
	}
	
	public function ask_form ($content_id = null)
	{
		$this->layout = null;
		global $content, $config, $filter_list;

		if ($_POST['content_id'] > 0) {
			$content_id = (int)$_POST['content_id'];
		} else {
			$content_id = (int)$content_id;
		}

		$content = $this->ContentBase->get_content_information($content_id);			
		$content_description = $this->ContentBase->get_content_description($content_id);			

		$this->set('content_id', $content_id);
		$this->set('content_name', $content_description['ContentDescription']['name']);

		if(!empty($_POST) && !$this->request->is('ajax'))
		{

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
	
			if($spam_flag == true)
			{
				$this->redirect('/' . $content['ContentType']['name'] . '/' . $content['Content']['alias'] . $config['URL_EXTENSION']);
			}
			
			if ($_POST['email'] != '' && $_POST['content'] != '') {
				// Email Subject
				$subject = $content_description['ContentDescription']['name'];
				$subject = $config['SITE_NAME'] . ' - ' . $subject;

				$body = $content_description['ContentDescription']['name'] . "\n"."\n" . $_POST['content'];

				$this->Email->init();
				$this->Email->From = $_POST['email'];
				$this->Email->FromName = $_POST['name'];

				$this->Email->AddAddress($config['SEND_CONTACT_US_EMAIL']);
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
	}
	
	/**
	* The template function simply calls the view specified by the $action parameter.
	*
	*/
	public function template ($action)
	{
	}

}
