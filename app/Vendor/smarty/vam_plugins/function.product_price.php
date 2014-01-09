<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_product_price($params, $template)
{
	global $content;
	
	App::uses('CurrencyBaseComponent', 'Controller/Component');
	$CurrencyBase =& new CurrencyBaseComponent(new ComponentCollection());
	
	$price = $CurrencyBase->display_price($content['ContentProduct']['price']);
	
	echo $price;
}

function smarty_help_function_product_price () {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays the product price for the current content.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{product_price}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em>(<?php echo __('None') ?>)</em></li>
	</ul>
	<?php
}

function smarty_about_function_product_price () {
}
?>