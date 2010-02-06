<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009-2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$combine->js(array(
	'modified.js',
	'jquery/jquery.min.js',
	'focus-first-input.js'
));

	echo $admin->ShowPageHeaderStart($current_crumb, 'edit.png');

        echo $form->create('TaxCountryZoneRate', array('id' => 'contentform', 'action' => '/tax_country_zone_rates/admin_edit/' . $data['Tax']['id'] . '/' . $data['TaxCountryZoneRate']['id'], 'url' => '/tax_country_zone_rates/admin_edit/' . $data['Tax']['id'] . '/' . $data['TaxCountryZoneRate']['id']));
	echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Tax Zone Rates Details', true),
				   'TaxCountryZoneRate.id' => array(
				   		'type' => 'hidden',
						'value' => $data['TaxCountryZoneRate']['id']
	               ),
	               'TaxCountryZoneRate.rate' => array(
				   		'label' => __('Tax Rate', true),
   						'value' => $data['TaxCountryZoneRate']['rate']
	               )		     				   	   																									
			));
	echo $form->submit( __('Submit', true), array('name' => 'submit')) . $form->submit( __('Cancel', true), array('name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	echo $admin->ShowPageHeaderEnd(); 
?>