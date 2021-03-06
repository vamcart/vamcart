<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

class GroupsCustomersController extends AppController {
	public $name = 'GroupsCustomers';
        public $paginate = array('limit' => 20, 'order' => array('GroupsCustomer.id' => 'asc'));
        
        public function admin ()
			{
            $this->set('current_crumb', __('Customers groups listing', true));
            $this->set('title_for_layout', __('Customers groups listing', true));
            
            $this->GroupsCustomer->unbindModel(array('hasMany' => array('GroupsCustomerDescription')));
            $this->GroupsCustomer->bindModel(array('hasOne' => array('GroupsCustomerDescription' => array(
						'className' => 'GroupsCustomerDescription',
						'conditions' => 'language_id = ' . $this->Session->read('Customer.language_id')
					))));            
            
            $data = $this->paginate('GroupsCustomer');
            $this->set('data',$data);
        	}          
        
        public function admin_edit ($group_id = null)
			{
            $this->set('current_crumb', __('Group details', true));
            $this->set('title_for_layout', __('Group details', true));            
            $data = $this->GroupsCustomer->read(null,$group_id);
            $data['GroupsCustomerDescription'] = Set::combine($data,'GroupsCustomerDescription.{n}.language_id','GroupsCustomerDescription.{n}');
            $this->request->data = $data;
            $this->loadModel('Language');
            $this->set('languages', $this->Language->find('all', array('conditions' => array('active' => '1'), 'order' => array('Language.id ASC'))));            
			}
        
        public function admin_new() 
			{
            $this->redirect('/groups_customers/admin_edit/');
			}
        
        public function admin_save ()
			{              
            if(isset($this->data['cancelbutton']))
            {
                $this->redirect('/groups_customers/admin/');
                die();
            }		
            if(!empty($this->data))
            {
                if($this->GroupsCustomer->saveAll($this->request->data)) 
                {
                    $this->Session->setFlash(__('Record saved.', true));
                } else 
                {
                    $this->Session->setFlash(__('Group Not Saved!', true), 'default', array('class' => 'error-message red')); 
                    if (!$this->GroupsCustomer->validates()) {
                        //$err = $this->GroupsCustomer->validationErrors;
                        $this->Session->setFlash(__('Validation errors!', true), 'default', array('class' => 'error-message red'));                         
                    }
                }
            }
            $this->redirect('/groups_customers/admin/');
        	}
        
			public function admin_delete ($group_id = null)
			{
            $this->GroupsCustomer->delete($group_id);
            $this->redirect('/groups_customers/admin/');
			}
			
			public function admin_modify_selected() 	
			{
			$build_flash = "";
			foreach($this->params['data']['GroupsCustomer']['modify'] AS $value)
			{
				// Make sure the id is valid
				if($value > 0)
				{
					$this->GroupsCustomer->id = $value;
					$currency = $this->GroupsCustomer->read();
			
					switch ($this->data['multiaction']) 
					{
						case "delete":
							    $this->GroupsCustomer->delete($value);
								$build_flash .= __('Record deleted.', true) . '<br />';									
						break;
					}
				}
			}
			$this->Session->setFlash($build_flash);
			$this->redirect('/groups_customers/admin/');
			}
							
	}