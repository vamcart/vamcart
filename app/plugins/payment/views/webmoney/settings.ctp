<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $form->inputs(array(
	'legend' => null,
	'webmoney.webmoney_purse' => array(
	'label' => __('WebMoney Purse', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
	),
	
	'webmoney.webmoney_secret_key' => array(
	'label' => __('WebMoney Secret Key', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][1]['value']
	)
	
));
?>