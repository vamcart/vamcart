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

echo '<table class="contentTable">';

echo $html->tableHeaders(array( __('Title', true), __('Code', true), __('Action', true)));

foreach ($zones AS $zone)
{
	echo $admin->TableCells(
		  array(
			$html->link(__($zone['CountryZone']['name'],true),'/country_zones/admin_edit/' . $country['Country']['id'] . '/' . $zone['CountryZone']['id']),
			$zone['CountryZone']['code'],
			array($admin->ActionButton('edit','/countries/admin_edit/' . $country['Country']['id'] . '/' . $zone['CountryZone']['id'],__('Edit', true)) . $admin->ActionButton('delete','/country_zones/admin_delete/' . $country['Country']['id'] . '/' . $zone['CountryZone']['id'],__('Delete', true)), array('align'=>'center'))
		   ));
}
echo '</table>';

//echo $admin->ActionBar(array('delete'=>__('Delete',true)));
echo $form->end();
echo $admin->CreateNewLink($country['Country']['id']);
?>