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


echo $form->create('GlobalContentBlock', array('action' => '/global_content_blocks/admin_modify_selected/', 'url' => '/global_content_blocks/admin_modify_selected/'));

echo '<table class="pagetable" cellspacing="0">';
echo $html->tableHeaders(array( __('Title', true), __('Call (Template Placeholder)', true), __('Active', true), __('Action', true), '&nbsp;'));

foreach ($global_content_blocks AS $global_content_block)
{
	echo $admin->TableCells(
		  array(
			$html->link($global_content_block['GlobalContentBlock']['name'],'/global_content_blocks/admin_edit/' . $global_content_block['GlobalContentBlock']['id']),
			'{global_content alias="' . $global_content_block['GlobalContentBlock']['alias'] . '"}',
			$ajax->link(($global_content_block['GlobalContentBlock']['active'] == 1?$html->image('admin/true.gif'):$html->image('admin/false.gif')), 'null', $options = array('url' => '/global_content_blocks/admin_change_active_status/' . $global_content_block['GlobalContentBlock']['id'], 'update' => 'inner-content'), null, false),
			$admin->ActionButton('edit','/global_content_blocks/admin_edit/' . $global_content_block['GlobalContentBlock']['id']) . $admin->ActionButton('delete','/global_content_blocks/admin_delete/' . $global_content_block['GlobalContentBlock']['id']),
			$form->checkbox('modify][', array('value' => $global_content_block['GlobalContentBlock']['id']))
		   ));
}
echo '</table>';
echo $admin->EmptyResults($global_content_blocks);

echo $admin->ActionBar(array('activate'=>__('Activate',true),'deactivate'=>__('Deactivate',true),'delete'=>__('Delete',true)));
echo $form->end(); 
?>