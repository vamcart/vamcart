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

class PaymentMethodsController extends AppController {
	var $name = 'PaymentMethods';

	function admin_set_as_default ($id)
	{
		$this->setDefaultItem($id);
	}
	
	function admin_change_active_status ($id) 
	{
		$this->changeActiveStatus($id);	
	}
		

	function admin_edit ($id)
	{
//		$id = $this->PaymentMethod->find(array('alias' => $payment_method));
		$this->set('current_crumb', __('Edit Payment Method', true));
		if(empty($this->data))
		{
			$this->set('data',$this->PaymentMethod->read(null,$id));
		}
		else
		{
			if(isset($this->params['form']['cancel']))
			{
				$this->redirect('/payment_methods/admin/');
				die();
			}

			// Save the main payment information
			$this->PaymentMethod->save($this->data);
			
			// Loop through the extra and save the the PaymentMethodValue table
			$payment = $this->PaymentMethod->read(null,$id);
			$type_key = $payment['PaymentMethod']['alias'];
			
			foreach($this->data[$type_key] AS $key => $value)
			{
				$original_value = $this->PaymentMethod->PaymentMethodValue->find(array('key' => $key,'payment_method_id' => $id));
				$original_value['PaymentMethodValue']['payment_method_id'] = $id;
				$original_value['PaymentMethodValue']['key'] = $key;
				$original_value['PaymentMethodValue']['value'] = $value;				

				$this->PaymentMethod->PaymentMethodValue->save($original_value);
			}
			
			$this->Session->setFlash(__('Record saved.',true));
			$this->redirect('/payment_methods/admin/');
		}
	
	}	
		
//	function admin ($ajax = false)
//	{
//		$this->set('current_crumb', __('Payment Methods Listing', true));
//		$this->set('payment_method_data',$this->PaymentMethod->find('all', array('order' => array('PaymentMethod.name ASC'))));	

//	}	

	function admin ()
	{
		$this->set('current_crumb', __('Modules Listing', true));
		$path = APP . 'plugins' . DS . 'payment' . DS . 'views';
		$module_path = new Folder($path);
		$dirs = $module_path->read();
		$modules = array();
		foreach($dirs[0] AS $dir)
		{
				$module = array();
				$module['alias'] = $dir; 
				$module['name'] = Inflector::humanize($module['alias']);
				$module['installed'] = $this->PaymentMethod->findCount(array('alias' => $module['alias'], 'active' => '1'));
				$module['version'] = '1';
				
				if($module['installed'] > 0)
				{
					$db_module = $this->Module->find(array('alias' => $module['alias']));
					$module['installed_version'] = $db_module['Module']['version'];
				}
					
				$modules[] = $module;
		}
		
		$this->set('modules',$modules);
				
	}

	function install($payment_method)
	{

		$new_module = array();
		$new_module['PaymentMethod']['active'] = '1';
		$new_module['PaymentMethod']['default'] = '1';
		$new_module['PaymentMethod']['name'] = $payment_method;
		$new_module['PaymentMethod']['alias'] = $payment_method;
		$this->PaymentMethod->save($new_module);
			
		$this->Session->setFlash(__('Module Installed', true));
		$this->redirect('/payment_methods/admin/');
	}

	function uninstall($payment_method)
	{

		$module_id = $this->PaymentMethod->find(array('alias' => $payment_method));

		$this->PaymentMethod->del($module_id);
			
		$this->Session->setFlash(__('Module Uninstalled', true));
		$this->redirect(array('action'=>'admin'));
	}
	
}
?>