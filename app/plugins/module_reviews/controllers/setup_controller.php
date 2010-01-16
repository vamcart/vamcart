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

class SetupController extends ModuleReviewsAppController {
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

		$this->loadModels();
		
		// Create the new module record		
		$new_module = array();
		$new_module['Module']['name'] = __('Reviews', true);
		$new_module['Module']['alias'] = 'reviews';
		$new_module['Module']['version'] = $this->ModuleBase->get_version();
		$new_module['Module']['nav_level'] = '3';				
		$this->Module->save($new_module);
		
		// Create new core pages
		$default_alias = 'read-reviews';
		$default_name = 'Read Reviews';
		$default_description = '{module alias=\'reviews\' action=\'display\'}';
		
		$this->ModuleBase->create_core_page($default_alias,$default_name,$default_description);

		$default_alias = 'create-review';
		$default_name = 'Write Review';
		$default_description = '{module alias=\'reviews\' action=\'create\'}';
		
		$this->ModuleBase->create_core_page($default_alias,$default_name,$default_description);		
		
		// Create the database table
		$install_query = "
		CREATE TABLE `module_reviews` (
		`id` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`content_id` INT( 10 ) NOT NULL ,
		`name` VARCHAR( 50 ) NOT NULL ,
		`content` TEXT NOT NULL ,
		`created` DATETIME NOT NULL ,
		`modified` DATETIME NOT NULL
		) ENGINE = innodb;";
		
		$this->Module->execute($install_query);
		
		$this->Session->setFlash(__('Module Installed', true));
		$this->redirect('/modules/admin/');
	}
	
	
	function uninstall()
	{
		$this->loadModels();
		
		// Delete the module record
		$module = $this->Module->findByAlias('reviews');
		$this->Module->del($module['Module']['id']);
		
		// Delete the core page
		App::import('Model', 'Content');
			$this->Content =& new Content();		

		$core_page = $this->Content->find(array('Content.parent_id' => '-1','alias' => 'read-reviews'));
		$this->Content->del($core_page['Content']['id'],true);

		$core_page2 = $this->Content->find(array('Content.parent_id' => '-1','alias' => 'create-review'));
		$this->Content->del($core_page2['Content']['id'],true);		
		
		// Delete the module record
		$uninstall_query = "DROP TABLE `module_reviews`;";
		$this->Module->execute($uninstall_query);
		
		$this->Session->setFlash(__('Module Uninstalled', true)); 
		$this->redirect('/modules/admin/');
	}

}

?>