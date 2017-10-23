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
		$new_module['ShippingMethodValue'][1]['value'] = 'russianpostcalc.ru';

		$new_module['ShippingMethodValue'][2]['shipping_method_id'] = $this->ShippingMethod->id;
		$new_module['ShippingMethodValue'][2]['key'] = 'api_password';
		$new_module['ShippingMethodValue'][2]['value'] = 'russianpostcalc.ru';

		$new_module['ShippingMethodValue'][3]['shipping_method_id'] = $this->ShippingMethod->id;
		$new_module['ShippingMethodValue'][3]['key'] = 'store_zip_code';
		$new_module['ShippingMethodValue'][3]['value'] = '101000';

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

		$data = array();
		if(!empty($key_values['ShippingMethodValue']))
			$data = array_combine(Set::extract($key_values, 'ShippingMethodValue.{n}.key'),
				Set::extract($key_values, 'ShippingMethodValue.{n}.value'));


		$shipping_cost = $data['handling'];

		$total_weight = 0;
		
		foreach($order['OrderProduct'] AS $products)
		{
			$total_weight += (int) $products['weight']*$products['quantity'];
		}
			
		return $shipping_cost;
	}

	public function before_process()
	{
	}
	
}

?>