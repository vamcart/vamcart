<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_repeat($params, $template)
{
	return (isset($params['times']) && intval($params['times']) > 0 ? str_repeat($params['string'], $params['times']) : '');
}

function smarty_help_function_repeat() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Repeats a given string a certain number of times.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{repeat string="<?php echo __('Hello!') ?>" times="3"}	</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(string)') ?></em> - <?php echo __('String to repeat.') ?></li>
		<li><em><?php echo __('(times)') ?></em> - <?php echo __('Number of times to repeat the specified string.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_repeat() {
}
?>