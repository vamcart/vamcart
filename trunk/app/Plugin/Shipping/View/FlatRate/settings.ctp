<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Form->inputs(array(
	'legend' => null,
	'key_values.cost' => array(
		'label' => __('Shipping Cost'), 
		'type' => 'text',
		'value' => $data['ShippingMethodValue'][0]['value']
	)
));

?>