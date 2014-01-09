<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Form->input('key_values.per_item_amount', array(
		'label' => __('Per Item Amount'), 
		'type' => 'text',
		'value' => $data['ShippingMethodValue'][0]['value']
		));
echo $this->Form->input('key_values.per_item_handling', array(
		'label' => __('Handling'), 
		'type' => 'text',
		'value' => $data['ShippingMethodValue'][1]['value']
		));

?>