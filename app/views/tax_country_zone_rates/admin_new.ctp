<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
?>
<?php echo $html->scriptBlock('
	$(document).ready(function(){

		$("select#TaxCountryZoneRateCountryId").change(function () {
			$("div#zones_by_country").load("'. BASE . '/tax_country_zone_rates/list_zones_by_country/"+$("select#TaxCountryZoneRateCountryId").val());
		})

	});
', array('allowCache'=>false,'safe'=>false,'inline'=>false)); ?>
<?php

$html->script(array(
	'modified.js',
	'focus-first-input.js'
), array('inline' => false));

echo $admin->ShowPageHeaderStart($current_crumb, 'new.png');

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
	
	
echo $admin->formButton(__('Submit', true), 'submit.png', array('type' => 'submit', 'name' => 'submit',  'id' => 'submitbutton')) . $admin->formButton(__('Cancel', true), 'cancel.png', array('type' => 'submit', 'name' => 'cancelbutton'));
echo '<div class="clear"></div>';
	
echo $form->end();

echo $admin->ShowPageHeaderEnd();
	
?>