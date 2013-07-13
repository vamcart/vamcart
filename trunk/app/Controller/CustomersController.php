<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
class CustomersController extends AppController {
	public $name = 'Customers';
	public $paginate = array('limit' => 20, 'order' => array('Customer.id' => 'asc'));

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
		}
		else
		{
			
			// Check if we set a new password, and if so make sure they match.
			if($this->data['Customer']['password'] != "")
			{
				if($this->data['Customer']['password'] != $this->data['Customer']['retype'])
				{
					$this->Session->setFlash(__('Sorry, passwords did not match.', true));
					//$this->redirect('/customers/admin/');
					//die();
				}
				
				$this->request->data['Customer']['password'] = Security::hash($this->data['Customer']['password'], 'sha1', true);

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
		
				switch ($this->data['multiaction']) 
				{
					case "delete":
						   $this->Customer->delete($value);
							$build_flash .= __('Record deleted.', true) . ' (' . $customer['Customer']['name'] . ')<br />';									
					break;
				}
			}
		}
		$this->Session->setFlash($build_flash);
		$this->redirect('/customers/admin/');
	}	
	
	public function admin ($ajax = false)
	{
		$this->set('current_crumb', __('Customers Listing', true));
		$this->set('title_for_layout', __('Customers Listing', true));
		$data = $this->paginate('Customer');
		$this->set('data',$data);

	}	
	
}