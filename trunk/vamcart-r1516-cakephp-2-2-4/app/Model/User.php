<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class User extends AppModel {

	public $name = 'User';

	public $hasMany = array('UserPref' => array('dependent'     => true));

	public function hashPasswords($data) {
		return $data;
	}
}
