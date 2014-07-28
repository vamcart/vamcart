<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('PaymentAppController', 'Payment.Controller');

class InterkassaController extends PaymentAppController {
	public $uses = array('PaymentMethod', 'Order');
	public $module_name = 'Interkassa';
	public $icon = 'interkassa.png';

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
		$new_module['PaymentMethodValue'][0]['key'] = 'interkassa_id';
		$new_module['PaymentMethodValue'][0]['value'] = '';

		$new_module['PaymentMethodValue'][1]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][1]['key'] = 'interkassa_secret_key';
		$new_module['PaymentMethodValue'][1]['value'] = '';

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
			
		$order = $this->Order->read(null,$_SESSION['Customer']['order_id']);
		
		$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));

		$interkassa_settings = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'interkassa_id')));
		$interkassa_id = $interkassa_settings['PaymentMethodValue']['value'];

      $interkassa_data = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'interkassa_secret_key')));
      $interkassa_secret_key = $interkassa_data['PaymentMethodValue']['value'];
      
		$result = array(
			'ik_am' => $order['Order']['total'], // Сумма платежа
			'ik_pm_no' => $_SESSION['Customer']['order_id'], // Номер заказа
			'ik_desc' => 'Order-'.$_SESSION['Customer']['order_id'], // Описание платежа
			'ik_cur' => $_SESSION['Customer']['currency_code'], // Валюта платежа
			'ik_co_id' => $interkassa_id, // Идентификатор кассы
		);

		// Формируем подпись
		$result['ik_sign'] = $this->getSign($result);

		$process_button_string = '';

		$process_button_string .= '<form action="https://sci.interkassa.com/" method="post">';

		foreach ($result as $k => $val)
		{
			$process_button_string .= '<input type="hidden" name="'. $k . '" value="' . $val . '">';
		}
      		
		$content = $process_button_string;
						
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

	public function after_process()
	{
	}
	
	
	public function result()
	{
		$this->layout = false;
      $interkassa_data = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'interkassa_secret_key')));
      $interkassa_secret_key = $interkassa_data['PaymentMethodValue']['value'];
		$order = $this->Order->read(null,$_POST['ik_payment_id']);
		$sign = ikGetSign($_POST);
		$hash = strtoupper(md5($_POST['ik_shop_id'].":".$_POST['ik_payment_amount'].":".$_POST['ik_payment_id'].":".$_POST['ik_paysystem_alias'].":".$_POST['ik_baggage_fields'].":".$interkassa_secret_key));
		$merchant_summ = number_format($_POST['amount'], 2);
		$order_summ = number_format($order['Order']['total'], 2);

		if (($_POST['ik_sign'] == $sign) && ($merchant_summ == $order_summ) && ($_POST['ik_inv_st'] == 'success')) {
			
		$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));
		$order_data = $this->Order->find('first', array('conditions' => array('Order.id' => $_POST['ik_payment_id'])));
		$order_data['Order']['order_status_id'] = $payment_method['PaymentMethod']['order_status_id'];
		
		$this->Order->save($order_data);
		
		}
	
	}

	private function getSign($aParams)
	{
		ksort ($aParams, SORT_STRING);
		array_push($aParams, MODULE_PAYMENT_IK_SECRET_KEY);
		$signString = implode(':', $aParams);
		$sign = base64_encode(md5($signString, true));
		return $sign;
	}

	private function ikGetSign($post)
	{
	$aParams = array();
	foreach ($post as $key => $value)
	{
		if (!preg_match('/ik_/', $key))
			continue;
		$aParams[$key] = $value;
	}

	unset($aParams['ik_sign']);

		$key = MODULE_PAYMENT_IK_SECRET_KEY;

	ksort ($aParams, SORT_STRING);
	array_push($aParams, $key);
	$signString = implode(':', $aParams);
	$sign = base64_encode(md5($signString, true));
	return $sign;
	}	
	}

?>