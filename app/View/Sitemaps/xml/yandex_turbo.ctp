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
                   <header>
                       <h1><?php echo $product['name'] ?></h1>
                   </header>
                   <p><?php echo $product['description'] ?></p>
                  <figure>
                      <img src="<?php echo htmlentities(Router::url($product['image'], true)) ?>" />
                      <figcaption><?php echo $product['name'] ?></figcaption>
                  </figure>
               ]]>
           </turbo:content>
        </item>
<?php } ?>        
    </channel>
</rss>
