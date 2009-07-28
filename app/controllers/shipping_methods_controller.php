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
		if(isset($this->params['form']['cancel']))
		{
			$this->redirect('/shipping_methods/admin/');
			die();
		}
		
		if(empty($this->data))
		{
			$this->set('data', $this->ShippingMethod->find(array('id' =>$shipping_method_id,null,null,2)));
			$this->render('admin_edit','admin');
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
	
	function admin ($ajax = false)
	{
		$this->set('current_crumb', __('Shipping Methods Listing', true));
		$this->set('shipping_method_data',$this->ShippingMethod->findAll(null,null,'ShippingMethod.name ASC'));	

		if($ajax == true)
			$this->render('admin','ajax');
		else
			$this->render('admin','admin');
	}	
}
?>