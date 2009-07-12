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
<script language="javascript" type="text/javascript">
	function update_zone_list ()
	{
		var select_box = $('TaxCountryZoneRateCountryId');
		var country_id = select_box.options[select_box.selectedIndex].value;
		
		new Ajax.Updater('zones_by_country', '/tax_country_zone_rates/list_zones_by_country/' + country_id, {asynchronous:true});
		
	}
</script>
	
<?php

echo $form->create('TaxCountryZoneRate', array('action' => '/tax_country_zone_rates/admin_new/' . $tax['Tax']['id'], 'url' => '/tax_country_zone_rates/admin_new/' . $tax['Tax']['id']));
	
	echo '<fieldset>';
	echo $form->inputs(array(
				'TaxCountryZoneRate/tax_id' => array(
					'type' => 'hidden',
					'value' => $tax['Tax']['id']
	              ),
				'TaxCountryZoneRate/country_id' => array(
			   		'label' => __('country', true),
					'type' => 'select',
					'options' => $country_list,
					'selected' => '223',
					'onchange' => 'update_zone_list()'
	              )));
				  
	echo '<div id="zones_by_country">';
		echo $this->requestAction('/tax_country_zone_rates/list_zones_by_country/223', array('return'=>true));	
	echo '</div>';

	echo $form->inputs(array('TaxCountryZoneRate/rate' => array(
			   		'label' => __('tax_rate', true),
					'type' => 'text'
				)));
	
	echo '</fieldset>';
	
echo $form->submit( __('form_submit', true), array('name' => 'submit', 'id' => 'submitbutton')) . $form->submit( __('form_cancel', true), array('name' => 'cancel'));
echo '<div class="clearb"></div>';
	
echo $form->end();
	

?>
