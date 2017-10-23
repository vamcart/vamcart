<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('ShippingAppController', 'Shipping.Controller');

class CdekController extends ShippingAppController {
	public $uses = array('ShippingMethod');
	public $module_name = 'Cdek';
	public $icon = 'cdek.png';

	public function settings ()
	{
		$this->set('data', $this->ShippingMethod->findByCode($this->module_name));
	}

	public function install()
	{

		$new_module = array();
		$new_module['ShippingMethod']['active'] = '1';
		$new_module['ShippingMethod']['order'] = '0';
		$new_module['ShippingMethod']['default'] = '0';
		$new_module['ShippingMethod']['name'] = Inflector::humanize($this->module_name);
		$new_module['ShippingMethod']['icon'] = $this->icon;
		$new_module['ShippingMethod']['code'] = $this->module_name;

		$new_module['ShippingMethodValue'][0]['shipping_method_id'] = $this->ShippingMethod->id;
		$new_module['ShippingMethodValue'][0]['key'] = 'handling';
		$new_module['ShippingMethodValue'][0]['value'] = '0';

		$new_module['ShippingMethodValue'][1]['shipping_method_id'] = $this->ShippingMethod->id;
		$new_module['ShippingMethodValue'][1]['key'] = 'api_key';
		$new_module['ShippingMethodValue'][1]['value'] = '';

		$new_module['ShippingMethodValue'][2]['shipping_method_id'] = $this->ShippingMethod->id;
		$new_module['ShippingMethodValue'][2]['key'] = 'api_password';
		$new_module['ShippingMethodValue'][2]['value'] = '';

		$new_module['ShippingMethodValue'][3]['shipping_method_id'] = $this->ShippingMethod->id;
		$new_module['ShippingMethodValue'][3]['key'] = 'sender_city';
		$new_module['ShippingMethodValue'][3]['value'] = 'Москва';

		$new_module['ShippingMethodValue'][4]['shipping_method_id'] = $this->ShippingMethod->id;
		$new_module['ShippingMethodValue'][4]['key'] = 'debug';
		$new_module['ShippingMethodValue'][4]['value'] = '0';

		$this->ShippingMethod->saveAll($new_module);

		$this->Session->setFlash(__('Module Installed'));
		$this->redirect('/shipping_methods/admin/');
	}

	public function uninstall()
	{

		$module_id = $this->ShippingMethod->findByCode($this->module_name);

		$this->ShippingMethod->delete($module_id['ShippingMethod']['id'], true);
			
		$this->Session->setFlash(__('Module Uninstalled'));
		$this->redirect('/shipping_methods/admin/');
	}

	public function calculate ()
	{
		global $order;

		$key_values = $this->ShippingMethod->findByCode($this->module_name);

		$data_cdek = array();
		if(!empty($key_values['ShippingMethodValue']))
			$data_cdek = array_combine(Set::extract($key_values, 'ShippingMethodValue.{n}.key'),
				Set::extract($key_values, 'ShippingMethodValue.{n}.value'));
	
	    $sender_city = $data_cdek['sender_city'];
	    
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, "http://api.cdek.ru/city/getListByTerm/json.php?q=".$sender_city);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    $data = curl_exec($curl);
	    
	    curl_close($curl);
	    if($data === false) {
		  //return "ID номер для города отправителя посылки не найден.";
	    }
	    
	    $senderCity = json_decode($data, $assoc=true);
	    $senderCityId = $senderCity["geonames"][0]["id"];
	
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, "http://api.cdek.ru/city/getListByTerm/json.php?q=".$order['Order']['bill_city']);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    $data = curl_exec($curl);
	    
	    curl_close($curl);
	    if($data === false) {
		  //return "ID номер для города получателя посылки не найден.";
	    }
	    
	    $receiverCity = json_decode($data, $assoc=true);
	    $receiverCityId = $receiverCity["geonames"][0]["id"];


		//подключаем файл с классом CalculatePriceDeliveryCdek
		App::import('Vendor', 'Cdek', array('file' => 'cdek'.DS.'CalculatePriceDeliveryCdek.php'));
		
		try {
		
			//создаём экземпляр объекта CalculatePriceDeliveryCdek
			$calc = new CalculatePriceDeliveryCdek();
			
		    //Авторизация.
		    if ($data_cdek['api_key'] != '' && $data_cdek['api_password'] != '') $calc->setAuth('authLoginString', 'passwordString');
			
			//устанавливаем город-отправитель
			$calc->setSenderCityId($senderCityId);
			//устанавливаем город-получатель
			$calc->setReceiverCityId($receiverCityId);
			//устанавливаем дату планируемой отправки
			//$calc->setDateExecute();
			
			//задаём список тарифов с приоритетами
		    //$calc->addTariffPriority($_REQUEST['tariffList1']);
		    //$calc->addTariffPriority($_REQUEST['tariffList2']);
			
			//устанавливаем тариф по-умолчанию
			$calc->setTariffId('11');
				
			//устанавливаем режим доставки
			$calc->setModeDeliveryId(3);
			//добавляем места в отправление
			
				foreach($order['OrderProduct'] AS $products)
				{
					$calc->addGoodsItemBySize($products['weight']*$products['quantity'], $products['length'], $products['width'], $products['height']);
		
				}	
			
			if ($calc->calculate() === true) {
				$res = $calc->getResult();
				
				if ($data_cdek['debug'] == 1) echo 'Цена доставки: ' . $res['result']['price'] . 'руб.<br />';
				if ($data_cdek['debug'] == 1) echo 'Срок доставки: ' . $res['result']['deliveryPeriodMin'] . '-' . 
										 $res['result']['deliveryPeriodMax'] . ' дн.<br />';
				if ($data_cdek['debug'] == 1) echo 'Планируемая дата доставки: c ' . $res['result']['deliveryDateMin'] . ' по ' . $res['result']['deliveryDateMax'] . '.<br />';
				if ($data_cdek['debug'] == 1) echo 'id тарифа, по которому произведён расчёт: ' . $res['result']['tariffId'] . '.<br />';
		        if(array_key_exists('cashOnDelivery', $res['result'])) {
		            if ($data_cdek['debug'] == 1) echo 'Ограничение оплаты наличными, от (руб): ' . $res['result']['cashOnDelivery'] . '.<br />';
		        }
			} else {
				$err = $calc->getError();
				if( isset($err['error']) && !empty($err) ) {
					if ($data_cdek['debug'] == 1) var_dump($err);
					foreach($err['error'] as $e) {
						if ($data_cdek['debug'] == 1) echo 'Код ошибки: ' . $e['code'] . '.<br />';
						if ($data_cdek['debug'] == 1) echo 'Текст ошибки: ' . $e['text'] . '.<br />';
					}
				}
			}
		    
		    //раскомментируйте, чтобы просмотреть исходный ответ сервера
		     //var_dump($calc->getResult());
		     //var_dump($calc->getError());
		
		} catch (Exception $e) {
		    if ($data_cdek['debug'] == 1) echo 'Ошибка: ' . $e->getMessage() . "<br />";
		}
			
		return $res['result']['price']+$data_cdek['handling'];
	}

	public function before_process()
	{
	}
	
}

?>