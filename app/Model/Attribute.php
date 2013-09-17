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
            foreach ($data['values_f'] as $k => $def_value) 
            {
                if(isset($def_value['set'])) $def_value['data'][$def_value['set']]['value'] = '1'; 
                foreach ($def_value['data'] as $value) 
                {
                    if(!isset($value['value'])) $value['value'] = '0'; 
                    //$ret_data[$key]['id'] = $value['id'];
                    $ret_data['values_attribute'][$value['id']]['parent_id'] = $k;   
                    $ret_data['values_attribute'][$value['id']]['type_attr'] = $value['type_attr'];                    
                    $ret_data['values_attribute'][$value['id']]['value'] = $value['value'];
                 }
                 if(isset($def_value['is_active']))$ret_data['is_active'][$k] = $def_value['is_active'];
                 else $ret_data['is_active'][$k] = '0';

            }        
            return $ret_data;
        }
        
  /*      public function export($data)
        {
            foreach ($data as $key => $value) 
            {
                $this->id = $value; 
                $attr = $this->read();
                if(empty($attr['']))
                //$tmp = $this->AttributeDescription->find('all',array('conditions' => array('id' => $data)));
                var_dump($tmp);
            }
        }
        
        public function import($data)
        {
            
        }
*/
}
?>