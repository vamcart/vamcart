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

echo $html->tableHeaders(array( __('Name', true), __('Code', true), __('Active', true), __('Default', true), __('Action', true)));

foreach ($shipping_method_data AS $ShippingMethod)
{
	echo $admin->TableCells(
		  array(
				$html->link($ShippingMethod['ShippingMethod']['name'], '/shipping_methods/admin_edit/' . $ShippingMethod['ShippingMethod']['id']),
				$ShippingMethod['ShippingMethod']['code'],
				$ajax->link(($ShippingMethod['ShippingMethod']['active'] == 1?$html->image('admin/icons/true.png', array('alt' => __('True', true))):$html->image('admin/icons/false.png', array('alt' => __('False', true)))), 'null', $options = array('url' => '/shipping_methods/admin_change_active_status/' . $ShippingMethod['ShippingMethod']['id'], 'update' => 'content'), null, false),
				$admin->DefaultButton($ShippingMethod['ShippingMethod']),
				$admin->ActionButton('edit','/shipping_methods/admin_edit/' . $ShippingMethod['ShippingMethod']['id'],__('Edit', true))
		   ));
		   	
}

echo '</table>';

?>