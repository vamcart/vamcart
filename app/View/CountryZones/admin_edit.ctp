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

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-application-edit');
	
	echo $this->Form->create('CountryZone', array('id' => 'contentform', 'action' => '/country_zones/admin_edit/' . $country_id, 'url' => '/country_zones/admin_edit/' . $country_id));
		echo $this->Form->input('CountryZone.country_id', array(
				   		'type' => 'hidden',
						'value' => $country_id
	               ));
		echo $this->Form->input('CountryZone.id', array(
				   		'type' => 'hidden'
	               ));
		echo $this->Form->input('CountryZone.name', array(
				   		'label' => __('Name')
	               ));
		echo $this->Form->input('CountryZone.code', array(
				   		'label' => __('Code')
	               ));		   	   																									
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	
	echo $this->Admin->ShowPageHeaderEnd();
	
	?>