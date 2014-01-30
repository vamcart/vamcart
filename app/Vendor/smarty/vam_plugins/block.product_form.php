<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_block_product_form($params, $product_form, $template, &$repeat)
{

	if (is_null($product_form)) {
		return;
	}

	if(!isset ($params['product_id']))
		$params['product_id'] = null;

	global $config, $content;

	if ($config['AJAX_ENABLE'] == '1') {
	$output .= '
<script type="text/javascript">
  function onProductFormSubmit'.$params['product_id'].'() {
    var str = $("#product-form'.$params['product_id'].'").serialize();

    $.post("'.BASE.'/cart/purchase_product", str, function(data) {
      $("#shopping-cart-box").html(data);
    });
  }
</script>
';
	}

	$output .= '<form class="form-inline" name="product-form" id="product-form'.$params['product_id'].'" method="post" action="' . BASE . '/cart/purchase_product/"'.(($config['AJAX_ENABLE'] == '1') ? ' onsubmit="onProductFormSubmit'.$params['product_id'].'(); return false;"' : '').'>
			<input type="hidden" name="product_id" value="' . (($params['product_id'] > 0) ? $params['product_id'] : $content['Content']['id']) . '">';
	$output .= $product_form;
	$output .= '</form>';

	echo $output;
}

function smarty_help_function_product_form() {
?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Wraps the product purchase button with a form.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just wrap your product purchase with:') ?> <code>{product_form}<?php echo __('stuff') ?>{/product_form}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(product_id)') ?></em> - <?php echo __('Product ID.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_product_form() {
}
?>
