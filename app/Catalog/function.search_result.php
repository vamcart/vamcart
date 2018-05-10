<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
function default_template_search_result()
{
$template = '
{if $content_list}

{if $pages_number > 1}
<!-- start: Pagination -->
<div class="text-center">
  <ul class="pagination">
    {for $pg=1 to $pages_number}
    <li{if $pg == $page} class="active"{/if}><a href="{base_path}/page/search-result{$ext}?page={$pg}&keyword={$keyword}">{$pg}</a></li>
    {/for}
    <li{if "all" == $page} class="active"{/if}><a href="{base_path}/page/search-result{$ext}?page=all&keyword={$keyword}">{lang}All{/lang}</a></li>
  </ul>
</div>
<!-- end: Pagination -->
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

{if $pages_number > 1}
<!-- start: Pagination -->
<div class="text-center">
  <ul class="pagination">
    {for $pg=1 to $pages_number}
    <li{if $pg == $page} class="active"{/if}><a href="{base_path}/page/search-result{$ext}?page={$pg}&keyword={$keyword}">{$pg}</a></li>
    {/for}
    <li{if "all" == $page} class="active"{/if}><a href="{base_path}/page/search-result{$ext}?page=all&keyword={$keyword}">{lang}All{/lang}</a></li>
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
	$Smarty = new SmartyComponent(new ComponentCollection());

	App::uses('CakeTime', 'Utility');

	$params['limit'] = $config['PRODUCTS_PER_PAGE'];
	$content_total = 0;

	$vars = $template->smarty->tpl_vars;
	
	if (!isset($_GET['page'])) {
		$vars['page'] = 1;
	} else {
		$vars['page'] = $_GET['page'];
	}

	if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {

		App::import('Model', 'Content');
		$Content = new Content();

		$Content->unbindModel(array('belongsTo' => array('ContentType', 'Template')), false);
		$Content->unbindModel(array('hasMany' => array('ContentImage', 'ContentDescription', 'Attribute')), false);
		$Content->unbindModel(array('hasOne' => array('ContentLink', 'ContentProduct', 'ContentPage', 'ContentCategory', 'ContentArticle', 'ContentNews')), false);
		$Content->unbindModel(array('hasAndBelongsToMany' => array('xsell')), false);

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

		$Content->bindModel(array(
			'hasOne' => array(
				'ContentDownloadable' => array(
					'className' => 'ContentDownloadable'
				)
			)
		), false);

		$Content->bindModel(array('hasOne' => array(
				'ContentSpecial' => array(
                    'className' => 'ContentSpecial'
					))));

		$search_conditions = array('AND' => array('Content.active' => '1', 'ContentType.name' => array('product', 'downloadable'),
						'OR' => array('ContentDescription.name LIKE' => '%' . $_GET['keyword'] . '%',
						         'ContentProduct.model LIKE' => '%' . $_GET['keyword'] . '%',
							      'ContentDescription.description LIKE' => '%' . $_GET['keyword'] . '%')));
		$Content->recursive = 1;

		$content_total = $content_list_data = $Content->find('count', array('conditions' => $search_conditions 
																									, 'group' => array('Content.alias')
																									));


		if ($vars['page'] == 'all') {
			$content_list_data = $Content->find('all', array('conditions' => $search_conditions
			, 'group' => array('Content.alias')
			));
		} else {
			$content_list_data = $Content->find('all', array('conditions' => $search_conditions
																			, 'group' => array('Content.alias') 
																			, 'limit' => $params['limit'] 
																			, 'page' => $vars['page']
																			));
		}

		$content_list = array();
		$count = 0;

		$CurrencyBase = new CurrencyBaseComponent(new ComponentCollection());
		$ContentBase = new ContentBaseComponent(new ComponentCollection());
	
		foreach($content_list_data AS $raw_data) {
			$content_type = 'ContentProduct';
			$price = $raw_data['ContentProduct']['price'];
	
			if ($raw_data['Content']['content_type_id'] == 7) {
				$content_type = 'ContentDownloadable';
				$price = $raw_data['ContentDownloadable']['price'];
			}
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
			if ($raw_data['Content']['content_type_id'] == 2 or $raw_data['Content']['content_type_id'] == 7) $content_list[$count]['label_id']	= $raw_data[$content_type]['label_id'];	
			$content_list[$count]['date_added']	= CakeTime::i18nFormat($raw_data['Content']['created']);	
			$content_list[$count]['date_modified']	= CakeTime::i18nFormat($raw_data['Content']['modified']);	

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

	// Error page
	//if (!$content_list) {
		//throw new NotFoundException();
	//}	

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

