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


echo '<table class="contentTable">';

echo $html->tableHeaders(array( __('Name', true), __('Default', true),  __('Order', true), __('Action', true)));

foreach ($order_status_data AS $order_status)
{
	echo $admin->TableCells(
		  array(
				$html->link($order_status['OrderStatusDescription']['name'], '/order_status/admin_edit/' . $order_status['OrderStatus']['id']),
				$admin->DefaultButton($order_status['OrderStatus']),
				$admin->MoveButtons($order_status['OrderStatus'], $order_status_count),
				$admin->ActionButton('edit','/order_status/admin_edit/' . $order_status['OrderStatus']['id'],__('Edit', true)) . $admin->ActionButton('delete','/order_status/admin_delete/' . $order_status['OrderStatus']['id'],__('Delete', true))
		   ));
		   	
}

echo '</table>';

echo $admin->CreateNewLink();

?>