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

   public function wei2btc($wei)
   {
       return bcdiv($wei,1000000000000000000,18);
   }

   public function btc2wei($eth)
   {
       return bcmul($eth,1000000000000000000);
   }

}
?>