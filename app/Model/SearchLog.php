<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class SearchLog extends AppModel {
	public $name = 'SearchLog';

	public $virtualFields = array(
		'total' => 'count(SearchLog.keyword)'
	);
}
?>