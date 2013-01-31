<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

class UserTagBaseComponent extends Object 
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

	public function call_user_tag ($params)
	{
		// Load the model
		App::import('Model', 'UserTag');
			$this->UserTag =& new UserTag();
	
		$tag = $this->UserTag->findByAlias($params['alias']);
		
		eval($tag['UserTag']['content']);
	}
	
	
}
?>