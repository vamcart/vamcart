<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Form->input('paypal.paypal_email', array(
	'label' => __('Paypal Email'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
));

?>