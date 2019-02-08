<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_login_box()
{
$template = '
<div class="widget inner">
		{if not $is_logged_in }
	<h3 class="widget-title">{lang}Login{/lang}</h3>
		<form action="{base_path}/site/login?return_url={$return_url}" method="post" class="form-horizontal">
			<div class="form-group">
			<label class="col-sm-2 control-label" for="inputEmail">{lang}E-mail{/lang}</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="data[Customer][email]" id="inputEmail"">
				</div>
			</div>
			<div class="form-group">
			<label class="col-sm-2 control-label" for="inputPassword">{lang}Password{/lang}</label>
				<div class="col-sm-10">
					<input type="password" class="form-control" name="data[Customer][password]" id="inputPassword" autocomplete="off">
				</div>
			</div>
			<div class="form-group">
			  <div class="col-sm-offset-2 col-sm-10">
			    <button type="submit" class="btn btn-default"><i class="fa fa-sign-in"></i> {lang}Login{/lang}</button>
			  </div>
			</div>
		</form>
		<br /><br />
		<ul class="list-inline">
		<li>{lang}Social Login:{/lang}</li>
		<li><a href="{base_path}/site/social_login/google"><i class="fa fa-google" title="Google"></i> {lang}Google{/lang}</a></li>
		<li><a href="https://oauth.vk.com/authorize?client_id={config value=VK_OAUTH_CLIENT_ID}&redirect_uri={$smarty.const.FULL_BASE_URL}{$smarty.const.BASE}/site/social_login/vk&response_type=code&display=page&scope=email"><i class="fa fa-vk" title="VK"></i> {lang}VK{/lang}</a></li>
		<li><a href="https://www.facebook.com/dialog/oauth?client_id={config value=FACEBOOK_OAUTH_CLIENT_ID}&redirect_uri={$smarty.const.FULL_BASE_URL}{$smarty.const.BASE}/site/social_login/facebook&response_type=code&display=page&scope=public_profile,email"><i class="fa fa-facebook" title="Facebook"></i> {lang}Facebook{/lang}</a></li>
		</ul>
		<ul class="list-inline">
		<li><a href="{base_path}/customer/register{config value=url_extension}">{lang}Registration{/lang}</a></li>
		<li><a href="{base_path}/customer/password_recovery{config value=url_extension}">{lang}Forgot your password?{/lang}</a></li>
		</ul>
		{else}
		<ul class="icons clearfix">
			<li><a href="{base_path}/customer/account_edit{config value=url_extension}">{lang}Account Edit{/lang}</a></li>
			<li><a href="{base_path}/customer/address_book{config value=url_extension}">{lang}Address Book{/lang}</a></li>
			<li><a href="{base_path}/customer/my_orders{config value=url_extension}">{lang}My Orders{/lang}</a></li>
		</ul>
		<form action="{base_path}/site/logout?return_url={$return_url}" method="post">
			<button type="submit" class="btn btn-default"><i class="fa fa-sign-out"></i> {lang}Logout{/lang}</button>
		</form>
		{/if}
</div>
';

return $template;
}

function smarty_function_login_box($params, $template)
{
	App::uses('SmartyComponent', 'Controller/Component');
	$Smarty = new SmartyComponent(new ComponentCollection());

	if (isset($_SESSION['Customer']['customer_id'])) {
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
	<p><?php echo __('Displays login box.') ?></p>
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