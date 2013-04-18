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
		$action_button = $this->Admin->linkButton(__('Install'),'/module_' . $module['alias'] . '/setup/install/','cus-add', array('escape' => false, 'class' => 'btn'));
	}
	elseif((isset($module['installed_version']))&&($module['installed_version'] < $module['version']))
	{
		$action_button = $this->Admin->linkButton(__('Upgrade'),'/module_' . $module['alias'] . '/setup/upgrade/','cus-cog', array('escape' => false, 'class' => 'btn'),__('Are you sure?'));
	}
	else
	{
		$action_button = $this->Admin->linkButton(__('Uninstall'),'/module_' . $module['alias'] . '/setup/uninstall/','cus-cancel', array('escape' => false, 'class' => 'btn'),__('Are you sure?'));
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

echo $this->Admin->linkButton(__('Add module'), '/modules/admin_add/', 'cus-plugin-add', array('escape' => false, 'class' => 'btn'));

echo $this->Admin->ShowPageHeaderEnd();

?>