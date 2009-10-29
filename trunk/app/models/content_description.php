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