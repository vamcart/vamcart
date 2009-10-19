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

class EmailTemplateController extends AppController {

	var $name = 'EmailTemplate';
	var $uses = array('EmailTemplate','Language');

	function admin_set_as_default ($order_status_id)
	{
		$this->setDefaultItem($order_status_id);
	}

	function admin_move ($id, $direction)
	{
		$this->moveItem($id, $direction);		
	}
	
	function admin_delete ($order_status_id)
	{
		// Get the order_status and make sure it's not the default
		$this->EmailTemplate->id = $order_status_id;
		$order_status = $this->EmailTemplate->read();

		if($order_status['EmailTemplate']['default'] == 1)
		{
			$this->Session->setFlash( __('Error: Could not delete default record.', true));		
		}
		elseif($this->EmailTemplate->Order->findCount(array('Order.order_status_id' => $order_status_id)) > 0)
		{
			$this->Session->setFlash( __('Record deleted.', true));				
		}
		else
		{
			// Ok, delete the order_status and cascade for the description
			$status = $this->EmailTemplate->read(null,$order_status_id);
			$this->EmailTemplate->del($order_status_id, true);	
			
			// Move all order status that have a higher sort order 1 slot down
			$higher_positions = $this->EmailTemplate->find('all', array('conditions' => array('EmailTemplate.order >' => $status['EmailTemplate']['order'])));
			foreach($higher_positions AS $position)
			{
				$position['EmailTemplate']['order'] -= 1; 
				$this->EmailTemplate->save($position);
			}
			
			$this->Session->setFlash( __('Record deleted.', true));		
		}
		$this->redirect('/order_status/admin/');

	}

	function admin_edit ($order_status_id = null)
	{
		$this->set('current_crumb', __('Order Status', true));
		// If they pressed cancel
		if(isset($this->params['form']['cancel']))
		{
			$this->redirect('/order_status/admin/');
			die();
		}

		if(empty($this->data))
		{
			
			$this->EmailTemplate->id = $order_status_id;
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
			if($order_status_id == null)
			{
				$highest = $this->EmailTemplate->find('all', array('order' => array('EmailTemplate.order DESC')));
				$order = $highest['EmailTemplate']['order'] + 1;
				$this->data['EmailTemplate']['order'] = $order;
				
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
			if($order_status_id == null)
				$order_status_id = $this->EmailTemplate->getLastInsertid();
			
			// Lets just delete all of the description associations and remake them
			$descriptions = $this->EmailTemplate->EmailTemplateDescription->find('all', array('conditions' => array('order_status_id' => $order_status_id)));
			foreach($descriptions AS $description)
			{
				$this->EmailTemplate->EmailTemplateDescription->del($description['EmailTemplateDescription']['id']);
			}

		
			foreach($this->data['EmailTemplateDescription'] AS $id => $value)
			{
				$new_description = array();
				$new_description['EmailTemplateDescription']['order_status_id'] = $order_status_id;
				$new_description['EmailTemplateDescription']['language_id'] = $id;
				$new_description['EmailTemplateDescription']['name'] = $value;				
				
				$this->EmailTemplate->EmailTemplateDescription->create();
				$this->EmailTemplate->EmailTemplateDescription->save($new_description);
			}
			
			$this->redirect('/order_status/admin');
		}		
	}

	

	function admin_new() 
	{
		$this->redirect('/order_status/admin_edit/');
	}


	function admin ($ajax = false)
	{
		$this->set('current_crumb', __('Order Status Listing', true));
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
		
		$this->set('order_status_data',$this->EmailTemplate->find('all', array('order' => array('EmailTemplate.order ASC'))));			
		$this->set('order_status_count', $this->EmailTemplate->findCount());

	}	
}

?>