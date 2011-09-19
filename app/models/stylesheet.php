<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class Stylesheet extends AppModel {
	var $name = 'Stylesheet';
	var $belongsTo = array('StylesheetMediaType');
	var $hasAndBelongsToMany = array('Template' =>
								array('className'    => 'Template',
                                     'joinTable'    => 'templates_stylesheets',
                                     'foreignKey'   => 'stylesheet_id',
                               ));

	var $validate = array(
	'name' => array(
		'rule' => 'notEmpty'
	)
	);
								   
}
?>