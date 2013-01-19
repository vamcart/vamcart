<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('AppModel', 'Model');
class Language extends AppModel {
	var $name = 'DefinedLanguage';
	var $belongsTo = array('Language');
}
?>