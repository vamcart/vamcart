{if $reviews}
<div class="row-fluid reviews-title">
	<div class="span8 title"><h3>{lang}Reviews{/lang}: {$total}</h3></div>
</div>

{foreach from=$reviews item=review}
<div class="media">
	<a href="" class="pull-left"><img class="media-object" src="{base_path}/img/avatar.png" alt=""/></a>
	<div class="media-body">
		<div class="inner">
			<h4 class="media-heading">{$review.name} - {$review.created}:</h4>
				<div class="description">
					{$review.content}
				</div>
		</div>
	</div>
</div>
{/foreach}
{else}
{lang}No reviews were found for this product.{/lang}
{/if}