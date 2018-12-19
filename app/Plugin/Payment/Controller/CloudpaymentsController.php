<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('PaymentAppController', 'Payment.Controller');

class CloudpaymentsController extends PaymentAppController {
	public $uses = array('PaymentMethod', 'Order');
	public $module_name = 'cloudpayments';
	public $icon = 'cloudpayments.png';

	public function settings ()
	{
		$this->set('data', $this->PaymentMethod->findByAlias($this->module_name));
	}

	public function install()
	{
		$new_module = array();
		$new_module['PaymentMethod']['active'] = '1';
		$new_module['PaymentMethod']['default'] = '0';
		$new_module['PaymentMethod']['name'] = Inflector::humanize($this->module_name);
		$new_module['PaymentMethod']['icon'] = $this->icon;
		$new_module['PaymentMethod']['alias'] = $this->module_name;

		$new_module['PaymentMethodValue'][0]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][0]['key'] = 'cp_public_id';
		$new_module['PaymentMethodValue'][0]['value'] = '';

		$new_module['PaymentMethodValue'][1]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][1]['key'] = 'cp_secret_api';
		$new_module['PaymentMethodValue'][1]['value'] = '';
		
		$new_module['PaymentMethodValue'][2]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][2]['key'] = 'cp_language';
		$new_module['PaymentMethodValue'][2]['value'] = 'ru-RU';
		
		$new_module['PaymentMethodValue'][3]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][3]['key'] = 'cp_kassa';
		$new_module['PaymentMethodValue'][3]['value'] = '1';
		
		$new_module['PaymentMethodValue'][4]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][4]['key'] = 'cp_taxationSystem';
		$new_module['PaymentMethodValue'][4]['value'] = '0';
		
		$new_module['PaymentMethodValue'][5]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][5]['key'] = 'cp_vat';
		$new_module['PaymentMethodValue'][5]['value'] = '';
		
		$new_module['PaymentMethodValue'][6]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][6]['key'] = 'cp_vatd';
		$new_module['PaymentMethodValue'][6]['value'] = '';
		
		$new_module['PaymentMethodValue'][7]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][7]['key'] = 'cp_scheme_payment';
		$new_module['PaymentMethodValue'][7]['value'] = 'charge';

		$this->PaymentMethod->saveAll($new_module);

		$this->Session->setFlash(__('Module Installed'));
		$this->redirect('/payment_methods/admin/');
	}

	public function uninstall()
	{

		$module_id = $this->PaymentMethod->findByAlias($this->module_name);

		$this->PaymentMethod->delete($module_id['PaymentMethod']['id'], true);
			
		$this->Session->setFlash(__('Module Uninstalled'));
		$this->redirect('/payment_methods/admin/');
	}

	
