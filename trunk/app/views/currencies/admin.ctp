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


echo $form->create('Currency', array('action' => '/currencies/admin_modify_selected/', 'url' => '/currencies/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $html->tableHeaders(array( __('Currency', true), __('Code', true), __('Active', true), __('Default', true), __('Action', true), '&nbsp;'));

foreach ($currency_data AS $currency)
{
	echo $admin->TableCells(
		  array(
				$html->link($currency['Currency']['name'], '/currencies/admin_edit/' . $currency['Currency']['id']),
				$currency['Currency']['code'],
				$ajax->link(($currency['Currency']['active'] == 1?$html->image('admin/true.gif'):$html->image('admin/false.gif')), 'null', $options = array('url' => '/currencies/admin_change_active_status/' . $currency['Currency']['id'], 'update' => 'inner-content'), null, false),
				$admin->DefaultButton($currency['Currency']),
				$admin->ActionButton('edit','/currencies/admin_edit/' . $currency['Currency']['id']) . $admin->ActionButton('delete','/currencies/admin_delete/' . $currency['Currency']['id']),
				$form->checkbox('modify][', array('value' => $currency['Currency']['id']))
		   ));
		   	
}

echo '</table>';

echo $admin->ActionBar(array('activate'=>__('Activate',true),'deactivate'=>__('Deactivate',true),'delete'=>__('Delete',true)));

?>