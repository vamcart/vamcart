<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_attribute_list()
{
    $template = '   
                {if $attr.target=="CATALOG"}
                    {foreach from=$attr.element_list item=attr_element}
                        {if isset($attr_element.values_attribute)}
                            {if $attr_element@first} <ul class="specs"> {/if}                
                                <li class="{cycle values="odd,even"}">{value_filter template=$attr_element.template.template_catalog 
                                                  id_attribute=$attr_element.values_attribute.id 
                                                  name_attribute=$attr_element.name 
                                                  values_attribute=$attr_element.values_attribute}</li>
                            {if $attr_element@last} </ul> {/if}
                        {/if}
                    {/foreach}   
                {else if $attr.target=="PRODUCT"}
                    {foreach from=$attr.element_list item=attr_element}
                        {if isset($attr_element.values_attribute)}
                            {if $attr_element@first} <ul class="specs"> {/if}                
                                <li class="{cycle values="odd,even"}">{value_filter template=$attr_element.template.template_product 
                                                  id_attribute=$attr_element.values_attribute.id 
                                                  name_attribute=$attr_element.name 
                                                  values_attribute=$attr_element.values_attribute}</li>
                            {if $attr_element@last} </ul> {/if}
                        {/if}
                    {/foreach} 
                {else if $attr.target=="PRODUCT_GROUP"}

	                 {foreach from=$attr.element_list item=attr_element}
	                     {if isset($attr_element.values_attribute)}
	                         <ul class="specs">               
	                             <li class="{cycle values="odd,even"}">{value_filter template=$attr_element.template.template_product 
	                                               id_attribute=$attr_element.values_attribute.id 
	                                               name_attribute=$attr_element.name 
	                                               values_attribute=$attr_element.values_attribute}</li>
	                         </ul>
	                     {/if}
	                 {/foreach}
	                 <br /> 

						<div id="spinner">
							<img src="{base_path}/img/ajax-loader.gif" alt="" width="31" height="31" />
						</div>
                    <script> 
                        $(document).ready(function () { 
                            global_spinner = $("#spinner");
                        });
                    </script>

                    <form id="set_attr_form" method="post" action={$base_content}>
                    {foreach from=$attr.element_list item=attr_element}
                    {if $attr_element@first}<ul class="specs">{/if}                     
                    {if $attr_element.values_attribute && $attr_element.group_attributes}                    
                        <li class="{cycle values="odd,even"}">{if !empty($attr_element.values_attribute.name)}<b>{/if}
                                {lang}Select{/lang} {$attr_element.name}:
                            {if !empty($attr_element.values_attribute.name)}</b>{/if}                                
{if $attr_element.group_attributes}
                        <ul class="attributes nav nav-pills">
                            <li class="active"><span class="active">{$attr_element.values_attribute.name}</span></li>
                        {foreach from=$attr_element.group_attributes item=attr_val}                        
                            <li class="{cycle values="odd,even"}">
                                {if $attr_val.make}<b>{/if}
                                    <a class="confirm" href={$attr_val.content_chng_url} onclick=\'$("#attr{$attr_val.values_attribute.id}").attr("value","1");\'> {$attr_val.values_attribute.name} </a>
                                    <input id="attr{$attr_val.values_attribute.id}" name="data[set_attr][{$attr_val.values_attribute.id}]" type="hidden" />
                                {if $attr_val.make}</b>{/if}
                            </li>                          
                        {/foreach}
                        </ul>
{/if}                        
                        </li>
                    {/if}                      
                    {if $attr_element@last}</ul>{/if}
                    {/foreach}
                    <script>
                    $(function () {      
                        $(".confirm").on("click",function(){            
                            var http_send = $(this).attr("href");
                            var form_data = $("#set_attr_form").serialize();
                            $.ajax({
                                    type: "POST",
                                    url: http_send,
                                    data: form_data,
                                    async: true,
                                    success: function (data, textStatus) {
                                        $("#ajaxcontent").html(data);},
                                    beforeSend: function () {
                                        global_spinner.fadeIn("fast");
                                        },
                                    complete: function () {
                                        /*global_spinner.fadeOut("slow");*/
                                        }                                                    
                                });                            
                            return false;
                        });
                    });
                    </script>
                    </form>

                {/if}
                <br />              
    ';
    return $template;
}


function smarty_function_attribute_list($params)
{  
    global $content;
    App::uses('SmartyComponent', 'Controller/Component');
    $Smarty = new SmartyComponent(new ComponentCollection());
    
    $attr = array();
    App::import('Model', 'Content');
    $Content = new Content();

    if (isset($params['product_id'])) //Для каталога
    { 
        $attr['element_list'] = $Content->getSetAttributesForProduct($params['product_id']);
        $attr['target'] = 'CATALOG';
        $attr['is_group'] = $Content->is_group($params['product_id']);
        
        $content_id = $params['product_id'];
    }
    else //Для карточки товара
    {   
        if($Content->is_group($content['Content']['id']))
        {
             $attr['element_list'] = $Content->getSetAttributesForGroup($content['Content']['id'],true);
             $attr['target'] = 'PRODUCT_GROUP';
        } else {         
            $attr['element_list'] = $Content->getSetAttributesForProduct($content['Content']['id']);
            $attr['target'] = 'PRODUCT';
        }
        $content_id = $content['Content']['id'];
    }                 

    $assignments = array();
    $assignments = array('attr' => $attr,
                         'content_id' => $content_id,    
                         'base_content' => $Content->getUrlForContent($content_id),
                         );
    $display_template = $Smarty->load_template($params, 'attribute_list');
    $Smarty->display($display_template, $assignments);

}

function smarty_help_function_attribute_list() 
{
    ?>
    <h3><?php echo __('What does this tag do?') ?></h3>
    <p><?php echo __('Displays attributes list.') ?></p>
    <h3><?php echo __('How do I use it?') ?></h3>
    <p><?php echo __('Just insert the tag into your template/page like:') ?> <code>{attribute_list}</code></p>
    <h3><?php echo __('What parameters does it take?') ?></h3>
    <ul>
        <li><em><?php echo __('(template)') ?></em> - <?php echo __('Overrides the default template.') ?></li>
    	<li><em><?php echo __('(product_id)') ?></em> - <?php echo __('Product ID.') ?></li>
      </ul>
    <?php
}

function smarty_about_function_attribute_list() 
{
}
?>
