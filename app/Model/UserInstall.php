<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class UserInstall extends AppModel {
	public $name = 'UserInstall';
	public $useTable = false;

	public function hashPasswords($data)
	{
		return $data;
	}
}
