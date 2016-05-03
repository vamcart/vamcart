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

	echo $this->Admin->ShowPageHeaderStart($title_for_layout, 'cus-application-edit');

	echo $this->Form->create('ContentProductPrice', array('id' => 'contentform', 'url' => '/discounts/admin_edit/'));
	echo $this->Form->input('ContentProductPrice.id', 
						array(
				   		'type' => 'hidden'
	               ));
	echo $this->Form->input('ContentProductPrice.content_product_id', 
						array(
				   		'type' => 'hidden'
	               ));
	echo $this->Form->input('ContentProductPrice.quantity', 
						array(
				   		'label' => __('Quantity')
	               ));
	echo $this->Form->input('ContentProductPrice.price', 
						array(
   				   		'label' => __('Price')
	               ));
	echo '<div class="clear"></div>';
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo $this->Form->end();
	echo $this->Admin->ShowPageHeaderEnd(); 
?>