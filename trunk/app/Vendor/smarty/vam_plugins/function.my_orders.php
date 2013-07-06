<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2013 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_my_orders()
{
$template = '
{foreach from=$errors item=error}
<div class="error">{$error}</div>
{/foreach}
<form id="login-form" name="login-form" action="{base_path}/site/my_orders" method="post">
<div class="label"><label for="name">{lang}Name{/lang}:</label></div><input id="name" name="customer[name]" type="text" value="{$form_data.name}" />
<br />
<div class="label"><label for="email">{lang}E-mail{/lang}:</label></div><input id="email" name="customer[email]" type="text" value="{$form_data.email}" />
<br />
<div class="label"><label for="password">{lang}Password{/lang}:</label></div><input id="password" name="customer[password]" type="password" />
<br />
<div class="label"><label for="retype">{lang}Retype Password{/lang}:</label></div><input id="retype" name="customer[retype]" type="password" />
<br />
<input name="customer_id" type="hidden" value="{$smarty.session.customer_id}" />
<br />
<button class="btn" type="submit" value="{lang}Save{/lang}"><i class="cus-tick"></i> {lang}Save{/lang}</button>
</form>
';

return $template;
}


function smarty_function_my_orders($params, $template)
{
	App::uses('SmartyComponent', 'Controller/Component');
	$Smarty =& new SmartyComponent(new ComponentCollection());

	$errors = array();

	if (isset($_SESSION['loginFormErrors'])) {
		foreach ($_SESSION['loginFormErrors'] as $key => $value) {
			$errors[] = $value[0];
		}
		unset($_SESSION['loginFormErrors']);
	}

	if (isset($_SESSION['loginFormData'])) {
		$form_data = $_SESSION['loginFormData'];
		unset($_SESSION['loginFormData']);
	} else {
		$form_data = array(
			'name' => '',
			'email' => '',
		);
	}

	$display_template = $Smarty->load_template($params, 'my_orders');
	$assignments = array(
		'errors' => $errors,
		'form_data' => $form_data,
	);

	$Smarty->display($display_template, $assignments);

}

function smarty_help_function_my_orders() {
	?>
	<?php
}

function smarty_about_function_my_orders() {
}
