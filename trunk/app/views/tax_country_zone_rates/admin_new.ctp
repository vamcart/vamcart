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
?>
<?php echo $javascript->codeBlock('
	$(document).ready(function(){

		$("select#TaxCountryZoneRateCountryId").change(function () {
			$("div#zones_by_country").load("'. BASE . '/tax_country_zone_rates/list_zones_by_country/"+$("select#TaxCountryZoneRateCountryId").val());
		})

	});
', array('allowCache'=>false,'safe'=>false,'inline'=>false)); ?>
<?php

echo $form->create('TaxCountryZoneRate', array('id' => 'contentform', 'action' => '/tax_country_zone_rates/admin_new/' . $tax['Tax']['id'], 'url' => '/tax_country_zone_rates/admin_new/' . $tax['Tax']['id']));
	
	echo $form->inputs(array(
				'legend' => null,
				'fieldset' => __('Tax Zone Rates Details', true),
				'TaxCountryZoneRate.tax_id' => array(
					'type' => 'hidden',
					'value' => $tax['Tax']['id']
	              ),
				'TaxCountryZoneRate.country_id' => array(
			   		'label' => __('Country', true),
					'type' => 'select',
					'options' => $country_list,
					'selected' => '223'
	              )));
				  
	echo '<div id="zones_by_country">';
		echo $this->requestAction('/tax_country_zone_rates/list_zones_by_country/223', array('return'));	
	echo '</div>';

	echo $form->inputs(array(
					'legend' => null,
					'TaxCountryZoneRate.rate' => array(
			   	'label' => __('Tax Rate', true),
					'type' => 'text'
				)));
	
	
echo $form->submit( __('Submit', true), array('name' => 'submit', 'id' => 'submitbutton')) . $form->submit( __('Cancel', true), array('name' => 'cancel'));
echo '<div class="clear"></div>';
	
echo $form->end();
	
?>