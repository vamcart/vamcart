<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Form->input('paypal.paypal_email', array(
	'label' => __('Paypal Email'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
));

?>