<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  switch($content_type_id) {
    case '1':

echo $form->inputs(array(
			'legend' => false,
			'fieldset' => false,
		   'ContentCategory.extra' => array(
		   		'type' => 'hidden',
				'value' => 1
              )
		  ));

      break;
    case '2':
    default:

$tax_options = $this->requestAction('/contents/generate_tax_list/');

	echo $validation->bind('ContentProduct', array('form' => '#contentform', 'messageId' => 'messages'));

	echo $form->inputs(array(
		'legend' => false,
		'fieldset' => false,
	   'ContentProduct.price' => array(
   		'label' => __('Price', true),
		'type' => 'text',
		'value' => !isset($data['ContentProduct']['price'])? 0 : $data['ContentProduct']['price']
	   ),
           'ContentProduct.moq' => array(
   		'label' => __('Minimum order quantity', true),
		'type' => 'text',
		'value' => !isset($data['ContentProduct']['moq'])? 0 : $data['ContentProduct']['moq']
	   ),
           'ContentProduct.pf' => array(
   		'label' => __('Packet quantity', true),
		'type' => 'text',
		'value' => !isset($data['ContentProduct']['pf'])? 0 : $data['ContentProduct']['pf']
	   ),
	   'ContentProduct.tax_id' => array(
   		'label' => __('Tax Class', true),
		'type' => 'select',
		'options' => $tax_options,
		'selected' => $data['ContentProduct']['tax_id']
	   ),
	   'ContentProduct.stock' => array(
   		'label' => __('Stock', true),
		'type' => 'text',
		'value' => !isset($data['ContentProduct']['stock'])? 0 : $data['ContentProduct']['stock']
	   ),
	   'ContentProduct.model' => array(
   		'label' => __('Model', true),
		'type' => 'text',
		'value' => $data['ContentProduct']['model']
	   ),
	   'ContentProduct.weight' => array(
   		'label' => __('Weight', true),
		'type' => 'text',
		'value' => !isset($data['ContentProduct']['weight'])? 0 : $data['ContentProduct']['weight']
	   )
	));

      break;
    case '3':

echo $form->inputs(array(
			'legend' => false,
			'fieldset' => false,
		   'ContentPage.extra' => array(
		   		'type' => 'hidden',
				'value' => 1
              )
		  ));

      break;
    case '4':

echo $form->inputs(array(
		'legend' => false,
		'fieldset' => false,
		   'ContentLink.url' => array(
		   		'type' => 'text',
				'label' => __('URL', true),
				'value' => $data['ContentLink']['url']
              )
		  ));

      break;
    case '5':

echo $form->inputs(array(
			'legend' => false,
			'fieldset' => false,
		   'ContentNews.extra' => array(
		   		'type' => 'hidden',
				'value' => 1
              )
		  ));

      break;

    case '6':

echo $form->inputs(array(
			'legend' => false,
			'fieldset' => false,
		   'ContentArticle.extra' => array(
		   		'type' => 'hidden',
				'value' => 1
              )
		  ));

      break;

}

      
?>