<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('PaymentAppController', 'Payment.Controller');

class QiwiController extends PaymentAppController {
	var $uses = array('PaymentMethod', 'Order');
	var $module_name = 'Qiwi';
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

		$content = '<form action="' . BASE . '/payment/qiwi/process_payment/" method="post">
		<p>	{lang}Phone{/lang}: &nbsp;<input type="text" name="qiwi_telephone" /> {lang}Example{/lang}: 916820XXXX</p>
		<span class="button"><button type="submit" value="{lang}Confirm Order{/lang}"><img src="{base_path}/img/icons/buttons/submit.png" width="12" height="12" alt="" />&nbsp;{lang}Confirm Order{/lang}</button></span>
		</form>';

		return $content;	
	}

	function process_payment ()
	{
		$order = $this->Order->read(null,$_SESSION['Customer']['order_id']);

		$qiwi_id_data = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'qiwi_id')));
		$qiwi_id = $qiwi_id_data['PaymentMethodValue']['value'];

		$qiwi_secret_key_data = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'qiwi_secret_key')));
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
			'user' => $_POST['qiwi_telephone'],
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
		
		$this->redirect('/orders/place_order/');
	}
	
	function after_process()
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
		
	function result()
	{
		$this->layout = 'empty';

			App::import('Vendor', 'Nusoap', array('file' => 'nusoap'.DS.'nusoap.php'));
				
			$server = new nusoap_server;
			$server->register('updateBill');
			$server->service($HTTP_RAW_POST_DATA);
			
			function updateBill($login, $password, $txn, $status) {

			$order = $this->Order->read(null,$txn);
	
			$qiwi_id_data = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'qiwi_id')));
			$qiwi_id = $qiwi_id_data['PaymentMethodValue']['value'];
	
			$qiwi_secret_key_data = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'qiwi_secret_key')));
			$qiwi_secret_key = $qiwi_secret_key_data['PaymentMethodValue']['value'];
			
			//обработка возможных ошибок авторизации
			if ( $login != $qiwi_id )
			return 150;
			
			if ( !empty($password) && $password != strtoupper(md5($txn.strtoupper(md5($qiwi_secret_key)))) )
			return 150;
			
			// получаем номер заказа
			$transaction = intval($txn);
			
			// меняем статус заказа при условии оплаты счёта
			if ( $status == 60 ) {
				
			$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));
			$order_data = $this->Order->find('first', array('conditions' => array('Order.id' => $txn)));
			$order_data['Order']['order_status_id'] = $payment_method['PaymentMethod']['order_status_id'];
			
			$this->Order->save($order_data);
			
				
			}
			
			}	
	
	}
	
}

?>