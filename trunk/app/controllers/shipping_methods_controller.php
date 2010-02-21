<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009-2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class ShippingMethodsController extends AppController {
	var $name = 'ShippingMethods';

	function admin_change_active_status ($id) 
	{
		$this->changeActiveStatus($id);	
	}
	
	function admin_set_as_default ($id)
	{
		$this->setDefaultItem($id);
	}
	
	function admin_edit ($shipping_method_id)
	{
		$this->set('current_crumb', __('Edit Shipping Method', true));
		$this->pageTitle = __('Edit Shipping Method', true);
		if(isset($this->params['form']['cancel']))
		{
			$this->redirect('/shipping_methods/admin/');
			die();
		}
		
		if(empty($this->data))
		{
			$this->set('data', $this->ShippingMethod->find(array('id' =>$shipping_method_id,null,null,2)));
		}
		else
		{
			$this->ShippingMethod->save($this->data);
			
			if((isset($this->data['key_values'])) && (!empty($this->data['key_values'])))
			{
			foreach($this->data['key_values'] AS $key => $value)
			{
				$attribute = $this->ShippingMethod->ShippingMethodValue->findByKey($key);			
				if(empty($attribute))
				{
					$this->ShippingMethod->ShippingMethodValue->create();
					$attribute['ShippingMethodValue']['shipping_method_id'] = $this->data['ShippingMethod']['id'];
					$attribute['ShippingMethodValue']['key'] = $key;					
				}
				$attribute['ShippingMethodValue']['value'] = $value;
				$this->ShippingMethod->ShippingMethodValue->save($attribute);
			}
			}
			
			$this->Session->setFlash(__('Record saved.',true));
			$this->redirect('/shipping_methods/admin/');
		}
	}
	
	function admin ()
	{
		$this->set('current_crumb', __('Modules Listing', true));
		$this->pageTitle = __('Modules Listing', true);
		$path = APP . 'plugins' . DS . 'shipping' . DS . 'views';
		$module_path = new Folder($path);
		$dirs = $module_path->read();
		$modules = array();
		foreach($dirs[0] AS $dir)
		{
				$module = array();
				$module['code'] = $dir; 
				$db_module = $this->ShippingMethod->findByCode($module['code']);
				$module['id'] = $db_module['ShippingMethod']['id'];
				$module['name'] = (isset($db_module['ShippingMethod']['name'])?$db_module['ShippingMethod']['name']:Inflector::humanize($module['code']));
				$module['default'] = (isset($db_module['ShippingMethod']['default'])?$db_module['ShippingMethod']['default']:0);
				$module['installed'] = $this->ShippingMethod->find('count', array('conditions' => array('code' => $module['code'], 'active' => '1')));
				$module['order'] = $db_module['ShippingMethod']['order'];
				
				$modules[] = $module;
		}
		
		$this->set('modules',$modules);
				
	}

}
?>