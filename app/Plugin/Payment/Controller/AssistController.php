<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('PaymentAppController', 'Payment.Controller');

class AssistController extends PaymentAppController {
	var $uses = array('PaymentMethod', 'Order');
	var $module_name = 'Assist';
	var $icon = 'assist.png';

	function settings ()
	{
		$this->set('data', $this->PaymentMethod->findByAlias($this->module_name));
	}

	function install()
	{
		$new_module = array();
		$new_module['PaymentMethod']['active'] = '1';
		$new_module['PaymentMethod']['default'] = '0';
		$new_module['PaymentMethod']['name'] = Inflector::humanize($this->module_name);
		$new_module['PaymentMethod']['icon'] = $this->icon;
		$new_module['PaymentMethod']['alias'] = $this->module_name;

		$new_module['PaymentMethodValue'][0]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][0]['key'] = 'assist_shop_id';
		$new_module['PaymentMethodValue'][0]['value'] = '';

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
			
		$order = $this->Order->read(null,$_SESSION['Customer']['order_id']);
		
		$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));

		$assist_settings = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'assist_shop_id')));
		$assist_shop_id = $assist_settings['PaymentMethodValue']['value'];
		$return_url = 'http://'.$_SERVER['HTTP_HOST'] .  BASE . '/orders/place_order/';
		
		$content = '<form action="https://secure.assist.ru/shops/purchase.cfm" method="post">
			<input type="hidden" name="Shop_IDP" value="'.$assist_shop_id.'">
			<input type="hidden" name="Order_IDP" value="' . $_SESSION['Customer']['order_id'] . '">
			<input type="hidden" name="Subtotal_P" value="' . $order['Order']['total'] . '">
			<input type="hidden" name="Currency" value="' . $_SESSION['Customer']['currency_code'] . '">
			<input type="hidden" name="URL_RETURN" value="' . $return_url . '">
			<input type="hidden" name="Comment" value="' . $_SESSION['Customer']['order_id'] . ' ' . $order['Order']['email'] . '">';
						
		$content .= '
			<button class="btn btn-inverse" type="submit" value="{lang}Process to Payment{/lang}"><i class="icon-ok"></i> {lang}Process to Payment{/lang}</button>
			</form>';
	
	// Save the order
	
		foreach($_POST AS $key => $value)
			$order['Order'][$key] = $value;
		
		// Get the default order status
		$default_status = $this->Order->OrderStatus->find('first', array('conditions' => array('default' => '1')));
		$order['Order']['order_status_id'] = $default_status['OrderStatus']['id'];

		// Save the order
		$this->Order->save($order);

		return $content;
	}

	function after_process()
	{
	}
	
	
	function result()
	{
		$this->layout = 'empty';
	}
	
}

?>