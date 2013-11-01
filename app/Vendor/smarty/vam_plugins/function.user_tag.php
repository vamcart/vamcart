<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_user_tag($params, $template)
{

	App::uses('UserTagBaseComponent', 'Controller/Component');
	$UserTagBase =& new UserTagBaseComponent(new ComponentCollection());

	$UserTagBase->call_user_tag($params);

}

function smarty_help_function_user_tag() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Calls the user tag specified by alias') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{user_tag alias='tag-alias'}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(alias)') ?></em> - <?php echo __('Alias of the user tag to call.') ?></li>
		<li><em><?php echo __('(var)') ?></em> - <?php echo __('Pass any other smarty variables or information to the user tag like:') ?> {user_tag alias='tag-alias' var1='abcd' var2='1234'}.  <?php echo __('These will be available for the user tag to use in the $params array.') ?></li>		
	</ul>
	<?php
}

function smarty_about_function_user_tag() {
}
?>