<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('PaymentAppController', 'Payment.Controller');

class YandexController extends PaymentAppController {
	var $uses = array('PaymentMethod', 'Order');
	var $module_name = 'Yandex';
	var $icon = 'yandex.png';

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
		$new_module['PaymentMethodValue'][0]['key'] = 'shopid';
		$new_module['PaymentMethodValue'][0]['value'] = '';

		$new_module['PaymentMethodValue'][1]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][1]['key'] = 'scid';
		$new_module['PaymentMethodValue'][1]['value'] = '';

		$new_module['PaymentMethodValue'][2]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][2]['key'] = 'secret_key';
		$new_module['PaymentMethodValue'][2]['value'] = '';

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

		$yandex_settings_shopid = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'shopid')));
		$yandex_shopid = $yandex_settings_shopid['PaymentMethodValue']['value'];

		$yandex_settings_scid = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'scid')));
		$yandex_scid = $yandex_settings_scid['PaymentMethodValue']['value'];

		$success_url = 'http://'.$_SERVER['HTTP_HOST'] .  BASE . '/orders/place_order/';
		$fail_url = 'http://'.$_SERVER['HTTP_HOST'] .  BASE . '/page/checkout' . $config['URL_EXTENSION'];
		
		$content = '<form action="https://money.yandex.ru/eshop.xml" method="post">
			<input type="hidden" name="shopId" value="'.$yandex_shopid.'">
			<input type="hidden" name="scid" value="'.$yandex_scid.'">
			<input type="hidden" name="sum" value="' . $order['Order']['total'] . '">
			<input type="hidden" name="customerNumber" value="' . $order['Order']['total'] . '">
			<input type="hidden" name="orderNumber" value="' . $_SESSION['Customer']['order_id'] . '">
			<input type="hidden" name="shopSuccessURL" value="' . $success_url . '">
			<input type="hidden" name="shopFailURL" value="' . $fail_url . '">
			<input type="hidden" name="cps_email" value="' . $order['Order']['phone'] . '">
			<input type="hidden" name="cms_name" value="vamshop">
			<input type="hidden" name="cps_phone" value="' . $order['Order']['email'] . '">';
						
		$content .= '
			<button class="btn btn-inverse" type="submit" value="{lang}Process to Payment{/lang}"><i class="fa fa-check"></i> {lang}Process to Payment{/lang}</button>
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
		$this->layout = false;
      $yandex_data = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'secret_key')));
      $yandex_secret_key = $webmoney_data['PaymentMethodValue']['value'];
		$order = $this->Order->read(null,$_POST['orderNumber']);
		$crc = $_POST['md5'];
		$hash = strtoupper(md5($_POST['action'].';'.$_POST['orderSumAmount'].';'.$_POST['orderSumCurrencyPaycash'].';'.$_POST['orderSumBankPaycash'].';'.$_POST['shopId'].';'.$_POST['invoiceId'].';'.$_POST['customerNumber'].';'.$yandex_secret_key));
		$merchant_summ = number_format($_POST['orderSumAmount'], 2);
		$inv_id = $_POST['orderNumber'];
		$order_summ = number_format($order['Order']['total'], 2);
		
		$hash = strtoupper(md5($_POST['action'].';'.$_POST['orderSumAmount'].';'.$_POST['orderSumCurrencyPaycash'].';'.$_POST['orderSumBankPaycash'].';'.$_POST['shopId'].';'.$_POST['invoiceId'].';'.$_POST['customerNumber'].';'.MODULE_PAYMENT_YANDEX_MERCHANT_SECRET_KEY));

		$yandex_settings_shopid = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'shopid')));
		$yandex_shopid = $yandex_settings_shopid['PaymentMethodValue']['value'];

		$yandex_settings_scid = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'scid')));
		$yandex_scid = $yandex_settings_scid['PaymentMethodValue']['value'];
		
		if ($_POST['action'] == 'process' or $_POST['action'] == 'checkOrder') {
		if ($hash == $crc) {
		echo '<?xml version="1.0" encoding="UTF-8"?>
		<checkOrderResponse performedDatetime="'.$_POST['requestDatetime'].'"
		                    code="0" invoiceId="'.$_POST['invoiceId'].'"
		                    shopId="'.$yandex_shopid.'"/>';
		}
		}
		
		if ($_POST['action'] == 'paymentAviso') {
		if ($hash == $crc) {
		echo '<?xml version="1.0" encoding="UTF-8"?>
		<paymentAvisoResponse
		    performedDatetime="'.$_POST['requestDatetime'].'"
		    code="0" invoiceId="'.$_POST['invoiceId'].'"
		    shopId="'.$yandex_shopid.'"/>';
		}
		}
		
		// checking and handling
		if ($_POST['action'] == 'paymentAviso') {
		if ($hash == $crc) {
		if ($merchant_summ == $order_summ) {

		$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));
		$order_data = $this->Order->find('first', array('conditions' => array('Order.id' => $inv_id)));
		$order_data['Order']['order_status_id'] = $payment_method['PaymentMethod']['order_status_id'];
		
		$this->Order->save($order_data);
		
		}
		}
		}
	
	}
	
}

?>