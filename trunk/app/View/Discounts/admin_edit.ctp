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

	echo $this->Form->create('Discount', array('id' => 'contentform', 'action' => '/discounts/admin_edit/', 'url' => '/discounts/admin_edit/'));
	echo $this->Form->inputs(array(
					'legend' => null,
					'fieldset' => __('Discount Details'),
				   'ContentProductPrice.id' => array(
				   		'type' => 'hidden'
	               ),
                                    'ContentProductPrice.content_product_id' => array(
				   		'type' => 'hidden'
	               ),
                                   'ContentProductPrice.quantity' => array(
				   		'label' => __('Quantity')
	               ),
				   'ContentProductPrice.price' => array(
   				   		'label' => __('Price')
	               )				     				   	   																									
			));
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn', 'type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	echo $this->Admin->ShowPageHeaderEnd(); 
?>