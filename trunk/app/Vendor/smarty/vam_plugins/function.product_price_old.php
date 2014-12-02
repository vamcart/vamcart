<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_product_price_old($params, $template)
{
	global $content;
	
	App::uses('CurrencyBaseComponent', 'Controller/Component');
	$CurrencyBase =& new CurrencyBaseComponent(new ComponentCollection());

	if ($content['Content']['content_type_id'] == 7) {
		$price_old = $content['ContentDownloadable']['old_price'];
	} else {
		$price_old = $content['ContentProduct']['old_price'];
	}

	if ($content['ContentProduct']['price'] >= $price_old) {
		return;
	}

	if(isset($params['price'])) $price_old = $params['price'];
			
	$price_old = $CurrencyBase->display_price($price_old);
	
	echo $price_old;
}

function smarty_help_function_product_price_old () {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays the product price for the current content.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{product_price_old}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em>(<?php echo __('None') ?>)</em></li>
	</ul>
	<?php
}

function smarty_about_function_product_price_old () {
}
?>