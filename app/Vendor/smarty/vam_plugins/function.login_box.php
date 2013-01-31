<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_login_box()
{
$template = '
<div class="info_box">
	<div class="box_heading">{lang}Login{/lang}</div>
	<div class="box_content">
		<form action="{$login_form_action}" method="post">
		<select name="currency_picker">
	 	{foreach from=$currencies item=currency}
	<option value="{$currency.id}" {if $currency.id == $smarty.session.Customer.currency_id}selected="selected"{/if}>{$currency.name}</option>
		{/foreach}
		</select>
		<span class="button"><button type="submit" value="{lang}Go{/lang}"><img src="{base_path}/img/icons/buttons/submit.png" width="12" height="12" alt="" />&nbsp;{lang}Go{/lang}</button></span>
		</form>
	</div>
</div>
';

return $template;
}

function smarty_function_login_box($params, $template)
{
	App::uses('SmartyComponent', 'Controller/Component');
	$Smarty =& new SmartyComponent(new ComponentCollection());

	if (isset($_SESSION['Auth']) && isset($_SESSION['Auth']['Customer'])) {
		$isLoggedIn = true;
	} else {
		$isLoggedIn = false;
	}

	global $Dispatcher;

	$vars = array(
		'login_form_action' => BASE . '/site/login/',
		'is_logged_in' => $isLoggedIn,
//		'return_url' => base64_encode(urlencode($Dispatcher->here)),
		'return_url' => '',
	);

	$display_template = $Smarty->load_template($params, 'login_box');
	$Smarty->display($display_template, $vars);
}

function smarty_help_function_login_box() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Allows the user to login.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{login_box}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Useful if you want to override the default content listing template. Setting this will utilize the template that matches this alias.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_login_box() {
}
?>