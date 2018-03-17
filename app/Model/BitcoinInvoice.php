<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class BitcoinInvoice extends AppModel {
	public $name = 'BitcoinInvoice';

   public function value2btc($value)
   {
       return $value/100000000;
   }

   public function btc2value($value)
   {
       return $value*100000000;
   }

}
?>