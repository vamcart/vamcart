<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
   
class CustomersController extends AppController {
	public $name = 'Customers';
	public $helpers = array('Time');
	public $components = array('EventBase', 'Email', 'Smarty','ConfigurationBase', 'CurrencyBase', 'ContentBase');
	public $paginate = array('limit' => 20, 'order' => array('Customer.id' => 'desc'));

	public function admin_delete ($customer_id)
	{
		// Get the customer and make sure it's not the default
		$this->Customer->id = $customer_id;
		$customer = $this->Customer->read();
		
		if($customer['Customer']['default'] == 1)
		{
			$this->Session->setFlash( __('Error: Could not delete default record.', true));		
		}
		else
		{
			// Ok, delete the customer
			$this->Customer->delete($customer_id);	
			$this->Session->setFlash( __('Record deleted.', true));		
		}
		$this->redirect('/customers/admin/');
	}
	
	
	public function admin_edit ($customer_id = null)
	{
		$this->set('current_crumb', __('Customer Details', true));
		$this->set('title_for_layout', __('Customer Details', true));
		// If they pressed cancel
		if(isset($this->data['cancelbutton']))
		{
			$this->redirect('/customers/admin/');
			die();
		}
		
		if(empty($this->data))
		{                        
			$this->request->data = $this->Customer->read(null,$customer_id);
                        
                        $this->loadModel('GroupsCustomer');                    
                        $this->GroupsCustomer->unbindModel(array('hasMany' => array('GroupsCustomerDescription')));
                        $this->GroupsCustomer->bindModel(array('hasOne' => array('GroupsCustomerDescription' => array(
						'className' => 'GroupsCustomerDescription',
						'conditions' => 'language_id = ' . $this->Session->read('Customer.language_id')
					)))); 
                        $groups = $this->GroupsCustomer->find('all',array('fields' => array('GroupsCustomer.id', 'GroupsCustomerDescription.name')));
                        $groups = Set::combine($groups,'{n}.GroupsCustomer.id','{n}.GroupsCustomerDescription.name');
                        $groups[0] = __('no');
                        asort($groups);
                        $this->set('groups',$groups);

			// Get Default Country
			App::import('Model', 'Country');
			$country = new Country();
			$default_country = $country->find('first', array('conditions' => array('Country.default' => 1),'limit' => 1));			

			// Get Default State
			App::import('Model', 'CountryZone');
			$zone = new CountryZone();
			$default_state = $zone->find('first', array('conditions' => array('CountryZone.default' => 1),'limit' => 1));			

			$this->set('default_country',$default_country['Country']['id']);
			$this->set('default_state',$default_state['CountryZone']['id']);

			$this->set('data',$this->request->data);
		}
		else
		{
			
			// Check if we set a new password, and if so make sure they match.
			if($this->data['Customer']['password'] != "")
			{
				if($this->data['Customer']['password'] != $this->data['Customer']['retype'])
				{
					$this->Session->setFlash(__('Sorry, passwords did not match.', true));
					$this->redirect('/customers/admin/');
					die();
				}

					$this->request->data['Customer']['password'] = Security::hash($this->data['Customer']['password'], 'sha1', true);

			} else {

				$current_customer_data = $this->Customer->find('first', array('conditions' => array('customer_id' => $this->data['Customer']['id'])));
				$this->request->data['Customer']['password'] = $current_customer_data['Customer']['password'];
				
			}

      $user = $this->Customer->save($this->request->data);

			$address = array();
			$address['AddressBook'] = $this->data['AddressBook'];
			$address['AddressBook']['customer_id'] = $this->Customer->id;

			$check = $this->Customer->AddressBook->find('first', array('conditions' => array('customer_id' => $this->Customer->id)));
			if(!empty($check))
				$address['AddressBook']['id']= $check['AddressBook']['id'];

			$this->Customer->AddressBook->save($address);
			
			$this->Session->setFlash(__('Record saved.', true));
			$this->redirect('/customers/admin');
		}		
	}

	public function admin_new() 
	{
		$this->redirect('/customers/admin_edit/');
	}

	public function admin_modify_selected() 	
	{
		$build_flash = "";
		foreach($this->params['data']['Customer']['modify'] AS $value)
		{
			// Make sure the id is valid
			if($value > 0)
			{
				$this->Customer->id = $value;
				$customer = $this->Customer->read();
				$target_page = '/customers/admin/';
		
				switch ($this->data['multiaction']) 
				{
					case "delete":
						   $this->Customer->delete($value);
							$build_flash .= __('Record deleted.', true) . ' (' . $customer['Customer']['name'] . ')<br />';									
					break;
					case "send_message":
						$customer_id = $value;
						$name = $customer['Customer']['name'];
						$email = $customer['Customer']['email'];
						$message = $this->data['message'];
						$this->_send_message($customer_id, $name, $email, $message);
						$build_flash .= __('Message sent successfully.', true);
						$target_page = '/customers/admin/';
					break;
					//case "customer_orders":
						//$build_flash .= __('Customer Orders List.', true);
						//$target_page = '/orders/admin/?email=' . $customer['Customer']['email'];
						//break;
				}
			}
		}
		$this->Session->setFlash($build_flash);
		$this->redirect($target_page);
	}	

