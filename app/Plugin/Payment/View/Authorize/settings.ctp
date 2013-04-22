<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
	
echo $this->Form->input('authorize.authorize_login', array(
	'label' => __('Authorize.Net ID'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
));

?>