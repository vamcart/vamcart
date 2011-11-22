<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $admin->ShowPageHeaderStart($current_crumb, 'modules.png');

echo '<table class="contentTable">';

echo $html->tableHeaders(array( __('Name', true), __('Installed', true), __('Version', true), __('Action', true)));

foreach ($modules AS $module)
{

	if($module['installed'] == 0)
	{
		$action_button = $admin->linkButton(__('Install',true),'/module_' . $module['alias'] . '/setup/install/','install.png', array('escape' => false, 'class' => 'button'));
	}
	elseif((isset($module['installed_version']))&&($module['installed_version'] < $module['version']))
	{
		$action_button = $admin->linkButton(__('Upgrade',true),'/module_' . $module['alias'] . '/setup/upgrade/','upgrade.png', array('escape' => false, 'class' => 'button'),__('Are you sure?', true));
	}
	else
	{
		$action_button = $admin->linkButton(__('Uninstall',true),'/module_' . $module['alias'] . '/setup/uninstall/','uninstall.png', array('escape' => false, 'class' => 'button'),__('Are you sure?', true));
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

echo $admin->linkButton(__('Add module',true), '/modules/admin_add/', 'add.png', array('escape' => false, 'class' => 'button'));

echo $admin->ShowPageHeaderEnd();

?>