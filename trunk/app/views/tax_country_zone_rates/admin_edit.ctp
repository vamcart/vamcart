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


	echo $form->create('TaxCountryZoneRate', array('action' => '/tax_country_zone_rates/admin_edit/' . $data['Tax']['id'] . '/' . $data['TaxCountryZoneRate']['id'], 'url' => '/tax_country_zone_rates/admin_edit/' . $data['Tax']['id'] . '/' . $data['TaxCountryZoneRate']['id']));
	echo $form->inputs(array(
					'fieldset' => __('Tax Zone Rates Details', true),
				   'TaxCountryZoneRate/id' => array(
				   		'type' => 'hidden',
						'value' => $data['TaxCountryZoneRate']['id']
	               ),
	               'TaxCountryZoneRate/rate' => array(
				   		'label' => __('Tax Rate', true),
   						'value' => $data['TaxCountryZoneRate']['rate']
	               )		     				   	   																									
			));
	echo $form->submit( __('Submit', true), array('name' => 'submit')) . $form->submit( __('Cancel', true), array('name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	?>
</div>