<rss
    xmlns:yandex="http://news.yandex.ru"
    xmlns:media="http://search.yahoo.com/mrss/"
    xmlns:turbo="http://turbo.yandex.ru"
    version="2.0"
>
    <channel>
<?php foreach ($products as $product) { ?>
        <item turbo="true">
           <link><?php echo Router::url(htmlspecialchars($product['url']), true) ?></link>
           <turbo:content>
               <![CDATA[
                  <figure>
                      <img src="<?php echo htmlentities(Router::url($product['image'], true)) ?>" />
                      <figcaption><?php echo $product['name'] ?></figcaption>
                  </figure>
                   <header>
                       <h1><?php echo $product['name'] ?></h1>
                   </header>
                   <div itemscope itemtype="http://schema.org/Rating">
                       <meta itemprop="ratingValue" content="<?php echo $product['rating'] ?>">
                       <meta itemprop="bestRating" content="<?php echo $product['max_rating'] ?>">
                   </div>
                   <p><?php echo __("Price") ?>: <strong><?php echo $product['price'] ?></strong></p>
                   <button
                    formaction="<?php echo Router::url(htmlspecialchars($product['url']), true) ?>"
                    data-background-color="orange"
                    data-color="white"
                    data-primary="true"><?php echo __d("catalog", "Buy") ?></button>                   
                   <p><?php echo $product['description'] ?></p>
                   <h1><?php echo $product['name'] ?></h1>
               ]]>
           </turbo:content>
        </item>
<?php } ?>        
    </channel>
</rss>
