<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_filter_variants()
{
    $template = '
    <div class="filter-variants">
            <ul class="list-group">
                {foreach from=$element_list item=element}
                    {if $element["filter"]["is_active"] == 1}
                            {foreach from=$element["filter"]["values_attribute"] item=value}
                                {if $value["val"] == 1}
                                    <li class="list-group-item"> 
                                        {$element["filter"]["name_attribute"]} : {$value["name"]} 
                                        <button type="button" class="close" id="clear-filter-link-{$value["id"]}">
                                            <span aria-hidden="true">×</span>
                                        </button>    
                                        <script>
                                        $(function($){
                                          $("#clear-filter-link-{$value["id"]}").click(function() {
                                            $("#value{$value["id"]}").attr("checked",false);
                                            var checked = false;
                                            $("#value{$value["id"]}").closest(".filter-group").find(".filter-value").each(function( index ) {
                                                if($(this).prop("checked"))
                                                    checked = true;
                                            });
                                            if(!checked)
                                                $("#activeval{$element["filter"]["id_attribute"]}").attr("value","0");
                                            $("#filterbutton").click();
                                          });
                                        });  
                                        </script>
                                    </li>
                                {/if}
                            {/foreach} 
                    {/if}
                {/foreach}        
            </ul>    
			<div class="filter">
				{foreach from=$element_list item=element}
					{$element["out_elements"]}
				{/foreach}
			</div>
    </div>
';
    return $template;
}


function smarty_function_filter_variants($params)
{
    global $filter_list,$filtered_attributes;
    global $content;
    global $config;

    App::uses('SmartyComponent', 'Controller/Component');
    $Smarty = new SmartyComponent(new ComponentCollection());
    
    App::import('Model', 'Attr');
    $Attribute = new Attr();
    
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
            ,'is_show_var' => $attribute['is_show_var']
            ,'base_url' => BASE . '/' . $content['ContentType']['name'] . '/' . $content['Content']['alias'] . $config['URL_EXTENSION']
            ,'url' => BASE . '/' . $content['ContentType']['name'] . '/filtered/set/'.md5(serialize($filter_list)).'/'.$content['Content']['alias'] . $config['URL_EXTENSION']
            ,'values_attribute' => $value_attributes
            ,'is_active' => (isset($filter_list['is_active'][$attribute['id']]))?$filter_list['is_active'][$attribute['id']]:0

        );
        
$links_template = '
{if $is_show_var == 1}
<ul class="attributes nav nav-pills">
{foreach from=$values_attribute item=val}
<li{if $val.val == 1 && $is_active == 1} class="active"{/if}>
	<a href="{$url}?data%5Bvalues_f%5D%5B{$id_attribute}%5D%5Bis_active%5D=1&data%5Bvalues_f%5D%5B{$id_attribute}%5D%5Bset%5D={$val.id}&data%5Bvalues_f%5D%5B{$id_attribute}%5D%5Bdata%5D%5B{$val.id}%5D%5Btype_attr%5D={$val.type_attr}&data%5Bvalues_f%5D%5B{$id_attribute}%5D%5Bdata%5D%5B{$val.id}%5D%5Bid%5D={$val.id}"{if $val.val == 1 && $is_active == 1} class="active"{/if}>
	{page_name} {$val.name}
	</a>
</li>
{/foreach}
</ul>
{/if}
';        
        
        //$element_list[$k]['out_elements'] = $Smarty->fetch($attribute['AttributeTemplate']['template_filter'],$element_list[$k]['filter']);
        $element_list[$k]['out_elements'] = $Smarty->fetch($links_template,$element_list[$k]['filter']);
    }
    $assignments = array();
    $assignments = array('element_list' => $element_list
                        ,'base_url' => BASE . '/' . $content['ContentType']['name']
                        ,'base_content' => $content['Content']['alias'] . $config['URL_EXTENSION'] 
                        ,'hash' => md5(serialize($filter_list))
                        );
    $display_template = $Smarty->load_template($params, 'filter_variants');
    $Smarty->display($display_template, $assignments);


}

function smarty_help_function_filter_variants() 
{
    ?>
    <h3><?php echo __('What does this tag do?') ?></h3>
    <p><?php echo __('Displays filter box.') ?></p>
    <h3><?php echo __('How do I use it?') ?></h3>
    <p><?php echo __('Just insert the tag into your template/page like:') ?> <code>{filter_variants}</code></p>
    <h3><?php echo __('What parameters does it take?') ?></h3>
    <ul>
    	<li><em><?php echo __('(template)') ?></em> - <?php echo __('Overrides the default template.') ?></li>
    </ul>
    <?php
}

function smarty_about_function_filter_variants() 
{
}
?>