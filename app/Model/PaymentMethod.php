<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class PaymentMethod extends AppModel {
	public $name = 'PaymentMethod';
	public $hasMany = array('PaymentMethodValue' => array('dependent' => true));
}
?>