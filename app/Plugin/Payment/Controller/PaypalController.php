<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('PaymentAppController', 'Payment.Controller');

class PaypalController extends PaymentAppController {
	var $uses = array('PaymentMethod', 'Order');
	var $components = array('OrderBase');
	var $module_name = 'Paypal';
	var $icon = 'paypal.png';
	
	function settings ()
	{
		$this->set('data', $this->PaymentMethod->findByAlias($this->module_name));
	}

	function install()
	{

		$new_module = array();
		$new_module['PaymentMethod']['active'] = '1';
		$new_module['PaymentMethod']['name'] = Inflector::humanize($this->module_name);
		$new_module['PaymentMethod']['icon'] = $this->icon;
		$new_module['PaymentMethod']['alias'] = $this->module_name;

		$new_module['PaymentMethodValue'][0]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][0]['key'] = 'paypal_email';
		$new_module['PaymentMethodValue'][0]['value'] = 'your@paypal-email-address';

		$this->PaymentMethod->saveAll($new_module);
			
		$this->Session->setFlash(__('Module Installed'));
		$this->redirect('/payment_methods/admin/');
	}

	function uninstall()
	{

		$module_id = $this->PaymentMethod->findByAlias($this->module_name);

		$this->PaymentMethod->delete($module_id['PaymentMethod']['id'], true);
			
		$this->Session->setFlash(__('Module Uninstalled'));
		$this->redirect('/payment_methods/admin/');
	}
	
	function before_process () 
	{
		$order = $this->OrderBase->get_order();
		
		$paypal_email = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'paypal_email')));
		$email = $paypal_email['PaymentMethodValue']['value'];
		$return_url = $_SERVER['HTTP_HOST'] .  BASE . '/orders/place_order/';
		$cancel_url = $_SERVER['HTTP_HOST'];
		
		$content = '
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_cart">
			<input type="hidden" name="upload" value="1">
			<input type="hidden" name="business" value="' . $email . '">
			<input type="hidden" name="return" value="' . $return_url . '">
			<input type="hidden" name="rm" value="2">
			<input type="hidden" name="cancel_return" value="' . $cancel_url . '">';
		
		$product_count = 1;
		foreach($order['OrderProduct'] AS $product)
		{
			$content .= '<input type="hidden" name="item_name_' . $product_count . '" value="' . $product['name'] . '">
						 <input type="hidden" name="quantity_' . $product_count . '" value="' . $product['quantity'] . '">
						 <input type="hidden" name="amount_' . $product_count . '" value="' . $product['price'] . '">';

			++$product_count;
		}
		$content .= '<input type="hidden" name="item_name_' . $product_count . '" value="shipping">
					 <input type="hidden" name="amount_' . $product_count . '" value="' . $order['Order']['shipping'] . '">
					 <input type="hidden" name="tax_x" value="' . $order['Order']['tax'] . '">';		
						
		$content .= '
			<button class="btn btn-inverse" type="submit" value="{lang}Confirm Order{/lang}"><i class="icon-ok"></i> {lang}Confirm Order{/lang}</button>
			</form>';
		return $content;
	}
	
	function after_process()
	{
		$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));
		$order_data = $this->Order->find('first', array('conditions' => array('Order.id' => $_SESSION['Customer']['order_id'])));
		if ($payment_method['PaymentMethod']['order_status_id'] > 0) {
		$order_data['Order']['order_status_id'] = $payment_method['PaymentMethod']['order_status_id'];
		
		$this->Order->save($order_data);
		}
	}
	
}

?>