<div id="review_listing">
{foreach from=$reviews item=review}		
	<div class="review">	
		<div class="author">{$review.name}, {$review.created}</div>
		<div class="content">{$review.content}</div>
	</div>
{foreachelse}	
	{lang}No reviews were found for this product.{/lang}
{/foreach}				
</div>