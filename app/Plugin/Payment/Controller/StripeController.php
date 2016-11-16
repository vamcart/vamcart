<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('PaymentAppController', 'Payment.Controller');

class StripeController extends PaymentAppController {
	public $uses = array('PaymentMethod', 'Order');
	public $module_name = 'Stripe';
	public $icon = 'stripe.png';

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
		$new_module['PaymentMethodValue'][0]['key'] = 'secret_key';
		$new_module['PaymentMethodValue'][0]['value'] = '';

		$new_module['PaymentMethodValue'][1]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][1]['key'] = 'publish_key';
		$new_module['PaymentMethodValue'][1]['value'] = '';

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
		
		$order = $this->Order->read(null,$_SESSION['Customer']['order_id']);
		
		$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));

		$secret_key_query = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'secret_key')));
		$secret_key = $secret_key_query['PaymentMethodValue']['value'];

		$publish_key_query = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'publish_key')));
		$publish_key = $publish_key_query['PaymentMethodValue']['value'];

        App::import('Vendor', 'stripe', array('file' => 'stripe'.DS.'init.php'));

$stripe = array(
  'secret_key'      => 'sk_test_pMHNYyqsni45QoKGAJ7DlFYv',
  'publishable_key' => 'pk_test_L83k75ErjGIy0tOg7ptmeIUn'
);

\Stripe\Stripe::setApiKey($stripe['secret_key']);

				$content = '	

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">
  Stripe.setPublishableKey("'.$publish_key.'");
</script>

<script>

$(function() {
  var $form = $("#payment-form");
  $form.submit(function(event) {
    // Disable the submit button to prevent repeated clicks:
    $form.find(".submit").prop("disabled", true);

    // Request a token from Stripe:
    Stripe.card.createToken($form, stripeResponseHandler);

    // Prevent the form from being submitted:
    return false;
  });
});

function stripeResponseHandler(status, response) {
  // Grab the form:
  var $form = $("#payment-form");

  if (response.error) { // Problem!

    // Show the errors on the form:
    $form.find(".payment-errors").text(response.error.message);
    $form.find(".submit").prop("disabled", false); // Re-enable submission

  } else { // Token was created!

    // Get the token ID:
    var token = response.id;

    // Insert the token ID into the form so it gets submitted to the server:
    $form.append($(\'<input type="hidden" name="stripeToken">\').val(token));

    // Submit the form:
    $form.get(0).submit();
  }
};

</script>

		<form action="' . BASE . '/payment/stripe/process_payment/" method="post" id="payment-form" class="form-horizontal">
		<span class="payment-errors"></span>
		<div id="stripe">
		<div class="form-group">
			<label class="col-sm-3 control-label" for="email">{lang}Card Number{/lang}:</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" data-stripe="number" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label" for="email">{lang}Expiration month (MM){/lang}:</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" size="2" data-stripe="exp_month" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label" for="email">{lang}Expiration year (YY){/lang}:</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" size="2" data-stripe="exp_year" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label" for="email">{lang}CVC{/lang}:</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" size="3" data-stripe="cvc" />
			</div>
		</div>
		<button class="btn btn-default submit" type="submit" value="{lang}Pay with Card{/lang}"><i class="fa fa-check"></i> {lang}Pay with Card{/lang}</button>
		</form>';
		return $content;
	}

	public function process_payment()
	{
		global $config;
		
		$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));
		$order_data = $this->Order->find('first', array('conditions' => array('Order.id' => $_SESSION['Customer']['order_id'])));

		$secret_key_query = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'secret_key')));
		$secret_key = $secret_key_query['PaymentMethodValue']['value'];

		$publish_key_query = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'publish_key')));
		$publish_key = $publish_key_query['PaymentMethodValue']['value'];

      App::import('Vendor', 'stripe', array('file' => 'stripe'.DS.'init.php'));

		$stripe = array(
		  'secret_key'      => $secret_key,
		  'publishable_key' => $publish_key
		);

		\Stripe\Stripe::setApiKey($stripe['secret_key']);

		  $token  = $_POST['stripeToken'];
		
		  $customer = \Stripe\Customer::create(array(
		      'email' => $order_data['Order']['email'],
		      'card'  => $token
		  ));
		
		  $charge = \Stripe\Charge::create(array(
		      'customer' => $customer->id,
		      'amount'   => $order_data['Order']['total'],
		      'currency' => $_SESSION['Customer']['currency_code']
		  ));

		if ($payment_method['PaymentMethod']['order_status_id'] > 0) {
		$order_data['Order']['order_status_id'] = $payment_method['PaymentMethod']['order_status_id'];

		$this->Order->save($order_data);

		}

		// Empty the cart
		$_SESSION['Customer']['order_id'] = null;
					
		$this->redirect('/page/success' . $config['URL_EXTENSION']);
	}
		
	public function after_process()
	{
	// Save the order
	
		foreach($_POST AS $key => $value)
			$order['Order'][$key] = $value;
		
		// Get the default order status
		$default_status = $this->Order->OrderStatus->find('first', array('conditions' => array('default' => '1')));
		$order['Order']['order_status_id'] = $default_status['OrderStatus']['id'];

		// Save the order
		$this->Order->save($order);
	}
	
	
	public function result()
	{
	}
	
}

?>