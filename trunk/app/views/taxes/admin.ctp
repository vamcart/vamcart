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

echo $html->tableHeaders(array( __('Name', true), __('Default', true), __('Action', true),'&nbsp;'));

foreach ($tax_data AS $tax)
{
	$set_all_bug_fix =  __('Are you sure you want to set all products to this tax class?',true);
	
	echo $admin->TableCells(
		  array(
				$html->link($tax['Tax']['name'], '/tax_country_zone_rates/admin/' . $tax['Tax']['id']),
				$admin->DefaultButton($tax['Tax']),
				$admin->ActionButton('edit','/taxes/admin_edit/' . $tax['Tax']['id'],__('Edit', true)) . $admin->ActionButton('delete','/taxes/admin_delete/' . $tax['Tax']['id'],__('Delete', true)),
				$html->link(__('Set All Products',true), '/taxes/admin_set_all_products/' . $tax['Tax']['id'], null,$set_all_bug_fix)
		   ));
		   	
}
echo '</table>';

echo $admin->EmptyResults($tax_data);

echo $admin->CreateNewLink();

?>