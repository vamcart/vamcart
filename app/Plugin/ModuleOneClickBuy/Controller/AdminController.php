<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

class AdminController extends ModuleOneClickBuyAppController {
	
	public function admin_help()
	{
		$this->set('current_crumb', __d('module_one_click_buy', 'One Click Buy'));
		$this->set('title_for_layout', __d('module_one_click_buy', 'One Click Buy'));
	}

}

?>