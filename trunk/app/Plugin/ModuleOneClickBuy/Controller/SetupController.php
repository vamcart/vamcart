<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
class SetupController extends ModuleOneClickBuyAppController {
	public $uses = array('Module', 'Content');
	public $components = array('ModuleBase');
	
	public function upgrade ()
	{
		$this->ModuleBase->upgrade();
		$this->Session->setFlash(__('Module Upgraded'));
		$this->redirect('/modules/admin/');		
	}
		
	public function install()
	{

		// Create the new module record		
		$new_module = array();
		$new_module['Module']['name'] = __d('module_one_click_buy', 'One Click Buy');
		$new_module['Module']['icon'] = 'cus-cart';
		$new_module['Module']['alias'] = 'one_click_buy';
		$new_module['Module']['version'] = $this->ModuleBase->get_version();
		$new_module['Module']['nav_level'] =  '-1';				
		$this->Module->save($new_module);
		
		// Create new core pages
		$default_alias = 'one_click_buy';
		$default_name = __d('module_one_click_buy', 'One Click Buy');
		$default_description = '{module alias=\'one_click_buy\' controller=\'buy\' action=\'success\'}';
		
		$this->ModuleBase->create_core_page($default_alias,$default_name,$default_description);

		// Create the database table
		$install_query = "
		INSERT INTO `defined_languages` (`language_id`, `key`, `value`, `created`, `modified`) VALUES 
		(1, 'One Click Buy', 'One Click Buy', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
		(2, 'One Click Buy', 'Купить за 1 клик', '2013-10-10 20:08:49', '2013-10-10 20:08:49')
		";		
		$this->Module->query($install_query);

		$this->Session->setFlash(__('Module Installed'));
		$this->Session->setFlash(__('Module Installed'));
		$this->redirect('/module_one_click_buy/admin/admin_help');
	}
	
	
	public function uninstall()
	{
		// Delete the module record
		$module = $this->Module->findByAlias('one_click_buy');
		$this->Module->delete($module['Module']['id']);
		
		$core_page = $this->Content->find('first', array('conditions' => array('Content.parent_id' => '-1','alias' => 'one_click_buy')));
		$this->Content->delete($core_page['Content']['id'],true);

		// Delete the module record
		$uninstall_query = "DELETE FROM `defined_languages` WHERE `key` = 'One Click Buy'";
		$this->Module->query($uninstall_query);

		$this->Session->setFlash(__('Module Uninstalled')); 
		$this->redirect('/modules/admin/');
	}

}
