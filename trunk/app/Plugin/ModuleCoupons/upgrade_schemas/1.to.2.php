<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

$changes[] = "ALTER TABLE `module_coupons` ADD `num_uses` INT( 10 ) NOT NULL AFTER `amount_off_total` ;";

?>