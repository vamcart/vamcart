<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class ContentDownloadable extends AppModel {
	public $name = 'ContentDownloadable';
	public $belongsTo = array('Tax');

	public $validate = array(
		'price' => array(
			'rule' => 'notEmpty'
		)
	);
}
