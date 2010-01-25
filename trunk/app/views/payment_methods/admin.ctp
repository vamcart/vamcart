<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009-2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo $javascript->link('jquery/jquery.min', false);

echo $admin->ShowPageHeaderStart($current_crumb, 'payment-methods.png');

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
			array(($module['installed'] == 1?$html->image('admin/icons/true.png', array('alt' => __('True', true))):$html->image('admin/icons/false.png', array('alt' => __('False', true)))), array('align'=>'center')),
			array((isset($module['id'])?$admin->DefaultButton($module):''), array('align'=>'center')),
		  	array((isset($module['order'])?$module['order']:''), array('align'=>'center')),
			array($action_button, array('align'=>'center'))	
		   ));
	
}

echo '</table>';

echo $admin->ShowPageHeaderEnd();

?>