<?php 
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009-2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class SetupController extends ModuleAbandonedCartsAppController {
	var $uses = null;
	var $components = array('ModuleBase');

	function upgrade ()
	{
		$this->ModuleBase->upgrade();
		$this->Session->setFlash(__('Module Upgraded', true));
		$this->redirect('/modules/admin/');		
	}
		
	function install()
	{
		$this->ModuleBase->check_if_installed('abandoned_carts');
		
		App::import('Model', 'Module');
		$this->Module =& new Module();
		
		// Create the new module record		
		$new_module = array();
		$new_module['Module']['name'] = __('Abandoned Carts', true);
		$new_module['Module']['alias'] = 'abandoned_carts';
		$new_module['Module']['version'] = $this->ModuleBase->get_version();
		$new_module['Module']['nav_level'] = '2';				
		$this->Module->save($new_module);
		
		
			
		$this->Session->setFlash(__('Module Installed', true));
		$this->redirect('/modules/admin/');
	}
	
	function uninstall()
	{
		App::import('Model', 'Module');
		$this->Module =& new Module();
			
		// Delete the module record
		$module = $this->Module->findByAlias('abandoned_carts');
		$this->Module->del($module['Module']['id']);
		
			
		$this->Session->setFlash(__('Module Uninstalled', true));
		$this->redirect('/modules/admin/');	
	}

}

?>