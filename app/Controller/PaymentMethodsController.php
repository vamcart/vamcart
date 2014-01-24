<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Folder', 'Utility');

class PaymentMethodsController extends AppController {
	public $name = 'PaymentMethods';

	public function admin_set_as_default ($id)
	{
		$this->setDefaultItem($id);
	}
	
	public function admin_change_active_status ($id) 
	{
		$this->changeActiveStatus($id);	
	}
		

	public function admin_edit ($id)
	{
		$this->set('current_crumb', __('Edit Payment Method', true));
		$this->set('title_for_layout', __('Edit Payment Method', true));

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
			if(isset($this->data['cancelbutton']))
			{
				$this->redirect('/payment_methods/admin/');
				die();
			}

			// Save the main payment information
			$this->PaymentMethod->save($this->data);
			
			// Loop through the extra and save the the PaymentMethodValue table
			$payment = $this->PaymentMethod->read(null,$id);
			$type_key = strtolower($payment['PaymentMethod']['alias']);
			if (isset($this->data[$type_key])) {
			foreach($this->data[$type_key] AS $key => $value)
			{
				$original_value = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => $key,'payment_method_id' => $id)));
				$original_value['PaymentMethodValue']['payment_method_id'] = $id;
				$original_value['PaymentMethodValue']['key'] = $key;
				$original_value['PaymentMethodValue']['value'] = $value;				

				$this->PaymentMethod->PaymentMethodValue->save($original_value);
			}
			}
			
			$this->Session->setFlash(__('Record saved.',true));
			$this->redirect('/payment_methods/admin/');
		}
	
	}	
		
	public function admin ()
	{
		$this->set('current_crumb', __('Modules Listing', true));
		$this->set('title_for_layout', __('Modules Listing', true));
		$path = APP . 'Plugin' . DS . 'Payment' . DS . 'View';
		$module_path = new Folder($path);
		$dirs = $module_path->read();
		$modules = array();
		foreach($dirs[0] AS $dir)
		{
				$module = array();
				$module['alias'] = $dir; 
				$db_module = $this->PaymentMethod->findByAlias($module['alias']);
				$module['id'] = (isset($db_module['PaymentMethod']['id'])?$db_module['PaymentMethod']['id']:null);
				$module['name'] = (isset($db_module['PaymentMethod']['name'])?$db_module['PaymentMethod']['name']:Inflector::humanize($module['alias']));
				$module['default'] = (isset($db_module['PaymentMethod']['default'])?$db_module['PaymentMethod']['default']:null);
				$module['installed'] = $this->PaymentMethod->find('count', array('conditions' => array('alias' => $module['alias'], 'active' => '1')));
				$module['order'] = (isset($db_module['PaymentMethod']['order'])?$db_module['PaymentMethod']['order']:null);
				
				$modules[] = $module;
		}
		
		$this->set('modules',$modules);
				
	}

	public function admin_add ()
	{
		$this->set('current_crumb', __('Module Upload', true));
		$this->set('title_for_layout', __('Module Upload', true));
	}

	public function admin_upload ()
	{
		$this->set('current_crumb', __('Module Upload', true));
		$this->set('title_for_layout', __('Module Upload', true));

		// If they pressed cancel
		if(isset($this->data['cancelbutton']))
		{
			$this->redirect('/payment_methods/admin/');
			die();
		}
		
		$val = $this->data['AddModule']['submittedfile'];
		
		if ( (!empty( $this->data['AddModule']['submittedfile']['tmp_name']) && $this->data['AddModule']['submittedfile']['tmp_name'] != 'none')) {
			$this->Session->setFlash( __('Module Uploaded', true));		

			$this->destination = '../tmp/modules/';
			$this->filename = $this->data['AddModule']['submittedfile']['name'];
			$this->permissions = '0777';

				if (move_uploaded_file($this->data['AddModule']['submittedfile']['tmp_name'], $this->destination . $this->filename)) {
					chmod($this->destination . $this->filename, $this->permissions);
					App::import('Vendor', 'PclZip', array('file' => 'pclzip'.DS.'zip.php'));
					$this->archive = new PclZip('../tmp/modules/'.$this->filename);
						if ($this->archive->extract(PCLZIP_OPT_PATH,'../..') == 0)
							die(__('Error : Unable to unzip archive', true));
					@unlink($this->destination.$this->filename);
				} else {
							return false;
				}

		} else {
			$this->Session->setFlash( __('Module Not Uploaded', true));
		}		
		
		$this->redirect('/payment_methods/admin/');
	
	}
	
}
?>