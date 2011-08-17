<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class EmailTemplate extends AppModel {

	var $name = 'EmailTemplate';
	var $hasMany = array('EmailTemplateDescription' => array('dependent'     => true));

}
?>