<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Html->script('selectall', array('inline' => false));

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-calculator-edit');

echo $this->Form->create('TaxCountryZoneRate', array('action' => '/tax_country_zone_rates/admin_modify_selected/' . $tax['Tax']['id'], 'url' => '/tax_country_zone_rates/admin_modify_selected/' . $tax['Tax']['id']));

echo '<table class="contentTable">';

echo $this->Html->tableHeaders(array( __('Name'), __('Tax Rate'), __('Action'), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($data AS $tax_rate_zone)
{
	echo $this->Admin->TableCells(
		  array(
				$this->Html->link($tax_rate_zone['CountryZone']['name'], '/tax_country_zone_rates/admin_edit/' . $tax['Tax']['id'] . '/' . $tax_rate_zone['TaxCountryZoneRate']['id']),
				$tax_rate_zone['TaxCountryZoneRate']['rate'],
				array($this->Admin->ActionButton('edit','/tax_country_zone_rates/admin_edit/' . $tax_rate_zone['Tax']['id'] . '/' . $tax_rate_zone['TaxCountryZoneRate']['id'],__('Edit')) . $this->Admin->ActionButton('delete','/tax_country_zone_rates/admin_delete/' .  $tax_rate_zone['Tax']['id'] . '/' . $tax_rate_zone['TaxCountryZoneRate']['id'],__('Delete')), array('align'=>'center')),
				array($this->Form->checkbox('modify][', array('value' => $tax_rate_zone['TaxCountryZoneRate']['id'])), array('align'=>'center'))
		   ));
		   	
}
echo '</table>';
echo $this->Admin->EmptyResults($data);

echo $this->Admin->ActionBar(array('delete'=>__('Delete')),true,$tax['Tax']['id']);
echo $this->Form->end();

echo $this->Admin->ShowPageHeaderEnd();

?>