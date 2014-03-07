<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

class ConfigurationBaseComponent extends Object 
{

	public function beforeFilter ()
	{
	}

	public function initialize(Controller $controller) {
	}
    
	public function startup(Controller $controller) {
	}

	public function shutdown(Controller $controller) {
	}

	public function beforeRedirect(Controller $controller){
	}
    
	public function beforeRender(Controller $controller){
	}
	
	public function load_configuration ()
	{
		$config_values = Cache::read('vam_config', 'catalog');
		
		if($config_values === false)
		{
			App::import('Model', 'Configuration');
				$Configuration =& new Configuration();
	
			$configuration_values = $Configuration->find('all');

			$config_values = array_combine(Set::extract($configuration_values, '{n}.Configuration.key'),
						 		 Set::extract($configuration_values, '{n}.Configuration.value'));		

			Cache::write('vam_config', $config_values, 'catalog');
		}
		
		return $config_values;
		
	}	

	public function load_translate ()
	{
		$translate_values = Cache::read('vam_language'. '_' . $_SESSION['Customer']['language_id'], 'catalog');
		
			if($translate_values === false)
			{
		
					App::import('Model', 'DefinedLanguage');
					$DefinedLanguage =& new DefinedLanguage();
			
					$defined_language_values = $DefinedLanguage->find('all', array('conditions' => array('language_id' => $_SESSION['Customer']['language_id'])));
		
					$translate_values = array_combine(Set::extract($defined_language_values, '{n}.DefinedLanguage.key'),
								 		 Set::extract($defined_language_values, '{n}.DefinedLanguage.value'));	
								 		 
			Cache::write('vam_language'. '_' . $_SESSION['Customer']['language_id'], $translate_values, 'catalog');
			}
		
		return $translate_values;
		
	}
		
}
?>