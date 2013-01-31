<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
class OrdersController extends AppController {
	public $name = 'Orders';
	public $helpers = array('Time');
	public $uses = array('EmailTemplate', 'Order');
	public $components = array('EventBase', 'Email', 'Smarty','ConfigurationBase');
	public $paginate = array('limit' => 25, 'order' => array('Order.created' => 'desc'));

	public function confirmation ()
	{
		
		global $config;
		global $order;

		if (isset($_SESSION['Customer']['order_id'])) {
					
		foreach($_POST AS $key => $value)
			$order['Order'][$key] = $value;
		
		$this->Order->save($order);
		
		$this->redirect('/page/confirmation' . $config['URL_EXTENSION']);				

		}
				
	}
		
	public function place_order ()
	{
		global $config;
		
		if (isset($_SESSION['Customer']['order_id'])) {
			$order = $this->Order->read(null,$_SESSION['Customer']['order_id']);
			$this->EventBase->ProcessEvent('PlaceOrderBeforeSave');

			foreach($_POST AS $key => $value) {
				$order['Order'][$key] = $value;
			}

			// Update products ordered 
			foreach($order['OrderProduct'] as $order_data) {

				if ('' == $order['OrderProduct']['filename']) {
					App::import('Model', 'ContentProduct');
					$ContentProduct =& new ContentProduct();
					$product_data = $ContentProduct->findByContentId($order_data['content_id']);
					$product_data['ContentProduct']['ordered'] = $product_data['ContentProduct']['ordered'] + $order_data['quantity'];
					$ContentProduct->save($product_data);
				} else {
					App::import('Model', 'ContentDownloadable');
					$ContentDownloadable =& new ContentDownloadable();
					$product_data = $ContentDownloadable->findByContentId($order_data['content_id']);
					$product_data['ContentDownloadable']['ordered'] = $product_data['ContentDownloadable']['ordered'] + $order_data['quantity'];
					$ContentDownloadable->save($product_data);
				}

			}

			// Get the default order status
			if ($order['Order']['order_status_id'] == 0) {
				$default_status = $this->Order->OrderStatus->find('first', array('conditions' => array('default' => '1')));
				$order['Order']['order_status_id'] = $default_status['OrderStatus']['id'];
			}

			// Save the order
			$this->Order->save($order);

			// Load the after_process public function from the payment modules
			$this->requestAction('/payment/'.$order['PaymentMethod']['alias'].'/after_process/');

			// Empty the cart
			$_SESSION['Customer']['order_id'] = null;

			$this->EventBase->ProcessEvent('PlaceOrderAfterSave');

			// Sending email
			
			// Retrieve email template
			$this->EmailTemplate->unbindModel(array('hasMany' => array('EmailTemplateDescription')));
			$this->EmailTemplate->bindModel(
				array('hasOne' => array(
					'EmailTemplateDescription' => array(
						'className'  => 'EmailTemplateDescription',
						'conditions' => 'language_id = ' . $this->Session->read('Customer.language_id')
					)
				))
			);

			// Get email template
			$email_template = $this->EmailTemplate->findByAlias('new-order');
			// Get current order status
			$current_order_status = $this->Order->OrderStatus->OrderStatusDescription->find('first', array('conditions' => array('OrderStatusDescription.order_status_id =' => $order['Order']['order_status_id'], 'OrderStatusDescription.language_id =' => $this->Session->read('Customer.language_id'))));

			// Email Subject
			$subject = $email_template['EmailTemplateDescription']['subject'];
			$subject = str_replace('{$order_number}',$order['Order']['id'], $subject);
			$subject = $config['SITE_NAME'] . ' - ' . $subject;

			$body = $email_template['EmailTemplateDescription']['content'];
			$body = str_replace('{$name}', $order['Order']['bill_name'], $body);
			$body = str_replace('{$order_number}', $order['Order']['id'], $body);
			$body = str_replace('{$order_status}', $current_order_status['OrderStatusDescription']['name'], $body);

			$order = $this->Order->find('all', array('conditions' => array('Order.id' => $order['Order']['id'])));
			$order = $order[0];

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

			if ($order['Order']['email'] != '') {
				// Set up mail
				$this->Email->init();
				$this->Email->From = $config['NEW_ORDER_FROM_EMAIL'];
				$this->Email->FromName = __($config['NEW_ORDER_FROM_NAME'],true);
				// Send to customer
				$this->Email->AddAddress($order['Order']['email']);
				$this->Email->Subject = $subject;

				// Email Body
				$this->Email->Body = $body;

				// Sending mail
				$this->Email->send();
			}
		
			// Send to admin
			if($config['SEND_EXTRA_EMAIL'] != '') {

				// Set up mail
				$this->Email->init();
				$this->Email->From = $config['NEW_ORDER_FROM_EMAIL'];
				$this->Email->FromName = __($config['NEW_ORDER_FROM_NAME'],true);
				$this->Email->AddAddress($config['SEND_EXTRA_EMAIL']);
				$this->Email->Subject = $subject;

				// Email Body
				$this->Email->Body = $body;
		
				// Sending mail
				$this->Email->send();

			}

		}

		// Get the configuration values to redirect
		$this->redirect('/page/success' . $config['URL_EXTENSION']);
	}

