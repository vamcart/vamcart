<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('ShippingAppController', 'Shipping.Controller');

class SpsrController extends ShippingAppController {
	public $uses = array('ShippingMethod');
	public $module_name = 'Spsr';
	public $icon = 'spsr.png';

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
		$new_module['ShippingMethodValue'][1]['value'] = 'test';

		$new_module['ShippingMethodValue'][2]['shipping_method_id'] = $this->ShippingMethod->id;
		$new_module['ShippingMethodValue'][2]['key'] = 'api_password';
		$new_module['ShippingMethodValue'][2]['value'] = 'test';

		$new_module['ShippingMethodValue'][3]['shipping_method_id'] = $this->ShippingMethod->id;
		$new_module['ShippingMethodValue'][3]['key'] = 'sender_city';
		$new_module['ShippingMethodValue'][3]['value'] = 'Москва';

		$new_module['ShippingMethodValue'][4]['shipping_method_id'] = $this->ShippingMethod->id;
		$new_module['ShippingMethodValue'][4]['key'] = 'ikn';
		$new_module['ShippingMethodValue'][4]['value'] = '7600010711';

		$new_module['ShippingMethodValue'][5]['shipping_method_id'] = $this->ShippingMethod->id;
		$new_module['ShippingMethodValue'][5]['key'] = 'ship_type';
		$new_module['ShippingMethodValue'][5]['value'] = '3';

		$new_module['ShippingMethodValue'][6]['shipping_method_id'] = $this->ShippingMethod->id;
		$new_module['ShippingMethodValue'][6]['key'] = 'debug';
		$new_module['ShippingMethodValue'][6]['value'] = '0';

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
		global $order, $config;
		
		$cost = 0;

		$shipping_weight = 0;
		
		foreach($order['OrderProduct'] AS $product)				
		{
			$shipping_weight += ($product['weight'] * $product['quantity']);
		}
		
		$key_values = $this->ShippingMethod->findByCode($this->module_name);

		$data_spsr = array();
		if(!empty($key_values['ShippingMethodValue']))
			$data_spsr = array_combine(Set::extract($key_values, 'ShippingMethodValue.{n}.key'),
				Set::extract($key_values, 'ShippingMethodValue.{n}.value'));
	
	    $sender_city = $data_spsr['sender_city'];

		//вытаскиваем Region ID города назначения базы
		//$region_id = vam_get_spsr_zone_id($order->delivery['zone_id']);
		$region_id = 992; // Москва
		
		//вытаскиваем свой Region ID из базы
		//$own_cpcr_id = vam_get_spsr_zone_id($own_zone_id);
		$own_cpcr_id = 992; // Москва

	//oscommerce дважды запрашивает цену доставки c cpcr.ru - до подтверждения цены доставки (для показа пользователю) и после подтверждения цены доставки (нажатие кнопки "Продолжить"). Х.з. почему, видимо так работает oscommerce. Чтобы не запрашивать дважды кешируем $cost в hidden поле cost.


    $xml_from_city = '
<root xmlns="http://spsr.ru/webapi/Info/GetCities/1.0">
<p:Params Name="WAGetCities" Ver="1.0" xmlns:p="http://spsr.ru/webapi/WA/1.0" />
<GetCities CityName="'.$data_spsr['sender_city'].'" />
</root>
    ';

    $result_from_city = $this->send_xml( $xml_from_city );
 
    $xml_string_from_city = simplexml_load_string($result_from_city);

    $xml_to_city = '
<root xmlns="http://spsr.ru/webapi/Info/GetCities/1.0">
<p:Params Name="WAGetCities" Ver="1.0" xmlns:p="http://spsr.ru/webapi/WA/1.0" />
<GetCities CityName="'.$order['Order']['bill_city'].'" />
</root>
    ';

    $result_to_city = $this->send_xml( $xml_to_city );
 
    $xml_string_to_city = simplexml_load_string($result_to_city);

    $xml_error_to_city = '
<root xmlns="http://spsr.ru/webapi/Info/GetCities/1.0">
<p:Params Name="WAGetCities" Ver="1.0" xmlns:p="http://spsr.ru/webapi/WA/1.0" />
<GetCities CityName="'.$_POST['error_tocity'].'" />
</root>
    ';

    $result_error_to_city = $this->send_xml( $xml_error_to_city );
 
    $xml_string_error_to_city = simplexml_load_string($result_error_to_city);


