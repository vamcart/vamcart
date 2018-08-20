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
<script>
$(function () {

{if $phone_mask != ""}
new Cleave("#ship_phone", {
  numericOnly: true,
  blocks: [0, 3, 0, 3, 2, 2],
  delimiters: ["(", ")", " ", "-","-"],
});
{/if}   

  $("#contentform :input:text:visible:enabled:first").trigger("focus");

  $("form#contentform :input").on("change",function() {
    $("input[id=\'" + this.id + "\']").addClass("modified");
    $("radio[id=\'" + this.id + "\']").addClass("modified");
    $("select[id=\'" + this.id + "\']").addClass("modified");
    $("checkbox[id=\'" + this.id + "\']").addClass("modified");
    $("textarea[id=\'" + this.id + "\']").addClass("modified");
  });

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
		//"AddressBook[ship_line_2]": {
			//required: true,
			//minlength: 3,
		//},
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
      //"AddressBook[ship_line_2]": {
        //required: "{lang}Required field{/lang}",
        //minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 3"
      //},
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

    $("#ship_country").on("change",function () {
      $("#ship_state_div").load(\'{base_path}/countries/address_book_regions/\' + $(this).val());
    });

	  $("#ship_state").chosen({
	      no_results_text:"{lang}Not Found{/lang}",
	      search_contains:true,
	      placeholder_text_single:"{lang}Select{/lang}",
	      width: "100%"
	  });         

	  $("#ship_country").chosen({
	      no_results_text:"{lang}Not Found{/lang}",
	      search_contains:true,
	      placeholder_text_single:"{lang}Select{/lang}",
	      width: "100%"
	  });         
    
  });
</script>
{foreach from=$errors item=error}
{if $error}
<div class="alert alert-danger"><i class="cus-error"></i> {$error}</div>
{/if}
{/foreach}
<form id="contentform" name="address-book" action="{base_path}/site/address_book" method="post" class="form-horizontal">
<div>{lang}Shipping Information{/lang}</div>
	<div class="form-group">
		<label class="col-sm-3 control-label" for="ship_name">{lang}Name{/lang}:</label>
		<div class="col-sm-9">
			<input id="ship_name" name="AddressBook[ship_name]" class="form-control" type="text" value="{$form_data.AddressBook.ship_name}" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label" for="ship_line_1">{lang}Address Line 1{/lang}:</label>
		<div class="col-sm-9">
			<input id="ship_line_1" name="AddressBook[ship_line_1]" class="form-control" type="text" value="{$form_data.AddressBook.ship_line_1}" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label" for="ship_line_2">{lang}Address Line 2{/lang}:</label>
		<div class="col-sm-9">
			<input id="ship_line_2" name="AddressBook[ship_line_2]" class="form-control" type="text" value="{$form_data.AddressBook.ship_line_2}" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label" for="ship_city">{lang}City{/lang}:</label>
		<div class="col-sm-9">
			<input id="ship_city" name="AddressBook[ship_city]" class="form-control" type="text" value="{$form_data.AddressBook.ship_city}" />
		</div>
	</div>    
	<div class="form-group">
		<label class="col-sm-3 control-label" for="ship_country">{lang}Country{/lang}:</label>
		<div class="col-sm-9">
			<select name="AddressBook[ship_country]" class="chosen-select form-control" id="ship_country">{if $form_data.AddressBook.ship_country}{country_list selected={$form_data.AddressBook.ship_country}}{else}{country_list}{/if}</select>
		</div>
	</div>
	<div class="form-group">
	<div id="ship_state_div">
		<label class="col-sm-3 control-label" for="ship_state">{lang}State{/lang}:</label>
		<div class="col-sm-9">
			<select name="AddressBook[ship_state]" class="chosen-select form-control" id="ship_state">{if $form_data.AddressBook.ship_state}{state_list country={$form_data.AddressBook.ship_country} selected={$form_data.AddressBook.ship_state}}{else}{state_list}{/if}</select>
		</div>
	</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label" for="ship_zip">{lang}Zipcode{/lang}:</label>
		<div class="col-sm-9">
			<input id="ship_zip" name="AddressBook[ship_zip]" class="form-control" type="text" value="{$form_data.AddressBook.ship_zip}" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label" for="ship_phone">{lang}Phone{/lang}:</label>
		<div class="col-sm-9">
			<input id="ship_phone" name="AddressBook[phone]" class="form-control" type="text" value="{$form_data.AddressBook.phone}" />
		</div>
	</div>    
	<div class="form-group">
	  <div class="col-sm-offset-3 col-sm-9">
	    <button class="btn btn-default" type="submit" value="{lang}Save{/lang}"><i class="fa fa-check"></i> {lang}Save{/lang}</button>
	  </div>
	</div>
</form>
';

return $template;
}


function smarty_function_address_book($params, $template)
{
	if (!isset($_SESSION['Customer']['customer_id']) or $_SESSION['Customer']['customer_id'] == 0) {
		return;
	}

	App::uses('SmartyComponent', 'Controller/Component');
	$Smarty = new SmartyComponent(new ComponentCollection());

	App::import('Model', 'Customer');
	$Customer = new Customer();

	$customer_data = $Customer->AddressBook->find('first', array('conditions' => array('AddressBook.customer_id' => $_SESSION['Customer']['customer_id'])));

	$customer = (!$customer_data) ? false : $customer_data;

	$errors = array();

	if (isset($_SESSION['FormErrors'])) {
		foreach ($_SESSION['FormErrors'] as $key => $value) {
			$errors[] = $value[0];
		}
		unset($_SESSION['FormErrors']);
	}
	
	global $config;

	$display_template = $Smarty->load_template($params, 'address_book');
	$assignments = array(
		'errors' => $errors,
		'form_data' => $customer,
		'dadata_api_key' => $config['DADATA_API_KEY'],
		'phone_mask' => $config['PHONE_MASK']
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
