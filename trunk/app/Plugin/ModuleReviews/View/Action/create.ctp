<script type="text/javascript" src="{base_path}/js/modified.js"></script>
<script type="text/javascript" src="{base_path}/js/jquery/plugins/validate/jquery.validate.pack.js"></script>
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
			<textarea class="span10" name="content" id="content" cols="30" rows="10" placeholder="{lang}Review{/lang}"></textarea>
			</div>
			<button class="btn btn-inverse btn-submit-review" type="submit" name="submit" value="{lang}Submit{/lang}"><i class="icon-ok"></i> {lang}Submit{/lang}</button>
		</div>
		</form>
</div>