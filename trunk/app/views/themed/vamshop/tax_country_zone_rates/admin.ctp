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

echo $form->create('TaxCountryZoneRate', array('action' => '/tax_country_zone_rates/admin_modify_selected/' . $tax['Tax']['id'], 'url' => '/tax_country_zone_rates/admin_modify_selected/' . $tax['Tax']['id']));

echo '<table class="contentTable">';

echo $html->tableHeaders(array( __('Name', true), __('Tax Rate', true), __('Action', true), '<input type="checkbox" onclick="checkAll(this)" />'));

foreach ($data AS $tax_rate_zone)
{
	echo $admin->TableCells(
		  array(
				$html->link($tax_rate_zone['CountryZone']['name'], '/tax_country_zone_rates/admin_edit/' . $tax['Tax']['id'] . '/' . $tax_rate_zone['TaxCountryZoneRate']['id']),
				$tax_rate_zone['TaxCountryZoneRate']['rate'],
				$admin->ActionButton('edit','/tax_country_zone_rates/admin_edit/' . $tax_rate_zone['Tax']['id'] . '/' . $tax_rate_zone['TaxCountryZoneRate']['id'],__('Edit', true)) . $admin->ActionButton('delete','/tax_country_zone_rates/admin_delete/' .  $tax_rate_zone['Tax']['id'] . '/' . $tax_rate_zone['TaxCountryZoneRate']['id'],__('Delete', true)),
				array($form->checkbox('modify][', array('value' => $tax_rate_zone['TaxCountryZoneRate']['id'])), array('align'=>'center'))
		   ));
		   	
}
echo '</table>';
echo $admin->EmptyResults($data);

echo $admin->ActionBar(array('delete'=>__('Delete',true)),true,$tax['Tax']['id']);
echo $form->end();

?>