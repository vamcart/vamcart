<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('PaymentAppController', 'Payment.Controller');

class CredomaticController extends PaymentAppController {
	public $uses = array('PaymentMethod', 'Order');
	public $module_name = 'Credomatic';
	public $icon = 'credomatic.png';

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
		$new_module['PaymentMethodValue'][0]['key'] = 'credomatic_processor_id';
		$new_module['PaymentMethodValue'][0]['value'] = '';

		$new_module['PaymentMethodValue'][1]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][1]['key'] = 'credomatic_key_id';
		$new_module['PaymentMethodValue'][1]['value'] = '';

		$new_module['PaymentMethodValue'][2]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][2]['key'] = 'credomatic_key';
		$new_module['PaymentMethodValue'][2]['value'] = '';

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
			
		$order = $this->Order->read(null,$_SESSION['Customer']['order_id']);
		
		$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));

		$credomatic_settings_processor = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'credomatic_processor_id')));
		$credomatic_processor = $credomatic_settings_processor['PaymentMethodValue']['value'];

		$credomatic_settings_key_id = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'credomatic_key_id')));
		$credomatic_key_id = $credomatic_settings_key_id['PaymentMethodValue']['value'];

		$credomatic_settings_key = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'credomatic_key')));
		$credomatic_key = $credomatic_settings_key['PaymentMethodValue']['value'];
		
		$content = '
		
<form name="CredomaticPost" method="post" action="https://credomatic.compassmerchantsolutions.com/api/transact.php" class="form-horizontal" />
<input type="hidden" name="type" value="sale"/>
<input type="hidden" name="key_id" value="'.$credomatic_key_id.'"/>
<input type="hidden" name="hash" value="' . md5($_SESSION['Customer']['order_id']."|".number_format($order['Order']['total'],2,'.','')."|".time()."|".$credomatic_key) . '" >
<input type="hidden" name="time" value="' . time() . '"/>
<input type="hidden" name="redirect" value="'.FULL_BASE_URL . BASE . '/payment/credomatic/result/'.'"/>

<input type="hidden" name="amount" value="'.number_format($order['Order']['total'],2,'.','').'"/>
<input type="hidden" name="orderid" value="'.$_SESSION['Customer']['order_id'].'"/>
<input type="hidden" name="processor_id" value="'.$credomatic_processor.'"/>

<div class="form-group"> 
<label class="col-sm-3 control-label" for="ccnumber">{lang}Card Number{/lang}:</label> 
<div class="col-sm-9"> 
<input type="text" class="form-control" name="ccnumber" id="ccnumber" value=""> 
</div> 
</div>

<div class="form-group"> 
<label class="col-sm-3 control-label" for="ccexp">{lang}Card Expire (format: MMYY){/lang}:</label> 
<div class="col-sm-9"> 
<input type="text" class="form-control" name="ccexp" id="ccexp" value=""> 
</div> 
</div>

<div class="form-group"> 
<label class="col-sm-3 control-label" for="cvv">{lang}CVV Code{/lang}:</label> 
<div class="col-sm-9"> 
<input type="text" class="form-control" name="cvv" id="cvv" value=""> 
</div> 
</div>

';
						
		$content .= '
			<button class="btn btn-default" type="submit" value="{lang}Process to Payment{/lang}"><i class="fa fa-check"></i> {lang}Process to Payment{/lang}</button>
			</form>';
	
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

		if(empty($order_id))
		return;
		
		$order = $this->Order->read(null,$order_id);
		
		$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));

		$credomatic_settings = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'credomatic_purse')));
		$credomatic_purse = $credomatic_settings['PaymentMethodValue']['value'];
		
		$content = '<form action="https://merchant.credomatic.ru/lmi/payment.asp" method="post" class="form-horizontal">
			<input type="hidden" name="LMI_PAYMENT_NO" value="' . $order_id . '">
			<input type="hidden" name="LMI_PAYEE_PURSE" value="'.$credomatic_purse.'">
			<input type="hidden" name="LMI_PAYMENT_DESC" value="' . $order_id . ' ' . $order['Order']['email'] . '">
			<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="' . $order['Order']['total'] . '">
			<input type="hidden" name="LMI_SIM_MODE" value="0">';
						
		$content .= '
			<button class="btn btn-warning" type="submit" value="{lang}Pay Now{/lang}"><i class="fa fa-dollar"></i> {lang}Pay Now{/lang}</button>
			</form>';

		return $content;
	}
	
	public function after_process()
	{
	}
	
	public function result()
	{
		global $config;
		$this->layout = false;
      $credomatic_data = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'credomatic_key')));
      $credomatic_secret_key = $credomatic_data['PaymentMethodValue']['value'];
		$order = $this->Order->read(null,$_POST['LMI_PAYMENT_NO']);
		$crc = $_POST['LMI_HASH'];
		$hash = strtoupper(hash('sha256',$_POST['LMI_PAYEE_PURSE'].$_POST['LMI_PAYMENT_AMOUNT'].$_POST['LMI_PAYMENT_NO'].$_POST['LMI_MODE'].$_POST['LMI_SYS_INVS_NO'].$_POST['LMI_SYS_TRANS_NO'].$_POST['LMI_SYS_TRANS_DATE'].$credomatic_secret_key. 
$_POST['LMI_PAYER_PURSE'].$_POST['LMI_PAYER_WM']));
		$merchant_summ = number_format($_POST['LMI_PAYMENT_AMOUNT'], 2);
		$order_summ = number_format($order['Order']['total'], 2);

		if (($crc == $hash) && ($merchant_summ == $order_summ)) {
		
		$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));
		$order_data = $this->Order->find('first', array('conditions' => array('Order.id' => $_POST['LMI_PAYMENT_NO'])));
		$order_data['Order']['order_status_id'] = $payment_method['PaymentMethod']['order_status_id'];
		
		$this->Order->save($order_data);
		
		}
		
		$this->redirect('/page/success' . $config['URL_EXTENSION']);
		
// logging
$fp = fopen(WWW_ROOT.'log-get.log', 'a+');
$str=date('Y-m-d H:i:s').' - ';
foreach ($_GET as $vn=>$vv) {
  $str.=$vn.'='.$vv.';';
}

fwrite($fp, $str."\n");
fclose($fp);		

// logging
$fp = fopen(WWW_ROOT.'log-post.log', 'a+');
$str=date('Y-m-d H:i:s').' - ';
foreach ($_POST as $vn=>$vv) {
  $str.=$vn.'='.$vv.';';
}

fwrite($fp, $str."\n");
fclose($fp);		
	
	}
	
}

?>