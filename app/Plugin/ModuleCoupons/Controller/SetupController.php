<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('ModuleCouponsAppController', 'ModuleCoupons.Controller');

class SetupController extends ModuleCouponsAppController {
	var $uses = array('Module', 'Content', 'Event');
	var $components = array('ModuleBase');
	
	function upgrade ()
	{
		$this->ModuleBase->upgrade();
		$this->Session->setFlash(__('Module Upgraded'));
		$this->redirect('/modules/admin/');		
	}
	
	function install()
	{
		$this->ModuleBase->check_if_installed('coupons');
		
		// Create the new module record		
		$new_module = array();
		$new_module['Module']['name'] = __('Coupons');
		$new_module['Module']['icon'] = 'cus-calculator';
		$new_module['Module']['alias'] = 'coupons';
		$new_module['Module']['version'] = $this->ModuleBase->get_version();
		$new_module['Module']['nav_level'] = '3';				
		$this->Module->save($new_module);
		
		
		// Create a new core page to show the details of a coupon
		$default_alias = 'coupon-details';
		$default_name = 'Voucher Details';
		$default_description = '{module alias=\'coupons\' action=\'show_info\'}';
		
		$this->ModuleBase->create_core_page($default_alias,$default_name,$default_description);

		
		// Create a new event
		$event = $this->Event->findByAlias('UpdateOrderTotalsAfterSave');
		
		$new_handler = array();
		$new_handler['EventHandler']['event_id'] = $event['Event']['id'];
		$new_handler['EventHandler']['originator'] = 'CouponsModule';		
		$new_handler['EventHandler']['action'] = '/module_coupons/event/utilize_coupon/';
		$this->Event->EventHandler->save($new_handler);
		
		
		// Create the coupons table
		$install_query = array();

		$install_query[] = "
		DROP TABLE IF EXISTS module_coupons;
		CREATE TABLE `module_coupons` (
		  `id` int(10) auto_increment,
		  `name` varchar(255) collate utf8_unicode_ci,
		  `code` varchar(255) collate utf8_unicode_ci,
		  `free_shipping` varchar(10) collate utf8_unicode_ci,
		  `percent_off_total` double,
		  `amount_off_total` double,
		  `max_uses` int(10),
		  `min_product_count` int(10),
		  `max_product_count` int(10),
		  `min_order_total` int(10),
		  `max_order_total` int(10),
		  `start_date` datetime,
		  `expiration_date` datetime,
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
		$this->redirect('/modules/admin/');
	}
	
	function uninstall()
	{
		// Delete the module record
		$module = $this->Module->findByAlias('coupons');
		$this->Module->delete($module['Module']['id']);
		
		// Deletes the tables
		$uninstall_query = "DROP TABLE `module_coupons`;";
		$this->Module->query($uninstall_query);
		
		$handlers = $this->Event->EventHandler->find('all', array('conditions' => array('EventHandler.originator' => 'CouponsModule')));
		foreach($handlers AS $value)
		{
			$this->Event->EventHandler->delete($value['EventHandler']['id']);
		}
		
		// Delete the core page
		$core_page = $this->Content->find('first', array('conditions' => array('Content.parent_id' => '-1','alias' => 'coupon-details')));
		$this->Content->delete($core_page['Content']['id'],true);
		
		$this->Session->setFlash(__('Module Uninstalled'));
		$this->redirect('/modules/admin/');	
	}

}

?>