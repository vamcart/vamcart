<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
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
