<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
class ConfigurationController extends AppController {
	public $name = 'Configuration';
	public $uses = array('Configuration', 'ConfigurationGroup');
	
	public function admin_clear_cache ()
	{
		Cache::clear(false, 'catalog');
		$this->Session->setFlash(__('Cache cleared.',true));
		$this->redirect('/configuration/admin/');
	}
	
	public function admin_edit ()
	{
		$this->set('current_crumb', __('Store Configuration', true));
		$this->set('title_for_layout', __('Store Configuration', true));
		if(!empty($this->data))
		{
			if(isset($this->data['cancelbutton']))
			{
				$this->redirect('/configuration/admin/');
				die();
			}
						
			foreach($this->data['Configuration'] AS $key => $value)
			{
				$current_config = $this->Configuration->find('first', array('conditions' => array('key' => $key)));
				$current_config['Configuration']['value'] = $value;
				$this->Configuration->save($current_config);
			}

			$this->Session->setFlash(__('Record saved.', true));

			$this->redirect('/configuration/admin/');
		}
		
		// Grab all configration values then loop through and set the array key to the database key
		$configuration_values = $this->Configuration->find('all');
		$keyed_config_values = array();
		foreach($configuration_values AS $key => $value)
		{
			$array_key = $value['Configuration']['key'];
			$keyed_config_values[$array_key] = $value['Configuration'];
		}

		$this->set('configuration_values',$keyed_config_values);
	}
	
	public function admin ()
	{
		$this->set('current_crumb', __('Store Configuration', true));
		$this->set('title_for_layout', __('Store Configuration', true));
		
		$this->set('data',$this->ConfigurationGroup->find('all', array('conditions' => array('ConfigurationGroup.visible' => 1), 'order' => array('ConfigurationGroup.sort_order ASC'))));
	}	
}
?>