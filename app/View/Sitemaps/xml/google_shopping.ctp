<?php echo '<?xml version="1.0"?>'; ?>
<?php echo '<rss version="2.0" 
xmlns:g="http://base.google.com/ns/1.0">'; ?>
<?php echo '<channel>'; ?>
<?php echo '<title>' . $sitename .'</title>'; ?>
<?php echo '<link>' . Router::url('/', true) . '</link>'; ?>
<?php echo '<description>' . $sitename . '</description>'; ?>

<?php foreach ($products as $product) { ?>
            <item>
                <title><?php echo $this->Text->truncate($product['name'],140,array('ellipsis' => '','exact' => false,'html' => true)); ?></title>
                <link><?php echo Router::url($product['url'], true) ?></link>
                <description>
                <?php echo $product['description'] ?>
                </description>
                <g:image_link><?php echo htmlentities(Router::url($product['image'], true)) ?></g:image_link>
                <g:price><?php echo $product['price'] ?></g:price>
                <g:condition>новый</g:condition>
                <g:availability>in stock</g:availability>
                <g:id><?php echo $product['id']; ?></g:id>
                <?php if ($product['google_shopping_category_id'] > 0) { ?><g:google_product_category><?php echo $product['google_shopping_category_id']; ?></g:google_product_category><?php } ?>
            </item>
<?php } ?>
</channel>
</rss>