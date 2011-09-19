<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class ContentProduct extends AppModel {
	var $name = 'ContentProduct';
	var $belongsTo = array('Tax');
	
	var $validate = array(
	'price' => array(
		'rule' => 'notEmpty'
	),
	'weight' => array(
		'rule' => 'notEmpty'
	),
	'stock' => array(
		'rule' => 'notEmpty'
	)
	);
	
}
?>