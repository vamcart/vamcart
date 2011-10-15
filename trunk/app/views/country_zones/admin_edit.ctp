<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$html->script(array(
	'modified.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $admin->ShowPageHeaderStart($current_crumb, 'edit.png');
	
	echo $form->create('CountryZone', array('id' => 'contentform', 'action' => '/country_zones/admin_edit/' . $country_id, 'url' => '/country_zones/admin_edit/' . $country_id));
		echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Country Zone Details', true),
				   'CountryZone.country_id' => array(
				   		'type' => 'hidden',
						'value' => $country_id
	               ),
				   'CountryZone.id' => array(
				   		'type' => 'hidden'
	               ),
	               'CountryZone.name' => array(
				   		'label' => __('Name', true)
	               ),
	               'CountryZone.code' => array(
				   		'label' => __('Code', true)
	               )	     		
				   ));		   	   																									
	echo $admin->formButton(__('Submit', true), 'submit.png', array('type' => 'submit', 'name' => 'submit')) . $admin->formButton(__('Cancel', true), 'cancel.png', array('type' => 'reset', 'name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	
	echo $admin->ShowPageHeaderEnd();
	
	?>