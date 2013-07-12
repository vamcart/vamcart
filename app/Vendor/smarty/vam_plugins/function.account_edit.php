<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2013 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_account_edit()
{
$template = '
{foreach from=$errors item=error}
{if $error}
<div class="alert alert-error"><i class="cus-error"></i> {$error}</div>
{/if}
{/foreach}
<form id="account-edit" name="account-edit" action="{base_path}/site/account_edit" method="post">
<div class="label"><label for="name">{lang}Name{/lang}:</label></div><input id="name" name="customer[name]" type="text" value="{$form_data.Customer.name}" />
<br />
<div class="label"><label for="email">{lang}E-mail{/lang}:</label></div><input id="email" name="customer[email]" type="text" value="{$form_data.Customer.email}" />
<br />
<div class="label"><label for="password">{lang}Password{/lang}:</label></div><input id="password" name="customer[password]" type="password" />
<br />
<div class="label"><label for="retype">{lang}Retype Password{/lang}:</label></div><input id="retype" name="customer[retype]" type="password" />
<br />
<button class="btn" type="submit" value="{lang}Save{/lang}"><i class="cus-tick"></i> {lang}Save{/lang}</button>
</form>
';

return $template;
}


function smarty_function_account_edit($params, $template)
{
	App::uses('SmartyComponent', 'Controller/Component');
	$Smarty =& new SmartyComponent(new ComponentCollection());

	App::import('Model', 'Customer');
	$Customer =& new Customer();

	$customer_data = $Customer->find('first', array('conditions' => array('Customer.id' => $_SESSION['Customer']['customer_id'])));

	$errors = array();

	if (isset($_SESSION['FormErrors'])) {
		foreach ($_SESSION['FormErrors'] as $key => $value) {
			$errors[] = $value[0];
		}
		unset($_SESSION['FormErrors']);
	}

	$display_template = $Smarty->load_template($params, 'account_edit');
	$assignments = array(
		'errors' => $errors,
		'form_data' => $customer_data,
	);

	$Smarty->display($display_template, $assignments);

}

function smarty_help_function_account_edit() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays account edit page.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{account_edit}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em>(<?php echo __('None') ?>)</em></li>
	</ul>
	<?php
}

function smarty_about_function_account_edit() {
}
