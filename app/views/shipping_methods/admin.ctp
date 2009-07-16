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

echo $html->tableHeaders(array( __('Name', true), __('Code', true), __('Active', true), __('Default', true), __('Action', true)));

foreach ($shipping_method_data AS $ShippingMethod)
{
	echo $admin->TableCells(
		  array(
				$html->link($ShippingMethod['ShippingMethod']['name'], '/shipping_methods/admin_edit/' . $ShippingMethod['ShippingMethod']['id']),
				$ShippingMethod['ShippingMethod']['code'],
				$ajax->link(($ShippingMethod['ShippingMethod']['active'] == 1?$html->image('admin/true.gif'):$html->image('admin/false.gif')), 'null', $options = array('url' => '/shipping_methods/admin_change_active_status/' . $ShippingMethod['ShippingMethod']['id'], 'update' => 'inner-content'), null, false),
				$admin->DefaultButton($ShippingMethod['ShippingMethod']),
				$admin->ActionButton('edit','/shipping_methods/admin_edit/' . $ShippingMethod['ShippingMethod']['id'])
		   ));
		   	
}

echo '</table>';

?>