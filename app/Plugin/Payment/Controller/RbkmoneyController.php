<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('PaymentAppController', 'Payment.Controller');

class RbkmoneyController extends PaymentAppController {
	var $uses = array('PaymentMethod', 'Order');
	var $module_name = 'Rbkmoney';
	var $icon = 'rbkmoney.png';

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
		$new_module['PaymentMethodValue'][0]['key'] = 'store_id';
		$new_module['PaymentMethodValue'][0]['value'] = '';

		$new_module['PaymentMethodValue'][1]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][1]['key'] = 'secret_key';
		$new_module['PaymentMethodValue'][1]['value'] = '';

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
		
		global $config;
		
		$order = $this->Order->read(null,$_SESSION['Customer']['order_id']);
		
		$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));

		$rbkmoney_settings = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'store_id')));
		$rbkmoney_store_id = $rbkmoney_settings['PaymentMethodValue']['value'];
		$success_url = 'http://'.$_SERVER['HTTP_HOST'] .  BASE . '/orders/place_order/';
		$fail_url = 'http://'.$_SERVER['HTTP_HOST'] .  BASE . '/page/checkout' . $config['URL_EXTENSION'];
		
		$content = '<form action="https://rbkmoney.ru/acceptpurchase.aspx" method="post">
			<input type="hidden" name="orderId" value="' . $_SESSION['Customer']['order_id'] . '">
			<input type="hidden" name="eshopId" value="'.$rbkmoney_store_id.'">
			<input type="hidden" name="serviceName" value="' . $_SESSION['Customer']['order_id'] . ' ' . $order['Order']['email'] . '">
			<input type="hidden" name="recipientAmount" value="' . $order['Order']['total'] . '">
			<input type="hidden" name="recipientCurrency" value="' . $_SESSION['Customer']['currency_code'] . '">
			<input type="hidden" name="successUrl" value="' . $success_url . '">
			<input type="hidden" name="failUrl" value="' . $fail_url . '">';
						
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
      $rbkmoney_data = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'secret_key')));
      $rbkmoney_secret_key = $rbkmoney_data['PaymentMethodValue']['value'];
		$order = $this->Order->read(null,$_POST['orderId']);
		$crc = $_POST['hash'];
		$hash = md5($_POST['eshopId'].'::'.$_POST['orderId'].'::'.$_POST['serviceName'].'::'.$_POST['eshopAccount'].'::'.$_POST['recipientAmount'].'::'.$_POST['recipientCurrency'].'::'.$_POST['paymentStatus'].'::'.$_POST['userName'].'::'.$_POST['userEmail'].'::'.$_POST['paymentData'].'::'.$rbkmoney_secret_key);
		$merchant_summ = number_format($_POST['recipientAmount'], 2);
		$order_summ = number_format($order['Order']['total'], 2);

		if (($crc == $hash) && ($merchant_summ == $order_summ) && ($_POST['paymentStatus'] == '5')) {
		
		$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));
		$order_data = $this->Order->find('first', array('conditions' => array('Order.id' => $_POST['orderId'])));
		$order_data['Order']['order_status_id'] = $payment_method['PaymentMethod']['order_status_id'];
		
		$this->Order->save($order_data);
		
		}
	
	}
	
}

?>