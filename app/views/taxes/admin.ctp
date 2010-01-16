<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo $javascript->link('jquery/jquery.min', false);

echo '<table class="contentTable">';

echo $html->tableHeaders(array( __('Name', true), __('Default', true), __('Action', true),'&nbsp;'));

foreach ($tax_data AS $tax)
{
	$set_all_bug_fix =  __('Are you sure you want to set all products to this tax class?',true);
	
	echo $admin->TableCells(
		  array(
				$html->link($tax['Tax']['name'], '/tax_country_zone_rates/admin/' . $tax['Tax']['id']),
				array($admin->DefaultButton($tax['Tax']), array('align'=>'center')),
				array($admin->ActionButton('edit','/taxes/admin_edit/' . $tax['Tax']['id'],__('Edit', true)) . $admin->ActionButton('delete','/taxes/admin_delete/' . $tax['Tax']['id'],__('Delete', true)), array('align'=>'center')),
				array($html->link(__('Set All Products',true), '/taxes/admin_set_all_products/' . $tax['Tax']['id'], null,$set_all_bug_fix), array('align'=>'center'))
		   ));
		   	
}
echo '</table>';

echo $admin->EmptyResults($tax_data);

echo $admin->CreateNewLink();

?>