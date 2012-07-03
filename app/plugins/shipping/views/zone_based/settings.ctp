<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

//echo '<p>' .__('Table based shipping can be set to work off of number of products in cart, weight of products, or total price of products. In the textarea below specify value to cost pairs with a colon followed by a comma. Example: 0:1.00,1:2.50,2:3.00. Units of measure must be integers.', true) . '</p>';
echo '<br />';

$fields = array();
$fields['legend'] = null;

$types = array('weight' => __('Weight', true),
               'total' => __('Total', true),
               'products' => __('Products', true));

$geo_zones[-1] = __('Select zone', true);
ksort($geo_zones);

$fields['key_values.zone_based_type'] = array(
            'type'      => 'select',
            'selected'  => $data['ShippingMethodValue'][0]['value'],
            'label'     => __('Based Off',true),
            'options'   => $types
            );

for ($i = 0; $i < $num_zones; $i++) {
    $fields['key_values.zone_based_zone_' . ($i + 1)] = array(
        'type'     => 'select',
        'label'    => __('Geo Zone', true) . ' ' . ($i + 1),
        'selected' => $data['ShippingMethodValue'][$i*3 + 1]['value'],
        'options'  => $geo_zones
    );

    $fields['key_values.zone_based_cost_' . ($i + 1)] = array(
        'type'  => 'text',
        'label' => __('Shipping Cost for Zone', true) . ' ' . ($i + 1),
        'value' => $data['ShippingMethodValue'][$i*3 + 2]['value']
    );

    $fields['key_values.zone_based_handling_' . ($i + 1)] = array(
        'type'  => 'text',
        'label' => __('Shipping Handling Cost for Zone', true) . ' ' . ($i + 1),
        'value' => $data['ShippingMethodValue'][$i*3 + 3]['value']
    );
}

echo $form->inputs($fields);
?>
