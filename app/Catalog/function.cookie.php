<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_cookie($params, $template)
{
	if (!isset ($params['name'])) 
    $params['name'] = false;
	
   if (!$params['name']) return;	
	
	if (isset($_COOKIE[$params['name']])) {
		$result = $_COOKIE[$params['name']];
	} else {
		$result = false;
	}

	return $result;
}

function smarty_help_function_cookie() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays the cookie value.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{cookie name="cookie-name"}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(name)') ?></em> - <?php echo __('Display value of selected cookie.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_cookie() {
}
?>