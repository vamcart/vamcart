<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo $html->script('jquery/jquery.min', array('inline' => false));

echo $admin->ShowPageHeaderStart($current_crumb, 'payment-methods.png');

echo '<table class="contentTable">';

echo $html->tableHeaders(array( __('Name', true), __('Code', true), __('Active', true), __('Default', true), __('Sort Order', true), __('Action', true)));

foreach ($modules AS $module)
{

	if($module['installed'] == 0)
	{
		$action_button = $admin->linkButton(__('Install',true),'/payment/' . $module['alias'] . '/install/','install.png',array('escape' => false, 'class' => 'button'));
	}
	else
	{
		$action_button = $admin->linkButton(__('Uninstall',true),'/payment/' . $module['alias'] . '/uninstall/','uninstall.png',array('escape' => false, 'class' => 'button'),__('Are you sure?', true));
	}

	echo $admin->TableCells(
		  array(
		  	(isset($module['id'])?$html->link($module['name'],'/payment_methods/admin_edit/' . $module['id']):$module['name']),
		  	$module['alias'],
			array(($module['installed'] == 1?$html->image('admin/icons/true.png', array('alt' => __('True', true))):$html->image('admin/icons/false.png', array('alt' => __('False', true)))), array('align'=>'center')),
			array((isset($module['id'])?$admin->DefaultButton($module):''), array('align'=>'center')),
		  	array((isset($module['order'])?$module['order']:''), array('align'=>'center')),
			array($action_button, array('align'=>'center'))	
		   ));
	
}

echo '</table>';

echo $admin->linkButton(__('Add module',true), '/payment_methods/add/', 'add.png', array('escape' => false, 'class' => 'button'));

echo $admin->ShowPageHeaderEnd();

?>