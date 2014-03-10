<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_compared()
{
$template = '
<!-- start: Page section -->
	<section class="span9 page-sidebar pull-right">
		<h2>{page_name}</h2>  

		<!-- start: products listing -->
		<div class="row-fluid shop-products">
			<ul class="thumbnails">
				{foreach from=$element_list[0]["attributes_product"] item=node}
				<li class="item span4 {if $node@index is div by 3}first{/if}">
					<div class="thumbnail text-center">
						<a href="{$node.url}" class="image"><img src="{$node.image}" alt="{$node.name}"{if {$node.image_width} > 0} width="{$node.image_width}"{/if}{if {$node.image_height} > 0} height="{$node.image_height}"{/if} /><span class="frame-overlay"></span><span class="price">{$node.price}</span></a>
					<div class="inner notop nobottom text-left">
						<h4 class="title"><a href="{$node.url}">{$node.name}</a></h4>
						<div class="description">{$node.short_description|strip_tags|truncate:30:"...":true}</div>
					</div>
					</div>
					{product_form product_id={$node.id}}
					<div class="inner darken notop">
						<button class="btn btn-add-to-cart" type="submit"><i class="icon-shopping-cart"></i> {lang}Buy{/lang}</button>
						{if isset($is_compare)}<a href="{base_path}/category/addcmp/{$node.alias}/{$content_alias->value}{$ext}" class="btn btn-add-to-cart"><i class="icon-bookmark"></i> {lang}Compare{/lang}</a>{/if}
					</div>
					{/product_form}
				</li>
				{/foreach}
			</ul>
		</div>  
		<!-- end: products listing -->

			<!-- start: compare_table -->
			<table class="contentTable">
			<tbody>
			<tr>
				<th>{lang}Comparison{/lang}</th>
				{foreach from=$element_list[0]["attributes_product"] item=product}
					<th>
					{$product.name}
					</th>
				{/foreach}
			</tr>   
			{foreach from=$element_list item=attribute}
				<tr>
			       	<td>{$attribute.name_attribute}</td>
				{foreach from=$attribute["attributes_product"] item=product}
					<td>
		               	        {value_filter template=$attribute["template_attribute"] id_attribute=$attribute["id_attribute"] 
		                                                                               name_attribute=$attribute["name_attribute"] 
		                                                                               values_attribute=$product["values_attribute"]}
					</td>
				{/foreach}
				</tr>
			{/foreach}
			</tbody>
			</table>
			<!-- end: compare_table -->

	</section>
<!-- end: Page section -->
';
return $template;
}