    $xml_sid = '
<root xmlns="http://spsr.ru/webapi/usermanagment/login/1.0">
<p:Params Name="WALogin" Ver="1.0" xmlns:p="http://spsr.ru/webapi/WA/1.0" />
<Login Login="'.$data_spsr['api_key'].'" Pass="'.$data_spsr['api_password'].'" UserAgent="'.$config['site_name'].'" />
</root>
    ';

    $result_xml_sid = $this->send_xml( $xml_sid );
 
    $xml_sid = simplexml_load_string($result_xml_sid);
    
	if (!isset($_POST['cost'])) {		 		
		//составление запроса стоимости доставки
		if(isset($_POST['error_tocity']))
			{
			$request='http://www.cpcr.ru/cgi-bin/postxml.pl?TARIFFCOMPUTE_2&ToCity='.$xml_string_error_to_city->City->Cities['City_ID'].'|0&FromCity='.$xml_string_from_city->City->Cities['City_ID'].'|0&Weight='. $shipping_weight .'&ToBeCalledFor=0&SID='.$xml_sid->Login['SID'].'';
			//$request='http://cpcr.ru/cgi-bin/postxml.pl?TariffCompute&FromRegion='.$own_cpcr_id.'|0&FromCityName='.iconv("UTF-8","windows-1251", $data_spsr['sender_city']).'&Weight='. $shipping_weight .'&Nature='.MODULE_SHIPPING_SPSR_NATURE.'&Amount=0&Country=209|0&ToCity='.iconv("UTF-8","windows-1251", $_POST['error_tocity']);
			}
		else
			{
			$request='http://www.cpcr.ru/cgi-bin/postxml.pl?TARIFFCOMPUTE_2&ToCity='.$xml_string_to_city->City->Cities['City_ID'].'|0&FromCity='.$xml_string_from_city->City->Cities['City_ID'].'|0&Weight='. $shipping_weight .'&ToBeCalledFor==0&SID='.$xml_sid->Login['SID'].'';
			//$request='http://cpcr.ru/cgi-bin/postxml.pl?TariffCompute&FromRegion='.$own_cpcr_id.'|0&FromCityName='.iconv("UTF-8","windows-1251", $data_spsr['sender_city']).'&Weight='. $shipping_weight .'&Nature='.MODULE_SHIPPING_SPSR_NATURE.'&Amount=0&Country=209|0&ToRegion='.$region_id.'|0&ToCityName='.iconv("UTF-8","windows-1251", $order['Order']['bill_city']);
			}
		
		//проверки связи с сервером
		$server_link = false;
		
		$file_headers = @get_headers($request);
		if(($file_headers[0] !== 'HTTP/1.1 404 Not Found') && ($file_headers!==false)) {
			$server_link = true;
		}
	
		//Запрос стоимости с cpcr.ru
		if ($server_link==true){
			$xmlstring= simplexml_load_file($request);
		}else{
			$title = "<font color=red>Нет связи с сервером cpcr.ru, стоимость доставки не определена.</font>";
			$cost = 0;
		}

//echo var_dump($xmlstring);

    $xml_sid_logout = '
<root xmlns="http://spsr.ru/webapi/usermanagment/logout/1.0" >
<p:Params Name="WALogout" Ver="1.0" xmlns:p="http://spsr.ru/webapi/WA/1.0" />
<Logout Login="'.$data_spsr['api_key'].'" SID="'.$xml_sid->Login['SID'].'" />
</root>
    ';

    $result_xml_sid_logout = $this->send_xml( $xml_sid_logout );
 
    $xml_sid_logout = simplexml_load_string($result_xml_sid_logout);

//echo var_dump($xml_sid_logout);

		//получение цены доставки
		if ($xmlstring->Tariff)
			{
			$find_symbols = array(chr(160),'р.',' '); //вместо пробела в стоимости доставки cpcr.ru использует симовл с ascii кодом 160.
			$cost = ceil(str_replace(',','.',str_replace($find_symbols,'',$xmlstring->Tariff->Total_Dost)));
			$title .= 'Доставка в '.$order['Order']['bill_city'].', '.$order['BillState']['name'];
			if ($cost>0) {$title .= '<input type="hidden" name="cost" value="'.$cost.'">';}			
			}
	//если $cost уже был определен
	}else{
		$cost = $_POST['cost'];
		$title .= 'Доставка в '.$order['Order']['bill_city'].', '.$order['BillState']['name'];
		if ($cost>0) {$title .= '<input type="hidden" name="cost" value="'.$cost.'">';}	
	}			
		
