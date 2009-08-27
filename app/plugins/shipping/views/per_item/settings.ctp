<?php
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.com
   http://vamshop.ru
   Copyright 2009 VaM Shop
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo $form->inputs(array(
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