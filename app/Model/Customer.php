<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
   
App::uses('Model', 'AppModel');
class Customer extends AppModel {
	public $name = 'Customer';
	public $hasOne = array('AddressBook' => array('dependent' => true));
	public $hasMany = array('CustomerMessage' => array('dependent' => true));
	public $belongsTo = array('GroupsCustomer');

	public function _validationRules() 
	{
	$this->validate = array(
		'name' => array(
			'rule'    => 'notBlank',
			'message' => __('Name must only contain letters and numbers.', true)
		),
		//'password' => array(
			//'passwordlength' => array(
				//'rule' => 'notBlank',
				//'message' => __('Password can not be blank', true)
			//),
			//'passwordequal' => array(
				//'rule' => 'checkpasswords',
				//'message' => __('Passwords don\'t match', true)
			//),
		//),
		/*'email' => array (
			'email' => array(
				'rule' => array('email', true),
				'required' => true,
				'allowEmpty' => false,
				'message' => __('Please, input correct e-mail address', true)
			),
			//'unique' => array (
				//'rule' => 'isUnique',
				//'message' => __('This email has already been taken.', true)
			//),
		),*/
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
				$data['Customer']['password'] = Security::hash($data['Customer']['password'], 'sha1', true);
			}
		}
		return $data;
	}

	public function login()
	{
	}

}
