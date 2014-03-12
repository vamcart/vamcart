<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_address_book()
{
$template = '
<script type="text/javascript" src="{base_path}/js/modified.js"></script>
<script type="text/javascript" src="{base_path}/js/focus-first-input.js"></script>
<script type="text/javascript" src="{base_path}/js/jquery/plugins/validate/jquery.validate.pack.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  // validate form
  $("#contentform").validate({
    rules: {
      "AddressBook[ship_name]": {
        required: true,
        minlength: 3      
     },
      "AddressBook[ship_line_1]": {
        required: true,
        minlength: 3,
     },
		"AddressBook[ship_line_2]": {
			required: true,
			minlength: 3,
		},
		"AddressBook[ship_city]": {
			required: true,
			minlength: 3,
		},
      "AddressBook[ship_country]": {
        required: true,
     },
      //"AddressBook[ship_state]": {
        //required: true,
     //},
		"AddressBook[ship_zip]": {
			required: true,
			minlength: 3,
		},
		"AddressBook[phone]": {
			required: true,
			minlength: 3,
		}
    },
    messages: {
      "AddressBook[ship_name]": {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 3"
      },
      "AddressBook[ship_line_1]": {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 3"
      },
      "AddressBook[ship_line_2]": {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 3"
      },
      "AddressBook[ship_city]": {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 3"
      },
      "AddressBook[ship_country]": {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 3"
      },
      //"AddressBook[ship_state]": {
        //required: "{lang}Required field{/lang}",
      //},
      "AddressBook[ship_zip]": {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 3"
      },
      "AddressBook[phone]": {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 3"
      }
    }
  });
});
</script><script type="text/javascript">
  $(document).ready(function() {
    $("#ship_country").change(function () {
      $("#ship_state_div").load(\'{base_path}/countries/address_book_regions/\' + $(this).val());
    });
  });
</script>
{foreach from=$errors item=error}
{if $error}
<div class="alert alert-error"><i class="cus-error"></i> {$error}</div>
{/if}
{/foreach}
<form id="contentform" class="form-horizontal" name="address-book" action="{base_path}/site/address_book" method="post">
<div>{lang}Shipping Information{/lang}</div>
	<div class="control-group">
		<label class="control-label" for="ship_name">{lang}Name{/lang}:</label>
		<div class="controls">
			<input id="ship_name" name="AddressBook[ship_name]" type="text" value="{$form_data.AddressBook.ship_name}" />
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="ship_line_1">{lang}Address Line 1{/lang}:</label>
		<div class="controls">
			<input id="ship_line_1" name="AddressBook[ship_line_1]" type="text" value="{$form_data.AddressBook.ship_line_1}" />
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="ship_line_2">{lang}Address Line 2{/lang}:</label>
		<div class="controls">
			<input id="ship_line_2" name="AddressBook[ship_line_2]" type="text" value="{$form_data.AddressBook.ship_line_2}" />
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="ship_city">{lang}City{/lang}:</label>
		<div class="controls">
			<input id="ship_city" name="AddressBook[ship_city]" type="text" value="{$form_data.AddressBook.ship_city}" />
		</div>
	</div>    
	<div class="control-group">
		<label class="control-label" for="ship_country">{lang}Country{/lang}:</label>
		<div class="controls">
			<select name="AddressBook[ship_country]" id="ship_country">{country_list selected={$form_data.AddressBook.ship_country}}</select>
		</div>
	</div>
	<div class="control-group">
	<div id="ship_state_div">
		<label class="control-label" for="ship_state">{lang}State{/lang}:</label>
		<div class="controls">
			<select name="AddressBook[ship_state]" id="ship_state">{state_list country={$form_data.AddressBook.ship_country} selected={$form_data.AddressBook.ship_state}}</select>
		</div>
	</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="ship_zip">{lang}Zipcode{/lang}:</label>
		<div class="controls">
			<input id="ship_zip" name="AddressBook[ship_zip]" type="text" value="{$form_data.AddressBook.ship_zip}" />
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="ship_phone">{lang}Phone{/lang}:</label>
		<div class="controls">
			<input id="ship_phone" name="AddressBook[phone]" type="text" value="{$form_data.AddressBook.phone}" />
		</div>
	</div>    
	<button class="btn btn-inverse" type="submit" value="{lang}Save{/lang}"><i class="fa fa-check"></i> {lang}Save{/lang}</button>
</form>
';

return $template;
}


function smarty_function_address_book($params, $template)
{
	App::uses('SmartyComponent', 'Controller/Component');
	$Smarty =& new SmartyComponent(new ComponentCollection());

	App::import('Model', 'Customer');
	$Customer =& new Customer();

	$customer_data = $Customer->AddressBook->find('first', array('conditions' => array('AddressBook.customer_id' => $_SESSION['Customer']['customer_id'])));
	$errors = array();

	if (isset($_SESSION['FormErrors'])) {
		foreach ($_SESSION['FormErrors'] as $key => $value) {
			$errors[] = $value[0];
		}
		unset($_SESSION['FormErrors']);
	}

	$display_template = $Smarty->load_template($params, 'address_book');
	$assignments = array(
		'errors' => $errors,
		'form_data' => $customer_data,
	);

	$Smarty->display($display_template, $assignments);

}

function smarty_help_function_address_book() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays address book page.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{address_book}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em>(<?php echo __('None') ?>)</em></li>
	</ul>
	<?php
}

function smarty_about_function_address_book() {
}
