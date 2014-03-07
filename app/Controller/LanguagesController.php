<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
class LanguagesController extends AppController {
	public $name = 'Languages';
	public $components = array('EventBase');	
	
	public function pick_language($language_id,$redirect = null) 
	{
		$this->Session->write('Customer.language_id', $language_id);

		// Set Config.language
		$default_language = $this->Language->find('first', array('conditions' => array('id' => $language_id)));

		$this->Session->write('Config.language', $default_language['Language']['iso_code_2']);
		$this->Session->write('Customer.language', $default_language['Language']['iso_code_2']);

		$this->EventBase->ProcessEvent('SwitchLanguage');
		
		if($redirect != null)
			$this->redirect($redirect);	
		else
			if(isset($_SERVER['HTTP_REFERER']))
				$this->redirect($_SERVER['HTTP_REFERER']);
			else
				$this->redirect('/');		
		
	}

	public function admin_change_active_status ($id) 
	{
		$this->changeActiveStatus($id);	
	}
		
	public function admin_set_as_default ($language_id)
	{
		$this->setDefaultItem($language_id);
	}

	public function admin_delete ($language_id)
	{
		// Get the language and make sure it's not the default
		$this->Language->id = $language_id;
		$language = $this->Language->read();
		
		if($language['Language']['default'] == 1)
		{
			$this->Session->setFlash( __('Error: Could not delete default record.', true));		
		}
		else
		{
			// Ok, delete the language
			$this->Language->delete($language_id);	
			$this->Session->setFlash( __('Record deleted.', true));		
		}
		$this->redirect('/languages/admin/');
	}
	
	
	public function admin_edit ($language_id = null)
	{
		$this->set('current_crumb', __('Language Details', true));
		$this->set('title_for_layout', __('Language Details', true));
		// If they pressed cancel
		if(isset($this->data['cancelbutton']))
		{
			$this->redirect('/languages/admin/');
			die();
		}
		
		if(empty($this->data))
		{
			$this->request->data = $this->Language->read(null,$language_id);
		}
		else
		{
			$this->Language->save($this->data);		
			$this->Session->setFlash(__('Record created.', true));
			Cache::clear(false, 'catalog');
			$this->redirect('/languages/admin/');
		}		
	}
	
	public function admin_new() 
	{
		$this->redirect('/languages/admin_edit/');
	}
	
	public function admin_modify_selected() 	
	{
		$build_flash = "";
		foreach($this->params['data']['Language']['modify'] AS $value)
		{
			// Make sure the id is valid
			if($value > 0)
			{
				$this->Language->id = $value;
				$language = $this->Language->read();
		
				switch ($this->data['multiaction']) 
				{
					case "delete":
						// Make sure it's not the default language
						if($language['Language']['default'] == 0)
						{
						    $this->Language->delete($value);
							$build_flash .= __('Record deleted.', true) . ' ' . $language['Language']['name'] . '<br />';									
						}
						else
						{	
							$build_flash .= __('Error: Could not delete default record.', true) . ' ' . $language['Language']['name'] . '<br />';								
						}
					break;
					case "activate":
						$language['Language']['active'] = 1;
						$this->Language->save($language);
						$build_flash .= __('Record activated.', true) . ' (' . $language['Language']['name'] . ')<br />';								
					break;					
					case "deactivate":
						// Don't let them deactivate the default language
						if($language['Language']['default'] == 1)
						{
							$build_flash .=  __('Error: Could not deactivate default record.', true) .' ' . $language['Language']['name'] . '<br />';								
						}
						else
						{
							$language['Language']['active'] = 0;
							$this->Language->save($language);
							$build_flash .= __('Record deactivated.', true) . ' ' . $language['Language']['name'] . '<br />';								
						}
					break;										
				}
			}
		}
		$this->Session->setFlash($build_flash);
		$this->redirect('/languages/admin/');
	}	
	
	public function admin ($ajax = false)
	{
		$this->set('current_crumb', __('Languages Listing', true));
		$this->set('title_for_layout', __('Languages Listing', true));
		$this->set('language_data',$this->Language->find('all', array('order' => array('Language.name ASC'))));	
	}	
	
}
?>