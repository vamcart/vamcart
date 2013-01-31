<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class ContentType extends AppModel {
	public $name = 'ContentType';
	public $belongsTo = array('TemplateType');
}
?>