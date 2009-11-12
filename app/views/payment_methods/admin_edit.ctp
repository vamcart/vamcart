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

	echo $form->create('PaymentMethod', array('id' => 'contentform', 'action' => '/payment_methods/admin_edit/' . $data['PaymentMethod']['id'], 'url' => '/payment_methods/admin_edit/' . $data['PaymentMethod']['id']));
	echo $form->inputs(array(
					'fieldset' => __('Payment Method Details', true),
				   'PaymentMethod.id' => array(
				   		'type' => 'hidden',
						'value' => $data['PaymentMethod']['id']
	               ),
	               'PaymentMethod.name' => array(
				   		'label' => __('Name', true),
   						'value' => $data['PaymentMethod']['name']
	               ),				     				   	   																									
	               'PaymentMethod.order' => array(
				   		'label' => __('Sort Order', true),
   						'value' => $data['PaymentMethod']['order']
	               ),				     				   	   																									
	               'PaymentMethod.order_status_id' => array(
							'type' => 'select',
							'label' => __('Order Status', true),
							'options' => $order_status_list,
							'selected' => $current_order_status
	               )				     				   	   																									
			));
	
	echo $this->requestAction( '/payment/'.$data['PaymentMethod']['alias'].'/settings/', array('return'));	
	
	echo $form->submit( __('Submit', true), array('name' => 'submit')) . $form->submit( __('Cancel', true), array('name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	?>
</div>