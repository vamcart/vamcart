<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
	
echo $form->inputs(array(
	'legend' => null,
	'authorize.authorize_login' => array(
	'label' => __('Authorize.Net ID', true),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
)));

?>