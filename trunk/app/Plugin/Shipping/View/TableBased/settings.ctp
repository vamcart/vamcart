<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo '<p>' .__('Table based shipping can be set to work off of number of products in cart, weight of products, or total price of products. In the textarea below specify value to cost pairs with a colon followed by a comma. Example: 0:1.00,1:2.50,2:3.00. Units of measure must be integers.') . '</p>';

$types = array('weight' => __('Weight'),
			   'total' => __('Total'),
			   'products' => __('Products'));

echo $this->Form->input('key_values.table_based_type', array(
		'type' => 'select',
		'selected' => $data['ShippingMethodValue'][0]['value'],
		'label' => __('Based Off'),
		'options' => $types
	));
echo $this->Form->input('key_values.table_based_rates', array(
		'type' => 'textarea',
		'class' => 'pagesmalltextarea',
		'label' => __('Rates'),
		'type' => 'text',
		'value' => $data['ShippingMethodValue'][1]['value']
	));

?>