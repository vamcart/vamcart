<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo $form->inputs(array(
	'legend' => null,
	'key_values.cost' => array(
		'label' => __('Shipping Cost',true), 
		'type' => 'text',
		'value' => $data['ShippingMethodValue'][0]['value']
	)
));

?>