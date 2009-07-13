<?php
/** SMS - Selling Made Simple
 * Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
 * This project's homepage is: http://sellingmadesimple.org
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * BUT withOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
**/

class OrdersController extends AppController {
	var $name = 'Orders';
	var $helpers = array('Time');
	var $components = array('EventBase');
	var $paginate = array('limit' => 25, 'order' => array('Order.created' => 'desc'));

		
	function place_order ()
	{
		global $config;
		
		$order = $this->Order->read(null,$_SESSION['Customer']['order_id']);

		$this->EventBase->ProcessEvent('PlaceOrderBeforeSave');

		foreach($_POST AS $key => $value)
			$order['Order'][$key] = $value;
		
		// Get the default order status
		$default_status = $this->Order->OrderStatus->find(array('default' => '1'));
		$order['Order']['order_status_id'] = $default_status['OrderStatus']['id'];

		// Save the order and empty the cart
		$this->Order->save($order);
		$_SESSION['Customer']['order_id'] = null;

		$this->EventBase->ProcessEvent('PlaceOrderAfterSave');
		
		// Get the configuration values to redirect
		$this->redirect('/Page/thank-you' . $config['URL_EXTENSION']);
	}
	
	function admin_delete ($id)
	{
		$this->Order->del($id,true);
		$this->Session->setFlash(__('Record deleted.',true));
		$this->redirect('/orders/admin/');
	}

	function admin_new_comment ($user = null)
	{
		// First get the original order, and see if we're changing status
		$old_order = $this->Order->read(null,$this->data['Order']['id']);

		if($old_order['Order']['order_status_id'] != $this->data['Order']['order_status_id'])
		{
			// Do nothing for now, but we'll do something later I think....
		}
		
		$this->Order->save($this->data);
		$this->Order->OrderComment->save($this->data);
		$this->redirect('/orders/admin_view/' . $this->data['Order']['id']);
	}	
	
	function admin_view ($id)
	{

		$order = $this->Order->findAll(array('Order.id' => $id),null,null,null,null,2);
		$this->set('data',$order[0]);

		// Bind and set the order status select list
		$this->Order->OrderStatus->unbindModel(array('hasMany' => array('OrderStatusDescription')));
		$this->Order->OrderStatus->bindModel(
	        array('hasOne' => array(
				'OrderStatusDescription' => array(
                    'className' => 'OrderStatusDescription',
					'conditions'   => 'language_id = 1'
                )
            )
           	)
	    );		
		
		$status_list = $this->Order->OrderStatus->findAll(null,null,'OrderStatus.order ASC');
		$order_status_list = array();
		
		foreach($status_list AS $status)
		{
			$status_key = $status['OrderStatus']['id'];
			$order_status_list[$status_key] = $status['OrderStatusDescription']['name'];
		}
		
		$this->set('order_status_list',$order_status_list);
		$this->render('','admin');
	}
	
	function admin_modify_selected ()
	{
		$this->redirect('/orders/admin/');
	}
	
	function admin ($ajax = false)
	{
			
		$this->Order->OrderStatus->unbindModel(array('hasMany' => array('OrderStatusDescription')));
		$this->Order->OrderStatus->bindModel(
	        array('hasOne' => array(
				'OrderStatusDescription' => array(
                    'className' => 'OrderStatusDescription',
					'conditions'   => 'language_id = 1'
                )
            )
           	)
	    );			
	

		$this->Order->recursive = 2;
		$data = $this->paginate('Order',"Order.order_status_id > 0");

		$this->set('data',$data);


		if($ajax == true)
			$this->render('','ajax');
		else
			$this->render('','admin');
	}	
}
?>