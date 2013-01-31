<?php echo '<?xml version="1.0" encoding="utf-8"?>' . "\n" ?>
<!DOCTYPE yml_catalog SYSTEM "shops.dtd">
<yml_catalog date="<?php echo date('Y-m-d H:m'); ?>">
    <shop>
        <name><?php echo $sitename ?></name>
        <company><?php echo $sitename ?></company>
        <url><?php echo Router::url('/', true) ?></url>
        <currencies>
<?php foreach($currencies as $currency) { ?>
            <currency id="<?php echo $currency['id'] ?>" rate="<?php echo $currency['rate'] ?>" />
<?php } ?>
        </currencies>
        <categories>
<?php foreach ($categories as $category) { ?>
            <category id="<?php echo $category['id'] ?>" <?php if ($category['parentId'] > 0) { echo 'parentId="' . $category['parentId'] . '"';} ?>><?php echo $category['name'] ?></category>
<?php } ?>
        </categories>
        <offers>
<?php foreach ($products as $product) { ?>
            <offer id="<?php echo $product['id'] ?>" available="true">
                <url><?php echo Router::url($product['parentId'], true) ?></url>
                <price><?php echo $product['price'] ?></price>
                <currencyId><?php echo $default_currency ?></currencyId>
                <categoryId><?php echo $product['parentId'] ?></categoryId>
                <picture><?php echo htmlentities(Router::url($product['image'], true)) ?></picture>
                <name><?php echo $product['name'] ?></name>
                <description>
                <?php echo $product['description'] ?>
                </description>
            </offer>
<?php } ?>
        </offers>
    </shop>
</yml_catalog>
