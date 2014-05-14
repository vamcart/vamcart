<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('ShippingAppController', 'Shipping.Controller');

class TableBasedController extends ShippingAppController {
	public $uses = array('ShippingMethod');
	public $module_name = 'TableBased';
	public $icon = 'table.png';

	public function settings ()
	{
		$this->set('data', $this->ShippingMethod->findByCode($this->module_name));
	}

	public function install()
	{

		$new_module = array();
		$new_module['ShippingMethod']['active'] = '1';
		$new_module['ShippingMethod']['name'] = Inflector::humanize($this->module_name);
		$new_module['ShippingMethod']['icon'] = $this->icon;
		$new_module['ShippingMethod']['code'] = $this->module_name;

		$new_module['ShippingMethodValue'][0]['shipping_method_id'] = $this->ShippingMethod->id;
		$new_module['ShippingMethodValue'][0]['key'] = 'table_based_type';
		$new_module['ShippingMethodValue'][0]['value'] = 'weight';

		$new_module['ShippingMethodValue'][1]['shipping_method_id'] = $this->ShippingMethod->id;
		$new_module['ShippingMethodValue'][1]['key'] = 'table_based_rates';
		$new_module['ShippingMethodValue'][1]['value'] = '0:0.50,1:1.50,2:2.25,3:3.00,4:5.75';

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
		$key_values = $this->ShippingMethod->findByCode($this->module_name);
	
		$data = array();
		if(!empty($key_values['ShippingMethodValue']))
			$data = array_combine(Set::extract($key_values, 'ShippingMethodValue.{n}.key'),
							  Set::extract($key_values, 'ShippingMethodValue.{n}.value'));	
		
		// Calculate the unit of measure depending on what's set in the database
		global $order;
		$units = 0;		
		switch($data['table_based_type'])
		{
			case 'products':
				$units = count($order['OrderProduct']);
			break;
			case 'total':
				$units = $order['Order']['total'];
			break;		
			case 'weight':
				foreach($order['OrderProduct'] AS $product)				
				{
					$units += ($product['weight'] * $product['quantity']);
				}
			break;				
		}
		
		// Loop through the rates value
$newline = 
'
';	
		$rates = str_replace($newline,'',$data['table_based_rates']);
		$rates = explode(',',$rates);
		
		$keyed_rates = array();
		foreach($rates AS $key => $value)
		{
			$temp_rates = explode(':',$value);
			$temp_rate_key = $temp_rates['0'];
			$keyed_rates[$temp_rate_key] = $temp_rates['1'];
		}
		
		$keyed_rates = array_reverse($keyed_rates,true);

		$shipping_price = 0;
		foreach($keyed_rates AS $key => $value)
		{
			if(($key < $units)&&($shipping_price == 0))
			{
				$shipping_price = $value;
			}
		}
		
		return $shipping_price;
	}
	
	public function before_process()
	{
	}
		
}

?>