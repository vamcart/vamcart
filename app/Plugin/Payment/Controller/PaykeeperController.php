<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2013 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

class PaykeeperController extends PaymentAppController {
	var $uses = array('PaymentMethod', 'Order');
	var $module_name = 'Paykeeper';
	var $icon = 'paykeeper.png';

	function settings ()
	{
        $this->set('data', $this->PaymentMethod->findByAlias($this->module_name));
	}

	function install()
	{

		$new_module = array();
		$new_module['PaymentMethod']['active'] = '1';
		$new_module['PaymentMethod']['default'] = '0';
		$new_module['PaymentMethod']['name'] = Inflector::humanize($this->module_name);
		$new_module['PaymentMethod']['icon'] = $this->icon;
		$new_module['PaymentMethod']['alias'] = $this->module_name;

        $new_module['PaymentMethodValue'][0]['key'] = 'form_url';
        $new_module['PaymentMethodValue'][0]['value'] = '';

        $new_module['PaymentMethodValue'][1]['key'] = 'secret_seed';
        $new_module['PaymentMethodValue'][1]['value'] = '';

		$this->PaymentMethod->saveAll($new_module);

		$this->Session->setFlash(__('Module Installed'));
		$this->redirect('/payment_methods/admin/');
	}

	function uninstall()
	{

		$module_id = $this->PaymentMethod->findByAlias($this->module_name);

		$this->PaymentMethod->delete($module_id['PaymentMethod']['id'], true);
			
		$this->Session->setFlash(__('Module Uninstalled'));
		$this->redirect('/payment_methods/admin/');
	}

	function before_process () 
	{
        global $config;
        			
        $order = $this->Order->read(null, $_SESSION['Customer']['order_id']);
        
        $sum = $order['Order']['total'];
        $orderid = $order['Order']['id'];
        $clientid = $order['Order']['bill_name'];
        $client_email = $order['Order']['email'];
        $client_phone = $order['Order']['phone'];
        $service_name = $config['SITE_NAME'];

        $paykeeper_settings_form_url = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'form_url')));
        $form_url = $paykeeper_settings_form_url['PaymentMethodValue']['value'];
        $paykeeper_settings_secret = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'secret_seed')));
        $secret = $paykeeper_settings_secret['PaymentMethodValue']['value'];

        $to_hash = number_format ($sum, 2 , '.' , '') .
                                  $clientid           .   
                                  $orderid            .   
                                  $service_name       .   
                                  $client_email       .   
                                  $client_phone       .   
                                  $secret;

        $sign = hash ('sha256' , $to_hash);


		$content = '
		<form action="' . $form_url . '" method="post">
        <input type="hidden" name="sum" value = "' . $sum . '">
        <input type="hidden" name="orderid" value = "' . $orderid . '">
        <input type="hidden" name="clientid" value = "' . $clientid . '">
        <input type="hidden" name="client_email" value = "' . $client_email . '">
        <input type="hidden" name="client_phone" value = "' . $client_phone . '">
        <input type="hidden" name="service_name" value = "' . $service_name . '">
        <input type="hidden" name="sign" value = "' . $sign . '">
		<button class="btn btn-warning" type="submit" value="{lang}Pay Now{/lang}"><i class="fa fa-dollar"></i> {lang}Pay Now{/lang}</button>
		</form>';
        foreach($_POST AS $key => $value)
            $order['Order'][$key] = $value;

        // Get the default order status
        $default_status = $this->Order->OrderStatus->find('first', array('conditions' => array('default' => '1')));
        $order['Order']['order_status_id'] = $default_status['OrderStatus']['id'];

        // Save the order
        $this->Order->save($order);

		return $content;
	}

	public function payment_after($order_id = 0)
	{
	}

	function after_process()
	{
	}

    public function result()
    {
        $this->layout = false;

        if(isset($_POST['id']) && isset($_POST['orderid'])){
            $paykeeper_settings_secret = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'secret_seed')));
            $secret_seed = $paykeeper_settings_secret['PaymentMethodValue']['value'];
            $id = $_POST['id'];
            $sum = $_POST['sum'];
            $clientid = $_POST['clientid'];
            $orderid = $_POST['orderid'];
            $key = $_POST['key'];

            if ($key != md5 ($id . sprintf ("%.2lf", $sum).$clientid.$orderid.$secret_seed))
            {
                echo "Error! Hash mismatch";
                exit;
            }

            //Change order status
            $payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));
            $order_data = $this->Order->find('first', array('conditions' => array('Order.id' => $orderid)));
            if ($payment_method['PaymentMethod']['order_status_id'] > 0) {
                $order_data['Order']['order_status_id'] = $payment_method['PaymentMethod']['order_status_id'];
		
                $this->Order->save($order_data);
            }

            echo "OK ".md5($id.$secret_seed);
        }
    }
	    
}
?>
