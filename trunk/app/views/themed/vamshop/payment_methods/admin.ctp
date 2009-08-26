<?php
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.com
   http://vamshop.ru
   Copyright 2009 VaM Shop
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo '<table class="contentTable">';

echo $html->tableHeaders(array( __('Name', true), __('Active', true), __('Version', true), __('Action', true)));

foreach ($modules AS $module)
{

	if($module['installed'] == 0)
	{
		$action_button = $html->link(__('Install',true),'/payment_methods/install/' . $module['alias']);
	}
	elseif((isset($module['installed_version']))&&($module['installed_version'] < $module['version']))
	{
		$action_button = $html->link(__('Upgrade',true),'/payment_methods/upgrade/' . $module['alias'],null,__('Are you sure?', true));
	}
	else
	{
		$action_button = $html->link(__('Uninstall',true),'/payment_methods/uninstall/' . $module['alias'],null,__('Are you sure?', true));
	}

	echo $admin->TableCells(
		  array(
		  	$html->link($module['name'],'/payment_methods/admin_edit/' . $module['alias']),
			($module['installed'] == 1?$html->image('admin/icons/true.png', array('alt' => __('True', true))):$html->image('admin/icons/false.png', array('alt' => __('False', true)))),
			$module['version'],
			$action_button	
		   ));
	
}

echo '</table>';

?>