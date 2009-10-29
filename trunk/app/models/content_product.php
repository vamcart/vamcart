<?php
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.com
   http://vamshop.ru
   Copyright 2009 VaM Shop
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
	'price' => array(
		'rule' => 'notEmpty'
	),
	'stock' => array(
		'rule' => 'notEmpty'
	)
	);
	
}
?>