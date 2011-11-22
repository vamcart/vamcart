<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
	
echo $form->inputs(array(
	'legend' => null,
	'google_html.google_html_merchant_id' => array(
	'label' => __('Merchant ID', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
)));

?>