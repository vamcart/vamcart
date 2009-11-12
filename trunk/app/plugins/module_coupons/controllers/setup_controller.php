<?php 
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class SetupController extends ModuleCouponsAppController {
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
		$this->ModuleBase->check_if_installed('coupons');
		
		App::import('Model', 'Module');
		$this->Module =& new Module();
		
		// Create the new module record		
		$new_module = array();
		$new_module['Module']['name'] = __('Coupons', true);
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
		App::import('Model', 'Event');
		$this->Event =& new Event();
		$event = $this->Event->findByAlias('UpdateOrderTotalsAfterSave');
		
		$new_handler = array();
		$new_handler['EventHandler']['event_id'] = $event['Event']['id'];
		$new_handler['EventHandler']['originator'] = 'CouponsModule';		
		$new_handler['EventHandler']['action'] = '/module_coupons/event/utilize_coupon/';
		$this->Event->EventHandler->save($new_handler);
		
		
		// Create the coupons table
		$install_query = array();

		$install_query[] = "
		CREATE TABLE `module_coupons` (
		`id` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`name` VARCHAR( 50 ) NOT NULL ,
		`code` VARCHAR( 50 ) NOT NULL ,
		`free_shipping` VARCHAR( 10 ) NOT NULL ,
		`percent_off_total` double NOT NULL ,
		`amount_off_total` double NOT NULL ,		
		`max_uses` INT( 10 ) NOT NULL ,
		`min_product_count` INT( 10 ) NOT NULL ,
		`max_product_count` INT( 10 ) NOT NULL ,
		`min_order_total` INT( 10 ) NOT NULL ,
		`max_order_total` INT( 10 ) NOT NULL ,		
		`start_date` DATETIME NOT NULL ,
		`expiration_date` DATETIME NOT NULL ,
		`created` DATETIME NOT NULL ,
		`modified` DATETIME NOT NULL
		) ENGINE = innodb;
		";
				
		foreach($install_query AS $query)
		{
			$this->Module->execute($query);
		}
		

		
		$this->Session->setFlash(__('Module Installed', true));
		$this->redirect('/modules/admin/');
	}
	
	function uninstall()
	{
		App::import('Model', 'Module');
		$this->Module =& new Module();
			
		// Delete the module record
		$module = $this->Module->findByAlias('coupons');
		$this->Module->del($module['Module']['id']);
		
		// Deletes the tables
		$uninstall_query = "DROP TABLE `module_coupons`;";
		$this->Module->execute($uninstall_query);
		
		// Delete any associated events.
		App::import('Model', 'Event');	
		$this->Event =& new Event();
		
		$handlers = $this->Event->EventHandler->find('all', array('conditions' => array('EventHandler.originator' => 'CouponsModule')));
		foreach($handlers AS $value)
		{
			$this->Event->EventHandler->del($value['EventHandler']['id']);
		}
		
		// Delete the core page
		App::import('Model', 'Content');
			$this->Content =& new Content();		

		$core_page = $this->Content->find(array('Content.parent_id' => '-1','alias' => 'coupon-details'));
		$this->Content->del($core_page['Content']['id'],true);
		
		$this->Session->setFlash(__('Module Uninstalled', true));
		$this->redirect('/modules/admin/');	
	}

}

?>