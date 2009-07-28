<?php
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.com
   http://vamshop.ru
   Copyright 2009 VaM Shop
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
	var $hasOne = array('ContentLink' => array('dependent' => true),'ContentSelflink' => array('dependent' => true),'ContentProduct' => array('dependent' => true),'ContentPage' => array('dependent' => true),'ContentCategory' => array('dependent' => true));
}

?>