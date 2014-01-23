<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
	
echo $this->Form->input('googlehtml.google_html_merchant_id', array(
	'label' => __('Merchant ID'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
));

?>