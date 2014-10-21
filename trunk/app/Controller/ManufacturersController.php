<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
class ManufacturersController extends AppController {
	public $name = 'Manufacturers';
	
	public function admin_change_active_status ($id) 
	{
		$this->changeActiveStatus($id);	
	}
		
	public function admin_delete ($manufacturer_id)
	{
		// Get the manufacturer and make sure it's not the default
		$this->Manufacturer->id = $manufacturer_id;
		$manufacturer = $this->Manufacturer->read();
		
		if($manufacturer['Manufacturer']['default'] == 1)
		{
			$this->Session->setFlash( __('Error: Could not delete default record.', true));		
		}
		else
		{
			// Ok, delete the manufacturer
			$this->Manufacturer->delete($manufacturer_id);	
			$this->Session->setFlash( __('Record deleted.', true));		
		}
		$this->redirect('/manufacturers/admin/');
	}
	
	
	public function admin_edit ($manufacturer_id = null)
	{
		$this->set('current_crumb', __('Manufacturer Details', true));
		$this->set('title_for_layout', __('Manufacturer Details', true));
		// If they pressed cancel
		if(isset($this->data['cancelbutton']))
		{
			$this->redirect('/manufacturers/admin/');
			die();
		}
		
		if(empty($this->data))
		{
			$this->request->data = $this->Manufacturer->read(null,$manufacturer_id);
		}
		else
		{
			$this->Manufacturer->save($this->data);		
			$this->Session->setFlash(__('Record created.', true));
			$this->redirect('/manufacturers/admin/');
		}		
	}
	
	public function admin_new() 
	{
		$this->redirect('/manufacturers/admin_edit/');
	}
	
	public function admin_modify_selected() 	
	{
		$build_flash = "";
		foreach($this->params['data']['Manufacturer']['modify'] AS $value)
		{
			// Make sure the id is valid
			if($value > 0)
			{
				$this->Manufacturer->id = $value;
				$manufacturer = $this->Manufacturer->read();
		
				switch ($this->data['multiaction']) 
				{
					case "delete":
						$this->Manufacturer->delete($value);
						$build_flash .= __('Record deleted.', true) . ' ' . $manufacturer['Manufacturer']['name'] . '<br />';									
					break;
					case "activate":
						$manufacturer['Manufacturer']['active'] = 1;
						$this->Manufacturer->save($manufacturer);
						$build_flash .= __('Record activated.', true) . ' (' . $manufacturer['Manufacturer']['name'] . ')<br />';								
					break;					
					case "deactivate":
							$manufacturer['Manufacturer']['active'] = 0;
							$this->Manufacturer->save($manufacturer);
							$build_flash .= __('Record deactivated.', true) . ' ' . $manufacturer['Manufacturer']['name'] . '<br />';								
					break;										
				}
			}
		}
		$this->Session->setFlash($build_flash);
		$this->redirect('/manufacturers/admin/');
	}	
	
	public function admin ($ajax = false)
	{
		$this->set('current_crumb', __('Manufacturers Listing', true));
		$this->set('title_for_layout', __('Manufacturers Listing', true));
		$this->set('manufacturer_data',$this->Manufacturer->find('all', array('order' => array('Manufacturer.name ASC'))));	
	}	
	
}
?>