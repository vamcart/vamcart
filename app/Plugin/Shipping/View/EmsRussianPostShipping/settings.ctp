<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Form->input('key_values.city', array(
		'label' => __('Store City'), 
		'type' => 'text',
		'value' => $data['ShippingMethodValue'][0]['value']
	));

?>