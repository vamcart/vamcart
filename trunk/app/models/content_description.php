<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class ContentDescription extends AppModel {

	var $name = 'ContentDescription';
	var $belongsTo = array('Language');
	
	var $validate = array(
	'content_id' => array(
		'rule' => 'notEmpty'
	)
	);
		
}

?>