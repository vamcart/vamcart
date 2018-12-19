<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Form->input('cloudpayments.cp_public_id', array(
	'label' => __d('cloudpayments','Public ID'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
	));
	
echo $this->Form->input('cloudpayments.cp_secret_api', array(
	'label' => __d('cloudpayments','Secret API'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][1]['value']
	));
	
echo $this->Form->input('cloudpayments.cp_language', array(
	'label' => __d('cloudpayments','Widget language'),
	'type' => 'select',
	'value' => $data['PaymentMethodValue'][2]['value'],
	'options' => array(
	
	'en-US' => __('English'),
	'ru-RU' => __('Русский'),
	'uk' => __('Український'),
	'lv' => __('Latviešu'),
	'az' => __('Azərbaycan'),
	'kk' => __('Русский (часовой пояс ALMT)'),
	'kk-KZ' => __('Қазақ'),
	'pl' => __('Polski'),
	'pt' => __('Português'),
	),
	));
	
echo $this->Form->input('cloudpayments.cp_scheme_payment', array(
	'label' => __d('cloudpayments','The scheme of payment'),
	'type' => 'select',
	'value' => $data['PaymentMethodValue'][7]['value'],
	'options' => array(
	'charge' => __d('cloudpayments','One-stage payment'),
	'auth' => __d('cloudpayments','Two-stage payment')
	),
	));
	
echo '<br />';
echo $this->Form->input('cloudpayments.cp_kassa', array(
	'label' => __('cp_kassa'),
	'type' => 'radio',
	'separator' => '<br /><br />',
	'options' => array('0' => __d('cloudpayments','Do not send checks to the online cashier(Federal law-54)'), '1' => __d('cloudpayments','Send checks to online cashier(Federal law-54)')),
	'legend' => false,
	'value' => $data['PaymentMethodValue'][3]['value']
	));
	
echo $this->Form->input('cloudpayments.cp_taxationSystem', array(
	'label' => __d('cloudpayments','The system of taxation'),
	'type' => 'select',
	'value' => $data['PaymentMethodValue'][4]['value'],
	'options' => array(
	'0' => __d('cloudpayments','General taxation system'),
	'1' => __d('cloudpayments','Simplified taxation system (Income)'),
	'2' => __d('cloudpayments','Simplified taxation system (Income minus Consumption)'),
	'3' => __d('cloudpayments','Single tax imputed income'),
	'4' => __d('cloudpayments','Uniform agricultural tax'),
	'5' => __d('cloudpayments','The patent system of taxation')
	),
	));
	
echo $this->Form->input('cloudpayments.cp_vat', array(
	'label' => __d('cloudpayments','VAT rate'),
	'type' => 'select',
	'value' => $data['PaymentMethodValue'][5]['value'],
	'options' => array(
	'' => __d('cloudpayments','Not subject to VAT'),
	'20' => __d('cloudpayments','VAT 20%'),
	'18' => __d('cloudpayments','VAT 18%'),
	'10' => __d('cloudpayments','VAT 10%'),
	'0' => __d('cloudpayments','VAT 0%'),
	'110' => __d('cloudpayments','The calculated VAT 10/110'),
	'118' => __d('cloudpayments','The calculated VAT 18/118'),
	'120' => __d('cloudpayments','The calculated VAT 20/120'),
	),
	));
	
echo $this->Form->input('cloudpayments.cp_vatd', array(
	'label' => __d('cloudpayments','The system of taxation for delivery'),
	'type' => 'select',
	'value' => $data['PaymentMethodValue'][6]['value'],
	'options' => array(
	'' => __d('cloudpayments','Not subject to VAT'),
	'20' => __d('cloudpayments','VAT 20%'),
	'18' => __d('cloudpayments','VAT 18%'),
	'10' => __d('cloudpayments','VAT 10%'),
	'0' => __d('cloudpayments','VAT 0%'),
	'110' => __d('cloudpayments','The calculated VAT 10/110'),
	'118' => __d('cloudpayments','The calculated VAT 18/118'),
	'120' => __d('cloudpayments','The calculated VAT 20/120')
	),
	));
	
?>