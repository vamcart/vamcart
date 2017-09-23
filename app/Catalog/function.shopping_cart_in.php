<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_shopping_cart_in($params, $template)
{
	global $order;
	global $config;
	global $content;

	if(!isset($params['content_id']))
		$params['content_id'] = null;
		
	$in_cart = false;	
		
	App::uses('OrderBaseComponent', 'Controller/Component');
	$OrderBase = new OrderBaseComponent(new ComponentCollection());

   $in_cart = $OrderBase->in_cart($params['content_id']);

	return $in_cart;
}

function smarty_help_function_shopping_cart_in() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Return shopping cart state by content id.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{shopping_cart_in}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(content_id)') ?></em> - <?php echo __('Content id number.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_shopping_cart_in() {
}
?>