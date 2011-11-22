<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

class AdminController extends ModuleAbandonedCartsAppController {
	var $helpers = array('Time','Admin');
	var $uses = null;

	function purge_old_carts()
	{
		App::import('Model', 'Order');
		$this->Order =& new Order();
		
		$old_carts = $this->Order->find('all', array('conditions' => array('Order.order_status_id' => '0')));
		foreach($old_carts AS $cart)
		{
			$this->Order->delete($cart, true);
		}
		$this->Session->setFlash(__('Abandoned carts have been purged.', true));
		$this->redirect('/module_abandoned_carts/admin/admin_index/');
	}

	function admin_index ()
	{
		App::import('Model', 'Order');
		$this->Order =& new Order();
			
		$this->set('current_crumb',__('Abandoned Carts', true));
		$this->set('title_for_layout', __('Abandoned Carts', true));
		$this->set('data',$this->Order->find('all', array('conditions' => array('Order.order_status_id' => '0'))));
		
	}

	function admin_help()
	{
		$this->set('current_crumb',__('Abandoned Carts', true));
		$this->set('title_for_layout', __('Abandoned Carts', true));
	}

}

?>