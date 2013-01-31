<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('ShippingAppController', 'Shipping.Controller');

class ZoneBasedController extends ShippingAppController {
        var $uses = array('ShippingMethod', 'GeoZone');
        var $module_name = 'ZoneBased';
        var $num_zones = 10;

        function settings ()
        {
                $this->set('data', $this->ShippingMethod->findByCode($this->module_name));
                $this->set('num_zones', $this->num_zones);
                $this->set('geo_zones', $this->GeoZone->find('list', array(
                        'fields' => array('GeoZone.id', 'GeoZone.description')
                )));
        }

        function install()
        {

                $new_module = array();
                $new_module['ShippingMethod']['active'] = '1';
                $new_module['ShippingMethod']['name'] = Inflector::humanize($this->module_name);
                $new_module['ShippingMethod']['code'] = $this->module_name;

                $new_module['ShippingMethodValue'][0]['shipping_method_id'] = $this->ShippingMethod->id;
                $new_module['ShippingMethodValue'][0]['key'] = 'zone_based_type';
                $new_module['ShippingMethodValue'][0]['value'] = 'weight';

                for ($i = 0; $i < $this->num_zones; $i++) {

                        $new_module['ShippingMethodValue'][$i*3 + 1]['shipping_method_id'] = $this->ShippingMethod->id;
                        $new_module['ShippingMethodValue'][$i*3 + 1]['key'] = 'zone_based_zone_' . ($i + 1);
                        $new_module['ShippingMethodValue'][$i*3 + 1]['value'] = '';

                        $new_module['ShippingMethodValue'][$i*3 + 2]['shipping_method_id'] = $this->ShippingMethod->id;
                        $new_module['ShippingMethodValue'][$i*3 + 2]['key'] = 'zone_based_cost_' . ($i + 1);
                        $new_module['ShippingMethodValue'][$i*3 + 2]['value'] = '';

                        $new_module['ShippingMethodValue'][$i*3 + 3]['shipping_method_id'] = $this->ShippingMethod->id;
                        $new_module['ShippingMethodValue'][$i*3 + 3]['key'] = 'zone_based_handling_' . ($i + 1);
                        $new_module['ShippingMethodValue'][$i*3 + 3]['value'] = '';
                }

                $this->ShippingMethod->saveAll($new_module);

                $this->Session->setFlash(__('Module Installed'));
                $this->redirect('/shipping_methods/admin/');
        }

        function uninstall()
        {

                $module_id = $this->ShippingMethod->findByCode($this->module_name);

                $this->ShippingMethod->delete($module_id['ShippingMethod']['id'], true);

                $this->Session->setFlash(__('Module Uninstalled'));
                $this->redirect('/shipping_methods/admin/');
        }

        function calculate ()
        {
                $key_values = $this->ShippingMethod->findByCode($this->module_name);

                $data = array();
                if(!empty($key_values['ShippingMethodValue']))
                        $data = array_combine(Set::extract($key_values, 'ShippingMethodValue.{n}.key'),
                                              Set::extract($key_values, 'ShippingMethodValue.{n}.value'));

                $num_zones = (int)((sizeof($data) - 1)/3);

                // Calculate the unit of measure depending on what's set in the database
                global $order;
                $shipping_country = $order['Order']['bill_country'];
//echo print_r($order['Order']); die;
                $shipping_price = 0;
                for ($i = 1; $i <= $num_zones; $i++) {
                        $countries = explode(',', $data['zone_based_zone_' . $i]);

                        if (in_array($shipping_country, $countries)) {
                                $cost     = $data['zone_based_cost_' . $i];
                                $handling = $data['zone_based_handling_' . $i];
                                // добавит расчет по таблице
                                $shipping_price = $cost + $handling;
                                break;
                        }
                }

/*
		switch($data['table_based_type'])
		{
			case 'products':
				$units = count($order['OrderProduct']);
			break;
			case 'total':
				$units = $order['Order']['total'];
			break;		
			case 'weight':
				foreach($order['OrderProduct'] AS $product)				
				{
					$units += ($product['weight'] * $product['quantity']);
				}
			break;				
		}
		
		// Loop through the rates value
$newline = 
'
';	
		$rates = str_replace($newline,'',$data['table_based_rates']);
		$rates = explode(',',$rates);
		
		$keyed_rates = array();
		foreach($rates AS $key => $value)
		{
			$temp_rates = explode(':',$value);
			$temp_rate_key = $temp_rates['0'];
			$keyed_rates[$temp_rate_key] = $temp_rates['1'];
		}
		
		$keyed_rates = array_reverse($keyed_rates,true);
*/
//		$shipping_price = 0;
/*
		foreach($keyed_rates AS $key => $value)
		{
			if(($key < $units)&&($shipping_price == 0))
			{
				$shipping_price = $value;
			}
		}
		
*/
                return $shipping_price;
        }

        function before_process()
        {
        }
}
?>
