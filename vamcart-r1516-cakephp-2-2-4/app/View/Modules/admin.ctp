<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'modules.png');

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Name'), __('Installed'), __('Version'), __('Action')));

foreach ($modules AS $module)
{

	if($module['installed'] == 0)
	{
		$action_button = $this->Admin->linkButton(__('Install'),'/module_' . $module['alias'] . '/setup/install/','install.png', array('escape' => false, 'class' => 'button'));
	}
	elseif((isset($module['installed_version']))&&($module['installed_version'] < $module['version']))
	{
		$action_button = $this->Admin->linkButton(__('Upgrade'),'/module_' . $module['alias'] . '/setup/upgrade/','upgrade.png', array('escape' => false, 'class' => 'button'),__('Are you sure?'));
	}
	else
	{
		$action_button = $this->Admin->linkButton(__('Uninstall'),'/module_' . $module['alias'] . '/setup/uninstall/','uninstall.png', array('escape' => false, 'class' => 'button'),__('Are you sure?'));
	}

	echo $this->Admin->TableCells(
		  array(
		  	$this->Html->link($module['name'],'/module_' . $module['alias'] . '/admin/admin_help'),
			array(($module['installed'] == 1?$this->Html->image('admin/icons/true.png', array('alt' => __('True'))):$this->Html->image('admin/icons/false.png', array('alt' => __('False')))), array('align'=>'center')),
			array($module['version'], array('align'=>'center')),
			array($action_button, array('align'=>'center'))	
		   ));
	
}

echo '</table>';

echo $this->Admin->linkButton(__('Add module'), '/modules/admin_add/', 'add.png', array('escape' => false, 'class' => 'button'));

echo $this->Admin->ShowPageHeaderEnd();

?>