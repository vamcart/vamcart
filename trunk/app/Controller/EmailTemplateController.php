<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
class EmailTemplateController extends AppController {

	public $name = 'EmailTemplate';
	public $uses = array('EmailTemplate','Language');

	public function admin_delete ($email_template_id)
	{
		// Get the email template and make sure it's not the default
		$this->EmailTemplate->id = $email_template_id;
		$email_template = $this->EmailTemplate->read();
		
		if($email_template['EmailTemplate']['default'] == 1)
		{
			$this->Session->setFlash( __('Error: Could not delete default record.', true));		
		}
		else
		{
		// Ok, delete the email template
		$this->EmailTemplate->delete($email_template_id,true);
		$this->Session->setFlash(__('Record deleted.',true));
		}
		$this->redirect('/email_template/admin/');
	}

	public function admin_edit ($email_template_id = null)
	{
		$this->set('current_crumb', __('Edit', true));
		$this->set('title_for_layout', __('Edit', true));
		// If they pressed cancel
		if(isset($this->data['cancelbutton']))
		{
			$this->redirect('/email_template/admin/');
			die();
		}

		if(empty($this->data))
		{
			
			$this->EmailTemplate->id = $email_template_id;
			$data = $this->EmailTemplate->read();
		
			// Loop through the description results and assign the key as the language ID
			// But not if it's a new order status
			
			if(!empty($data))
			{
			$tmp = $data['EmailTemplateDescription'];
			
			$data['EmailTemplateDescription'] = null;
			foreach($tmp AS $id => $value)
			{
				$key = $value['language_id'];
				$data['EmailTemplateDescription'][$key] = $value;
			}
			}
			$this->set('data', $data);
			$this->set('languages', $this->EmailTemplate->EmailTemplateDescription->Language->find('all', array('conditions' => array('active' => '1'), 'order' => array('Language.id ASC'))));
		}
		else
		{
			// If it's a new order status set the sort order to the highest + 1
			if($email_template_id == null)
			{
				$highest = $this->EmailTemplate->find('all', array('order' => array('EmailTemplate.order DESC')));
				$order = $highest['EmailTemplate']['order'] + 1;
				$this->request->data['EmailTemplate']['order'] = $order;
				
				// Also set the flash
				$this->Session->setFlash(__('Record created.', true));
			}
			else
			{
				$this->Session->setFlash(__('Record saved.', true));
			}
			
			// Save the order status
			$this->EmailTemplate->save($this->data);		
			
			// Get the id if it's new
			if($email_template_id == null)
				$email_template_id = $this->EmailTemplate->getLastInsertid();
			
			// Lets just delete all of the description associations and remake them
			$descriptions = $this->EmailTemplate->EmailTemplateDescription->find('all', array('conditions' => array('email_template_id' => $email_template_id)));
			foreach($descriptions AS $description)
			{
				$this->EmailTemplate->EmailTemplateDescription->delete($description['EmailTemplateDescription']['id']);
			}

		
			foreach($this->data['EmailTemplateDescription'] AS $id => $value)
			{
				$new_description = array();
				$new_description['EmailTemplateDescription']['email_template_id'] = $email_template_id;
				$new_description['EmailTemplateDescription']['language_id'] = $id;
				$new_description['EmailTemplateDescription']['subject'] = $value['subject'];				
				$new_description['EmailTemplateDescription']['content'] = $value['content'];				
				
				$this->EmailTemplate->EmailTemplateDescription->create();
				$this->EmailTemplate->EmailTemplateDescription->save($new_description);
			}
			
			$this->redirect('/email_template/admin');
		}		
	}

	

	public function admin_new() 
	{
		$this->redirect('/email_template/admin_edit/');
	}


	public function admin ($ajax = false)
	{
		$this->set('current_crumb', __('Email Templates Listing', true));
		$this->set('title_for_layout', __('Email Templates Listing', true));
		// Lets remove the hasMany association for now and associate it with our language of choice
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
		
		$this->set('email_template_data',$this->EmailTemplate->find('all', array('order' => array('EmailTemplate.order ASC'))));			

	}	
}

?>