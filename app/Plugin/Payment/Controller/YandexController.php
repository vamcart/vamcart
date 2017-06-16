<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('PaymentAppController', 'Payment.Controller');

class YandexController extends PaymentAppController {
	public $uses = array('PaymentMethod', 'Order');
	public $module_name = 'Yandex';
	public $icon = 'yandex.png';

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
		$new_module['PaymentMethodValue'][0]['key'] = 'shopid';
		$new_module['PaymentMethodValue'][0]['value'] = '';

		$new_module['PaymentMethodValue'][1]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][1]['key'] = 'scid';
		$new_module['PaymentMethodValue'][1]['value'] = '';

		$new_module['PaymentMethodValue'][2]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][2]['key'] = 'secret_key';
		$new_module['PaymentMethodValue'][2]['value'] = '';

		$new_module['PaymentMethodValue'][3]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][3]['key'] = 'mode';
		$new_module['PaymentMethodValue'][3]['value'] = '0';

		$new_module['PaymentMethodValue'][4]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][4]['key'] = 'payment_type';
		$new_module['PaymentMethodValue'][4]['value'] = 'PC';

		$new_module['PaymentMethodValue'][5]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][5]['key'] = 'send_check';
		$new_module['PaymentMethodValue'][5]['value'] = '0';

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

		$yandex_settings_shopid = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'shopid')));
		$yandex_shopid = $yandex_settings_shopid['PaymentMethodValue']['value'];

		$yandex_settings_scid = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'scid')));
		$yandex_scid = $yandex_settings_scid['PaymentMethodValue']['value'];

		$yandex_settings_mode = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'mode')));
		$yandex_mode = $yandex_settings_mode['PaymentMethodValue']['value'];

		$yandex_settings_send_check = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'send_check')));
		$yandex_send_check = $yandex_settings_send_check['PaymentMethodValue']['value'];

		$yandex_settings_payment_type = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'payment_type')));
		$yandex_payment_type = $yandex_settings_payment_type['PaymentMethodValue']['value'];
		
		if ($yandex_mode == '0') {
			$action_url = 'https://demomoney.yandex.ru/eshop.xml';
		} else {
			$action_url = 'https://money.yandex.ru/eshop.xml';
		}

		$success_url = FULL_BASE_URL . BASE . '/orders/place_order/';
		$fail_url = FULL_BASE_URL . BASE . '/page/checkout' . $config['URL_EXTENSION'];

		if ($yandex_send_check == '1') {

            $receipt = array(
                'customerContact' => $order['Order']['email'],
                'items' => array(),
            );

            foreach ($order['OrderProduct'] as $product) {

                $id_tax = 1;

                $receipt['items'][] = array(
                    'quantity' => $product['quantity'],
                    'text' => substr($product['name'], 0, 128),
                    'tax' => $id_tax,
                    'price' => array(
                        'amount' => number_format($product['price'], 2, '.', ''),
                        'currency' => 'RUB'
                    ),
                );
            }

            if ($order['Order']['shipping'] > 0) {
                $id_tax = 1;
                $receipt['items'][] = array(
                    'quantity' => 1,
                    'text' => substr($order['ShippingMethod']['name'], 0, 128),
                    'tax' => $id_tax,
                    'price' => array(
                        'amount' => number_format($order['Order']['shipping'], 2, '.', ''),
                        'currency' => 'RUB'
                    ),
                );
            }
        }
		
		$content = '<form action="'.$action_url.'">
			<input type="hidden" name="shopId" value="'.$yandex_shopid.'">
			<input type="hidden" name="scid" value="'.$yandex_scid.'">
			<input type="hidden" name="sum" value="' . $order['Order']['total'] . '">
			<input type="hidden" name="customerNumber" value="' . $_SESSION['Customer']['order_id'] . '">
			<input type="hidden" name="orderNumber" value="' . $_SESSION['Customer']['order_id'] . '">
			<input type="hidden" name="shopSuccessURL" value="' . $success_url . '">
			<input type="hidden" name="shopFailURL" value="' . $fail_url . '">
			<input type="hidden" name="cps_email" value="' . $order['Order']['email'] . '">
			<input type="hidden" name="cps_phone" value="' . $order['Order']['phone'] . '">
			<input type="hidden" name="cms_name" value="vamshop">
			'.($yandex_send_check == 1 ? '<input type="hidden" name="receipt" value="{literal}'.json_encode($receipt).'{/literal}>' : null).'
			<input type="hidden" name="paymentType" value="'.$yandex_payment_type.'">
			';
						
		$content .= '
			<button class="btn btn-default" type="submit" value="{lang}Process to Payment{/lang}"><i class="fa fa-check"></i> {lang}Process to Payment{/lang}</button>
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

		$yandex_settings_shopid = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'shopid')));
		$yandex_shopid = $yandex_settings_shopid['PaymentMethodValue']['value'];

		$yandex_settings_scid = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'scid')));
		$yandex_scid = $yandex_settings_scid['PaymentMethodValue']['value'];

		$yandex_settings_mode = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'mode')));
		$yandex_mode = $yandex_settings_mode['PaymentMethodValue']['value'];

		$yandex_settings_payment_type = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'payment_type')));
		$yandex_payment_type = $yandex_settings_payment_type['PaymentMethodValue']['value'];
		
		if ($yandex_mode == '0') {
			$action_url = 'https://demomoney.yandex.ru/eshop.xml';
		} else {
			$action_url = 'https://money.yandex.ru/eshop.xml';
		}

		$success_url = FULL_BASE_URL . BASE . '/orders/place_order/';
		$fail_url = FULL_BASE_URL . BASE . '/page/checkout' . $config['URL_EXTENSION'];
		
		$content = '<form action="'.$action_url.'">
			<input type="hidden" name="shopId" value="'.$yandex_shopid.'">
			<input type="hidden" name="scid" value="'.$yandex_scid.'">
			<input type="hidden" name="sum" value="' . $order['Order']['total'] . '">
			<input type="hidden" name="customerNumber" value="' . $order_id . '">
			<input type="hidden" name="orderNumber" value="' . $order_id . '">
			<input type="hidden" name="shopSuccessURL" value="' . $success_url . '">
			<input type="hidden" name="shopFailURL" value="' . $fail_url . '">
			<input type="hidden" name="cps_email" value="' . $order['Order']['email'] . '">
			<input type="hidden" name="cps_phone" value="' . $order['Order']['phone'] . '">
			<input type="hidden" name="cms_name" value="vamshop">
			<input type="hidden" name="paymentType" value="'.$yandex_payment_type.'">
			';
						
		$content .= '
			<button class="btn btn-default" type="submit" value="{lang}Pay Now{/lang}"><i class="fa fa-dollar"></i> {lang}Pay Now{/lang}</button>
			</form>';

		return $content;
	}
	
	public function result()
	{
		$this->layout = false;
      $yandex_data = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'secret_key')));
      $yandex_secret_key = $yandex_data['PaymentMethodValue']['value'];
		$order = $this->Order->read(null,$_POST['orderNumber']);
		$crc = $_POST['md5'];
		$hash = strtoupper(md5($_POST['action'].';'.$_POST['orderSumAmount'].';'.$_POST['orderSumCurrencyPaycash'].';'.$_POST['orderSumBankPaycash'].';'.$_POST['shopId'].';'.$_POST['invoiceId'].';'.$_POST['customerNumber'].';'.$yandex_secret_key));
		$merchant_summ = number_format($_POST['orderSumAmount'], 2);
		$inv_id = $_POST['orderNumber'];
		$order_summ = number_format($order['Order']['total'], 2);
		
		$yandex_settings_shopid = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'shopid')));
		$yandex_shopid = $yandex_settings_shopid['PaymentMethodValue']['value'];

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