<?php
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.com
   http://vamshop.ru
   Copyright 2009 VaM Shop
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
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
							   
}
?>