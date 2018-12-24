<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_content_listing()
{
$template = '
{if $content_list}

{if isset($content_alias)}
<div class="sort">
<div class="btn-toolbar">
  <div class="btn-group">
  <span class="btn btn-default"><i class="fa fa-sort" title="{lang}Sort by{/lang}"></i></span>
    <a class="btn btn-default{if $order == "price-asc"} active{/if}" href="{base_path}/category/{$content_alias->value}{$ext}/order/price-asc">{lang}Price{/lang}</a>
    <a class="btn btn-default{if $order == "price-asc"} active{/if}" href="{base_path}/category/{$content_alias->value}{$ext}/order/price-asc"><i class="fa fa-sort-numeric-asc" title="{lang}Price (Low to High){/lang}"></i></a>
    <a class="btn btn-default{if $order == "price-desc"} active{/if}" href="{base_path}/category/{$content_alias->value}{$ext}/order/price-desc"><i class="fa fa-sort-numeric-desc" title="{lang}Price (High to Low){/lang}"></i></a>
    <a class="btn btn-default{if $order == "name-asc"} active{/if}" href="{base_path}/category/{$content_alias->value}{$ext}/order/name-asc">{lang}Product Name{/lang}</a>
    <a class="btn btn-default{if $order == "name-asc"} active{/if}" href="{base_path}/category/{$content_alias->value}{$ext}/order/name-asc"><i class="fa fa-sort-alpha-asc" title="{lang}Name (A-Z){/lang}"></i></a>
    <a class="btn btn-default{if $order == "name-desc"} active{/if}" href="{base_path}/category/{$content_alias->value}{$ext}/order/name-desc"><i class="fa fa-sort-alpha-desc" title="{lang}Name (Z-A){/lang}"></i></a>
    <a class="btn btn-default{if $order == "ordered-desc"} active{/if}" href="{base_path}/category/{$content_alias->value}{$ext}/order/ordered-desc">{lang}Popular{/lang}</a>
    <a class="btn btn-default{if $order == "ordered-desc"} active{/if}" href="{base_path}/category/{$content_alias->value}{$ext}/order/ordered-desc"><i class="fa fa-thumbs-up" title="{lang}Popular (desc){/lang}"></i></a>
    <a class="btn btn-default{if $order == "ordered-asc"} active{/if}" href="{base_path}/category/{$content_alias->value}{$ext}/order/ordered-asc"><i class="fa fa-thumbs-down" title="{lang}Popular (asc){/lang}"></i></a>
  </div>
</div>
</div>
{/if}  

{if isset($content_alias)}
{if $pages_number > 1}
<!-- start: Pagination -->
<div class="text-center">
  <ul class="pagination">
    {for $pg=1 to $pages_number}
    <li{if $pg == {$page}} class="active"{/if}><a href="{base_path}/category/{$content_alias->value}{$ext}/page/{$pg}{if $order}/order/{$order}{/if}">{$pg}</a></li>
    {/for}
    <li{if "all" == {$page}} class="active"{/if}><a href="{base_path}/category/{$content_alias->value}{$ext}/page/all{if $order}/order/{$order}{/if}">{lang}All{/lang}</a></li>
  </ul>
</div>
<!-- end: Pagination -->
{/if}  
{/if}  
  
<!-- start: products listing -->
<div class="row shop-products">
  <ul class="thumbnails">
    {foreach from=$content_list item=node}
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
        <div class="description">{attribute_list product_id=$node.id}</div>
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

{if isset($content_alias)}
{if $pages_number > 1}
<!-- start: Pagination -->
<div class="text-center">
  <ul class="pagination">
    {for $pg=1 to $pages_number}
    <li{if $pg == {$page}} class="active"{/if}><a href="{base_path}/category/{$content_alias->value}{$ext}/page/{$pg}{if $order}/order/{$order}{/if}">{$pg}</a></li>
    {/for}
    <li{if "all" == {$page}} class="active"{/if}><a href="{base_path}/category/{$content_alias->value}{$ext}/page/all{if $order}/order/{$order}{/if}">{lang}All{/lang}</a></li>
  </ul>
</div>
<!-- end: Pagination -->
{/if}
{/if}  

{else}
{lang}No Items Found{/lang}

{/if}  
';		

return $template;
}

