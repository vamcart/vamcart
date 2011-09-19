<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo $form->inputs(array(
	'legend' => null,
	'key_values.per_item_amount' => array(
		'label' => __('Per Item Amount',true), 
		'type' => 'text',
		'value' => $data['ShippingMethodValue'][0]['value']
		),
	'key_values.per_item_handling' => array(
		'label' => __('Handling',true), 
		'type' => 'text',
		'value' => $data['ShippingMethodValue'][1]['value']
		)
		
	));

?>