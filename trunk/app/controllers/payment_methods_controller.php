<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009 VaM Cart
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
		$this->set('current_crumb', __('Edit Payment Method', true));

		// Load Order Statuses
		App::import('Model', 'OrderStatusDescription');
		$OrderStatusDescription =& new OrderStatusDescription();

		$statutes = $OrderStatusDescription->find('all', array('order' => array('OrderStatusDescription.id ASC'), 'conditions'   => 'language_id = ' . $this->Session->read('Customer.language_id')));
		$statutes_list = array();

		foreach($statutes AS $status)
		{
			$status_key = $status['OrderStatusDescription']['order_status_id'];
			$statutes_list[$status_key] = $status['OrderStatusDescription']['name'];
		}

		$this->set('order_status_list',$statutes_list);

		// Get Current Order Statuses
		$order_status_id = $this->PaymentMethod->findById($id);

		$this->set('current_order_status', $order_status_id['PaymentMethod']['order_status_id']);	

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
				$db_module = $this->PaymentMethod->findByAlias($module['alias']);
				$module['id'] = $db_module['PaymentMethod']['id'];
				$module['name'] = (isset($db_module['PaymentMethod']['name'])?$db_module['PaymentMethod']['name']:Inflector::humanize($module['alias']));
				$module['default'] = (isset($db_module['PaymentMethod']['default'])?$db_module['PaymentMethod']['default']:0);
				$module['installed'] = $this->PaymentMethod->findCount(array('alias' => $module['alias'], 'active' => '1'));
				$module['order'] = $db_module['PaymentMethod']['order'];
				
				$modules[] = $module;
		}
		
		$this->set('modules',$modules);
				
	}

}
?>