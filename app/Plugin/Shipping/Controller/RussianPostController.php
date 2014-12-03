<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('ShippingAppController', 'Shipping.Controller');

class RussianPostController extends ShippingAppController {
        public $uses = array('ShippingMethod', 'GeoZone', 'CountryZone');
        public $module_name = 'RussianPost';
        public $num_zones = 5;
        public $icon = 'russianpost.png';

        public function settings ()
        {
                $this->set('data', $this->ShippingMethod->findByCode($this->module_name));
                $this->set('num_zones', $this->num_zones);
                $this->set('geo_zones', $this->GeoZone->find('list', array(
                        'fields' => array('GeoZone.id', 'GeoZone.name', 'GeoZone.description')
                )));
        }

        public function install()
        {

                $new_module = array();
                $new_module['ShippingMethod']['active'] = '1';
                $new_module['ShippingMethod']['name'] = Inflector::humanize($this->module_name);
                $new_module['ShippingMethod']['icon'] = $this->icon;
                $new_module['ShippingMethod']['code'] = $this->module_name;

                $new_module['ShippingMethodValue'][0]['shipping_method_id'] = $this->ShippingMethod->id;
                $new_module['ShippingMethodValue'][0]['key'] = 'russian_post_type';
                $new_module['ShippingMethodValue'][0]['value'] = 'weight';

                for ($i = 0; $i < $this->num_zones; $i++) {

                        $new_module['ShippingMethodValue'][$i*3 + 1]['shipping_method_id'] = $this->ShippingMethod->id;
                        $new_module['ShippingMethodValue'][$i*3 + 1]['key'] = 'russian_post_zone_' . ($i + 1);
                        $new_module['ShippingMethodValue'][$i*3 + 1]['value'] = '';

                        $new_module['ShippingMethodValue'][$i*3 + 2]['shipping_method_id'] = $this->ShippingMethod->id;
                        $new_module['ShippingMethodValue'][$i*3 + 2]['key'] = 'russian_post_cost_' . ($i + 1);
                        $new_module['ShippingMethodValue'][$i*3 + 2]['value'] = '';

                        $new_module['ShippingMethodValue'][$i*3 + 3]['shipping_method_id'] = $this->ShippingMethod->id;
                        $new_module['ShippingMethodValue'][$i*3 + 3]['key'] = 'russian_post_handling_' . ($i + 1);
                        $new_module['ShippingMethodValue'][$i*3 + 3]['value'] = '';
                }

                $this->ShippingMethod->saveAll($new_module);

                $this->Session->setFlash(__('Module Installed'));
                $this->redirect('/shipping_methods/admin/');
        }

        public function uninstall()
        {

                $module_id = $this->ShippingMethod->findByCode($this->module_name);

                $this->ShippingMethod->delete($module_id['ShippingMethod']['id'], true);

                $this->Session->setFlash(__('Module Uninstalled'));
                $this->redirect('/shipping_methods/admin/');
        }

        public function calculate ()
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
                $shipping_price = 0;
                $cost = 0;
                $handling = 0;

                $country_zone = $this->CountryZone->find('first', array('conditions' => array('CountryZone.id' => $order['Order']['bill_state'])));

					if ($country_zone) {

                $geo_zone = $country_zone['GeoZone']['id'];

                $cost     = $data['russian_post_cost_' . $geo_zone];
                $handling = $data['russian_post_handling_' . $geo_zone];

		switch($data['russian_post_type'])
		{
			case 'products':
				$units = count($order['OrderProduct']);
			break;
			case 'total':
				$units = $order['Order']['total'];
			break;		
			case 'weight':
				$units = 0;
				foreach($order['OrderProduct'] AS $product)				
				{
					$units += ($product['weight'] * $product['quantity']);
				}
			break;				
		}
		
$newline =
'
';	
		$rates = str_replace($newline, '', $cost);
		$rates = explode(',', $rates);
		
		$keyed_rates = array();
		foreach($rates AS $key => $value)
		{
			$temp_rates = explode(':',$value);
			$temp_rate_key = $temp_rates['0'];
			$keyed_rates[$temp_rate_key] = $temp_rates['1'];
		}
		
		$keyed_rates = array_reverse($keyed_rates,true);

		$shipping_price = 0;

		foreach($keyed_rates AS $key => $value)
		{
			if(($key < $units)&&($shipping_price == 0))
			{
				$shipping_price = $value;
			}
		}

					}

                return $shipping_price + $handling;
        }

        public function before_process()
        {
        }
}