public function before_process () 
	{
			
		global $config;
		
		//заказ
		$order = $this->Order->read(null,$_SESSION['Customer']['order_id']);
		
		//сумма заказа
		$cp_amount = $order['Order']['total'];
		
		//email
		$cp_email = $order['Order']['email'];
		
		//телефон
		$cp_phone = $order['Order']['phone'];
        
        //метод оплаты
		$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));

        //публичный ключ
        $cp_public_id_settings = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'cp_public_id')));
		$cp_public_id = $cp_public_id_settings['PaymentMethodValue']['value'];
		
		//схема проведения платежа
        $cp_scheme_payment_settings = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'cp_scheme_payment')));
		$cp_scheme_payment = $cp_scheme_payment_settings['PaymentMethodValue']['value'];
		
		//валюта заказа
		$cp_сurrencies = $_SESSION['Customer']['currency_code'];
		
		//номер заказа
		$cp_order_id = $_SESSION['Customer']['order_id'];
		
		//урл удачной оплаты
        $success_url = FULL_BASE_URL . BASE . '/orders/place_order/';
        
        //урл неудачной оплаты
		$fail_url = FULL_BASE_URL . BASE . '/page/checkout' . $config['URL_EXTENSION'];
		
		//локализация виджета из настроек 
		$cp_language_settings = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'cp_language')));
		$cp_language = $cp_language_settings['PaymentMethodValue']['value'];
		
		//назначение заказа на языке виджета
		if ($cp_language=='ru-RU')
		    $cp_description = 'Оплата заказа №'.$cp_order_id;
		    
		if ($cp_language=='kk')
		    $cp_description = 'Оплата заказа №'.$cp_order_id;
		    
		if ($cp_language=='en-US')
		    $cp_description = 'Order payment №'.$cp_order_id;
		    
		if ($cp_language=='uk')
		    $cp_description = 'Оплата замовлення №'.$cp_order_id;
		    
		if ($cp_language=='lv')
		    $cp_description = 'Pasūtījuma apmaksa №'.$cp_order_id;
		    
		if ($cp_language=='az')
		    $cp_description = 'Ödəniş əməliyyatı №'.$cp_order_id;
		    
		if ($cp_language=='kk-KZ')
		    $cp_description = 'Тапсырысты төлеу №'.$cp_order_id;
		    
		if ($cp_language=='pl')
		    $cp_description = 'Płatności za zamówienia №'.$cp_order_id;
		    
		if ($cp_language=='pt')
		    $cp_description = 'O pagamento do pedido №'.$cp_order_id;
		
		//формируем чек
		
		//чекбокс активации кассы
		$cp_kassa_settings = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'cp_kassa')));
		$cp_kassa = $cp_kassa_settings['PaymentMethodValue']['value'];
		
		//система налогообложения из настроек
		$cp_taxationSystem_settings = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'cp_taxationSystem')));
		$cp_taxationSystem = $cp_taxationSystem_settings['PaymentMethodValue']['value'];
		
		//НДС из настроек
		$cp_vat_settings = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'cp_vat')));
		$cp_vat = $cp_vat_settings['PaymentMethodValue']['value'];
		
		//НДС доставки из настроек
		$cp_vatd_settings = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'cp_vatd')));
		$cp_vatd = $cp_vatd_settings['PaymentMethodValue']['value'];
		
        if ($cp_kassa == '1')
        {	
            foreach ($order['OrderProduct'] as $product)
            {      
                        $Items[] = array(
                        'label'           =>trim($product['name']),
                        'price'           =>$product['price'],
                        'quantity'        =>$product['quantity'],
                        'amount'          =>$product['price']*$product['quantity'],
                        'vat'             =>$cp_vat,
                        'method'          =>0,
    	                'object'          =>0,
                        'measurementUnit' =>'шт.',
                        );
            };        
               if ($order['Order']['shipping'] > 0)
                {   $Items[] = array(
                        'label'           =>trim('Доставка - ' . __($order['ShippingMethod']['name'])),
                        'price'           =>$order['Order']['shipping'],
                        'quantity'        =>1,
                        'amount'          =>$order['Order']['shipping'],
                        'vat'             =>$cp_vatd,
                        'method'          =>0,
    	                'object'          =>0,
                        'measurementUnit' =>'',
                        );
                };
            $receipt = array(
                'Items'         =>$Items,
                'taxationSystem'=>$cp_taxationSystem,
	            'email'         =>$order['Order']['email'],
	            'phone'         =>$order['Order']['phone'],
	            'amounts'       =>array (
	                'electronic'     => $order['Order']['total'],
		            'advancePayment' => 0,
		            'credit'         => 0,
		            'provision'      => 0,
	                )
	            ,);
            $cp_data = array('cloudPayments' => array(
                        'customerReceipt'=>$receipt
                    )
                );
            $cp_data = ',data:'.json_encode($cp_data,JSON_UNESCAPED_UNICODE);
        }; 
        
		$content = '<form>
		    <script src='.'https://widget.cloudpayments.ru/bundles/cloudpayments'.'></script>
		    <button class="btn btn-default" type="button" onclick= "payHandler()" value="{lang}Process to Payment{/lang}"><i class="fa fa-check"></i> {lang}Process to Payment{/lang}</button>
			</form>';                                    

        echo "<script>
            var payHandler = function (){   
                var widget = new cp.CloudPayments({language: '$cp_language'});
                widget.$cp_scheme_payment({ 
                        publicId:       '$cp_public_id',
                        description:    '$cp_description',
                        amount:         parseFloat('$cp_amount'),
                        currency:       '$cp_сurrencies',
                        invoiceId:      '$cp_order_id',
                        email:          '$cp_email'
                        $cp_data
                        },
                        '$success_url',
                        '$fail_url'
                    );
                };
            </script>";

	    // Save the order
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

	public function after_process()
	{   
	}
	
	
	public function result()
	{
	    $this->layout = false;
	    
	    //параметры запроса
        $cb_action          = $_GET['action'];
        $cb_amount		    = $_POST['Amount'];
        $cb_status		    = $_POST['Status'];

        //параметры заказа
        $order            = $this->Order->read(null,$_POST['InvoiceId']);
        $amount           = $order['Order']['total'];

        //API из настроек
        $cp_secret_api_settings = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'cp_secret_api')));
        $cp_secret_api          = $cp_secret_api_settings['PaymentMethodValue']['value'];
        
        //контрольная подпись
        $hash   = $_POST;
        $sign   = hash_hmac('sha256', $hash, $cp_secret_api, true);
        $sign   = base64_encode($sign);
        $signs  = $_SERVER['HTTPS_CONTENT_HMAC'];
        
        //проверяем контрольную подпись
        if ($signs!= $sign)
        {
            $this->response->body(json_encode(array('code'=>13)));
        }
        elseif ($cb_action==check)
        {
            if(empty($order))
            {
                $this->response->body(json_encode(array('code'=>10)));
            } 
            elseif($amount != $cb_amount || $amount<=0)
            {
                $this->response->body(json_encode(array('code'=>11)));
            }
            else $this->response->body(json_encode(array('code'=>0)));
        }    
        elseif($cb_action==pay && $cb_status==Completed)
        {   
	        $cp_order_status = $this->Order->OrderStatus->OrderStatusDescription->find('all');
	        foreach ($cp_order_status as $p)
	        if  ($p['OrderStatusDescription']['name'] == 'CP paid') 
		    {
	            $cp_order_status = $p['OrderStatusDescription']['order_status_id'];
		        $order['Order']['order_status_id'] = $cp_order_status;
		    }
		    elseif (empty($cp_order_status))
		    {
		        $default_status = $this->Order->OrderStatus->find('first', array('conditions' => array('default' => '1')));
		        $order['Order']['order_status_id'] = $default_status['OrderStatus']['id'];
		    }
            $this->Order->save($order);
            $this->response->body(json_encode(array('code'=>0)));
        }
        elseif ($cb_action==confirm)
        {   
	        $cp_order_status = $this->Order->OrderStatus->OrderStatusDescription->find('all');
	        foreach ($cp_order_status as $p)
	        if  ($p['OrderStatusDescription']['name'] == 'CP paid') 
		    {
	            $cp_order_status = $p['OrderStatusDescription']['order_status_id'];
		        $order['Order']['order_status_id'] = $cp_order_status;
		    }
		    elseif (empty($cp_order_status))
		    {
		        $default_status = $this->Order->OrderStatus->find('first', array('conditions' => array('default' => '1')));
		        $order['Order']['order_status_id'] = $default_status['OrderStatus']['id'];
		    }
            $this->Order->save($order);
            $this->response->body(json_encode(array('code'=>0)));
        }
        elseif($cb_action==pay && $cb_status==Authorized)
        {   
	        $cp_order_status = $this->Order->OrderStatus->OrderStatusDescription->find('all');
	        foreach ($cp_order_status as $p)
	        if  ($p['OrderStatusDescription']['name'] == 'CP authorized') 
		    {
	            $cp_order_status = $p['OrderStatusDescription']['order_status_id'];
		        $order['Order']['order_status_id'] = $cp_order_status;
		    }
		    elseif (empty($cp_order_status))
		    {
		        $default_status = $this->Order->OrderStatus->find('first', array('conditions' => array('default' => '1')));
		        $order['Order']['order_status_id'] = $default_status['OrderStatus']['id'];
		    }
            $this->Order->save($order);
            $this->response->body(json_encode(array('code'=>0)));
        }        
        elseif ($cb_action==refund)        
        {   
	        $cp_order_status = $this->Order->OrderStatus->OrderStatusDescription->find('all');
	        foreach ($cp_order_status as $p)
	        if  ($p['OrderStatusDescription']['name'] == 'CP refund') 
		    {
	            $cp_order_status = $p['OrderStatusDescription']['order_status_id'];
		        $order['Order']['order_status_id'] = $cp_order_status;
		    }
		    elseif (empty($cp_order_status))
		    {
		        $default_status = $this->Order->OrderStatus->find('first', array('conditions' => array('default' => '1')));
		        $order['Order']['order_status_id'] = $default_status['OrderStatus']['id'];
		    }
            $this->Order->save($order);
            $this->response->body(json_encode(array('code'=>0)));
        }     
        elseif ($cb_action==cancel)
        {   
	        $cp_order_status = $this->Order->OrderStatus->OrderStatusDescription->find('all');
	        foreach ($cp_order_status as $p)
	        if  ($p['OrderStatusDescription']['name'] == 'CP refund') 
		    {
	            $cp_order_status = $p['OrderStatusDescription']['order_status_id'];
		        $order['Order']['order_status_id'] = $cp_order_status;
		    }
		    elseif (empty($cp_order_status))
		    {
		        $default_status = $this->Order->OrderStatus->find('first', array('conditions' => array('default' => '1')));
		        $order['Order']['order_status_id'] = $default_status['OrderStatus']['id'];
		    }
            $this->Order->save($order);
            $this->response->body(json_encode(array('code'=>0)));
        }  
        elseif ($cb_action==receipt)
        { 
            $this->response->body(json_encode(array('code'=>0)));
        }        
        elseif ($cb_action==fail)
        {   
            $this->response->body(json_encode(array('code'=>0)));
        }        
        return $this->response;
	}
	
}

?>