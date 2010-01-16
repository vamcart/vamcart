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
	'webmoney.webmoney_purse' => array(
	'label' => __('WebMoney Purse', true),
	'value' => $data['PaymentMethodValue'][0]['value']
	),
	
	'webmoney.webmoney_secret_key' => array(
	'label' => __('WebMoney Secret Key', true),
	'value' => $data['PaymentMethodValue'][1]['value']
	)
	
));
?>