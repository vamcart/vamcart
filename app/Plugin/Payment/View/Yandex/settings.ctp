<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Form->input('yandex.shopid', array(
	'label' => __('Yandex.Money ShopID'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
	));

echo $this->Form->input('yandex.scid', array(
	'label' => __('Yandex.Money scid'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][1]['value']
	));
	
echo $this->Form->input('yandex.secret_key', array(
	'label' => __('Yandex.Money shopPassword'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][2]['value']
	));
?>