function smarty_function_content_listing($params, $template)
{
	global $config,$content,$filter_list,$filtered_content,$sort_by;
			
			if (!isset ($params['current_order'])) 
			    $params['current_order'] = false;

			if (!isset ($params['order'])) 
			    $params['order'] = 'id-desc';

			if (isset ($params['current_order']) && $params['current_order'] == '') 
			    $params['current_order'] = $params['order'];
			    
        switch ($params['current_order']) {

        case 'order':
            $params['order_column'] = 'Content.order';
        break;

        case 'order-asc':
            $params['order_column'] = 'Content.order ASC';
        break;

        case 'order-desc':
            $params['order_column'] = 'Content.order DESC';
        break;

        case 'price':
            $params['order_column'] = 'ContentProduct.price';
        break;

        case 'price-asc':
            $params['order_column'] = 'ContentProduct.price ASC';
        break;

        case 'price-desc':
            $params['order_column'] = 'ContentProduct.price DESC';
        break;

        case 'stock':
            $params['order_column'] = 'ContentProduct.stock';
        break;

        case 'stock-asc':
            $params['order_column'] = 'ContentProduct.stock ASC';
        break;

        case 'stock-desc':
            $params['order_column'] = 'ContentProduct.stock DESC';
        break;

        case 'name':
            $params['order_column'] = 'ContentDescription.name';
        break;

        case 'name-asc':
            $params['order_column'] = 'ContentDescription.name ASC';
        break;

        case 'name-desc':
            $params['order_column'] = 'ContentDescription.name DESC';
        break;

        case 'id':
            $params['order_column'] = 'Content.id';
        break;

        case 'id-asc':
            $params['order_column'] = 'Content.id ASC';
        break;

        case 'id-desc':
            $params['order_column'] = 'Content.id DESC';
        break;

        case 'ordered':
            $params['order_column'] = 'ContentProduct.ordered';
        break;

        case 'ordered-asc':
            $params['order_column'] = 'ContentProduct.ordered ASC';
        break;

        case 'ordered-desc':
            $params['order_column'] = 'ContentProduct.ordered DESC';
        break;

        default:
            $params['order_column'] = 'Content.id DESC';
        break;        
            
        }

	// Cache the output.
	$cache_name = 'vam_content_listing_output_' . $_SESSION['Customer']['customer_group_id'] . '_' . $content['Content']['id'] . '_' . (isset($params['template'])?$params['template']:'') . (isset($params['parent'])?'_'.$params['parent']:'') . (isset($params['label_id'])?'_'.$params['label_id']:'') . (isset($params['current_order'])?'_'.$params['current_order']:'') . (isset($params['order'])?'_'.$params['order']:'') . '_' . $_SESSION['Customer']['language_id'] . '_' . $_SESSION['Customer']['currency_id'] . '_' . $_SESSION['Customer']['page'] . (isset($filter_list)?md5(serialize($filter_list)):'');
	$output = Cache::read($cache_name, 'catalog');
	if($output === false)
	{
		ob_start();
		
	// Load some necessary components & models
	App::uses('SmartyComponent', 'Controller/Component');
		$Smarty = new SmartyComponent(new ComponentCollection());

	App::uses('CakeTime', 'Utility');

	App::import('Model', 'Content');
		$Content = new Content();		

	// Make sure parent is valid, if it's not a number get the correct parent number
	if(!isset($params['parent']))
		$params['parent'] = 0;
	if(!is_numeric($params['parent']))
	{
		$get_content = $Content->findByAlias($params['parent']);
		$params['parent'] = $get_content['Content']['id'];
	}

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
		
        if(!isset ($params['page']))
            $params['page'] = 1;

        if(!isset ($params['type']))
            $params['type'] = 'all';

        if(!isset($params['label_id'])) 
            $params['label_id'] = 0;

        if(!isset($params['category'])) 
            $params['category'] = 0;


	// Loop through the values in $params['type'] and set some more condiitons
	$allowed_types = array();
	if((!isset($params['type'])) || ($params['type'] == 'all'))
	{
		// Set the default conditions if all or nothing was passed
		App::import('Model', 'ContentType');
		$ContentType = new ContentType();
		$allowed_types = $ContentType->find('list');
	}
	else
	{
		$types = explode(',',$params['type']);
		
		foreach($types AS $type)
			$allowed_types[] =  $type;
	}
	$content_list_group = '';

	if ($params['parent'] >= 0) {
	$content_list_data_conditions = array('Content.parent_id' => $params['parent'],'Content.active' => '1','Content.show_in_menu' => '1');
	} else {
	$content_list_data_conditions = array('Content.active' => '1','Content.show_in_menu' => '1');
	}

	$Content->recursive = 1;

        // Applying pagination for products only
        if(strpos($params['type'],'product') !== false) {

            if(!empty($filter_list))
            {        
                $content_list_data_conditions = array_merge($content_list_data_conditions,array('Content.id' => $filtered_content));        
            } else {     
                $content_list_data_conditions = array_merge($content_list_data_conditions,array('OR' => array(
                   'Content.id_group' => 0
                  ,'Content.id_group is null'
                  ,'Content.is_group' => 1
                ))); 
            } 

				// Sort products by manufacturer
				if(isset($params['manufacturer']) && $params['manufacturer'] > 0) {
				$content_list_data_conditions = array_slice($content_list_data_conditions,1);
				$content_list_data_conditions = array_merge($content_list_data_conditions,array('ContentProduct.manufacturer_id' => $params['manufacturer']));
				}

				// Sort products by is_new
				if(isset($params['is_new']) && $params['is_new'] == 1) {
				$content_list_data_conditions = array_slice($content_list_data_conditions,1);
				$content_list_data_conditions = array_merge($content_list_data_conditions,array('ContentProduct.is_new' => (int)$params['is_new']));
				}

				// Sort products by is_featured
				if(isset($params['is_featured']) && $params['is_featured'] == 1) {
				$content_list_data_conditions = array_slice($content_list_data_conditions,1);
				$content_list_data_conditions = array_merge($content_list_data_conditions,array('ContentProduct.is_featured' => (int)$params['is_featured']));
				}

				// Sort products by label
				if(strpos($params['type'],'product') !== false){
				if(isset($params['label_id']) && $params['label_id'] > 0) {
				if(!isset($params['parent']) or $params['parent'] <= 0) {
				$content_list_data_conditions = array_slice($content_list_data_conditions,1);
				}
				$content_list_data_conditions = array_merge($content_list_data_conditions,array('ContentProduct.label_id' => $params['label_id']));
				}
				}

            if($params['page'] == 'all'){          

                $content_list_data = $Content->find('all', array('conditions' => $content_list_data_conditions, 'order' => array($params['order_column'])));
                $content_total = $Content->find('count',array('conditions' => $content_list_data_conditions));
            }
            else{

					if(!isset ($params['limit']))
						$params['limit'] = $config['PRODUCTS_PER_PAGE'];
                $content_list_data = $Content->find('all', array('conditions' => $content_list_data_conditions, 'limit' => $params['limit'],'page' => $params['page'], 'order' => array($params['order_column'])));
                $content_total = $Content->find('count',array('conditions' => $content_list_data_conditions));
            }
            //$content_total = count($content_list_data);
        }
        else{
        	
        	if ($params['type'] == 'manufacturer' && isset($params['category']) && $params['category'] > 0) {
        		$content_manufacturers = array_replace($content_list_data_conditions, array('Content.parent_id' => $params['category']));

				App::import('Model', 'Content');
				$Content_Manufactures = new Content();		
		
				$Content_Manufactures->unbindAll();	
		
				$Content_Manufactures->bindModel(array('hasOne' => array(
						'ContentProduct' => array(
		                    'className' => 'ContentProduct'
							))));
		
        		$content_manufacturers_id = $Content_Manufactures->find('all', array('conditions' => $content_manufacturers, 'limit' => isset($params['limit']) ? $params['limit'] : null,'order' => array($params['order_column'])));
        		
        		$manufacturers_id = null;
        		foreach($content_manufacturers_id AS $key => $value) {
        			if ($value['ContentProduct']['manufacturer_id'] > 0) $manufacturers_id[$key] =  $value['ContentProduct']['manufacturer_id'];
        		
        		}
        		
        		if (is_array($manufacturers_id)) {
        		$manufacturers_id = array_unique($manufacturers_id);
				$content_list_data_conditions = array_merge($content_list_data_conditions,array('Content.id' => $manufacturers_id));
				}
				
			}
            $content_list_data = $Content->find('all', array('conditions' => $content_list_data_conditions, 'limit' => isset($params['limit']) ? $params['limit'] : null,'order' => array($params['order_column'])));
        }
	
	// Loop through the content list and create a new array with only what the template needs
	$content_list = array();
	$count = 0;
	
	$CurrencyBase = new CurrencyBaseComponent(new ComponentCollection());
	$ContentBase = new ContentBaseComponent(new ComponentCollection());
	
	foreach($content_list_data AS $raw_data)
	{
		$content_type = 'ContentProduct';
		$price = $raw_data['ContentProduct']['price'];

		if ($raw_data['Content']['content_type_id'] == 7) {
			$content_type = 'ContentDownloadable';
			$price = $raw_data['ContentDownloadable']['price'];
		}
		if(in_array(strtolower($raw_data['ContentType']['name']),$allowed_types))
		{
			$content_list[$count]['name']	= $raw_data['ContentDescription']['name'];
			$content_list[$count]['description']	= $raw_data['ContentDescription']['description'];
			$content_list[$count]['short_description']	= $raw_data['ContentDescription']['short_description'];
			$content_list[$count]['meta_title']	= $raw_data['ContentDescription']['meta_title'];
			$content_list[$count]['meta_description']	= $raw_data['ContentDescription']['meta_description'];
			$content_list[$count]['meta_keywords']	= $raw_data['ContentDescription']['meta_keywords'];
			$content_list[$count]['id']	= $raw_data['Content']['id'];
			$content_list[$count]['parent_id']	= $raw_data['Content']['parent_id'];
			$content_list[$count]['alias']	= $raw_data['Content']['alias'];
			if ($raw_data['Content']['content_type_id'] == 2 or $raw_data['Content']['content_type_id'] == 7) $content_list[$count]['price']	= ($price > 0) ? $CurrencyBase->display_price($price) : false;	
			if ($raw_data['Content']['content_type_id'] == 2 or $raw_data['Content']['content_type_id'] == 7) $content_list[$count]['old_price']	= (($raw_data[$content_type]['old_price'] > $price) ? $CurrencyBase->display_price($raw_data[$content_type]['old_price']) : false);	
			if ($raw_data['Content']['content_type_id'] == 2 or $raw_data['Content']['content_type_id'] == 7) $content_list[$count]['price_save']	= (($raw_data[$content_type]['old_price']-$price > 0) ? $CurrencyBase->display_price($raw_data[$content_type]['old_price']-$price) : false);	
			if ($raw_data['Content']['content_type_id'] == 2 or $raw_data['Content']['content_type_id'] == 7) $content_list[$count]['price_save_percent']	= (($raw_data[$content_type]['old_price'] > $price) ? 100-($price*100/$raw_data[$content_type]['old_price']) : false);	
			if ($raw_data['Content']['content_type_id'] == 2 or $raw_data['Content']['content_type_id'] == 7) $content_list[$count]['discount']	= (($raw_data[$content_type]['old_price'] > $price) ? 100-($price*100/$raw_data[$content_type]['old_price']) : 0);	
			$content_list[$count]['rating']	= $ContentBase->getReviewsInfo($raw_data['Content']['id'], 'average_rating');	
			$content_list[$count]['star_rating']	= $ContentBase->getReviewsInfo($raw_data['Content']['id'], 'star_rating');	
			$content_list[$count]['reviews']	= $ContentBase->getReviewsInfo($raw_data['Content']['id'], 'reviews_total');	
			if ($raw_data['Content']['content_type_id'] == 2 or $raw_data['Content']['content_type_id'] == 7) $content_list[$count]['stock']	= $raw_data[$content_type]['stock'];	
			if ($raw_data['Content']['content_type_id'] == 2 or $raw_data['Content']['content_type_id'] == 7) $content_list[$count]['model']	= $raw_data[$content_type]['model'];	
			if ($raw_data['Content']['content_type_id'] == 2) $content_list[$count]['weight']	= $raw_data[$content_type]['weight'];	
			if ($raw_data['Content']['content_type_id'] == 2) $content_list[$count]['length']	= ($raw_data['ContentProduct']['length'] > 0) ? $raw_data['ContentProduct']['length'] : false;	
			if ($raw_data['Content']['content_type_id'] == 2) $content_list[$count]['width']	= ($raw_data['ContentProduct']['width'] > 0) ? $raw_data['ContentProduct']['width'] : false;	
			if ($raw_data['Content']['content_type_id'] == 2) $content_list[$count]['height']	= ($raw_data['ContentProduct']['height'] > 0) ? $raw_data['ContentProduct']['height'] : false;	
			if ($raw_data['Content']['content_type_id'] == 2) $content_list[$count]['volume']	= ($raw_data['ContentProduct']['volume'] > 0) ? $raw_data['ContentProduct']['volume'] : false;	
			if ($raw_data['Content']['content_type_id'] == 2 or $raw_data['Content']['content_type_id'] == 7) $content_list[$count]['manufacturer']	= $ContentBase->getManufacturerName($raw_data[$content_type]['manufacturer_id']);	
			if ($raw_data['Content']['content_type_id'] == 2 or $raw_data['Content']['content_type_id'] == 7) $content_list[$count]['manufacturer_url']	= BASE . '/manufacturer/' . $ContentBase->getManufacturerAlias($raw_data[$content_type]['manufacturer_id']) . $config['URL_EXTENSION'];
			if ($raw_data['Content']['content_type_id'] == 2 or $raw_data['Content']['content_type_id'] == 7) $content_list[$count]['category_url']	= BASE . '/category/' . $ContentBase->getContentAlias($raw_data['Content']['parent_id']) . $config['URL_EXTENSION'];
			if ($raw_data['Content']['content_type_id'] == 2 or $raw_data['Content']['content_type_id'] == 7) $content_list[$count]['label_id']	= $raw_data[$content_type]['label_id'];	
			$content_list[$count]['date_added']	= CakeTime::i18nFormat($raw_data['Content']['created']);	
			$content_list[$count]['date_modified']	= CakeTime::i18nFormat($raw_data['Content']['modified']);	
			$content_list[$count]['viewed']	= $raw_data['Content']['viewed'];

//3.Установим признак если группа
								if (is_array($content_list_group)) {
                        if (in_array($raw_data['Content']['id'],$content_list_group)){ 
                            $content_list[$count]['is_group'] = true;
                            //var_dump($Content->getSetAttributesForProduct(96));
                        }
                     	}
//                        
                        $content_list[$count]['attributes'] = array();
                        if (isset($raw_data['Attribute'])) {
                        foreach($raw_data['Attribute'] AS $attribute)
                        {
                            $content_list[$count]['attributes'][$attribute['parent_id']]['id'] = $attribute['id'];
                            $content_list[$count]['attributes'][$attribute['parent_id']]['value'] = $attribute['val'];
                        }
                        }

			// Content Image
			
			if($raw_data['ContentImage']['image'] != "") {
				$image_url = $raw_data['Content']['id'] . '/' . $raw_data['ContentImage']['image'];
				$image_path = BASE . '/img/content/' . $raw_data['ContentImage']['image'];
				$thumb_name = substr_replace($raw_data['ContentImage']['image'] , '', strrpos($raw_data['ContentImage']['image'] , '.')).'-'.$config['THUMBNAIL_SIZE'].'.png';	
				$thumb_path = IMAGES . 'content/' . $thumb_name;
				$thumb_url = BASE . '/img/content/' . $thumb_name;

					if(file_exists($thumb_path) && is_file($thumb_path)) {
						list($width, $height, $type, $attr) = getimagesize($thumb_path);
						$content_list[$count]['image'] =  $thumb_url;
						$content_list[$count]['image_original'] =  $image_path;
						$content_list[$count]['image_width'] = $width;
						$content_list[$count]['image_height'] = $height;
					} else {
						$image_url = 'noimage.png';
						$thumb_name = 'noimage-'.$config['THUMBNAIL_SIZE'].'.png';	
						$thumb_path = IMAGES . 'content/' . $thumb_name;
						$thumb_url = BASE . '/img/content/' . $thumb_name;

						$content_list[$count]['image'] =  BASE . '/img/content/' . $thumb_name;
						$content_list[$count]['image_thumb'] = BASE . '/img/content/' . $image_url;
						$content_list[$count]['image_original'] =  $thumb_url;
						$content_list[$count]['image_width'] = $config['THUMBNAIL_SIZE'];
						$content_list[$count]['image_height'] = $config['THUMBNAIL_SIZE'];
					}

			} else { 

				$image_url = 'noimage.png';
				$thumb_name = 'noimage-'.$config['THUMBNAIL_SIZE'].'.png';	
				$thumb_path = IMAGES . 'content/' . $thumb_name;
				$thumb_url = BASE . '/img/content/' . $thumb_name;

					if(file_exists($thumb_path) && is_file($thumb_path)) {
						list($width, $height, $type, $attr) = getimagesize($thumb_path);
						$content_list[$count]['image'] =  $thumb_url;
						$content_list[$count]['image_width'] = $width;
						$content_list[$count]['image_height'] = $height;
					} else {
						$content_list[$count]['image'] = BASE . '/images/thumb/' . $image_url;
						$content_list[$count]['image_width'] = null;
						$content_list[$count]['image_height'] = null;
					}

			}
			
			if($raw_data['ContentType']['name'] == 'link')
			{
				$content_list[$count]['url'] = $raw_data['ContentLink']['url'];
			}
			else
			{
				$content_list[$count]['url']	= BASE . '/' . $raw_data['ContentType']['name'] . '/' . $raw_data['Content']['alias'] . $config['URL_EXTENSION'];
			}
			$count ++;
		}
	}
	$vars = $template->smarty->tpl_vars;
	$vars['content_list'] = $content_list;
	$vars['count'] = $count;
	$vars['pages_number'] = 0;
	$vars['page'] = $params['page'];
	$vars['order'] = $params['current_order'];
	$vars['ext'] = $config['URL_EXTENSION'];

	// Error page
	//if (!$content_list) {
		//throw new NotFoundException();
	//}	

        if(!isset ($params['limit']))
				$params['limit'] = $config['PRODUCTS_PER_PAGE'];

        // Calculating the number of pages
         if(strpos($params['type'],'product') !== false){
             $vars['pages_number'] = ceil($content_total/$params['limit']);
         }
         
	if($config['GD_LIBRARY'] == 0)
		$vars['thumbnail_width'] = $config['THUMBNAIL_SIZE'];

	if(!empty($content['CompareAttribute']))$vars['is_compare'] = 1;

	$display_template = $Smarty->load_template($params,'content_listing');	
	$Smarty->display($display_template,$vars);
	
		
		// Write the output to cache and echo them
		$output = @ob_get_contents();
		ob_end_clean();	
		Cache::write($cache_name, $output, 'catalog');		

	}
	echo $output;
}

