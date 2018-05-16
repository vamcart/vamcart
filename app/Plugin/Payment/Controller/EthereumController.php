<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('PaymentAppController', 'Payment.Controller');

class EthereumController extends PaymentAppController {
	public $uses = array('Module', 'EthereumInvoice', 'PaymentMethod', 'Order', 'EmailTemplate');
	public $components = array('Email', 'Smarty', 'ContentBase');
	public $module_name = 'Ethereum';
	public $icon = 'ethereum.png';

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
		$new_module['PaymentMethodValue'][0]['key'] = 'eth_wallet';
		$new_module['PaymentMethodValue'][0]['value'] = '';

		$new_module['PaymentMethodValue'][1]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][1]['key'] = 'eth_api_key';
		$new_module['PaymentMethodValue'][1]['value'] = '';

		$this->PaymentMethod->saveAll($new_module);

		// Create the database table
		$install_query = "
		DROP TABLE IF EXISTS ethereum_invoices;
		CREATE TABLE `ethereum_invoices` (
		  `id` int(10) auto_increment,
		  `order_id` int(10),
		  `value` double,
		  `created` datetime,
		  `modified` datetime,
		  PRIMARY KEY  (`id`),
		  INDEX order_id (order_id)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		";		
		$this->Module->query($install_query);

		$this->Session->setFlash(__('Module Installed'));
		$this->redirect('/payment_methods/admin/');
	}

	public function uninstall()
	{

		$module_id = $this->PaymentMethod->findByAlias($this->module_name);

		$this->PaymentMethod->delete($module_id['PaymentMethod']['id'], true);

		// Delete the module record
		$uninstall_query = "DROP TABLE IF EXISTS `ethereum_invoices`;";
		$this->Module->query($uninstall_query);
			
		$this->Session->setFlash(__('Module Uninstalled'));
		$this->redirect('/payment_methods/admin/');
	}

	public function before_process () 
	{
			
		global $config;
		
		$order = $this->Order->read(null,$_SESSION['Customer']['order_id']);
		
		$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));
		
		$ethereum_settings_wallet = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'eth_wallet')));
		$ethereum_wallet = $ethereum_settings_wallet['PaymentMethodValue']['value'];

		$ethereum_settings_key = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'eth_api_key')));
		$ethereum_key = $ethereum_settings_key['PaymentMethodValue']['value'];
		
		$order_currency = $this->Session->read('Customer.currency_code');
		$ethereum_invoice = array();
		$content = '';
		
		$success_url = FULL_BASE_URL . BASE . '/orders/place_order/';
		$fail_url = FULL_BASE_URL . BASE . '/page/checkout' . $config['URL_EXTENSION'];
		
		$ethereum_wallet_data = json_decode(file_get_contents('https://api.coinbase.com/v2/prices/ETH-'.$order_currency.'/spot'),true);

		$order_total = $order['Order']['total'];
		$ethereum_order_total = $order['Order']['total']*(1/$ethereum_wallet_data['data']['amount']);		

		$eth_invoice = $this->EthereumInvoice->find('first', array('conditions' => array('order_id' => $order['Order']['id'])));
		
		if(!$eth_invoice) {
		
		$ethereum_invoice['EthereumInvoice']['order_id'] = $order['Order']['id'];
		$ethereum_invoice['EthereumInvoice']['value'] = number_format($ethereum_order_total, 4);

		// Save the eth invoice
		$this->EthereumInvoice->saveAll($ethereum_invoice);
		
		} else {

		$ethereum_order_total = number_format($eth_invoice['EthereumInvoice']['value'],4);		
		
		}
		
		$content .= '<img src="https://chart.googleapis.com/chart?cht=qr&chs=250x250&chl='.$ethereum_wallet.'" alt="'.$ethereum_wallet.'" width="250" height="250" />';
		$content .= '<br />';
		$content .= __("Our eth wallet is:") . ' ' . '<h3><strong>' . $ethereum_wallet . '</strong></h3>';
		$content .= '<br />';
		$content .= __("Order Total (ETH):") . ' <h3><strong>' . number_format($ethereum_order_total, 4) . '</strong></h3>';
		$content .= '<br />';
		$content .= '<br />';
		$content .= __("Please make transaction to our eth wallet!");
		$content .= '<br />';
		$content .= '<br />';
		$content .= '<h3><u><a href="'.FULL_BASE_URL . BASE . '/payment/ethereum/result/" target="_blank">'.__("Check your order payment confirmation!") . '</a></u></h3>';
		$content .= '<br />';
		$content .= '<br />';
		$content .= '	
		<form action="' . BASE . '/orders/place_order/" method="post">
		<button class="btn btn-default" type="submit" value="{lang}Confirm Order{/lang}"><i class="fa fa-check"></i> {lang}Confirm Order{/lang}</button>
		</form>';
						
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
	}
	
	public function result()
	{
		global $order;
		
		$this->layout = false;
  
		$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));

		$ethereum_settings_wallet = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'eth_wallet')));
		$ethereum_wallet = $ethereum_settings_wallet['PaymentMethodValue']['value'];

		$ethereum_settings_key = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'eth_api_key')));
		$ethereum_key = $ethereum_settings_key['PaymentMethodValue']['value'];
  
		$eth_invoice = $this->EthereumInvoice->find('first', array('conditions' => array('order_id' => $order['Order']['id'])));


		
		$eth_transactions_data = json_decode(file_get_contents('https://api.etherscan.io/api?module=account&action=txlist&address='.$ethereum_wallet.'&startblock=0&endblock=9999999999999999&page=1&offset=5&sort=desc&apikey='.$ethereum_key),true);
		
		function search_array(&$array, $val)
		{
		    foreach ($array as $key => &$value) {
		        if (is_array($value)) {
		            search_array($value, $val);
		        } elseif (stripos($value, $val) === FALSE) {
		            unset($array[$key]);
		        }
		    }
		}
		
		$result = false;
		
		search_array($eth_transactions_data['result'], substr($this->EthereumInvoice->eth2wei($eth_invoice['EthereumInvoice']['value']),0,4));
		$result = array_filter($eth_transactions_data['result']);
		
		//echo var_dump($result);

	     if ($result) {
				echo __('Payment transaction for this order confirmed!');     
				
					$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));
					$order_data = $this->Order->find('first', array('conditions' => array('Order.id' => $order['Order']['id'])));
					$order_data['Order']['order_status_id'] = $payment_method['PaymentMethod']['order_status_id'];
					
					$this->Order->save($order_data);
				 
	      } else {
				echo __('Payment transaction for this order not found!');      
	      }	

	}
	
}

?>