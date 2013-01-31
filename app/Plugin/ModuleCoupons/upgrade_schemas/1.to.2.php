<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

$changes[] = "ALTER TABLE `module_coupons` ADD `num_uses` INT( 10 ) NOT NULL AFTER `amount_off_total` ;";

?>