<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class ContentDownloadable extends AppModel {
	var $name = 'ContentDownloadable';
	var $belongsTo = array('Tax');

	var $validate = array(
		'price' => array(
			'rule' => 'notEmpty'
		)
	);
}
