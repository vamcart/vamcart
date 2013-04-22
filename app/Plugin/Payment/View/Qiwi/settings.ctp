<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
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