<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo $form->inputs(array(
	'legend' => null,
	'key_values.per_item_amount' => array(
		'label' => __('Per Item Amount',true), 
		'value' => $data['ShippingMethodValue'][0]['value']
		),
	'key_values.per_item_handling' => array(
		'label' => __('Handling',true), 
		'value' => $data['ShippingMethodValue'][1]['value']
		)
		
	));

?>