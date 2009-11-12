<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
	
echo $form->inputs(array('google_html.google_html_merchant_id' => array(
	'label' => __('Merchant ID', true),
	'value' => $data['PaymentMethodValue'][0]['value']
)));

?>