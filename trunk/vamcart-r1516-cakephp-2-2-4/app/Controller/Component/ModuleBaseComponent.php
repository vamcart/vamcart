<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

class ModuleBaseComponent extends Object 
{
	var $components = array('Session');
	
	function beforeFilter ()
	{
	}

    public function initialize(Controller $controller) {
	}
    
public function startup(Controller $controller) {
	}

public function shutdown(Controller $controller) {
	}
    
public function  beforeRender(Controller $controller){
	}

public function beforeRedirect(Controller $controller){
	}
	
	function get_version ()
	{
		
		$version = intval(file_get_contents(APP . 'plugins' . DS . $this->controller->params['plugin'] . DS . 'version.txt'));
		return $version;
	}
	
	function upgrade ()
	{
		$current_version = $this->get_version();

		App::import('Model', 'Module');
		$this->Module =& new Module();
		
		$module_alias = substr($this->controller->params['plugin'],7,strlen($this->controller->params['plugin']));
		$installed_module = $this->Module->find('first', array('conditions' => array('alias' => $module_alias)));
		
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
			
			$upgrade_file = APP . 'plugins' . DS . $this->controller->params['plugin'] . DS . 'upgrade_schemas' . DS .  $start_file . '.to.' . $end_file . '.php';
			
			if(file_exists($upgrade_file))
			{
				$changes = array();
				require_once($upgrade_file);

				foreach($changes AS $change)
				{
					$this->Module->execute($change);
				}
				$start_file = $end_file;
			}
		}
		
		$installed_module['Module']['version'] = $current_version;
		$this->Module->save($installed_module);
	}
	
	function create_core_page ($alias,$name,$description)
	{
		App::import('Model', 'Content');
			$this->Content =& new Content();		

		$new_page = array();
		$new_page['Content']['alias'] = $alias;
		$new_page['Content']['parent_id'] = '-1';		
		$new_page['Content']['active'] = '1';
		$new_page['Content']['content_type_id'] = '3';		

		// Get the default template
		App::import('Model', 'Template');
			$this->Template =& new Template();		
		
		$default_template = $this->Template->find('first', array('conditions' => array('default' => '1')));
		$new_page['Content']['template_id'] = $default_template['Template']['id'];
			
		$this->Content->save($new_page);
		$new_page_id = $this->Content->getLastInsertId();			
		
		// Get all of the active languages
		$languages = $this->Content->ContentDescription->Language->find('all', array('conditions' => array('active' => '1')));
		
		// Loop through the languages, saving each one.
		foreach($languages AS $language)
		{
			$new_description = array();
			$new_description['ContentDescription']['content_id'] = $new_page_id;
			$new_description['ContentDescription']['language_id'] = $language['Language']['id'];
			$new_description['ContentDescription']['name'] = $name;
			$new_description['ContentDescription']['description'] = $description;						
			
			$this->Content->ContentDescription->create();
			$this->Content->ContentDescription->save($new_description);
		}
	}
	
	function check_if_installed ($module_alias,$redirect = true)
	{
		App::import('Model', 'Module');
		$this->Module =& new Module();
		
		$check_count = $this->Module->find('count', array('conditions' => array('Module.alias' => $module_alias)));
		
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