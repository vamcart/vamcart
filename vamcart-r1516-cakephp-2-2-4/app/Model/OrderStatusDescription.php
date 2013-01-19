<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class OrderStatusDescription extends AppModel {
	var $name = 'OrderStatusDescription';
	var $belongsTo = array('OrderStatus','Language');
}
?>