<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class PerItemController extends ShippingAppController {
	var $uses = array('ShippingMethod');
	var $module_name = 'per_item';

	function settings ()
	{
		$this->set('data', $this->ShippingMethod->findByCode($this->module_name));
	}

	function install()
	{

		$new_module = array();
		$new_module['ShippingMethod']['active'] = '1';
		$new_module['ShippingMethod']['name'] = Inflector::humanize($this->module_name);
		$new_module['ShippingMethod']['code'] = $this->module_name;

		$new_module['ShippingMethodValue'][0]['shipping_method_id'] = $this->ShippingMethod->id;
		$new_module['ShippingMethodValue'][0]['key'] = 'per_item_amount';
		$new_module['ShippingMethodValue'][0]['value'] = '1.00';

		$new_module['ShippingMethodValue'][1]['shipping_method_id'] = $this->ShippingMethod->id;
		$new_module['ShippingMethodValue'][1]['key'] = 'per_item_handling';
		$new_module['ShippingMethodValue'][1]['value'] = '5.00';

		$this->ShippingMethod->saveAll($new_module);

		$this->Session->setFlash(__('Module Installed', true));
		$this->redirect('/shipping_methods/admin/');
	}

	function uninstall()
	{

		$module_id = $this->ShippingMethod->findByCode($this->module_name);

		$this->ShippingMethod->delete($module_id['ShippingMethod']['id'], true);
			
		$this->Session->setFlash(__('Module Uninstalled', true));
		$this->redirect('/shipping_methods/admin/');
	}

	function calculate ()
	{
		App::import('Model', 'ShippingMethod');
		$this->ShippingMethod =& new ShippingMethod();
		$key_values = $this->ShippingMethod->findByCode($this->module_name);
	
		$data = array();
		if(!empty($key_values['ShippingMethodValue']))
			$data = array_combine(Set::extract($key_values, 'ShippingMethodValue.{n}.key'),
							  Set::extract($key_values, 'ShippingMethodValue.{n}.value'));	
		
		global $order;
		
		$shipping_total = $data['per_item_handling'];
		
		foreach($order['OrderProduct'] AS $product)
		{
			$shipping_total += ($data['per_item_amount']*$product['quantity']);
		}
		
		return $shipping_total;
	}

	function before_process()
	{
	}
	
}

?>