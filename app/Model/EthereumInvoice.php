<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class EthereumInvoice extends AppModel {
	public $name = 'EthereumInvoice';

   public function wei2eth($wei)
   {
       return bcdiv($wei,1000000000000000000,18);
   }

   public function eth2wei($eth)
   {
       return bcmul($eth,1000000000000000000);
   }

}
?>