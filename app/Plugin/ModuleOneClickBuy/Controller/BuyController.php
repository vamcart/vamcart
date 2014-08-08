<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

class BuyController extends ModuleOneClickBuyAppController {
	public $uses = array('Order', 'EmailTemplate');
	public $components = array('Email', 'Smarty', 'ContentBase', 'OrderBase');
		
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

		if(!empty($_POST) && $_POST['phone'] != '')
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

			// Save the order
			$this->purchase_product();
			
			if (filter_var($config['SEND_EXTRA_EMAIL'], FILTER_VALIDATE_EMAIL) or filter_var($_POST['phone'], FILTER_VALIDATE_EMAIL)) {

				// Get email template
				$email_template = $this->EmailTemplate->findByAlias('one_click_buy');

				// Email Subject
				$subject = $email_template['EmailTemplateDescription']['subject'];
				$subject = str_replace('{$product_name}',$content_description['ContentDescription']['name'], $subject);
				$subject = str_replace('{$store_name}',$config['SITE_NAME'], $subject);

				$body = $email_template['EmailTemplateDescription']['content'];
				$body = str_replace('{$product_name}', $content_description['ContentDescription']['name'], $body);
				$body = str_replace('{$contact}', $_POST['phone'], $body);

				$this->Email->init();
				$this->Email->From = $_POST['phone'];
				$this->Email->FromName = $_POST['phone'];

				// Send email to admin
				if (filter_var($config['SEND_EXTRA_EMAIL'], FILTER_VALIDATE_EMAIL)) {
				$this->Email->AddAddress($config['SEND_EXTRA_EMAIL']);
				}
				
				// Send email to customer
				if (filter_var($_POST['phone'], FILTER_VALIDATE_EMAIL)) {
				$this->Email->AddAddress($_POST['phone']);
				}
				
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

	private function purchase_product () {
		// Clean up the post
		App::uses('Sanitize', 'Utility');
		$clean = new Sanitize();
		$clean->paranoid($_POST);

			$new_order = array();

			$new_order['Order']['customer_id'] = '-1';

			$new_order['Order']['bill_name'] = __d('module_one_click_buy', 'One Click Buy');
			$new_order['Order']['ship_name'] = __d('module_one_click_buy', 'One Click Buy');

			if (!filter_var($_POST['phone'], FILTER_VALIDATE_EMAIL)) {
			$new_order['Order']['phone'] = $_POST['phone'];
			} else {			
			$new_order['Order']['email'] = $_POST['phone'];
			}
		
			// Get default shipping & payment methods and assign them to the order
			$default_payment = $this->Order->PaymentMethod->find('first', array('conditions' => array('default' => '1')));
			$new_order['Order']['payment_method_id'] = $default_payment['PaymentMethod']['id'];

			$default_shipping = $this->Order->ShippingMethod->find('first', array('conditions' => array('default' => '1')));
			$new_order['Order']['shipping_method_id'] = $default_shipping['ShippingMethod']['id'];

			// Get the default order status
			if ($new_order['Order']['order_status_id'] == 0) {
				$default_status = $this->Order->OrderStatus->find('first', array('conditions' => array('default' => '1')));
				$new_order['Order']['order_status_id'] = $default_status['OrderStatus']['id'];
			}

			// Save the order
			$this->Order->save($new_order);

			$order_id = $this->Order->getLastInsertId();
			$_SESSION['Customer']['order_id'] = $order_id;
			global $order;
			$order = $new_order;

			// Add the product to the order from the component
			$this->OrderBase->add_product($_POST['content_id'], 1);

			// Empty the cart
			$_SESSION['Customer']['order_id'] = null;

	}
	
}
