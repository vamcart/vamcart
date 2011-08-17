<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo $form->inputs(array(
	'legend' => null,
	'invoice.bank_name' => array(
	'label' => __('Bank Name', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
	),
	
	'invoice.bank_account1' => array(
	'label' => __('Account Number 1', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][1]['value']
	),
	
	'invoice.bik' => array(
	'label' => __('BIK', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][2]['value']
	),
	
	'invoice.bank_account2' => array(
	'label' => __('Account Number 2', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][3]['value']
	),
	
	'invoice.inn' => array(
	'label' => __('INN', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][4]['value']
	),
	
	'invoice.recipient' => array(
	'label' => __('Recipient', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][5]['value']
	),
	
	'invoice.kpp' => array(
	'label' => __('KPP', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][6]['value']
	),
	
	'invoice.payment_text' => array(
	'label' => __('Payment Text', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][7]['value']
	),

	'invoice.address' => array(
	'label' => __('Company Address', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][8]['value']
	),

	'invoice.phone' => array(
	'label' => __('Company Phone', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][9]['value']
	),

	'invoice.ogrn' => array(
	'label' => __('OGRN', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][10]['value']
	),

	'invoice.okpo' => array(
	'label' => __('OKPO', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][11]['value']
	)
	
));
?>