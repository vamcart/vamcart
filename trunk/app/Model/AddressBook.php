<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2013 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class AddressBook extends AppModel {
	public $name = 'AddressBook';
	
	public function _validationRules() 
	{
	$this->validate = array(
		'ship_name' => array(
			'rule' => 'notEmpty',
			'message' => __('Name must only contain letters and numbers.', true)
		),
		'ship_line_1' => array(
			'rule' => 'notEmpty',
			'message' => __('Address Line 1 must only contain letters and numbers.', true)
		),
		'ship_city' => array(
			'rule' => 'notEmpty',
			'message' => __('City must only contain letters and numbers.', true)
		),
		'ship_state' => array(
			'rule' => 'notEmpty',
			'message' => __('State must only contain letters and numbers.', true)
		),
		'ship_country' => array(
			'rule' => 'notEmpty',
			'message' => __('Country must only contain letters and numbers.', true)
		),
		'ship_zip' => array(
			'rule' => 'Numeric',
			'required' => true,
			'allowEmpty' => false,
			'message' => __('Zipcode must only contain numbers.', true)
		),
		'phone' => array(
			'rule' => 'Numeric',
			'required' => true,
			'allowEmpty' => false,
			'message' => __('Phone must only contain numbers.', true)
		),
	);
	}


	public function login()
	{
	}

}