function smarty_help_function_content_listing() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays a list of content items depending on the parent of those items.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{content_listing}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(type)') ?></em> - <?php echo __('Type of content to display. Seperate multiple values with commas, example:') ?> {content_listing type='category,page'}. <?php echo __('Available values') ?>: category,product,downloadable,page,link,news,article,manufacturer. <?php echo __('Defaults to') ?> 'all'.</li>
		<li><em><?php echo __('(parent)') ?></em> - <?php echo __('The parent of the content items to be shown. Accepts an alias or id, defaults to 0.') ?></li>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Useful if you want to override the default content listing template. Setting this will utilize the template that matches this alias.') ?></li>
		<li><em><?php echo __('(page)') ?></em> - <?php echo __('Current page.') ?></li>
		<li><em><?php echo __('(label_id)') ?></em> - <?php echo __('Display products with selected product label.') ?></li>
		<li><em><?php echo __('(manufacturer)') ?></em> - <?php echo __('Display products with selected brand (manufacturer_id).') ?></li>
		<li><em><?php echo __('(order)') ?></em> - <?php echo __('Content listing sort order. Available values: ') . 'order,order-asc,order-desc,price,price-asc,price-desc,stock,stock-asc,stock-desc,name,name-asc,name-desc,id,id-asc,id-desc,ordered,ordered-asc,ordered-desc' ?></li>
		<li><em><?php echo __('(is_new)') ?></em> - <?php echo __('Display new products. Available values: 1 or 0.') ?></li>
		<li><em><?php echo __('(is_featured)') ?></em> - <?php echo __('Display featured products. Available values: 1 or 0.') ?></li>
		<li><em><?php echo __('(current_order)') ?></em> - <?php echo __('Current product listing sort order. Available values: ') . '$current_order' ?></li>
		<li><em><?php echo __('(limit)') ?></em> - <?php echo __('Items per page.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_content_listing() {
}
?>