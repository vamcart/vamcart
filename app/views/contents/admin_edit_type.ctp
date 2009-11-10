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

  switch($content_type_id) {
    case '1':

echo $form->inputs(array(
		   'ContentCategory.extra' => array(
		   		'type' => 'hidden',
				'value' => 1
              )
		  ));

      break;
    case '2':
    default:

$tax_options = $this->requestAction('/contents/generate_tax_list/');

	echo $form->inputs(array(
	   'ContentProduct.price' => array(
   		'label' => __('Price', true),
		'type' => 'text',
		'value' => $data['ContentProduct']['price']
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
		'value' => $data['ContentProduct']['stock']
	   ),
	   'ContentProduct.model' => array(
   		'label' => __('Model', true),
		'type' => 'text',
		'value' => $data['ContentProduct']['model']
	   ),
	   'ContentProduct.weight' => array(
   		'label' => __('Weight', true),
		'type' => 'text',
		'value' => $data['ContentProduct']['weight']
	   )
	));

      break;
    case '3':

echo $form->inputs(array(
		   'ContentPage.extra' => array(
		   		'type' => 'hidden',
				'value' => 1
              )
		  ));

      break;
    case '4':

echo $form->inputs(array(
		'fieldset' => __('Link Details', true),
		   'ContentLink.url' => array(
		   		'type' => 'text',
				'label' => __('URL', true),
				'value' => $data['ContentLink']['url']
              )
		  ));

      break;
    case '5':

$options = $this->requestAction('/contents/content_selflink_list/' . $data['ContentSelflink']['content_id']);


if(empty($options))
{
	echo '<p>' . __('There are no available content records. Please select a different content type.', true) . '</p>';
}
else
{


	echo '<div class="input">';
	echo '<label for="ContentSelflinkUrl">' . __('Link To', true) . '</label>';
	
	echo $form->select('ContentSelflink.url', $options, $data['ContentSelflink']['url'], null, $showEmpty = __('Select Internal Page', true));
	
	echo '</div>';
}

      break;

    case '6':

echo $form->inputs(array(
		   'ContentNews.extra' => array(
		   		'type' => 'hidden',
				'value' => 1
              )
		  ));

      break;

    case '7':

echo $form->inputs(array(
		   'ContentArticle.extra' => array(
		   		'type' => 'hidden',
				'value' => 1
              )
		  ));

      break;

}

      
?>