<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class EmailTemplateDescription extends AppModel {
	public $name = 'EmailTemplateDescription';
	public $belongsTo = array('EmailTemplate','Language');
}
?>