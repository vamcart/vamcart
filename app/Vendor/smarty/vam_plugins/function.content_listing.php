<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_content_listing()
{
$template = '<div>
 {if $pages_number > 1 || $page=="all"}
    <div class="paginator">
          <ul>
            <li>{lang}Pages{/lang}:</li>
            {for $pg=1 to $pages_number}
            <li><a href="{base_path}/category/{$content_alias->value}{$ext}/page/{$pg}" {if $pg == $page}class="current"{/if}>{$pg}</a></li>
            {/for}
            <li><a href="{base_path}/category/{$content_alias->value}{$ext}/page/all" {if "all" == $page}class="current"{/if}>{lang}All{/lang}</a></li>
          </ul>
    </div>
  {/if}  
<ul class="listing">
{foreach from=$content_list item=node}
	<li
	{if $node.alias == $content_alias}
		class="active"
	{/if}
	>
	<div><a href="{$node.url}"><img src="{$node.image}" alt="{$node.name}" 
	{if isset($thumbnail_width)}
	 width="{$thumbnail_width}"
	{/if}
	/></a></div>
	<div><a href="{$node.url}">{$node.name}</a></div></li>
{foreachelse}
	<li class="no_items">{lang}No Items Found{/lang}</li>
{/foreach}
</ul>
<div class="clear"></div>
  {if $pages_number > 1 || $page=="all"}
    <div class="paginator">
          <ul>
            <li>{lang}Pages{/lang}:</li>
            {for $pg=1 to $pages_number}
            <li><a href="{base_path}/category/{$content_alias->value}{$ext}/page/{$pg}" {if $pg == $page}class="current"{/if}>{$pg}</a></li>
            {/for}
            <li><a href="{base_path}/category/{$content_alias->value}{$ext}/page/all" {if "all" == $page}class="current"{/if}>{lang}All{/lang}</a></li>
          </ul>
    </div>
  {/if}  
</div>
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
		
	// Make sure parent is valid, if it's not a number get the correct parent number
	if(!isset($params['parent']))
		$params['parent'] = 0;
	if(!is_numeric($params['parent']))
	{
		$get_content = $Content->findByAlias($params['parent']);
		$params['parent'] = $get_content['Content']['id'];
	}


/*->***************************************************************/
                $Content->bindModel(array('hasMany' => array(
				'Attribute' => array(
                    'className' => 'Attribute'
					))));
/***************************************************************<-*/  


        if(!isset ($params['on_page']))
            $params['on_page'] = $config['PRODUCTS_PER_PAGE'];

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
/*->***************************************************************/
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
                    $or_val = array();
                    switch ($filter_value['type_attr']) 
                    {
                        case 'max_value':
                            if(trim($filter_value['value']) != '')
                            $or_val = array('AttributeDefValue.id = ' . $k ,'AttributeValue.val >= ' . $filter_value['value'] . ' OR (AttributeDefValue.val >= ' . $filter_value['value'] . ' AND AttributeValue.val IS NULL)');
                        break;
                        case 'min_value':
                            if(trim($filter_value['value']) != '')
                            $or_val = array('AttributeDefValue.id = ' . $k ,'AttributeValue.val <= ' . $filter_value['value'] . ' OR (AttributeDefValue.val <= ' . $filter_value['value'] . ' AND AttributeValue.val IS NULL)');
                        break;
                        case 'like_value':
                            $filter_value['value'] = "'%" . $filter_value['value'] . "%'";
                            $or_val = array('AttributeDefValue.id = ' . $k ,'AttributeValue.val not like ' . $filter_value['value'] . ' OR (AttributeDefValue.val not like ' . $filter_value['value'] . ' AND AttributeValue.val IS NULL)');
                        break;
                        case 'dig_value':
                            if(trim($filter_value['value']) != '' && is_numeric($filter_value['value']))
                            $or_val = array('AttributeDefValue.id = ' . $k ,'AttributeValue.val != ' . $filter_value['value'] . ' OR (AttributeDefValue.val != ' . $filter_value['value'] . ' AND AttributeValue.val IS NULL)');
                        break;
                        case 'list_value':
                            $filter_value['value'] = $filter_value['value'] + 0;
                            $or_val = array('AttributeDefValue.id = ' . $k ,'AttributeValue.val != ' . $filter_value['value'] . ' OR (AttributeDefValue.val != ' . $filter_value['value'] . ' AND AttributeValue.val IS NULL)');
                        break;
                        case 'checked_list':
                            $filter_value['value'] = $filter_value['value'] + 0;
                            if($filter_value['value'] != 0)$or_val = array('AttributeDefValue.id = ' . $k ,'AttributeValue.val != ' . $filter_value['value'] . ' OR (AttributeDefValue.val != ' . $filter_value['value'] . ' AND AttributeValue.val IS NULL)');
                        break;
                        default:
                            $filter_value['value'] = $filter_value['value'] + 0;
                            $or_val = array('AttributeDefValue.id = ' . $k ,'AttributeValue.val != ' . $filter_value['value'] . ' OR (AttributeDefValue.val != ' . $filter_value['value'] . ' AND AttributeValue.val IS NULL)');
                        break;
                    }
                    if(!empty($or_val))array_push($attribute_conditions, $or_val);
                }
            }
            if(!empty($attribute_conditions))
            {    
                $attribute_conditions = array('OR' => $attribute_conditions);

                $tmp_content_list_data_conditions = array_merge($content_list_data_conditions, $attribute_conditions);
                $content_filtered_list_data = $ContentFiltered->find('all', array('conditions' => $tmp_content_list_data_conditions, 'order' => array('Content.order ASC') ,'joins' => $content_list_data_joins ,'group' => array('Content.id')));

                if(!empty($content_filtered_list_data))
                {
                    foreach($content_filtered_list_data AS $k => $content_filtered)
                    {
                        $tmp_filter_list[$k] = $content_filtered['Content']['id'];
                    }
                    $content_list_data_conditions = array_merge($content_list_data_conditions, array('NOT' => array('Content.id' => $tmp_filter_list)));
                }
            }
        }
