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

echo $form->create('Currency', array('action' => '/currencies/admin_modify_selected/', 'url' => '/currencies/admin_modify_selected/'));

echo '<table class="contentTable">';

echo $html->tableHeaders(array( __('Currency', true), __('Code', true), __('Active', true), __('Default', true), __('Action', true), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($currency_data AS $currency)
{
	echo $admin->TableCells(
		  array(
				$html->link($currency['Currency']['name'], '/currencies/admin_edit/' . $currency['Currency']['id']),
				$currency['Currency']['code'],
				$ajax->link(($currency['Currency']['active'] == 1?$html->image('admin/icons/true.png', array('alt' => __('True', true))):$html->image('admin/icons/false.png', array('alt' => __('False', true)))), 'null', $options = array('url' => '/currencies/admin_change_active_status/' . $currency['Currency']['id'], 'update' => 'content'), null, false),
				$admin->DefaultButton($currency['Currency']),
				$admin->ActionButton('edit','/currencies/admin_edit/' . $currency['Currency']['id'],__('Edit', true)) . $admin->ActionButton('delete','/currencies/admin_delete/' . $currency['Currency']['id'],__('Delete', true)),
				array($form->checkbox('modify][', array('value' => $currency['Currency']['id'])), array('align'=>'center'))
		   ));
		   	
}

echo '</table>';

echo $admin->ActionBar(array('activate'=>__('Activate',true),'deactivate'=>__('Deactivate',true),'delete'=>__('Delete',true)));

?>