<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_get_template_vars($params, $template)
{
	echo '<pre>';
	echo 'TEMPLATE VARS { <br />';
	foreach($template->smarty->tpl_vars AS $key => $value)
	{
		
		echo '&nbsp;&nbsp;&nbsp;&nbsp;' . $key . ' => ';
		if(is_array($value))
			print_r($value);
		else
			echo $value . '<br />';
		
	}
	
	echo '}';
	echo '</pre>';
	return;

}

function smarty_help_function_get_template_vars() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Dumps all available smarty template variables onto the page. If you wanted to use one you would use it like:') ?> {$content_id}</p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{get_template_vars}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em>(<?php echo __('None') ?>)</em></li>
	</ul>
	<?php
}

function smarty_about_function_get_template_vars() {
}
?>