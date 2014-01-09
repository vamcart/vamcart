<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

class LocaleComponent extends Object
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
    
	public function beforeRender(Controller $controller){
	}

	public function beforeRedirect(Controller $controller){
	}
	
	public function custom_crumb ($format, $language_key, $count = 1)
	{
		$language_format = __('% ' . $format, true);
		if($language_format != '% ' . $format)
			$this->controller->set('current_crumb',sprintf($language_format, __n($language_key,$language_key, $count, true)));
	}

	public function set_crumb($action=null,$controller=null)
	{
		if($action == null)
		{
			$action = $this->controller->action;
		}
		
		if($controller == null)
		{
			$controller = $this->controller->name;
		}
		
		// Only return a crumb if the language value is assigned something.
		$language_format = __('% ' . $action, true);
		if($language_format != '% ' . $action)
			return sprintf($language_format, __n($controller,$controller, 1, true));
			
	}
	
	
}
?>