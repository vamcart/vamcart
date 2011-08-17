<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

//echo var_dump($xml);

    foreach ($xml->shop->categories->category as $category) {
    	echo $category.'<br />';
    }

    foreach ($xml->shop->offers->offer as $product) {
    	echo $product->name.'<br />';
    }
?>