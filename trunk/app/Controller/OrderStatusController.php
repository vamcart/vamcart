<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
class OrderStatusController extends AppController {

	public $name = 'OrderStatus';
	public $uses = array('OrderStatus','Language');

	public function admin_set_as_default ($order_status_id)
	{
		$this->setDefaultItem($order_status_id);
	}

	public function admin_move ($id, $direction)
	{
		$this->moveItem($id, $direction);		
	}
	
	public function admin_delete ($order_status_id)
	{
		// Get the order_status and make sure it's not the default
		$this->OrderStatus->id = $order_status_id;
		$order_status = $this->OrderStatus->read();

		if($order_status['OrderStatus']['default'] == 1)
		{
			$this->Session->setFlash( __('Error: Could not delete default record.', true));		
		}
		elseif($this->OrderStatus->Order->find('count', array('conditions' => array('Order.order_status_id' => $order_status_id))) > 0)
		{
			$this->Session->setFlash( __('Record deleted.', true));				
		}
		else
		{
			// Ok, delete the order_status and cascade for the description
			$status = $this->OrderStatus->read(null,$order_status_id);
			$this->OrderStatus->delete($order_status_id, true);	
			
			// Move all order status that have a higher sort order 1 slot down
			$higher_positions = $this->OrderStatus->find('all', array('conditions' => array('OrderStatus.order >' => $status['OrderStatus']['order'])));
			foreach($higher_positions AS $position)
			{
				$position['OrderStatus']['order'] -= 1; 
				$this->OrderStatus->save($position);
			}
			
			$this->Session->setFlash( __('Record deleted.', true));		
		}
		$this->redirect('/order_status/admin/');

	}

	public function admin_edit ($order_status_id = null)
	{
		$this->set('current_crumb', __('Order Status', true));
		$this->set('title_for_layout', __('Order Status', true));
		// If they pressed cancel
		if(isset($this->data['cancelbutton']))
		{
			$this->redirect('/order_status/admin/');
			die();
		}

		if(empty($this->data))
		{
			
			$this->OrderStatus->id = $order_status_id;
			$data = $this->OrderStatus->read();
		
			// Loop through the description results and assign the key as the language ID
			// But not if it's a new order status
			
			if(!empty($data))
			{
			$tmp = $data['OrderStatusDescription'];
			
			$data['OrderStatusDescription'] = null;
			foreach($tmp AS $id => $value)
			{
				$key = $value['language_id'];
				$data['OrderStatusDescription'][$key] = $value;
			}
			}
			$this->set('data', $data);
			$this->set('languages', $this->OrderStatus->OrderStatusDescription->Language->find('all', array('conditions' => array('active' => '1'), 'order' => array('Language.id ASC'))));
		}
		else
		{
			// If it's a new order status set the sort order to the highest + 1
			if($order_status_id == null)
			{
				$highest = $this->OrderStatus->find('all', array('order' => array('OrderStatus.order DESC')));
				$order = $highest['OrderStatus']['order'] + 1;
				$this->request->data['OrderStatus']['order'] = $order;
				
				// Also set the flash
				$this->Session->setFlash(__('Record created.', true));
			}
			else
			{
				$this->Session->setFlash(__('Record saved.', true));
			}
			
			// Save the order status
			$this->OrderStatus->save($this->data);		
			
			// Get the id if it's new
			if($order_status_id == null)
				$order_status_id = $this->OrderStatus->getLastInsertid();
			
			// Lets just delete all of the description associations and remake them
			$descriptions = $this->OrderStatus->OrderStatusDescription->find('all', array('conditions' => array('order_status_id' => $order_status_id)));
			foreach($descriptions AS $description)
			{
				$this->OrderStatus->OrderStatusDescription->delete($description['OrderStatusDescription']['id']);
			}

		
			foreach($this->data['OrderStatusDescription'] AS $id => $value)
			{
				$new_description = array();
				$new_description['OrderStatusDescription']['order_status_id'] = $order_status_id;
				$new_description['OrderStatusDescription']['language_id'] = $id;
				$new_description['OrderStatusDescription']['name'] = $value;				
				
				$this->OrderStatus->OrderStatusDescription->create();
				$this->OrderStatus->OrderStatusDescription->save($new_description);
			}
			
			$this->redirect('/order_status/admin');
		}		
	}

	

	public function admin_new() 
	{
		$this->redirect('/order_status/admin_edit/');
	}


	public function admin ($ajax = false)
	{
		$this->set('current_crumb', __('Order Status Listing', true));
		$this->set('title_for_layout', __('Order Status Listing', true));
		// Lets remove the hasMany association for now and associate it with our language of choice
		$this->OrderStatus->unbindModel(array('hasMany' => array('OrderStatusDescription')));
		$this->OrderStatus->bindModel(
			array('hasOne' => array(
				'OrderStatusDescription' => array(
					'className' => 'OrderStatusDescription',
					'conditions' => 'language_id = ' . $this->Session->read('Customer.language_id')
				)
			))
		);

		$this->set('order_status_data',$this->OrderStatus->find('all', array('order' => array('OrderStatus.order ASC'))));
		$this->set('order_status_count', $this->OrderStatus->find('count'));
	}
}

?>