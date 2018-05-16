<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
class SetupController extends ModuleOneClickBuyAppController {
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
		$this->ModuleBase->check_if_installed('one_click_buy');

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

		$install_query = array();

		$email_template = $this->EmailTemplate->findByAlias('one_click_buy');
		if (empty($email_template)) {

		$install_query[] = '
INSERT INTO email_templates (`id`, `alias`, `default`, `order`) VALUES (NULL, "one_click_buy", 0, 0);
';
		$install_query[] = '
INSERT INTO `email_template_descriptions` (`id`, `email_template_id`, `language_id`, `subject`, `content`) VALUES
(NULL, LAST_INSERT_ID(), 1, "One Click Buy - {$product_name}", "Hello!<br /><br />Thank you for stopping by {$store_name} and considering us for your purchase. Ordered product:<br /><br />{$product_name}<br /><br />Contact information: {$contact}"),
(NULL, LAST_INSERT_ID(), 2, "Купить за 1 клик - {$product_name}", "Здравствуйте!<br /><br />Вы оформили заказ в интернет-магазине {$store_name}!<br /><br />Товар, который Вы заказали:<br /><br />{$product_name}<br /><br />Контактные данные: {$contact}");
		';
				
		foreach($install_query AS $query)
		{
			$this->Module->query($query);
		}		
		}

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

		// Deletes the email templates records
		$email_template = $this->EmailTemplate->findByAlias('one_click_buy');
		if (!empty($email_template)) {
		$this->EmailTemplate->delete($email_template['EmailTemplate']['id']);
		}

		$this->Session->setFlash(__('Module Uninstalled')); 
		$this->redirect('/modules/admin/');
	}

}
