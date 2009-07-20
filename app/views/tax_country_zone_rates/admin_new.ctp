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

?>
<?php

echo $form->create('TaxCountryZoneRate', array('id' => 'contentform', 'action' => '/tax_country_zone_rates/admin_new/' . $tax['Tax']['id'], 'url' => '/tax_country_zone_rates/admin_new/' . $tax['Tax']['id']));
	
	echo $form->inputs(array('fieldset' => __('Tax Zone Rates Details', true),
				'TaxCountryZoneRate/tax_id' => array(
					'type' => 'hidden',
					'value' => $tax['Tax']['id']
	              ),
				'TaxCountryZoneRate/country_id' => array(
			   		'label' => __('Country', true),
					'type' => 'select',
					'options' => $country_list,
					'selected' => '223'
	              )));
				  
	echo '<div id="zones_by_country">';
		echo $this->requestAction('/tax_country_zone_rates/list_zones_by_country/223', array('return'=>true));	
	echo '</div>';

	echo $form->inputs(array('TaxCountryZoneRate/rate' => array(
			   		'label' => __('Tax Rate', true),
					'type' => 'text'
				)));
	
	
echo $form->submit( __('Submit', true), array('name' => 'submit', 'id' => 'submitbutton')) . $form->submit( __('Cancel', true), array('name' => 'cancel'));
echo '<div class="clear"></div>';
	
echo $form->end();
	
?>