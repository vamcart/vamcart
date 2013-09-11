<?php

function default_template_filter()
{
    $template = '
    <div class="box">
        <h5><img src="{base_path}/img/icons/menu/blocks.png" alt="" />&nbsp;{lang}Filter{/lang}</h5>
        <div class="boxContent">
            <form name="" action="{$url}" method="post">
                <div class="">
                    {foreach from=$element_list item=element}
                        {value_filter template=$element["template"] params=$element["value_list"]}
                    {/foreach}
                    <button class="btn" name="applybutton" type="submit"><i class="cus-tick"></i>
                    {lang}Apply{/lang}
                    </button>
                    <button class="btn" name="cancelbutton" type="submit"><i class="cus-cancel"></i>
                       Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
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
    
    if (empty($content['Attribute'])||$content['ContentType']['name'] != 'category') 
    {
	echo '<div></div>';
	return;
    }

    //на будущее убрать в модель
    $element_list = array();
    foreach($content['Attribute'] AS $k => $attribute)
    {
        $element_list[$k]['template'] = $attribute['AttributeTemplate']['template'];
        foreach($attribute['ValAttribute'] AS $k_v => $value)
        {
            if(isset($value['type_attr'])&&$value['type_attr']!=''&&$value['type_attr']!='def')$k_v = $value['type_attr'];//передаем тип в качестве ключа
            $element_list[$k]['value_list']['val_attribute'][$k_v]['id'] = $value['id'];
            $element_list[$k]['value_list']['val_attribute'][$k_v]['parent_id'] = $value['id'];
            $element_list[$k]['value_list']['val_attribute'][$k_v]['name'] = $value['name'];
            $element_list[$k]['value_list']['val_attribute'][$k_v]['type_attr'] = $value['type_attr'];
            if(isset($filter_list[$value['id']])) $element_list[$k]['value_list']['val_attribute'][$k_v]['val'] = $filter_list[$value['id']]['value'];
            else $element_list[$k]['value_list']['val_attribute'][$k_v]['val'] = '0';
        }
        $element_list[$k]['value_list']['id_attribute'] = $attribute['id'];
        $element_list[$k]['value_list']['name_attribute'] = $attribute['name'];
    }
    $assignments = array();
    $assignments = array('element_list' => $element_list
                        ,'url' => BASE . '/' . $content['ContentType']['name']. '/filtered/set/' . $content['Content']['alias'] . $config['URL_EXTENSION']
                        );
    $display_template = $Smarty->load_template($params, 'filter');
    $Smarty->display($display_template, $assignments);

}

function smarty_help_function_filter() 
{
    ?>
    <h3><?php echo __('What does this tag do?') ?></h3>
    <p><?php echo __('Displays a more detailed version of the user\'s cart.') ?></p>
    <h3><?php echo __('How do I use it?') ?></h3>
    <p><?php echo __('Just insert the tag into your template/page like:') ?> <code>{filter}</code></p>
    <h3><?php echo __('What parameters does it take?') ?></h3>
    <ul>
    	<li><em><?php echo __('(template)') ?></em> - <?php echo __('Overrides the default template.') ?></li>
    	<li><em><?php echo __('(showempty)') ?></em> - <?php echo __('(true or false) If set to false does not display the cart if the user has not added any items.  Defaults to false.') ?></li>		
    </ul>
    <?php
}

function smarty_about_function_filter() 
{
}
?>
