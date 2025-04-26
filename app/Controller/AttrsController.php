<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

class AttributesController extends AppController 
{
    public $name = 'Attributes';
    public $paginate = null;
    public $helpers = array('Smarty');
    
    public function admin($type = 'category' ,$id = 0)
    {              
        $this->loadModel('Content');

	$this->Content->unbindAll();

	$this->Content->unbindModel(array('hasMany' => array('ContentDescription')));
	$this->Content->bindModel(array('hasOne' => array('ContentDescription' => array(
						'className' => 'ContentDescription',
						'conditions' => 'language_id = ' . $this->Session->read('Customer.language_id')
					))));
        $this->Content->unbindModel(array('hasMany' => array('Attr')));
	$this->Content->bindModel(array('hasMany' => array('Attr' => array(
						'className' => 'Attr'
                                               ,'order' => array('Attr.order ASC')
					))));
        
        $this->Content->Attr->setLanguageDescriptor($this->Session->read('Customer.language_id'));
        
        $this->Content->bindModel(array('belongsTo' => array('ContentGroup' => array('className' => 'Content'
                                                    ,'foreignKey'    => 'id_group'))));
        $this->Content->ContentGroup->unbindAll();
	$this->Content->ContentGroup->bindModel(array('hasOne' => array('ContentDescription' => array(
						'className' => 'ContentDescription',
						'conditions' => 'language_id = ' . $this->Session->read('Customer.language_id')
					))));
        $this->Content->recursive = 2;
        
        if($type == 'category') $this->paginate['Content'] = array('conditions' => array('Content.content_type_id' => $this->Content->get_content_type('ContentCategory'))
                                          ,'limit' => '30'
                                          ,'order' => array('Content.order ASC')
                                           );
        /*else $this->paginate['Content'] = array('conditions' => array('Content.parent_id' => $id , 'Content.content_type_id = 2')
                                          ,'limit' => '30'
                                          ,'order' => array('Content.order ASC')
                                           );*/
        $content_data = $this->paginate('Content');
       
        $this->set('content_data',$content_data);
        $this->set('current_crumb', __('Listing', true));
        $this->set('title_for_layout', __('Listing', true));
        
    } 
    
    public function admin_attr ($id = 0)
    {              
        $this->admin('product' ,$id);        
    } 
    
