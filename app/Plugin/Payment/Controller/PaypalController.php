<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('PaymentAppController', 'Payment.Controller');

class PaypalController extends PaymentAppController {
	public $uses = array('PaymentMethod', 'Order');
	public $components = array('OrderBase');
	public $module_name = 'Paypal';
	public $icon = 'paypal.png';
	
	public function settings ()
	{
		$this->set('data', $this->PaymentMethod->findByAlias($this->module_name));
	}

	public function install()
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

	public function uninstall()
	{

		$module_id = $this->PaymentMethod->findByAlias($this->module_name);

		$this->PaymentMethod->delete($module_id['PaymentMethod']['id'], true);
			
		$this->Session->setFlash(__('Module Uninstalled'));
		$this->redirect('/payment_methods/admin/');
	}
	
	public function before_process () 
	{
		$order = $this->OrderBase->get_order();
		
		$paypal_email = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'paypal_email')));
		$email = $paypal_email['PaymentMethodValue']['value'];
		$return_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] .  BASE . '/orders/place_order/';
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
			$amount = $product['price'];
			$content .= '<input type="hidden" name="item_name_' . $product_count . '" value="' . $product['name'] . '">
						 <input type="hidden" name="quantity_' . $product_count . '" value="' . $product['quantity'] . '">
						 <input type="hidden" name="tax_' . $product_count . '" value="' . number_format($product['tax'], 2) . '">
						 <input type="hidden" name="amount_' . $product_count . '" value="' . $amount . '">';

			++$product_count;
		}
		$content .= '<input type="hidden" name="item_name_' . $product_count . '" value="'. __('Shipping') .'">
					 <input type="hidden" name="charset" value="utf-8">		
					 <input type="hidden" name="amount_' . $product_count . '" value="' . $order['Order']['shipping'] . '">';		
						
		$content .= '
			<button class="btn btn-default" type="submit" value="{lang}Confirm Order{/lang}"><i class="fa fa-check"></i> {lang}Confirm Order{/lang}</button>
			</form>';
		return $content;
	}

	public function payment_after($order_id = 0)
	{
		if(empty($order_id))
		return;
		
		$order = $this->Order->read(null,$order_id);

		$paypal_email = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'paypal_email')));
		$email = $paypal_email['PaymentMethodValue']['value'];
		$return_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] .  BASE . '/orders/place_order/';
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
			$amount = $product['price'];
			$content .= '<input type="hidden" name="item_name_' . $product_count . '" value="' . $product['name'] . '">
						 <input type="hidden" name="quantity_' . $product_count . '" value="' . $product['quantity'] . '">
						 <input type="hidden" name="tax_' . $product_count . '" value="' . number_format($product['tax'], 2) . '">
						 <input type="hidden" name="amount_' . $product_count . '" value="' . $amount . '">';

			++$product_count;
		}
		$content .= '<input type="hidden" name="item_name_' . $product_count . '" value="'. __('Shipping') .'">
					 <input type="hidden" name="charset" value="utf-8">		
					 <input type="hidden" name="amount_' . $product_count . '" value="' . $order['Order']['shipping'] . '">';		
						
		$content .= '
			<button class="btn btn-default" type="submit" value="{lang}Pay Now{/lang}"><i class="fa fa-dollar"></i> {lang}Pay Now{/lang}</button>
			</form>';

		return $content;

	}
	
	public function after_process()
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