	public function admin_delete ($id)
	{
		$this->Order->delete($id,true);
		$this->Session->setFlash(__('Record deleted.',true));
		$this->redirect('/orders/admin/');
	}

	public function admin_new_comment ($user = null)
	{
		// First get the original order, and see if we're changing status
		$old_order = $this->Order->read(null,$this->data['Order']['id']);

		if($old_order['Order']['order_status_id'] != $this->data['Order']['order_status_id'])
		{
			// Do nothing for now, but we'll do something later I think....
		}
		
		$this->Order->save($this->data);
		$this->Order->OrderComment->save($this->data);
		
		if ($this->data['OrderComment']['sent_to_customer'] == 1) {
		
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
		$email_template = $this->EmailTemplate->findByAlias('new-order-status');
		// Get current order status
		$current_order_status = $this->Order->OrderStatus->OrderStatusDescription->find('first', array('conditions' => array('OrderStatusDescription.order_status_id =' => $this->data['Order']['order_status_id'], 'OrderStatusDescription.language_id =' => $this->Session->read('Customer.language_id'))));
		
		if ($old_order['Order']['email'] != '') {
		// Set up mail
		$this->Email->init();
		$this->Email->From = $config['NEW_ORDER_STATUS_FROM_EMAIL'];
		$this->Email->FromName = __($config['NEW_ORDER_STATUS_FROM_NAME'],true);
		$this->Email->AddAddress($old_order['Order']['email']);
		
		// Email Subject
		$subject = $email_template['EmailTemplateDescription']['subject'];
		$subject = str_replace('{$order_number}', $this->data['Order']['id'], $subject);
		$subject = $config['SITE_NAME'] . ' - ' . $subject;
		$this->Email->Subject = $subject;
		
		$body = $email_template['EmailTemplateDescription']['content'];
		$body = str_replace('{$name}', $old_order['Order']['bill_name'], $body);
		$body = str_replace('{$order_number}', $this->data['Order']['id'], $body);
		$body = str_replace('{$order_status}', $current_order_status['OrderStatusDescription']['name'], $body);
		$body = str_replace('{$comments}', $this->data['OrderComment']['comment'], $body);
		
		// Email Body
		$this->Email->Body = $body;
		
		// Sending mail
		$this->Email->send();
		}
		
		}
		
		$this->redirect('/orders/admin_view/' . $this->data['Order']['id']);
	}	
	
	public function admin_view ($id)
	{
		$this->set('current_crumb', __('Order View', true));
		$this->set('title_for_layout', __('Order View', true));
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
	
	public function admin_modify_selected ()
	{
		$this->redirect('/orders/admin/');
	}
	
	public function admin ($ajax = false)
	{
		$this->set('current_crumb', __('Orders Listing', true));
		$this->set('title_for_layout', __('Orders Listing', true));
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

	public function admin_search() {
		if (!isset($_SESSION['Search'])) {
			$_SESSION['Search'] = array();
		}

		if (isset($this->data['Search']['term'])) {
			$_SESSION['Search']['term'] = $this->data['Search']['term'];
		}
		$this->set('current_crumb', __('Search Result', true));
		$this->set('title_for_layout', __('Search Result', true));
		$this->Order->OrderStatus->unbindModel(array('hasMany' => array('OrderStatusDescription')));
		$this->Order->OrderStatus->bindModel(array(
			'hasOne' => array(
				'OrderStatusDescription' => array(
					'className'  => 'OrderStatusDescription',
					'conditions' => 'OrderStatusDescription.language_id = ' . $this->Session->read('Customer.language_id')
				)
			)
		));

		$this->Order->recursive = 2;

		if (isset($_SESSION['Search']['term']) and ($this->RequestHandler->isPost() or isset($this->params['named']['page']) )) {
			$term = $_SESSION['Search']['term'];
		} else {
			$term ='~';
			unset($_SESSION['Search']['term']);
		}

		$data = $this->paginate('Order', "Order.order_status_id > 0 and (Order.id='" . (int)$term . "' or Order.bill_name LIKE '%" . $term . "%' or Order.email LIKE '%" . $term . "%' or Order.phone LIKE '%" . $term . "%')");
		$this->set('data',$data);
	}
}
?>