    public function admin_editor_attr($action = 'init' ,$type = 'attr' ,$id = 0) 
    {   
        $attribute = array();
        
        switch ($action) 
	{
            case 'init':
                
            break;
            case 'add':
                $attribute['Attr']['id'] = 0;
                if ($type == 'attr') $attribute['Attr']['content_id'] = $id;
                else if ($type == 'val') $attribute['Attr']['content_id'] = 0;
                if ($type == 'attr') $attribute['Attr']['parent_id'] = 0;
                else if ($type == 'val') $attribute['Attr']['parent_id'] = $id;
                $attribute['Attr']['price_value'] = 0;
                $attribute['Attr']['order'] = 0;
                $attribute['ValAttribute'] = array();
            break;
            case 'edit':
                $this->Attr->ValAttribute->setLanguageDescriptor($this->Session->read('Customer.language_id'));
                $this->Attr->id = $id;
                $attribute = $this->Attr->read();   
                if(!empty($attribute))
                {
                    $tmp = $attribute['AttributeDescription'];
                    $attribute['AttributeDescription'] = null;
                    foreach($tmp AS $id => $value)
                    {
                        $key = $value['language_id'];
                        $attribute['AttributeDescription'][$key] = $value;
                    }
                }
                $id = $attribute['Attr']['parent_id'];
            break;
            case 'save':
                if(isset($this->data['cancelbutton']))
                {
                    if ($type == 'attr') $this->redirect('/attributes/admin_viewer_attr/' . $this->data['Attr']['content_id']);
                    else if ($type == 'val') $this->redirect('/attributes/admin_editor_attr/edit/attr/' . $this->data['Attr']['parent_id']);
                }
                $attribute = array();
                $attribute['Attr'] = $this->data['Attr'];
                foreach($this->data['Attr']['AttributeDescription'] AS $k => $value)
		{
                    $attribute['AttributeDescription'][$k]['dsc_id'] = $value['dsc_id'];
                    $attribute['AttributeDescription'][$k]['name'] = $value['name'];
                    $attribute['AttributeDescription'][$k]['language_id'] = $k;
                }
                //Сортировка
                if ($type == 'attr' && (!isset($attribute['Attr']['order']) || $attribute['Attr']['order'] == 0)) $attribute['Attr']['order'] = $this->Attr->find('count',array('conditions' => array('Attr.content_id' => $attribute['Attr']['content_id']))) + 1;
                else if ($type == 'val' && (!isset($attribute['Attr']['order']) || $attribute['Attr']['order'] == 0)) $attribute['Attr']['order'] = $this->Attr->find('count',array('conditions' => array('Attr.parent_id' => $attribute['Attr']['parent_id']))) + 1;
                if ($type == 'val')$attribute['Attr']['content_id'] = 0;
                //Создаем запись 
                if($attribute['Attr']['id'] == 0) $this->Attr->create();
                if($this->Attr->saveAll($attribute))
                {
                    if ($type == 'attr')//для атрибута создадим значения по умолчанию
                    {
                        $this->constructDefValue($attribute['Attr']['attribute_template_id'], $attribute['Attr']['id']);
                    }
                    $this->Session->setFlash(__('Attributes saved.'));
                } else $this->Session->setFlash(__('Attributes not saved!'), 'default', array('class' => 'error-message red'));  

                $this->redirect('/attributes/admin_viewer_attr_dialog/' . $this->data['Attr']['content_id']);
            break;
            case 'delete':
                $attribute = $this->Attr->read(false,$id);               
                if($this->Attr->delete($id))
                {
                    $this->Session->setFlash(__('Attributes deleted.'));
                } else $this->Session->setFlash(__('Attributes not deleted!'), 'default', array('class' => 'error-message red'));
                if ($type == 'val') {
                    $parent_attr = $this->Attr->read(false,$attribute['Attr']['parent_id']);
                    $this->redirect('/attributes/admin_viewer_attr_dialog/'  . $parent_attr['Attr']['content_id']);
                } else $this->redirect('/attributes/admin_viewer_attr_dialog/'  . $attribute['Attr']['content_id']);
            break;
            default:
                die();
            break;
        }
        
        
        $this->loadModel('Language');
        $this->set('languages', $this->Language->find('all', array('conditions' => array('active' => '1'), 'order' => array('Language.id ASC'))));
        $this->loadModel('AttributeTemplate');
        if($type == 'val') 
        {   
            $this->Attr->id = $id;
            $this->Attr->recursive = -1;
            $parent_attr = $this->Attr->read(); 
            $template = $this->AttributeTemplate->find('first',array('conditions' => array('id' => $parent_attr['Attr']['attribute_template_id'])));
            $template = unserialize($template['AttributeTemplate']['setting']);
            function v($var){return($var == 1);}
            $template = array_filter($template,"v");
            foreach ($template AS $k => $val) $template[$k] = $k;
            $this->set('template',$template);
            $attribute['Attr']['content_id'] = $parent_attr['Attr']['content_id'];
        }
        else $this->set('template', $this->AttributeTemplate->find('list'));
        $this->set('attribute',$attribute);
        $this->set('type',$type);
        $this->set('current_crumb', __('Attribute Editor', true));
	$this->set('title_for_layout', __('Attribute Editor', true)); 
    }
    
    public function admin_editor_attr_dialog($action = 'init' ,$type = 'attr' ,$id = 0) 
    {
        $this->layout = 'ajax';
        $this->autoRender = false;   
        $this->admin_editor_attr($action,$type,$id);
        $this->render('admin_editor_attr_dialog');
    }
    
    public function admin_viewer_attr($content_id = 0) 
    {
        $this->loadModel('Attr');
        $this->Attr->recursive = 2;
        $this->Attr->setLanguageDescriptor($this->Session->read('Customer.language_id'));
        $this->Attr->ValAttribute->setLanguageDescriptor($this->Session->read('Customer.language_id'));
        $attributes = $this->Attr->find('all',array('conditions' => array('Attr.content_id' => $content_id)));
        $this->set('attributes',$attributes);
        $this->set('current_crumb', __('Attributes Listing', true));
	$this->set('title_for_layout', __('Attributes Listing', true));
        $this->set('content_id', $content_id);
    }
    
    public function admin_viewer_attr_dialog($content_id = 0) 
    {
        if($this->request->isAjax()) {
            $this->layout = 'ajax';
        }
        
        $this->admin_viewer_attr($content_id);
    }    
    
    public function change_field_status($field = 'is_active' ,$id = 0, $model = 'this')
    {
        if($model == 'this') {$current_model = $this->modelClass; $current_model_name = $this->modelClass;}
        else {$this->loadModel($model); $current_model = $model; $current_model_name = $this->$model->name;}
	$this->$current_model->id = $id;
	$record = $this->$current_model->read();        
	if($record[$current_model_name][$field] == 0)
	{
            $record[$current_model_name][$field] = 1;
	}
	else
	{
            $record[$current_model_name][$field] = 0;		
	}      
	$this->$current_model->save($record);
        $this->redirect('/attributes/admin_viewer_attr_dialog/'  . $record['Attr']['content_id']);
    }
    
