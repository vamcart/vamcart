<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class Contact extends AppModel {
	public $name = 'Contact';
	public $hasMany = array('ContactAnswer' => array('dependent' => true));
}
?>