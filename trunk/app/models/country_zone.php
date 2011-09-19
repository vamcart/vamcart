<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class CountryZone extends AppModel {
   var $name = 'CountryZone';
   var $belongsTo = array('Country');
}
?>