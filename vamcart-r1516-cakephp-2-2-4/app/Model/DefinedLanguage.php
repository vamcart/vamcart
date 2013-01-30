<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('AppModel', 'Model');
class DefinedLanguage extends AppModel {
	public $name = 'DefinedLanguage';
	public $belongsTo = array('Language');
}
?>