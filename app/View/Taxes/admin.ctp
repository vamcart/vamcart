<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-calculator-add');

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Name'), __('Default'), __('Action'),'&nbsp;'));

foreach ($tax_data AS $tax)
{
	$set_all_bug_fix =  __('Are you sure you want to set all products to this tax class?');
	
	echo $this->Admin->TableCells(
		  array(
				$this->Html->link($tax['Tax']['name'], '/tax_country_zone_rates/admin/' . $tax['Tax']['id']),
				array($this->Admin->DefaultButton($tax['Tax']), array('align'=>'center')),
				array($this->Admin->ActionButton('edit','/taxes/admin_edit/' . $tax['Tax']['id'],__('Edit')) . $this->Admin->ActionButton('delete','/taxes/admin_delete/' . $tax['Tax']['id'],__('Delete')), array('align'=>'center')),
				array($this->Admin->linkButton(__('Set All Products'), '/taxes/admin_set_all_products/' . $tax['Tax']['id'], 'cus-table-add', array('escape' => false, 'class' => 'btn'),$set_all_bug_fix), array('align'=>'center'))
		   ));
		   	
}
echo '</table>';

echo $this->Admin->EmptyResults($tax_data);

echo $this->Admin->CreateNewLink();

echo $this->Admin->ShowPageHeaderEnd();

?>