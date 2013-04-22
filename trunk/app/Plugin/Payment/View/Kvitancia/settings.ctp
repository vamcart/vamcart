<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Form->input('kvitancia.bank_name', array(
	'label' => __('Bank Name'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
	));
	
echo $this->Form->input('kvitancia.bank_account1', array(
	'label' => __('Account Number 1'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][1]['value']
	));
	
echo $this->Form->input('kvitancia.bik', array(
	'label' => __('BIK'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][2]['value']
	));
	
echo $this->Form->input('kvitancia.bank_account2', array(
	'label' => __('Account Number 2'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][3]['value']
	));
	
echo $this->Form->input('kvitancia.inn', array(
	'label' => __('INN'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][4]['value']
	));
	
echo $this->Form->input('kvitancia.recipient', array(
	'label' => __('Recipient'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][5]['value']
	));
	
echo $this->Form->input('kvitancia.kpp', array(
	'label' => __('KPP'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][6]['value']
	));
	
echo $this->Form->input('kvitancia.payment_text', array(
	'label' => __('Payment Text'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][7]['value']
	));
?>