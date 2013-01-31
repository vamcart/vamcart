<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	
	public $validate = array();

    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);

        $this->_validationRules();
    }

    public function _validationRules() {
        //implemented on child classes
    }	
	
	/**
	* Called by Cake after every model is saved.  
	* This method clears the cache if we're saving to one of the specified models to check.
	*
	*/			
	public function afterSave($created)
	{
		$check_models = array('Content','Template','Stylesheet','MicroTemplate','GlobalContentBlock');
		if(in_array($this->name,$check_models))
		{
			Cache::clear();
		}
	}


	/**
	* Unbinds all associated models that are attached to the current model.
	*
	* @param  array $params Array of models to un-associate
	*/		
	public function unbindAll($params = array())
	{

$unbind = array(); 
    foreach ($this->belongsTo as $model=>$info) 
    { 
      $unbind['belongsTo'][] = $model; 
    } 
    foreach ($this->hasOne as $model=>$info) 
    { 
      $unbind['hasOne'][] = $model; 
    } 
    foreach ($this->hasMany as $model=>$info) 
    { 
      $unbind['hasMany'][] = $model; 
    } 
    foreach ($this->hasAndBelongsToMany as $model=>$info) 
    { 
      $unbind['hasAndBelongsToMany'][] = $model; 
    } 
    parent::unbindModel($unbind); 

    return true;
	}
  
}
