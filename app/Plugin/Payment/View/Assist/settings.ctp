<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Form->input('assist.assist_shop_id', array(
	'label' => __('Assist Shop ID'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
	));
?>