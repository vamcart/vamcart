<?php
/** SMS - Selling Made Simple
 * Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
 * This project's homepage is: http://sellingmadesimple.orgs
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


echo $form->create('UserTag', array('action' => '/UserTags/admin_modify_selected/', 'url' => '/UserTags/admin_modify_selected/'));

echo '<table class="pagetable" cellspacing="0">';
echo $html->tableHeaders(array( __('Title', true), __('Call (Template Placeholder)', true), __('Action', true), '&nbsp;'));

foreach ($user_tags AS $UserTag)
{
	echo $admin->TableCells(
		  array(
			$html->link($UserTag['UserTag']['name'],'/user_tags/admin_edit/' . $UserTag['UserTag']['id']),
			'{user_tag alias=\'' . $UserTag['UserTag']['alias'] . '\'}',
			$admin->ActionButton('edit','/user_tags/admin_edit/' . $UserTag['UserTag']['id']) . $admin->ActionButton('delete','/user_tags/admin_delete/' . $UserTag['UserTag']['id']),
			$form->checkbox('modify][', array('value' => $UserTag['UserTag']['id']))
		   ));
}
echo '</table>';

echo $admin->ActionBar(array('delete'));
echo $form->end(); 
?>