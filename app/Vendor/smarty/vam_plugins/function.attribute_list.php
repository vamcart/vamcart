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
                            {if $attr_element@first} <ul> {/if}                
                                <li>
                                    {value_filter template=$attr_element.template.template_catalog 
                                                  id_attribute=$attr_element.values_attribute.id 
                                                  name_attribute=$attr_element.name 
                                                  values_attribute=$attr_element.values_attribute} 
                                </li>
                            {if $attr_element@last} </ul> {/if}
                        {/if}
                    {/foreach}                
                {else if $attr.target=="PRODUCT"}
                    {foreach from=$attr.element_list item=attr_element}
                        {if isset($attr_element.values_attribute)}
                            {if $attr_element@first} <ul> {/if}                
                                <li>
                                    {value_filter template=$attr_element.template.template_product 
                                                  id_attribute=$attr_element.values_attribute.id 
                                                  name_attribute=$attr_element.name 
                                                  values_attribute=$attr_element.values_attribute} 
                                </li>
                            {if $attr_element@last} </ul> {/if}
                        {/if}
                    {/foreach} 
                {else if $attr.target=="PRODUCT_GROUP"}
						<div id="spinner">
							<img src="{base_path}/img/ajax-loader.gif" alt="" />
						</div>
                    <script type="text/javascript"> 
                        //<![CDATA[
                        $(document).ready(function () { 
                            global_spinner = $("#spinner");
                        });
                        //]]>
                    </script> 

                    <form id="set_attr_form" method="post" action={$base_content}>
                    {foreach from=$attr.element_list item=attr_element}
                        {if $attr_element@first}<ul>{/if}                     
                        <li>
                            {if $attr_element.make}<b>{/if}
                                {$attr_element.name}
                                {$attr_element.values_attribute.name}
                            {if $attr_element.make}</b>{/if}                                
                        <ul class="sub-menu">
                        {foreach from=$attr_element.group_attributes item=attr_val}                        
                            <li>
                                {if $attr_val.make}<b>{/if}
                                    <a class="confirm" href={$attr_val.content_chng_url} onclick=\'$("#attr{$attr_val.values_attribute.id}").attr("value","1");\'> {$attr_val.values_attribute.name} </a>
                                    <input id="attr{$attr_val.values_attribute.id}" name="data[set_attr][{$attr_val.values_attribute.id}]" type="hidden" />
                                {if $attr_val.make}</b>{/if}
                            </li>                          
                        {/foreach}
                        </ul>
                        </li>
                        {if $attr_element@last}</ul>{/if}                      
                    {/foreach}
                    <script type="text/javascript">      
                        //<![CDATA[
                        $(".confirm").click(function(){            
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

                        //]]>
                    </script>                
                    </form>
                {/if}              
    ';
    return $template;
}


function smarty_function_attribute_list($params)
{  
    global $content;
    App::uses('SmartyComponent', 'Controller/Component');
    $Smarty =& new SmartyComponent(new ComponentCollection());
    
    $attr = array();
    App::import('Model', 'Content');
    $Content =& new Content();

    if (isset($params['product_id'])) //Для каталога
    { 
        $attr['element_list'] = $Content->getSetAttributesForProduct($params['product_id']);
        $attr['target'] = 'CATALOG';
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
    $assignments = array('attr' => $attr
                        ,'base_content' => $Content->getUrlForContent($content_id));
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
