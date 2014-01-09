<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Form->input('invoice.bank_name', array(
	'label' => __('Bank Name'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
	));
	
echo $this->Form->input('invoice.bank_account1', array(
	'label' => __('Account Number 1'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][1]['value']
	));
	
echo $this->Form->input('invoice.bik', array(
	'label' => __('BIK'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][2]['value']
	));
	
echo $this->Form->input('invoice.bank_account2', array(
	'label' => __('Account Number 2'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][3]['value']
	));
	
echo $this->Form->input('invoice.inn', array(
	'label' => __('INN'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][4]['value']
	));
	
echo $this->Form->input('invoice.recipient', array(
	'label' => __('Recipient'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][5]['value']
	));
	
echo $this->Form->input('invoice.kpp', array(
	'label' => __('KPP'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][6]['value']
	));
	
echo $this->Form->input('invoice.payment_text', array(
	'label' => __('Payment Text'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][7]['value']
	));

echo $this->Form->input('invoice.address', array(
	'label' => __('Company Address'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][8]['value']
	));

echo $this->Form->input('invoice.phone', array(
	'label' => __('Company Phone'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][9]['value']
	));

echo $this->Form->input('invoice.ogrn', array(
	'label' => __('OGRN'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][10]['value']
	));

echo $this->Form->input('invoice.okpo', array(
	'label' => __('OKPO'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][11]['value']
	));
?>