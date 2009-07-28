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

class PerItemComponent extends Object 
{

	function beforeFilter ()
	{
	}

    function startup(&$controller)
	{
    }


	function calculate ()
	{
		App::import('Model', 'ShippingMethod');
		$this->ShippingMethod =& new ShippingMethod();
		$key_values = $this->ShippingMethod->findByCode('per_item');
	
		$data = array();
		if(!empty($key_values['ShippingMethodValue']))
			$data = array_combine(Set::extract($key_values, 'ShippingMethodValue.{n}.key'),
							  Set::extract($key_values, 'ShippingMethodValue.{n}.value'));	
		
		global $order;
		
		$shipping_total = $data['per_item_handling'];
		
		foreach($order['OrderProduct'] AS $product)
		{
			$shipping_total += ($data['per_item_amount']*$product['quantity']);
		}
		
		return $shipping_total;
	}
	
	
}
?>