    public function set_group_content($content_id = 0)
    {       
        $this->loadModel('Content');
        $this->Content->id = $content_id;
        $content = $this->Content->read();
        if($content['Content']['id'] != $content['Content']['id_group'])
            $this->Content->updateAll(array('Content.id_group' => $content_id),array('Content.id' => $content_id));
        else $this->Content->updateAll(array('Content.id_group' => null),array('Content.id_group' => $content_id));
        $this->change_field_status('is_group',$content_id,'content');
    }
    
    public function change_group_content($content_id = 0)
    {
        $this->loadModel('Content');
        $this->Content->updateAll(array('Content.id_group' => ($this->data['value']==0)?null:$this->data['value']),array('Content.id' => $content_id));
        $this->Content->id = $content_id;
        $this->Content->unbindAll();
        $this->Content->bindModel(array('belongsTo' => array('ContentGroup' => array('className' => 'Content'
                                                    ,'foreignKey'    => 'id_group'))));  
        $this->Content->ContentGroup->unbindAll();
        $this->Content->ContentGroup->bindModel(array('hasOne' => array('ContentDescription' => array(
						'className' => 'ContentDescription',
						'conditions' => 'language_id = ' . $this->Session->read('Customer.language_id')
					))));
        $this->Content->recursive = 2;
        $content = $this->Content->read();        
        $this->set('return',(isset($content['ContentGroup']['alias']))?$content['ContentGroup']['ContentDescription']['name']:__('Select'));
        $this->render('/Elements/ajaxreturn');
    }
    
    public function get_groups_content($parent_content_id = 0)
    {
        $this->loadModel('Content');
        $this->Content->unbindAll();
	$this->Content->bindModel(array('hasOne' => array('ContentDescription' => array(
						'className' => 'ContentDescription',
						'conditions' => 'language_id = ' . $this->Session->read('Customer.language_id')
					))));
        $content = $this->Content->find('all',array('conditions' => array('Content.parent_id' => $parent_content_id
                                                                                                ,'Content.is_group' => 1)));
        $content = Set::combine($content,'{n}.Content.id','{n}.ContentDescription.name');

        $content[0] = __('Select');
        $this->set('return',json_encode($content));
        $this->render('/Elements/ajaxreturn');
    }
    
