<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
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