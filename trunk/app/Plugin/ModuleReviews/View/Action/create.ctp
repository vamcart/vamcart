<script type="text/javascript" src="{base_path}/js/modified.js"></script>
<script type="text/javascript" src="{base_path}/js/jquery/plugins/validate/jquery.validate.pack.js"></script>
<script type="text/javascript">
$(function($){

    $('.form-anti-bot, .form-anti-bot-2').hide(); // hide inputs from users
    var answer = $('.form-anti-bot input#anti-bot-a').val(); // get answer
    $('.form-anti-bot input#anti-bot-q').val( answer ); // set answer into other input

    if ( $('form#contentform input#anti-bot-q').length == 0 ) {
        var current_date = new Date();
        var current_year = current_date.getFullYear();
        $('form#contentform').append('<input type="hidden" name="anti-bot-q" id="anti-bot-q" value="'+current_year+'" />'); // add whole input with answer via javascript to form
    }

});
</script>
<script type="text/javascript">
$(document).ready(function() {
  // validate form
  $("#contentform").validate({
    rules: {
      name: {
        required: true,
        minlength: 3      
     },
      content: {
        required: true,
        minlength: 3      
     },
    },
    messages: {
      name: {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 3"
      },
      content: {
        required: "{lang}Required field{/lang}",
        minlength: "{lang}Required field{/lang}. {lang}Min length{/lang}: 3"
      }
    }
  });
});
</script>
<div class="row-fluid add-review">
	<h3>{lang}Add Review{/lang}</h3>
		<form action="{base_path}/module_reviews/action/create/" method="post" id="contentform">
		<input type="hidden" name="content_id" value="{$content_id}" />
		<div class="control-group">
			<div class="controls controls-row">
			<input class="span4" name="name" id="name" type="text" placeholder="{lang}Name{/lang}"/>
			</div>
			<div class="controls controls-row">
			<label>{lang}Rating{/lang}:</label>
			<label class="radio inline">
			<input name="rating" type="radio" value="1"/> 1
			</label>
			<label class="radio inline">
			<input name="rating" type="radio" value="2"/> 2
			</label>
			<label class="radio inline">
			<input name="rating" type="radio" value="3"/> 3
			</label>
			<label class="radio inline">
			<input name="rating" type="radio" value="4"/> 4
			</label>
			<label class="radio inline">
			<input name="rating" type="radio" value="5" checked /> 5
			</label>
			</div>
			<div class="controls controls-row">
			<textarea class="span10" name="content" id="content" cols="30" rows="10" placeholder="{lang}Review{/lang}"></textarea>
			</div>
			<button class="btn btn-inverse btn-submit-review" type="submit" name="submit" value="{lang}Submit{/lang}"><i class="fa fa-check"></i> {lang}Submit{/lang}</button>
			<div class="form-anti-bot" style="clear:both;">
				<strong>Current <span style="display:none;">month</span> <span style="display:inline;">ye@r</span> <span style="display:none;">day</span></strong> <span class="required">*</span>
				<input type="hidden" name="anti-bot-a" id="anti-bot-a" value="{$smarty.now|date_format:"%Y"}" />
				<input type="text" name="anti-bot-q" id="anti-bot-q" size="30" value="19" />
			</div>
			<div class="form-anti-bot-2" style="display:none;">
				<strong>Leave this field empty</strong> <span class="required">*</span>
				<input type="text" name="anti-bot-e-email-url" id="anti-bot-e-email-url" size="30" value=""/>
			</div>
		</div>
		</form>
</div>