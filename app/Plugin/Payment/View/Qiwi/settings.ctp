<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Form->input('qiwi.qiwi_id', array(
	'label' => __('Qiwi ID'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
	));
	
echo $this->Form->input('qiwi.qiwi_secret_key', array(
	'label' => __('Qiwi Password'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][1]['value']
	));
?>