<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

//echo '<p>' .__('Table based shipping can be set to work off of number of products in cart, weight of products, or total price of products. In the textarea below specify value to cost pairs with a colon followed by a comma. Example: 0:1.00,1:2.50,2:3.00. Units of measure must be integers.') . '</p>';
echo '<br />';

//$fields = array();
//$fields['legend'] = null;

$types = array('weight' => __('Weight'),
               'total' => __('Total'),
               'products' => __('Products'));

$geo_zones[-1] = __('Select zone');
ksort($geo_zones);

echo $this->Form->input('key_values.zone_based_type', array(
            'type'      => 'select',
            'selected'  => $data['ShippingMethodValue'][0]['value'],
            'label'     => __('Based Off'),
            'options'   => $types
            ));

for ($i = 0; $i < $num_zones; $i++) {
echo '<br style="clear:both" />';
echo $this->Form->input('key_values.zone_based_zone_' . ($i + 1), array(
        'type'     => 'select',
        'label'    => __('Geo Zone') . ' ' . ($i + 1),
        'selected' => $data['ShippingMethodValue'][$i*3 + 1]['value'],
        'options'  => $geo_zones
    ));
echo '<br style="clear:both" />';
echo $this->Form->input('key_values.zone_based_cost_' . ($i + 1), array(
        'type'  => 'text',
        'label' => __('Shipping Cost for Zone') . ' ' . ($i + 1),
        'value' => $data['ShippingMethodValue'][$i*3 + 2]['value']
    ));
echo '<br style="clear:both" />';
echo $this->Form->input('key_values.zone_based_handling_' . ($i + 1), array(
        'type'  => 'text',
        'label' => __('Shipping Handling Cost for Zone') . ' ' . ($i + 1),
        'value' => $data['ShippingMethodValue'][$i*3 + 3]['value']
    ));
echo '<br style="clear:both" />';
}

?>
