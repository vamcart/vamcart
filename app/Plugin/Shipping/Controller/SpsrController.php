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
		$method = $this->ShippingMethod->findByCode($this->module_name);

		return $method['ShippingMethodValue'][0]['value'];
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