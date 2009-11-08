	<a href="/product/{$content_alias}.html">{$content_name}</a>
	<br />
	<hr />
	<div class="css_form">
	<div class="review">
	<form action="/module_reviews/action/create/" method="post">
	<input type="hidden" name="content_id" value="{$content_id}" />
	<div>
		<label for="name">Name</label>
		<input type="text" name="name" id="name" />
	</div>
	<div>
		<label for="review">Review</label>
		<textarea name="content"></textarea>
	</div>
	<div>
		<span class="button"><input type="submit" value="{lang}Submit{/lang}" /></span>
	</div>
	</form>
	</div>
</div>