<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('PaymentAppController', 'Payment.Controller');

class InterkassaController extends PaymentAppController {
	var $uses = array('PaymentMethod', 'Order');
	var $module_name = 'Interkassa';
	var $icon = 'interkassa.png';

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
		$new_module['PaymentMethodValue'][0]['key'] = 'interkassa_id';
		$new_module['PaymentMethodValue'][0]['value'] = '';

		$new_module['PaymentMethodValue'][1]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][1]['key'] = 'interkassa_secret_key';
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

		$interkassa_settings = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'interkassa_id')));
		$interkassa_id = $interkassa_settings['PaymentMethodValue']['value'];

      $interkassa_data = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'interkassa_secret_key')));
      $interkassa_secret_key = $interkassa_data['PaymentMethodValue']['value'];
      
      $ik_sign_hash_str = $interkassa_id . ':' . $order['Order']['total'] . ':' . $_SESSION['Customer']['order_id'] . ':' . '' . ':' . $_SESSION['Customer']['order_id'] . ':' . $interkassa_secret_key;
      $ik_sign_hash = md5($ik_sign_hash_str);
      		
		$content = '<form action="https://interkassa.com/lib/payment.php" method="post">
			<input type="hidden" name="ik_payment_id" value="' . $_SESSION['Customer']['order_id'] . '">
			<input type="hidden" name="ik_shop_id" value="'.$interkassa_id.'">
			<input type="hidden" name="ik_payment_desc" value="' . $_SESSION['Customer']['order_id'] . ' ' . $order['Order']['email'] . '">
			<input type="hidden" name="ik_payment_amount" value="' . $order['Order']['total'] . '">
			<input type="hidden" name="ik_paysystem_alias" value="">
			<input type="hidden" name="ik_baggage_fields" value="' . $_SESSION['Customer']['order_id'] . '">
			<input type="hidden" name="ik_sign_hash" value="'.$ik_sign_hash.'">';
						
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
      $interkassa_data = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'interkassa_secret_key')));
      $interkassa_secret_key = $interkassa_data['PaymentMethodValue']['value'];
		$order = $this->Order->read(null,$_POST['ik_payment_id']);
		$crc = $_POST['ik_sign_hash'];
		$hash = strtoupper(md5($_POST['ik_shop_id'].":".$_POST['ik_payment_amount'].":".$_POST['ik_payment_id'].":".$_POST['ik_paysystem_alias'].":".$_POST['ik_baggage_fields'].":".$interkassa_secret_key));
		$merchant_summ = number_format($_POST['amount'], 2);
		$order_summ = number_format($order['Order']['total'], 2);

		if (($crc == $hash) && ($merchant_summ == $order_summ) && ($_POST['ik_payment_state'] == 'success')) {
			
		$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));
		$order_data = $this->Order->find('first', array('conditions' => array('Order.id' => $_POST['ik_payment_id'])));
		$order_data['Order']['order_status_id'] = $payment_method['PaymentMethod']['order_status_id'];
		
		$this->Order->save($order_data);
		
		}
	
	}
	
}

?>