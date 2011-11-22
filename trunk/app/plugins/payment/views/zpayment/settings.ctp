<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $form->inputs(array(
	'legend' => null,
	'zpayment.zpayment_purse' => array(
	'label' => __('Zpayment Purse', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
	),
	
	'zpayment.zpayment_secret_key' => array(
	'label' => __('Zpayment Secret Key', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][1]['value']
	)
	
));
?>