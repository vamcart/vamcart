<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_cdek_shipping_time()
{
$template = '
{$shipping_time}
';
		
return $template;
}


function smarty_function_cdek_shipping_time($params, $template)
{
	global $content, $config, $order;

	$geo_data = array();
  App::import('Vendor', 'GeoCity', array('file' => 'GeoCity'.DS.'SxGeo.php'));
  $SxGeo= new SxGeo(APP.'Vendor/GeoCity/SxGeo.dat');
  $geo_data = $SxGeo->get($_SERVER['REMOTE_ADDR']);

	$city = $geo_data["city"]["name_ru"];
	
	if ($_COOKIE['vamshop-city']) $city = $_COOKIE['vamshop-city'];

	if(!isset($params['city'])) {
		$params['city'] = $city;	
	} else {
		$city = $params['city'];	
	}	

	if ($_POST['bill_city'] != '') $city = $_POST['bill_city'];

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://api.cdek.ru/city/getListByTerm/json.php?q=".urlencode($city));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt($ch,CURLOPT_TIMEOUT,3);
    $data = curl_exec($curl);
    
    curl_close($curl);
    if($data === false) {
	  if ($data_cdek['debug'] == 1) echo "ID номер для города отправителя посылки не найден.";
    }
    
    $senderCity = json_decode($data, $assoc=true);
    $senderCityId = $senderCity["geonames"][0]["id"];

	$state = $geo_data["region"]["name_ru"];
	$country = $geo_data["country"]["name_ru"];
	
	// Cache the output.
	$cache_name = 'vam_cdek_shipping_time_output' . (isset($params['template'])?'_'.$params['template']:'') . $content['Content']['id'] .'_' . $_SESSION['Customer']['language_id'].'_'.$city;
	$output = Cache::read($cache_name, 'catalog');
	if($output === false)
	{
	ob_start();

	App::uses('SmartyComponent', 'Controller/Component');
	$Smarty = new SmartyComponent(new ComponentCollection());

	App::uses('CurrencyBaseComponent', 'Controller/Component');
	$CurrencyBase = new CurrencyBaseComponent(new ComponentCollection());

	App::import('Model', 'ShippingMethod');
		$ShippingMethod = new ShippingMethod();

     $cdek_pvz_checkout = "https://integration.cdek.ru/pvzlist.php?cityid=".$senderCityId;
     
     //echo $senderCityId;
     
     $cdek_results = '';
     
     // create curl resource
     $ch = curl_init();

     // set url
     curl_setopt($ch, CURLOPT_URL, $cdek_pvz_checkout);

     //return the transfer as a string
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

     // $output contains the output string
     $output = curl_exec($ch);

     // close curl resource to free up system resources
     curl_close($ch);  

     $cdek_contents = $output;
     $cdek_results = simplexml_load_string($cdek_contents);
     
     //echo var_dump($cdek_results);

	$keyed_cdek_shipping_time = array();
	$pvz_id = 0;
	foreach($cdek_results AS $pvz)
	{
		$keyed_cdek_shipping_time[$pvz_id] = array(
										  'id' => $pvz['Code'],
										  'name' => $pvz['Name'],
										  'address' => $pvz['City'].', '.$pvz['Address'],
										  'phone' => $pvz['Phone'],
										  );
										  
   $pvz_id++;
	}	
	
		$key_values = $ShippingMethod->findByCode("Cdek");

		$data_cdek = array();
		if(!empty($key_values['ShippingMethodValue']))
			$data_cdek = array_combine(Set::extract($key_values, 'ShippingMethodValue.{n}.key'),
				Set::extract($key_values, 'ShippingMethodValue.{n}.value'));
	
	    $sender_city = $data_cdek['sender_city'];
	    
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, "https://api.cdek.ru/city/getListByTerm/json.php?q=".urlencode($sender_city));
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    $data = curl_exec($curl);
	    
	    curl_close($curl);
	    if($data === false) {
		  if ($data_cdek['debug'] == 1) echo "ID номер для города отправителя посылки не найден.";
	    }
	    
	    $senderCity = json_decode($data, $assoc=true);
	    $senderCityId = $senderCity["geonames"][0]["id"];
	
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, "https://api.cdek.ru/city/getListByTerm/json.php?q=".urlencode($order['Order']['bill_city']));
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    $data = curl_exec($curl);
	    
	    curl_close($curl);
	    if($data === false) {
		  if ($data_cdek['debug'] == 1) echo "ID номер для города получателя посылки не найден.";
	    }
	    
	    $receiverCity = json_decode($data, $assoc=true);
	    $receiverCityId = $receiverCity["geonames"][0]["id"];


		//подключаем файл с классом CalculatePriceDeliveryCdek
		App::import('Vendor', 'Cdek', array('file' => 'cdek'.DS.'CalculatePriceDeliveryCdek.php'));
		
		$data_cdek['debug'] = 0;
		
		try {
		
			//создаём экземпляр объекта CalculatePriceDeliveryCdek
			$calc = new CalculatePriceDeliveryCdek();
			
		    //Авторизация.
		    if ($data_cdek['api_key'] != '' && $data_cdek['api_password'] != '') $calc->setAuth($data_cdek['api_key'], $data_cdek['api_password']);
			
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
			$calc->setTariffId('136');
				
			//устанавливаем режим доставки
			$calc->setModeDeliveryId(3);
			//добавляем места в отправление
			
				foreach($order['OrderProduct'] AS $products)
				{
					$calc->addGoodsItemBySize($products['weight'], $products['length'], $products['width'], $products['height']*$products['quantity']);
		
				}	
			
			if ($calc->calculate() === true) {
				$res = $calc->getResult();
				
				if ($data_cdek['debug'] == 1) echo 'Цена доставки: ' . $res['result']['price'] . 'руб.<br />';
				$shipping_time = $res['result']['deliveryPeriodMin'] .'-'. $res['result']['deliveryPeriodMax'] .' дн.';
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
			
	
	
	$assignments = array(
		'city' => $city,
		'state' => $state,
		'country' => $country,
		'shipping_time' => $shipping_time,
		'cdek_pvz_checkout' => $keyed_cdek_shipping_time
	);

	$display_template = $Smarty->load_template($params, 'cdek_shipping_time');
	//$Smarty->display($display_template, $assignments);
	$output = $Smarty->display($display_template, $assignments);
	 
	// Write the output to cache and echo them	
	$output = @ob_get_contents();
	ob_end_clean();	
	Cache::write($cache_name, $output, 'catalog');		
	}
	
	echo $output;
	
}

function smarty_help_function_cdek_shipping_time() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays the cdek shipping time.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{cdek_shipping_time}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Useful if you want to override the default content listing template. Setting this will utilize the template that matches this alias.') ?></li>
		<li><em><?php echo __('(city)') ?></em> - <?php echo __('City name.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_cdek_shipping_time() {
}
?>