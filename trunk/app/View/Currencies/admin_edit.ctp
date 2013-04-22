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

	echo $this->Form->create('Currency', array('id' => 'contentform', 'action' => '/currencies/admin_edit/', 'url' => '/currencies/admin_edit/'));
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
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	echo $this->Admin->ShowPageHeaderEnd(); 
?>