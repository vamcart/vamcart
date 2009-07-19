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

echo $html->tableHeaders(array(__('Title', true), __('Default', true), __('Action', true)));
foreach ($templates AS $template)
{

	if(in_array($template['Template']['id'], $user_prefs))
	{
		$arrow_link = $ajax->link($html->image('admin/icons/expand.png'), 'null', $options = array('url' => '/templates/expand_section/' . $template['Template']['id'], 'update' => 'content'), null, false);
		$collapse_style = "display:none;";
	}
	else
	{
		$collapse_style = " ";
		$arrow_link = $ajax->link($html->image('admin/icons/collapse.png'), 'null', $options = array('url' => '/templates/contract_section/' . $template['Template']['id'], 'update' => 'content'), null, false);
	}


	
	echo $admin->TableCells(
		  array(
			$arrow_link . '&nbsp;' .
			$html->link($template['Template']['name'],'/templates/admin_edit/' . $template['Template']['id'], array('style' => 'font-weight:bold;')),
			$admin->DefaultButton($template['Template']),
			$admin->ActionButton('stylesheet','/templates/admin_attach_stylesheets/' . $template['Template']['id'],__('Attach Stylesheets', true)) . $admin->ActionButton('copy','/templates/admin_copy/' . $template['Template']['id'],__('Copy', true)) . $admin->ActionButton('edit','/templates/admin_edit_details/' . $template['Template']['id'],__('Edit', true)) . $admin->ActionButton('delete','/templates/admin_delete/' . $template['Template']['id'],__('Delete', true))
		   ));
	echo '<tr id=collapse_"' . $template['Template']['id'] . '" style="' . $collapse_style . '"><td colspan="3">';
	echo '<table class="contentTable">';
	
		foreach($template['children'] AS $micro)
		{
			echo $admin->TableCells(
			  array(
					' - ' . $html->link($micro['Template']['name'],'/templates/admin_edit/' . $micro['Template']['id'])
			   ));
		}
	
	echo '</table>';
	echo '</td></tr>';
}
echo '</table>';

echo $admin->CreateNewLink(); 
echo $form->end(); 
?>