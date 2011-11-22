<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

//echo var_dump($xml);

    foreach ($xml->shop->categories->category as $category) {
    	echo $category.'<br />';
    }

    foreach ($xml->shop->offers->offer as $product) {
    	echo $product->name.'<br />';
    }
?>