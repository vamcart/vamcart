<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Form->input('qiwirest.qiwi_id', array(
	'label' => __('Qiwi ID'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
	));
	
echo $this->Form->input('qiwirest.qiwi_api_id', array(
	'label' => __('Qiwi API ID'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][1]['value']
	));

echo $this->Form->input('qiwirest.qiwi_notify_pass', array(
	'label' => __('Qiwi Notify Password'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][2]['value']
	));

?>