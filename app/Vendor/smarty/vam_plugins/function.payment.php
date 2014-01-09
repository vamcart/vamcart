<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_payment ()
{
$template = '
{payment_content alias=$payment_alias}
';
return $template;
}

function smarty_function_payment($params, $template)
{

	/*
	 *  Load some necessary vars
	 **/	
	global $config;
	global $order;		
		
	App::uses('SmartyComponent', 'Controller/Component');
		$Smarty =& new SmartyComponent(new ComponentCollection());

	App::uses('PaymentMethodBaseComponent', 'Controller/Component');
		$PaymentMethodBase =& new PaymentMethodBaseComponent(new ComponentCollection());

	App::import('Model', 'PaymentMethod');
		$PaymentMethod =& new PaymentMethod();


	$PaymentMethodBase->save_customer_data();

	// Get the payment method 
	$payment = $PaymentMethod->read(null,$order['Order']['payment_method_id']);
	
	$assignments = array('payment_alias' => $payment['PaymentMethod']['alias']);

	$display_template = $Smarty->load_template($params,'payment');	
	$Smarty->display($display_template,$assignments);
	
}

function smarty_help_function_payment() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('This plugin handles the payment process.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('You should only use this tag in the confirmation core page. Just insert the tag into your page like:') ?> <code>{payment}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Useful if you want to override the default content listing template. Setting this will utilize the template that matches this alias.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_payment() {
}
?>