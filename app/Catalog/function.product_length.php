<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_product_length($params, $template)
{
	global $content;

	if ($content['Content']['content_type_id'] != 2) return;

	$length = $content['ContentProduct']['length'];
	
	if ($length > 0) {
	echo $length;
	}
}

function smarty_help_function_product_length () {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays the product length for the current content.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{product_length}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em>(<?php echo __('None') ?>)</em></li>
	</ul>
	<?php
}

function smarty_about_function_product_length () {
}
?>