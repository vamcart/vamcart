<?php 
/** SMS - Selling Made Simple
 * Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
 * This project's homepage is: http://sellingmadesimple.org
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * BUT withOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
**/

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
		
		loadModel('Module');
		$this->Module =& new Module();
		
		// Create the new module record		
		$new_module = array();
		$new_module['Module']['name'] = 'Abandoned Carts';
		$new_module['Module']['alias'] = 'abandoned_carts';
		$new_module['Module']['version'] = $this->ModuleBase->get_version();
		$new_module['Module']['nav_level'] = '2';				
		$this->Module->save($new_module);
		
		
			
		$this->Session->setFlash(__('Module Installed', true));
		$this->redirect('/modules/admin/');
	}
	
	function uninstall()
	{
		loadModel('Module');
		$this->Module =& new Module();
			
		// Delete the module record
		$module = $this->Module->findByAlias('abandoned_carts');
		$this->Module->del($module['Module']['id']);
		
			
		$this->Session->setFlash(__('Module Uninstalled', true));
		$this->redirect('/modules/admin/');	
	}

}

?>