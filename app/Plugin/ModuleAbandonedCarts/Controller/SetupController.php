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

		$install_query[] = '
INSERT INTO email_templates (`id`, `alias`, `default`, `order`) VALUES (NULL, "abandoned-cart", 0, 4);
';
		$install_query[] = '
INSERT INTO `email_template_descriptions` (`id`, `email_template_id`, `language_id`, `subject`, `content`) VALUES
(NULL, LAST_INSERT_ID(), 1, "Abandoned cart", "Thank you for stopping by {$store_name} and considering us for your purchase.<br /><br />We noticed that during a visit to our store you placed the following item(s) in your shopping cart, but did not complete the transaction.<br /><br />Shopping Cart Contents:<br />{foreach item=products from=$order_products}<br />{$products.quantity} x {$products.name} = {$products.total}<br />{if $products.filename != ""}{lang}Download link:{/lang} {$smarty.const.FULL_BASE_URL}{$smarty.const.BASE}/download/{$order_number}/{$products.id}/{$products.download_key}{/if}<br />{/foreach}<br /><br />{lang}{$shipping_method}{/lang}:  {$shipping_total}<br />{lang}Order Total:{/lang} {$order_total}<br /><br />{$comments}<br /><br />We are always interested in knowing what happened and if there was a reason that you decided not to purchase at this time. If you could be so kind as to let us know if you had any issues or concerns, we would appreciate it.  We are asking for feedback from you and others as to how we can help make your experience at {$store_name} better.<br /><br />PLEASE NOTE: If you believe you completed your purchase and are wondering why it was not delivered, this email is an indication that your order was NOT completed, and that you have NOT been charged! Please return to the store in order to complete your order.<br /><br />Our apologies if you already completed your purchase, we try not to send these messages in those cases, but sometimes it is hard for us to tell depending on individual circumstances.<br /><br />Again, thank you for your time and consideration in helping us improve {$store_name}."),
(NULL, LAST_INSERT_ID(), 2, "Незавершённый заказ", "Здравствуйте!<br /><br />Вы начинали оформлять заказ в интернет-магазине {$store_name}, но так и не оформили его до конца!<br /><br />Нам было бы интересно узнать, почему Вы так и не оформили его до конца?<br /><br />Если у Вас в процессе оформления заказа возникли какие-либо проблемы, мы всегда готовы Вам помочь с оформлением заказа и с удовольствием ответим на возникшие вопросы. <br /><br />Задайте нам их в ответном письме, мы поможем Вам оформить заказ.<br /><br />Товар, который Вы заказывали:<br />{foreach item=products from=$order_products}<br />{$products.quantity} x {$products.name} = {$products.total}<br />{if $products.filename != ""}{lang}Download link:{/lang} {$smarty.const.FULL_BASE_URL}{$smarty.const.BASE}/download/{$order_number}/{$products.id}/{$products.download_key}{/if}<br />{/foreach}<br /><br />{lang}{$shipping_method}{/lang}: {$shipping_total}<br />{lang}Order Total:{/lang} {$order_total}<br /><br />{$comments}");
		';
				
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
		
		// Deletes the email templates records
		$email_template = $this->EmailTemplate->findByAlias('abandoned-cart');
		if (!empty($email_template)) {
		$this->EmailTemplate->delete($email_template['EmailTemplate']['id']);
		}
			
		$this->Session->setFlash(__('Module Uninstalled'));
		$this->redirect('/modules/admin/');	
	}

}

?>