<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2019 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('ShippingAppController', 'Shipping.Controller');

class BoxberryController extends ShippingAppController {
	public $uses = array('ShippingMethod');
	public $module_name = 'Boxberry';
	public $icon = 'boxberry.png';

	public function settings ()
	{
		$this->set('data', $this->ShippingMethod->findByCode($this->module_name));
	}

	public function install()
	{

		$new_module = array();
		$new_module['ShippingMethod']['active'] = '1';
		$new_module['ShippingMethod']['default'] = '1';
		$new_module['ShippingMethod']['name'] = Inflector::humanize($this->module_name);

		$new_module['ShippingMethod']['description'] = '

<script src="//points.boxberry.ru/js/boxberry.js"> </script>
	<div id="boxberry_address"></div>
	<a href="#" class="btn btn-warning" onclick="boxberry.open(callback_function); return false;"><i class="fa fa-check"></i> Выбрать пункт выдачи на карте</a>
	<input type="hidden" name="boxberry_id" id="boxberry_id" value="" />
	<input type="hidden" name="boxberry_address" id="boxberry_address" value="" />

<script>

function callback_function(result){ 
document.getElementById("bill_line_2").value = result.address;
//document.getElementById("js-pricedelivery").innerHTML = result.price;
document.getElementById("boxberry_id").innerHTML = result.id;

result.name = encodeURIComponent(result.name) // Что бы избежать проблемы с кириллическими символами, на страницах отличными от UTF8, вы можете использовать функцию encodeURIComponent() 

//document.getElementById("boxberry_name").innerHTML =	result.name;
document.getElementById("boxberry_address").innerHTML =	result.address;
//document.getElementById("workschedule").innerHTML =	result.workschedule;
//document.getElementById("boxberry_phone").innerHTML = result.phone;
//document.getElementById("boxberry_period").innerHTML = result.period;

document.getElementById("ship_6").checked="checked";

if (result.prepaid=="1") { 
alert("Отделение работает только по предоплате!"); 
} 
} 
</script>

';


		$new_module['ShippingMethod']['icon'] = $this->icon;
		$new_module['ShippingMethod']['code'] = $this->module_name;

		$new_module['ShippingMethodValue'][0]['shipping_method_id'] = $this->ShippingMethod->id;
		$new_module['ShippingMethodValue'][0]['key'] = 'cost';
		$new_module['ShippingMethodValue'][0]['value'] = '400';

		$new_module['ShippingMethodValue'][1]['shipping_method_id'] = $this->ShippingMethod->id;
		$new_module['ShippingMethodValue'][1]['key'] = 'token';
		$new_module['ShippingMethodValue'][1]['value'] = '';

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

		$data_ems = array();
		if(!empty($key_values['ShippingMethodValue']))
			$data_ems = array_combine(Set::extract($key_values, 'ShippingMethodValue.{n}.key'),
				Set::extract($key_values, 'ShippingMethodValue.{n}.value'));
	
	    $token = $data_ems['token'];
	    $cost = $data_ems['cost'];
       $to_zip = $order['Order']['bill_zip'];
       $total = $order['Order']['total'];

			$total_weight = 0;
			
			foreach($order['OrderProduct'] AS $products)
			{
				$total_weight += $products['weight']*$products['quantity'];
			}
			
			$total_weight = $total_weight * 1000;
        
        $url="http://api.boxberry.de/json.php?token=".$token."&method=DeliveryCosts&weight=".$total_weight."&target=&ordersum=".$total."&deliverysum=".$cost."&targetstart=&height=&width=&depth=&zip=".$to_zip."";

        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $url);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);  

        $contents = $output;
        $results = json_decode($contents, true); 
        
        //echo var_dump($results);

		return $results["price"]+$cost;
	}

	public function before_process()
	{
	}
	
}

?>