<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
?>
<?php echo $this->Html->scriptBlock('
	$(document).ready(function(){

		$("select#TaxCountryZoneRateCountryId").change(function () {
			$("div#zones_by_country").load("'. BASE . '/tax_country_zone_rates/list_zones_by_country/"+$("select#TaxCountryZoneRateCountryId").val());
		})

	});
', array('allowCache'=>false,'safe'=>false,'inline'=>false)); ?>
<?php

$this->Html->script(array(
	'modified.js',
	'focus-first-input.js'
), array('inline' => false));

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'new.png');

echo $this->Form->create('TaxCountryZoneRate', array('id' => 'contentform', 'action' => '/tax_country_zone_rates/admin_new/' . $tax['Tax']['id'], 'url' => '/tax_country_zone_rates/admin_new/' . $tax['Tax']['id']));
	
	echo $this->Form->inputs(array(
				'legend' => null,
				'fieldset' => __('Tax Zone Rates Details'),
				'TaxCountryZoneRate.tax_id' => array(
					'type' => 'hidden',
					'value' => $tax['Tax']['id']
	              ),
				'TaxCountryZoneRate.country_id' => array(
			   		'label' => __('Country'),
					'type' => 'select',
					'options' => $country_list,
					'selected' => '223'
	              )));
				  
	echo '<div id="zones_by_country">';
		echo $this->requestAction('/tax_country_zone_rates/list_zones_by_country/223', array('return'));	
	echo '</div>';

	echo $this->Form->inputs(array(
					'legend' => null,
					'TaxCountryZoneRate.rate' => array(
			   	'label' => __('Tax Rate'),
					'type' => 'text'
				)));
	
	
echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit',  'id' => 'submitbutton')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
echo '<div class="clear"></div>';
	
echo $this->Form->end();

echo $this->Admin->ShowPageHeaderEnd();
	
?>