<?php
class TaxCountryZoneRate extends AppModel {
	var $name = 'TaxCountryZoneRate';
	var $belongsTo = array('Tax','CountryZone');
}
?>