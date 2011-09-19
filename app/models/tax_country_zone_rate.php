<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class TaxCountryZoneRate extends AppModel {
	var $name = 'TaxCountryZoneRate';
	var $belongsTo = array('Tax','CountryZone');
}
?>