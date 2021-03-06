<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('PaymentAppController', 'Payment.Controller');

class OpenbankController extends PaymentAppController {
	public $uses = array('PaymentMethod', 'Order', 'EmailTemplate');
	public $components = array('Email', 'Smarty', 'ContentBase');
	public $module_name = 'Openbank';
	public $icon = 'openbank.png';

	public function settings ()
	{
		$this->set('data', $this->PaymentMethod->findByAlias($this->module_name));
	}

	public function install()
	{
		$new_module = array();
		$new_module['PaymentMethod']['active'] = '1';
		$new_module['PaymentMethod']['default'] = '0';
		$new_module['PaymentMethod']['name'] = Inflector::humanize($this->module_name);
		$new_module['PaymentMethod']['icon'] = $this->icon;
		$new_module['PaymentMethod']['alias'] = $this->module_name;

		$new_module['PaymentMethodValue'][0]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][0]['key'] = 'partnerid';
		$new_module['PaymentMethodValue'][0]['value'] = '';

		$new_module['PaymentMethodValue'][1]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][1]['key'] = 'serviceid';
		$new_module['PaymentMethodValue'][1]['value'] = '';

		$this->PaymentMethod->saveAll($new_module);

		$this->Session->setFlash(__('Module Installed'));
		$this->redirect('/payment_methods/admin/');
	}

	public function uninstall()
	{

		$module_id = $this->PaymentMethod->findByAlias($this->module_name);

		$this->PaymentMethod->delete($module_id['PaymentMethod']['id'], true);
			
		$this->Session->setFlash(__('Module Uninstalled'));
		$this->redirect('/payment_methods/admin/');
	}

	public function before_process () 
	{
			
		global $config;
		
		$order = $this->Order->read(null,$_SESSION['Customer']['order_id']);

		$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));

		$openbank_settings_partnerid = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'partnerid')));
		$openbank_partnerid = $openbank_settings_partnerid['PaymentMethodValue']['value'];

		$openbank_settings_serviceid = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'serviceid')));
		$openbank_serviceid = $openbank_settings_serviceid['PaymentMethodValue']['value'];

		$success_url = FULL_BASE_URL . BASE . '/orders/place_order/';
		$fail_url = FULL_BASE_URL . BASE . '/page/checkout' . $config['URL_EXTENSION'];
		
		$content = '
			<a class="btn btn-default" href="https://secure.openbank.ru/openapi/deploy/open_payments/index.html?partnerId='.$openbank_partnerid.'&serviceId='.$openbank_serviceid.'&account='.$order['Order']['id'].'&amount='.$order['Order']['total'].'&emailEnabled=1&email='.$order['Order']['email'].'&phoneEnabled=1&phone='.$order['Order']['phone'].'&supportEmail='.$config['SEND_EXTRA_EMAIL'].'&partnerBackUrl='.$success_url.'&amountReadOnly=1&paramsReadOnly=1" target="_blank" value="{lang}Process to Payment{/lang}"><i class="fa fa-check"></i> {lang}Process to Payment{/lang}</a>			
			';
						
	// Save the order
	
		foreach($_POST AS $key => $value)
			$order['Order'][$key] = $value;
		
		// Get the default order status
		$default_status = $this->Order->OrderStatus->find('first', array('conditions' => array('default' => '1')));
		$order['Order']['order_status_id'] = $default_status['OrderStatus']['id'];

		// Save the order
		$this->Order->save($order);

			// Sending email
			
			// Retrieve email template
			$this->EmailTemplate->unbindModel(array('hasMany' => array('EmailTemplateDescription')));
			$this->EmailTemplate->bindModel(
				array('hasOne' => array(
					'EmailTemplateDescription' => array(
						'className'  => 'EmailTemplateDescription',
						'conditions' => 'language_id = ' . $this->Session->read('Customer.language_id')
					)
				))
			);

			// Get email template
			$email_template = $this->EmailTemplate->findByAlias('new-order');
			// Get current order status
			$current_order_status = $this->Order->OrderStatus->OrderStatusDescription->find('first', array('conditions' => array('OrderStatusDescription.order_status_id =' => $order['Order']['order_status_id'], 'OrderStatusDescription.language_id =' => $this->Session->read('Customer.language_id'))));

			// Email Subject
			$subject = $email_template['EmailTemplateDescription']['subject'];
			$subject = str_replace('{$order_number}',$order['Order']['id'], $subject);
			$subject = $config['SITE_NAME'] . ' - ' . $subject;

			$fio = explode(" ", $order['Order']['bill_name']);		

			$assignments1 = array(
			'name' => $order['Order']['bill_name'],
			'firstname' => isset($fio[0]) ? $fio[0] : $order['Order']['bill_name'],
			'lastname' => isset($fio[1]) ? $fio[1] : $order['Order']['bill_name'],
			'order_number' => $order['Order']['id'],
			'order_status' => $current_order_status['OrderStatusDescription']['name'],
			'bill_name' => $order['Order']['bill_name'],
			'bill_line_1' => $order['Order']['bill_line_1'],
			'bill_line_2' => $order['Order']['bill_line_2'],
			'bill_city' => $order['Order']['bill_city'],
			'bill_state' => $order['BillState']['name'],
			'bill_country' => $order['BillCountry']['name'],
			'bill_zip' => $order['Order']['bill_zip'],
			'ship_name' => $order['Order']['ship_name'],
			'ship_line_1' => $order['Order']['ship_line_1'],
			'ship_line_2' => $order['Order']['ship_line_2'],
			'ship_city' => $order['Order']['ship_city'],
			'ship_state' => $order['ShipState']['name'],
			'ship_country' => $order['ShipCountry']['name'],
			'ship_zip' => $order['Order']['ship_zip']
			);

			$order = $this->Order->find('all', array('conditions' => array('Order.id' => $order['Order']['id'])));

			$order = $order[0];

			$assignments2 = array(
			'shipping_method' => __($order['ShippingMethod']['name'], true),
			'shipping_method_description' => __($order['ShippingMethod']['description'], true),
			'payment_method' => __($order['PaymentMethod']['name'], true),
			'payment_method_description' => __($order['PaymentMethod']['description'], true),
			'date' => $order['Order']['created'],
			'phone' => $order['Order']['phone'],
			'email' => $order['Order']['email']
			);

			$assignments3 = array(
			'order_total' => $this->CurrencyBase->display_price($order['Order']['total']),
			'shipping_total' => $this->CurrencyBase->display_price($order['Order']['shipping'])
			);
			
			
			$order_comment = $this->Order->OrderComment->find('first', array('order'   => 'OrderComment.id DESC', 'conditions' => array('OrderComment.order_id' => $order['Order']['id'])));

			$comments = '';
			if (isset($order_comment['OrderComment']['comment']) && $order_comment['OrderComment']['comment'] != '')
			$comments = $order_comment['OrderComment']['comment'];

			$assignments4 = array(
			'comments' => $comments
			);

			$order_products = array();
			foreach($order['OrderProduct'] AS $key => $value) {

			$content_information = $this->ContentBase->get_content_information($order['OrderProduct'][$key]['content_id']);			
			$content_description = $this->ContentBase->get_content_description($order['OrderProduct'][$key]['content_id']);			
	
			App::import('Model', 'ContentImage');
			$ContentImage = new ContentImage();
	
			$ContentImage = $ContentImage->find('first', array('conditions' => array('ContentImage.content_id' => $order['OrderProduct'][$key]['content_id'])));
	
				$order_products[$key] = $value;
				$order_products[$key]['total'] = $this->CurrencyBase->display_price($order['OrderProduct'][$key]['quantity']*$order['OrderProduct'][$key]['price']);
				$order_products[$key]['content_information'] = $content_information['Content'];
				$order_products[$key]['content_description'] = $content_description['ContentDescription'];
				$order_products[$key]['content_image'] = $ContentImage['ContentImage']['image'];
			}

			$assignments5 = array(
			'order_products' => $order_products
			);
			
			$assignments = array_merge($assignments1, $assignments2, $assignments3, $assignments4, $assignments5);

			$body = $this->Smarty->fetch($email_template['EmailTemplateDescription']['content'], $assignments);

			if ($order['Order']['email'] != '') {
				// Set up mail
				$this->Email->init();
				$this->Email->From = $config['NEW_ORDER_FROM_EMAIL'];
				$this->Email->FromName = __($config['NEW_ORDER_FROM_NAME'],true);
				// Send to customer
				$this->Email->AddAddress($order['Order']['email']);
				$this->Email->Subject = $subject;

				// Email Body
				$this->Email->Body = $body;

				// Sending mail
				$this->Email->send();
			}
		
			// Send to admin
			if($config['SEND_EXTRA_EMAIL'] != '') {

				// Set up mail
				$this->Email->init();
				$this->Email->From = $config['NEW_ORDER_FROM_EMAIL'];
				$this->Email->FromName = __($config['NEW_ORDER_FROM_NAME'],true);
				$this->Email->AddAddress($config['SEND_EXTRA_EMAIL']);
				if ($order['Order']['email'] != '') $this->Email->AddReplyTo($order['Order']['email']);
				$this->Email->Subject = $subject;

				// Email Body
				$this->Email->Body = $body;
		
				// Sending mail
				$this->Email->send();

			}


		return $content;
	}

	public function after_process()
	{
	}
	
	public function payment_after($order_id = 0)
	{
		global $config;

		if(empty($order_id))
		return;

		$order = $this->Order->read(null,$order_id);

		$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));

		$openbank_settings_partnerid = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'partnerid')));
		$openbank_partnerid = $openbank_settings_partnerid['PaymentMethodValue']['value'];

		$openbank_settings_serviceid = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'serviceid')));
		$openbank_serviceid = $openbank_settings_serviceid['PaymentMethodValue']['value'];

		$success_url = FULL_BASE_URL . BASE . '/orders/place_order/';
		$fail_url = FULL_BASE_URL . BASE . '/page/checkout' . $config['URL_EXTENSION'];
		
		$content = '
			<a class="btn btn-default" href="https://secure.openbank.ru/openapi/deploy/open_payments/index.html?partnerId='.$openbank_partnerid.'&serviceId='.$openbank_serviceid.'&account='.$order['Order']['id'].'&amount='.$order['Order']['total'].'&emailEnabled=1&email='.$order['Order']['email'].'&phoneEnabled=1&phone='.$order['Order']['phone'].'&supportEmail='.$config['SEND_EXTRA_EMAIL'].'&partnerBackUrl='.$success_url.'&amountReadOnly=1&paramsReadOnly=1" target="_blank" value="{lang}Pay Now{/lang}"><i class="fa fa-dollar"></i> {lang}Pay Now{/lang}</a>
			';

						
			// Sending email
			
			// Retrieve email template
			$this->EmailTemplate->unbindModel(array('hasMany' => array('EmailTemplateDescription')));
			$this->EmailTemplate->bindModel(
				array('hasOne' => array(
					'EmailTemplateDescription' => array(
						'className'  => 'EmailTemplateDescription',
						'conditions' => 'language_id = ' . $this->Session->read('Customer.language_id')
					)
				))
			);

			// Get email template
			$email_template = $this->EmailTemplate->findByAlias('new-order');
			// Get current order status
			$current_order_status = $this->Order->OrderStatus->OrderStatusDescription->find('first', array('conditions' => array('OrderStatusDescription.order_status_id =' => $order['Order']['order_status_id'], 'OrderStatusDescription.language_id =' => $this->Session->read('Customer.language_id'))));

			// Email Subject
			$subject = $email_template['EmailTemplateDescription']['subject'];
			$subject = str_replace('{$order_number}',$order['Order']['id'], $subject);
			$subject = $config['SITE_NAME'] . ' - ' . $subject;

			$fio = explode(" ", $order['Order']['bill_name']);		

			$assignments1 = array(
			'name' => $order['Order']['bill_name'],
			'firstname' => isset($fio[0]) ? $fio[0] : $order['Order']['bill_name'],
			'lastname' => isset($fio[1]) ? $fio[1] : $order['Order']['bill_name'],
			'order_number' => $order['Order']['id'],
			'order_status' => $current_order_status['OrderStatusDescription']['name'],
			'bill_name' => $order['Order']['bill_name'],
			'bill_line_1' => $order['Order']['bill_line_1'],
			'bill_line_2' => $order['Order']['bill_line_2'],
			'bill_city' => $order['Order']['bill_city'],
			'bill_state' => $order['BillState']['name'],
			'bill_country' => $order['BillCountry']['name'],
			'bill_zip' => $order['Order']['bill_zip'],
			'ship_name' => $order['Order']['ship_name'],
			'ship_line_1' => $order['Order']['ship_line_1'],
			'ship_line_2' => $order['Order']['ship_line_2'],
			'ship_city' => $order['Order']['ship_city'],
			'ship_state' => $order['ShipState']['name'],
			'ship_country' => $order['ShipCountry']['name'],
			'ship_zip' => $order['Order']['ship_zip']
			);

			$order = $this->Order->find('all', array('conditions' => array('Order.id' => $order['Order']['id'])));

			$order = $order[0];

			$assignments2 = array(
			'shipping_method' => __($order['ShippingMethod']['name'], true),
			'shipping_method_description' => __($order['ShippingMethod']['description'], true),
			'payment_method' => __($order['PaymentMethod']['name'], true),
			'payment_method_description' => __($order['PaymentMethod']['description'], true),
			'date' => $order['Order']['created'],
			'phone' => $order['Order']['phone'],
			'email' => $order['Order']['email']
			);

			$assignments3 = array(
			'order_total' => $this->CurrencyBase->display_price($order['Order']['total']),
			'shipping_total' => $this->CurrencyBase->display_price($order['Order']['shipping'])
			);
			
			
			$order_comment = $this->Order->OrderComment->find('first', array('order'   => 'OrderComment.id DESC', 'conditions' => array('OrderComment.order_id' => $order['Order']['id'])));

			$comments = '';
			if (isset($order_comment['OrderComment']['comment']) && $order_comment['OrderComment']['comment'] != '')
			$comments = $order_comment['OrderComment']['comment'];

			$assignments4 = array(
			'comments' => $comments
			);

			$order_products = '';
			foreach($order['OrderProduct'] AS $product) {
				$order_products .= $product['quantity'] . ' x ' . $product['name'] . ' = ' . $this->CurrencyBase->display_price($product['quantity']*$product['price']) . "\n";
				if ('' != $product['filename']) {
					$order_products .= __('Download link: ', true) . FULL_BASE_URL . BASE . '/download/' . $order['Order']['id'] . '/' . $product['id'] . '/' . $product['download_key'] . "\n";
				}
			}

			$order_products .= "\n" . __($order['ShippingMethod']['name'], true) . ': ' . $this->CurrencyBase->display_price($order['Order']['shipping']) . "\n";
			$order_products .= __('Order Total',true) . ': ' . $this->CurrencyBase->display_price($order['Order']['total']) . "\n";

			$assignments5 = array(
			'products' => $order_products,
			'products_array' => $order['OrderProduct']
			);
			
			$assignments = array_merge($assignments1, $assignments2, $assignments3, $assignments4, $assignments5);

			$body = $this->Smarty->fetch($email_template['EmailTemplateDescription']['content'], $assignments);

			if ($order['Order']['email'] != '') {
				// Set up mail
				$this->Email->init();
				$this->Email->From = $config['NEW_ORDER_FROM_EMAIL'];
				$this->Email->FromName = __($config['NEW_ORDER_FROM_NAME'],true);
				// Send to customer
				$this->Email->AddAddress($order['Order']['email']);
				$this->Email->Subject = $subject;

				// Email Body
				$this->Email->Body = $body;

				// Sending mail
				$this->Email->send();
			}
		
			// Send to admin
			if($config['SEND_EXTRA_EMAIL'] != '') {

				// Set up mail
				$this->Email->init();
				$this->Email->From = $config['NEW_ORDER_FROM_EMAIL'];
				$this->Email->FromName = __($config['NEW_ORDER_FROM_NAME'],true);
				$this->Email->AddAddress($config['SEND_EXTRA_EMAIL']);
				if ($order['Order']['email'] != '') $this->Email->AddReplyTo($order['Order']['email']);
				$this->Email->Subject = $subject;

				// Email Body
				$this->Email->Body = $body;
		
				// Sending mail
				$this->Email->send();

			}

		return $content;

	}
	
	public function result()
	{
		$this->layout = false;
		$order = $this->Order->read(null,$_POST['partnerMdOrder']);

		if ($_POST['operation'] == 'approved') {
		
		$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));
		$order_data = $this->Order->find('first', array('conditions' => array('Order.id' => $_POST['partnerMdOrder'])));
		$order_data['Order']['order_status_id'] = $payment_method['PaymentMethod']['order_status_id'];
		
		$this->Order->save($order_data);
		
		}
	
	}
	
}

?>