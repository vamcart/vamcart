<?php
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.com
   http://vamshop.ru
   Copyright 2009 VaM Shop
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$tax_options = $this->requestAction('/contents/generate_tax_list/');


	echo $form->inputs(array(
	   'ContentProduct/price' => array(
   		'label' => __('Price', true),
		'type' => 'text',
		'value' => $data['ContentProduct']['price']
	   ),
	   'ContentProduct/tax_id' => array(
   		'label' => __('Tax Class', true),
		'type' => 'select',
		'options' => $tax_options,
		'selected' => $data['ContentProduct']['tax_id']
	   ),
	   'ContentProduct/stock' => array(
   		'label' => __('Stock', true),
		'type' => 'text',
		'value' => $data['ContentProduct']['stock']
	   ),
	   'ContentProduct/model' => array(
   		'label' => __('Model', true),
		'type' => 'text',
		'value' => $data['ContentProduct']['model']
	   ),
	   'ContentProduct/weight' => array(
   		'label' => __('Weight', true),
		'type' => 'text',
		'value' => $data['ContentProduct']['weight']
	   )
	));
?>