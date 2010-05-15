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
	'qiwi.qiwi_id' => array(
	'label' => __('Qiwi ID', true),
	'value' => $data['PaymentMethodValue'][0]['value']
	),
	
	'qiwi.qiwi_secret_key' => array(
	'label' => __('Qiwi Password', true),
	'value' => $data['PaymentMethodValue'][1]['value']
	)
	
));
?>