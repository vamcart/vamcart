<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class UserInstall extends AppModel {
	var $name = 'UserInstall';
	var $useTable = false;

	function hashPasswords($data)
	{
		return $data;
	}
}
