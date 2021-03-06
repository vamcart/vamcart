<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

$this->Html->script(array(
	'admin/modified.js',
	'admin/focus-first-input.js'
), array('inline' => false));

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'cus-application-edit');

        echo $this->Form->create('ShippingMethod', array('id' => 'contentform', 'name' => 'contentform', 'url' => '/shipping_methods/admin_edit/'.$data['ShippingMethod']['id']));
		echo $this->Form->input('ShippingMethod.id', 
					array(
						'type' => 'hidden',
						'value' => $data['ShippingMethod']['id']
					));
		echo $this->Form->input('ShippingMethod.name', 
					array(
						'type' => 'text',
						'label' => __('Name'),
						'value' => $data['ShippingMethod']['name']
					));					
		echo $this->Form->input('ShippingMethod.description', 
					array(
						'type' => 'textarea',
						'label' => __('Description'),
						'class' => 'pagesmalltextarea',
						'value' => $data['ShippingMethod']['description']
					));					
		echo $this->Form->input('ShippingMethod.order', 
					array(
						'type' => 'text',
						'label' => __('Sort Order'),
						'value' => $data['ShippingMethod']['order']
					));
				  
	echo $this->requestAction( '/shipping/'.$data['ShippingMethod']['code'].'/settings/', array('return'));	
	
	echo '<div class="clear"></div>';
	echo $this->Admin->formButton(__('Submit'), 'cus-tick', array('class' => 'btn btn-primary', 'type' => 'submit', 'name' => 'submit',  'id' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cus-cancel', array('class' => 'btn btn-default', 'type' => 'submit', 'name' => 'cancelbutton'));
	echo $this->Form->end();
	
	echo $this->Admin->ShowPageHeaderEnd();
	
?>