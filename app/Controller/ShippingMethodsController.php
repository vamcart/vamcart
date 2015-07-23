<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Folder', 'Utility');

class ShippingMethodsController extends AppController {
	public $name = 'ShippingMethods';

	public function admin_change_active_status ($id) 
	{
		$this->changeActiveStatus($id);	
	}
	
	public function admin_set_as_default ($id)
	{
		$this->setDefaultItem($id);
	}
	
	public function admin_edit ($shipping_method_id)
	{
		$this->set('current_crumb', __('Edit Shipping Method', true));
		$this->set('title_for_layout', __('Edit Shipping Method', true));
		if(isset($this->data['cancelbutton']))
		{
			$this->redirect('/shipping_methods/admin/');
			die();
		}

		if(empty($this->data))
		{
			$this->set('data', $this->ShippingMethod->find('first', array('conditions' => array('id' =>$shipping_method_id,null,null,2))));
		}
		else
		{
			$this->ShippingMethod->save($this->data);
			
			if((isset($this->data['key_values'])) && (!empty($this->data['key_values'])))
			{
			    foreach($this->data['key_values'] AS $key => $value)
			    {
                    $attribute = $this->ShippingMethod->ShippingMethodValue->find('first', array(
                        'conditions' => array('ShippingMethodValue.shipping_method_id' => $shipping_method_id,
                                              'key' => $key
                        )));

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
	
	public function admin ()
	{
		$this->set('current_crumb', __('Modules Listing', true));
		$this->set('title_for_layout', __('Modules Listing', true));
		$path = APP . 'Plugin' . DS . 'Shipping' . DS . 'View';
		$module_path = new Folder($path);
		$dirs = $module_path->read();
		$modules = array();
		foreach($dirs[0] AS $dir)
		{
				$module = array();
				$module['code'] = $dir; 
				$db_module = $this->ShippingMethod->findByCode($module['code']);
				$module['id'] = (isset($db_module['ShippingMethod']['id'])?$db_module['ShippingMethod']['id']:null);
				$module['name'] = (isset($db_module['ShippingMethod']['name'])?$db_module['ShippingMethod']['name']:Inflector::humanize($module['code']));
				$module['default'] = (isset($db_module['ShippingMethod']['default'])?$db_module['ShippingMethod']['default']:null);
				$module['installed'] = $this->ShippingMethod->find('count', array('conditions' => array('code' => $module['code'], 'active' => '1')));
				$module['order'] = (isset($db_module['ShippingMethod']['order'])?$db_module['ShippingMethod']['order']:null);
				
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
			$this->redirect('/shipping_methods/admin/');
			die();
		}
		
		if (isset($this->data['AddModule']['submittedfile'])
			&& $this->data['AddModule']['submittedfile']['error'] == 0
			&& is_uploaded_file($this->data['AddModule']['submittedfile']['tmp_name'])) {

			@unlink(ROOT.'/app/tmp/modules/' . $this->data['AddModule']['submittedfile']['name']);

			if (!is_dir(ROOT.'/app/tmp/modules/shipping_methods/')) {
				mkdir(ROOT.'/app/tmp/modules/shipping_methods/');
			}
		
			move_uploaded_file($this->data['AddModule']['submittedfile']['tmp_name'], ROOT.'/app/tmp/modules/shipping_methods/' . $this->data['AddModule']['submittedfile']['name']);

			$z = new ZipArchive();
			$z->open(ROOT.'/app/tmp/modules/shipping_methods/' . $this->data['AddModule']['submittedfile']['name']);

			$res = $z->extractTo(ROOT.'/app/tmp/modules/shipping_methods/');
			$this->copyDir(ROOT.'/app/tmp/modules/shipping_methods/app/Plugin/Shipping', ROOT.'/app/Plugin/Shipping', true);
			$icons_dir = ROOT.'/app/tmp/modules/shipping_methods/app/webroot/img/icons/shipping';
			if (file_exists($icons_dir) && is_dir($icons_dir)) $this->copyDir($icons_dir, ROOT.'/app/webroot/img/icons/shipping', true);
			$locale_dir = ROOT.'/app/tmp/modules/shipping_methods/app/Locale';
			if (file_exists($locale_dir) && is_dir($locale_dir)) $this->copyDir($locale_dir, ROOT.'/app/Locale', true);
			
			$z->close();

			@$this->removeDir(ROOT.'/app/tmp/modules/shipping_methods/');
			@unlink(ROOT.'/app/tmp/modules/shipping_methods/' . $this->data['Templates']['submittedfile']['name']);
			$this->Session->setFlash( __('Module Uploaded', true));		
			$this->redirect('/shipping_methods/admin/');
		} else {
			$this->Session->setFlash(__('Please, select the file for import.',true));
			$this->redirect('/shipping_methods/admin_add/');
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
							//if ('php' == $ext) {
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