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
echo $html->tableHeaders(array( __('Title', true), __('Call (Template Placeholder)', true),  __('Action', true)));

foreach ($micro_templates AS $micro_template)
{
	echo $admin->TableCells(
		  array(
			$html->link($micro_template['MicroTemplate']['alias'],'/micro_templates/admin_edit/' . $micro_template['MicroTemplate']['id']),
			'{' . $micro_template['MicroTemplate']['tag_name'] . ' template=\'' . $micro_template['MicroTemplate']['alias'] . '\'}',
			$admin->ActionButton('edit','/micro_templates/admin_edit/' . $micro_template['MicroTemplate']['id'],__('Edit', true)) . $admin->ActionButton('delete','/micro_templates/admin_delete/' . $micro_template['MicroTemplate']['id'],__('Delete', true))
		   ));
}
echo '</table>';
echo $admin->CreateNewLink();
?>