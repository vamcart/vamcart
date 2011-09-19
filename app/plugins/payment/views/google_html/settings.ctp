<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
	
echo $form->inputs(array(
	'legend' => null,
	'google_html.google_html_merchant_id' => array(
	'label' => __('Merchant ID', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
)));

?>