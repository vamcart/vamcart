<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class Content extends AppModel {
	var $name = 'Content';
	var $belongsTo = array('ContentType','Template');
	var $hasMany = array('ContentImage','ContentDescription' => array('dependent' => true));
	var $hasOne = array('ContentLink' => array('dependent' => true),'ContentSelflink' => array('dependent' => true),'ContentProduct' => array('dependent' => true),'ContentPage' => array('dependent' => true),'ContentCategory' => array('dependent' => true),'ContentArticle' => array('dependent' => true),'ContentNews' => array('dependent' => true));

	var $validate = array(
	'parent_id' => array(
		'rule' => 'notEmpty'
	)
	);
	
}

?>