<?php 
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.com
   http://vamshop.ru
   Copyright 2009 VaM Shop
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class StorePickupController extends PaymentAppController {
	var $uses = array('PaymentMethod');

	function settings ()
	{
	}

	function install()
	{

		$new_module = array();
		$new_module['PaymentMethod']['active'] = '1';
		$new_module['PaymentMethod']['name'] = 'Store Pickup';
		$new_module['PaymentMethod']['alias'] = 'store_pickup';
		$this->PaymentMethod->save($new_module);

		$this->Session->setFlash(__('Module Installed', true));
		$this->redirect('/payment_methods/admin/');
	}

	function uninstall()
	{

		$module_id = $this->PaymentMethod->findByAlias('store_pickup');

		$this->PaymentMethod->del($module_id['PaymentMethod']['id'], true);
			
		$this->Session->setFlash(__('Module Uninstalled', true));
		$this->redirect('/payment_methods/admin/');
	}

	function before_process () 
	{
		$content = '
		<form action="' . BASE . '/orders/place_order/" method="post">
		<button id="vam_checkout_button" type="submit">{lang}Confirm Order{/lang}</button>
		</form>';
		return $content;	
	}
	
}

?>