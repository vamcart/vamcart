<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class EmailTemplateDescription extends AppModel {
	var $name = 'EmailTemplateDescription';
	var $belongsTo = array('EmailTemplate','Language');
}
?>