<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Form->input('stripe.secret_key', array(
	'label' => __('Stripe Secret Key'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
	));

echo $this->Form->input('stripe.publish_key', array(
	'label' => __('Stripe Publishable Key'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][1]['value']
	));
	
?>