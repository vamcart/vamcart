<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009-2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo $form->inputs(array(
	'legend' => null,
	'kvitancia.bank_name' => array(
	'label' => __('Bank Name', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
	),
	
	'kvitancia.bank_account1' => array(
	'label' => __('Account Number 1', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][1]['value']
	),
	
	'kvitancia.bik' => array(
	'label' => __('BIK', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][2]['value']
	),
	
	'kvitancia.bank_account2' => array(
	'label' => __('Account Number 2', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][3]['value']
	),
	
	'kvitancia.inn' => array(
	'label' => __('INN', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][4]['value']
	),
	
	'kvitancia.recipient' => array(
	'label' => __('Recipient', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][5]['value']
	),
	
	'kvitancia.kpp' => array(
	'label' => __('KPP', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][6]['value']
	),
	
	'kvitancia.payment_text' => array(
	'label' => __('Payment Text', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][7]['value']
	)
	
));
?>