/***************************************************************<-*/          
            if($params['page'] == 'all'){          
                $content_list_data = $Content->find('all', array('conditions' => $content_list_data_conditions, 'order' => array('Content.order ASC')));
                $content_total = $Content->find('count',array('conditions' => $content_list_data_conditions));
            }
            else{
                $content_list_data = $Content->find('all', array('conditions' => $content_list_data_conditions, 'limit' => $params['on_page'],'page' => $params['page'], 'order' => array('Content.order ASC')));
                $content_total = $Content->find('count',array('conditions' => $content_list_data_conditions));
            }
        }
        else{
            $content_list_data = $Content->find('all', array('conditions' => $content_list_data_conditions, 'order' => array('Content.order ASC')));
        }
	
	// Loop through the content list and create a new array with only what the template needs
	$content_list = array();
	$count = 0;
	foreach($content_list_data AS $raw_data)
	{
		if(in_array(strtolower($raw_data['ContentType']['name']),$allowed_types))
		{
			$content_list[$count]['name']	= $raw_data['ContentDescription']['name'];
			$content_list[$count]['alias']	= $raw_data['Content']['alias'];
			$content_list[$count]['price']	= $raw_data['ContentProduct']['price'];	
			$content_list[$count]['stock']	= $raw_data['ContentProduct']['stock'];	
			$content_list[$count]['model']	= $raw_data['ContentProduct']['model'];	
			$content_list[$count]['weight']	= $raw_data['ContentProduct']['weight'];	
/*->***************************************************************/
                        $content_list[$count]['atributes'] = array();
                        foreach($raw_data['Attribute'] AS $atribute)
                        {
                            $content_list[$count]['atributes'][$atribute['parent_id']]['id'] = $atribute['id'];
                            $content_list[$count]['atributes'][$atribute['parent_id']]['value'] = $atribute['val'];
                        }
/***************************************************************<-*/      
		if (isset($raw_data['ContentImage']['image']) && file_exists(IMAGES . 'content/' . $raw_data['Content']['id'] . '/' . $raw_data['ContentImage']['image'])) {
			$content_list[$count]['icon']	= BASE . '/img/content/' . $raw_data['Content']['id'] . '/' . $raw_data['ContentImage']['image'];
		}
		
			if($raw_data['ContentImage']['image'] != "")
				$image_url = 'content/' . $raw_data['Content']['id'] . '/' . $raw_data['ContentImage']['image'];
			else 
				$image_url = 'noimage.png';
				
			if($config['GD_LIBRARY'] == 0)
				$content_list[$count]['image'] =  BASE . '/img/' . $image_url;
			else
				$content_list[$count]['image'] = BASE . '/images/thumb?src=/' . $image_url . '&w=' . $config['THUMBNAIL_SIZE'];
			
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
             $vars['pages_number'] = ceil($content_total/$params['on_page']);
         }
         
	if($config['GD_LIBRARY'] == 0)
		$vars['thumbnail_width'] = $config['THUMBNAIL_SIZE'];

/*->***************************************************************/
	if(!empty($content['CompareAttribute']))$vars['is_compare'] = 1;
/***************************************************************<-*/  


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
		<li><em><?php echo __('(on_page)') ?></em> - <?php echo __('Items per page.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_content_listing() {
}
?>