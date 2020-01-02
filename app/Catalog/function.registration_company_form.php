<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_registration_company_form()
{
$template = '
<script>
$(function () {

  $("#contentform :input:text:visible:enabled:first").trigger("focus");

  $("form#contentform :input").on("change",function() {
    $("input[id=\'" + this.id + "\']").addClass("modified");
    $("radio[id=\'" + this.id + "\']").addClass("modified");
    $("select[id=\'" + this.id + "\']").addClass("modified");
    $("checkbox[id=\'" + this.id + "\']").addClass("modified");
    $("textarea[id=\'" + this.id + "\']").addClass("modified");
  });

    $(\'.form-anti-bot, .form-anti-bot-2\').hide(); // hide inputs from users
    var answer = $(\'.form-anti-bot input#anti-bot-a\').val(); // get answer
    $(\'.form-anti-bot input#anti-bot-q\').val( answer ); // set answer into other input

    if ( $(\'form#contentform input#anti-bot-q\').length == 0 ) {
        var current_date = new Date();
        var current_year = current_date.getFullYear();
        $(\'form#contentform\').append(\'<input type="hidden" name="anti-bot-q" id="anti-bot-q" value="\'+current_year+\'" />\'); // add whole input with answer via javascript to form
    }

  // validate form
  $("#contentform").validate({
    rules: {
      "customer[inn]": {
        required: true,
        minlength: 10      
     },
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
      "customer[inn]": {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 10"
      },
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
<div class="alert alert-danger"><i class="cus-error"></i> {$error}</div>
{/if}
{/foreach}
<form id="contentform" name="login-form" action="{base_path}/site/register" method="post" class="form-horizontal">
	<div class="form-group">
		<label class="col-sm-3 control-label" for="name">{lang domain="default"}INN{/lang}:</label>
		<div class="col-sm-9">
			<input id="inn" name="customer[inn]" class="form-control" type="text" value="{$form_data.inn}" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label" for="name">{lang domain="default"}Company Name{/lang}:</label>
		<div class="col-sm-9">
			<input id="name" name="customer[name]" class="form-control" type="text" value="{$form_data.name}" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label" for="name">{lang domain="default"}OGRN{/lang}:</label>
		<div class="col-sm-9">
			<input id="ogrn" name="customer[ogrn]" class="form-control" type="text" value="{$form_data.ogrn}" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label" for="name">{lang domain="default"}KPP{/lang}:</label>
		<div class="col-sm-9">
			<input id="kpp" name="customer[kpp]" class="form-control" type="text" value="{$form_data.kpp}" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label" for="name">{lang}City{/lang}::</label>
		<div class="col-sm-9">
			<input id="city" name="customer[company_city]" class="form-control" type="text" value="{$form_data.company_city}" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label" for="name">{lang}State{/lang}::</label>
		<div class="col-sm-9">
			<select name="customer[company_state]" class="form-control" id="state">{state_list}</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label" for="email">{lang}E-mail{/lang}:</label>
		<div class="col-sm-9">
			<input id="email" name="customer[email]" class="form-control" type="text" value="{$form_data.email}" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label" for="password">{lang}Password{/lang}:</label>
		<div class="col-sm-9">
			<input id="password" name="customer[password]" class="form-control" type="password" autocomplete="off" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label" for="retype">{lang}Retype Password{/lang}:</label>
		<div class="col-sm-9">
			<input id="retype" name="customer[retype]" class="form-control" type="password" autocomplete="off" />
		</div>
	</div>   
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
					{lang}By clicking button you are agree to our policy.{/lang} <a href="{base_path}/page/conditions-of-use.html" target="_blank">{lang}Terms & Conditions.{/lang}</a>
		</div>
	</div>
	<p id="message"></p>
	<div class="form-group">
	  <div class="col-sm-offset-3 col-sm-9">
	    <button id="continue" class="btn btn-default" type="submit" name="submit" value="{lang}Register{/lang}" disabled><i class="fa fa-check"></i> {lang}Register{/lang}</button>
	  </div>
	</div>
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
{if $dadata_api_key != "" and $smarty.session.Config.language == "ru"}
<link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@18.8.0/dist/css/suggestions.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<!--[if lt IE 10]>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxtransport-xdomainrequest/1.0.1/jquery.xdomainrequest.min.js"></script>
<![endif]-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/suggestions-jquery@18.8.0/dist/js/jquery.suggestions.min.js"></script>
<script>
(function($) {

// DaData.Ru Suggestions 

var token = "{$dadata_api_key}";

var $party = $("#inn");
var $message = $("#message");
var $continue = $("#continue");
var selectedParty;

function selectParty(suggestion) {
  console.log(suggestion);
  $message.text("Отлично, можно продолжать регистрацию! Нажмите кнопку Регистрация для подтверждения регистрации.");
  selectedParty = suggestion.data;
  $continue.prop("disabled", false);
  
  $("#name").val(suggestion.data.name.short_with_opf);
  $("#inn").val(suggestion.data.inn);
  $("#ogrn").val(suggestion.data.ogrn);
  $("#kpp").val(suggestion.data.kpp);
  $("#city").val(suggestion.data.address.data.city_with_type);
  $("#state option:contains(" + suggestion.data.address.data.region_with_type + ")").attr("selected", "selected");
}

function selectNone() {
  selectedParty = null;
  $message.text("Вы не ввели компанию");
  $continue.prop("disabled", true);
}

$party.suggestions({
  token: "{$dadata_api_key}",
  type: "PARTY",
  onSelect: selectParty,
  onSelectNothing: selectNone
});

})(jQuery);
  
</script>
{/if}
';

return $template;
}


function smarty_function_registration_company_form($params, $template)
{
	App::uses('SmartyComponent', 'Controller/Component');
	$Smarty = new SmartyComponent(new ComponentCollection());

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

	$display_template = $Smarty->load_template($params, 'registration_company_form');
	
	global $config;

	$assignments = array(
		'errors' => $errors,
		'dadata_api_key' => $config['DADATA_API_KEY'],
		'form_data' => $form_data,
	);

	$Smarty->display($display_template, $assignments);

}

function smarty_help_function_registration_company_form() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays company registration page.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{registration_form}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em>(<?php echo __('None') ?>)</em></li>
	</ul>
	<?php
}

function smarty_about_function_registration_company_form() {
}
