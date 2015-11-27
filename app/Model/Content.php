<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
   
App::uses('Model', 'AppModel');
class Content extends AppModel {
	public $name = 'Content';
	public $belongsTo = array('ContentType','Template');
	public $hasMany = array('ContentImage','ContentDescription' => array('dependent' => true),'Attribute' => array('dependent' => true));
	public $hasOne = array('ContentLink' => array('dependent' => true),'ContentProduct' => array('dependent' => true),'ContentPage' => array('dependent' => true),'ContentCategory' => array('dependent' => true),'ContentArticle' => array('dependent' => true),'ContentNews' => array('dependent' => true),'ContentDownloadable' => array('dependent' => true),'ContentManufacturer' => array('dependent' => true), 'ContentSpecial' => array('dependent' => true));
        
        
	public $hasAndBelongsToMany = array(
	    'xsell' =>
		array(
		    'className' => 'Content',
		    'join_table' => 'contents_contents',
		    'associationForeignKey' => 'related_id',
		    'foreignKey' => 'product_id',
		    'unique' => true
		)
	);
        
        private $save_associations = false;
        private $associations = null;

        public function set_save_associations($save = true)   {
            $this->save_associations = $save;       
        }
        
	public function beforeFind($queryData)   {
		//$this->query("SET SQL_MODE=''");
		//$this->query("SET SQL_BIG_SELECTS=1");
            if($this->save_associations) {
                $this->associations['hasOne'] = $this->hasOne;
                $this->associations['hasMany'] = $this->hasMany;
                $this->associations['belongsTo'] = $this->belongsTo;
                $this->associations['hasAndBelongsToMany'] = $this->hasAndBelongsToMany;
            }
	}
        
        public function afterFind($results, $primary = false)
        {
            if($this->save_associations) {
                $this->hasOne = $this->associations['hasOne'];
                $this->hasMany = $this->associations['hasMany'];
                $this->belongsTo = $this->associations['belongsTo'];
                $this->hasAndBelongsToMany = $this->associations['hasAndBelongsToMany'];
            }
            return $results;
        }
	
	public $validate = array(
		'parent_id' => array(
			'rule' => 'notEmpty'
		)
	);
        
        public function getAliasForContent($content_id = 0)
        {   
            $alias = null;
            global $config;
            if($content_id == 0&&isset($this->id)) $content_id = $this->id;
            $this->unbindAll();
            $content = $this->find('first', array('conditions' => array('Content.id' => $content_id)));
            if(isset($content['Content']['alias']))
                $alias = $content['Content']['alias'];
            return $alias;            
        }
        
        public function getUrlForContent($content_id = 0, $base_type = null)
        {
            $url = null;            
            global $config;
            if($content_id == 0&&isset($this->id)) $content_id = $this->id;
            $this->unbindAll();
            $this->bindModel(array('belongsTo' => array('ContentType' => array('className' => 'ContentType'))));
            $this->bindModel(array('hasOne' => array('ContentLink' => array('className' => 'ContentLink'))));	
            $content = $this->find('first', array('conditions' => array('Content.id' => $content_id)));
            if(isset($content))
                if($content['ContentType']['name'] == 'link')
                    $url = $content['ContentLink']['url'];
                else
                    $url = BASE . '/' . ((isset($base_type))?$base_type:$content['ContentType']['name']) . '/' . $content['Content']['alias'] . $config['URL_EXTENSION'];
            return $url;
        }

        public function getStockForContent($content_id = 0)
        {
            global $config;
            if($content_id == 0&&isset($this->id)) $content_id = $this->id;
            $this->unbindAll();
            $this->bindModel(array('belongsTo' => array('ContentType' => array('className' => 'ContentType'))));
            $this->bindModel(array('hasOne' => array('ContentProduct' => array('className' => 'ContentProduct'))));	
            $content = $this->find('first', array('conditions' => array('Content.id' => $content_id)));
            $stock = $content['ContentProduct']['stock'];
            return $stock;
        }

        public function getPriceForContent($content_id = 0)
        {
            global $config;
            if($content_id == 0&&isset($this->id)) $content_id = $this->id;
            $this->unbindAll();
            $this->bindModel(array('belongsTo' => array('ContentType' => array('className' => 'ContentType'))));
            $this->bindModel(array('hasOne' => array('ContentProduct' => array('className' => 'ContentProduct'))));	
            $content = $this->find('first', array('conditions' => array('Content.id' => $content_id)));
            $price = $content['ContentProduct']['price'];
            return $price;
        }

                
        public function is_group($content_id = 0)
        {
            if($content_id == 0&&isset($this->id)) $content_id = $this->id;
            $is_group = false;
            if($content_id == 0&&isset($this->id)) $content_id = $this->id;
            $this->unbindAll();           
            $product = $this->find('first', array('conditions' => array('id' => $content_id,'id_group IS NOT NULL', 'id_group <>' => 0)));
            if(!empty($product)) $is_group = true;
            return $is_group;
        }
        
