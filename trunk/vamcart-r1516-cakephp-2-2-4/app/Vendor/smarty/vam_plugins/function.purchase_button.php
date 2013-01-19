<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_purchase_button($params, $template)
{
	$result = '<span class="button"><button type="submit" value="'. __('Add To Cart', true) .'"><img src="'.BASE.'/img/icons/buttons/cart_add.png" width="12" height="12" alt="" />&nbsp;'. __('Add To Cart', true) .'</button></span>';
	return $result;
}

function smarty_help_function_purchase_button() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Creates a purchase button for the product.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your product_info template like:') ?> <code>{purchase_button}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(product_id)') ?></em> - <?php echo __('Overrides the current global content_id. Useful if you want to place a purchase button in product listing pages.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_purchase_button() {
}
?>