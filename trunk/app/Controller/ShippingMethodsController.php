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
		
		$this->redirect('/shipping_methods/admin/');
	
	}
	
}
?>