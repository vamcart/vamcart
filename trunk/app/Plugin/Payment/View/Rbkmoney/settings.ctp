<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Form->input('rbkmoney.store_id', array(
	'label' => __('RBKMoney Store ID'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
	));
	
echo $this->Form->input('rbkmoney.secret_key', array(
	'label' => __('RBKMoney Secret Key'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][1]['value']
	));
?>