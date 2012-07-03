<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

class Content extends AppModel {
	var $name = 'Content';
	var $belongsTo = array('ContentType','Template');
	var $hasMany = array('ContentImage','ContentDescription' => array('dependent' => true));
	var $hasOne = array('ContentLink' => array('dependent' => true),'ContentProduct' => array('dependent' => true),'ContentPage' => array('dependent' => true),'ContentCategory' => array('dependent' => true),'ContentArticle' => array('dependent' => true),'ContentNews' => array('dependent' => true));

	var $validate = array(
		'parent_id' => array(
			'rule' => 'notEmpty'
		)
	);

}

?>