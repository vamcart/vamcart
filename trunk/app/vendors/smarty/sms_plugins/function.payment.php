<?php
/** SMS - Selling Made Simple
 * Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
 * This project's homepage is: http://sellingmadesimple.org
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * BUT withOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
**/

function default_template_payment ()
{
$template = '
{lang}{$payment_alias}-details{/lang}
{payment_content alias=$payment_alias}
';
return $template;
}

function smarty_function_payment($params, &$smarty)
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
	<p><?php echo __('You should only use this tag in the payment core page. Just insert the tag into your page like:') ?> <code>{payment}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('overrides the default payment template.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_payment() {
	?>
	<p><?php echo __('Author: Kevin Grandon&lt;kevingrandon@hotmail.com&gt;</p>') ?>
	<p><?php echo __('Version:') ?> 0.1</p>
	<p>
	<?php echo __('Change History:') ?><br/>
	<?php echo __('None') ?>
	</p>
	<?php
}
?>