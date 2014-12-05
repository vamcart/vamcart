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
<div class="sort">{lang}Sort by:{/lang}</div>
<div class="btn-toolbar">
	<div class="btn-group">
	<span class="btn btn-inverse"><i class="fa fa-filter" title="{lang}Sort by:{/lang}"></i></span>
		<a class="btn btn-inverse{if $order == "price-asc"} active{/if}" href="{base_path}/category/{$content_alias->value}{$ext}/order/price-asc">{lang} Price{/lang}</a>
		<a class="btn btn-inverse{if $order == "price-asc"} active{/if}" href="{base_path}/category/{$content_alias->value}{$ext}/order/price-asc"><i class="fa fa-sort-numeric-asc" title="{lang}Price (Low to High){/lang}"></i></a>
		<a class="btn btn-inverse{if $order == "price-desc"} active{/if}" href="{base_path}/category/{$content_alias->value}{$ext}/order/price-desc"><i class="fa fa-sort-numeric-desc" title="{lang}Price (High to Low){/lang}"></i></a>
		<a class="btn btn-inverse{if $order == "name-asc"} active{/if}" href="{base_path}/category/{$content_alias->value}{$ext}/order/name-asc">{lang} Name{/lang}</a>
		<a class="btn btn-inverse{if $order == "name-asc"} active{/if}" href="{base_path}/category/{$content_alias->value}{$ext}/order/name-asc"><i class="fa fa-sort-alpha-asc" title="{lang}Name (A-Z){/lang}"></i></a>
		<a class="btn btn-inverse{if $order == "name-desc"} active{/if}" href="{base_path}/category/{$content_alias->value}{$ext}/order/name-desc"><i class="fa fa-sort-alpha-desc" title="{lang}Name (Z-A){/lang}"></i></a>
		<a class="btn btn-inverse{if $order == "ordered-desc"} active{/if}" href="{base_path}/category/{$content_alias->value}{$ext}/order/ordered-desc">{lang} Popular{/lang}</a>
		<a class="btn btn-inverse{if $order == "ordered-desc"} active{/if}" href="{base_path}/category/{$content_alias->value}{$ext}/order/ordered-desc"><i class="fa fa-thumbs-up" title="{lang}Popular (desc){/lang}"></i></a>
		<a class="btn btn-inverse{if $order == "ordered-asc"} active{/if}" href="{base_path}/category/{$content_alias->value}{$ext}/order/ordered-asc"><i class="fa fa-thumbs-down" title="{lang}Popular (asc){/lang}"></i></a>
	</div>
</div>
{/if}

{if isset($content_alias)}
{if $pages_number > 1}
<!-- start: Pagination -->
<div class="pagination pagination-centered">
	<ul>
		{for $pg=1 to $pages_number}
		<li{if $pg == $page} class="active"{/if}><a href="{base_path}/category/{$content_alias->value}{$ext}/page/{$pg}{if $order}/order/{$order}{/if}">{$pg}</a></li>
		{/for}
		<li{if "all" == $page} class="active"{/if}><a href="{base_path}/category/{$content_alias->value}{$ext}/page/all{if $order}/order/{$order}{/if}">{lang}All{/lang}</a></li>
	</ul>
</div>
<!-- end: Pagination -->
{/if}  
{/if}  
  
