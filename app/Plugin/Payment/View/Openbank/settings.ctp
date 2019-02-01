<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Form->input('openbank.partnerid', array(
	'label' => __('partnerId'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
	));

echo $this->Form->input('openbank.serviceid', array(
	'label' => __('serviceId'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][1]['value']
	));
	
?>