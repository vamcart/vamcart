<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class TaxCountryZoneRate extends AppModel {
	var $name = 'TaxCountryZoneRate';
	var $belongsTo = array('Tax','CountryZone');
}
?>