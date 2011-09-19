<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class ContentType extends AppModel {
	var $name = 'ContentType';
	var $belongsTo = array('TemplateType');
}
?>