function smarty_function_compared($params)
{    
	global $content;
	
	$compare_elements = implode(".", $_SESSION['compare_list'][$content['Content']['alias']]);
	
	// Cache the output.
	$cache_name = 'vam_compared' . (isset($params['template'])?'_'.$params['template']:'') . '_' . $content['Content']['id'] . '_' . $_SESSION['Customer']['language_id'] . '_' . $compare_elements;
	$output = Cache::read($cache_name, 'catalog');
	if($output === false)
	{
	ob_start();
		
	App::uses('SmartyComponent', 'Controller/Component');
	$Smarty =& new SmartyComponent(new ComponentCollection());
        
        App::import('Model', 'Content');
	$Content =& new Content();

        App::import('Model', 'Attribute');
	$Attribute =& new Attribute();

	
	$content_compare_list = $_SESSION['compare_list'][$content['Content']['alias']];
	
        $Attribute->setLanguageDescriptor($_SESSION['Customer']['language_id']);
        $attr = $Attribute->find('all',array('conditions' => array('Attribute.content_id' => $content['Content']['id'] ,'Attribute.is_active' => '1' ,'Attribute.is_show_cmp' => '1')));


		$Content->unbindAll();

		$Content->bindModel(array('hasOne' => array(
				'ContentDescription' => array(
                    'className' => 'ContentDescription',
					'conditions'   => 'language_id = '.$_SESSION['Customer']['language_id']
                ))));
		$Content->bindModel(array('belongsTo' => array(
				'ContentType' => array(
                    'className' => 'ContentType'
					))));			
		$Content->bindModel(array('hasOne' => array(
				'ContentImage' => array(
                    'className' => 'ContentImage',
                    'conditions'=>array('ContentImage.order' => '1')
					))));						
		$Content->bindModel(array('hasOne' => array(
				'ContentLink' => array(
                    'className' => 'ContentLink'
					))));		
		$Content->bindModel(array('hasOne' => array(
				'ContentProduct' => array(
                    'className' => 'ContentProduct'
					))));

		$Content->bindModel(array('hasMany' => array('Attribute' => array(
						'className' => 'Attribute'
                                               ,'order' => array('Attribute.order ASC')
					))));

        $content_list = $Content->find('all',array('recursive' => 2, 'conditions' => array('Content.id' => $content_compare_list)));

	$element_list = array();
	$CurrencyBase =& new CurrencyBaseComponent(new ComponentCollection());

        foreach ($attr as $k_a => $attribute) 
        {
            	$element_list[$k_a]['id_attribute'] = $attribute['Attribute']['id'];
            	$element_list[$k_a]['name_attribute'] = $attribute['Attribute']['name'];
            	$element_list[$k_a]['template_attribute'] = $attribute['AttributeTemplate']['template_compare'];
                $element_list[$k_a]['attributes_product'] = array();
                foreach ($content_list as $k_p => $product) 
                {
                    $element_list[$k_a]['attributes_product'][$k_p]['name'] = $product['ContentDescription']['name'];
                    $element_list[$k_a]['attributes_product'][$k_p]['description']	= $product['ContentDescription']['description'];
                    $element_list[$k_a]['attributes_product'][$k_p]['short_description']	= $product['ContentDescription']['short_description'];
                    $element_list[$k_a]['attributes_product'][$k_p]['meta_title']	= $product['ContentDescription']['meta_title'];
                    $element_list[$k_a]['attributes_product'][$k_p]['meta_description']	= $product['ContentDescription']['meta_description'];
                    $element_list[$k_a]['attributes_product'][$k_p]['meta_keywords']	= $product['ContentDescription']['meta_keywords'];
                    $element_list[$k_a]['attributes_product'][$k_p]['id']	= $product['Content']['id'];
                    $element_list[$k_a]['attributes_product'][$k_p]['alias']	= $product['Content']['alias'];
                    $element_list[$k_a]['attributes_product'][$k_p]['price']	= $CurrencyBase->display_price($product['ContentProduct']['price']);	
                    $element_list[$k_a]['attributes_product'][$k_p]['stock']	= $product['ContentProduct']['stock'];	
                    $element_list[$k_a]['attributes_product'][$k_p]['model']	= $product['ContentProduct']['model'];	
                    $element_list[$k_a]['attributes_product'][$k_p]['weight']	= $product['ContentProduct']['weight'];	

								global $config;

								// Content Image
								
								if($product['ContentImage']['image'] != "") {
									$image_url = $product['Content']['id'] . '/' . $product['ContentImage']['image'];
									$thumb_name = substr_replace($product['ContentImage']['image'] , '', strrpos($product['ContentImage']['image'] , '.')).'-'.$config['THUMBNAIL_SIZE'].'.png';	
									$thumb_path = IMAGES . 'content' . '/' . $product['Content']['id'] . '/' . $thumb_name;
									$thumb_url = BASE . '/img/content/' . $product['Content']['id'] . '/' . $thumb_name;
					
										if(file_exists($thumb_path) && is_file($thumb_path)) {
											list($width, $height, $type, $attr) = getimagesize($thumb_path);
											$element_list[$k_a]['attributes_product'][$k_p]['image'] =  $thumb_url;
											$element_list[$k_a]['attributes_product'][$k_p]['image_width'] = $width;
											$element_list[$k_a]['attributes_product'][$k_p]['image_height'] = $height;
										} else {
											$element_list[$k_a]['attributes_product'][$k_p]['image'] = BASE . '/images/thumb/' . $image_url;
											$element_list[$k_a]['attributes_product'][$k_p]['image_width'] = null;
											$element_list[$k_a]['attributes_product'][$k_p]['image_height'] = null;
										}
					
								} else { 
					
									$image_url = '0/noimage.png';
									$thumb_name = 'noimage-'.$config['THUMBNAIL_SIZE'].'.png';	
									$thumb_path = IMAGES . 'content' . '/0/' . $thumb_name;
									$thumb_url = BASE . '/img/content' . '/0/' . $thumb_name;
					
										if(file_exists($thumb_path) && is_file($thumb_path)) {
											list($width, $height, $type, $attr) = getimagesize($thumb_path);
											$element_list[$k_a]['attributes_product'][$k_p]['image'] =  $thumb_url;
											$element_list[$k_a]['attributes_product'][$k_p]['image_width'] = $width;
											$element_list[$k_a]['attributes_product'][$k_p]['image_height'] = $height;
										} else {
											$element_list[$k_a]['attributes_product'][$k_p]['image'] = BASE . '/images/thumb/' . $image_url;
											$element_list[$k_a]['attributes_product'][$k_p]['image_width'] = null;
											$element_list[$k_a]['attributes_product'][$k_p]['image_height'] = null;
										}
					
								}									
												
								if($product['ContentType']['name'] == 'link')
								{
									$element_list[$k_a]['attributes_product'][$k_p]['url'] = $product['ContentLink']['url'];
								}
								else
								{
									$element_list[$k_a]['attributes_product'][$k_p]['url']	= BASE . '/' . $product['ContentType']['name'] . '/' . $product['Content']['alias'] . $config['URL_EXTENSION'];
								}
                    
                    $element_list[$k_a]['attributes_product'][$k_p]['values_attribute'] = array();
                    $val_attr = Set::combine($product['Attribute'],'{n}.parent_id','{n}.val');
                    foreach($attribute['ValAttribute'] AS $k_v => $value)
                    {               
		        if(isset($value['type_attr'])&&$value['type_attr']!=''
				&&$value['type_attr']!='list_value'&&$value['type_attr']!='checked_list')$k_v = $value['type_attr'];
                	$element_list[$k_a]['attributes_product'][$k_p]['values_attribute'][$k_v]['id'] = $value['id']; 
                	$element_list[$k_a]['attributes_product'][$k_p]['values_attribute'][$k_v]['name'] = $value['name'];
                	$element_list[$k_a]['attributes_product'][$k_p]['values_attribute'][$k_v]['type_attr'] = $value['type_attr'];
                	if(isset($val_attr[$value['id']])) $element_list[$k_a]['attributes_product'][$k_p]['values_attribute'][$k_v]['val'] = $val_attr[$value['id']];
                	else $element_list[$k_a]['attributes_product'][$k_p]['values_attribute'][$k_v]['val'] = $value['val'];   
                    }
                }
        }

	$assignments = array();
    	$assignments = array('element_list' => $element_list);
	$display_template = $Smarty->load_template($params, 'compared');
	$Smarty->display($display_template, $assignments);

	$output = @ob_get_contents();
	ob_end_clean();	
	Cache::write($cache_name, $output, 'catalog');		
	}
	
	echo $output;
}

function smarty_help_function_compared() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays compare page data.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template/page like:') ?> <code>{compared}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Overrides the default template.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_compared() {
}
?>
