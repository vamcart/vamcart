<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_registration_form()
{
$template = '
<script type="text/javascript" src="{base_path}/js/modified.js"></script>
<script type="text/javascript" src="{base_path}/js/focus-first-input.js"></script>
<script type="text/javascript" src="{base_path}/js/jquery/plugins/validate/jquery.validate.pack.js"></script>
<script type="text/javascript">
$(function($){

    $(\'.form-anti-bot, .form-anti-bot-2\').hide(); // hide inputs from users
    var answer = $(\'.form-anti-bot input#anti-bot-a\').val(); // get answer
    $(\'.form-anti-bot input#anti-bot-q\').val( answer ); // set answer into other input

    if ( $(\'form#contentform input#anti-bot-q\').length == 0 ) {
        var current_date = new Date();
        var current_year = current_date.getFullYear();
        $(\'form#contentform\').append(\'<input type="hidden" name="anti-bot-q" id="anti-bot-q" value="\'+current_year+\'" />\'); // add whole input with answer via javascript to form
    }

});
</script>
<script type="text/javascript">
$(document).ready(function() {
  // validate form
  $("#contentform").validate({
    rules: {
      "customer[name]": {
        required: true,
        minlength: 2      
     },
      "customer[email]": {
        required: true,
        minlength: 6,
        email: true      
     },
		"customer[password]": {
			required: true,
			minlength: 5,
		},
		"customer[retype]": {
			required: true,
			minlength: 5,
			equalTo: "#password"
		}
    },
    messages: {
      "customer[name]": {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 2"
      },
      "customer[email]": {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 6"
      },
      "customer[password]": {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 5"
      },
      "customer[retype]": {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 5"
      }
    }
  });
});
</script>
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
			<input id="password" name="customer[password]" type="password" autocomplete="off" />
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="retype">{lang}Retype Password{/lang}:</label>
		<div class="controls">
			<input id="retype" name="customer[retype]" type="password" autocomplete="off" />
		</div>
	</div>   
	<button class="btn btn-inverse" type="submit" name="submit" value="{lang}Register{/lang}"><i class="icon-ok"></i> {lang}Register{/lang}</button>
	<div class="form-anti-bot" style="clear:both;">
		<strong>Current <span style="display:none;">month</span> <span style="display:inline;">ye@r</span> <span style="display:none;">day</span></strong> <span class="required">*</span>
		<input type="hidden" name="anti-bot-a" id="anti-bot-a" value="{$smarty.now|date_format:"%Y"}" />
		<input type="text" name="anti-bot-q" id="anti-bot-q" size="30" value="19" />
	</div>
	<div class="form-anti-bot-2" style="display:none;">
		<strong>Leave this field empty</strong> <span class="required">*</span>
		<input type="text" name="anti-bot-e-email-url" id="anti-bot-e-email-url" size="30" value=""/>
	</div>
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
