<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('ShippingAppController', 'Shipping.Controller');

class RussianPostCalcController extends ShippingAppController {
	public $uses = array('ShippingMethod');
	public $module_name = 'RussianPostCalc';
	public $icon = 'russianpost.png';

	public function settings ()
	{
		$this->set('data', $this->ShippingMethod->findByCode($this->module_name));
	}

	public function install()
	{

		$new_module = array();
		$new_module['ShippingMethod']['active'] = '1';
		$new_module['ShippingMethod']['default'] = '0';
		$new_module['ShippingMethod']['name'] = Inflector::humanize($this->module_name);
		$new_module['ShippingMethod']['icon'] = $this->icon;
		$new_module['ShippingMethod']['code'] = $this->module_name;

		$new_module['ShippingMethodValue'][0]['shipping_method_id'] = $this->ShippingMethod->id;
		$new_module['ShippingMethodValue'][0]['key'] = 'api_key';
		$new_module['ShippingMethodValue'][0]['value'] = 'russianpostcalc.ru';

		$new_module['ShippingMethodValue'][1]['shipping_method_id'] = $this->ShippingMethod->id;
		$new_module['ShippingMethodValue'][1]['key'] = 'api_password';
		$new_module['ShippingMethodValue'][1]['value'] = 'russianpostcalc.ru';

		$new_module['ShippingMethodValue'][2]['shipping_method_id'] = $this->ShippingMethod->id;
		$new_module['ShippingMethodValue'][2]['key'] = 'store_zip_code';
		$new_module['ShippingMethodValue'][2]['value'] = '101000';

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
		global $order;

		$api_key = $this->ShippingMethod->ShippingMethodValue->find('first', array('conditions' => array('key' => 'api_key')));
		$api_key = $api_key['ShippingMethodValue']['value'];

		$api_password = $this->ShippingMethod->ShippingMethodValue->find('first', array('conditions' => array('key' => 'api_password')));
		$api_password = $api_password['ShippingMethodValue']['value'];

		$store_zip_code = $this->ShippingMethod->ShippingMethodValue->find('first', array('conditions' => array('key' => 'store_zip_code')));
		$store_zip_code = $store_zip_code['ShippingMethodValue']['value'];

		$total_weight = 0;
		
		foreach($order['OrderProduct'] AS $products)
		{
			$total_weight += (int) $products['weight']*$products['quantity'];
		}
			
    //запрос расчета стоимости отправления из 101000 МОСКВА во ВЛАДИМИР 600000.
    $ret = $this->russianpostcalc_api_calc($api_key, $api_password, $store_zip_code, $order['Order']['bill_zip'], $total_weight, $order['Order']['total']);
    
    //if (isset($ret['msg']['type']) && $ret['msg']['type'] == "done")
    //{
        //echo "success! codepage: UTF-8 <br/>";
        //print_r($ret);
        //echo "<br/>";
    //}else
    //{
        //echo "error! codepage: UTF-8 <br/>";
        //print_r($ret);
        //echo "<br/>";
    //}

		return $ret['calc'][1]['cost'];
	}

	public function before_process()
	{
	}
	
private function _russianpostcalc_api_communicate($request)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "http://russianpostcalc.ru/api_v1.php");
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($curl);
    
    curl_close($curl);
    if($data === false)
    {
	return "10000 server error";
    }
    
    $js = json_decode($data, $assoc=true);
    return $js;
}

private function russianpostcalc_api_calc($apikey, $password, $from_index, $to_index, $weight, $ob_cennost_rub)
{
    $request = array("apikey"=>$apikey, 
                        "method"=>"calc", 
                        "from_index"=>$from_index,
                        "to_index"=>$to_index,
                        "weight"=>$weight,
                        "ob_cennost_rub"=>$ob_cennost_rub
                    );

    if ($password != "")
    {
        //если пароль указан, аутентификация по методу API ключ + API пароль.
        $all_to_md5 = $request;
        $all_to_md5[] = $password;
        $hash = md5(implode("|", $all_to_md5));
        $request["hash"] = $hash;
    }

    $ret = $this->_russianpostcalc_api_communicate($request);

    return $ret;
}
	
}

?>