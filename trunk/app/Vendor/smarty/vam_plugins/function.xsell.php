<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

function default_template_xsell()
{
    $template = '
<div class="row-fluid">
	<h3>{lang}Also purchased{/lang}</h3>
</div>

<div class="row-fluid shop-products">
	<ul class="thumbnails">
		{foreach from=$relations item=node}
      <li class="item span4 {if $node@index is div by 3}first{/if}">
			<div class="thumbnail">

				{if sizeof($node.image) > 0 }
				{if $thumbnail == "true"}
				<a href="{$node.url}" class="image"><img src="{$node.image.image_thumb}" alt="{$node.image.image}" /><span class="frame-overlay"></span><span class="price">{$node.price}</span></a>
				{else}
				<a href="{$node.url}" class="image"><img src="{$node_product.image.image_path}" width="{$thumbnail_size}" alt="{$node.image.image}" /><span class="frame-overlay"></span><span class="price">{$node.price}</span></a>
				{/if}
				{else}
				{if $thumbnail == "true"}
				<a href="{$node.url}" class="image"><img src="{$noimg_thumb}" alt="{lang}No Image{/lang}" /><span class="frame-overlay"></span><span class="price">{$node.price}</span></a>
				{else}
				<a href="{$node.url}" class="image"><img src="{$noimg_path}" width="{$thumbnail_size}" alt="{lang}No Image{/lang}" /><span class="frame-overlay"></span><span class="price">{$node.price}</span></a>
				{/if}
				{/if}
				
			<div class="inner notop nobottom">
				<h4 class="title">{$node.name}</h4>
				<p class="description">{$node.description|strip_tags|truncate:30:"...":true}</p>
              </div>
			</div>
			{product_form product_id={$node.id}}
			<div class="inner darken notop">
				<button class="btn btn-add-to-cart" type="submit"><i class="icon-shopping-cart"></i> {lang}Buy{/lang}</button>
			</div>
			{/product_form}
		</li>
		{/foreach}
	</ul>
</div>
';
    return $template;
}

function smarty_function_xsell($params, &$smarty)
{
	global $content;
	global $config;

	if (!isset($content['ContentRelations']) || sizeof($content['ContentRelations']) < 1) {
		return;
	}

	App::uses('SmartyComponent', 'Controller/Component');
	$Smarty = new SmartyComponent(new ComponentCollection());

	App::import('Model', 'ContentImage');
	$ContentImage = new ContentImage();

	App::import('Model', 'Content');
	$Content = new Content();

	App::uses('CurrencyBaseComponent', 'Controller/Component');
	$CurrencyBase = new CurrencyBaseComponent(new ComponentCollection());

	if(!isset($params['number']))
		$params['number'] = null;

	if(!isset($params['width']))
		$params['width'] = $config['THUMBNAIL_SIZE'];

	if(!isset($params['height']))
		$params['height'] = 100;

	if(!isset($params['thumbnail']))
		$params['thumbnail'] = 'true';
	elseif($params['thumbnail'] == 'false')
		$params['thumbnail'] = 'false';

	if($config['GD_LIBRARY'] == '0')
		$params['thumbnail'] = 'false';

	$language_id = $content['ContentDescription']['language_id'];

	foreach ($content['ContentRelations'] as $key => $related) {
		$image = $ContentImage->find('first', array('conditions' => array('content_id' => $content['ContentRelations'][$key]['id'])));
		if (isset($image['ContentImage'])) {
			$content_id = $image['ContentImage']['content_id'];
			$content['ContentRelations'][$key]['image'] = $image['ContentImage'];
			$content['ContentRelations'][$key]['image']['image_path'] = BASE . '/img/content/' . $content_id . '/' . $image['ContentImage']['image'];
			$content['ContentRelations'][$key]['image']['image_thumb'] =  BASE . '/images/thumb/' . $content_id . '/' . $image['ContentImage']['image'];
		} else {
		    $content['ContentRelations'][$key]['image'] = array();
		}
		
		$product = $Content->find('first', array('conditions' => array('Content.id' => $content['ContentRelations'][$key]['id'])));
		$content['ContentRelations'][$key]['id'] = $content['ContentRelations'][$key]['id'];
		$content['ContentRelations'][$key]['price'] = $CurrencyBase->display_price($product['ContentProduct']['price']);
		$content['ContentRelations'][$key]['url'] = BASE . '/' . $product['ContentType']['name'] . '/' . $product['Content']['alias'] . $config['URL_EXTENSION'];

		$product = $Content->ContentDescription->find('first', array('conditions' => array('content_id' => $content['ContentRelations'][$key]['id'], 
									       'ContentDescription.language_id' => $language_id)));
		$content['ContentRelations'][$key]['name'] = $product['ContentDescription']['name'];
		$content['ContentRelations'][$key]['description'] = $product['ContentDescription']['description'];
	}

	$assignments = array('relations' => $content['ContentRelations'],
			     'thumbnail' => $params['thumbnail'],
			     'noimg_thumb' => BASE . '/images/thumb/0/noimage.png',
			     'noimg_path' => BASE . '/img/noimage.png',
			     'thumbnail_size' => $config['THUMBNAIL_SIZE']
			);

	$display_template = $Smarty->load_template($params, 'xsell');
	$Smarty->display($display_template, $assignments);
}

function smarty_help_function_xsell () {
	?>
	<h3><?php echo __('What does this tag do?') ?></h3>
	<p><?php echo __('Displays also purchased products for the current content.') ?></p>
	<h3><?php echo __('How do I use it?') ?></h3>
	<p><?php echo __('Just insert the tag into your template like:') ?> <code>{xsell}</code></p>
	<h3><?php echo __('What parameters does it take?') ?></h3>
	<ul>
		<li><em><?php echo __('(template)') ?></em> - <?php echo __('Useful if you want to override the default content listing template. Setting this will utilize the template that matches this alias.') ?></li>
	</ul>
	<?php
}

function smarty_about_function_xsell () {
}
?>