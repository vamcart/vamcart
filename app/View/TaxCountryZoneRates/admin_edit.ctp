<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'modified.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-application-edit');

        echo $this->Form->create('TaxCountryZoneRate', array('id' => 'contentform', 'action' => '/tax_country_zone_rates/admin_edit/' . $data['Tax']['id'] . '/' . $data['TaxCountryZoneRate']['id'], 'url' => '/tax_country_zone_rates/admin_edit/' . $data['Tax']['id'] . '/' . $data['TaxCountryZoneRate']['id']));
	echo $this->Form->input('TaxCountryZoneRate.id', 
						array(
				   		'type' => 'hidden',
							'value' => $data['TaxCountryZoneRate']['id']
	               ));
	echo $this->Form->input('TaxCountryZoneRate.rate', 
						array(
				   		'label' => __('Tax Rate'),
   						'value' => $data['TaxCountryZoneRate']['rate']
	               ));
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	echo $this->Admin->ShowPageHeaderEnd(); 
?>