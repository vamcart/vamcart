<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Form->inputs(array(
	'legend' => null,
	'invoice.bank_name' => array(
	'label' => __('Bank Name'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
	),
	
	'invoice.bank_account1' => array(
	'label' => __('Account Number 1'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][1]['value']
	),
	
	'invoice.bik' => array(
	'label' => __('BIK'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][2]['value']
	),
	
	'invoice.bank_account2' => array(
	'label' => __('Account Number 2'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][3]['value']
	),
	
	'invoice.inn' => array(
	'label' => __('INN'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][4]['value']
	),
	
	'invoice.recipient' => array(
	'label' => __('Recipient'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][5]['value']
	),
	
	'invoice.kpp' => array(
	'label' => __('KPP'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][6]['value']
	),
	
	'invoice.payment_text' => array(
	'label' => __('Payment Text'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][7]['value']
	),

	'invoice.address' => array(
	'label' => __('Company Address'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][8]['value']
	),

	'invoice.phone' => array(
	'label' => __('Company Phone'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][9]['value']
	),

	'invoice.ogrn' => array(
	'label' => __('OGRN'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][10]['value']
	),

	'invoice.okpo' => array(
	'label' => __('OKPO'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][11]['value']
	)
	
));
?>