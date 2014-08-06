<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

class BuyController extends ModuleOneClickBuyAppController {
	public $uses = array('EmailTemplate');
	public $components = array('Email', 'Smarty', 'ContentBase');
		
	public function link ()
	{
		global $content, $config;
		$assignments = array('one_click_buy_link' => BASE . '/module_one_click_buy/buy/form/'.$content['Content']['id']);
		return $assignments;
	}
	
	public function form ($content_id = null)
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
			
			if ($config['SEND_EXTRA_EMAIL'] != '') {
				// Email Subject
				$subject = $content_description['ContentDescription']['name'];
				$subject = $config['SITE_NAME'] . ' - ' . __d('module_one_click_buy', 'One Click Buy') . ' - ' . $subject;

				$body = $content_description['ContentDescription']['name'] . "\n" . $_POST['phone'];

				$this->Email->init();
				$this->Email->From = $_POST['phone'];
				$this->Email->FromName = $_POST['phone'];

				$this->Email->AddAddress($config['SEND_EXTRA_EMAIL']);
				$this->Email->Subject = $subject;

				// Email Body
				$this->Email->Body = $body;

				// Sending mail
				$this->Email->send();
			}

			$this->redirect('/page/one_click_buy'.$config['URL_EXTENSION']);
		}

	}

	public function success ()
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
