<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $form->inputs(array(
	'legend' => null,
	'qiwi.qiwi_id' => array(
	'label' => __('Qiwi ID', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
	),
	
	'qiwi.qiwi_secret_key' => array(
	'label' => __('Qiwi Password', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][1]['value']
	)
	
));
?>