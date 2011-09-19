<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$changes[] = "ALTER TABLE `module_coupons` ADD `num_uses` INT( 10 ) NOT NULL AFTER `amount_off_total` ;";

?>