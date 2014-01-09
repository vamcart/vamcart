<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Form->input('zpayment.zpayment_purse', array(
	'label' => __('Zpayment Purse'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
	));
	
echo $this->Form->input('zpayment.zpayment_secret_key', array(
	'label' => __('Zpayment Secret Key'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][1]['value']
	));
?>