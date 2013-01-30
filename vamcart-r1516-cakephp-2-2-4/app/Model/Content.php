<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class Content extends AppModel {
	public $name = 'Content';
	public $belongsTo = array('ContentType','Template');
	public $hasMany = array('ContentImage','ContentDescription' => array('dependent' => true));
	public $hasOne = array('ContentLink' => array('dependent' => true),'ContentProduct' => array('dependent' => true),'ContentPage' => array('dependent' => true),'ContentCategory' => array('dependent' => true),'ContentArticle' => array('dependent' => true),'ContentNews' => array('dependent' => true),'ContentDownloadable' => array('dependent' => true));

	public $validate = array(
		'parent_id' => array(
			'rule' => 'notEmpty'
		)
	);

}

?>