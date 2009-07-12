<?php
/** SMS - Selling Made Simple
 * Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
 * This project's homepage is: http://sellingmadesimple.org
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * BUT withOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
**/

class LanguagesController extends AppController {
	var $name = 'Languages';
	var $components = array('EventBase');	
	
	function pick_language($language_id,$redirect = null) 
	{
		$_SESSION['Customer']['language_id'] = $language_id;

		$this->EventBase->ProcessEvent('SwitchLanguage');
		
		if($redirect != null)
			$this->redirect($redirect);	
		else
			if(isset($_SERVER['HTTP_REFERER']))
				$this->redirect($_SERVER['HTTP_REFERER']);
			else
				$this->redirect('/');		
		
	}

	function admin_change_active_status ($id) 
	{
		$this->changeActiveStatus($id);	
	}
		
	function admin_set_as_default ($language_id)
	{
		$this->setDefaultItem($language_id);
	}

	function admin_delete ($language_id)
	{
		// Get the language and make sure it's not the default
		$this->Language->id = $language_id;
		$language = $this->Language->read();
		
		if($language['Language']['default'] == 1)
		{
			$this->Session->setFlash( __('record_delete_default', true));		
		}
		else
		{
			// Ok, delete the language
			$this->Language->del($language_id);	
			$this->Session->setFlash( __('record_delete', true));		
		}
		$this->redirect('/languages/admin/');
	}
	
	
	function admin_edit ($language_id = null)
	{
		// If they pressed cancel
		if(isset($this->params['form']['cancel']))
		{
			$this->redirect('/languages/admin/');
			die();
		}
		
		if(empty($this->data))
		{
			$this->data = $this->Language->read(null,$language_id);
		}
		else
		{
			$this->Language->save($this->data);		
			$this->Session->setFlash(__('record_created', true));
			$this->redirect('/languages/admin');
		}		
		$this->render('','admin');
	}
	
	function admin_new() 
	{
		$this->redirect('/languages/admin_edit/');
	}
	
	function admin_modify_selected() 	
	{
		$build_flash = "";
		foreach($this->params['data']['Language']['modify'] AS $value)
		{
			// Make sure the id is valid
			if($value > 0)
			{
				$this->Language->id = $value;
				$language = $this->Language->read();
		
				switch ($this->params['form']['multiaction']) 
				{
					case "delete":
						// Make sure it's not the default language
						if($language['Language']['default'] == 0)
						{
						    $this->Language->del($value);
							$build_flash .= __('record_deleted', true) . ': ' . $language['Language']['name'] . '<br />';									
						}
						else
						{	
							$build_flash .= __('record_delete_default', true) . ': ' . $language['Language']['name'] . '<br />';								
						}
					break;
					case "activate":
						$language['Language']['active'] = 1;
						$this->Language->save($language);
						$build_flash .= __('record_activated', true) . ' (' . $language['Language']['name'] . ')<br />';								
					break;					
					case "deactivate":
						// Don't let them deactivate the default language
						if($language['Language']['default'] == 1)
						{
							$build_flash .=  __('record_deactivate_default', true) .': ' . $language['Language']['name'] . '<br />';								
						}
						else
						{
							$language['Language']['active'] = 0;
							$this->Language->save($language);
							$build_flash .= __('record_deactivated', true) . ': ' . $language['Language']['name'] . '<br />';								
						}
					break;										
				}
			}
		}
		$this->Session->setFlash($build_flash);
		$this->redirect('/languages/admin/');
	}	
	
	function admin ($ajax = false)
	{
			
		$this->set('language_data',$this->Language->findAll(null,null,'Language.name ASC'));	

		if($ajax == true)
			$this->render('','ajax');
		else
			$this->render('','admin');
	}	
	
}
?>