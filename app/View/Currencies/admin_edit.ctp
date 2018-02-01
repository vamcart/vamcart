<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'admin/modified.js',
	'admin/focus-first-input.js'
), array('inline' => false));

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-application-edit');

	echo $this->Form->create('Currency', array('id' => 'contentform', 'url' => '/currencies/admin_edit/'));
	echo $this->Form->input('Currency.id', 
						array(
				   		'type' => 'hidden'
	               ));
	echo $this->Form->input('Currency.name', 
						array(
				   		'label' => __('Name')
	               ));
	echo $this->Form->input('Currency.code', 
						array(
   				   		'label' => __('Code')
	               ));	
	echo $this->Form->input('Currency.symbol_left', 
						array(
   				   		'label' => __('Symbol Left')
	               ));	
	echo $this->Form->input('Currency.symbol_right', 
						array(
   				   		'label' => __('Symbol Right')
	               ));	
	echo $this->Form->input('Currency.decimal_point', 
						array(
   				   		'label' => __('Decimal Point')
	               ));					   				   			
	echo $this->Form->input('Currency.thousands_point', 
						array(
   				   		'label' => __('Thousands Point')
	               ));	
	echo $this->Form->input('Currency.decimal_places', 
						array(
   				   		'label' => __('Decimal Places')
	               ));				 
	echo $this->Form->input('Currency.value', 
						array(
   				   		'label' => __('Value')
	               ));
	echo '<div class="clear"></div>';
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo $this->Form->end();
	echo $this->Admin->ShowPageHeaderEnd(); 
?>