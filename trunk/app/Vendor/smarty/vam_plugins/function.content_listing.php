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

{if $pages_number > 1}
<!-- start: Pagination -->
<div class="pagination pagination-centered">
	<ul>
		{for $pg=1 to $pages_number}
		<li{if $pg == $page} class="active"{/if}><a href="{base_path}/category/{$content_alias->value}{$ext}/page/{$pg}">{$pg}</a></li>
		{/for}
		<li{if "all" == $page} class="active"{/if}><a href="{base_path}/category/{$content_alias->value}{$ext}/page/all">{lang}All{/lang}</a></li>
	</ul>
</div>
<!-- end: Pagination -->
{/if}  
  
<!-- start: products listing -->
<div class="row-fluid shop-products">
	<ul class="thumbnails">
		{foreach from=$content_list item=node}
		<li class="item span4 {if $node@index is div by 3}first{/if}">
			<div class="thumbnail text-center">
				<a href="{$node.url}" class="image"><img src="{$node.image}" alt="{$node.name}"{if isset($thumbnail_width)} width="{$thumbnail_width}"{/if} /><span class="frame-overlay"></span><span class="price">{$node.price}</span></a>
			<div class="inner notop nobottom text-left">
				<h4 class="title"><a href="{$node.url}">{$node.name}</a></h4>
				<div class="description">{$node.short_description|strip_tags|truncate:30:"...":true}</div>
				<div class="description">{attribute_list value_attributes=$node.attributes}</div>
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

{if $pages_number > 1}
<!-- start: Pagination -->
<div class="pagination pagination-centered">
	<ul>
		{for $pg=1 to $pages_number}
		<li{if $pg == $page} class="active"{/if}><a href="{base_path}/category/{$content_alias->value}{$ext}/page/{$pg}">{$pg}</a></li>
		{/for}
		<li{if "all" == $page} class="active"{/if}><a href="{base_path}/category/{$content_alias->value}{$ext}/page/all">{lang}All{/lang}</a></li>
	</ul>
</div>
<!-- end: Pagination -->
{/if}

{else}
{lang}No Items Found{/lang}

{/if}
';		

return $template;
}

function smarty_function_content_listing($params, $template)
{
	global $content;
	
	// Cache the output.
	$cache_name = 'vam_content_listing_output_' . $content['Content']['id'] .  (isset($params['template'])?'_'.$params['template']:'') .  (isset($params['parent'])?'_'.$params['parent']:'') . '_' . $_SESSION['Customer']['language_id'];
	$output = Cache::read($cache_name);
	if($output === false)
	{
		ob_start();
		
	global $config;
		
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
		
	// Make sure parent is valid, if it's not a number get the correct parent number
	if(!isset($params['parent']))
		$params['parent'] = 0;
	if(!is_numeric($params['parent']))
	{
		$get_content = $Content->findByAlias($params['parent']);
		$params['parent'] = $get_content['Content']['id'];
	}


                $Content->bindModel(array('hasMany' => array(
				'Attribute' => array(
                    'className' => 'Attribute'
					))));

        if(!isset ($params['page']))
            $params['page'] = 1;

        if(!isset ($params['type']))
            $params['type'] = 'all';
	
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
	$content_list_data_conditions = array('Content.parent_id' => $params['parent'],'Content.active' => '1','Content.show_in_menu' => '1');
	$Content->recursive = 2;

        // Applying pagination for products only
        if(strpos($params['type'],'product') !== false){

        global $filter_list;
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
                $content_filtered_list_data = $ContentFiltered->find('list', array('fields' => 'id','conditions' => $tmp_content_list_data_conditions, 'order' => array('Content.order ASC') ,'joins' => $content_list_data_joins ,'group' => array('Content.id')));
                $next_flt = array('Content.id' => $content_filtered_list_data);
            }
            $content_list_data_conditions = array_merge($content_list_data_conditions,$next_flt);
        }
            if($params['page'] == 'all'){          

                $content_list_data = $Content->find('all', array('conditions' => $content_list_data_conditions, 'order' => array('Content.order ASC')));
                $content_total = $Content->find('count',array('conditions' => $content_list_data_conditions));
            }
            else{
            	
	  	        if(!isset ($params['limit']))
   	         $params['limit'] = $config['PRODUCTS_PER_PAGE'];
            
                $content_list_data = $Content->find('all', array('conditions' => $content_list_data_conditions, 'limit' => $params['limit'],'page' => $params['page'], 'order' => array('Content.id ASC, Content.order ASC')));
                $content_total = $Content->find('count',array('conditions' => $content_list_data_conditions));
            }
        }
        else{
            $content_list_data = $Content->find('all', array('conditions' => $content_list_data_conditions, 'limit' => $params['limit'], 'order' => array('Content.order ASC, Content.id ASC')));
        }
	
	// Loop through the content list and create a new array with only what the template needs
	$content_list = array();
	$count = 0;
	
	$CurrencyBase =& new CurrencyBaseComponent(new ComponentCollection());
	
	foreach($content_list_data AS $raw_data)
	{
		if ($raw_data['Content']['content_type_id'] == 7) {
			$price = $raw_data['ContentDownloadable']['price'];
		} else {
			$price = $raw_data['ContentProduct']['price'];
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
			$content_list[$count]['price']	= $CurrencyBase->display_price($price);	
			$content_list[$count]['stock']	= $raw_data['ContentProduct']['stock'];	
			$content_list[$count]['model']	= $raw_data['ContentProduct']['model'];	
			$content_list[$count]['weight']	= $raw_data['ContentProduct']['weight'];	
			$content_list[$count]['date_added']	= CakeTime::i18nFormat($raw_data['Content']['created']);	
			$content_list[$count]['date_modified']	= CakeTime::i18nFormat($raw_data['Content']['modified']);	

                        $content_list[$count]['attributes'] = array();
                        foreach($raw_data['Attribute'] AS $attribute)
                        {
                            $content_list[$count]['attributes'][$attribute['parent_id']]['id'] = $attribute['id'];
                            $content_list[$count]['attributes'][$attribute['parent_id']]['value'] = $attribute['val'];
                        }

		if (isset($raw_data['ContentImage']['image']) && file_exists(IMAGES . 'content/' . $raw_data['Content']['id'] . '/' . $raw_data['ContentImage']['image'])) {
			$content_list[$count]['icon']	= BASE . '/img/content/' . $raw_data['Content']['id'] . '/' . $raw_data['ContentImage']['image'];
		}
		
			if($raw_data['ContentImage']['image'] != "")
				$image_url = $raw_data['Content']['id'] . '/' . $raw_data['ContentImage']['image'];
			else 
				$image_url = '0/noimage.png';
				
			if($config['GD_LIBRARY'] == 0)
				$content_list[$count]['image'] =  BASE . '/img/content/' . $image_url;
			else
				$content_list[$count]['image'] = BASE . '/images/thumb/' . $image_url;
				//list($width, $height, $type, $attr) = getimagesize(Router::url(BASE . '/images/thumb/' . $image_url, true));
				//$content_list[$count]['image_width'] = $width;
				//$content_list[$count]['image_height'] = $height;
			
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
        $vars['ext'] = $config['URL_EXTENSION'];

        
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
		Cache::write($cache_name, $output);		
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
		<li><em><?php echo __('(limit)') ?></em> - <?php echo __('Items per page.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_content_listing() {
}
?>