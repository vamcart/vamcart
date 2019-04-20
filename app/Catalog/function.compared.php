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
	<div class="content compared">
		<h2>{page_name}</h2>  

		<!-- start: products listing -->
		<div class="row shop-products">
			<ul class="thumbnails">
				{foreach from=$element_list[0]["attributes_product"] item=node}
        <li class="item col-sm-6 col-md-4">
          <div class="thumbnail text-center">
            {if $node.discount > 0}<div class="description"><span class="discount">-{$node.discount|round}%</span></div>{/if}
            <a href="{$node.url}" class="image"><img src="{$node.image}" alt="{$node.name}"{if {$node.image_width} > 0} width="{$node.image_width}"{/if}{if {$node.image_height} > 0} height="{$node.image_height}"{/if} />
            {if $node.price}<span class="frame-overlay"></span><span class="price">{$node.price}</span>{/if}
            {product_label label_id={$node.label_id}}
            </a>
          <div class="inner notop nobottom text-left">
            <h4 class="title"><a href="{$node.url}">{$node.name}</a></h4>
            {if $node.reviews > 0}<div class="description"><span class="rating">{$node.star_rating}</span> <span class="reviews">{lang}Feedback{/lang}: {$node.reviews}</span></div>{/if}
            {if $node.old_price}<div class="description">{lang}List Price{/lang}: <span class="old-price"><del>{$node.old_price}</del></span></div>{/if}
            {if $node.price_save}<div class="description">{lang}You Save{/lang}: <span class="save">{$node.price_save} ({$node.price_save_percent|round}%)</span></div>{/if}
            <div class="description">{$node.short_description|strip_tags|truncate:30:"...":true}</div>
          </div>
          </div>
          {product_form product_id={$node.id}}
          <div class="inner darken notop">
            <button class="btn btn-default btn-add-to-cart" type="submit"><i class="fa fa-shopping-cart"></i> {lang}Buy{/lang}</button>
            {if isset($is_compare)}<a href="{base_path}/category/addcmp/{$node.alias}/{$content_alias->value}{$ext}" class="btn btn-default btn-add-to-cart"><i class="fa fa-bookmark"></i> {lang}Compare{/lang}</a>{/if}
          </div>
          {/product_form}
        </li>
				{/foreach}
			</ul>
		</div>  
		<!-- end: products listing -->

			<!-- start: compare_table -->
			<table class="table table-striped table-hover">
			<thead>
			<tr>
				<th>{lang}Comparison{/lang}</th>
				{foreach from=$element_list[0]["attributes_product"] item=product}
					<th>
					{$product.name}
					</th>
				{/foreach}
			</tr>
			</thead>   
			<tbody>
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

	</div>
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
	$Smarty = new SmartyComponent(new ComponentCollection());

	App::uses('CakeTime', 'Utility');
        
        App::import('Model', 'Content');
	$Content = new Content();

        App::import('Model', 'Attribute');
	$Attribute = new Attribute();

	
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
		$Content->bindModel(array('hasOne' => array(
				'ContentDownloadable' => array(
                    'className' => 'ContentDownloadable'
					))));
		$Content->bindModel(array('hasOne' => array(
				'ContentSpecial' => array(
                    'className' => 'ContentSpecial'
					))));

		$Content->bindModel(array('hasMany' => array('Attribute' => array(
						'className' => 'Attribute'
                                               ,'order' => array('Attribute.order ASC')
					))));

        $content_list = $Content->find('all',array('recursive' => 1, 'conditions' => array('Content.id' => $content_compare_list)));

	$element_list = array();
	$CurrencyBase = new CurrencyBaseComponent(new ComponentCollection());
	$ContentBase = new ContentBaseComponent(new ComponentCollection());

        foreach ($attr as $k_a => $attribute) 
        {
            	$element_list[$k_a]['id_attribute'] = $attribute['Attribute']['id'];
            	$element_list[$k_a]['name_attribute'] = $attribute['Attribute']['name'];
            	$element_list[$k_a]['template_attribute'] = $attribute['AttributeTemplate']['template_compare'];
                $element_list[$k_a]['attributes_product'] = array();
                foreach ($content_list as $k_p => $product) 
                {
						$content_type = 'ContentProduct';
						$price = $product['ContentProduct']['price'];
				
						if ($product['Content']['content_type_id'] == 7) {
							$content_type = 'ContentDownloadable';
							$price = $product['ContentDownloadable']['price'];
						}

						$element_list[$k_a]['attributes_product'][$k_p]['name']	= $product['ContentDescription']['name'];
						$element_list[$k_a]['attributes_product'][$k_p]['description']	= $product['ContentDescription']['description'];
						$element_list[$k_a]['attributes_product'][$k_p]['short_description']	= $product['ContentDescription']['short_description'];
						$element_list[$k_a]['attributes_product'][$k_p]['meta_title']	= $product['ContentDescription']['meta_title'];
						$element_list[$k_a]['attributes_product'][$k_p]['meta_description']	= $product['ContentDescription']['meta_description'];
						$element_list[$k_a]['attributes_product'][$k_p]['meta_keywords']	= $product['ContentDescription']['meta_keywords'];
						$element_list[$k_a]['attributes_product'][$k_p]['id']	= $product['Content']['id'];
						$element_list[$k_a]['attributes_product'][$k_p]['alias']	= $product['Content']['alias'];
						if ($product['Content']['content_type_id'] == 2 or $product['Content']['content_type_id'] == 7) $element_list[$k_a]['attributes_product'][$k_p]['price']	= ($price > 0) ? $CurrencyBase->display_price($price) : false;	
						if ($product['Content']['content_type_id'] == 2 or $product['Content']['content_type_id'] == 7) $element_list[$k_a]['attributes_product'][$k_p]['old_price']	= (($product[$content_type]['old_price'] > $price) ? $CurrencyBase->display_price($product[$content_type]['old_price']) : false);	
						if ($product['Content']['content_type_id'] == 2 or $product['Content']['content_type_id'] == 7) $element_list[$k_a]['attributes_product'][$k_p]['price_save']	= (($product[$content_type]['old_price']-$price > 0) ? $CurrencyBase->display_price($product[$content_type]['old_price']-$price) : false);	
						if ($product['Content']['content_type_id'] == 2 or $product['Content']['content_type_id'] == 7) $element_list[$k_a]['attributes_product'][$k_p]['price_save_percent']	= (($product[$content_type]['old_price'] > $price) ? 100-($price*100/$product[$content_type]['old_price']) : false);	
						if ($product['Content']['content_type_id'] == 2 or $product['Content']['content_type_id'] == 7) $element_list[$k_a]['attributes_product'][$k_p]['discount']	= (($product[$content_type]['old_price'] > $price) ? 100-($price*100/$product[$content_type]['old_price']) : 0);	
						$element_list[$k_a]['attributes_product'][$k_p]['rating']	= $ContentBase->getReviewsInfo($product['Content']['id'], 'average_rating');	
						$element_list[$k_a]['attributes_product'][$k_p]['star_rating']	= $ContentBase->getReviewsInfo($product['Content']['id'], 'star_rating');	
						$element_list[$k_a]['attributes_product'][$k_p]['reviews']	= $ContentBase->getReviewsInfo($product['Content']['id'], 'reviews_total');	
						if ($product['Content']['content_type_id'] == 2 or $product['Content']['content_type_id'] == 7) $element_list[$k_a]['attributes_product'][$k_p]['stock']	= $product[$content_type]['stock'];	
						if ($product['Content']['content_type_id'] == 2 or $product['Content']['content_type_id'] == 7) $element_list[$k_a]['attributes_product'][$k_p]['model']	= $product[$content_type]['model'];	
						if ($product['Content']['content_type_id'] == 2) $element_list[$k_a]['attributes_product'][$k_p]['weight']	= $product[$content_type]['weight'];	
						if ($product['Content']['content_type_id'] == 2 or $product['Content']['content_type_id'] == 7) $element_list[$k_a]['attributes_product'][$k_p]['manufacturer']	= $ContentBase->getManufacturerName($product[$content_type]['manufacturer_id']);	
						if ($product['Content']['content_type_id'] == 2 or $product['Content']['content_type_id'] == 7) $element_list[$k_a]['attributes_product'][$k_p]['label_id']	= $product[$content_type]['label_id'];	
						$element_list[$k_a]['attributes_product'][$k_p]['date_added']	= CakeTime::i18nFormat($product['Content']['created']);	
						$element_list[$k_a]['attributes_product'][$k_p]['date_modified']	= CakeTime::i18nFormat($product['Content']['modified']);	

								global $config;

								// Content Image
								
								if($product['ContentImage']['image'] != "") {
									$image_url = $product['Content']['id'] . '/' . $product['ContentImage']['image'];
									$image_path = BASE . '/img/content/' . $product['ContentImage']['image'];
									$thumb_name = substr_replace($product['ContentImage']['image'] , '', strrpos($product['ContentImage']['image'] , '.')).'-'.$config['THUMBNAIL_SIZE'].'.png';	
									$thumb_path = IMAGES . 'content/' . $thumb_name;
									$thumb_url = BASE . '/img/content/' . $thumb_name;
					
										if(file_exists($thumb_path) && is_file($thumb_path)) {
											list($width, $height, $type, $attr) = getimagesize($thumb_path);
											$element_list[$k_a]['attributes_product'][$k_p]['image'] =  $thumb_url;
											$element_list[$k_a]['attributes_product'][$k_p]['image_original'] =  $image_path;
											$element_list[$k_a]['attributes_product'][$k_p]['image_width'] = $width;
											$element_list[$k_a]['attributes_product'][$k_p]['image_height'] = $height;
										} else {
											$element_list[$k_a]['attributes_product'][$k_p]['image'] = BASE . '/images/thumb/' . $image_url;
											$element_list[$k_a]['attributes_product'][$k_p]['image_original'] =  $image_path;
											$element_list[$k_a]['attributes_product'][$k_p]['image_width'] = null;
											$element_list[$k_a]['attributes_product'][$k_p]['image_height'] = null;
										}
					
								} else { 
					
									$image_url = 'noimage.png';
									$thumb_name = 'noimage-'.$config['THUMBNAIL_SIZE'].'.png';	
									$thumb_path = IMAGES . 'content/' . $thumb_name;
									$thumb_url = BASE . '/img/content/' . $thumb_name;
					
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
