<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
class SetupController extends ModuleAskAProductQuestionAppController {
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
		$new_module['Module']['name'] = __d('module_ask_a_product_question', 'Ask A Product Question');
		$new_module['Module']['icon'] = 'cus-user-comment';
		$new_module['Module']['alias'] = 'ask_a_product_question';
		$new_module['Module']['version'] = $this->ModuleBase->get_version();
		$new_module['Module']['nav_level'] =  '-1';				
		$this->Module->save($new_module);
		
		// Create new core pages
		$default_alias = 'ask_a_product_question';
		$default_name = __d('module_ask_a_product_question', 'Ask A Product Question');
		$default_description = '{module alias=\'ask_a_product_question\' controller=\'get\' action=\'ask_success\'}';
		
		$this->ModuleBase->create_core_page($default_alias,$default_name,$default_description);

		// Create the database table
		$install_query = "
		INSERT INTO `defined_languages` (`language_id`, `key`, `value`, `created`, `modified`) VALUES 
		(1, 'Ask A Product Question', 'Ask A Product Question', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
		(2, 'Ask A Product Question', 'Задать вопрос о товаре', '2013-10-10 20:08:49', '2013-10-10 20:08:49')
		";		
		$this->Module->query($install_query);

		$this->Session->setFlash(__('Module Installed'));
		$this->Session->setFlash(__('Module Installed'));
		$this->redirect('/module_ask_a_product_question/admin/admin_help');
	}
	
	
	public function uninstall()
	{
		// Delete the module record
		$module = $this->Module->findByAlias('ask_a_product_question');
		$this->Module->delete($module['Module']['id']);
		
		$core_page = $this->Content->find('first', array('conditions' => array('Content.parent_id' => '-1','alias' => 'ask_a_product_question')));
		$this->Content->delete($core_page['Content']['id'],true);

		// Delete the module record
		$uninstall_query = "DELETE FROM `defined_languages` WHERE `key` = 'Ask A Product Question'";
		$this->Module->query($uninstall_query);

		$this->Session->setFlash(__('Module Uninstalled')); 
		$this->redirect('/modules/admin/');
	}

}