		//Обработка ошибки Город не найден
		if ($xmlstring->Error->ToCity && $server_link == true)
			{
			$title .= "<font color=red>Ошибка, город \"".$order['Order']['bill_city']."\" не найден. Либо в названии города допущена ошибка, либо в данный город СПСР доставку не производит.</font><br />";
			}
		
			//Уточнение названия города, для получения City_Id c сервера cpcr.ru
		if (!$xmlstring->Error->ToCity->City->CityName=='')
			{
			$title .= "<font color=red>Пожалуйста уточните название вашего города:</font><br />";
			if ($xmlstring->Error->ToCity->City)
				{
				foreach ($xmlstring->Error->ToCity->City as $city_value)
					{		
					$title .= "<input type=radio name=error_tocity value=\"".$city_value->City_Id."|".$city_value->City_Owner_Id."\" onChange=\"this.form.submit()\">".$city_value->CityName.", ".$city_value->RegionName."<br />";
					//начало код для унификации с калькулятором
					echo "<input type=hidden name=\"".$city_value->City_Id."|".$city_value->City_Owner_Id."\" value=\"".$city_value->CityName.", ".$city_value->RegionName."\">";	
					//конец код для унификации с калькулятором						
					}
				}
			}
			
		//Обработка ошибки Веса
		if ($xmlstring->Error->Weight)
			{
			$title .= "<br /><font color=red>Ошибка! Неправильный формат веса</font>";
			}
		
		//Оюработка ошибки Оценочной стоимости	
		if ($xmlstring->Error->Amount)
			{
			$title .= "<br /><font color=red>Ошибка! Неправильный формат оценочной стоимости</font>";
			}
		if (!isset($own_cpcr_id))
			{
			$title .= "<br /><font color=red>Ошибка! Вы не выбрали зону! (Администрирование>Настройки>My store>Zone)</font>";
			}
			
		//Обработка ошибки Mutex Wait Timeout
		if ($xmlstring->Error['Type']=='Mutex' & $xmlstring->Error['SubType']=='Wait Timeout')  {
			$title .= "<br /><font color=red>Ошибка! cpcr.ru не вернул ответ на запрос. Попробуйте обновить страницу.</font>";
		}
		
		//Обработка ошибки ComputeTariff CalcError
		if ($xmlstring->Error['Type']=='ComputeTariff' & $xmlstring->Error['SubType']=='CalcError')  {
			$title .= "<br /><font color=red>Ошибка! Ошибка вычисления стоимости доставки.</font>";
		}		
		
		//Обработка ошибки Command Unknown
		if ($xmlstring->Error['Type']=='Command' & $xmlstring->Error['SubType']=='Unknown')  {
			$title .= "<br /><font color=red>Ошибка! Неизвестная команда.</font>";
		}
		
		//Обработка ошибки Unknown Unknown (прочие ошибки)
		if ($xmlstring->Error['Type'])  {
			$title .= "<br /><font color=red>Неизвестная ошибка, попробуйте позже.</font>";
		}		
		
		//Отображдение отладочной информации
		if($data_spsr['debug'] == 1)
			{
			$title .= "<br />".'$own_zone_id='.$own_zone_id."<br />".
			'Город отправки='.$data_spsr['sender_city']."<br />".
			'$shipping_weight='.$shipping_weight."<br />".
			'Тип отправления='.$data_spsr['ship_type']."<br />".
			'$request='.$request."<br />".
			'$cost='.$cost."<br />".
			'$_POST[\'cost\']='.$_POST['cost'];
			'$xmlstring:'."<br />".
			(is_object($xmlstring)?"<textarea readonly=\"readonly\" rows=\"5\">".$xmlstring->asXML()."</textarea>":'');			
			}

		if ($data_spsr['debug'] == 1) echo $title;

		return $cost+$data_spsr['handling'];

	}

	public function before_process()
	{
	}


	private function send_xml( $xml )
	{
		$addr = 'http://api.spsr.ru/waExec/WAExec';
		$curl = curl_init();
	
		curl_setopt( $curl, CURLOPT_URL,  $addr);
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); 
		curl_setopt( $curl, CURLOPT_POST, 1);
		curl_setopt( $curl, CURLOPT_POSTFIELDS,   $xml );
	
		$header = array('Content-Type: application/xml');
	 
		curl_setopt( $curl, CURLOPT_HTTPHEADER, $header);
						      
	
		$result = curl_exec( $curl );
		//$result = htmlspecialchars($result); 
		curl_close( $curl );
		return $result;
	}
		
}

?>