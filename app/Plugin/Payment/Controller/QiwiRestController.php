<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('PaymentAppController', 'Payment.Controller');

class QiwiRestController extends PaymentAppController {
	public $uses = array('PaymentMethod', 'Order');
	public $module_name = 'QiwiRest';
	public $icon = 'qiwi.png';

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
		$new_module['PaymentMethodValue'][0]['key'] = 'qiwi_id';
		$new_module['PaymentMethodValue'][0]['value'] = '';

		$new_module['PaymentMethodValue'][1]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][1]['key'] = 'qiwi_api_id';
		$new_module['PaymentMethodValue'][1]['value'] = '';

		$new_module['PaymentMethodValue'][2]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][2]['key'] = 'qiwi_notify_pass';
		$new_module['PaymentMethodValue'][2]['value'] = '';

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

		$content = '<form action="' . BASE . '/payment/qiwi_rest/process_payment/" method="post">
		<p>	'.__('Qiwi Phone').': &nbsp;<input type="text" name="qiwi_telephone" /> {lang}Example{/lang}: 7916820XXXX</p>
		<button class="btn btn-default" type="submit" value="{lang}Confirm Order{/lang}"><i class="fa fa-check"></i> {lang}Confirm Order{/lang}</button>
		</form>';

		return $content;	
	}

	public function process_payment ()
	{
		$order = $this->Order->read(null,$_SESSION['Customer']['order_id']);

		$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));

		$qiwi_rest_settings = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'qiwi_id')));
		$qiwi_rest_id = $qiwi_rest_settings['PaymentMethodValue']['value'];

		$qiwi_api_id_data = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'qiwi_api_id')));
		$qiwi_api_id = $qiwi_api_id_data['PaymentMethodValue']['value'];

		$qiwi_notify_pass_data = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'qiwi_notify_pass')));
		$qiwi_notify_pass = $qiwi_notify_pass_data['PaymentMethodValue']['value'];

		$shop_id = $qiwi_rest_id;
		$order_id = $order['Order']['id'];		
		$api_id = $qiwi_api_id;
		$notify_pass = $qiwi_notify_pass;
		
		$service_url = 'https://w.qiwi.com/api/v2/prv/' . $shop_id . '/bills/' . $order_id;
		$ch = curl_init($service_url);

		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
    		curl_setopt($ch, CURLOPT_USERPWD, $api_id . ":" . $notify_pass);
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

	    	curl_setopt($ch, CURLOPT_HTTPHEADER, array (
		    "Accept: application/json"
    		));


		$currency_code = 'RUB';
		$summ = number_format($order['Order']['total'],2,'.','');
		$life_time = date('c', strtotime("+7 days"));

		$_data = "user=" . urlencode("tel:+" . $_POST['qiwi_telephone']) . "&amount=" . urlencode($summ) . "&ccy=" . urlencode($currency_code) . "&comment=" . urlencode($order_id) . "&lifetime=" . urlencode($life_time). "&prv_name=" . urlencode(STORE_NAME);
		
		curl_setopt($ch, CURLOPT_POSTFIELDS, $_data);

		$results = curl_exec ($ch) or die(curl_error($ch));
		//echo $results; 
		//echo curl_error($ch); 

		curl_close($ch);

		$success_url = 'http://'.$_SERVER['HTTP_HOST'] .  BASE . '/orders/place_order/';
		$fail_url = 'http://'.$_SERVER['HTTP_HOST'] .  BASE . '/page/checkout' . $config['URL_EXTENSION'];
		
		$redirect_url = 'https://w.qiwi.com/order/external/main.action?shop='.$qiwi_rest_id.'&transaction='.$order_id.'&successUrl='.$success_url.'&failUrl='.$fail_url;
		
		$this->redirect($redirect_url);
	}
	
	public function after_process()
	{
	// Save the order
	
		foreach($_POST AS $key => $value)
			$order['Order'][$key] = $value;
		
		// Get the default order status
		$default_status = $this->Order->OrderStatus->find('first', array('conditions' => array('default' => '1')));
		$order['Order']['order_status_id'] = $default_status['OrderStatus']['id'];

		// Save the order
		$this->Order->save($order);

	}
		
	public function result()
	{
		$this->layout = false;

		$this->RequestHandler->respondAs('xml');
		$this->RequestHandler->renderAs($this, 'xml');
		
		$this->set('xml', '<?xml version="1.0"?><result><result_code>0</result_code></result>');

		$order = $this->Order->read(null,$_POST['bill_id']);
		$merchant_summ = number_format((float)$_POST['amount'], 2);
		$order_summ = number_format((float)$order['Order']['total'], 2);

		if (($_POST['status'] == 'paid') && ($merchant_summ == $order_summ) && ($order_summ > 0)) {
		
		$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));
		$order_data = $this->Order->find('first', array('conditions' => array('Order.id' => $_POST['bill_id'])));
		$order_data['Order']['order_status_id'] = $payment_method['PaymentMethod']['order_status_id'];
		
		$this->Order->save($order_data);
		
		}
	
	}
	
}

?>