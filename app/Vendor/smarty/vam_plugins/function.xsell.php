<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
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
      <li class="item span4{if $node@index is div by 3} first{/if}">
			<div class="thumbnail text-center">
				<a href="{$node.url}" class="image"><img src="{$node.image.image}" alt="{$node.name}"{if {$node.image.image_width} > 0} width="{$node.image.image_width}"{/if}{if {$node.image.image_height} > 0} height="{$node.image.image_height}"{/if} /><span class="frame-overlay"></span><span class="price">{$node.price}</span></a>
			<div class="inner notop nobottom text-left">
				<h4 class="title"><a href="{$node.url}">{$node.name}</a></h4>
				<p class="description">{$node.short_description|strip_tags|truncate:30:"...":true}</p>
              </div>
			</div>
			{product_form product_id={$node.id}}
			<div class="inner darken notop">
				<button class="btn btn-add-to-cart" type="submit"><i class="fa fa-shopping-cart"></i> {lang}Buy{/lang}</button>
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

	$language_id = $content['ContentDescription']['language_id'];

	foreach ($content['ContentRelations'] as $key => $related) {
		$image = $ContentImage->find('first', array('conditions' => array('content_id' => $content['ContentRelations'][$key]['id'])));

		// Content Image
		
		if($image['ContentImage']['image'] != "") {
			$image_url = $content['ContentRelations'][$key]['id'] . '/' . $image['ContentImage']['image'];
			$thumb_name = substr_replace($image['ContentImage']['image'] , '', strrpos($image['ContentImage']['image'] , '.')).'-'.$config['THUMBNAIL_SIZE'].'.png';	
			$thumb_path = IMAGES . 'content' . '/' . $content['ContentRelations'][$key]['id'] . '/' . $thumb_name;
			$thumb_url = BASE . '/img/content/' . $content['ContentRelations'][$key]['id'] . '/' . $thumb_name;

				if(file_exists($thumb_path) && is_file($thumb_path)) {
					list($width, $height, $type, $attr) = getimagesize($thumb_path);
					$content['ContentRelations'][$key]['image']['image'] =  $thumb_url;
					$content['ContentRelations'][$key]['image']['image_width'] = $width;
					$content['ContentRelations'][$key]['image']['image_height'] = $height;
				} else {
					$content['ContentRelations'][$key]['image']['image'] = BASE . '/images/thumb/' . $image_url;
					$content['ContentRelations'][$key]['image']['image_width'] = null;
					$content['ContentRelations'][$key]['image']['image_height'] = null;
				}

		} else { 

			$image_url = '0/noimage.png';
			$thumb_name = 'noimage-'.$config['THUMBNAIL_SIZE'].'.png';	
			$thumb_path = IMAGES . 'content' . '/0/' . $thumb_name;
			$thumb_url = BASE . '/img/content' . '/0/' . $thumb_name;

				if(file_exists($thumb_path) && is_file($thumb_path)) {
					list($width, $height, $type, $attr) = getimagesize($thumb_path);
					$content['ContentRelations'][$key]['image']['image'] =  $thumb_url;
					$content['ContentRelations'][$key]['image']['image_width'] = $width;
					$content['ContentRelations'][$key]['image']['image_height'] = $height;
				} else {
					$content['ContentRelations'][$key]['image']['image'] = BASE . '/images/thumb/' . $image_url;
					$content['ContentRelations'][$key]['image']['image_width'] = null;
					$content['ContentRelations'][$key]['image']['image_height'] = null;
				}

		}
		
		$product = $Content->find('first', array('conditions' => array('Content.id' => $content['ContentRelations'][$key]['id'])));
		$content['ContentRelations'][$key]['id'] = $content['ContentRelations'][$key]['id'];
		$content['ContentRelations'][$key]['stock'] = $product['ContentProduct']['stock'];
		$content['ContentRelations'][$key]['price'] = $CurrencyBase->display_price($product['ContentProduct']['price']);
		$content['ContentRelations'][$key]['url'] = BASE . '/' . $product['ContentType']['name'] . '/' . $product['Content']['alias'] . $config['URL_EXTENSION'];

		$product = $Content->ContentDescription->find('first', array('conditions' => array('content_id' => $content['ContentRelations'][$key]['id'], 
									       'ContentDescription.language_id' => $language_id)));
		$content['ContentRelations'][$key]['name'] = $product['ContentDescription']['name'];
		$content['ContentRelations'][$key]['description'] = $product['ContentDescription']['description'];
		$content['ContentRelations'][$key]['short_description'] = $product['ContentDescription']['short_description'];
	}

	$assignments = array('relations' => $content['ContentRelations']);

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