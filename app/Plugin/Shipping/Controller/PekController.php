<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2018 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('ShippingAppController', 'Shipping.Controller');

class PekController extends ShippingAppController {
	public $uses = array('ShippingMethod');
	public $module_name = 'Pek';
	public $icon = 'pek.png';

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
		$new_module['ShippingMethod']['description'] = '';
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

		$data_pek = array();
		if(!empty($key_values['ShippingMethodValue']))
			$data_pek = array_combine(Set::extract($key_values, 'ShippingMethodValue.{n}.key'),
				Set::extract($key_values, 'ShippingMethodValue.{n}.value'));
	
	    $sender_city = $data_pek['sender_city'];

	    //echo var_dump($sender_city);
	    
	    // Определяем ID номер города отправителя
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, "https://pecom.ru/ru/calc/towns.php");
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    $data = curl_exec($curl);
	    
	    curl_close($curl);
	    
	    $senderCity = json_decode($data, $assoc=true);

	    //if(!$senderCity[$sender_city]) {
		  //echo "Невозможно рассчитать стоимость доставки ПЭК. Свяжитесь с нами для уточнения стоимости доставки.";
	    //}
	    	    
	    $city_id = array_search($sender_city, $senderCity[$sender_city]);

		//echo var_dump($senderCity[$sender_city]);	
		//echo var_dump($city_id);

	    // Определяем ID номер города получаетеля
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, "https://pecom.ru/ru/calc/towns.php");
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    $data = curl_exec($curl);
	    
	    curl_close($curl);
	    
	    $delivery_city = json_decode($data, $assoc=true);
	    $deliveryCity = $order['Order']['bill_city'];

	    //if(!$senderCity[$sender_city]) {
		  //echo "Невозможно рассчитать стоимость доставки ПЭК. Свяжитесь с нами для уточнения стоимости доставки.";
	    //}
	    	    
	    $delivery_city_id = array_search($deliveryCity, $delivery_city[$deliveryCity]);

	    //echo var_dump($deliveryCity);
	    //echo var_dump($delivery_city_id);

	    // Получаем расчёт стоимости доставки
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, "http://calc.pecom.ru/bitrix/components/pecom/calc/ajax.php?places[0][]=1&places[0][]=2&places[0][]=3&places[0][]=4&places[0][]=5&places[0][]=1&places[0][]=1&take[town]=".$city_id."&deliver[town]=".$delivery_city_id."");
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    $data = curl_exec($curl);
	    
	    curl_close($curl);

	    $senderCity = json_decode($data, $assoc=true);

	    //if(!$senderCity["deliver"][2]) {
		  //echo "Невозможно рассчитать стоимость доставки ПЭК. Свяжитесь с нами для уточнения стоимости доставки.";
	    //}
	    
	    //echo var_dump($senderCity);

		return $senderCity["deliver"][2]+$data_pek['handling'];
	}

	public function before_process()
	{
	}
	
}

?>