<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
class LabelsController extends AppController {
	public $name = 'Labels';
	
	public function admin_change_active_status ($id) 
	{
		$this->changeActiveStatus($id);	
	}
		
	public function admin_set_as_default ($label_id)
	{
		$this->setDefaultItem($label_id);
	}

	public function admin_delete ($label_id)
	{
		// Get the label and make sure it's not the default
		$this->Label->id = $label_id;
		$label = $this->Label->read();
		
		if($label['Label']['default'] == 1)
		{
			$this->Session->setFlash( __('Error: Could not delete default record.', true));		
		}
		else
		{
			// Ok, delete the label
			$this->Label->delete($label_id);	
			$this->Session->setFlash( __('Record deleted.', true));		
		}
		$this->redirect('/labels/admin/');
	}
	
	
	public function admin_edit ($label_id = null)
	{
		$this->set('current_crumb', __('Product Label Details', true));
		$this->set('title_for_layout', __('Product Label Details', true));
		// If they pressed cancel
		if(isset($this->data['cancelbutton']))
		{
			$this->redirect('/labels/admin/');
			die();
		}
		
		if(empty($this->data))
		{
			$this->request->data = $this->Label->read(null,$label_id);
		}
		else
		{
			$this->Label->save($this->data);		
			$this->Session->setFlash(__('Record created.', true));
			$this->redirect('/labels/admin/');
		}		
	}
	
	public function admin_new() 
	{
		$this->redirect('/labels/admin_edit/');
	}
	
	public function admin_modify_selected() 	
	{
		$build_flash = "";
		foreach($this->params['data']['Label']['modify'] AS $value)
		{
			// Make sure the id is valid
			if($value > 0)
			{
				$this->Label->id = $value;
				$label = $this->Label->read();
		
				switch ($this->data['multiaction']) 
				{
					case "delete":
						// Make sure it's not the default label
						if($label['Label']['default'] == 0)
						{
						    $this->Label->delete($value);
							$build_flash .= __('Record deleted.', true) . ' ' . $label['Label']['name'] . '<br />';									
						}
						else
						{	
							$build_flash .= __('Error: Could not delete default record.', true) . ' ' . $label['Label']['name'] . '<br />';								
						}
					break;
					case "activate":
						$label['Label']['active'] = 1;
						$this->Label->save($label);
						$build_flash .= __('Record activated.', true) . ' (' . $label['Label']['name'] . ')<br />';								
					break;					
					case "deactivate":
						// Don't let them deactivate the default label
						if($label['Label']['default'] == 1)
						{
							$build_flash .=  __('Error: Could not deactivate default record.', true) .' ' . $label['Label']['name'] . '<br />';								
						}
						else
						{
							$label['Label']['active'] = 0;
							$this->Label->save($label);
							$build_flash .= __('Record deactivated.', true) . ' ' . $label['Label']['name'] . '<br />';								
						}
					break;										
				}
			}
		}
		$this->Session->setFlash($build_flash);
		$this->redirect('/labels/admin/');
	}	
	
	public function admin ($ajax = false)
	{
		$this->set('current_crumb', __('Product Labels Listing', true));
		$this->set('title_for_layout', __('Product Labels Listing', true));
		$this->set('label_data',$this->Label->find('all', array('order' => array('Label.alias ASC'))));	
	}	
	
}
?>