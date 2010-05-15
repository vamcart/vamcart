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
	'robokassa.login' => array(
	'label' => __('Robokassa Login', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
	),
	
	'robokassa.password1' => array(
	'label' => __('Robokassa Password 1', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][1]['value']
	),

	'robokassa.password2' => array(
	'label' => __('Robokassa Password 2', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][2]['value']
	)
	
));
?>