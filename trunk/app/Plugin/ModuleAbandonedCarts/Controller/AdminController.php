<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('ModuleAbandonedCartsAppController', 'ModuleAbandonedCarts.Controller');

class AdminController extends ModuleAbandonedCartsAppController {
	public $helpers = array('Time','Admin');
	public $uses = array('Order');
	public $paginate = array('limit' => 20, 'order' => array('Order.created' => 'desc'));
	
	public function purge_old_carts()
	{
		$old_carts = $this->Order->find('all', array('conditions' => array('Order.order_status_id' => '0')));
		foreach($old_carts AS $cart)
		{
			$this->Order->delete($cart['Order']['id'], true);
		}
		$this->Session->setFlash(__('Abandoned carts have been purged.'));
		$this->redirect('/module_abandoned_carts/admin/admin_index/');
	}

	public function admin_index ()
	{
		$this->set('current_crumb', false);
		$this->set('title_for_layout', __('Abandoned Carts'));
		$this->set('data',$this->paginate('Order',"Order.order_status_id <= '0'"));
		
	}

	public function admin_modify_selected() 	
	{
		$build_flash = "";
		foreach($this->params['data']['Order']['modify'] AS $value)
		{
			// Make sure the id is valid
			if($value > 0)
			{
				$this->Order->id = $value;
				$order = $this->Order->read();
		
				switch ($this->data['multiaction']) 
				{
					case "delete":

						// Delete the order
						$this->Order->delete($value);

						$build_flash .= __('Record deleted.', true) . ' ' . __('Order Id', true) . ' ' . $order['Order']['id'] . '<br />';									
			
					break;								
				}
			}
		}
		$this->Session->setFlash($build_flash);
		$this->redirect('/module_abandoned_carts/admin/admin_index/');
	}	

	public function admin_delete ($id)
	{
		$this->Session->setFlash(__('Record deleted.',true));

			$order = $this->Order->read(null,$id);

			// Delete the order
			$this->Order->delete($id,true);

		$this->redirect('/module_abandoned_carts/admin/admin_index/');
	}
	
	public function admin_help()
	{
		$this->set('current_crumb',__('Abandoned Carts'));
		$this->set('title_for_layout', __('Abandoned Carts'));
	}

}

?>