<!-- start: products listing -->
<div class="row-fluid shop-products">
	<ul class="thumbnails">
		{foreach from=$content_list item=node}
		<li class="item span4 {if $node@index is div by 3}first{/if}">
			<div class="thumbnail text-center">
				{if $node.discount > 0}<div class="description"><span class="discount">-{$node.discount|round}%</span></div>{/if}
				<a href="{$node.url}" class="image"><img src="{$node.image}" alt="{$node.name}"{if isset($thumbnail_width)} width="{$thumbnail_width}"{/if} />{product_label label_id={$node.label_id}}</a>
			<div class="inner notop nobottom text-left">
				<h4 class="title"><a href="{$node.url}">{$node.name}</a></h4>
				{if $node.reviews > 0}<div class="description"><span class="rating">{$node.star_rating}</span> <span class="reviews">(<a href="{$node.url}">{$node.reviews}</a>)</span></div>{/if}
				{if $node.price}<div class="description">{lang}Price{/lang}: <span class="price">{$node.price}</span></div>{/if}
				{if $node.old_price}<div class="description">{lang}List Price{/lang}: <span class="old-price"><del>{$node.old_price}</del></span></div>{/if}
				{if $node.price_save}<div class="description">{lang}You Save{/lang}: <span class="save">{$node.price_save} ({$node.price_save_percent|round}%)</span></div>{/if}
				<div class="description">{$node.short_description|strip_tags|truncate:30:"...":true}</div>
				<div class="description">{attribute_list product_id=$node.id}</div>
			</div>
			</div>
			{product_form product_id={$node.id}}
			<div class="inner darken notop">
				<button class="btn btn-add-to-cart" type="submit"><i class="fa fa-shopping-cart"></i> {lang}Buy{/lang}</button>
				{if isset($is_compare)}<a href="{base_path}/category/addcmp/{$node.alias}/{$content_alias->value}{$ext}" class="btn btn-add-to-cart"><i class="fa fa-bookmark"></i> {lang}Compare{/lang}</a>{/if}
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
<div class="pagination pagination-centered">
	<ul>
		{for $pg=1 to $pages_number}
		<li{if $pg == $page} class="active"{/if}><a href="{base_path}/category/{$content_alias->value}{$ext}/page/{$pg}{if $order}/order/{$order}{/if}">{$pg}</a></li>
		{/for}
		<li{if "all" == $page} class="active"{/if}><a href="{base_path}/category/{$content_alias->value}{$ext}/page/all{if $order}/order/{$order}{/if}">{lang}All{/lang}</a></li>
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
	global $config,$content,$filter_list,$sort_by;

        //if(!isset ($params['order_column']))
        //$params['order'] = 'Content.order ASC';

if (!isset ($params['order'])) {
    $params['order'] = 'Content.order ASC';
} elseif (!isset ($params['current_order'])) {
    $params['current_order'] = $params['order'];
} elseif ($params['order'] == $params['current_order']) {
    $params['order'] = $params['current_order'];
}

        //if(!isset ($params['order']))
            //$params['order'] = $sort_by;

        //if(!isset ($params['current_order']))
           // $params['current_order'] = $params['order'];

        //if($params['order'] != $params['current_order'])
            //$params['order'] = $params['current_order'];

        //if($sort_by == false && !isset ($params['order']))
            //$params['order'] = 'order-asc';
        
        //if($sort_by != false)
            //$params['order'] = $sort_by;

        //if(isset ($params['current_order']) && $params['current_order'] == $params['order']) {
			//$test = $params['current_order'];
		//} elseif ($params['current_order'] != $params['order']) {
			//$test = $params['order'];
		//} else {
			//$test = 'order-asc';
		//}
		//echo $test;


			switch ($params['current_order']):

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
            $params['order_column'] = 'Content.order ASC';
        break;
            
        endswitch;


