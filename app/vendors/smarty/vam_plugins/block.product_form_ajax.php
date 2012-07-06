<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_block_product_form_ajax($params, $product_form, $template, &$repeat)
{

	if (is_null($product_form)) {
		return;
	}

	global $content;

	$output = '<form name ="product-form" id="product-form" method="post" action="' . BASE . '/cart/purchase_product/" onsubmit="onProductFormSubmit(); return false;">
			<input type="hidden" name="product_id" value="' . $content['Content']['id'] . '">';
	$output .= $product_form;
	$output .= '</form>';

	echo $output;
}

function smarty_help_function_product_form_ajax() {
?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Wraps the product purchase button with a ajax form.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just wrap your product purchase with:') ?> <code>{product_form_ajax}<?php echo __('stuff') ?>{/product_form_ajax}</code></p>
<?php
}

function smarty_about_function_product_form_ajax() {
}
?>
