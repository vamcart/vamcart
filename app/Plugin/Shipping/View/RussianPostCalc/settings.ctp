<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Form->input('key_values.api_key', array(
		'label' => __('API Key'), 
		'type' => 'text',
		'value' => $data['ShippingMethodValue'][0]['value']
	));

echo $this->Form->input('key_values.api_password', array(
		'label' => __('API Password'), 
		'type' => 'text',
		'value' => $data['ShippingMethodValue'][1]['value']
	));

echo $this->Form->input('key_values.store_zip_code', array(
		'label' => __('Store Zip Code'), 
		'type' => 'text',
		'value' => $data['ShippingMethodValue'][2]['value']
	));

?>