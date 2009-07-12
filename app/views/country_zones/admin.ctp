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


echo '<table class="pagetable" cellspacing="0">';

echo $html->tableHeaders(array( __('title', true), __('code', true), __('action', true)));

foreach ($zones AS $zone)
{
	echo $admin->TableCells(
		  array(
			$html->link($zone['CountryZone']['name'],'/country_zones/admin_edit/' . $country['Country']['id'] . '/' . $zone['CountryZone']['id']),
			$zone['CountryZone']['code'],
			$admin->ActionButton('edit','/countries/admin_edit/' . $country['Country']['id'] . '/' . $zone['CountryZone']['id']) . $admin->ActionButton('delete','/country_zones/admin_delete/' . $country['Country']['id'] . '/' . $zone['CountryZone']['id'])
		   ));
}
echo '</table>';

//echo $admin->ActionBar(array('delete'));
echo $form->end();
echo $admin->CreateNewLink($country['Country']['id']);
?>