<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

App::uses('Model', 'AppModel');
class AttributeDescription extends AppModel {

	public $name = 'AttributeDescription';
	public $belongsTo = array('Language','Attribute_p' => array('className' => 'Attribute'
                                                    ,'foreignKey'    => 'attribute_id'
                                ));
	public $primaryKey = 'dsc_id';
	public $validate = array(
		'attribute_id' => array(
			'rule' => 'notBlank'
		)
	);
}
