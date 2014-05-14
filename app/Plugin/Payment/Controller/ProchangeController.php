<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('PaymentAppController', 'Payment.Controller');

class ProchangeController extends PaymentAppController {
	public $uses = array('PaymentMethod', 'Order');
	public $module_name = 'Prochange';
	public $icon = 'prochange.png';

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
		$new_module['PaymentMethodValue'][0]['key'] = 'pro_client';
		$new_module['PaymentMethodValue'][0]['value'] = '';

		$new_module['PaymentMethodValue'][1]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][1]['key'] = 'pro_ra';
		$new_module['PaymentMethodValue'][1]['value'] = '';

		$new_module['PaymentMethodValue'][2]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][2]['key'] = 'secret_key';
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
			
		$order = $this->Order->read(null,$_SESSION['Customer']['order_id']);
		
		$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));

		$prochange_settings = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'pro_client')));
		$pro_client = $prochange_settings['PaymentMethodValue']['value'];
		$prochange_ra_settings = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'pro_ra')));
		$pro_ra = $prochange_ra_settings['PaymentMethodValue']['value'];
		
		$content = '<form action="http://merchant.prochange.ru/pay.pro" method="post">
			<input type="hidden" name="PRO_FIELD_1" value="' . $_SESSION['Customer']['order_id'] . '">
			<input type="hidden" name="PRO_CLIENT" value="'.$pro_client.'">
			<input type="hidden" name="PRO_RA" value="'.$pro_ra.'">
			<input type="hidden" name="PRO_PAYMENT_DESC" value="' . $_SESSION['Customer']['order_id'] . ' ' . $order['Order']['email'] . '">
			<input type="hidden" name="PRO_SUMMA" value="' . $order['Order']['total'] . '">';
						
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
      $prochange_data = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'secret_key')));
      $secret_key = $prochange_data['PaymentMethodValue']['value'];
		$order = $this->Order->read(null,$_POST['PRO_FIELD_1']);
		$crc = $_POST['PRO_SECRET_KEY'];
		$hash = $secret_key;
		$merchant_summ = number_format($_POST['PRO_SUMMA'], 2);
		$order_summ = number_format($order['Order']['total'], 2);

		if (($crc == $hash) && ($merchant_summ == $order_summ)) {
		
		$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));
		$order_data = $this->Order->find('first', array('conditions' => array('Order.id' => $_POST['PRO_FIELD_1'])));
		$order_data->id = $_POST['PRO_FIELD_1'];
		$order_data['Order']['order_status_id'] = $payment_method['PaymentMethod']['order_status_id'];
		
		$this->Order->save($order_data);
		
		}
	
	}
	
}

?>