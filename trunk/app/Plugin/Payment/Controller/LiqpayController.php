<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('PaymentAppController', 'Payment.Controller');

class LiqpayController extends PaymentAppController {
	var $uses = array('PaymentMethod', 'Order');
	var $module_name = 'Liqpay';
	var $icon = 'liqpay.png';

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
		$new_module['PaymentMethodValue'][0]['key'] = 'liqpay_id';
		$new_module['PaymentMethodValue'][0]['value'] = '';

		$new_module['PaymentMethodValue'][1]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][1]['key'] = 'liqpay_secret_key';
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
			
		$order = $this->Order->read(null,$_SESSION['Customer']['order_id']);
		
		$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));

		$liqpay_settings = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'liqpay_id')));
		$liqpay_id = $liqpay_settings['PaymentMethodValue']['value'];

      $liqpay_data = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'liqpay_secret_key')));
      $liqpay_secret_key = $liqpay_data['PaymentMethodValue']['value'];

		$server_url = 'http://'.$_SERVER['HTTP_HOST'] .  BASE . '/payment/liqpay/result/';
		$result_url = 'http://'.$_SERVER['HTTP_HOST'] .  BASE . '/orders/place_order/';
      
		$content = '<form action="https://liqpay.com/?do=clickNbuy" method="post">
			<input type="hidden" name="order_id" value="' . $_SESSION['Customer']['order_id'] . '">
			<input type="hidden" name="merchant_id" value="'.$liqpay_id.'">
			<input type="hidden" name="description" value="' . $_SESSION['Customer']['order_id'] . ' ' . $order['Order']['email'] . '">
			<input type="hidden" name="amount" value="' . $order['Order']['total'] . '">
			<input type="hidden" name="currency" value="' . $_SESSION['Customer']['currency_code'] . '">
			<input type="hidden" name="version" value="1.1">
			<input type="hidden" name="server_url" value="' . $server_url . '">
			<input type="hidden" name="result_url" value="' . $result_url . '">';
						
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
      $liqpay_data = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'liqpay_secret_key')));
      $liqpay_secret_key = $liqpay_data['PaymentMethodValue']['value'];
		$liqpay_settings = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'liqpay_id')));
		$liqpay_id = $liqpay_settings['PaymentMethodValue']['value'];
		$order = $this->Order->read(null,$_POST['order_id']);
		$crc = $_POST['signature'];
		$hash_source = "|".$_POST['version']."|".$liqpay_secret_key."|".$_POST['action_name']."|".$_POST['sender_phone']."|".$liqpay_id."|".$_POST['amount']."|".$_POST['currency']."|".$_POST['order_id']."|".$_POST['transaction_id']."|".$_POST['status']."|".$_POST['code']."|";
		$hash = base64_encode(sha1($hash_source,1));
		$merchant_summ = number_format($_POST['amount'], 2);
		$order_summ = number_format($order['Order']['total'], 2);

		if (($crc == $hash) && ($merchant_summ == $order_summ) && ($_POST['status'] == 'success')) {
			
		$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));
		$order_data = $this->Order->find('first', array('conditions' => array('Order.id' => $_POST['order_id'])));
		$order_data['Order']['order_status_id'] = $payment_method['PaymentMethod']['order_status_id'];
		
		$this->Order->save($order_data);
		
		}
	
	}
	
}

?>