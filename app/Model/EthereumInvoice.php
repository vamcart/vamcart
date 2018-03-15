<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class Ethereum extends AppModel {
	public $name = 'Ethereum';
	public $useTable = false;


   public function wei2eth($wei)
   {
       return bcdiv($wei,1000000000000000000,18);
   }

}
?>