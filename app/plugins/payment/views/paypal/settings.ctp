<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo $form->inputs(array(
	'legend' => null,
	'paypal.paypal_email' => array(
	'label' => __('Paypal Email', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
)));

?>