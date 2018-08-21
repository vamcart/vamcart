<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
class ContactUsController extends AppController {
	public $name = 'ContactUs';
	public $components = array('Email', 'ConfigurationBase');
	public $helpers = array('Time','Text');
	public $uses = array('EmailTemplate', 'AnswerTemplate', 'Contact', 'ContactAnswer');
	public $paginate = array('limit' => 20, 'order' => array('Contact.id' => 'desc'));

	public function send_email ()
	{
		// Clean up the post
		App::uses('Sanitize', 'Utility');
		$clean = new Sanitize();
		$clean->paranoid($_POST);

		foreach($_POST AS $key => $value)
			$_POST[$key] = $clean->html($value);

		$spam_flag = false;
		$antispam_error_message = '';

		if ( trim( $_POST['anti-bot-q'] ) != date('Y') ) { // answer is wrong - maybe spam
			$spam_flag = true;
			if ( empty( $_POST['anti-bot-q'] ) ) { // empty answer - maybe spam
				$antispam_error_message .= 'Error: empty answer. ['.$_POST['anti-bot-q'].']<br> ';
			} else {
				$antispam_error_message .= 'Error: answer is wrong. ['.$_POST['anti-bot-q'].']<br> ';
			}
		}
		if ( ! empty( $_POST['anti-bot-e-email-url'] ) ) { // field is not empty - maybe spam
			$spam_flag = true;
			$antispam_error_message .= 'Error: field should be empty. ['.$_POST['anti-bot-e-email-url'].']<br> ';
		}


		// Save to database
		
		App::import('Model', 'Contact');
		$contact = new Contact();
		
		$contact_data = array();

		$contact_data['name'] = $_POST['name'];
		$contact_data['email'] = $_POST['email'];
		$contact_data['message'] = $_POST['message'];

		$contact_data['customer_id'] = (($_SESSION['Customer']['customer_id'] > 0) ? $_SESSION['Customer']['customer_id'] : 0);
		$contact_data['answered'] = 0;

		$contact_data['created'] = date("Y-m-d H:i:s");
		$contact_data['modified'] = date("Y-m-d H:i:s");

		$contact_data['ref'] = $_SERVER['HTTP_REFERER'];
		$contact_data['ip'] = $_SERVER['REMOTE_ADDR'];
		$contact_data['forwarded_ip'] = $_SERVER['REMOTE_ADDR'];
		$contact_data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
		$contact_data['accept_language'] = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

		$contact->save($contact_data);

		
		$config = $this->ConfigurationBase->load_configuration();
		
		// Send to admin
		if($config['SEND_CONTACT_US_EMAIL'] != '' && $spam_flag == false)
		{
		
		// Set up mail
		$this->Email->init();
		$this->Email->From = $config['SEND_CONTACT_US_EMAIL'];
		$this->Email->FromName = $config['SEND_CONTACT_US_EMAIL'];
		$this->Email->AddReplyTo($_POST['email'], $_POST['name']);
		$this->Email->AddAddress($config['SEND_CONTACT_US_EMAIL']);
		$this->Email->Subject = $config['SITE_NAME'] . ' - ' . __('Contact Us' ,true);

		// Email Body
		$this->Email->Body = $_POST['message'];
		
		// Sending mail
		$this->Email->send();
		
		}

		$this->Session->setFlash(__('Your enquiry has been successfully sent!'), 'bootstrap_alert_success');
				
		$this->redirect('/');
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

						// Restock 
						foreach($order['OrderProduct'] as $order_data) {
			
							$filename = (isset($order['OrderProduct']['filename'])) ? $order['OrderProduct']['filename'] : false;

							if (!$filename) {

								App::import('Model', 'ContentProduct');
								$ContentProduct = new ContentProduct();
								//$product_data = $ContentProduct->findByContentId($order_data['content_id']);
                                                                $product_data = $ContentProduct->find('first',array('conditions' => array('ContentProduct.content_id' => $order_data['content_id'])
                                                                                           ,'fields' => array('ContentProduct.id','ContentProduct.ordered','ContentProduct.stock')
                                                                                           ));                                                                
								$product_data['ContentProduct']['ordered'] = $product_data['ContentProduct']['ordered'] - $order_data['quantity'];
								$product_data['ContentProduct']['stock'] = $product_data['ContentProduct']['stock'] + $order_data['quantity'];
								$ContentProduct->save($product_data);
							} else {
								App::import('Model', 'ContentDownloadable');
								$ContentDownloadable = new ContentDownloadable();
								//$product_data = $ContentDownloadable->findByContentId($order_data['content_id']);
                                                                $product_data = $ContentDownloadable->find('first',array('conditions' => array('ContentDownloadable.content_id' => $order_data['content_id'])
                                                                                           ,'fields' => array('ContentDownloadable.id','ContentDownloadable.ordered','ContentDownloadable.stock')
                                                                                           ));                                                                 
								$product_data['ContentDownloadable']['ordered'] = $product_data['ContentDownloadable']['ordered'] - $order_data['quantity'];
								$product_data['ContentDownloadable']['stock'] = $product_data['ContentDownloadable']['stock'] + $order_data['quantity'];
								$ContentDownloadable->save($product_data);
							}
			
						}
			
						// Delete the order
						$this->Order->delete($value);

						$build_flash .= __('Record deleted.', true) . ' ' . __('Order Id', true) . ' ' . $order['Order']['id'] . '<br />';									
			
					break;								
					case "change_status":
						$status_id = $this->data['status'];
						$comment = $this->data['comment'];
						$notify = $this->data['notify'];
						$this->_change_status($order, $status_id, $comment, $notify);
						$build_flash .= __('Order status changed.', true);
						$target_page = '/orders/admin/';
						break;
				}
			}
		}
		$this->Session->setFlash($build_flash);
		$this->redirect('/orders/admin/');
	}	

	public function _change_status($order, $status_id, $comment, $notify)
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
		$email_template = $this->EmailTemplate->findByAlias('new-order-status');
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
		$subject = $config['SITE_NAME'] . ' - ' . $subject;
		$this->Email->Subject = $subject;
		
		$fio = explode(" ", $order['Order']['bill_name']);		

		$assignments1 = array(
		'name' => $order['Order']['bill_name'],
		'firstname' => isset($fio[0]) ? $fio[0] : $order['Order']['bill_name'],
		'lastname' => isset($fio[1]) ? $fio[1] : $order['Order']['bill_name'],
		'order_number' => $order['Order']['id'],
		'order_status' => $current_order_status['OrderStatusDescription']['name'],
		'bill_name' => $order['Order']['bill_name'],
		'bill_line_1' => $order['Order']['bill_line_1'],
		'bill_line_2' => $order['Order']['bill_line_2'],
		'bill_city' => $order['Order']['bill_city'],
		'bill_state' => $order['BillState']['name'],
		'bill_country' => $order['BillCountry']['name'],
		'bill_zip' => $order['Order']['bill_zip'],
		'ship_name' => $order['Order']['ship_name'],
		'ship_line_1' => $order['Order']['ship_line_1'],
		'ship_line_2' => $order['Order']['ship_line_2'],
		'ship_city' => $order['Order']['ship_city'],
		'ship_state' => $order['ShipState']['name'],
		'ship_country' => $order['ShipCountry']['name'],
		'ship_zip' => $order['Order']['ship_zip']
		);

		$assignments2 = array(
		'shipping_method' => __($order['ShippingMethod']['name'], true),
		'shipping_method_description' => __($order['ShippingMethod']['description'], true),
		'payment_method' => __($order['PaymentMethod']['name'], true),
		'payment_method_description' => __($order['PaymentMethod']['description'], true),
		'date' => $order['Order']['created'],
		'phone' => $order['Order']['phone'],
		'email' => $order['Order']['email']
		);

		$assignments3 = array(
		'order_total' => $this->CurrencyBase->display_price($order['Order']['total']),
		'shipping_total' => $this->CurrencyBase->display_price($order['Order']['shipping'])
		);
		
		
		$order_comment = $this->Order->OrderComment->find('first', array('order'   => 'OrderComment.id DESC', 'conditions' => array('OrderComment.order_id' => $order['Order']['id'])));

		$comments = '';
		if (isset($order_comment['OrderComment']['comment']) && $order_comment['OrderComment']['comment'] != '')
		$comments = $order_comment['OrderComment']['comment'];

		$assignments4 = array(
		'comments' => $comments
		);

		$order_products = array();
		foreach($order['OrderProduct'] AS $key => $value) {

		$content_information = $this->ContentBase->get_content_information($order['OrderProduct'][$key]['content_id']);			
		$content_description = $this->ContentBase->get_content_description($order['OrderProduct'][$key]['content_id']);			

		App::import('Model', 'ContentImage');
		$ContentImage = new ContentImage();

		$ContentImage = $ContentImage->find('first', array('conditions' => array('ContentImage.content_id' => $order['OrderProduct'][$key]['content_id'])));

			$order_products[$key] = $value;
			$order_products[$key]['total'] = $this->CurrencyBase->display_price($order['OrderProduct'][$key]['quantity']*$order['OrderProduct'][$key]['price']);
			$order_products[$key]['content_information'] = $content_information['Content'];
			$order_products[$key]['content_description'] = $content_description['ContentDescription'];
			$order_products[$key]['content_image'] = $ContentImage['ContentImage']['image'];
		}

		$assignments5 = array(
		'order_products' => $order_products
		);
		
		$assignments = array_merge($assignments1, $assignments2, $assignments3, $assignments4, $assignments5);

		$body = $this->Smarty->fetch($email_template['EmailTemplateDescription']['content'], $assignments);
				
		// Email Body
		$this->Email->Body = $body;
		
		// Sending mail
		$this->Email->send();
		}

		// Send SMS to customer
		if($config['SMS_EMAIL'] != '' && $order['Order']['phone'] != '') {

			// Set up mail
			$this->Email->init();
			$this->Email->From = $config['NEW_ORDER_FROM_EMAIL'];
			$this->Email->FromName = __($config['NEW_ORDER_FROM_NAME'],true);
			$this->Email->AddAddress($config['SMS_EMAIL']);
			$this->Email->Subject = $order['Order']['phone'];

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

			// Restock 
			foreach($order['OrderProduct'] as $order_data) {

					$filename = (isset($order['OrderProduct']['filename'])) ? $order['OrderProduct']['filename'] : false;

					if (!$filename) {

					App::import('Model', 'ContentProduct');
					$ContentProduct = new ContentProduct();
					//$product_data = $ContentProduct->findByContentId($order_data['content_id']);
                                        $product_data = $ContentProduct->find('first',array('conditions' => array('ContentProduct.content_id' => $order_data['content_id'])
                                                                                           ,'fields' => array('ContentProduct.id','ContentProduct.ordered','ContentProduct.stock')
                                                                                           ));                                        
					$product_data['ContentProduct']['ordered'] = $product_data['ContentProduct']['ordered'] - $order_data['quantity'];
					$product_data['ContentProduct']['stock'] = $product_data['ContentProduct']['stock'] + $order_data['quantity'];
					$ContentProduct->save($product_data);
				} else {
					App::import('Model', 'ContentDownloadable');
					$ContentDownloadable = new ContentDownloadable();
					//$product_data = $ContentDownloadable->findByContentId($order_data['content_id']);
                                        $product_data = $ContentDownloadable->find('first',array('conditions' => array('ContentDownloadable.content_id' => $order_data['content_id'])
                                                                                           ,'fields' => array('ContentDownloadable.id','ContentDownloadable.ordered','ContentDownloadable.stock')
                                                                                           )); 
					$product_data['ContentDownloadable']['ordered'] = $product_data['ContentDownloadable']['ordered'] - $order_data['quantity'];
					$product_data['ContentDownloadable']['stock'] = $product_data['ContentDownloadable']['stock'] + $order_data['quantity'];
					$ContentDownloadable->save($product_data);
				}

			}

			// Delete the order
			$this->Order->delete($id,true);

		$this->redirect('/orders/admin/');
	}

	public function admin_new_comment ($user = null)
	{
		// First get the original order, and see if we're changing status
		$order = $this->Order->read(null,$this->data['Order']['id']);

		if($order['Order']['order_status_id'] != $this->data['Order']['order_status_id'])
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
		
		if ($order['Order']['email'] != '') {
		// Set up mail
		$this->Email->init();
		$this->Email->From = $config['NEW_ORDER_STATUS_FROM_EMAIL'];
		$this->Email->FromName = __($config['NEW_ORDER_STATUS_FROM_NAME'],true);
		$this->Email->AddAddress($order['Order']['email']);
		
		// Email Subject
		$subject = $email_template['EmailTemplateDescription']['subject'];
		$subject = str_replace('{$order_number}', $this->data['Order']['id'], $subject);
		$subject = $config['SITE_NAME'] . ' - ' . $subject;
		$this->Email->Subject = $subject;
		
		$fio = explode(" ", $order['Order']['bill_name']);		

		$assignments1 = array(
		'name' => $order['Order']['bill_name'],
		'firstname' => isset($fio[0]) ? $fio[0] : $order['Order']['bill_name'],
		'lastname' => isset($fio[1]) ? $fio[1] : $order['Order']['bill_name'],
		'order_number' => $order['Order']['id'],
		'order_status' => $current_order_status['OrderStatusDescription']['name'],
		'bill_name' => $order['Order']['bill_name'],
		'bill_line_1' => $order['Order']['bill_line_1'],
		'bill_line_2' => $order['Order']['bill_line_2'],
		'bill_city' => $order['Order']['bill_city'],
		'bill_state' => $order['BillState']['name'],
		'bill_country' => $order['BillCountry']['name'],
		'bill_zip' => $order['Order']['bill_zip'],
		'ship_name' => $order['Order']['ship_name'],
		'ship_line_1' => $order['Order']['ship_line_1'],
		'ship_line_2' => $order['Order']['ship_line_2'],
		'ship_city' => $order['Order']['ship_city'],
		'ship_state' => $order['ShipState']['name'],
		'ship_country' => $order['ShipCountry']['name'],
		'ship_zip' => $order['Order']['ship_zip']
		);

		$assignments2 = array(
		'shipping_method' => __($order['ShippingMethod']['name'], true),
		'shipping_method_description' => __($order['ShippingMethod']['description'], true),
		'payment_method' => __($order['PaymentMethod']['name'], true),
		'payment_method_description' => __($order['PaymentMethod']['description'], true),
		'date' => $order['Order']['created'],
		'phone' => $order['Order']['phone'],
		'email' => $order['Order']['email']
		);

		$assignments3 = array(
		'order_total' => $this->CurrencyBase->display_price($order['Order']['total'])
		);
		
		
		$order_comment = $this->Order->OrderComment->find('first', array('order'   => 'OrderComment.id DESC', 'conditions' => array('OrderComment.order_id' => $order['Order']['id'])));

		$comments = $this->data['OrderComment']['comment'];

		$assignments4 = array(
		'comments' => $comments
		);

		$order_products = array();
		foreach($order['OrderProduct'] AS $key => $value) {

		$content_information = $this->ContentBase->get_content_information($order['OrderProduct'][$key]['content_id']);			
		$content_description = $this->ContentBase->get_content_description($order['OrderProduct'][$key]['content_id']);			

		App::import('Model', 'ContentImage');
		$ContentImage = new ContentImage();

		$ContentImage = $ContentImage->find('first', array('conditions' => array('ContentImage.content_id' => $order['OrderProduct'][$key]['content_id'])));

			$order_products[$key] = $value;
			$order_products[$key]['total'] = $this->CurrencyBase->display_price($order['OrderProduct'][$key]['quantity']*$order['OrderProduct'][$key]['price']);
			$order_products[$key]['content_information'] = $content_information['Content'];
			$order_products[$key]['content_description'] = $content_description['ContentDescription'];
			$order_products[$key]['content_image'] = $ContentImage['ContentImage']['image'];
		}

		$assignments5 = array(
		'order_products' => $order_products
		);
		
		$assignments = array_merge($assignments1, $assignments2, $assignments3, $assignments4, $assignments5);

		$body = $this->Smarty->fetch($email_template['EmailTemplateDescription']['content'], $assignments);
	
		// Email Body
		$this->Email->Body = $body;
		
		// Sending mail
		$this->Email->send();
		}

		// Send SMS to customer
		if($config['SMS_EMAIL'] != '' && $order['Order']['phone'] != '') {

			// Set up mail
			$this->Email->init();
			$this->Email->From = $config['NEW_ORDER_FROM_EMAIL'];
			$this->Email->FromName = __($config['NEW_ORDER_FROM_NAME'],true);
			$this->Email->AddAddress($config['SMS_EMAIL']);
			$this->Email->Subject = $order['Order']['phone'];

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
		global $config;
		
		$this->set('current_crumb', __('Order View', true));
		$this->set('title_for_layout', __('Order View', true));
		$this->set('config', $config);
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

	public function admin ($ajax = false)
	{
		$this->set('current_crumb', __('Messages List', true));
		$this->set('title_for_layout', __('Messages List', true));
		$data = $this->paginate('Contact');
		$this->set('data',$data);
	}	
	
}
?>