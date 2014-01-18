<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('PaymentAppController', 'Payment.Controller');

class RobokassaController extends PaymentAppController {
	var $uses = array('PaymentMethod', 'Order');
	var $module_name = 'Robokassa';
	var $icon = 'robokassa.png';

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
		$new_module['PaymentMethodValue'][0]['key'] = 'login';
		$new_module['PaymentMethodValue'][0]['value'] = '';

		$new_module['PaymentMethodValue'][1]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][1]['key'] = 'password1';
		$new_module['PaymentMethodValue'][1]['value'] = '';

		$new_module['PaymentMethodValue'][2]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][2]['key'] = 'password2';
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
			
		$order = $this->Order->read(null,$_SESSION['Customer']['order_id']);
		
		$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));

		$robokassa_settings = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'login')));
		$login = $robokassa_settings['PaymentMethodValue']['value'];
		$robokassa_pass_settings = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'password1')));
		$password1 = $robokassa_pass_settings['PaymentMethodValue']['value'];
		
		
		$content = '<form action="https://merchant.roboxchange.com/Index.aspx" method="post">
			<input type="hidden" name="InvId" value="' . $_SESSION['Customer']['order_id'] . '">
			<input type="hidden" name="MrchLogin" value="'.$login.'">
			<input type="hidden" name="SignatureValue" value="'.md5($login.':'.$order['Order']['total'].':'.$_SESSION['Customer']['order_id'].':'.$password1).'">
			<input type="hidden" name="IncCurrLabel" value="' . $_SESSION['Customer']['currency_code'] . '">
			<input type="hidden" name="Email" value="' . $order['Order']['email'] . '">
			<input type="hidden" name="Desc" value="' . $_SESSION['Customer']['order_id'] . ' ' . $order['Order']['email'] . '">
			<input type="hidden" name="OutSum" value="' . $order['Order']['total'] . '">';
						
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
		$this->layout = false;
      $robokassa_data = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'password2')));
      $password2 = $robokassa_data['PaymentMethodValue']['value'];
		$order = $this->Order->read(null,$_POST['InvId']);
		$crc = $_POST['SignatureValue'];
		$hash = md5($_POST['OutSum'].':'.$_POST['InvId'].':'.$password2);
		$merchant_summ = number_format($_POST['OutSum'], 2);
		$order_summ = number_format($order['Order']['total'], 2);

		if (($crc == $hash) && ($merchant_summ == $order_summ)) {
		
		$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));
		$order_data = $this->Order->find('first', array('conditions' => array('Order.id' => $_POST['InvId'])));
		$order_data['Order']['order_status_id'] = $payment_method['PaymentMethod']['order_status_id'];
		
		$this->Order->save($order_data);
		
		}
	
	}
	
}

?>