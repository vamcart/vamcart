<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$html->script(array(
	'modified.js',
	'jquery/jquery.min.js',
	'focus-first-input.js'
), array('inline' => false));

	echo $admin->ShowPageHeaderStart($current_crumb, 'edit.png');

        echo $form->create('ShippingMethod', array('id' => 'contentform', 'name' => 'contentform', 'action' => '/shipping_methods/admin_edit/'.$data['ShippingMethod']['id'], 'url' => '/shipping_methods/admin_edit/'.$data['ShippingMethod']['id']));
		echo $form->inputs(array(
				'legend' => null,
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
	
	echo $admin->formButton(__('Submit', true), 'submit.png', array('type' => 'submit', 'name' => 'submit',  'id' => 'submit')) . $admin->formButton(__('Cancel', true), 'cancel.png', array('type' => 'reset', 'name' => 'cancel'));
	echo '<div class="clear"></div>';
	echo $form->end();
	
	echo $admin->ShowPageHeaderEnd();
	
?>