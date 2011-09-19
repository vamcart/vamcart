<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo $form->inputs(array(
	'legend' => null,
	'prochange.pro_client' => array(
	'label' => __('Prochange ID 1', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
	),
	
	'prochange.pro_ra' => array(
	'label' => __('Prochange ID 2', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][1]['value']
	),

	'prochange.secret_key' => array(
	'label' => __('Prochange Secret Key', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][2]['value']
	)
	
));
?>