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

echo $html->tableHeaders(array( __('Name', true), __('Active', true), __('Default', true), __('Action', true)));

foreach ($payment_method_data AS $payment_method)
{
	echo $admin->TableCells(
		  array(
				$html->link($payment_method['PaymentMethod']['name'], '/payment_methods/admin_edit/' . $payment_method['PaymentMethod']['id']),
				$ajax->link(($payment_method['PaymentMethod']['active'] == 1?$html->image('admin/true.gif'):$html->image('admin/false.gif')), 'null', $options = array('url' => '/payment_methods/admin_change_active_status/' . $payment_method['PaymentMethod']['id'], 'update' => 'inner-content'), null, false),				
				$admin->DefaultButton($payment_method['PaymentMethod']),
				$admin->ActionButton('edit','/payment_methods/admin_edit/' . $payment_method['PaymentMethod']['id'])
		   ));
		   	
}
echo '</table>';

?>