<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('AppModel', 'Model');
class DefinedLanguage extends AppModel {
	public $name = 'DefinedLanguage';
	public $belongsTo = array('Language');
}
?>