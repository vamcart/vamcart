<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('ModuleAbandonedCartsAppController', 'ModuleAbandonedCarts.Controller');

class AdminController extends ModuleAbandonedCartsAppController {
	var $helpers = array('Time','Admin');
	var $uses = array('Order');

	function purge_old_carts()
	{
		$old_carts = $this->Order->find('all', array('conditions' => array('Order.order_status_id' => '0')));
		foreach($old_carts AS $cart)
		{
			$this->Order->delete($cart['Order']['id'], true);
		}
		$this->Session->setFlash(__('Abandoned carts have been purged.'));
		$this->redirect('/module_abandoned_carts/admin/admin_index/');
	}

	function admin_index ()
	{
		$this->set('current_crumb',__('Abandoned Carts'));
		$this->set('title_for_layout', __('Abandoned Carts'));
		$this->set('data',$this->Order->find('all', array('conditions' => array('Order.order_status_id' => '0'))));
		
	}

	function admin_help()
	{
		$this->set('current_crumb',__('Abandoned Carts'));
		$this->set('title_for_layout', __('Abandoned Carts'));
	}

}

?>