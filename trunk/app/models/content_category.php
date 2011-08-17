<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
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