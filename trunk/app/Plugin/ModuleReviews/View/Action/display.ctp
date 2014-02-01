{if $reviews}
	<div class="row-fluid reviews-title" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
		<div class="span8 title">
		<h3>{$content_name} {lang}Reviews{/lang}</h3>
		{lang}Reviews{/lang}: <span itemprop="reviewCount">{$total}</span>, {lang}Rating value{/lang}: <span itemprop="ratingValue">{$average_rating}</span>
		</div>	
	</div>
	
	{foreach from=$reviews item=review}
	<div class="media">
		<div class="media-body" itemprop="review" itemscope itemtype="http://schema.org/Review">
			<div class="inner">
				<h4 class="media-heading"><span itemprop="author" itemscope itemtype="http://schema.org/Person"><span itemprop="name">{$review.name}</span></span> - <span content="{$review.created|date_format:"%Y-%m-%d"}" itemprop="datePublished">{$review.created|date_format:"%Y-%m-%d"}</span>:</h4>

					<div class="description" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
						<span itemprop="ratingValue" content="{$review.rating}">{lang}Rating{/lang}: {$review.rating}</span>
					</div>

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