        public function getGroup($content_id = 0)
        {
            if($content_id == 0&&isset($this->id)) $content_id = $this->id;
            $this->unbindAll();
            $product = $this->find('first', array('conditions' => array('id' => $content_id,'id_group IS NOT NULL', 'id_group <>' => 0)));
            if(!empty($product))
                return $product['Content']['id_group'];
            else
                return null;
        }
        
        public function getSetAttributesForGroup($content_id = 0, $unique = false)
        {
            global $make_attr_product;
            $current_group_list_attr = $this->__getListSetAttributesForProduct($content_id);
            $list_attr = $this->getSetAttributesForProduct($content_id);
            $list_attr = Set::combine($list_attr,'{n}.id','{n}');        
            $this->unbindAll();          
            $products = $this->find('list', array('fields' => array('id','parent_id'),'conditions' => array('id_group' => $this->getGroup($content_id), 'Content.id <>' => $content_id)));                      
            foreach($products AS $product_id => $product_parent_id)
            {
                $group_list_attr = $this->getSetAttributesForProduct($product_id);               
                foreach($group_list_attr AS $attr)
                {
                    if($current_group_list_attr[$attr['values_attribute']['id']] == 0&&$attr['values_attribute'] != null)
                    {
                        $attr['content_id'] = $product_id;
                        $attr['content_alias'] = $this->getAliasForContent($product_id);
                        $attr['content_stock'] = $this->getStockForContent($product_id);
                        $attr['content_price'] = $this->getPriceForContent($product_id);
                        $attr['content_chng_url'] = $this->getUrlForContent($product_id,'product');
                        if($list_attr[$attr['id']]['values_attribute']['id'] != $make_attr_product)$attr['make'] = false;
                        if($unique) //Проверим на уникальность
                        {
                            $key_unique = true;
                            foreach($list_attr[$attr['id']]['group_attributes'] AS $set_attr)
                            {
                                if($set_attr['values_attribute']['id'] == $attr['values_attribute']['id']
                                   &&$set_attr['values_attribute']['set_val'] == $attr['values_attribute']['set_val']
                                   ) $key_unique = false;
                            }
                            if($key_unique) $list_attr[$attr['id']]['group_attributes'] = array_merge($list_attr[$attr['id']]['group_attributes'],array($attr));
                        }
                        else $list_attr[$attr['id']]['group_attributes'] = array_merge($list_attr[$attr['id']]['group_attributes'],array($attr));
                    }
                }
            }
            return $list_attr;
        }
        
        public function getSetAttributesForProduct($content_id = 0)
        {
            return $this->getListAttributesForProduct($content_id, true);
        }
        
        private function __getListSetAttributesForProduct($content_id = 0)
        {
            if($content_id == 0&&isset($this->id)) $content_id = $this->id;
            $this->unbindAll();
            $this->bindModel(array('hasMany' => array('SetAttributes' => array('className' => 'Attribute'))));
            $product = $this->find('first', array('conditions' => array('id' => $content_id/*, 'content_type_id' => 2*/)));
            $value_list = array();
            if(!empty($product))
            {                
                foreach($product['SetAttributes'] AS $set_values_attribute)
                {
                    $value_list[$set_values_attribute['parent_id']] = $set_values_attribute['val'];
                }
            }
            return $value_list;
        }
                