echo '<br />sort_by: '.$sort_by.'<br />curent_order: '.$params['current_order'].'<br />order: '.$params['order'].'order_column: '.$params['order_column'].'<br />';        

	// Cache the output.
	$cache_name = 'vam_content_listing_output_' . $_SESSION['Customer']['customer_group_id'] . '_' . $content['Content']['id'] . '_' . (isset($params['template'])?$params['template']:'') . (isset($params['parent'])?'_'.$params['parent']:'') . (isset($params['label_id'])?'_'.$params['label_id']:'') . (isset($params['current_order'])?'_'.$params['current_order']:'') . '_' . $_SESSION['Customer']['language_id'] . '_' . $_SESSION['Customer']['page'] . (isset($filter_list)?md5(serialize($filter_list)):'');
	$output = Cache::read($cache_name, 'catalog');
	if($output === false)
	{
		ob_start();
		
	// Load some necessary components & models
	App::uses('SmartyComponent', 'Controller/Component');
		$Smarty =& new SmartyComponent(new ComponentCollection());

	App::uses('CakeTime', 'Utility');

	App::import('Model', 'Content');
		$Content =& new Content();		
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
		
	// Make sure parent is valid, if it's not a number get the correct parent number
	if(!isset($params['parent']))
		$params['parent'] = 0;
	if(!is_numeric($params['parent']))
	{
		$get_content = $Content->findByAlias($params['parent']);
		$params['parent'] = $get_content['Content']['id'];
	}

        if(!isset ($params['page']))
            $params['page'] = 1;

        if(!isset ($params['type']))
            $params['type'] = 'all';

        if(!isset($params['label_id'])) 
            $params['label_id'] = 0;
	
	// Loop through the values in $params['type'] and set some more condiitons
	$allowed_types = array();
	if((!isset($params['type'])) || ($params['type'] == 'all'))
	{
		// Set the default conditions if all or nothing was passed
		App::import('Model', 'ContentType');
		$ContentType =& new ContentType();
		$allowed_types = $ContentType->find('list');
	}
	else
	{
		$types = explode(',',$params['type']);
		
		foreach($types AS $type)
			$allowed_types[] =  $type;
	}
	$content_list_group = '';

	$content_list_data_conditions = array('Content.parent_id' => $params['parent'],'Content.active' => '1','Content.show_in_menu' => '1');

	$Content->recursive = 1;

        // Applying pagination for products only
        if(strpos($params['type'],'product') !== false){
//1.Найдем группы        
        $ContentGroup =& new Content();
        $ContentGroup->recursive = -1;
        $content_list_group = $ContentGroup->find('list', array('fields' => array('Content.id_group' ,'COUNT(Content.id) AS grp_cnt')
                                                         ,'conditions' => $content_list_data_conditions
                                                         ,'group' => array('Content.id_group HAVING grp_cnt > 1')
                                                         ,'order' => array('Content.order ASC')));
        $content_list_group = array_keys($content_list_group);            
//
        if(!empty($filter_list))
        {
            $ContentFiltered =& new Content();
            $ContentFiltered->recursive = -1;
            $content_list_data_joins = array(array('table' => 'attributes'
                                                  ,'alias' => 'Attribute'
                                                  ,'type' => 'inner'
                                                  ,'conditions' => array('Content.parent_id = Attribute.content_id'))
                                            ,array('table' => 'attributes'
                                                  ,'alias' => 'AttributeDefValue'
                                                  ,'type' => 'inner'
                                                  ,'conditions' => array('Attribute.id = AttributeDefValue.parent_id'))
                                            ,array('table' => 'attributes'
                                                  ,'alias' => 'AttributeValue'
                                                  ,'type' => 'left'
                                                  ,'conditions' => array('Content.id = AttributeValue.content_id' ,'AttributeDefValue.id = AttributeValue.parent_id'))
                                            );
            $attribute_conditions = array();  

            foreach($filter_list['values_attribute'] AS $k => $filter_value)
            {
                if($filter_list['is_active'][$filter_value['parent_id']] == '1')
                {
                    if(!isset($attribute_conditions[$filter_value['parent_id']]))$attribute_conditions[$filter_value['parent_id']] = array();
                    $not_val = $in_val = array();
                    switch ($filter_value['type_attr']) 
                    {
                        case 'max_value':
                            if(trim($filter_value['value']) != '')
                            $not_val = array('AttributeDefValue.id = ' . $k ,'AttributeValue.val <= ' . $filter_value['value'] . ' OR (AttributeDefValue.val <= ' . $filter_value['value'] . ' AND AttributeValue.val IS NULL)');
                        break;
                        case 'min_value':
                            if(trim($filter_value['value']) != '')
                            $not_val = array('AttributeDefValue.id = ' . $k ,'AttributeValue.val >= ' . $filter_value['value'] . ' OR (AttributeDefValue.val >= ' . $filter_value['value'] . ' AND AttributeValue.val IS NULL)');
                        break;
                        case 'like_value':
                            $filter_value['value'] = "'%" . $filter_value['value'] . "%'";
                            $not_val = array('AttributeDefValue.id = ' . $k ,'AttributeValue.val like ' . $filter_value['value'] . ' OR (AttributeDefValue.val like ' . $filter_value['value'] . ' AND AttributeValue.val IS NULL)');
                        break;
                        case 'dig_value':
                            if(trim($filter_value['value']) != '' && is_numeric($filter_value['value']))
                            $not_val = array('AttributeDefValue.id = ' . $k ,'AttributeValue.val = ' . $filter_value['value'] . ' OR (AttributeDefValue.val = ' . $filter_value['value'] . ' AND AttributeValue.val IS NULL)');
                        break;
                        case 'checked_list':
                            $filter_value['value'] = $filter_value['value'] + 0;
                            if($filter_value['value'] != 0)$not_val = array("AttributeDefValue.id = " . $k ,"AttributeValue.val = '" . $filter_value['value'] . "' OR (AttributeDefValue.val = '" . $filter_value['value'] . "' AND AttributeValue.val IS NULL)");
                        break;
                        case 'list_value':
                            $filter_value['value'] = $filter_value['value'] + 0;
                            if($filter_value['value'] != 0)$not_val = array("AttributeDefValue.id = " . $k ,"AttributeValue.val = '" . $filter_value['value'] . "' OR (AttributeDefValue.val = '" . $filter_value['value'] . "' AND AttributeValue.val IS NULL)");
                        break;
                        default:
                            $filter_value['value'] = $filter_value['value'] + 0;
                            $not_val = array('AttributeDefValue.id = ' . $k ,'AttributeValue.val != ' . $filter_value['value'] . ' OR (AttributeDefValue.val != ' . $filter_value['value'] . ' AND AttributeValue.val IS NULL)');
                        break;
                    }
                    if(!empty($not_val))array_push($attribute_conditions[$filter_value['parent_id']], $not_val);
                }
            }
            
            $next_flt = $content_list_data_conditions;
            foreach ($attribute_conditions as $key => $value) 
            {
                $value = array('OR' => $value);
                $tmp_content_list_data_conditions = array_merge($next_flt, $value);
//Добавляем фильтр (новый вариант с группами)                
//                $content_filtered_list_data = $ContentFiltered->find('all', array('fields' => array('Content.id','IFNULL(Content.id_group,Content.id) as grp'),'conditions' => $tmp_content_list_data_conditions, 'order' => array($params['order_column']) ,'joins' => $content_list_data_joins ,'group' => array('Content.id')));
//                $content_filtered_list_data = Set::combine($content_filtered_list_data,'{n}.Content.id', '{n}.0.grp');//нормализуем в list
//(старый вариант без групп)
                $content_filtered_list_data = $ContentFiltered->find('list', array('fields' => 'id','conditions' => $tmp_content_list_data_conditions, 'order' => array('Content.order ASC') ,'joins' => $content_list_data_joins ,'group' => array('Content.id')));                
//                
                $next_flt = array('Content.id' => $content_filtered_list_data);
            }
            $content_list_data_conditions = array_merge($content_list_data_conditions,$next_flt);
        }
//2.Добавим фильтр для групп        
        $content_list_data_conditions = array_merge($content_list_data_conditions,array('OR' => array('Content.id_group is null','Content.id' => $content_list_group)));
//               

				// Sort products by manufacturer
				if(isset($params['manufacturer']) && $params['manufacturer'] > 0) {
				$content_list_data_conditions = array_slice($content_list_data_conditions,1);
				$content_list_data_conditions = array_merge($content_list_data_conditions,array('ContentProduct.manufacturer_id' => $params['manufacturer']));
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
echo '-'.$params['current_order'];
                $content_list_data = $Content->find('all', array('conditions' => $content_list_data_conditions, 'limit' => $params['limit'],'page' => $params['page'], 'order' => array($params['order_column'])));
                $content_total = $Content->find('count',array('conditions' => $content_list_data_conditions));
            }
            //$content_total = count($content_list_data);
        }
        else{
            $content_list_data = $Content->find('all', array('conditions' => $content_list_data_conditions, 'limit' => isset($params['limit']) ? $params['limit'] : null,'order' => array('Content.order ASC')));
        }
	
	// Loop through the content list and create a new array with only what the template needs
	$content_list = array();
	$count = 0;
	
	$CurrencyBase =& new CurrencyBaseComponent(new ComponentCollection());
	$ContentBase =& new ContentBaseComponent(new ComponentCollection());
	
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
			if ($raw_data['Content']['content_type_id'] == 2 or $raw_data['Content']['content_type_id'] == 7) $content_list[$count]['manufacturer']	= $ContentBase->getManufacturerName($raw_data[$content_type]['manufacturer_id']);	
			if ($raw_data['Content']['content_type_id'] == 2 or $raw_data['Content']['content_type_id'] == 7) $content_list[$count]['label_id']	= $raw_data[$content_type]['label_id'];	
			$content_list[$count]['date_added']	= CakeTime::i18nFormat($raw_data['Content']['created']);	
			$content_list[$count]['date_modified']	= CakeTime::i18nFormat($raw_data['Content']['modified']);	

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
				$image_path = BASE . '/img/content/' . $raw_data['Content']['id'] . '/' . $raw_data['ContentImage']['image'];
				$thumb_name = substr_replace($raw_data['ContentImage']['image'] , '', strrpos($raw_data['ContentImage']['image'] , '.')).'-'.$config['THUMBNAIL_SIZE'].'.png';	
				$thumb_path = IMAGES . 'content' . '/' . $raw_data['Content']['id'] . '/' . $thumb_name;
				$thumb_url = BASE . '/img/content/' . $raw_data['Content']['id'] . '/' . $thumb_name;

					if(file_exists($thumb_path) && is_file($thumb_path)) {
						list($width, $height, $type, $attr) = getimagesize($thumb_path);
						$content_list[$count]['image'] =  $thumb_url;
						$content_list[$count]['image_original'] =  $image_path;
						$content_list[$count]['image_width'] = $width;
						$content_list[$count]['image_height'] = $height;
					} else {
						$content_list[$count]['image'] = BASE . '/images/thumb/' . $image_url;
						$content_list[$count]['image_original'] =  $image_path;
						$content_list[$count]['image_width'] = null;
						$content_list[$count]['image_height'] = null;
					}

			} else { 

				$image_url = '0/noimage.png';
				$thumb_name = 'noimage-'.$config['THUMBNAIL_SIZE'].'.png';	
				$thumb_path = IMAGES . 'content' . '/0/' . $thumb_name;
				$thumb_url = BASE . '/img/content' . '/0/' . $thumb_name;

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
	$vars['order'] = (!$sort_by) ? $params['order'] : $sort_by;
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
		<li><em><?php echo __('(type)') ?></em> - <?php echo __('Type of content to display. Seperate multiple values with commas, example:') ?> {content_listing type='category,page'}. <?php echo __('Defaults to') ?> 'all'.</li>
		<li><em><?php echo __('(parent)') ?></em> - <?php echo __('The parent of the content items to be shown. Accepts an alias or id, defaults to 0.') ?></li>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Useful if you want to override the default content listing template. Setting this will utilize the template that matches this alias.') ?></li>
		<li><em><?php echo __('(page)') ?></em> - <?php echo __('Current page.') ?></li>
		<li><em><?php echo __('(label_id)') ?></em> - <?php echo __('Display products with selected product label.') ?></li>
		<li><em><?php echo __('(order)') ?></em> - <?php echo __('Content listing sort order. Available values: ') . 'order,order-asc,order-desc,price,price-asc,price-desc,stock,stock-asc,stock-desc,name,name-asc,name-desc,id,id-asc,id-desc,ordered,ordered-asc,ordered-desc' ?></li>
		<li><em><?php echo __('(limit)') ?></em> - <?php echo __('Items per page.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_content_listing() {
}
?>