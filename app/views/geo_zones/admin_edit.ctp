<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

$html->script(array(
	'modified.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $admin->ShowPageHeaderStart($current_crumb, 'edit.png');

	echo $form->create('Geozone', array('id' => 'contentform', 'action' => '/geo_zones/admin_edit/', 'url' => '/geo_zones/admin_edit/'));
	
	echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Geo Zone Details', true),
					'GeoZone.id' => array(
						'type' => 'hidden'
			),
			'GeoZone.name' => array(
						'label' => __('Name', true)
			),
			'GeoZone.description' => array(
						'label' => __('Description', true)
			)
	));
	echo $admin->formButton(__('Submit', true), 'submit.png', array('type' => 'submit', 'name' => 'submit')) . $admin->formButton(__('Cancel', true), 'cancel.png', array('type' => 'submit', 'name' => 'cancelbutton'));
	
	echo '<div class="clear"></div>';
	echo $form->end();
	echo $admin->ShowPageHeaderEnd(); 
?>