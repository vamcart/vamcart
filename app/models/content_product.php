<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class ContentProduct extends AppModel {
	var $name = 'ContentProduct';
	var $belongsTo = array('Tax');
	
	var $validate = array(
	'ContentProduct.price' => array(
		'rule' => 'notEmpty'
	),
	'ContentProduct.stock' => array(
		'rule' => 'notEmpty'
	)
	);
	
}
?>