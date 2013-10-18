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
<script type="text/javascript" src="{base_path}/js/modified.js"></script>
<script type="text/javascript" src="{base_path}/js/focus-first-input.js"></script>
{foreach from=$errors item=error}
{if $error}
<div class="alert alert-error"><i class="cus-error"></i> {$error}</div>
{/if}
{/foreach}
<form id="contentform" class="form-horizontal" name="login-form" action="{base_path}/site/register" method="post">
	<div class="control-group">
		<label class="control-label" for="name">{lang}Name{/lang}:</label>
		<div class="controls">
			<input id="name" name="customer[name]" type="text" value="{$form_data.name}" />
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="email">{lang}E-mail{/lang}:</label>
		<div class="controls">
			<input id="email" name="customer[email]" type="text" value="{$form_data.email}" />
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="password">{lang}Password{/lang}:</label>
		<div class="controls">
			<input id="password" name="customer[password]" type="password" />
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="retype">{lang}Retype Password{/lang}:</label>
		<div class="controls">
			<input id="retype" name="customer[retype]" type="password" />
		</div>
	</div>    
	<button class="btn btn-inverse" type="submit" value="{lang}Register{/lang}"><i class="icon-ok"></i> {lang}Register{/lang}</button>
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

	$display_template = $Smarty->load_template($params, 'registration_form');
	$assignments = array(
		'errors' => $errors,
		'form_data' => $form_data,
	);

	$Smarty->display($display_template, $assignments);

}

function smarty_help_function_registration_form() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays registration page.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{registration_form}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em>(<?php echo __('None') ?>)</em></li>
	</ul>
	<?php
}

function smarty_about_function_registration_form() {
}
