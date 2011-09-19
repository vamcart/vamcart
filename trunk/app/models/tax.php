<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class Tax extends AppModel {
	var $name = 'Tax';
	var $hasMany = array('TaxCountryZoneRate','ContentProduct');
}
?>