<?php
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.ru
   http://vamshop.com
   Copyright 2009 VaM Shop
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

function default_template_payment_after_process ()
{
$template = '
{payment_content type=after_process alias=$payment_alias}
';
return $template;
}

function smarty_function_payment_after_process($params, &$smarty)
{

	/*
	 *  Load some necessary vars
	 **/	
	global $config;
	global $order;		
		
	App::import('Component', 'Smarty');
		$Smarty =& new SmartyComponent();

	App::import('Component', 'PaymentMethodBase');
		$PaymentMethodBase =& new PaymentMethodBaseComponent();

	App::import('Model', 'PaymentMethod');
		$PaymentMethod =& new PaymentMethod();


	$PaymentMethodBase->save_customer_data();

	// Get the payment method 
//	$payment = $PaymentMethod->read(null,$order['Order']['payment_method_id']);
	
	$assignments = array('payment_alias' => 'store_pickup');

	$display_template = $Smarty->load_template($params,'payment');	
	$Smarty->display($display_template,$assignments);
	
}

function smarty_help_function_payment_after_process() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays any necessary payment code after process the order.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('This tag is called from the thank you core page like:') ?> <code>{payment_after_process}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('overrides the default payment template.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_payment_after_process() {
	?>
	<p><?php echo __('Author: Kevin Grandon &lt;kevingrandon@hotmail.com&gt;') ?></p>
	<p><?php echo __('Version:') ?> 0.1</p>
	<p>
	<?php echo __('Change History:') ?><br/>
	<?php echo __('None') ?>
	</p>
	<?php
}
?>