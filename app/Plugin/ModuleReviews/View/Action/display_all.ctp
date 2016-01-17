{if $reviews}
	<div class="reviews-title" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
		<div class="title">
		<h3>{$content_name} {lang}Reviews{/lang}</h3>
		{lang}Reviews{/lang}: <span itemprop="reviewCount">{$total}</span>, {lang}Rating value{/lang}: <span itemprop="ratingValue">{$average_rating}</span>
		</div>	
	</div>
	
	{foreach from=$reviews item=review}
	<div class="media">
		<div class="media-body" itemprop="review" itemscope itemtype="http://schema.org/Review">
			<div class="inner">
					<meta itemprop="itemReviewed" content="{$review.content_name}">
					
					<h4 itemprop="name"><a href="{$review.content_url}">{$review.content_name}</a></h4>

					<a href="{$review.content_url}" class="image"><img src="{$review.content_image.image}" alt="{$review.content_name}"{if {$review.content_image.image_width} > 0} width="{$review.content_image.image_width}"{/if}{if {$review.content_image.image_height} > 0} height="{$review.content_image.image_height}"{/if} />

					<h4 class="media-heading"><span itemprop="author" itemscope itemtype="http://schema.org/Person"><span itemprop="name">{$review.name}</span></span> - <span content="{$review.created|date_format:"%Y-%m-%d"}" itemprop="datePublished">{$review.created|date_format:"%Y-%m-%d"}</span>:</h4>
				
					<div class="description" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
						{lang}Rating{/lang}: <span itemprop="ratingValue" content="{$review.rating}">{$review.rating}</span>
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