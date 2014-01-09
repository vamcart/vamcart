<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

class ModuleBaseComponent extends Object 
{
	public $components = array('Session');
	
	public function beforeFilter ()
	{
	}

	public function initialize(Controller &$controller, $settings = array()) {
		$this->controller =& $controller;
    }
    
	public function startup(Controller $controller) {
	}

	public function shutdown(Controller $controller) {
	}
    
	public function beforeRender(Controller $controller){
	}

	public function beforeRedirect(Controller $controller){
	}
	
	public function get_version ()
	{
		$version = intval(file_get_contents(APP . 'Plugin' . DS . $this->controller->plugin . DS . 'version.txt'));

		return $version;
	}
	
	public function upgrade ()
	{
		$current_version = $this->get_version();

		App::import('Model', 'Module');
		$Module =& new Module();
		
		$module_alias = substr($this->controller->plugin,7,strlen($this->controller->plugin));
		$installed_module = $Module->find('first', array('conditions' => array('alias' => $module_alias)));
		
		// Make sure we're not upgrading to a lower version.
		$installed_version = $installed_module['Module']['version'];
		if($installed_version >= $current_version)
		{
			$this->Session->setFlash(__('Could not install module.',true));
			$this->controller->redirect('/modules/admin/');
			exit;
		}
		
		// Loop through the version numbers, and include the upgrade files if they exist.
		
		// Set a default starting upgrade version here because we might not always increment it.
		$start_file = $installed_version;
		
		for($version = $installed_version;$version < $current_version;++$version)
		{
			$end_file = $version + 1;
			
			$upgrade_file = APP . 'Plugin' . DS . $this->controller->plugin . DS . 'upgrade_schemas' . DS .  $start_file . '.to.' . $end_file . '.php';
			
			if(file_exists($upgrade_file))
			{
				$changes = array();
				require_once($upgrade_file);

				foreach($changes AS $change)
				{
					$Module->execute($change);
				}
				$start_file = $end_file;
			}
		}
		
		$installed_module['Module']['version'] = $current_version;
		$Module->save($installed_module);
	}
	
	public function create_core_page ($alias,$name,$description)
	{
		App::import('Model', 'Content');
			$Content =& new Content();		

		$new_page = array();
		$new_page['Content']['alias'] = $alias;
		$new_page['Content']['parent_id'] = '-1';		
		$new_page['Content']['active'] = '1';
		$new_page['Content']['content_type_id'] = '3';		

		// Get the default template
		App::import('Model', 'Template');
			$Template =& new Template();		
		
		$default_template = $Template->find('first', array('conditions' => array('default' => '1')));
		$new_page['Content']['template_id'] = $default_template['Template']['id'];
			
		$Content->save($new_page);
		$new_page_id = $Content->getLastInsertId();			
		
		// Get all of the active languages
		$languages = $Content->ContentDescription->Language->find('all', array('conditions' => array('active' => '1')));
		
		// Loop through the languages, saving each one.
		foreach($languages AS $language)
		{
			$new_description = array();
			$new_description['ContentDescription']['content_id'] = $new_page_id;
			$new_description['ContentDescription']['language_id'] = $language['Language']['id'];
			$new_description['ContentDescription']['name'] = $name;
			$new_description['ContentDescription']['description'] = $description;						
			
			$Content->ContentDescription->create();
			$Content->ContentDescription->save($new_description);
		}
	}
	
	public function check_if_installed ($module_alias,$redirect = true)
	{
		App::import('Model', 'Module');
		$Module =& new Module();
		
		$check_count = $Module->find('count', array('conditions' => array('Module.alias' => $module_alias)));
		
		if(($redirect == true)&&($check_count == 1))
		{
		
			$this->Session->setFlash($module_alias . ' ' . __('module exists.',true));
			$this->controller->redirect('/modules/admin');
			die();
		}
		else
		{
			return $check_count;
		}
	
	}
}
?>