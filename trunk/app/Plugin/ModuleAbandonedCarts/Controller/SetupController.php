<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('ModuleAbandonedCartsAppController', 'ModuleAbandonedCarts.Controller');

class SetupController extends ModuleAbandonedCartsAppController {
	var $uses = array('Module', 'Content', 'EmailTemplate');
	var $components = array('ModuleBase');

	function upgrade ()
	{
		$this->ModuleBase->upgrade();
		$this->Session->setFlash(__('Module Upgraded'));
		$this->redirect('/modules/admin/');		
	}
		
	function install()
	{
		$this->ModuleBase->check_if_installed('abandoned_carts');
		
		// Create the new module record		
		$new_module = array();
		$new_module['Module']['name'] = __('Abandoned Carts');
		$new_module['Module']['icon'] = 'cus-cart-error';
		$new_module['Module']['alias'] = 'abandoned_carts';
		$new_module['Module']['version'] = $this->ModuleBase->get_version();
		$new_module['Module']['nav_level'] = '2';				
		$this->Module->save($new_module);
		
		// Create the coupons table
		$email_template = $this->EmailTemplate->findByAlias('abandoned-cart');
		if (empty($email_template)) {
		$install_query = array();

		$install_query[] = "
INSERT INTO email_templates (`id`, `alias`, `default`, `order`) VALUES (NULL, 'abandoned-cart', 0, 4);
";
		$install_query[] = "
INSERT INTO `email_template_descriptions` (`id`, `email_template_id`, `language_id`, `subject`, `content`) VALUES
(NULL, 4, 1, 'Abandoned cart', 'Thank you for stopping by {\$store_name} and considering us for your purchase.\r\n\r\nWe noticed that during a visit to our store you placed the following item(s) in your shopping cart, but did not complete the transaction.\r\n\r\nShopping Cart Contents:\r\n\r\n{\$products}\r\n\r\n{\$comments}\r\n\r\nWe are always interested in knowing what happened and if there was a reason that you decided not to purchase at this time. If you could be so kind as to let us know if you had any issues or concerns, we would appreciate it.  We are asking for feedback from you and others as to how we can help make your experience at {\$store_name} better.\r\n\r\nPLEASE NOTE: If you believe you completed your purchase and are wondering why it was not delivered, this email is an indication that your order was NOT completed, and that you have NOT been charged! Please return to the store in order to complete your order.\r\n\r\nOur apologies if you already completed your purchase, we try not to send these messages in those cases, but sometimes it is hard for us to tell depending on individual circumstances.\r\n\r\nAgain, thank you for your time and consideration in helping us improve {\$store_name}.'),
(NULL, 4, 2, 'Незавершённый заказ', 'Вы начинали оформлять заказ в Интернет-магазине {\$store_name}, но так и не оформили его до конца!\r\n\r\nНам было бы интересно узнать, почему Вы так и не оформили его до конца?\r\n\r\nЕсли у Вас в процессе оформления заказа возникли какие-либо проблемы, мы всегда готовы Вам помочь с оформлением заказа и с удовольствием ответим на возникшие вопросы. \r\n\r\nЗадайте нам их в ответном письме, мы поможем Вам оформить заказ.\r\n\r\nТовар, который Вы заказывали:\r\n\r\n{\$products}\r\n\r\n{\$comments}');
		";
				
		foreach($install_query AS $query)
		{
			$this->Module->query($query);
		}		
		}
		
		$this->Session->setFlash(__('Module Installed'));
		$this->redirect('/modules/admin/');
	}
	
	function uninstall()
	{
		// Delete the module record
		$module = $this->Module->findByAlias('abandoned_carts');
		$this->Module->delete($module['Module']['id']);
		
		// Deletes the tables
		$email_template = $this->EmailTemplate->findByAlias('abandoned-cart');
		if (!empty($email_template)) {
		$uninstall_query = "delete from email_templates where alias= 'abandoned-cart';";
		$this->Module->query($uninstall_query);
		}
			
		$this->Session->setFlash(__('Module Uninstalled'));
		$this->redirect('/modules/admin/');	
	}

}

?>