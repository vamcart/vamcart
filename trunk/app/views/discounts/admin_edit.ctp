<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2011 by David Lednik (david.lednik@gmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$html->script(array(
	'modified.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $admin->ShowPageHeaderStart($current_crumb, 'edit.png');

	echo $form->create('Discount', array('id' => 'contentform', 'action' => '/discounts/admin_edit/', 'url' => '/discounts/admin_edit/'));
	echo $form->inputs(array(
					'legend' => null,
					'fieldset' => __('Discount Details', true),
				   'ContentProductPrice.id' => array(
				   		'type' => 'hidden'
	               ),
                                    'ContentProductPrice.content_product_id' => array(
				   		'type' => 'hidden'
	               ),
                                   'ContentProductPrice.quantity' => array(
				   		'label' => __('Quantity', true)
	               ),
				   'ContentProductPrice.price' => array(
   				   		'label' => __('Price', true)
	               )				     				   	   																									
			));
	echo $admin->formButton(__('Submit', true), 'submit.png', array('type' => 'submit', 'name' => 'submit')) . $admin->formButton(__('Cancel', true), 'cancel.png', array('type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $form->end();
	echo $admin->ShowPageHeaderEnd(); 
?>