<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class User extends AppModel {

	public $name = 'User';

	public $hasMany = array('UserPref' => array('dependent'     => true));

	public function hashPasswords($data) {
		return $data;
	}
}
