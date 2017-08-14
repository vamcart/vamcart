<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

class SetupController extends ModuleGiftAppController {
	public $uses = array('Module', 'Content', 'Event');
	public $components = array('ModuleBase');
	
	public function upgrade ()
	{
		$this->ModuleBase->upgrade();
		$this->Session->setFlash(__('Module Upgraded'));
		$this->redirect('/modules/admin/');		
	}
	
	public function install()
	{
		$this->ModuleBase->check_if_installed('gift');
		
		// Create the new module record		
		$new_module = array();
		$new_module['Module']['name'] = __d('module_gift', 'Gift');
		$new_module['Module']['icon'] = 'cus-cart-put';
		$new_module['Module']['alias'] = 'gift';
		$new_module['Module']['version'] = $this->ModuleBase->get_version();
		$new_module['Module']['nav_level'] = '5';				
		$this->Module->save($new_module);
		
		
		// Create a new event
		$event = $this->Event->findByAlias('UpdateOrderTotalsAfterSave');
		
		$new_handler = array();
		$new_handler['EventHandler']['event_id'] = $event['Event']['id'];
		$new_handler['EventHandler']['originator'] = 'ModuleGift';		
		$new_handler['EventHandler']['action'] = '/module_gift/gift/get_gift/';
		$this->Event->EventHandler->save($new_handler);
		
		
		// Create the payment type discount table
		$install_query = array();

		$install_query[] = "
		DROP TABLE IF EXISTS module_gifts;
		CREATE TABLE `module_gifts` (
		  `id` int(10) auto_increment,
		  `content_id` int(10),
		  `order_total` double,
		  `created` datetime,
		  `modified` datetime,
		  PRIMARY KEY  (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		";
				
		foreach($install_query AS $query)
		{
			$this->Module->query($query);
		}
		

		
		$this->Session->setFlash(__('Module Installed'));
		$this->redirect('/module_gift/admin/admin_help/');
	}
	
	public function uninstall()
	{
		// Delete the module record
		$module = $this->Module->findByAlias('gift');
		$this->Module->delete($module['Module']['id']);
		
		// Deletes the tables
		$uninstall_query = "DROP TABLE `module_gifts`;";
		$this->Module->query($uninstall_query);
		
		$handlers = $this->Event->EventHandler->find('all', array('conditions' => array('EventHandler.originator' => 'ModuleGift')));
		foreach($handlers AS $value)
		{
			$this->Event->EventHandler->delete($value['EventHandler']['id']);
		}
		
		$this->Session->setFlash(__('Module Uninstalled'));
		$this->redirect('/modules/admin/');	
	}

}

?>