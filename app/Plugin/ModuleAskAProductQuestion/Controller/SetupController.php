<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
class SetupController extends ModuleAskAProductQuestionAppController {
	public $uses = array('Module', 'Content', 'EmailTemplate',);
	public $components = array('ModuleBase');
	
	public function upgrade ()
	{
		$this->ModuleBase->upgrade();
		$this->Session->setFlash(__('Module Upgraded'));
		$this->redirect('/modules/admin/');		
	}
		
	public function install()
	{
		$this->ModuleBase->check_if_installed('ask_a_product_question');

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

		$install_query = array();

		$install_query[] = "
		INSERT INTO `defined_languages` (`language_id`, `key`, `value`, `created`, `modified`) VALUES 
		(1, 'Ask A Product Question', 'Ask A Product Question', '2013-10-10 20:08:49', '2013-10-10 20:08:49'),
		(2, 'Ask A Product Question', 'Задать вопрос о товаре', '2013-10-10 20:08:49', '2013-10-10 20:08:49')
		";		

		$email_template = $this->EmailTemplate->findByAlias('ask_a_product_question');
		if (empty($email_template)) {

		$install_query[] = "
INSERT INTO email_templates (`id`, `alias`, `default`, `order`) VALUES (NULL, 'ask_a_product_question', 0, 0);
";
		$install_query[] = "
INSERT INTO `email_template_descriptions` (`id`, `email_template_id`, `language_id`, `subject`, `content`) VALUES
(NULL, LAST_INSERT_ID(), 1, 'Ask a product question - {\$product_name}', 'Hello!\r\n\r\nThank you for your question! We\'ll reply you shortly.\r\n\r\nProduct name: {\$product_name}\r\n\r\nYour question:\r\n\r\n{\$question}'),
(NULL, LAST_INSERT_ID(), 2, 'Задать вопрос о товаре - {\$product_name}', 'Здравствуйте!\r\n\r\nСпасибо за Ваш вопрос! Мы ответим Вам в самое ближайшее время.\r\n\r\nНазвание товара: {\$product_name}\r\n\r\nВаш вопрос:\r\n\r\n{\$question}');
		";
				
		foreach($install_query AS $query)
		{
			$this->Module->query($query);
		}		
		}

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

		// Delete the defined language record
		$uninstall_query = "DELETE FROM `defined_languages` WHERE `key` = 'Ask A Product Question'";
		$this->Module->query($uninstall_query);

		// Deletes the email templates records
		$email_template = $this->EmailTemplate->findByAlias('ask_a_product_question');
		if (!empty($email_template)) {
		$this->EmailTemplate->delete($email_template['EmailTemplate']['id']);
		}

		$this->Session->setFlash(__('Module Uninstalled')); 
		$this->redirect('/modules/admin/');
	}

}
