<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_product_model($params, $template)
{
	global $content;

	$content_type = 'ContentProduct';
	if ($content['Content']['content_type_id'] == 7) $content_type = 'ContentDownloadable';
	
	$model = $content[$content_type]['model'];
		
	if ($model != '') {
	echo $model;
	}
}

function smarty_help_function_product_model () {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays the product model for the current content.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{product_model}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em>(<?php echo __('None') ?>)</em></li>
	</ul>
	<?php
}

function smarty_about_function_product_model () {
}
?>