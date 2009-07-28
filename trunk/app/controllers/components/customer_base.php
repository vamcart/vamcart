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

class CustomerBaseComponent extends Object 
{

    function startup(&$controller)
	{

    }

	/**
	* Saves all current customer information to the correct order record
	*
	* @param  array  $details A key => value paired array of customer details.  Keys should be the same as the fields in the Order table.
	*/
	function save_customer_details ($customer_details)
	{

		App::import('Component', 'EventBase');
		$this->EventBase =& new EventBaseComponent();
		
		App::import('Model', 'Order');
		$this->Order =& new Order();
		
		$order = $this->Order->read(null,$_SESSION['Customer']['order_id']);

		$this->EventBase->ProcessEvent('UpdateCustomerDetailsBeforeSave');
				
		foreach($customer_details AS $key => $value)
			$order['Order'][$key] = $value;

		$this->Order->save($order);
		
		$this->EventBase->ProcessEvent('UpdateCustomerDetailsAfterSave');		
	}
}
?>