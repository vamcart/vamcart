<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class EmailTemplateDescription extends AppModel {
	var $name = 'EmailTemplateDescription';
	var $belongsTo = array('EmailTemplate','Language');
}
?>