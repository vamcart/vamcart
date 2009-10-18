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

class OrdersController extends AppController {
	var $name = 'Orders';
	var $helpers = array('Time');
	var $components = array('EventBase', 'Email');
	var $paginate = array('limit' => 25, 'order' => array('Order.created' => 'desc'));

	function send()
	{

echo 'test';

	$this->set('test', 'переменная');

     $this->Email->template = 'email/default';
  
     $this->Email->to = 'vam@test.com';
     $this->Email->subject = 'Your new account';

     //$this->Email->attach($fully_qualified_filename, optionally $new_name_when_attached);
     // You can attach as many files as you like.

     $this->Email->send();
     
	}
 
		
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

		// Load the after_process function from the payment modules
		$this->requestAction('/payment/'.$order['PaymentMethod']['alias'].'/after_process/');

		// Save the order and empty the cart
		$this->Order->save($order);
		$_SESSION['Customer']['order_id'] = null;

		$this->EventBase->ProcessEvent('PlaceOrderAfterSave');
		
		// Get the configuration values to redirect
		$this->redirect('/page/thank-you' . $config['URL_EXTENSION']);
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
		$this->set('current_crumb', __('Order View', true));
		$order = $this->Order->find('all', array('conditions' => array('Order.id' => $id)));
		$this->set('data',$order[0]);

		// Bind and set the order status select list
		$this->Order->OrderStatus->unbindModel(array('hasMany' => array('OrderStatusDescription')));
		$this->Order->OrderStatus->bindModel(
	        array('hasOne' => array(
				'OrderStatusDescription' => array(
                    'className' => 'OrderStatusDescription',
					'conditions'   => 'language_id = ' . $this->Session->read('Customer.language_id')
                )
            )
           	)
	    );		
		
		$status_list = $this->Order->OrderStatus->find('all', array('order' => array('OrderStatus.order ASC')));
		$order_status_list = array();
		
		foreach($status_list AS $status)
		{
			$status_key = $status['OrderStatus']['id'];
			$order_status_list[$status_key] = $status['OrderStatusDescription']['name'];
		}
		
		$this->set('order_status_list',$order_status_list);
	}
	
	function admin_modify_selected ()
	{
		$this->redirect('/orders/admin/');
	}
	
	function admin ($ajax = false)
	{
		$this->set('current_crumb', __('Orders Listing', true));
		$this->Order->OrderStatus->unbindModel(array('hasMany' => array('OrderStatusDescription')));
		$this->Order->OrderStatus->bindModel(
	        array('hasOne' => array(
				'OrderStatusDescription' => array(
                    'className' => 'OrderStatusDescription',
					'conditions'   => 'OrderStatusDescription.language_id = ' . $this->Session->read('Customer.language_id')
                )
            )
           	)
	    );			
	

		$this->Order->recursive = 2;
		$data = $this->paginate('Order',"Order.order_status_id > 0");

		$this->set('data',$data);

	}	
}
?>