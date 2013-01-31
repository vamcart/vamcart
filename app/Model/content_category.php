<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
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