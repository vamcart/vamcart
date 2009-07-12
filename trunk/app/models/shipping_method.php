<?php
class ShippingMethod extends AppModel {
	var $name = 'ShippingMethod';
	var $hasMany = array('ShippingMethodValue');
}
?>