<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Form->input('credomatic.credomatic_processor_id', array(
	'label' => __('Credomatic Processor ID'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][0]['value']
	));
	
echo $this->Form->input('credomatic.credomatic_key_id', array(
	'label' => __('Credomatic Key ID'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][1]['value']
	));
echo $this->Form->input('credomatic.credomatic_key', array(
	'label' => __('Credomatic Key'),
	'type' => 'text',
	'value' => $data['PaymentMethodValue'][2]['value']
	));
?>