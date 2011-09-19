<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class OrderProduct extends AppModel {
	var $name = 'OrderProduct';
	
	var $belongsTo = array('Content');
}
?>