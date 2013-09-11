<?php

App::uses('Model', 'AppModel');
class Attribute extends AppModel {
	public $name = 'Attribute';
	public $belongsTo = array('AttributeTemplate');
	public $hasMany = array('AttributeDescription' => array('dependent' => true)
                               ,'ValAttribute' => array('className' => 'Attribute'
                                                    ,'foreignKey'    => 'parent_id'
						    ,'dependent' => true
                                ));
        public $language__descriptor = 0;

        public function afterFind($results, $primary = false)
        {
            if($this->language__descriptor != 0)
            {
                $tmp_results = array();
    /*            $this->unbindModel(array('hasMany' => array('AttributeDescription')));
                $this->bindModel(array('hasOne' => array('AttributeDescription' => array(
                                                    'className' => 'AttributeDescription',
                                                    'conditions' => 'language_id = ' . $this->language__descriptor
                                            ))));*/
                foreach ($results AS $k => $attribute)
                {
                    $tmp_results = $this->AttributeDescription->find('first',array('conditions' => array('language_id = ' . $this->language__descriptor
                                                                                                      ,'attribute_id' => $attribute[$this->alias]['id'])));
                    if(!empty($tmp_results))$results[$k][$this->alias] = array_merge($attribute[$this->alias],array('name' => $tmp_results['AttributeDescription']['name']));
                    else $results[$k][$this->alias] = array_merge($attribute[$this->alias],array('name' => 'nill'));
                }
            }
            return $results;/*parent::afterFind($results, $primary);*/
        }
        
        public function setLanguageDescriptor($language_id)
        {
            $this->language__descriptor = $language_id;
        }
        
        public function getFilterFromFormData($data)
        {            
            $ret_data = array();
            if(isset($data['values_f']))
            foreach ($data['values_f'] as $value) 
            {
                foreach ($value['data'] as $key => $val_attr) 
                {
                    if(isset($val_attr['value'])) $ret_data[$key]['value'] = $val_attr['value'];
                    else $ret_data[$key]['value'] = '0';
                    $ret_data[$key]['type_attr'] = $val_attr['type_attr'];
                    $ret_data[$key]['id'] = $val_attr['id'];
                    if(isset($value['is_active']))$ret_data[$key]['is_active'] = $value['is_active'];
                    else $ret_data[$key]['is_active'] = '0';
                }
                if(isset($value['set'])) $ret_data[$value['set']]['value'] = '1';
            }        
            return $ret_data;
        }

}
?>