<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Form->input('liqpay.liqpay_id', array(
	'label' => __('LiqPay ID'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
	));
	
echo $this->Form->input('liqpay.liqpay_secret_key', array(
	'label' => __('LiqPay Secret Key'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][1]['value']
	));
?>