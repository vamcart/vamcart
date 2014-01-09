<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Form->input('assist.assist_shop_id', array(
	'label' => __('Assist Shop ID'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
	));
?>