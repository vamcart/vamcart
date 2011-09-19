<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class EmailTemplate extends AppModel {

	var $name = 'EmailTemplate';
	var $hasMany = array('EmailTemplateDescription' => array('dependent'     => true));

}
?>