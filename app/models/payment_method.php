<?php
class PaymentMethod extends AppModel {
	var $name = 'PaymentMethod';
	var $hasMany = array('PaymentMethodValue');
}
?>