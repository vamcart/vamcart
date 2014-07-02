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
	public $uses = array('EmailTemplate', 'AnswerTemplate', 'Order');
	public $paginate = array('limit' => 20, 'order' => array('Order.created' => 'desc'));
	public $components = array('EventBase', 'Email', 'Smarty','ConfigurationBase');
		
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
					case "change_status":
						$status_id = $this->data['status'];
						$comment = $this->data['comment'];
						$notify = $this->data['notify'];
						$this->_change_customer($order, $status_id, $comment, $notify);
						$build_flash .= __('Customer Notified', true) . '<br />';
						$target_page = '/module_abandoned_carts/admin/admin_index/';
						break;
				}
			}
		}
		$this->Session->setFlash($build_flash);
		$this->redirect('/module_abandoned_carts/admin/admin_index/');
	}	

	public function _change_customer($order, $status_id, $comment, $notify)
	{
		$order['Order']['order_status_id'] = $status_id;

		if ($comment != '') {
		$order['OrderComment']['order_id'] = $order['Order']['id'];
		$order['OrderComment']['comment'] = $comment;
		$order['OrderComment']['sent_to_customer'] = $notify;
		$order['OrderComment']['created'] = date("Y-m-d H:i:s");
		$order['OrderComment']['modified'] = date("Y-m-d H:i:s");
		}
		
		$this->Order->save($order['Order']);

		if ($comment != '') {
		$this->Order->OrderComment->saveAll($order['OrderComment']);
		}
		
		if ($notify == 1) {
		
		global $config;
		$config = $this->ConfigurationBase->load_configuration();
		
		// Retrieve email template
		$this->EmailTemplate->unbindModel(array('hasMany' => array('EmailTemplateDescription')));
		$this->EmailTemplate->bindModel(
	        array('hasOne' => array(
				'EmailTemplateDescription' => array(
                    'className' => 'EmailTemplateDescription',
					'conditions'   => 'language_id = ' . $this->Session->read('Customer.language_id')
                )
            )
           	)
	    );
		
		// Get email template
		$email_template = $this->EmailTemplate->findByAlias('abandoned-cart');
		// Get current order status
		$current_order_status = $this->Order->OrderStatus->OrderStatusDescription->find('first', array('conditions' => array('OrderStatusDescription.order_status_id =' => $status_id, 'OrderStatusDescription.language_id =' => $this->Session->read('Customer.language_id'))));
		
		if ($order['Order']['email'] != '') {
		// Set up mail
		$this->Email->init();
		$this->Email->From = $config['NEW_ORDER_STATUS_FROM_EMAIL'];
		$this->Email->FromName = __($config['NEW_ORDER_STATUS_FROM_NAME'],true);
		$this->Email->AddAddress($order['Order']['email']);
		
		// Email Subject
		$subject = $email_template['EmailTemplateDescription']['subject'];
		$subject = str_replace('{$order_number}', $order['Order']['id'], $subject);
		$subject = str_replace('{$store_name}', $config['SITE_NAME'], $subject);
		$subject = $config['SITE_NAME'] . ' - ' . $subject;
		$this->Email->Subject = $subject;
		
		$body = $email_template['EmailTemplateDescription']['content'];
		$body = str_replace('{$name}', $order['Order']['bill_name'], $body);
		$body = str_replace('{$store_name}', $config['SITE_NAME'], $body);
		$body = str_replace('{$order_number}', $order['Order']['id'], $body);
		$body = str_replace('{$order_status}', $current_order_status['OrderStatusDescription']['name'], $body);
		$body = str_replace('{$comments}', $order['OrderComment']['comment'], $body);

		$body = str_replace('{$order_total}', $order['Order']['total'], $body);

		$order_products = '';
		foreach($order['OrderProduct'] AS $product) {
			$order_products .= $product['quantity'] . ' x ' . $product['name'] . ' = ' . $product['quantity']*$product['price'] . "\n";
			if ('' != $product['filename']) {
				$order_products .= __('Download link: ', true) . FULL_BASE_URL . BASE . '/download/' . $order['Order']['id'] . '/' . $product['id'] . '/' . $product['download_key'] . "\n";
			}
		}

		$order_products .= "\n" . $order['ShippingMethod']['name'] . ': ' . $order['Order']['shipping'] . "\n";
		$order_products .= __('Order Total',true) . ': ' . $order['Order']['total'] . "\n";

		$body = str_replace('{$products}', $order_products, $body);
		
		// Email Body
		$this->Email->Body = $body;
		
		// Sending mail
		$this->Email->send();
		}
		
		}
	}

	public function admin_order_statuses()
	{
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
		
		array_unshift($order_status_list, __('Abandoned Carts'));

		$this->set('order_status_list',$order_status_list);

			// Retrieve answer template
			$this->AnswerTemplate->unbindModel(array('hasMany' => array('AnswerTemplateDescription')));
			$this->AnswerTemplate->bindModel(
				array('hasOne' => array(
					'AnswerTemplateDescription' => array(
						'className'  => 'AnswerTemplateDescription',
						'conditions' => 'language_id = ' . $this->Session->read('Customer.language_id')
					)
				))
			);

		$answer_status_list = $this->AnswerTemplate->find('all', array('order' => array('AnswerTemplate.order ASC')));
		$answer_template_list = array();

		foreach($answer_status_list AS $answer_status)
		{
			$answer_status_key = $answer_status['AnswerTemplateDescription']['content'];
			$answer_template_list[$answer_status_key] = $answer_status['AnswerTemplateDescription']['name'];
		}
		
		$this->set('answer_template_list',$answer_template_list);
		
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