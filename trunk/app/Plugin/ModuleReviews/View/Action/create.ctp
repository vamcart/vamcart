<div class="row-fluid add-review">
	<h3>{lang}Add Review{/lang}</h3>
		<form action="{base_path}/module_reviews/action/create/" method="post">
		<input type="hidden" name="content_id" value="{$content_id}" />
			<div class="controls controls-row">
			<input class="span4" name="name" type="text" placeholder="{lang}Name{/lang}"/>
			</div>
			<textarea class="span12" name="content" id="content" cols="30" rows="10" placeholder="{lang}Review{/lang}"></textarea>
			<button class="btn btn-inverse btn-submit-review" type="submit" value="{lang}Submit{/lang}"><i class="icon-ok"></i> {lang}Submit{/lang}</button>
		</form>
</div>