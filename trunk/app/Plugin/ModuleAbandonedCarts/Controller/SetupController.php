<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('ModuleAbandonedCartsAppController', 'ModuleAbandonedCarts.Controller');

class SetupController extends ModuleAbandonedCartsAppController {
	var $uses = array('Module', 'Content');
	var $components = array('ModuleBase');

	function upgrade ()
	{
		$this->ModuleBase->upgrade();
		$this->Session->setFlash(__('Module Upgraded'));
		$this->redirect('/modules/admin/');		
	}
		
	function install()
	{
		$this->ModuleBase->check_if_installed('abandoned_carts');
		
		// Create the new module record		
		$new_module = array();
		$new_module['Module']['name'] = __('Abandoned Carts');
		$new_module['Module']['icon'] = 'cus-cart-error';
		$new_module['Module']['alias'] = 'abandoned_carts';
		$new_module['Module']['version'] = $this->ModuleBase->get_version();
		$new_module['Module']['nav_level'] = '2';				
		$this->Module->save($new_module);
		
		$this->Session->setFlash(__('Module Installed'));
		$this->redirect('/modules/admin/');
	}
	
	function uninstall()
	{
		// Delete the module record
		$module = $this->Module->findByAlias('abandoned_carts');
		$this->Module->delete($module['Module']['id']);
		
			
		$this->Session->setFlash(__('Module Uninstalled'));
		$this->redirect('/modules/admin/');	
	}

}

?>