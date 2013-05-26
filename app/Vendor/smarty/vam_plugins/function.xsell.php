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
<div id="xsell">
	<div id="xsell-title"><h1>{lang}Also purchased{/lang}:</h1></div>
	{foreach from=$relations item=xsell_product}
		<dl class="xsell-product">
			<dt class="xsell-product-name">{$xsell_product.name}</dt>
			{if sizeof($xsell_product.image) > 0 }
			<dt class="xsell-product-image>
			{if $thumbnail == "true"}
				<a href="{$xsell_product.image.image_path}" class="zoom" rel="group" title="{$xsell_product.image.image}"><img src="{$xsell_product.image.image_thumb}" alt="{$xsell_product.image.image}" /></a>
			{else}
				<img src="{$xsell_product.image.image_path}" width="{$thumbnail_size}" alt="{$xsell_product.image.image}" />
			{/if}
			</dt>
			{else}
				{if $thumbnail == "true"}
					<li><img src="{$noimg_thumb}" alt="{lang}No Image{/lang}" /></li>
				{else}
					<li><img src="{$noimg_path}" width="{$thumbnail_size}" alt="{lang}No Image{/lang}" /></li>
				{/if}
			{/if}
			<dl class="pricing"><b>{$xsell_product.price}</b></dl>
			<form method="post" action="/cart/purchase_product/">
				<input name="product_id" type="hidden" value="{$xsell_product.id}" />
				<input name="product_quantity" type="hidden" value="1" />
				{$xsell_product.button}
			</form>
		</dl>
	{/foreach}
	<br style="clear: both" />
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
			$content['ContentRelations'][$key]['image']['image_thumb'] =  BASE . '/images/thumb?src=/content/' . $content_id . '/' . $image['ContentImage']['image'] . '&w=' . $params['width'];
		} else {
		    $content['ContentRelations'][$key]['image'] = array();
		}
		
		$product = $Content->find('first', array('conditions' => array('Content.id' => $content['ContentRelations'][$key]['id'])));
		$content['ContentRelations'][$key]['price'] = $CurrencyBase->display_price($product['ContentProduct']['price']);

		$product = $Content->ContentDescription->find('first', array('conditions' => array('content_id' => $content['ContentRelations'][$key]['id'], 
									       'ContentDescription.language_id' => $language_id)));
		$content['ContentRelations'][$key]['name'] = $product['ContentDescription']['name'];
		$content['ContentRelations'][$key]['button'] = '<button class="btn" type="submit" value="'. __('Add To Cart', true) .'"><i class="cus-cart-add"></i> '. __('Add To Cart', true) .'</button>';
	}

	$assignments = array('relations' => $content['ContentRelations'],
			     'thumbnail' => $params['thumbnail'],
			     'noimg_thumb' => BASE . '/images/thumb?src=/noimage.png&w=' . $params['width'],
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