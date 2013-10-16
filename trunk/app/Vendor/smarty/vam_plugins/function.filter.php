<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2013 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_filter()
{
    $template = '
<section class="widget inner">
	<h3 class="widget-title">{lang}Filter{/lang}</h3>
		<form name="filter" action="{$base_url}/filtered/set/{$base_content}" method="post">
			<div class="filter">
				{foreach from=$element_list item=element}
					{value_filter template=$element["template_attribute"] id_attribute=$element["id_attribute"] 
										name_attribute=$element["name_attribute"] 
										values_attribute=$element["values_attribute"]
										is_active=$element["is_active"]}
				{/foreach}
				<button class="btn btn-inverse" name="applybutton" type="submit"><i class="icon-ok"></i> {lang}Apply{/lang}</button>
				<button class="btn btn-inverse" name="cancelbutton" type="submit"><i class="icon-remove"></i> {lang}Reset{/lang}</button>
			</div>
		</form>
</section>
';
    return $template;
}


function smarty_function_filter($params)
{
    global $filter_list;
    global $content;
    global $config;
    
    App::uses('SmartyComponent', 'Controller/Component');
    $Smarty =& new SmartyComponent(new ComponentCollection());
    
    App::import('Model', 'Attribute');
    $Attribute =& new Attribute();		
    
    if (empty($content['FilteredAttribute'])||$content['ContentType']['name'] != 'category') 
    {
	return;
    }

    $element_list = array();
    foreach($content['FilteredAttribute'] AS $k => $attribute)
    {
        $element_list[$k]['id_attribute'] = $attribute['id']; //id атрибута
        $element_list[$k]['name_attribute'] = $attribute['name'];
        $element_list[$k]['template_attribute'] = $attribute['AttributeTemplate']['template_filter'];
        if(isset($filter_list['is_active'][$attribute['id']]))$element_list[$k]['is_active'] = $filter_list['is_active'][$attribute['id']];
        else $element_list[$k]['is_active'] = '0';
        $element_list[$k]['values_attribute'] = array();
        foreach($attribute['ValAttribute'] AS $k_v => $value)
        {                        
            if(isset($value['type_attr'])&&$value['type_attr']!=''
			&&$value['type_attr']!='list_value'&&$value['type_attr']!='checked_list')$k_v = $value['type_attr'];//Если задан тип то передаем его качестве ключа
            $element_list[$k]['values_attribute'][$k_v]['id'] = $value['id']; //id default значения атрибута
            $element_list[$k]['values_attribute'][$k_v]['name'] = $value['name'];
            $element_list[$k]['values_attribute'][$k_v]['type_attr'] = $value['type_attr'];
            //Если задан фильтр установим его в соответствующие значения
            if(isset($filter_list['values_attribute'][$value['id']])) $element_list[$k]['values_attribute'][$k_v]['val'] = $filter_list['values_attribute'][$value['id']]['value'];
            else $element_list[$k]['values_attribute'][$k_v]['val'] = '0';   
        }
    }
    $assignments = array();
    $assignments = array('element_list' => $element_list
                        ,'base_url' => BASE . '/' . $content['ContentType']['name']
                        ,'base_content' => $content['Content']['alias'] . $config['URL_EXTENSION']
                        );
    $display_template = $Smarty->load_template($params, 'filter');
    $Smarty->display($display_template, $assignments);

}

function smarty_help_function_filter() 
{
    ?>
    <h3><?php echo __('What does this tag do?') ?></h3>
    <p><?php echo __('Displays filter box.') ?></p>
    <h3><?php echo __('How do I use it?') ?></h3>
    <p><?php echo __('Just insert the tag into your template/page like:') ?> <code>{filter}</code></p>
    <h3><?php echo __('What parameters does it take?') ?></h3>
    <ul>
    	<li><em><?php echo __('(template)') ?></em> - <?php echo __('Overrides the default template.') ?></li>
    </ul>
    <?php
}

function smarty_about_function_filter() 
{
}
?>