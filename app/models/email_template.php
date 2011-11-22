<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

class EmailTemplate extends AppModel {

	var $name = 'EmailTemplate';
	var $hasMany = array('EmailTemplateDescription' => array('dependent'     => true));

}
?>