<?php 
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009-2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class QiwiController extends PaymentAppController {
	var $uses = array('PaymentMethod', 'Order');
	var $module_name = 'qiwi';
	var $icon = 'qiwi.png';

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
		$new_module['PaymentMethodValue'][0]['key'] = 'qiwi_id';
		$new_module['PaymentMethodValue'][0]['value'] = '';

		$new_module['PaymentMethodValue'][1]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][1]['key'] = 'qiwi_secret_key';
		$new_module['PaymentMethodValue'][1]['value'] = '';

		$this->PaymentMethod->saveAll($new_module);

		$this->Session->setFlash(__('Module Installed', true));
		$this->redirect('/payment_methods/admin/');
	}

	function uninstall()
	{

		$module_id = $this->PaymentMethod->findByAlias($this->module_name);

		$this->PaymentMethod->delete($module_id['PaymentMethod']['id'], true);
			
		$this->Session->setFlash(__('Module Uninstalled', true));
		$this->redirect('/payment_methods/admin/');
	}

	function before_process () 
	{

		$content = '{lang}Example{/lang}: &nbsp;<input type="text" name="qiwi_telephone" /> {lang}Phone{/lang}: 916820XXXX

		<form action="' . BASE . '/orders/place_order/" method="post">
		<span class="button"><button type="submit" value="{lang}Confirm Order{/lang}">{lang}Confirm Order{/lang}</button></span>
		</form>';

	// Save the order
	
		foreach($_POST AS $key => $value)
			$order['Order'][$key] = $value;
		
		// Get the default order status
		$default_status = $this->Order->OrderStatus->find(array('default' => '1'));
		$order['Order']['order_status_id'] = $default_status['OrderStatus']['id'];

		// Save the order
		$this->Order->save($order);
    
		return $content;	
	}

	function after_process()
	{
		
		$order = $this->Order->read(null,$_SESSION['Customer']['order_id']);

		$qiwi_id_data = $this->PaymentMethod->PaymentMethodValue->find(array('key' => 'qiwi_id'));
		$qiwi_id = $qiwi_id_data['PaymentMethodValue']['value'];

		$qiwi_secret_key_data = $this->PaymentMethod->PaymentMethodValue->find(array('key' => 'qiwi_secret_key'));
		$qiwi_secret_key = $qiwi_secret_key_data['PaymentMethodValue']['value'];

			// Выписываем qiwi счёт для покупателя

        //if ($insert_order == true) {
        	
			App::import('Vendor', 'Nusoap', array('file' => 'nusoap'.DS.'nusoap.php'));

			$client = new nusoap_client("https://mobw.ru/services/ishop", false); // создаем клиента для отправки запроса на QIWI
			$error = $client->getError();
			
			//if ( !empty($error) ) {
			// обрабатываем возможные ошибки и в случае их возникновения откатываем транзакцию в своей системе
			//echo -1;
			//exit();
			//}
			
			$client->useHTTPPersistentConnection();
			
			// Параметры для передачи данных о платеже:
			// login - Ваш ID в системе QIWI
			// password - Ваш пароль
			// user - Телефон покупателя (10 символов, например 916820XXXX)
			// amount - Сумма платежа в рублях
			// comment - Комментарий, который пользователь увидит в своем личном кабинете или платежном автомате
			// txn - Наш внутренний уникальный номер транзакции
			// lifetime - Время жизни платежа до его автоматической отмены
			// alarm - Оповещать ли клиента через СМС или звонком о выписанном счете
			// create - 0 - только для зарегистрированных пользователей QIWI, 1 - для всех
			$params = array(
			'login' => $qiwi_id,
			'password' => $qiwi_secret_key,
			'user' => ($_SESSION['qiwi_telephone'] == '' ? $POST['qiwi_telephone'] : $_SESSION['qiwi_telephone']),
			'amount' => number_format($order['Order']['total'],0,'',''),
			'comment' => $_SESSION['Customer']['order_id'],
			'txn' => $_SESSION['Customer']['order_id'],
			'lifetime' => date("d.m.Y H:i:s", strtotime("+2 weeks")),
			'alarm' => 1,
			'create' => 1
			);
			
			// собственно запрос:
			$result = $client->call('createBill', $params, "http://server.ishop.mw.ru/");
			
			//if ($client->fault) {
			//echo -1;
			//exit();
			//} else {
			//$err = $client->getError();
			//if ($err) {
			//echo -1;
			//exit();
			//} else {
			//echo $result;
			//exit();
			//}
			//}

        //}	
		
	}
	
	
	function result()
	{
		$this->layout = 'empty';
      $qiwi_data = $this->PaymentMethod->PaymentMethodValue->find(array('key' => 'qiwi_secret_key'));
      $qiwi_secret_key = $qiwi_data['PaymentMethodValue']['value'];
		$order = $this->Order->read(null,$_POST['LMI_PAYMENT_NO']);
		$crc = $_POST['LMI_HASH'];
		$hash = strtoupper(md5($_POST['LMI_PAYEE_PURSE'].$_POST['LMI_PAYMENT_AMOUNT'].$_POST['LMI_PAYMENT_NO'].$_POST['LMI_MODE'].$_POST['LMI_SYS_INVS_NO'].$_POST['LMI_SYS_TRANS_NO'].$_POST['LMI_SYS_TRANS_DATE'].$qiwi_secret_key. 
$_POST['LMI_PAYER_PURSE'].$_POST['LMI_PAYER_WM']));
		$merchant_summ = number_format($_POST['LMI_PAYMENT_AMOUNT'], 2);
		$order_summ = number_format($order['Order']['total'], 2);

		if (($crc == $hash) && ($merchant_summ == $order_summ)) {
		
		$payment_method = $this->PaymentMethod->find(array('alias' => $this->module_name));
		$order_data = $this->Order->find('first', array('conditions' => array('Order.id' => $_POST['LMI_PAYMENT_NO'])));
		$order_data['Order']['order_status_id'] = $payment_method['PaymentMethod']['order_status_id'];
		
		$this->Order->save($order_data);
		
		}
	
	}
	
}

?>