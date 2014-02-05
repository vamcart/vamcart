<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('ShippingAppController', 'Shipping.Controller');

class EmsRussianPostShippingController extends ShippingAppController {
	public $uses = array('ShippingMethod');
	public $module_name = 'EmsRussianPostShipping';
	public $icon = 'ems.png';

	public function settings ()
	{
		$this->set('data', $this->ShippingMethod->findByCode($this->module_name));
	}

	public function install()
	{

		$new_module = array();
		$new_module['ShippingMethod']['active'] = '1';
		$new_module['ShippingMethod']['default'] = '0';
		$new_module['ShippingMethod']['name'] = Inflector::humanize($this->module_name);
		$new_module['ShippingMethod']['icon'] = $this->icon;
		$new_module['ShippingMethod']['code'] = $this->module_name;

		$new_module['ShippingMethodValue'][0]['shipping_method_id'] = $this->ShippingMethod->id;
		$new_module['ShippingMethodValue'][0]['key'] = 'city';
		$new_module['ShippingMethodValue'][0]['value'] = 'Москва';

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

			global $order;

			$this->Translit = new TranslitComponent(new ComponentCollection());
			
        $from_city = strtolower('city--Moskva');
        $to_city = strtolower('city--'.$this->Translit->convert($order['Order']['bill_city']));

			$total_weight = 0;
			
			foreach($order['OrderProduct'] AS $products)
			{
				$total_weight += (int) $products['weight']*$products['quantity'];
			}
        
        $url = 'http://emspost.ru/api/rest?method=ems.calculate&from='.$from_city.'&to='.$to_city.'&weight='.$total_weight;

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
        $contents = utf8_encode($contents);
        $results = json_decode($contents, true); 

		return $results['rsp']['price'];
	}

	public function before_process()
	{
	}
	
}

?>