{if $reviews}
	<div class="row-fluid reviews-title">
		<div class="span8 title"><h3>{lang}Reviews{/lang}: {$total}</h3></div>
	</div>
	
	{foreach from=$reviews item=review}
	<div class="media">
		<div class="media-body" itemprop="review" itemscope itemtype="http://schema.org/Review">
			<div class="inner">
				<h4 class="media-heading"><span itemscope itemtype="http://schema.org/Person" itemprop="author"><span itemprop="name">{$review.name}</span></span> - <span content="{$review.created}" itemprop="datePublished">{$review.created}</span>:</h4>
					<div class="description" itemprop="reviewBody">
						{$review.content}
					</div>
			</div>
		</div>
	</div>
	{/foreach}
	{else}
	{lang}No reviews were found for this product.{/lang}
{/if}