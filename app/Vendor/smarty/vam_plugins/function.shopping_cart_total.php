<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_shopping_cart_total($params, $template)
{
	global $order;
	global $config;
	global $content;


	$order_items = array();
	if (!isset($order['OrderProduct'])) {
			return;
	}

	$total_quantity = null;
	$total_weight = null;

	foreach($order['OrderProduct'] AS $cart_item)
	{
		$total_quantity += $cart_item['quantity'];
		$total_weight += $cart_item['weight']*$cart_item['quantity'];
	}

	return $total_quantity;
}

function smarty_help_function_shopping_cart_total() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays the total quantity products in shopping cart.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{shopping_cart_total}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em>(<?php echo __('None') ?>)</em></li>
	</ul>
	<?php
}

function smarty_about_function_shopping_cart_total() {
}
?>