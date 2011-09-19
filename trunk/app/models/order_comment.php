<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class OrderComment extends AppModel {
	var $name = 'OrderComment';
	var $belongsTo = array('Order','User');
}
?>