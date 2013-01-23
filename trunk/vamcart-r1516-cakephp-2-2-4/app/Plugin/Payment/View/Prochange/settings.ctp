<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Form->inputs(array(
	'legend' => null,
	'prochange.pro_client' => array(
	'label' => __('Prochange ID 1'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
	),
	
	'prochange.pro_ra' => array(
	'label' => __('Prochange ID 2'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][1]['value']
	),

	'prochange.secret_key' => array(
	'label' => __('Prochange Secret Key'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][2]['value']
	)
	
));
?>