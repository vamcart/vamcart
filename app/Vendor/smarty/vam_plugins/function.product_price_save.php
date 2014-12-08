<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_product_price_save($params, $template)
{
	global $content;
	
	App::uses('CurrencyBaseComponent', 'Controller/Component');
	$CurrencyBase = new CurrencyBaseComponent(new ComponentCollection());

	$content_type = 'ContentProduct';
	if ($content['Content']['content_type_id'] == 7) $content_type = 'ContentDownloadable';

		$price_value = $content[$content_type]['price'];
		$price_special = $content[$content_type]['old_price'];

	if ($content[$content_type]['price'] >= $price_special) {
		return;
	}

	if(isset($params['price'])) $price_special = $params['price'];

	$price_save	= $CurrencyBase->display_price($price_special-$price_value);	
	$price_special_percent	= ($price_special > $price_value) ? 100-($price_value*100/$price_special) : 0;	
	
	$price_special = $price_save . '('.round($price_special_percent).'%)';
	
	echo $price_special;
}

function smarty_help_function_product_price_save () {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays the product price for the current content.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{product_price_save}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em>(<?php echo __('None') ?>)</em></li>
	</ul>
	<?php
}

function smarty_about_function_product_price_save () {
}
?>