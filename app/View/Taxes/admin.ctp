<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $html->script('jquery/jquery.min', array('inline' => false));

echo $admin->ShowPageHeaderStart($current_crumb, 'taxes.png');

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
				array($admin->linkButton(__('Set All Products',true), '/taxes/admin_set_all_products/' . $tax['Tax']['id'], 'set_all.png', array('escape' => false, 'class' => 'button'),$set_all_bug_fix), array('align'=>'center'))
		   ));
		   	
}
echo '</table>';

echo $admin->EmptyResults($tax_data);

echo $admin->CreateNewLink();

echo $admin->ShowPageHeaderEnd();

?>