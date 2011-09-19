<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$html->script(array(
	'modified.js',
	'jquery/jquery.min.js',
	'focus-first-input.js'
), array('inline' => false));

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
	echo $admin->formButton(__('Submit', true), 'submit.png', array('type' => 'submit', 'name' => 'submit')) . $admin->formButton(__('Cancel', true), 'cancel.png', array('type' => 'reset', 'name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	echo $admin->ShowPageHeaderEnd(); 
?>