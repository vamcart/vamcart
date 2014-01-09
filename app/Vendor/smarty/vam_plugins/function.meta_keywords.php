<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_meta_keywords($params, $template)
{
	global $content;
	
	if ($content['ContentDescription']['meta_keywords']) { 
	$result = '<meta name="keywords" content="'.$content['ContentDescription']['meta_keywords'].'" />';
	} else {
	$result = null;
	}

	return $result;
}

function smarty_help_function_meta_keywords() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays the current meta keywords.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{meta_keywords}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em>(<?php echo __('None') ?>)</em></li>
	</ul>
	<?php
}

function smarty_about_function_meta_keywords() {
}
?>