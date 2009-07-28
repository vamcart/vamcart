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

echo $html->tableHeaders(array( __('Name', true), __('Active', true), __('Default', true), __('Action', true)));

foreach ($payment_method_data AS $payment_method)
{
	echo $admin->TableCells(
		  array(
				$html->link($payment_method['PaymentMethod']['name'], '/payment_methods/admin_edit/' . $payment_method['PaymentMethod']['id']),
				$ajax->link(($payment_method['PaymentMethod']['active'] == 1?$html->image('admin/icons/true.png', array('alt' => __('True', true))):$html->image('admin/icons/false.png', array('alt' => __('False', true)))), 'null', $options = array('url' => '/payment_methods/admin_change_active_status/' . $payment_method['PaymentMethod']['id'], 'update' => 'content'), null, false),				
				$admin->DefaultButton($payment_method['PaymentMethod']),
				$admin->ActionButton('edit','/payment_methods/admin_edit/' . $payment_method['PaymentMethod']['id'],__('Edit', true))
		   ));
		   	
}
echo '</table>';

?>