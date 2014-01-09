<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
	
echo $this->Form->input('authorize.authorize_login', array(
	'label' => __('Authorize.Net ID'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
));

?>