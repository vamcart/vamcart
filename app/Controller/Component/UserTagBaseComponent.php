<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

class UserTagBaseComponent extends CakeObject 
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

	public function beforeRedirect(Controller $controller, $url, $status = NULL, $exit = true){
	}

	public function call_user_tag ($params)
	{
		// Load the model
		App::import('Model', 'UserTag');
			$this->UserTag = new UserTag();
	
		$tag = $this->UserTag->findByAlias($params['alias']);
		
		eval($tag['UserTag']['content']);
	}
	
	
}
?>