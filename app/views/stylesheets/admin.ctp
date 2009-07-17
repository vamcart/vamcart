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


echo $form->create('Stylesheet', array('action' => '/stylesheets/admin_modify_selected/', 'url' => '/stylesheets/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $html->tableHeaders(array( __('Title', true), __('Active', true), __('Media Type', true), __('Action', true), '&nbsp;'));

foreach ($stylesheets AS $stylesheet)
{
	echo $admin->TableCells(
		  array(
			$html->link($stylesheet['Stylesheet']['name'],'/stylesheets/admin_edit/' . $stylesheet['Stylesheet']['id']),
			$ajax->link(($stylesheet['Stylesheet']['active'] == 1?$html->image('admin/icons/true.png'):$html->image('admin/icons/false.png')), 'null', $options = array('url' => '/stylesheets/admin_change_active_status/' . $stylesheet['Stylesheet']['id'], 'update' => 'content'), null, false),
			$stylesheet['StylesheetMediaType']['name'],
			$admin->ActionButton('stylesheet','/stylesheets/admin_attach_templates/' . $stylesheet['Stylesheet']['id']) . $admin->ActionButton('copy','/stylesheets/admin_copy/' . $stylesheet['Stylesheet']['id']) . $admin->ActionButton('edit','/stylesheets/admin_edit/' . $stylesheet['Stylesheet']['id']) . $admin->ActionButton('delete','/stylesheets/admin_delete/' . $stylesheet['Stylesheet']['id']), 
			$form->checkbox('modify][', array('value' => $stylesheet['Stylesheet']['id']))
			
		   ));
}
echo '</table>';

echo $admin->ActionBar(array('activate'=>__('Activate',true),'deactivate'=>__('Deactivate',true),'delete'=>__('Delete',true)));
echo $form->end(); 

?>