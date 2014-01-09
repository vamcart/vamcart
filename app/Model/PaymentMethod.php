<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class PaymentMethod extends AppModel {
	public $name = 'PaymentMethod';
	public $hasMany = array('PaymentMethodValue' => array('dependent' => true));
}
?>