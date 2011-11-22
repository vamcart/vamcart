<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

class OrderStatusDescription extends AppModel {
	var $name = 'OrderStatusDescription';
	var $belongsTo = array('OrderStatus','Language');
}
?>