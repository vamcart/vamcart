<?php
/** SMS - Selling Made Simple
 * Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
 * This project's homepage is: http://sellingmadesimple.org
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * BUT withOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
**/


echo $form->create('TaxCountryZoneRate', array('action' => '/tax_country_zone_rates/admin_modify_selected/' . $tax['Tax']['id'], 'url' => '/tax_country_zone_rates/admin_modify_selected/' . $tax['Tax']['id']));

echo '<table class="pagetable" cellspacing="0">';

echo $html->tableHeaders(array( __('Name', true), __('Tax Rate', true), __('Action', true), '&nbsp;'));

foreach ($data AS $tax_rate_zone)
{
	echo $admin->TableCells(
		  array(
				$html->link($tax_rate_zone['CountryZone']['name'], '/tax_country_zone_rates/admin_edit/' . $tax['Tax']['id'] . '/' . $tax_rate_zone['TaxCountryZoneRate']['id']),
				$tax_rate_zone['TaxCountryZoneRate']['rate'],
				$admin->ActionButton('edit','/tax_country_zone_rates/admin_edit/' . $tax_rate_zone['Tax']['id'] . '/' . $tax_rate_zone['TaxCountryZoneRate']['id']) . $admin->ActionButton('delete','/tax_country_zone_rates/admin_delete/' .  $tax_rate_zone['Tax']['id'] . '/' . $tax_rate_zone['TaxCountryZoneRate']['id']),
				$form->checkbox('modify][', array('value' => $tax_rate_zone['TaxCountryZoneRate']['id']))
		   ));
		   	
}
echo '</table>';
echo $admin->EmptyResults($data);

echo $admin->ActionBar(array('delete'=>__('Delete',true)),true,$tax['Tax']['id']);
echo $form->end();

?>