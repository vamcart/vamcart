<?php
class Tax extends AppModel {
	var $name = 'Tax';
	var $hasMany = array('TaxCountryZoneRate','ContentProduct');
}
?>