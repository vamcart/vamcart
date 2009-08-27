<?php 
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.com
   http://vamshop.ru
   Copyright 2009 VaM Shop
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class FlatRateController extends ShippingAppController {
	var $uses = array('ShippingMethod');
	var $module_name = 'flat_rate';

	function settings ()
	{
	}

	function install()
	{

		$new_module = array();
		$new_module['ShippingMethod']['active'] = '1';
		$new_module['ShippingMethod']['name'] = Inflector::humanize($this->module_name);
		$new_module['ShippingMethod']['code'] = $this->module_name;
		$this->ShippingMethod->save($new_module);

		$new_module_values = array();
		$new_module_values['ShippingMethodValue']['shipping_method_id'] = $this->ShippingMethod->id;
		$new_module_values['ShippingMethodValue']['key'] = 'rate';
		$new_module_values['ShippingMethodValue']['value'] = '5.99';

		$this->ShippingMethod->ShippingMethodValue->save($new_module_values);

		$new_module_values = array();
		$new_module_values['ShippingMethodValue']['shipping_method_id'] = $this->ShippingMethod->id;
		$new_module_values['ShippingMethodValue']['key'] = 'cost';
		$new_module_values['ShippingMethodValue']['value'] = '5.99';

		$this->ShippingMethod->ShippingMethodValue->save($new_module_values);

		$this->Session->setFlash(__('Module Installed', true));
		$this->redirect('/shipping_methods/admin/');
	}

	function uninstall()
	{

		$module_id = $this->ShippingMethod->findByCode($this->module_name);

		$this->ShippingMethod->del($module_id['ShippingMethod']['id'], true);
			
		$this->Session->setFlash(__('Module Uninstalled', true));
		$this->redirect('/shipping_methods/admin/');
	}

	function calculate ()
	{
		App::import('Model', 'ShippingMethod');
		$this->ShippingMethod =& new ShippingMethod();
		
		$method = $this->ShippingMethod->findByCode($this->module_name);

		return $method['ShippingMethodValue'][0]['value'];
	}
	
}

?>