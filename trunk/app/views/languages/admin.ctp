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


echo $form->create('Language', array('action' => '/languages/admin_modify_selected/', 'url' => '/languages/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $html->tableHeaders(array( __('Language', true), __('Code', true), '&nbsp;', __('Active', true), __('Default', true), __('Action', true), '&nbsp;'));

foreach ($language_data AS $language)
{
	echo $admin->TableCells(
		  array(
				$html->link($language['Language']['name'], '/languages/admin_edit/' . $language['Language']['id']),
				$language['Language']['iso_code_2'],				
				$admin->ShowFlag($language['Language']),
				$ajax->link(($language['Language']['active'] == 1?$html->image('admin/icons/true.png', array('alt' => __('True', true))):$html->image('admin/icons/false.png', array('alt' => __('False', true)))), 'null', $options = array('url' => '/languages/admin_change_active_status/' . $language['Language']['id'], 'update' => 'content'), null, false),
				$admin->DefaultButton($language['Language']),
				$admin->ActionButton('edit','/languages/admin_edit/' . $language['Language']['id']) . $admin->ActionButton('delete','/languages/admin_delete/' . $language['Language']['id']),
				$form->checkbox('modify][', array('value' => $language['Language']['id']))
		   ));
		   	
}

echo '</table>';

echo $admin->ActionBar(array('activate'=>__('Activate',true),'deactivate'=>__('Deactivate',true),'delete'=>__('Delete',true)));

?>