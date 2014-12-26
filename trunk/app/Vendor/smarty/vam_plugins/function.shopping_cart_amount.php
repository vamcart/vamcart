<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_shopping_cart_amount($params, $template)
{
	global $order;
	global $config;
	global $content;

	App::uses('CurrencyBaseComponent', 'Controller/Component');
	$CurrencyBase = new CurrencyBaseComponent(new ComponentCollection());

  $order_total = 0;

	$order_items = array();
	if (!isset($order['OrderProduct'])) {
			return;
	}

	if ($order['Order']['total'] > 0) {
  $order_total = $CurrencyBase->display_price($order['Order']['total']);
	}


	return $order_total;
}

function smarty_help_function_shopping_cart_amount() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays the shopping cart amount.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{shopping_cart_amount}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em>(<?php echo __('None') ?>)</em></li>
	</ul>
	<?php
}

function smarty_about_function_shopping_cart_amount() {
}
?>