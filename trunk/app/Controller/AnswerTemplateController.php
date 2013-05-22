<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
class AnswerTemplateController extends AppController {

	public $name = 'AnswerTemplate';
	public $uses = array('AnswerTemplate','Language');

	public function admin_delete ($answer_template_id)
	{
		// Get the answer template and make sure it's not the default
		$this->AnswerTemplate->id = $answer_template_id;
		$answer_template = $this->AnswerTemplate->read();
		
		if($answer_template['AnswerTemplate']['default'] == 1)
		{
			$this->Session->setFlash( __('Error: Could not delete default record.', true));		
		}
		else
		{
		// Ok, delete the answer template
		$this->AnswerTemplate->delete($answer_template_id,true);
		$this->Session->setFlash(__('Record deleted.',true));
		}
		$this->redirect('/answer_template/admin/');
	}

	public function admin_edit ($answer_template_id = null)
	{
		$this->set('current_crumb', __('Edit', true));
		$this->set('title_for_layout', __('Edit', true));
		// If they pressed cancel
		if(isset($this->data['cancelbutton']))
		{
			$this->redirect('/answer_template/admin/');
			die();
		}

		if(empty($this->data))
		{
			
			$this->AnswerTemplate->id = $answer_template_id;
			$data = $this->AnswerTemplate->read();
		
			// Loop through the description results and assign the key as the language ID
			// But not if it's a new order status
			
			if(!empty($data))
			{
			$tmp = $data['AnswerTemplateDescription'];
			
			$data['AnswerTemplateDescription'] = null;
			foreach($tmp AS $id => $value)
			{
				$key = $value['language_id'];
				$data['AnswerTemplateDescription'][$key] = $value;
			}
			}
			$this->set('data', $data);
			$this->set('languages', $this->AnswerTemplate->AnswerTemplateDescription->Language->find('all', array('conditions' => array('active' => '1'), 'order' => array('Language.id ASC'))));
		}
		else
		{
			// If it's a new order status set the sort order to the highest + 1
			if($answer_template_id == null)
			{
				$highest = $this->AnswerTemplate->find('all', array('order' => array('AnswerTemplate.order DESC')));
				$order = $highest['AnswerTemplate']['order'] + 1;
				$this->request->data['AnswerTemplate']['order'] = $order;
				
				// Also set the flash
				$this->Session->setFlash(__('Record created.', true));
			}
			else
			{
				$this->Session->setFlash(__('Record saved.', true));
			}
			
			// Save the order status
			$this->AnswerTemplate->save($this->data);		
			
			// Get the id if it's new
			if($answer_template_id == null)
				$answer_template_id = $this->AnswerTemplate->getLastInsertid();
			
			// Lets just delete all of the description associations and remake them
			$descriptions = $this->AnswerTemplate->AnswerTemplateDescription->find('all', array('conditions' => array('answer_template_id' => $answer_template_id)));
			foreach($descriptions AS $description)
			{
				$this->AnswerTemplate->AnswerTemplateDescription->delete($description['AnswerTemplateDescription']['id']);
			}

		
			foreach($this->data['AnswerTemplateDescription'] AS $id => $value)
			{
				$new_description = array();
				$new_description['AnswerTemplateDescription']['answer_template_id'] = $answer_template_id;
				$new_description['AnswerTemplateDescription']['language_id'] = $id;
				$new_description['AnswerTemplateDescription']['name'] = $value['name'];				
				$new_description['AnswerTemplateDescription']['content'] = $value['content'];				
				
				$this->AnswerTemplate->AnswerTemplateDescription->create();
				$this->AnswerTemplate->AnswerTemplateDescription->save($new_description);
			}
			
			$this->redirect('/answer_template/admin');
		}		
	}

	

	public function admin_new() 
	{
		$this->redirect('/answer_template/admin_edit/');
	}


	public function admin ($ajax = false)
	{
		$this->set('current_crumb', __('Answer Templates Listing', true));
		$this->set('title_for_layout', __('Answer Templates Listing', true));
		// Lets remove the hasMany association for now and associate it with our language of choice
		$this->AnswerTemplate->unbindModel(array('hasMany' => array('AnswerTemplateDescription')));
		$this->AnswerTemplate->bindModel(
	        array('hasOne' => array(
				'AnswerTemplateDescription' => array(
                    'className' => 'AnswerTemplateDescription',
					'conditions'   => 'language_id = ' . $this->Session->read('Customer.language_id')
                )
            )
           	)
	    );
		
		$this->set('answer_template_data',$this->AnswerTemplate->find('all', array('order' => array('AnswerTemplate.order ASC'))));			

	}	
}

?>