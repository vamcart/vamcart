<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

class User extends AppModel {

	var $name = 'User';

	var $hasMany = array('UserPref' => array('dependent'     => true));

	function hashPasswords($data) {
		return $data;
	}
}