        public function getListAttributesForProduct($content_id = 0, $is_set = false)
        {
            global $make_attr_product;            
            if($content_id == 0&&isset($this->id)) $content_id = $this->id;
            $this->unbindAll();
            $product = $this->find('first', array('conditions' => array('id' => $content_id/*, 'content_type_id' => 2*/)));
            $attr_list = array();
            $value_list = $this->__getListSetAttributesForProduct($content_id);
            $this->unbindAll();            
            $this->bindModel(array('hasMany' => array('Attributes' => array('className' => 'Attribute'
                                                                               ,'conditions' =>array('Attributes.is_active' => '1')))));
            $this->Attributes->unbindAll();
            $this->Attributes->bindModel(array('hasMany' => array('DefValAttributes' => array('className' => 'Attribute'
                                                    ,'foreignKey'    => 'parent_id'
						    ,'dependent' => true
                                                    //,'conditions' => array('DefValAttributes.id' => 2)
                                                    ,'order' => array('order ASC')
                                                    ))));
            $this->Attributes->bindModel(array('belongsTo' => array('AttributeTemplate' => array('className' => 'AttributeTemplate'))));
            $this->recursive = 2;
            $this->Attributes->setLanguageDescriptor($_SESSION['Customer']['language_id']);
            $this->Attributes->DefValAttributes->setLanguageDescriptor($_SESSION['Customer']['language_id']);
            $parent_group = $this->find('first', array('conditions' => array('id' => $product['Content']['parent_id']/*, 'content_type_id' => 1*/)
                                                    ,'order' => array('order ASC') 
                                                    ));
				if ($parent_group) {                                                    
            foreach($parent_group['Attributes'] AS $key_attr => $attribute)
            {
                $attr_list[$key_attr]['id'] = $attribute['id'];
                $attr_list[$key_attr]['name'] = $attribute['name'];
                $attr_list[$key_attr]['template'] = $attribute['AttributeTemplate'];
                //if(isset($value_list[$make_attr_product])&&$value_list[$make_attr_product]!=0)$attr_list[$key_attr]['make'] = true;         
                $attr_list[$key_attr]['make'] = false;         
                $attr_list[$key_attr]['group_attributes'] = array();
                foreach($attribute['DefValAttributes'] AS $key_val => $values_attribute)
                {
                    //Для установленных значений добавлена проверка на checked_list
                    if(isset($value_list[$values_attribute['id']])&&($value_list[$values_attribute['id']]!= 0||$is_set==false||$values_attribute['type_attr']=='checked_list' ||$values_attribute['type_attr']=='any_value'))
                    {
                        $attr_list[$key_attr]['values_attribute'][$key_val]['id'] = $values_attribute['id'];
                        $attr_list[$key_attr]['values_attribute'][$key_val]['name'] = $values_attribute['name'];
                        $attr_list[$key_attr]['values_attribute'][$key_val]['type_attr'] = $values_attribute['type_attr'];
                        $attr_list[$key_attr]['values_attribute'][$key_val]['default_val'] = $values_attribute['val'];
                        $attr_list[$key_attr]['values_attribute'][$key_val]['set_val'] = (isset($value_list[$values_attribute['id']]))?$value_list[$values_attribute['id']]:null;                          
                    }
                }
                //Для установленных значений добавлена проверка на checked_list
                if($is_set&&$values_attribute['type_attr']!='checked_list')$attr_list[$key_attr]['values_attribute'] = empty($attr_list[$key_attr]['values_attribute']) ? null : reset($attr_list[$key_attr]['values_attribute']);
            }     
            }          
            return $attr_list;            
        }
        
        public function get_childrens($content_id = null, $get_categories = false, $is_first = true)
        {
            $childrens = array();
            if(!isset($content_id)&&isset($this->id)) $content_id = $this->id;
            $content = $this->find('all',array('conditions' => array('Content.parent_id' => $content_id)));
            foreach ($content as $value) {
                $children = $this->get_childrens($value['Content']['id'],$get_categories,false);             
                if(key(current($children)) == 'Content') {
                    if($get_categories) $childrens[] = $value;
                    foreach ($children as $key => $child) {
                        if($is_first) $children[$key]['Tree'] = array($content_id);
                        $children[$key]['Tree'] = array_merge((isset($children[$key]['Tree'])?$children[$key]['Tree']:array()),array($value['Content']['id']));            
                    }
                    $childrens = array_merge($childrens,$children);
                } else $childrens[] = $children;
            }          
            if(!empty($childrens)) return $childrens;
            else {
                if($is_first) return false;
                else $this->find('first',array('conditions' => array('Content.id' => $content_id)));
            }
        }
        
        public function get_parents($content_id = null, $is_first = true)
        {     
            $parents = array();
            if(!isset($content_id)&&isset($this->id)) $content_id = $this->id;
            $content = $this->find('first',array('conditions' => array('Content.id' => $content_id)));
            if(!empty($content)) $parent_content = $this->find('first',array('conditions' => array('Content.id' => $content['Content']['parent_id'])));        
            if($parent_content['Content']['parent_id'] != 0) $parents = array_merge(array($parent_content),$this->get_parents($parent_content['Content']['id'],false));
            else $parents = array($parent_content);              
            return $parents;
        }
        
        public function get_content_type($type_name = null)
        {
            $types = $this->ContentType->find('list',array('fields' => array('id','id'),'conditions' => array('type' => $type_name)));
            if(is_array($type_name))
                return $types;
            else return current($types);
        }
        
}

?>