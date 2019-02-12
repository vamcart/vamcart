<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
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

<script type="text/javascript" src="https://pickpoint.ru/select/postamat.js"></script>
	<div id="address"></div>
	<a href="#" class="btn btn-warning" onclick="PickPoint.open(my_function);return false"><i class="fa fa-check"></i> Выбрать постамат</a>
	<input type="hidden" name="pickpoint_id" id="pickpoint_id" value="" />
	<input type="hidden" name="pickpoint_address" id="pickpoint_address" value="" />

<script>
	function my_function(result){
		// устанавливаем в скрытое поле ID терминала
		document.getElementById("pickpoint_id").value=result["id"];
		
		// показываем пользователю название точки и адрес доствки
		document.getElementById("address").innerHTML=result["name"]+"<br />"+result["address"];

		// показываем пользователю название точки и адрес доствки
		document.getElementById("pickpoint_address").value=result["name"]+result["address"];

		// показываем пользователю название точки и адрес доствки
		document.getElementById("bill_line_2").value=result["name"]+result["address"];

		document.getElementById("ship_7").checked="checked";

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
	
	    $from_zip = $data_ems['city'];
	    			
       $to_zip = $order['Order']['bill_zip'];

			$total_weight = 0;
			
			foreach($order['OrderProduct'] AS $products)
			{
				$total_weight += $products['weight']*$products['quantity'];
			}
			
			$total_weight = $total_weight * 1000;
        
        $ems = "http://tariff.russianpost.ru/tariff/v1/calculate?json&object=7030&from=".$from_zip."&to=".$to_zip."&weight=".$total_weight."";

        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $ems);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);  

        $contents = $output;
        $results = json_decode($contents, true); 

		return $results["pay"]/100;
	}

	public function before_process()
	{
	}
	
}

?>