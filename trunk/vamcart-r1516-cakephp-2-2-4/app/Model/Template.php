<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class Template extends AppModel {
	public $name = 'Template';
	public $belongsTo = array('TemplateType');
	public $hasAndBelongsToMany = array(
		'Stylesheet' => array(
			'className'    => 'Stylesheet',
			'joinTable'    => 'templates_stylesheets',
			'foreignKey'   => 'template_id',
		)
	);

	// Easy way to delete a single association
	public function delete_single_association ($template_id, $stylesheet_id)
	{
		$query = "DELETE FROM `templates_stylesheets` WHERE template_id = '" . $template_id . "' AND stylesheet_id = '" . $stylesheet_id . "' LIMIT 1";
		$results = $this->query($query);
	}
}
?>
