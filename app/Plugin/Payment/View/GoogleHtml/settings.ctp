<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
	
echo $this->Form->input('google_html.google_html_merchant_id', array(
	'label' => __('Merchant ID'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
));

?>