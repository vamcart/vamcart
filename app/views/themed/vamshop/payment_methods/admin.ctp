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

echo $html->tableHeaders(array( __('Name', true), __('Code', true), __('Active', true), __('Default', true), __('Sort Order', true), __('Action', true)));

foreach ($modules AS $module)
{

	if($module['installed'] == 0)
	{
		$action_button = $html->link(__('Install',true),'/payment/' . $module['alias'] . '/install/');
	}
	else
	{
		$action_button = $html->link(__('Uninstall',true),'/payment/' . $module['alias'] . '/uninstall/',null,__('Are you sure?', true));
	}

	echo $admin->TableCells(
		  array(
		  	(isset($module['id'])?$html->link($module['name'],'/payment_methods/admin_edit/' . $module['id']):$module['name']),
		  	$module['alias'],
			($module['installed'] == 1?$html->image('admin/icons/true.png', array('alt' => __('True', true))):$html->image('admin/icons/false.png', array('alt' => __('False', true)))),
			(isset($module['id'])?$admin->DefaultButton($module):''),
		  	(isset($module['order'])?$module['order']:''),
			$action_button	
		   ));
	
}

echo '</table>';

?>