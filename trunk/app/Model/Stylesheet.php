<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class Stylesheet extends AppModel {
	public $name = 'Stylesheet';
	public $belongsTo = array('StylesheetMediaType');
	public $hasAndBelongsToMany = array('Template' =>
								array('className'    => 'Template',
                                     'joinTable'    => 'templates_stylesheets',
                                     'foreignKey'   => 'stylesheet_id',
                               ));

	public $validate = array(
	'name' => array(
		'rule' => 'notEmpty'
	)
	);
								   
}
?>