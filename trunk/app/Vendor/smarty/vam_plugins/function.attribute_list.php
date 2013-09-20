<?php

function default_template_atribute_list()
{
    $template = '
                <div>
                <ul>
                    {foreach from=$element_list item=element}
                        {value_filter template=$element["template_attribute"] id_attribute=$element["id_attribute"] 
                                                                              name_attribute=$element["name_attribute"] 
                                                                              values_attribute=$element["values_attribute"]}
                    {/foreach}
                </ul>
                </div>
    ';
    return $template;
}


function smarty_function_atribute_list($params)
{
    global $content;
    App::uses('SmartyComponent', 'Controller/Component');
    $Smarty =& new SmartyComponent(new ComponentCollection());

    if (!empty($content['Attribute'])) 
    {
    
        $element_list = array();
        foreach($content['Attribute'] AS $k => $attribute)
        {
            $element_list[$k]['id_attribute'] = $attribute['id']; //id атрибута
            $element_list[$k]['name_attribute'] = $attribute['name'];
            $element_list[$k]['template_attribute'] = $attribute['AttributeTemplate']['template_catalog'];
            $element_list[$k]['values_attribute'] = array();
            foreach($attribute['ValAttribute'] AS $k_v => $value)
            {                        
                if(isset($value['type_attr'])&&$value['type_attr']!=''
			&&$value['type_attr']!='list_value'&&$value['type_attr']!='checked_list')$k_v = $value['type_attr'];//Если задан тип то передаем его качестве ключа
                $element_list[$k]['values_attribute'][$k_v]['id'] = $value['id']; //id default значения атрибута
                $element_list[$k]['values_attribute'][$k_v]['name'] = $value['name'];
                $element_list[$k]['values_attribute'][$k_v]['type_attr'] = $value['type_attr'];
                if(isset($params['value_atributes'][$value['id']])) $element_list[$k]['values_attribute'][$k_v]['val'] = $params['value_atributes'][$value['id']]['value'];
                else $element_list[$k]['values_attribute'][$k_v]['val'] = $value['val'];           
            }
        }
    }
    elseif(isset($content['Content']['parent_id'])) 
    {    
        App::import('Model', 'Attribute');
        $Attribute =& new Attribute();
        $Attribute->setLanguageDescriptor($_SESSION['Customer']['language_id']);
        $attr = $Attribute->find('all',array('conditions' => array('Attribute.content_id' => $content['Content']['parent_id'] ,'Attribute.is_active' => '1')));
        $Attribute->recursive = -1;
        $val_attr = $Attribute->find('all',array('conditions' => array('Attribute.content_id' => $content['Content']['id'])));
        $val_attr = Set::combine($val_attr,'{n}.Attribute.parent_id','{n}.Attribute.val');
        foreach ($attr as $k => $attribute) 
        {
            $element_list[$k]['id_attribute'] = $attribute['Attribute']['id']; //id атрибута
            $element_list[$k]['name_attribute'] = $attribute['Attribute']['name'];
            $element_list[$k]['template_attribute'] = $attribute['AttributeTemplate']['template_product'];
            $element_list[$k]['values_attribute'] = array();
            foreach($attribute['ValAttribute'] AS $k_v => $value)
            {
                if(isset($value['type_attr'])&&$value['type_attr']!=''
			&&$value['type_attr']!='list_value'&&$value['type_attr']!='checked_list')$k_v = $value['type_attr'];//Если задан тип то передаем его качестве ключа
                $element_list[$k]['values_attribute'][$k_v]['id'] = $value['id']; //id default значения атрибута
                $element_list[$k]['values_attribute'][$k_v]['name'] = $value['name'];
                $element_list[$k]['values_attribute'][$k_v]['type_attr'] = $value['type_attr'];
                if(isset($val_attr[$value['id']])) $element_list[$k]['values_attribute'][$k_v]['val'] = $val_attr[$value['id']];
                else $element_list[$k]['values_attribute'][$k_v]['val'] = $value['val'];   
            }
        }
    }
    else
    {
        return;
    }

    
    $assignments = array();
    $assignments = array('element_list' => $element_list);
    $display_template = $Smarty->load_template($params, 'atribute_list');
    $Smarty->display($display_template, $assignments);

}

function smarty_help_function_atribute_list() 
{
    ?>
    <h3><?php echo __('What does this tag do?') ?></h3>
    <p><?php echo __('Displays a more detailed version of the user\'s cart.') ?></p>
    <h3><?php echo __('How do I use it?') ?></h3>
    <p><?php echo __('Just insert the tag into your template/page like:') ?> <code>{value_filter}</code></p>
    <h3><?php echo __('What parameters does it take?') ?></h3>
    <ul>
        <li><em><?php echo __('(template)') ?></em> - <?php echo __('Тело шаблона.') ?></li>
    	<li><em><?php echo __('(values_attribute)') ?></em> - <?php echo __('Значения атрибута.') ?></li>
      </ul>
    <?php
}

function smarty_about_function_atribute_list() 
{
}
?>
