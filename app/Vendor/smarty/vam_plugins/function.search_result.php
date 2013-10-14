<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
function default_template_search_result()
{
$template = '
{if $content_list}

{if $pages_number > 1 || $page=="all"}
<!-- start: Pagination -->
<div class="pagination pagination-centered">
	<ul>
		{for $pg=1 to $pages_number}
		<li{if $pg == $page} class="active"{/if}><a href="{base_path}/category/{$content_alias->value}{$ext}/page/{$pg}">{$pg}</a></li>
		{/for}
		<li><a href="{base_path}/category/{$content_alias->value}{$ext}/page/all" {if "all" == $page}class="current"{/if}>{lang}All{/lang}</a></li>
	</ul>
</div>
<!-- end: Pagination -->
{/if}  
  
<!-- start: products listing -->
<div class="row-fluid shop-products">
	<ul class="thumbnails">
		{foreach from=$content_list item=node}
		<li class="item span4 {if $node@index is div by 3}first{/if}">
			<div class="thumbnail">
				<a href="{$node.url}" class="image"><img src="{$node.image}" alt="{$node.name}"{if isset($thumbnail_width)} width="{$thumbnail_width}"{/if} /><span class="frame-overlay"></span><span class="price">{$node.price}</span></a>
			<div class="inner notop nobottom">
				<h4 class="title">{$node.name}</h4>
				<p class="description">{$node.description|strip_tags|truncate:30:"...":true}</p>
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
<!-- end: products listing -->

{if $pages_number > 1 || $page=="all"}
<!-- start: Pagination -->
<div class="pagination pagination-centered">
	<ul>
		{for $pg=1 to $pages_number}
		<li{if $pg == $page} class="active"{/if}><a href="{base_path}/category/{$content_alias->value}{$ext}/page/{$pg}">{$pg}</a></li>
		{/for}
		<li><a href="{base_path}/category/{$content_alias->value}{$ext}/page/all" {if "all" == $page}class="current"{/if}>{lang}All{/lang}</a></li>
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

		$CurrencyBase =& new CurrencyBaseComponent(new ComponentCollection());
	
		foreach($content_list_data AS $raw_data) {
			$content_list[$count]['name']   = $raw_data['ContentDescription']['name'];
			$content_list[$count]['description']	= $raw_data['ContentDescription']['description'];
			$content_list[$count]['meta_title']	= $raw_data['ContentDescription']['meta_title'];
			$content_list[$count]['meta_description']	= $raw_data['ContentDescription']['meta_description'];
			$content_list[$count]['meta_keywords']	= $raw_data['ContentDescription']['meta_keywords'];
			$content_list[$count]['id']	= $raw_data['Content']['id'];
			$content_list[$count]['alias']  = $raw_data['Content']['alias'];
			$content_list[$count]['price']  = $CurrencyBase->display_price($raw_data['ContentProduct']['price']);
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

