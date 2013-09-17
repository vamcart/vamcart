<?php

function default_template_compared()
{
$template = '
<div>
	<table class="contentTable">
	<tbody>
	<tr>
		<th>{lang}Atribute{/lang}</th>
		{foreach from=$element_list[0]["atributes_product"] item=product}
			<th>
			{$product.name_product}
			</th>
		{/foreach}
        </tr>   
	{foreach from=$element_list item=atribute}
		<tr>
	       	<td>{$atribute.name_attribute}</td>
		{foreach from=$atribute["atributes_product"] item=product}
			<td>
               	        {value_filter template=$atribute["template_attribute"] id_attribute=$atribute["id_attribute"] 
                                                                               name_attribute=$atribute["name_attribute"] 
                                                                               values_attribute=$product["values_attribute"]}
			</td>
		{/foreach}
		</tr>
	{/foreach}
	</tr>
	</tbody>
	</table>
</div>
';
return $template;
}


function smarty_function_compared($params)
{    
	global $content;
	App::uses('SmartyComponent', 'Controller/Component');
	$Smarty =& new SmartyComponent(new ComponentCollection());
        
        App::import('Model', 'Content');
	$Content =& new Content();

        App::import('Model', 'Attribute');
	$Attribute =& new Attribute();

	
	$content_compre_list = $_SESSION['compare_list'][$content['Content']['alias']];
	
        $Attribute->setLanguageDescriptor($_SESSION['Customer']['language_id']);
        $attr = $Attribute->find('all',array('conditions' => array('Attribute.content_id' => $content['Content']['id'] ,'Attribute.is_active' => '1' ,'Attribute.is_show_cmp' => '1')));


        $Content->unbindAll();
	$Content->bindModel(array('hasOne' => array('ContentDescription' => array(
						'className' => 'ContentDescription',
						'conditions' => 'language_id = ' . $_SESSION['Customer']['language_id']
					))));
	$Content->bindModel(array('hasMany' => array('Attribute' => array(
						'className' => 'Attribute'
                                               ,'order' => array('Attribute.order ASC')
					))));

        $content_list = $Content->find('all',array('conditions' => array('Content.id' => $content_compre_list)));

	$element_list = array();
        foreach ($attr as $k_a => $attribute) 
        {
            	$element_list[$k_a]['id_attribute'] = $attribute['Attribute']['id'];
            	$element_list[$k_a]['name_attribute'] = $attribute['Attribute']['name'];
            	$element_list[$k_a]['template_attribute'] = $attribute['AttributeTemplate']['template_compare'];
                $element_list[$k_a]['atributes_product'] = array();
                foreach ($content_list as $k_p => $product) 
                {
                    $element_list[$k_a]['atributes_product'][$k_p]['name_product'] = $product['ContentDescription']['name'];
                    $element_list[$k_a]['atributes_product'][$k_p]['values_attribute'] = array();
                    $val_attr = Set::combine($product['Attribute'],'{n}.parent_id','{n}.val');
                    foreach($attribute['ValAttribute'] AS $k_v => $value)
                    {               
		        if(isset($value['type_attr'])&&$value['type_attr']!=''
				&&$value['type_attr']!='list_value'&&$value['type_attr']!='checked_list')$k_v = $value['type_attr'];
                	$element_list[$k_a]['atributes_product'][$k_p]['values_attribute'][$k_v]['id'] = $value['id']; 
                	$element_list[$k_a]['atributes_product'][$k_p]['values_attribute'][$k_v]['name'] = $value['name'];
                	$element_list[$k_a]['atributes_product'][$k_p]['values_attribute'][$k_v]['type_attr'] = $value['type_attr'];
                	if(isset($val_attr[$value['id']])) $element_list[$k_a]['atributes_product'][$k_p]['values_attribute'][$k_v]['val'] = $val_attr[$value['id']];
                	else $element_list[$k_a]['atributes_product'][$k_p]['values_attribute'][$k_v]['val'] = $value['val'];   
                    }
                }
        }

	$assignments = array();
    	$assignments = array('element_list' => $element_list);
	$display_template = $Smarty->load_template($params, 'compared');
	$Smarty->display($display_template, $assignments);

}

function smarty_help_function_compared() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays a more detailed version of the user\'s cart.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template/page like:') ?> <code>{compare}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Overrides the default template.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_compared() {
}
?>
