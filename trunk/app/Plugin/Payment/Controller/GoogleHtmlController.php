<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('PaymentAppController', 'Payment.Controller');

class GoogleHtmlController extends PaymentAppController {
	var $uses = array('PaymentMethod', 'Order');
	var $components = array('OrderBase');
	var $module_name = 'GoogleHtml';
	var $icon = 'googlecheckout.png';

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
		$new_module['PaymentMethodValue'][0]['key'] = 'google_html_merchant_id';
		$new_module['PaymentMethodValue'][0]['value'] = 'your-google-merchant-id';

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
		global $order;
		
		App::import('Model', 'PaymentMethod');
		$this->PaymentMethod =& new PaymentMethod();
		
		$google_merchant_id = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'google_html_merchant_id')));
		$merchant_id = $google_merchant_id['PaymentMethodValue']['value'];
		
		
		$return_url = $_SERVER['HTTP_HOST'] .'/orders/place_order/';
		$cancel_url = $_SERVER['HTTP_HOST'];
		
		$content = '<form method="POST" action="https://sandbox.google.com/checkout/cws/v2/Merchant/' . $merchant_id . '/checkout">';
		
		$product_count = 1;
		foreach($order['OrderProduct'] AS $product)
		{
			$content .= '<input type="hidden" name="item_name_' . $product_count . '" value="' . $product['name'] . '">
						 <input type="hidden" name="item_quantity_' . $product_count . '" value="' . $product['quantity'] . '">
						 <input type="hidden" name="item_price_' . $product_count . '" value="' . $product['price'] . '">';

			++$product_count;
		}
		$content .= '
						<input type="hidden" name="ship_method_name" value="' . $order['ShippingMethod']['name'] . '">
						<input type="hidden" name="ship_method_price" value="' . $order['Order']['shipping'] . '">
					';		
						
		$content .= '
			    <input type="image" name="Google Checkout" alt="Fast checkout through Google"
        		src="http://sandbox.google.com/checkout/buttons/checkout.gif?merchant_id=' . $merchant_id . '
             	&w=180&h=46&style=white&variant=text&loc=en_US"  height="46" width="180">
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