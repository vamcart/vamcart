<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_filter_active_name()
{
    $template = '{foreach from=$element_list item=element}
{if $element["filter"]["is_active"] == 1}
{foreach from=$element["filter"]["values_attribute"] item=value}
{if $value["val"] == 1}
{$element["filter"]["name_attribute"]} {$value["name"]}
{/if}
{/foreach} 
{/if}
{/foreach}';

	$template = str_replace("\r\n", "", $template);
	$template = str_replace("\n", "", $template);
	
    return $template;
}


function smarty_function_filter_active_name($params)
{
    global $filter_list,$filtered_attributes;
    global $content;
    global $config;

    App::uses('SmartyComponent', 'Controller/Component');
    $Smarty = new SmartyComponent(new ComponentCollection());
    
    App::import('Model', 'Attribute');
    $Attribute = new Attribute();
    
    if (empty($content['FilteredAttribute'])||$content['ContentType']['name'] != 'category')
    {
	return;
    }

    $element_list = array();
    foreach($content['FilteredAttribute'] AS $k => $attribute)
    {
        $value_attributes = array();
        foreach($attribute['ValAttribute'] AS $k_v => $value)
        {            
            if(isset($value['type_attr'])&&$value['type_attr']!=''
                        &&$value['type_attr']!='list_value'&&$value['type_attr']!='checked_list')$k_v = $value['type_attr'];//Если задан тип то передаем его качестве ключа
            $value_attributes[$k_v]['id'] = $value['id']; //id default значения атрибута         
            $value_attributes[$k_v]['name'] = $value['name'];
            $value_attributes[$k_v]['type_attr'] = $value['type_attr'];
            //Если задан фильтр установим его в соответствующие значения
            if(isset($filter_list['values_attribute'][$value['id']])) $value_attributes[$k_v]['val'] = $filter_list['values_attribute'][$value['id']]['value'];
            else $value_attributes[$k_v]['val'] = '0';             
            if(isset($filtered_attributes[$value['id']])||empty($filter_list))
                $value_attributes[$k_v]['disable'] = false;
            else $value_attributes[$k_v]['disable'] = true;
        }
     
        $element_list[$k]['filter'] = array(
            'id_attribute' => $attribute['id']
            ,'name_attribute' => $attribute['name']
            ,'values_attribute' => $value_attributes
            ,'is_active' => (isset($filter_list['is_active'][$attribute['id']]))?$filter_list['is_active'][$attribute['id']]:0
        );
        $element_list[$k]['out_elements'] = $Smarty->fetch($attribute['AttributeTemplate']['template_filter'],$element_list[$k]['filter']);
    }
    $assignments = array();
    $assignments = array('element_list' => $element_list
                        ,'base_url' => BASE . '/' . $content['ContentType']['name']
                        ,'base_content' => $content['Content']['alias'] . $config['URL_EXTENSION'] 
                        ,'hash' => md5(serialize($filter_list))
                        );
    $display_template = $Smarty->load_template($params, 'filter_active_name');
    $Smarty->display($display_template, $assignments);

}

function smarty_help_function_filter_active_name() 
{
    ?>
    <h3><?php echo __('What does this tag do?') ?></h3>
    <p><?php echo __('Displays current filter name.') ?></p>
    <h3><?php echo __('How do I use it?') ?></h3>
    <p><?php echo __('Just insert the tag into your template/page like:') ?> <code>{filter_active_name}</code></p>
    <h3><?php echo __('What parameters does it take?') ?></h3>
    <ul>
    	<li><em><?php echo __('(template)') ?></em> - <?php echo __('Overrides the default template.') ?></li>
    </ul>
    <?php
}

function smarty_about_function_filter_active_name() 
{
}
?>