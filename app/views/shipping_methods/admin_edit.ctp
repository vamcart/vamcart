<?php
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.com
   http://vamshop.ru
   Copyright 2009 VaM Shop
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

	echo $form->create('ShippingMethod', array('id' => 'contentform', 'name' => 'contentform', 'action' => '/shipping_methods/admin_edit/'.$data['ShippingMethod']['id'], 'url' => '/shipping_methods/admin_edit/'.$data['ShippingMethod']['id']));
		echo $form->inputs(array(
				'fieldset' => __('Shipping Method Details', true),
				'ShippingMethod/id' => array(
					'type' => 'hidden',
					'value' => $data['ShippingMethod']['id']
					),
				'ShippingMethod/name' => array(
					'type' => 'text',
					'label' => __('Name', true),
					'value' => $data['ShippingMethod']['name']
					),					
	               ));
				  
	echo $this->requestAction( '/shipping/admin/edit/' . $data['ShippingMethod']['code'], array('return'=>true));	
	
	echo $form->submit( __('Submit', true), array('name' => 'submit', 'id' => 'submit')) . $form->submit( __('Cancel', true), array('name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	?>
</div>