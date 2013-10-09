<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
function default_template_search_result()
{
$template = '<div>
 {if $pages_number > 1 || $page=="all"}
    <div class="paginator">
          <ul>
            <li>{lang}Pages{/lang}:</li>
            {for $pg=1 to $pages_number}
            <li><a href="{base_path}/page/search-result{$ext}?page={$pg}&keyword={$keyword}" {if $pg == $page}class="current"{/if}>{$pg}</a></li>
            {/for}
            <li><a href="{base_path}/page/search-result{$ext}?page={$pg}&keyword={$keyword}" {if "all" == $page}class="current"{/if}>{lang}All{/lang}</a></li>
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

  <div>
    {attribute_list value_attributes=$node.attributes}
	</div>

  {if isset($is_compare)}
  <div><a class="btn" href="{base_path}/category/addcmp/{$node.alias}/{$content_alias->value}{$ext}"><i class="cus-add"></i> {lang}Add to compare{/lang}</a></div>
	{/if}

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
            <li><a href="{base_path}/page/search-result{$ext}?page={$pg}&keyword={$keyword}" {if $pg == $page}class="current"{/if}>{$pg}</a></li>
            {/for}
            <li><a href="{base_path}/page/search-result{$ext}?page={$pg}&keyword={$keyword}" {if "all" == $page}class="current"{/if}>{lang}All{/lang}</a></li>
          </ul>
    </div>
  {/if}  
  
</div>
';		

return $template;
}

function smarty_function_search_result($params, $template)
{
	global $config;
	App::uses('Sanitize', 'Utility');
	$clean = new Sanitize();
	$clean->paranoid($_GET);

	App::uses('SmartyComponent', 'Controller/Component');
	$Smarty =& new SmartyComponent(new ComponentCollection());

	$params['limit'] = $config['PRODUCTS_PER_PAGE'];

	$vars = $template->smarty->tpl_vars;
	
	if (!isset($_GET['page'])) {
		$vars['page'] = 1;
	} else {
		$vars['page'] = $_GET['page'];
	}

	if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {

		App::import('Model', 'Content');
		$Content =& new Content();

		$Content->unbindModel(array('belongsTo' => array('ContentType', 'Template')), false);
		$Content->unbindModel(array('hasMany' => array('ContentImage', 'ContentDescription')), false);
		$Content->unbindModel(array('hasOne' => array('ContentLink', 'ContentProduct', 'ContentPage', 'ContentCategory', 'ContentArticle', 'ContentNews')), false);

		$Content->bindModel(array(
			'hasOne' => array(
				'ContentDescription' => array(
					'className' => 'ContentDescription',
					'conditions'   => 'language_id = '.$_SESSION['Customer']['language_id']
				)
			)
		), false);

		$Content->bindModel(array(
			'belongsTo' => array(
				'ContentType' => array(
					'className' => 'ContentType'
				)
			)
		), false);

		$Content->bindModel(array(
			'hasOne' => array(
				'ContentImage' => array(
					'className' => 'ContentImage',
					'conditions' => array(
						'ContentImage.order' => '1'
					)
				)
			)
		), false);

		$Content->bindModel(array(
			'hasOne' => array(
				'ContentProduct' => array(
					'className' => 'ContentProduct'
				)
			)
		), false);

		$search_conditions = array('AND' => array('ContentType.name' => 'product',
						'OR' => array('ContentDescription.name LIKE' => '%' . $_GET['keyword'] . '%',
							      'ContentDescription.description LIKE' => '%' . $_GET['keyword'] . '%')));
		$Content->recursive = 2;

		$content_total = $content_list_data = $Content->find('count', array('conditions' => $search_conditions));;

		if ($vars['page'] == 'all') {
			$content_list_data = $Content->find('all', array('conditions' => $search_conditions));
		} else {
			$content_list_data = $Content->find('all', array('conditions' => $search_conditions, 'limit' => $params['limit'], 'page' => $vars['page']));
		}

		$content_list = array();
		$count = 0;

		foreach($content_list_data AS $raw_data) {
			$content_list[$count]['name']   = $raw_data['ContentDescription']['name'];
			$content_list[$count]['alias']  = $raw_data['Content']['alias'];
			$content_list[$count]['price']  = $raw_data['ContentProduct']['price'];
			$content_list[$count]['stock']  = $raw_data['ContentProduct']['stock'];
			$content_list[$count]['model']  = $raw_data['ContentProduct']['model'];
			$content_list[$count]['weight'] = $raw_data['ContentProduct']['weight'];

			if (isset($raw_data['ContentImage']['image']) && file_exists(IMAGES . 'content/' . $raw_data['Content']['id'] . '/' . $raw_data['ContentImage']['image'])) {
				$content_list[$count]['icon']   = BASE . '/img/content/' . $raw_data['Content']['id'] . '/' . $raw_data['ContentImage']['image'];
			}

			if ($raw_data['ContentImage']['image'] != "") {
				$image_url = 'content/' . $raw_data['Content']['id'] . '/' . $raw_data['ContentImage']['image'];
			} else {
				$image_url = 'noimage.png';
			}

			if ($config['GD_LIBRARY'] == 0) {
				$content_list[$count]['image'] =  BASE . '/img/' . $image_url;
			} else {
				$content_list[$count]['image'] = BASE . '/images/thumb?src=/' . $image_url . '&amp;w=' . $config['THUMBNAIL_SIZE'];
			}

			$content_list[$count]['url']    = BASE . '/' . $raw_data['ContentType']['name'] . '/' . $raw_data['Content']['alias'] . $config['URL_EXTENSION'];
			$count ++;
		}
	} else {
		$content_list = array();
		$count = 0;
	}

	$vars['content_list'] = $content_list;
	$vars['count'] = $count;
	$params['keyword'] = $_GET['keyword'];
	$vars['keyword'] = urlencode($_GET['keyword']);

	$vars['ext'] = $config['URL_EXTENSION'];
	$vars['pages_number'] = ceil($content_total/$params['limit']);

	if($config['GD_LIBRARY'] == 0) {
		$vars['thumbnail_width'] = $config['THUMBNAIL_SIZE'];
        }

	$display_template = $Smarty->load_template($params, 'search_result');
	$Smarty->display($display_template, $vars);

}

function smarty_help_function_search_result() {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays a list of search result content.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{search_result}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Useful if you want to override the default content listing template. Setting this will utilize the template that matches this alias.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_search_result() {
}

