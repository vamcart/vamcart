<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

class Template extends AppModel {
	var $name = 'Template';
	var $belongsTo = array('TemplateType');
	var $hasAndBelongsToMany = array(
		'Stylesheet' => array(
			'className'    => 'Stylesheet',
			'joinTable'    => 'templates_stylesheets',
			'foreignKey'   => 'template_id',
		)
	);

	// Easy way to delete a single association
	function delete_single_association ($template_id, $stylesheet_id)
	{
		$query = "DELETE FROM `templates_stylesheets` WHERE template_id = '" . $template_id . "' AND stylesheet_id = '" . $stylesheet_id . "' LIMIT 1";
		$results = $this->query($query);
	}
}
?>
