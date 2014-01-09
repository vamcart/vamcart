<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Form->input('webmoney.webmoney_purse', array(
	'label' => __('WebMoney Purse'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
	));
	
echo $this->Form->input('webmoney.webmoney_secret_key', array(
	'label' => __('WebMoney Secret Key'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][1]['value']
	));
?>