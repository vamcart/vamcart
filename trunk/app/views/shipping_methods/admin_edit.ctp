<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

	echo $form->create('ShippingMethod', array('id' => 'contentform', 'name' => 'contentform', 'action' => '/shipping_methods/admin_edit/'.$data['ShippingMethod']['id'], 'url' => '/shipping_methods/admin_edit/'.$data['ShippingMethod']['id']));
		echo $form->inputs(array(
				'fieldset' => __('Shipping Method Details', true),
				'ShippingMethod.id' => array(
					'type' => 'hidden',
					'value' => $data['ShippingMethod']['id']
					),
				'ShippingMethod.name' => array(
					'type' => 'text',
					'label' => __('Name', true),
					'value' => $data['ShippingMethod']['name']
					),					
				'ShippingMethod.order' => array(
					'type' => 'text',
					'label' => __('Sort Order', true),
					'value' => $data['ShippingMethod']['order']
					)					
	               ));
				  
	echo $this->requestAction( '/shipping/'.$data['ShippingMethod']['code'].'/settings/', array('return'));	
	
	echo $form->submit( __('Submit', true), array('name' => 'submit', 'id' => 'submit')) . $form->submit( __('Cancel', true), array('name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	?>
</div>