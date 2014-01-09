<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Form->input('interkassa.interkassa_id', array(
	'label' => __('InterKassa ID'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
	));
	
echo $this->Form->input('interkassa.interkassa_secret_key', array(
	'label' => __('InterKassa Secret Key'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][1]['value']
	));
?>