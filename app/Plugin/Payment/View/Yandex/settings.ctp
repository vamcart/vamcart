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

echo $this->Form->input('yandex.mode', array(
	'label' => __('Yandex.Money Mode'),
	'type' => 'radio',
	'separator' => '<br /><br />',
	'options' => array('0' => __('Test Mode'), '1' => __('Production Mode')),
	'legend' => false,
	'value' => $data['PaymentMethodValue'][3]['value']
	));
echo '<br />';
echo $this->Form->input('yandex.payment_type', array(
	'label' => __('Yandex.Money Payment Type'),
	'type' => 'radio',
	'separator' => '<br /><br />',
	'options' => array(
	'PC' => __('Yandex.Money Wallet'), 
	'AC' => __('Yandex.Money Credit Card'),
	'MC' => __('Yandex.Money Mobile Phone'), 
	'GP' => __('Yandex.Money Terminals'),
	'WM' => __('Yandex.Money WebMoney'), 
	'SB' => __('Yandex.Money Sberbank Online'),
	'MP' => __('Yandex.Money mPOS'), 
	'AB' => __('Yandex.Money AlfaClick'),
	'MA' => __('Yandex.Money MasterPass'), 
	'PB' => __('Yandex.Money PSB'),
	'QW' => __('Yandex.Money QIWI')
	),
	'legend' => false,
	'value' => $data['PaymentMethodValue'][4]['value']
	));

?>