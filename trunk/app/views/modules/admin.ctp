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

echo $html->tableHeaders(array( __('Name', true), __('Installed', true), __('Version', true), __('Action', true)));

foreach ($modules AS $module)
{

	if($module['installed'] == 0)
	{
		$action_button = $html->link(__('Install',true),'/module_' . $module['alias'] . '/setup/install/');
	}
	elseif((isset($module['installed_version']))&&($module['installed_version'] < $module['version']))
	{
		$action_button = $html->link(__('Upgrade',true),'/module_' . $module['alias'] . '/setup/upgrade/',null,__('Are you sure?', true));
	}
	else
	{
		$action_button = $html->link(__('Uninstall',true),'/module_' . $module['alias'] . '/setup/uninstall/',null,__('Are you sure?', true));
	}

	echo $admin->TableCells(
		  array(
		  	$html->link($module['name'],'/module_' . $module['alias'] . '/admin/admin_help'),
			($module['installed'] == 1?$html->image('admin/icons/true.png'):$html->image('admin/icons/false.png')),
			$module['version'],
			$action_button	
		   ));
	
}

echo '</table>';

?>