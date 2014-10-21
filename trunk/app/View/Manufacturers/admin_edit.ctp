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

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-cog-edit');

	echo $this->Form->create('Manufacturer', array('id' => 'contentform', 'action' => '/manufacturers/admin_edit/', 'url' => '/manufacturers/admin_edit/'));
	echo $this->Form->input('Manufacturer.id', 
						array(
				   		'type' => 'hidden'
	               ));
	echo $this->Form->input('Manufacturer.name', 
						array(
				   		'label' => __('Name')
	               ));
	echo $this->Form->input('Manufacturer.alias', 
						array(
   				   	'label' => __('Alias')
	               ));
	echo $this->Form->input('Manufacturer.order', 
						array(
   				   	'label' => __('Sort Order')
	               ));
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	echo $this->Admin->ShowPageHeaderEnd(); 
?>