<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
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