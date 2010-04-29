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

$html->script(array(
	'jquery/jquery.min.js',
	'selectall.js'
), array('inline' => false));

echo $admin->ShowPageHeaderStart($current_crumb, 'currencies.png');

echo $form->create('Currency', array('action' => '/currencies/admin_modify_selected/', 'url' => '/currencies/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $html->tableHeaders(array( __('Currency', true), __('Code', true), __('Active', true), __('Default', true), __('Action', true), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($currency_data AS $currency)
{
	echo $admin->TableCells(
		  array(
				$html->link($currency['Currency']['name'], '/currencies/admin_edit/' . $currency['Currency']['id']),
				array($currency['Currency']['code'], array('align'=>'center')),
				array($ajax->link(($currency['Currency']['active'] == 1?$html->image('admin/icons/true.png', array('alt' => __('True', true))):$html->image('admin/icons/false.png', array('alt' => __('False', true)))), 'null', $options = array('escape' => false, 'url' => '/currencies/admin_change_active_status/' . $currency['Currency']['id'], 'update' => 'content'), null, false), array('align'=>'center')),
				array($admin->DefaultButton($currency['Currency']), array('align'=>'center')),
				array($admin->ActionButton('edit','/currencies/admin_edit/' . $currency['Currency']['id'],__('Edit', true)) . $admin->ActionButton('delete','/currencies/admin_delete/' . $currency['Currency']['id'],__('Delete', true)), array('align'=>'center')),
				array($form->checkbox('modify][', array('value' => $currency['Currency']['id'])), array('align'=>'center'))
		   ));
		   	
}

echo '</table>';

echo $admin->ActionBar(array('activate'=>__('Activate',true),'deactivate'=>__('Deactivate',true),'delete'=>__('Delete',true)));

echo $admin->ShowPageHeaderEnd();

?>