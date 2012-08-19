<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

class Customer extends AppModel {
	var $name = 'Customer';

	var $validate = array(
		'firstname' => array(
			'rule' => 'alphaNumeric',
			'required' => true,
			'allowEmpty' => false,
			'message' => 'Firstname must only contain letters and numbers.'
		),
		'lastname' => array(
			'rule' => 'alphaNumeric',
			'required' => true,
			'allowEmpty' => false,
			'message' => 'Lastname must only contain letters and numbers.'
		),
		'password' => array(
			'passwordlength' => array(
				'rule' => 'notEmpty',
				'message' => 'Password can not be blank',
			),
			'passwordequal' => array(
				'rule' => 'checkpasswords',
				'message' => 'Passwords dont match'
			),
		),
		'email' => array (
			'email' => array(
				'rule' => array('email', true),
				'required' => true,
				'allowEmpty' => false,
				'message' => 'Please, input correct e-mail address',
			),
			'unique' => array (
				'rule' => 'isUnique',
				'message' => 'This email has already been taken.',
			),
		),
	);

	function checkpasswords()
	{
		return !strcmp($this->data['Customer']['password'], $this->data['Customer']['retype']);
	}

}
