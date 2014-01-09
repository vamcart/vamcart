<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

App::uses('Model', 'AppModel');
class Attribute extends AppModel {
	public $name = 'Attribute';
	public $belongsTo = array('AttributeTemplate');
	public $hasMany = array('AttributeDescription' => array('dependent' => true)
                               ,'ValAttribute' => array('className' => 'Attribute'
                                                    ,'foreignKey'    => 'parent_id'
						    ,'dependent' => true
                                                    ,'order' => array('order ASC')
                                ));
	public $validate = array(
	'price_value' => array(
		'rule' => 'numeric'
	));
        public $language__descriptor = 0;

        public function afterFind($results, $primary = false)
        {
            if($this->language__descriptor != 0)
            {
                $tmp_results = array();

                foreach ($results AS $k => $attribute)
                {
                    $tmp_results = $this->AttributeDescription->find('first',array('conditions' => array('language_id = ' . $this->language__descriptor
                                                                                                      ,'attribute_id' => $attribute[$this->alias]['id'])));
                    if(!empty($tmp_results))$results[$k][$this->alias] = array_merge($attribute[$this->alias],array('name' => $tmp_results['AttributeDescription']['name']));
                    else $results[$k][$this->alias] = array_merge($attribute[$this->alias],array('name' => 'n/a'));
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
        
        public function export($data)
        {
            $ret_data = array();
            $fields_attribute_description = array();
            $this->resetAssociations();
            foreach ($data as $value) 
            {    
                $attr = $this->find('first', array('conditions' => array('Attribute.id' => $value)));

                if(!empty($attr['ValAttribute']))
                {
                    foreach ($attr['ValAttribute'] as $key_def => $value_def) 
                    {
                        $val = $this->AttributeDescription->find('all',array('conditions' => array('attribute_id' => $value_def['id'])));
                        
                        $language = array();
                        foreach ($val AS $k => $attribute_description)
                             foreach ($attribute_description['AttributeDescription'] AS $k_d => $dsc)
                                $language['expimpdsc#' . $k . '#' . $k_d] = $dsc;
                        
                        $line = array('Attribute' => array_merge(array('table_name' => 'ValAttribute'),$value_def,$language));
                        array_push($ret_data,$line);
                        
                    }
                }
                $language = array();
                foreach ($attr['AttributeDescription'] AS $k => $attribute_description)
                {
                     foreach ($attribute_description AS $k_d => $dsc)
                     {
                        $language['expimpdsc#' . $k . '#' . $k_d] = $dsc;
                        if(!isset($fields_attribute_description['expimpdsc#' . $k . '#' . $k_d]))
                                $fields_attribute_description['expimpdsc#' . $k . '#' . $k_d] = null;
                     }
                }
                if(empty($language))$language = $fields_attribute_description;
                $line = array('Attribute' => array_merge(array('table_name' => 'Attribute'),$attr['Attribute'],$language));
                array_push($ret_data,$line);
            }
            return $ret_data;
        }
        
        public function import($data)
        {
            $attribute_data = array();
            $attribute_description_data = array();
            foreach ($data as $k_r => $row) 
            {
                foreach ($row['Attribute'] as $k_c => $cell) 
                {
                    if(stripos($k_c, '#') !== false)
                    {
                        list($pr_fld ,$dsc ,$fld) = explode('#', $k_c);
                        $attribute_description_data[$pr_fld][$dsc . '_' . $k_r][$fld] = $cell;
                    }
                    else 
                    {
                        $attribute_data[$k_r][$k_c] = $cell;
                    }
                }
            }
            foreach($attribute_description_data['expimpdsc'] AS $table_row)
            {
               $this->AttributeDescription->save($table_row);
            }
            foreach($attribute_data AS $table_row)
            {
               $this->save($table_row);
            }
        }

}
?>