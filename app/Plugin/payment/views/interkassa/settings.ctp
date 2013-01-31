<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $form->inputs(array(
	'legend' => null,
	'interkassa.interkassa_id' => array(
	'label' => __('InterKassa ID', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
	),
	
	'interkassa.interkassa_secret_key' => array(
	'label' => __('InterKassa Secret Key', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][1]['value']
	)
	
));
?>