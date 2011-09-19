<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class Event extends AppModel {
	var $name = 'Event';
	var $hasMany = array('EventHandler');
}
?>