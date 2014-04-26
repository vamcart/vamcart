<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

App::uses('Model', 'AppModel');
class GroupsCustomer extends AppModel {
	public $name = 'GroupsCustomer';
	public $hasMany = array('GroupsCustomerDescription' => array('dependent' => true));

        public function _validationRules() 
	{
            $this->validate = array('price' => array('rule' => array('range', 0, 100)
						,'message' => __('Please enter a number between 0 and 100',true)
                                ));
        }

}
