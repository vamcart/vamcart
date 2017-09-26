<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Form->input('key_values.cost', array(
		'label' => __('Shipping Cost'), 
		'type' => 'text',
		'value' => $data['ShippingMethodValue'][0]['value']
	));

?>