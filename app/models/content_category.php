<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class ContentCategory extends AppModel {
	var $name = 'ContentCategory';
	
	var $validate = array(
	'content_id' => array(
		'rule' => 'notEmpty'
	)
	);
	
}
?>