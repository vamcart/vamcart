<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
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
	'admin/modified.js',
	'admin/focus-first-input.js'
), array('inline' => false));

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-add');

echo $this->Form->create('TaxCountryZoneRate', array('id' => 'contentform', 'url' => '/tax_country_zone_rates/admin_new/' . $tax['Tax']['id']));
	
	echo $this->Form->input('TaxCountryZoneRate.tax_id', 
					array(
						'type' => 'hidden',
						'value' => $tax['Tax']['id']
	              ));
	              
	echo $this->Form->input('TaxCountryZoneRate.country_id', 
					array(
			   		'label' => __('Country'),
						'type' => 'select',
						'options' => $country_list,
						'selected' => '223'
	              ));
				  
	echo '<div id="zones_by_country">';
		echo $this->requestAction('/tax_country_zone_rates/list_zones_by_country/223', array('return'));	
	echo '</div>';

	echo $this->Form->input('TaxCountryZoneRate.rate', 
					array(
			   		'label' => __('Tax Rate'),
						'type' => 'text'
				));
	
	
echo '<div class="clear"></div>';
echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit',  'id' => 'submitbutton')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'cancelbutton'));
	
echo $this->Form->end();

echo $this->Admin->ShowPageHeaderEnd();
	
?>