	public function _send_message($customer_id, $name, $email, $message)
	{
		App::import('Model', 'CustomerMessage');
		$CustomerMessage = new CustomerMessage();
		
		$message_data = array();

		if ($message != '') {
		$message_data['CustomerMessage']['customer_id'] = $customer_id;
		$message_data['CustomerMessage']['message'] = $message;
		$message_data['CustomerMessage']['sent_to_customer'] = 1;
		}
		
		$CustomerMessage->save($message_data);

		global $config;
		$config = $this->ConfigurationBase->load_configuration();
					
		// Set up mail
		$this->Email->init();
		$this->Email->From = $config['SEND_CONTACT_US_EMAIL'];
		$this->Email->FromName = $config['SEND_CONTACT_US_EMAIL'];
		$this->Email->AddAddress($email, $name);
		$this->Email->Subject = $config['SITE_NAME'] . ' - ' . __('Message' ,true);

		// Email Body
		$this->Email->Body = str_replace("\r\n","<br />",$message);
		
		// Sending mail
		$this->Email->send();

	}

	public function admin_send_message()
	{
			App::import('Model', 'AnswerTemplate');
			$AnswerTemplate = new AnswerTemplate();
		
			// Retrieve answer template
			$AnswerTemplate->unbindModel(array('hasMany' => array('AnswerTemplateDescription')));
			$AnswerTemplate->bindModel(
				array('hasOne' => array(
					'AnswerTemplateDescription' => array(
						'className'  => 'AnswerTemplateDescription',
						'conditions' => 'language_id = ' . $this->Session->read('Customer.language_id')
					)
				))
			);

		$answer_status_list = $AnswerTemplate->find('all', array('order' => array('AnswerTemplate.order ASC')));
		$answer_template_list = array();

		foreach($answer_status_list AS $answer_status)
		{
			$answer_status_key = $answer_status['AnswerTemplateDescription']['content'];
			$answer_template_list[$answer_status_key] = $answer_status['AnswerTemplateDescription']['name'];
		}
		
		$this->set('answer_template_list',$answer_template_list);
		
	}

	public function admin_delete_message ($message_id,$customer_id)
	{
		App::import('Model', 'CustomerMessage');
		$CustomerMessage = new CustomerMessage();

		$CustomerMessage->delete($message_id);	
		$this->Session->setFlash( __('Record deleted.', true));		

		$this->redirect('/customers/admin_view/'.$customer_id);
	}	

	public function admin_view ($id)
	{
		global $config;
		
		App::import('Model', 'CustomerMessage');
		$CustomerMessage = new CustomerMessage();

		$this->set('current_crumb', __('Messages List', true));
		$this->set('title_for_layout', __('Messages List', true));
		$this->set('config', $config);
		$messages = $CustomerMessage->find('all', array('conditions' => array('CustomerMessage.customer_id' => $id)));
		$this->set('data',$messages);
		
	}	
					
	public function admin ($ajax = false)
	{
		$this->set('current_crumb', __('Customers Listing', true));
		$this->set('title_for_layout', __('Customers Listing', true));
		$data = $this->paginate('Customer');
		$this->set('data',$data);

	}	

	public function admin_search() {
		if (!isset($_SESSION['Search'])) {
			$_SESSION['Search'] = array();
		}

		if (isset($this->data['Search']['customer_search_term'])) {
			$_SESSION['Search']['customer_search_term'] = $this->data['Search']['customer_search_term'];
		}
		$this->set('current_crumb', __('Search Result', true));
		$this->set('title_for_layout', __('Search Result', true));

		if (isset($_SESSION['Search']['customer_search_term']) and ($this->RequestHandler->isPost() or isset($this->params['named']['page']) )) {
			$customer_search_term = $_SESSION['Search']['customer_search_term'];
		} else {
			$customer_search_term ='~';
			unset($_SESSION['Search']['customer_search_term']);
		}

		$data = $this->paginate('Customer', "Customer.id > 0 and (Customer.name LIKE '%" . $customer_search_term . "%' or Customer.email LIKE '%" . $customer_search_term . "%' or AddressBook.phone LIKE '%" . $customer_search_term . "%')");

		$this->set('data',$data);

	}
	
	public function generate_country_list($country_id = 0)
	{
		  App::import('Model', 'Country');
		  $Countries = new Country();

      if ($country_id > 0){
      $default_country = $country_id;
      } else {

		// Get Default Country
		App::import('Model', 'Country');
		$country = new Country();
		$default_country = $country->find('first', array('conditions' => array('Country.default' => 1),'limit' => 1));			

      $default_country = $default_country['Country']['id'];
      }
      
			$countries = $Countries->find('list', array('conditions' => array('active' => 1)));
			foreach($countries AS $key => $value)
			{
				$countries[$key] = __($value, true);
			}

		$this->set('country_list',$countries);
					
		return $countries;
	}
	
	public function generate_state_list($state_id = 0)
	{
		  App::import('Model', 'CountryZone');
		  $CountryZones = new CountryZone();

      if ($state_id > 0){
      $default_country = $state_id;
      } else {
		// Get Default Country
		App::import('Model', 'Country');
		$country = new Country();
		$default_country = $country->find('first', array('conditions' => array('Country.default' => 1),'limit' => 1));			

      $default_country = $default_country['Country']['id'];
      }
      
			$states = $CountryZones->find('list', array('conditions' => array('country_id' => $default_country)));
			foreach($states AS $key => $value)
			{
				$states[$key] = __($value, true);
			}

		$this->set('state_list',$states);
							
		return $states;
	}

}