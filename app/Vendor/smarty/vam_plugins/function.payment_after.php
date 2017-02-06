<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_payment_after($params, $template)
{

	if(!isset($params['order_id']))
		return;
		
	/*
	 *  Load some necessary vars
	 **/	
	global $config;
		
	App::uses('SmartyComponent', 'Controller/Component');
		$Smarty = new SmartyComponent(new ComponentCollection());

	App::import('Model', 'PaymentMethod');
		$PaymentMethod = new PaymentMethod();

	App::import('Model', 'Order');
		$Order = new Order();

	// Get the order 
	$order = $Order->read(null,$params['order_id']);

	// Get the payment method 
	$payment = $PaymentMethod->read(null,$order['Order']['payment_method_id']);
	
	$payment_alias = $payment['PaymentMethod']['alias'];
	
	App::uses('SmartyComponent', 'Controller/Component');
		$Smarty = new SmartyComponent(new ComponentCollection());

	$payment_after = $Smarty->requestAction( '/payment/' . $payment_alias . '/after_process/');	

	$Smarty->display($payment_after);
	
}

function smarty_help_function_payment_after() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays payment form for sending the user payment process.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('This tag is called from the confirmation page like:') ?> <code>{payment_after order_id=123}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(order_id)') ?></em> - <?php echo __('Set order number to get payment details.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_payment_after() {
}
?>