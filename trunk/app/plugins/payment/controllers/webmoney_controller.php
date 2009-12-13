<?php 
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class WebmoneyController extends PaymentAppController {
	var $uses = array('PaymentMethod', 'Order');
	var $components = array('Email');
	var $module_name = 'webmoney';

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
		$new_module['PaymentMethod']['alias'] = $this->module_name;

		$new_module['PaymentMethodValue'][0]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][0]['key'] = 'webmoney_purse';
		$new_module['PaymentMethodValue'][0]['value'] = '';

		$new_module['PaymentMethodValue'][1]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][1]['key'] = 'webmoney_secret_key';
		$new_module['PaymentMethodValue'][1]['value'] = '';

		$this->PaymentMethod->saveAll($new_module);

		$this->Session->setFlash(__('Module Installed', true));
		$this->redirect('/payment_methods/admin/');
	}

	function uninstall()
	{

		$module_id = $this->PaymentMethod->findByAlias($this->module_name);

		$this->PaymentMethod->del($module_id['PaymentMethod']['id'], true);
			
		$this->Session->setFlash(__('Module Uninstalled', true));
		$this->redirect('/payment_methods/admin/');
	}

	function before_process () 
	{
			
		$order = $this->Order->read(null,$_SESSION['Customer']['order_id']);
		
		$payment_method = $this->PaymentMethod->find(array('alias' => $this->module_name));
		
		
		$paypal_email = $this->PaymentMethod->PaymentMethodValue->find(array('key' => 'paypal_email'));
		$email = $paypal_email['PaymentMethodValue']['value'];
		$return_url = $_SERVER['HTTP_HOST'] .  BASE . '/orders/place_order/';
		$cancel_url = $_SERVER['HTTP_HOST'];
		
		$content = '';
		
		$content = '<form action="https://merchant.webmoney.ru/lmi/payment.asp" method="post">
			<input type="hidden" name="LMI_PAYMENT_NO" value="'.$_SESSION['Customer']['order_id'].'">
			<input type="hidden" name="LMI_PAYEE_PURSE" value="Z250638326679">
			<input type="hidden" name="LMI_PAYMENT_DESC" value="' . $_SESSION['Customer']['order_id'] . ' - ' . $order['Order']['email'] . '">
			<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="' . $order['Order']['total'] . '">
			<input type="hidden" name="LMI_SIM_MODE" value="0">';
						
		$content .= '
			<span class="button"><button type="submit" value="{lang}Confirm order and Process to Payment{/lang}">{lang}Confirm order and Process to Payment{/lang}</button></span>
			</form>';
	
	// Save the order
	
		foreach($_POST AS $key => $value)
			$order['Order'][$key] = $value;
		
		// Get the default order status
		$default_status = $this->Order->OrderStatus->find(array('default' => '1'));
		$order['Order']['order_status_id'] = $default_status['OrderStatus']['id'];

		// Save the order
		$this->Order->save($order);
		$_SESSION['Customer']['order_id'] = null;

		return $content;
	}

	function after_process()
	{
	}
	
	
	function result()
	{

		$payment_method = $this->PaymentMethod->find(array('alias' => $this->module_name));
		$order_data = $this->Order->find('first', array('conditions' => array('Order.id' => $_POST['LMI_PAYMENT_NO'])));
		$order_data->id = $_POST['LMI_PAYMENT_NO'];
		$order_data['Order']['order_status_id'] = $payment_method['PaymentMethod']['order_status_id'];
		
		$this->Order->save($order_data);
	}
	
}

?>