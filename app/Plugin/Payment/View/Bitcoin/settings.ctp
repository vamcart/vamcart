<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Form->input('bitcoin.wallet', array(
	'label' => __('Bitcoin Wallet'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
	));

echo $this->Form->input('bitcoin.api_key', array(
	'label' => __('Bitcoin API Key'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][1]['value']
	));
	
?>