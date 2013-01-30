<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class Customer extends AppModel {
	public $name = 'Customer';

	public function _validationRules() 
	{
	$this->validate = array(
		'firstname' => array(
			'rule' => 'alphaNumeric',
			'required' => true,
			'allowEmpty' => false,
			'message' => __('Firstname must only contain letters and numbers.', true)
		),
		'lastname' => array(
			'rule' => 'alphaNumeric',
			'required' => true,
			'allowEmpty' => false,
			'message' => __('Lastname must only contain letters and numbers.', true)
		),
		'password' => array(
			'passwordlength' => array(
				'rule' => 'notEmpty',
				'message' => __('Password can not be blank', true)
			),
			'passwordequal' => array(
				'rule' => 'checkpasswords',
				'message' => __('Passwords don\'t match', true)
			),
		),
		'email' => array (
			'email' => array(
				'rule' => array('email', true),
				'required' => true,
				'allowEmpty' => false,
				'message' => __('Please, input correct e-mail address', true)
			),
			'unique' => array (
				'rule' => 'isUnique',
				'message' => __('This email has already been taken.', true)
			),
		),
	);
	}

	public function checkpasswords()
	{
		return !strcmp($this->data['Customer']['password'], $this->data['Customer']['retype']);
	}

	public function hashPasswords($data)
	{
		if(isset($data['Customer'])) {
			if (isset($data['Customer']['password'])) {
				$data['Customer']['password'] = md5($data['Customer']['password']);
			}
		}
		return $data;
	}

	public function login()
	{
	}

}
