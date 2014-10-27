<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

class SetupController extends ModulePaymentTypeDiscountAppController {
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
		$this->ModuleBase->check_if_installed('payment_type_discount');
		
		// Create the new module record		
		$new_module = array();
		$new_module['Module']['name'] = __d('module_payment_type_discount', 'Payment Type Discount');
		$new_module['Module']['icon'] = 'cus-calculator';
		$new_module['Module']['alias'] = 'payment_type_discount';
		$new_module['Module']['version'] = $this->ModuleBase->get_version();
		$new_module['Module']['nav_level'] = '5';				
		$this->Module->save($new_module);
		
		
		// Create a new event
		$event = $this->Event->findByAlias('UpdateOrderTotalsAfterSave');
		
		$new_handler = array();
		$new_handler['EventHandler']['event_id'] = $event['Event']['id'];
		$new_handler['EventHandler']['originator'] = 'PaymentTypeDiscountModule';		
		$new_handler['EventHandler']['action'] = '/module_payment_type_discount/payment_discount/apply/';
		$this->Event->EventHandler->save($new_handler);
		
		
		// Create the payment type discount table
		$install_query = array();

		$install_query[] = "
		DROP TABLE IF EXISTS module_payment_type_discounts;
		CREATE TABLE `module_payment_type_discounts` (
		  `id` int(10) auto_increment,
		  `payment_method_id` int(10),
		  `discount` double,
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
		$this->redirect('/module_payment_type_discount/admin/admin_help/');
	}
	
	public function uninstall()
	{
		// Delete the module record
		$module = $this->Module->findByAlias('payment_type_discount');
		$this->Module->delete($module['Module']['id']);
		
		// Deletes the tables
		$uninstall_query = "DROP TABLE `module_payment_type_discounts`;";
		$this->Module->query($uninstall_query);
		
		$handlers = $this->Event->EventHandler->find('all', array('conditions' => array('EventHandler.originator' => 'PaymentTypeDiscountModule')));
		foreach($handlers AS $value)
		{
			$this->Event->EventHandler->delete($value['EventHandler']['id']);
		}
		
		$this->Session->setFlash(__('Module Uninstalled'));
		$this->redirect('/modules/admin/');	
	}

}

?>