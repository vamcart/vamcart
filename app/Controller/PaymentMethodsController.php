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
		$OrderStatusDescription = new OrderStatusDescription();

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
		
		if (isset($this->data['AddModule']['submittedfile'])
			&& $this->data['AddModule']['submittedfile']['error'] == 0
			&& is_uploaded_file($this->data['AddModule']['submittedfile']['tmp_name'])) {

			@unlink(ROOT.'/app/tmp/modules/' . $this->data['AddModule']['submittedfile']['name']);

			if (!is_dir(ROOT.'/app/tmp/modules/payment_methods/')) {
				mkdir(ROOT.'/app/tmp/modules/payment_methods/');
			}
		
			move_uploaded_file($this->data['AddModule']['submittedfile']['tmp_name'], ROOT.'/app/tmp/modules/payment_methods/' . $this->data['AddModule']['submittedfile']['name']);

			$z = new ZipArchive();
			$z->open(ROOT.'/app/tmp/modules/payment_methods/' . $this->data['AddModule']['submittedfile']['name']);

			$res = $z->extractTo(ROOT.'/app/tmp/modules/payment_methods/');
			$this->copyDir(ROOT.'/app/tmp/modules/payment_methods/app/Plugin/Payment', ROOT.'/app/Plugin/Payment', true);
			$icons_dir = ROOT.'/app/tmp/modules/payment_methods/app/webroot/img/icons/payment';
			if (file_exists($icons_dir) && is_dir($icons_dir)) $this->copyDir($icons_dir, ROOT.'/app/webroot/img/icons/payment', true);
			$locale_dir = ROOT.'/app/tmp/modules/payment_methods/app/Locale';
			if (file_exists($locale_dir) && is_dir($locale_dir)) $this->copyDir($locale_dir, ROOT.'/app/Locale', true);
			
			$z->close();

			@$this->removeDir(ROOT.'/app/tmp/modules/payment_methods/');
			@unlink(ROOT.'/app/tmp/modules/payment_methods/' . $this->data['Templates']['submittedfile']['name']);
			$this->Session->setFlash( __('Module Uploaded', true));		
			$this->redirect('/payment_methods/admin/');
		} else {
			$this->Session->setFlash(__('Please, select the file for import.',true));
			$this->redirect('/payment_methods/admin_add/');
		}
				
	}

	// Helper stuff
	public function removeDir($path)
	{
		if (file_exists($path) && is_dir($path)) {
			$dirHandle = opendir($path);

			while (false !== ($file = readdir($dirHandle))) {
				if ($file!='.' && $file!='..') {
					$tmpPath=$path.'/'.$file;
					chmod($tmpPath, 0777);

					if (is_dir($tmpPath)) {
						$this->removeDir($tmpPath);
					} else {
						if (file_exists($tmpPath)) {
							@unlink($tmpPath);
						}
					}
				}
			}

			closedir($dirHandle);

			if (file_exists($path)) {
				@rmdir($path);
			}
		}
	}

	public function copyDir($source, $dest, $overwrite = false)
	{
		if (!is_dir($dest)) {
			mkdir($dest);
		}

		if ($handle = opendir($source)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != '.' && $file != '..') {
					$path = $source . '/' . $file;

					if (is_file($path)) {
						if (!is_file($dest . '/' . $file) || $overwrite) {
							$ext = pathinfo($file, PATHINFO_EXTENSION);
							//if ('php' != $ext) {
								if (!@copy($path, $dest . '/' . $file)) {
								}
							//}
						}
					} elseif (is_dir($path)) {

						if (!is_dir($dest . '/' . $file)) {
							mkdir($dest . '/' . $file);
						}

						$this->copyDir($path, $dest . '/' . $file, $overwrite);
					}
				}
			}
			closedir($handle);
		}
	}	
}
?>