<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class AnswerTemplate extends AppModel {

	public $name = 'AnswerTemplate';
	public $hasMany = array('AnswerTemplateDescription' => array('dependent'     => true));

}
?>