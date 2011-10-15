<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$html->script(array(
	'modified.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $admin->ShowPageHeaderStart($current_crumb, 'edit.png');

	echo $form->create('PaymentMethod', array('id' => 'contentform', 'action' => '/payment_methods/admin_edit/' . $data['PaymentMethod']['id'], 'url' => '/payment_methods/admin_edit/' . $data['PaymentMethod']['id']));
	echo $form->inputs(array(
					'legend' => null,
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
	
	echo $admin->formButton(__('Submit', true), 'submit.png', array('type' => 'submit', 'name' => 'submit')) . $admin->formButton(__('Cancel', true), 'cancel.png', array('type' => 'reset', 'name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	
	echo $admin->ShowPageHeaderEnd();
	
	?>