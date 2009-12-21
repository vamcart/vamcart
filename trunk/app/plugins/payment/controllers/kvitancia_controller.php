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

class KvitanciaController extends PaymentAppController {
	var $uses = array('PaymentMethod', 'Order');
	var $module_name = 'kvitancia';

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
		$new_module['PaymentMethodValue'][0]['key'] = 'bank_name';
		$new_module['PaymentMethodValue'][0]['value'] = '';

		$new_module['PaymentMethodValue'][1]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][1]['key'] = 'bank_account1';
		$new_module['PaymentMethodValue'][1]['value'] = '';

		$new_module['PaymentMethodValue'][2]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][2]['key'] = 'bik';
		$new_module['PaymentMethodValue'][2]['value'] = '';

		$new_module['PaymentMethodValue'][3]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][3]['key'] = 'bank_account2';
		$new_module['PaymentMethodValue'][3]['value'] = '';

		$new_module['PaymentMethodValue'][4]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][4]['key'] = 'inn';
		$new_module['PaymentMethodValue'][4]['value'] = '';

		$new_module['PaymentMethodValue'][5]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][5]['key'] = 'recipient';
		$new_module['PaymentMethodValue'][5]['value'] = '';

		$new_module['PaymentMethodValue'][6]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][6]['key'] = 'kpp';
		$new_module['PaymentMethodValue'][6]['value'] = '';

		$new_module['PaymentMethodValue'][7]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][7]['key'] = 'payment_text';
		$new_module['PaymentMethodValue'][7]['value'] = '';

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
		$content = '
		<a class="button" href="http://'.$_SERVER['HTTP_HOST'] .  BASE . '/payment/kvitancia/print_order/' . $_SESSION['Customer']['order_id'] . '" target="_blank"><span>{lang}Print Order{/lang}</span></a><br />
		<form action="' . BASE . '/orders/place_order/" method="post">
		<span class="button"><button type="submit" value="{lang}Confirm Order{/lang}">{lang}Confirm Order{/lang}</button></span>
		</form>';
		return $content;	
	}

	function after_process()
	{
		$payment_method = $this->PaymentMethod->find(array('alias' => $this->module_name));
		$order_data = $this->Order->find('first', array('conditions' => array('Order.id' => $_SESSION['Customer']['order_id'])));
		$order_data['Order']['order_status_id'] = $payment_method['PaymentMethod']['order_status_id'];
		
		$this->Order->save($order_data);
	}
	
	
	function print_order($id)
	{
		$this->layout = 'empty';		
		
//		if ($id != $_SESSION['Customer']['order_id'])
//		$this->redirect('/');		
		
      $rbkmoney_data = $this->PaymentMethod->PaymentMethodValue->find(array('key' => 'secret_key'));
      $rbkmoney_secret_key = $rbkmoney_data['PaymentMethodValue']['value'];
		$order = $this->Order->read(null,$_POST['orderId']);
		$crc = $_POST['hash'];
		$hash = md5($_POST['eshopId'].'::'.$_POST['orderId'].'::'.$_POST['serviceName'].'::'.$_POST['eshopAccount'].'::'.$_POST['recipientAmount'].'::'.$_POST['recipientCurrency'].'::'.$_POST['paymentStatus'].'::'.$_POST['userName'].'::'.$_POST['userEmail'].'::'.$_POST['paymentData'].'::'.$rbkmoney_secret_key);
		$merchant_summ = number_format($_POST['recipientAmount'], 2);
		$order_summ = number_format($order['Order']['total'], 2);

		if (($crc == $hash) && ($merchant_summ == $order_summ) && ($_POST['paymentStatus'] == '5')) {
		
		$payment_method = $this->PaymentMethod->find(array('alias' => $this->module_name));
		$order_data = $this->Order->find('first', array('conditions' => array('Order.id' => $_POST['orderId'])));
		$order_data->id = $_POST['orderId'];
		$order_data['Order']['order_status_id'] = $payment_method['PaymentMethod']['order_status_id'];
		
		$this->Order->save($order_data);
		
		}
	
	}
	
}

?>