    public function admin_editor_value($action = 'init' ,$content_id = 0) 
    {   
        $this->loadModel('Content');
        $this->Content->Attr->setLanguageDescriptor($this->Session->read('Customer.language_id'));
        $content_data = $this->Content->find('first',array('conditions' => array('Content.id' => $content_id)));
        
        switch ($action) 
	{
            case 'init':
                
            break;
            case 'edit':
                $this->Attr->setLanguageDescriptor($this->Session->read('Customer.language_id'));
                $this->Attr->ValAttribute->setLanguageDescriptor($this->Session->read('Customer.language_id'));
                $attr_data = $this->Attr->find('all',array('conditions' => array('Attr.content_id' => $content_data['Content']['parent_id'])
                                                               ,'order' => array('Attr.order ASC')));
                $this->Attr->recursive = -1;
                
                $element_list = array();
                foreach($attr_data AS $k => $attr)
                {
                
                    $element_list[$k]['id_attribute'] = $attr['Attr']['id'];
                    $element_list[$k]['name_attribute'] = $attr['Attr']['name'];
                    $element_list[$k]['template_attribute'] = $attr['AttributeTemplate']['template_editor'];
                    $element_list[$k]['values_attribute'] = array();   
                                        
                    if($attr['AttributeTemplate']['name']=='list')
                        $element_list[$k]['values_attribute'][-1] = array(
                            'name' => __('Select Value')
                           ,'type_attr' => $attr['Attr']['type_attr']
                           ,'id' => 0
                           ,'parent_id' => 0
                           ,'val' => ''
                        );
                    
                    foreach($attr['ValAttribute'] AS $k_v => $def_val)
                    {
                        $val = $this->Attr->find('first',array('conditions' => array('Attr.content_id' => $content_id
                                                                              ,'Attr.parent_id' => $def_val['id']
                                                                               )));
                        if(isset($def_val['type_attr'])&&$def_val['type_attr']!=''
				&&$def_val['type_attr']!='list_value'&&$def_val['type_attr']!='checked_list')$k_v = $def_val['type_attr'];//Если задан тип то передаем его качестве ключа
                        $element_list[$k]['values_attribute'][$k_v]['name'] = $def_val['name']; //наследуем от родителя
                        $element_list[$k]['values_attribute'][$k_v]['type_attr'] = $def_val['type_attr']; //наследуем от родителя
                        if(empty($val))
                        {
                            $def_val['parent_id'] = $def_val['id']; //свой id ,так как родитель
                            $element_list[$k]['values_attribute'][$k_v]['id'] = '0';
                            $element_list[$k]['values_attribute'][$k_v]['parent_id'] = $def_val['id'];
                            $element_list[$k]['values_attribute'][$k_v]['val'] = $def_val['val']; //данные родителя
                        }
                        else 
                        {
                            $element_list[$k]['values_attribute'][$k_v]['id'] = $val['Attr']['id'];//id берем свой для сохранения
                            $element_list[$k]['values_attribute'][$k_v]['parent_id'] = $val['Attr']['parent_id'];
                            $element_list[$k]['values_attribute'][$k_v]['val'] = $val['Attr']['val'];
                        }
                    }
                }
                
            break;
            case 'save':
                if(isset($this->data['cancelbutton']))
                {
                    $this->redirect('/attributes/admin_attr/' . $this->data['Attr']['parent_id']);
                }
                $save_data = array();
                foreach ($this->data['values_s'] as $def_value) 
                {
                    if(isset($def_value['set'])) $def_value['data'][$def_value['set']]['value'] = '1'; 
                    foreach ($def_value['data'] as $value) 
                    {
                        if(!isset($value['value'])) $value['value'] = '0'; 
                        array_push($save_data, array('id' => $value['id']
                                                    ,'parent_id' => $value['parent_id']
                                                    ,'content_id' => $this->data['Attr']['content_id']
                                                    ,'val' => $value['value']
                                                    ));
                    }
                }
                
                if(isset($this->data['Content']['id_groups'])&&!empty($this->data['Content']['id_groups'])) {
                    $this->loadModel('Content');                        
                    $this->Content->updateAll(array('Content.id_group' => $this->data['Attr']['content_id']),array('Content.id' => $this->data['Content']['id_groups']));
                    $this->Content->updateAll(array('Content.is_group' => 1, 'Content.id_group' => $this->data['Attr']['content_id']),array('Content.id' => $this->data['Attr']['content_id']));
                } else {
                    $this->Content->updateAll(array('Content.is_group' => 0,'Content.id_group' => 0),array('Content.parent_id' => $this->data['Attr']['parent_id']
                                                                                                          ,'Content.id_group' => $this->data['Attr']['content_id']));
                }
                
                if($this->Attr->saveAll($save_data))
                {
                    $this->Session->setFlash(__('Attributes Value Saved.'));
                } else $this->Session->setFlash(__('Attributes Value Not Saved!'), 'default', array('class' => 'error-message red'));  

                $this->redirect('/attributes/admin_attr/' . $this->data['Attr']['parent_id']);
            break;
            default:
                die();
            break;
        }
        
        $this->loadModel('Language');
        $this->set('languages', $this->Language->find('all', array('conditions' => array('active' => '1'), 'order' => array('Language.id ASC'))));
        $this->set('element_list',$element_list);
        $this->set('content_id', $content_id);
        $this->set('parent_id', $content_data['Content']['parent_id']); 
        $this->set('current_crumb', __('Attributes Value Editor', true));
	$this->set('title_for_layout', __('Attributes Value Editor', true)); 
    }
    
    public function admin_editor_value_dialog($action = 'init' ,$content_id = 0)
    {
        $this->layout = 'ajax';
        $this->autoRender = false;     
        $this->admin_editor_value($action,$content_id);
        
        $this->loadModel('Content');      
        $this->Content->set_save_associations();
        $this->Content->unbindAll();
        $content = $this->Content->read(false,$content_id);        
	$this->Content->bindModel(array('hasOne' => array('ContentDescription' => array(
						'className' => 'ContentDescription',
						'conditions' => 'language_id = ' . $this->Session->read('Customer.language_id')
					))));
        
        $selected_group_contents = $this->Content->find('all',array('conditions' => array('Content.id_group' => $content_id,'Content.id <>' => $content_id,'content_type_id' => $this->Content->get_content_type('ContentProduct'))));
        $selected_group_contents = Set::combine($selected_group_contents,'{n}.Content.id','{n}.ContentDescription.name');
        $this->set('selected_group_contents',$selected_group_contents);        
        
        $group_contents = $this->Content->find('all',array('conditions' => array('Content.parent_id' => $content['Content']['parent_id'],'Content.id <>' => $content_id,'content_type_id' => $this->Content->get_content_type('ContentProduct'))));
        $group_contents = Set::combine($group_contents,'{n}.Content.id','{n}.ContentDescription.name');
        $this->set('group_contents',$group_contents);                
        
        $this->render('admin_editor_value_dialog');
    }
    
