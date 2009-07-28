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

class ConfigurationController extends AppController {
	var $name = 'Configuration';
	var $view = 'Theme';
	var $layout = 'admin';
	var $theme = 'vamshop';
	
	function admin_clear_cache ()
	{
		Cache::clear();
		$this->Session->setFlash(__('Cache cleared.',true));
		$this->redirect('/configuration/admin_edit/');
	}
	
	function admin_edit ()
	{
		$this->set('current_crumb', __('Store Configuration', true));
		if(!empty($this->data))
		{
			if(isset($this->params['form']['cancelbutton']))
			{
				$this->redirect('/admin/admin_top/5/');
				die();
			}
						
			foreach($this->data['Configuration'] AS $key => $value)
			{
				$current_config = $this->Configuration->find(array('key' => $key));
				$current_config['Configuration']['value'] = $value;
				$this->Configuration->save($current_config);
			}
			$this->Session->setFlash(__('Record saved.', true));
		}
		
		// Grab all configration values then loop through and set the array key to the database key
		$configuration_values = $this->Configuration->findAll();
		$keyed_config_values = array();
		foreach($configuration_values AS $key => $value)
		{
			$array_key = $value['Configuration']['key'];
			$keyed_config_values[$array_key] = $value['Configuration'];
		}

		$this->set('configuration_values',$keyed_config_values);
	}
}
?>