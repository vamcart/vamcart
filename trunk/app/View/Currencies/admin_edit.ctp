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
	echo $this->Form->inputs(array(
					'legend' => null,
					'fieldset' => __('Currency Details'),
				   'Currency.id' => array(
				   		'type' => 'hidden'
	               ),
	               'Currency.name' => array(
				   		'label' => __('Name')
	               ),
				   'Currency.code' => array(
   				   		'label' => __('Code')
	               ),	
				   'Currency.symbol_left' => array(
   				   		'label' => __('Symbol Left')
	               ),	
				   'Currency.symbol_right' => array(
   				   		'label' => __('Symbol Right')
	               ),	
				   'Currency.decimal_point' => array(
   				   		'label' => __('Decimal Point')
	               ),					   				   			
				   'Currency.thousands_point' => array(
   				   		'label' => __('Thousands Point')
	               ),	
				   'Currency.decimal_places' => array(
   				   		'label' => __('Decimal Places')
	               ),				 
				   'Currency.value' => array(
   				   		'label' => __('Value')
	               )					     				   	   																									
			));
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	echo $this->Admin->ShowPageHeaderEnd(); 
?>