    public function constructDefValue($type_attr, $id_attr)
    {
        
    }
    
    public function admin_move ($id, $direction)
    {
	$current_model = $this->modelClass;

	$this->$current_model->id = $id;
	$current = $this->$current_model->read();
	if($direction == 'up')
		$new = $this->$current_model->find('first', array('conditions' => array($current_model.'.order < ' . $current[$current_model]['order']
                                                                                        ,$current_model.'.parent_id' => $current[$current_model]['parent_id'])
                                                                 ,'order' => $current_model.'.order DESC')); 
	else
		$new = $this->$current_model->find('first', array('conditions' => array($current_model.'.order > ' . $current[$current_model]['order']
                                                                                       ,$current_model.'.parent_id' => $current[$current_model]['parent_id'])
                                                                 ,'order' => $current_model.'.order ASC')); 
	$temp_order = $new[$current_model]['order'];
	$new[$current_model]['order'] = $current[$current_model]['order'];
	$current[$current_model]['order'] = $temp_order;
	$this->$current_model->save($new);
	$this->$current_model->save($current);
        
        $this->redirect($this->referer());	
    }
    
    public function admin_copy_attr_dialog($content_id = 0)
    {
        $this->layout = 'ajax';
        $this->set('content_id',$content_id);
    }
    
    public function admin_copy_attr()
    {
        $this->autoRender = false;
        $attributes = $this->Attr->all($this->data['Attr']['category_id']);
        foreach ($attributes as $attribute) {
            $data = array(
                'Attr' => array_merge($attribute['Attr'],array('AttributeDescription' => $attribute['AttributeDescription']))
            );
            $data['Attr']['id'] = 0;
            $data['Attr']['content_id'] = $this->data['Attr']['content_id'];
            foreach ($data['Attr']['AttributeDescription'] as $key => $value) {
                $data['Attr']['AttributeDescription'][$key]['dsc_id'] = 0;
            }
            $this->Attr->saveAll($data,array('deep' => true));
        }
        
        $this->redirect('/attributes/admin_viewer_attr_dialog/' . $this->data['Attr']['content_id']);
    }    
    
    public function admin_copy_attrvalues_dialog($content_id = 0,$attribute_id = 0)
    {
        $this->layout = 'ajax';
        
        $this->loadModel('Content');
	$this->Content->unbindAll();
	$this->Content->unbindModel(array('hasMany' => array('ContentDescription')));
	$this->Content->bindModel(array('hasOne' => array('ContentDescription' => array(
						'className' => 'ContentDescription',
						'conditions' => 'language_id = ' . $this->Session->read('Customer.language_id')
					))));
        $this->Content->unbindModel(array('hasMany' => array('Attr')));
	$this->Content->bindModel(array('hasMany' => array('Attr' => array(
						'className' => 'Attr'
                                               ,'order' => array('Attr.order ASC')
					))));
        $this->Content->Attr->setLanguageDescriptor($this->Session->read('Customer.language_id'));        
        
        $content = $this->Content->find('all',array('conditions' => array('Content.content_type_id' => $this->Content->get_content_type('ContentCategory'))));
        foreach ($content as $value) 
            foreach ($value['Attr'] as $attribute) 
                $content['return'][$value['ContentDescription']['name']][$attribute['id']] = $attribute['name'];
        $this->set('attributes',$content['return']);
        $this->set('attr_id',$attribute_id);
        $this->set('content_id',$content_id);
    }
    
    public function admin_copy_attrvalues()
    {      
        $this->autoRender = false;
        $val_attributes = $this->Attr->find('all',array('conditions' => array('Attr.parent_id' => $this->data['Attr']['parrent_id'])));
        foreach ($val_attributes as $val_attribute) {
            $data = array(
                'Attr' => array_merge($val_attribute['Attr'],array('AttributeDescription' => $val_attribute['AttributeDescription']))
            );
            $data['Attr']['id'] = 0;
            $data['Attr']['parent_id'] = $this->data['Attr']['id'];
            foreach ($data['Attr']['AttributeDescription'] as $key => $value) {
                $data['Attr']['AttributeDescription'][$key]['dsc_id'] = 0;
            }
            $this->Attr->saveAll($data,array('deep' => true));
        }   
        $this->redirect('/attributes/admin_viewer_attr_dialog/' . $this->data['Attr']['content_id']);
    }        
    
}

?>
