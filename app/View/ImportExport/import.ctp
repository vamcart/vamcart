<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

//echo var_dump($xml);

    foreach ($xml->shop->categories->category as $category) {
    	echo $category.'<br />';
    }

    foreach ($xml->shop->offers->offer as $product) {
    	echo $product->name.'<br />';
    }
?>