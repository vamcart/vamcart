<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_registration_form()
{
$template = '
{foreach from=$errors item=error}
<div class="error">{$error}</div>
{/foreach}
<form id="login-form" name="login-form" action="{base_path}/site/register" method="post">
<div class="label"><label for="firstname">{lang}Firstname{/lang}:</label></div><input id="firstname" name="customer[firstname]" type="text" value="{$form_data.firstname}" />
<br />
<div class="label"><label for="lastname">{lang}Lastname{/lang}:</label></div><input id="lastname" name="customer[lastname]" type="text" value="{$form_data.lastname}" />
<br />
<div class="label"><label for="email">{lang}E-mail{/lang}:</label></div><input id="email" name="customer[email]" type="text" value="{$form_data.email}" />
<br />
<div class="label"><label for="password">{lang}Password{/lang}:</label></div><input id="password" name="customer[password]" type="password" />
<br />
<div class="label"><label for="retype">{lang}Retype Password{/lang}:</label></div><input id="retype" name="customer[retype]" type="password" />
<br />
<br />
<span class="button"><button type="submit" value="{lang}Register{/lang}"><img src="{base_path}/img/icons/buttons/submit.png" width="12" height="12" alt="" />&nbsp;{lang}Register{/lang}</button></span>
</form>
';

return $template;
}


function smarty_function_registration_form($params, $template)
{
	App::uses('SmartyComponent', 'Controller/Component');
	$Smarty =& new SmartyComponent(new ComponentCollection());

	$errors = array();

	if (isset($_SESSION['loginFormErrors'])) {
		foreach ($_SESSION['loginFormErrors'] as $key => $value) {
			$errors[] = $value;
		}
		unset($_SESSION['loginFormErrors']);
	}

	if (isset($_SESSION['loginFormData'])) {
		$form_data = $_SESSION['loginFormData'];
		unset($_SESSION['loginFormData']);
	} else {
		$form_data = array(
			'firstname' => '',
			'lastname' => '',
			'email' => '',
		);
	}

	$display_template = $Smarty->load_template($params, 'registration_form');
	$assignments = array(
		'errors' => $errors,
		'form_data' => $form_data,
	);

	$Smarty->display($display_template, $assignments);

}

function smarty_help_function_registration_form() {
	?>
	<?php
}

function smarty_about_function_registration_form() {
}
