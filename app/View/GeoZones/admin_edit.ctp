<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'modified.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'edit.png');

	echo $this->Form->create('Geozone', array('id' => 'contentform', 'action' => '/geo_zones/admin_edit/', 'url' => '/geo_zones/admin_edit/'));
	
	echo $this->Form->inputs(array(
					'legend' => null,
					'fieldset' => __('Geo Zone Details'),
					'GeoZone.id' => array(
						'type' => 'hidden'
			),
			'GeoZone.name' => array(
						'label' => __('Name')
			),
			'GeoZone.description' => array(
						'label' => __('Description')
			)
	));
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	echo $this->Admin->ShowPageHeaderEnd(); 
?>