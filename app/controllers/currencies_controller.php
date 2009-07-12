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

class CurrenciesController extends AppController {
	var $name = 'Currencies';
	var $components = array('EventBase');

	function pick_currency ()
	{
		$_SESSION['Customer']['currency_id'] = $_POST['currency_picker'];

		$this->EventBase->ProcessEvent('SwitchCurrency');

		// Delete the cache.
		if(file_exists(CACHE . 'cake_sms_currency_output'))
		{
			Cache::delete('sms_currency_output');
		}
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
		
	function admin_change_active_status ($id) 
	{
		$this->changeActiveStatus($id);	
	}
	
	function admin_set_as_default ($currency_id)
	{
		$this->setDefaultItem($currency_id);
	}

	function admin_delete ($currency_id)
	{
		// Get the currency and make sure it's not the default
		$this->Currency->id = $currency_id;
		$currency = $this->Currency->read();
		
		if($currency['Currency']['default'] == 1)
		{
			$this->Session->setFlash( __('record_delete_default', true));		
		}
		else
		{
			// Ok, delete the currency
			$this->Currency->del($currency_id);	
			$this->Session->setFlash( __('record_deleted', true));		
		}
		$this->redirect('/currencies/admin/');
	}
	
	
	function admin_edit ($currency_id = null)
	{
		// If they pressed cancel
		if(isset($this->params['form']['cancel']))
		{
			$this->redirect('/currencies/admin/');
			die();
		}
		
		if(empty($this->data))
		{
			$this->data = $this->Currency->read(null,$currency_id);
		}
		else
		{
			$this->Currency->save($this->data);		
			$this->Session->setFlash(__('record_created', true));
			$this->redirect('/currencies/admin');
		}		
		$this->render('','admin');
	}
	
	function admin_new() 
	{
		$this->redirect('/currencies/admin_edit/');
	}
	
	function admin_modify_selected() 	
	{
		$build_flash = "";
		foreach($this->params['data']['Currency']['modify'] AS $value)
		{
			// Make sure the id is valid
			if($value > 0)
			{
				$this->Currency->id = $value;
				$currency = $this->Currency->read();
		
				switch ($this->params['form']['multiaction']) 
				{
					case "delete":
						// Make sure it's not the default currency
						if($currency['Currency']['default'] == 0)
						{
						    $this->Currency->del($value);
							$build_flash .= __('record_deleted', true) . ' (' . $currency['Currency']['name'] . ')<br />';									
						}
						else
						{	
							$build_flash .= __('record_delete_default', true) . ' (' . $currency['Currency']['name'] . ')<br />';								
						}
					break;
					case "activate":
						$currency['Currency']['active'] = 1;
						$this->Currency->save($currency);
						$build_flash .= __('record_activated', true) . ' (' . $currency['Currency']['name'] . ')<br />';								
					break;					
					case "deactivate":
						// Don't let them deactivate the default currency
						if($currency['Currency']['default'] == 1)
						{
							$build_flash .=  __('record_deactivate_default', true) .' (' . $currency['Currency']['name'] . ')<br />';								
						}
						else
						{
							$currency['Currency']['active'] = 0;
							$this->Currency->save($currency);
							$build_flash .= __('record_deactivated', true) . ' (' . $currency['Currency']['name'] . ')<br />';								
						}
					break;										
				}
			}
		}
		$this->Session->setFlash($build_flash);
		$this->redirect('/currencies/admin/');
	}	
	
	function admin ($ajax = false)
	{
		$this->set('currency_data',$this->Currency->findAll(null,null,'Currency.name ASC'));	

		if($ajax == true)
			$this->render('','ajax');
		else
			$this->render('','admin');
	}	
	
}
?>