<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

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
			array(($module['installed'] == 1?$html->image('admin/icons/true.png', array('alt' => __('True', true))):$html->image('admin/icons/false.png', array('alt' => __('False', true)))), array('align'=>'center')),
			array($module['version'], array('align'=>'center')),
			array($action_button, array('align'=>'center'))	
		   ));
	
}

echo '</table>';

?>