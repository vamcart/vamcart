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

echo $form->create('Content', array('action' => '/contents/admin_modify_selected/', 'url' => '/contents/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $html->tableHeaders(array(	 __('Title', true), __('Type', true), __('Template', true), __('Active', true), __('Show in menu', true), __('Default', true), __('Sort Order', true), __('Action', true), '&nbsp;'));

foreach ($content_data AS $content)
{

	// Set the name link
	if($content['Content']['count'] > 0)
	{
		// Link to child view
		$name_link = $html->link($html->image('admin/icons/folder.png') . ' ' . $content['ContentDescription']['name'], '/contents/admin/0/' . $content['Content']['id'], null, null, false);
	}
	else
	{
		// Link it to the edit screen
		$name_link = $html->link($content['ContentDescription']['name'], '/contents/admin_edit/' . $content['Content']['id']);
	}
	
	echo $admin->TableCells(
		  array(
				$name_link,
				$content['ContentType']['name'],
				$content['Template']['name'],
				$ajax->link(($content['Content']['active'] == 1?$html->image('admin/icons/true.png'):$html->image('admin/icons/false.png')), 'null', $options = array('url' => '/contents/admin_change_active_status/' . $content['Content']['id'], 'update' => 'inner-content'), null, false),
				$ajax->link(($content['Content']['show_in_menu'] == 1?$html->image('admin/icons/true.png'):$html->image('admin/icons/false.png')), 'null', $options = array('url' => '/contents/admin_change_show_in_menu_status/' . $content['Content']['id'], 'update' => 'inner-content'), null, false),
				$admin->DefaultButton($content['Content']),
				$admin->MoveButtons($content['Content'], $content_count),				
				$admin->ActionButton('edit','/contents/admin_edit/' . $content['Content']['id']) . $admin->ActionButton('delete','/contents/admin_delete/' . $content['Content']['id']),
				$form->checkbox('modify][', array('value' => $content['Content']['id']))
		   ));
		   	
}

// Display a link letting the user to go up one level
if(isset($parent_content))
{
	$parent_link = $html->link(__('Up One Level', true),'/contents/admin/' . $parent_content['Content']['parent_id']);
	echo '<tr><td colspan="9">' . $parent_link . '</td></tr>';	
}
echo '</table>';

echo $admin->ActionBar(array('activate'=>__('Activate',true),'deactivate'=>__('Deactivate',true),'show_in_menu'=>__('Show In Menu',true),'hide_from_menu'=>__('Hide From Menu',true),'delete'=>__('Delete',true)));
echo $form->end();
?>